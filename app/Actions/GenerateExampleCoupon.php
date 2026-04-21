<?php

namespace App\Actions;

use Spatie\LaravelMobilePass\Builders\Apple\CouponPassBuilder;
use Spatie\LaravelMobilePass\Enums\BarcodeType;
use Spatie\LaravelMobilePass\Enums\DateType;
use Spatie\LaravelMobilePass\Models\MobilePass;

class GenerateExampleCoupon
{
    public function execute(): MobilePass
    {
        $pass = CouponPassBuilder::make()
            ->setOrganisationName('Laravel King')
            ->setSerialNumber('pending')
            ->setDescription('Laravel Exclusive Coupon')
            ->setBackgroundColour('#512314')
            ->setLabelColour('#F5EBDC')
            ->setForegroundColour('#FF8629')
            ->addHeaderField(
                'expiry',
                now()->addDay()->toIso8601String(),
                label: 'Expires',
                dateStyle: DateType::Short,
                showDateAsRelative: true,
            )
            ->setIconImage(
                x1Path: public_path('images/laravel-king-icon.png'),
                x2Path: public_path('images/laravel-king-icon@2x.png'),
                x3Path: public_path('images/laravel-king-icon@3x.png'),
            )
            ->setLogoImage(
                x1Path: public_path('images/laravel-king-logo.png'),
                x2Path: public_path('images/laravel-king-logo@2x.png'),
                x3Path: public_path('images/laravel-king-logo@3x.png'),
            )
            ->setBarcode(BarcodeType::Qr, 'https://www.youtube.com/watch?v=dQw4w9WgXcQ')
            ->save();

        $pass->update([
            'content' => [
                ...$pass->content,
                'serialNumber' => $pass->id,
            ],
            'images' => [...$pass->images, 'strip' => [
                'x1Path' => public_path('images/laravel-king-strip.png'),
                'x2Path' => public_path('images/laravel-king-strip@2x.png'),
                'x3Path' => public_path('images/laravel-king-strip@3x.png'),
            ]],
        ]);

        return $pass;
    }
}
