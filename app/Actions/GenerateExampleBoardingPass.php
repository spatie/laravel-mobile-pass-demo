<?php

namespace App\Actions;

use Illuminate\Support\Str;
use Spatie\LaravelMobilePass\Builders\Apple\AirlinePassBuilder;
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
            ->setSerialNumber('pending')
            ->setDescription('Boarding Pass')
            ->setBackgroundColour('#FFFFFF')
            ->setLabelColour('#F53003')
            ->addHeaderField('flight-no', 'ART103', label: 'Flight')
            ->addHeaderField('seat', '66F', changeMessage: 'Your seat has changed to :value')
            ->addField('departure', 'ABU', label: 'Abu Dhabi International')
            ->addField('destination', 'LHR', label: 'London Heathrow')
            ->addSecondaryField('name', 'Freek Van der Herten')
            ->addSecondaryField('gate', 'D64', changeMessage: 'Your gate has changed to :value')
            ->addAuxiliaryField(
                'boarding-time',
                now()->addHour()->toIso8601String(),
                label: 'Boarding Time',
                dateStyle: DateType::Short,
                timeStyle: TimeStyleType::Short,
            )
            ->addAuxiliaryField('class', 'Economy')
            ->setLogoImage(
                x1Path: public_path('images/artisan-airways-logo.png'),
                x2Path: public_path('images/artisan-airways-logo@2x.png'),
                x3Path: public_path('images/artisan-airways-logo@3x.png'),
            )
            ->setIconImage(
                x1Path: public_path('images/artisan-airways-icon.png'),
                x2Path: public_path('images/artisan-airways-icon@2x.png'),
                x3Path: public_path('images/artisan-airways-icon@3x.png'),
            )
            ->setFooterImage(
                x1Path: public_path('images/artisan-airways-footer.png'),
                x2Path: public_path('images/artisan-airways-footer@2x.png'),
                x3Path: public_path('images/artisan-airways-footer@3x.png'),
            )
            ->setBarcode(BarcodeType::Pdf417, Str::random(128))
            ->save();

        $pass->update([
            'content' => [
                ...$pass->content,
                'serialNumber' => $pass->id,
            ],
        ]);

        return $pass;
    }
}
