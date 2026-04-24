<?php

use App\Livewire\PassDetail;
use App\Support\PassType;
use Illuminate\Support\Facades\Route;
use Spatie\LaravelMobilePass\Models\MobilePass;

Route::get('/', fn () => view('welcome'));

Route::get('/new-pass/{type}', function (string $type) {
    $passType = PassType::tryFrom($type) ?? abort(404);

    $mobilePass = app($passType->actionClass())->execute();

    return redirect()->route('pass', ['mobilePass' => $mobilePass]);
})->name('new-pass');

Route::livewire('/pass/{mobilePass}', PassDetail::class)->name('pass');

Route::get('/pass/{mobilePass}/download', fn (MobilePass $mobilePass) => $mobilePass)
    ->name('pass.download');
