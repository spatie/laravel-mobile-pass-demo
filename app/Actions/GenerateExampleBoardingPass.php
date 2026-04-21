<?php

namespace App\Actions;

use Illuminate\Support\Str;
use Spatie\LaravelMobilePass\Builders\Apple\AirlinePassBuilder;
use Spatie\LaravelMobilePass\Builders\Apple\Entities\Barcode;
use Spatie\LaravelMobilePass\Builders\Apple\Entities\Colour;
use Spatie\LaravelMobilePass\Builders\Apple\Entities\FieldContent;
use Spatie\LaravelMobilePass\Builders\Apple\Entities\Image;
use Spatie\LaravelMobilePass\Enums\BarcodeType;
use Spatie\LaravelMobilePass\Enums\DateType;
use Spatie\LaravelMobilePass\Enums\TimeStyleType;
use Spatie\LaravelMobilePass\Models\MobilePass;

class GenerateExampleBoardingPass
{
    public function execute(): MobilePass
    {
        $pass = AirlinePassBuilder::make()
            ->setOrganisationName('Artisan Airways')
            ->setDescription('Boarding Pass')
            ->setBackgroundColour(Colour::makeFromHex('#FFFFFF'))
            ->setLabelColour(Colour::makeFromHex('#F53003'))
            ->setHeaderFields(
                FieldContent::make('flight-no')
                    ->withLabel('Flight')
                    ->withValue('ART103'),
                FieldContent::make('seat')
                    ->withLabel('Seat')
                    ->withValue('66F')
                    ->showMessageWhenChanged('Your seat has changed to %@'),
            )
            ->setPrimaryFields(
                FieldContent::make('departure')
                    ->withLabel('Abu Dhabi International')
                    ->withValue('ABU'),
                FieldContent::make('destination')
                    ->withLabel('London Heathrow')
                    ->withValue('LHR'),
            )
            ->setSecondaryFields(
                FieldContent::make('name')
                    ->withLabel('Name')
                    ->withValue('Dan Johnson'),
                FieldContent::make('gate')
                    ->withLabel('Gate')
                    ->withValue('D64')
                    ->showMessageWhenChanged('Your gate has changed to %@'),
            )
            ->setAuxiliaryFields(
                FieldContent::make('boarding-time')
                    ->withLabel('Boarding Time')
                    ->withValue(now()->addHour()->toIso8601String())
                    ->usingDateType(DateType::Short)
                    ->usingTimeType(TimeStyleType::Short),
                FieldContent::make('class')
                    ->withLabel('Class')
                    ->withValue('Economy'),
            )
            ->setLogoImage(
                Image::make(
                    x1Path: public_path('images/artisan-airways-logo.png'),
                    x2Path: public_path('images/artisan-airways-logo@2x.png'),
                    x3Path: public_path('images/artisan-airways-logo@3x.png'),
                )
            )
            ->setIconImage(
                Image::make(
                    x1Path: public_path('images/artisan-airways-icon.png'),
                    x2Path: public_path('images/artisan-airways-icon@2x.png'),
                    x3Path: public_path('images/artisan-airways-icon@3x.png'),
                )
            )
            ->setFooterImage(
                Image::make(
                    x1Path: public_path('images/artisan-airways-footer.png'),
                    x2Path: public_path('images/artisan-airways-footer@2x.png'),
                    x3Path: public_path('images/artisan-airways-footer@3x.png'),
                )
            )
            ->save();

        $barcode = Barcode::make(BarcodeType::PDF417, Str::random(128))->toArray();

        $pass->update([
            'content' => [...$pass->content, 'barcode' => $barcode, 'barcodes' => [$barcode]],
        ]);

        return $pass;
    }
}
