<?php

namespace App\Actions;

use Spatie\LaravelMobilePass\Builders\Apple\CouponPassBuilder;
use Spatie\LaravelMobilePass\Builders\Apple\Entities\Barcode;
use Spatie\LaravelMobilePass\Builders\Apple\Entities\Colour;
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
            ->setBackgroundColour(Colour::makeFromHex('#512314'))
            ->setLabelColour(Colour::makeFromHex('#F5EBDC'))
            ->setForegroundColour(Colour::makeFromHex('#FF8629'))
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
            ->save();

        $barcode = Barcode::make(
            BarcodeType::QR,
            'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
        )->toArray();

        $pass->update([
            'content' => [
                ...$pass->content,
                'serialNumber' => $pass->id,
                'barcode' => $barcode,
                'barcodes' => [$barcode],
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
