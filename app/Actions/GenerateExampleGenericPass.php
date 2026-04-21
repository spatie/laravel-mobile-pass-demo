<?php

namespace App\Actions;

use Illuminate\Support\Str;
use Spatie\LaravelMobilePass\Builders\Apple\Entities\Barcode;
use Spatie\LaravelMobilePass\Builders\Apple\Entities\Colour;
use Spatie\LaravelMobilePass\Builders\Apple\Entities\FieldContent;
use Spatie\LaravelMobilePass\Builders\Apple\Entities\Image;
use Spatie\LaravelMobilePass\Builders\Apple\GenericPassBuilder;
use Spatie\LaravelMobilePass\Enums\BarcodeType;
use Spatie\LaravelMobilePass\Enums\DateType;
use Spatie\LaravelMobilePass\Models\MobilePass;

class GenerateExampleGenericPass
{
    public function execute(): MobilePass
    {
        $pass = GenericPassBuilder::make()
            ->setOrganisationName('Spatie Library')
            ->setSerialNumber('pending')
            ->setDescription('Spatie Library — Member Card')
            ->setBackgroundColour(Colour::makeFromHex('#F7F1E3'))
            ->setForegroundColour(Colour::makeFromHex('#1B1B18'))
            ->setLabelColour(Colour::makeFromHex('#4C5389'))
            ->setHeaderFields(
                FieldContent::make('tier')
                    ->withLabel('Membership')
                    ->withValue('Lifetime'),
            )
            ->setPrimaryFields(
                FieldContent::make('member')
                    ->withLabel('Member')
                    ->withValue('Freek Van der Herten'),
            )
            ->setSecondaryFields(
                FieldContent::make('member-no')
                    ->withLabel('Member №')
                    ->withValue('SL-0001'),
                FieldContent::make('branch')
                    ->withLabel('Branch')
                    ->withValue('Antwerp Central'),
            )
            ->setAuxiliaryFields(
                FieldContent::make('valid-until')
                    ->withLabel('Valid until')
                    ->withValue(now()->addYears(99)->toIso8601String())
                    ->usingDateType(DateType::Medium),
                FieldContent::make('books-out')
                    ->withLabel('Books on loan')
                    ->withValue('3')
                    ->showMessageWhenChanged('You now have %@ books on loan'),
            )
            ->setLogoImage(
                Image::make(
                    x1Path: public_path('images/spatie-library-logo.png'),
                    x2Path: public_path('images/spatie-library-logo@2x.png'),
                    x3Path: public_path('images/spatie-library-logo@3x.png'),
                )
            )
            ->setIconImage(
                Image::make(
                    x1Path: public_path('images/spatie-library-icon.png'),
                    x2Path: public_path('images/spatie-library-icon@2x.png'),
                    x3Path: public_path('images/spatie-library-icon@3x.png'),
                )
            )
            ->save();

        $barcode = Barcode::make(BarcodeType::QR, Str::random(24))->toArray();

        $pass->update([
            'content' => [
                ...$pass->content,
                'serialNumber' => $pass->id,
                'barcode' => $barcode,
                'barcodes' => [$barcode],
            ],
            'images' => [
                ...$pass->images,
                'thumbnail' => [
                    'x1Path' => public_path('images/spatie-library-thumbnail.png'),
                    'x2Path' => public_path('images/spatie-library-thumbnail@2x.png'),
                    'x3Path' => public_path('images/spatie-library-thumbnail@3x.png'),
                ],
            ],
        ]);

        return $pass;
    }
}
