<?php

use App\Support\Database\EnsureSqliteDatabaseExists;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

beforeEach(function () {
    $this->directory = storage_path('framework/testing/sqlite-'.uniqid());
    $this->databasePath = "{$this->directory}/database.sqlite";

    config()->set('database.connections.demo', [
        'driver' => 'sqlite',
        'database' => $this->databasePath,
        'prefix' => '',
        'foreign_key_constraints' => true,
        'create_when_missing' => true,
    ]);
});

afterEach(function () {
    DB::purge('demo');

    File::deleteDirectory($this->directory);
});

it('creates and migrates the sqlite database when it is missing', function () {
    app(EnsureSqliteDatabaseExists::class)('demo');

    expect(File::exists($this->databasePath))->toBeTrue()
        ->and(File::exists("{$this->databasePath}.migrating"))->toBeFalse()
        ->and(config('database.connections.demo.database'))->toBe($this->databasePath);

    foreach (['mobile_passes', 'apple_mobile_pass_devices', 'apple_mobile_pass_registrations', 'cache', 'sessions'] as $table) {
        expect(Schema::connection('demo')->hasTable($table))->toBeTrue();
    }

    expect(DB::connection('demo')->table('migrations')->count())->toBeGreaterThan(0);
});

it('leaves an existing database alone', function () {
    app(EnsureSqliteDatabaseExists::class)('demo');

    DB::connection('demo')->table('apple_mobile_pass_devices')->insert(['id' => 'device', 'push_token' => 'token']);

    app(EnsureSqliteDatabaseExists::class)('demo');

    expect(DB::connection('demo')->table('apple_mobile_pass_devices')->count())->toBe(1);
});

it('recreates the database after it was wiped', function () {
    app(EnsureSqliteDatabaseExists::class)('demo');

    DB::purge('demo');
    File::delete($this->databasePath);

    app(EnsureSqliteDatabaseExists::class)('demo');

    expect(Schema::connection('demo')->hasTable('mobile_passes'))->toBeTrue();
});

it('does nothing when creating the database is not enabled', function () {
    config()->set('database.connections.demo.create_when_missing', false);

    app(EnsureSqliteDatabaseExists::class)('demo');

    expect(File::exists($this->databasePath))->toBeFalse();
});

it('does nothing for an in memory database or another driver', function (array $connection) {
    config()->set('database.connections.demo', array_merge(config('database.connections.demo'), $connection));

    app(EnsureSqliteDatabaseExists::class)('demo');

    expect(File::exists($this->databasePath))->toBeFalse();
})->with([
    'in memory' => [['database' => ':memory:']],
    'mysql' => [['driver' => 'mysql']],
]);
