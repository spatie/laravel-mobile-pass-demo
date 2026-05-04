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
            ->setOrganizationName('Laravel King')
            ->setDescription('Laravel Exclusive Coupon')
            ->setBackgroundColor('#512314')
            ->setLabelColor('#F5EBDC')
            ->setForegroundColor('#FF8629')
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
            'images' => [
                ...$pass->images,
                'strip' => [
                    'x1Path' => public_path('images/laravel-king-strip.png'),
                    'x2Path' => public_path('images/laravel-king-strip@2x.png'),
                    'x3Path' => public_path('images/laravel-king-strip@3x.png'),
                ],
            ],
        ]);

        return $pass;
    }
}
