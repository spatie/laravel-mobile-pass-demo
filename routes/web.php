<?php

use App\Actions\GenerateExampleBoardingPass;
use App\Actions\GenerateExampleCoupon;
use App\Actions\GenerateExampleEventTicket;
use App\Actions\GenerateExampleGenericPass;
use App\Actions\GenerateExampleStoreCard;
use App\Livewire\PassDetail;
use App\Livewire\WifiPassForm;
use Illuminate\Support\Facades\Route;
use Spatie\LaravelMobilePass\Models\MobilePass;

Route::get('/', fn () => view('welcome'));

Route::middleware('throttle:new-pass')->group(function () {
    Route::get('/new-pass/{type}', function (string $type) {
        $action = match ($type) {
            'boarding-pass' => GenerateExampleBoardingPass::class,
            'coupon' => GenerateExampleCoupon::class,
            'event-ticket' => GenerateExampleEventTicket::class,
            'generic' => GenerateExampleGenericPass::class,
            'store-card' => GenerateExampleStoreCard::class,
            default => abort(404),
        };

        $mobilePass = app($action)->execute();

        return redirect()->route('pass', ['mobilePass' => $mobilePass]);
    })->name('new-pass');

    Route::get('/wifi-pass', WifiPassForm::class)->name('wifi-pass');
});

Route::get('/pass/{mobilePass}', PassDetail::class)->name('pass');

Route::get('/pass/{mobilePass}/download', fn (MobilePass $mobilePass) => $mobilePass)
    ->name('pass.download');
