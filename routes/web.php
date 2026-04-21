<?php

use App\Actions\GenerateExampleBoardingPass;
use App\Actions\GenerateExampleCoupon;
use App\Livewire\PassDetail;
use Illuminate\Support\Facades\Route;
use Spatie\LaravelMobilePass\Models\MobilePass;

Route::get('/', fn () => view('welcome'));

Route::get('/new-pass/{type}', function (string $type) {
    $action = match ($type) {
        'coupon' => GenerateExampleCoupon::class,
        'boarding-pass' => GenerateExampleBoardingPass::class,
        default => abort(404),
    };

    $mobilePass = app($action)->execute();

    return redirect()->route('pass', ['mobilePass' => $mobilePass]);
})->name('new-pass');

Route::get('/pass/{mobilePass}', PassDetail::class)->name('pass');

Route::get('/pass/{mobilePass}/download', fn (MobilePass $mobilePass) => $mobilePass)
    ->name('pass.download');
