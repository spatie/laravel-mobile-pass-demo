<?php

use App\Actions\GenerateExampleGenericPass;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Livewire\Mechanisms\HandleRequests\EndpointResolver;
use Spatie\LaravelMobilePass\Models\MobilePass;

uses(RefreshDatabase::class);

beforeEach(function () {
    config()->set('mobile-pass.apple.type_identifier', 'pass.be.spatie.demo');
    config()->set('mobile-pass.apple.team_identifier', 'TEAM123456');

    $this->mobilePass = app(GenerateExampleGenericPass::class)->execute();

    $this->snapshot = html_entity_decode(
        str($this->get(route('pass', ['mobilePass' => $this->mobilePass]))->getContent())
            ->match('/wire:snapshot="([^"]+)"/')
            ->toString()
    );
});

function pollPassDetail(string $snapshot): TestResponse
{
    return test()
        ->withHeaders(['X-Livewire' => '1'])
        ->postJson(EndpointResolver::updatePath(), [
            'components' => [
                ['snapshot' => $snapshot, 'updates' => [], 'calls' => []],
            ],
        ]);
}

it('keeps polling a pass that still exists', function () {
    pollPassDetail($this->snapshot)->assertSuccessful();
});

it('responds with page expired when a polled pass no longer exists', function () {
    MobilePass::query()->delete();

    pollPassDetail($this->snapshot)->assertStatus(419);
});

it('still responds with not found when visiting a pass that no longer exists', function () {
    MobilePass::query()->delete();

    $this->get(route('pass', ['mobilePass' => $this->mobilePass]))->assertNotFound();
});
