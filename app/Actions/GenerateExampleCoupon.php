<?php

namespace App\Actions;

use Spatie\LaravelMobilePass\Builders\Apple\CouponPassBuilder;
use Spatie\LaravelMobilePass\Builders\Apple\Entities\Barcode;
use Spatie\LaravelMobilePass\Builders\Apple\Entities\Colour;
use Spatie\LaravelMobilePass\Builders\Apple\Entities\FieldContent;
use Spatie\LaravelMobilePass\Builders\Apple\Entities\Image;
use Spatie\LaravelMobilePass\Enums\BarcodeType;
use Spatie\LaravelMobilePass\Enums\DateType;
use Spatie\LaravelMobilePass\Models\MobilePass;

class GenerateExampleCoupon
{
    public function execute(): MobilePass
    {
        $pass = CouponPassBuilder::make()
            ->setOrganisationName('Laravel King')
            ->setDescription('Laravel Exclusive Coupon')
            ->setBackgroundColour(Colour::makeFromHex('#512314'))
            ->setLabelColour(Colour::makeFromHex('#F5EBDC'))
            ->setForegroundColour(Colour::makeFromHex('#FF8629'))
            ->setHeaderFields(
                FieldContent::make('expiry')
                    ->withLabel('Expires')
                    ->withValue(now()->addDay()->toIso8601String())
                    ->usingDateType(DateType::Short)
                    ->showDateAsRelative(),
            )
            ->setIconImage(
                Image::make(
                    x1Path: public_path('images/laravel-king-icon.png'),
                    x2Path: public_path('images/laravel-king-icon@2x.png'),
                    x3Path: public_path('images/laravel-king-icon@3x.png'),
                )
            )
            ->setLogoImage(
                Image::make(
                    x1Path: public_path('images/laravel-king-logo.png'),
                    x2Path: public_path('images/laravel-king-logo@2x.png'),
                    x3Path: public_path('images/laravel-king-logo@3x.png'),
                )
            )
            ->save();

        $barcode = Barcode::make(
            BarcodeType::QR,
            'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
        )->toArray();

        $pass->update([
            'content' => [...$pass->content, 'barcode' => $barcode, 'barcodes' => [$barcode]],
            'images' => [...$pass->images, 'strip' => [
                'x1Path' => public_path('images/laravel-king-strip.png'),
                'x2Path' => public_path('images/laravel-king-strip@2x.png'),
                'x3Path' => public_path('images/laravel-king-strip@3x.png'),
            ]],
        ]);

        return $pass;
    }
}
