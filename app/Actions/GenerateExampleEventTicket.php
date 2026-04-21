<?php

namespace App\Actions;

use Illuminate\Support\Str;
use Spatie\LaravelMobilePass\Builders\Apple\Entities\Barcode;
use Spatie\LaravelMobilePass\Builders\Apple\Entities\Colour;
use Spatie\LaravelMobilePass\Builders\Apple\EventTicketPassBuilder;
use Spatie\LaravelMobilePass\Enums\BarcodeType;
use Spatie\LaravelMobilePass\Enums\DateType;
use Spatie\LaravelMobilePass\Enums\TimeStyleType;
use Spatie\LaravelMobilePass\Models\MobilePass;

class GenerateExampleEventTicket
{
    public function execute(): MobilePass
    {
        $pass = EventTicketPassBuilder::make()
            ->setOrganisationName('Laracon US')
            ->setSerialNumber('pending')
            ->setDescription('Laracon US 2026 — Admission Ticket')
            ->setBackgroundColour(Colour::makeFromHex('#0A0A0A'))
            ->setForegroundColour(Colour::makeFromHex('#FFFFFF'))
            ->setLabelColour(Colour::makeFromHex('#FF2D20'))
            ->addHeaderField(
                'doors',
                '2026-07-28T08:30:00-04:00',
                dateStyle: DateType::Medium,
                timeStyle: TimeStyleType::Short,
            )
            ->addField('event', 'Laracon US 2026')
            ->addSecondaryField('attendee', 'Freek Van der Herten')
            ->addSecondaryField('venue', 'SoWa Power Station')
            ->addAuxiliaryField('location', 'Boston, MA')
            ->addAuxiliaryField(
                'seat',
                'General Admission',
                changeMessage: 'Your seat has changed to :value',
            )
            ->setLogoImage(
                x1Path: public_path('images/laracon-logo.png'),
                x2Path: public_path('images/laracon-logo@2x.png'),
                x3Path: public_path('images/laracon-logo@3x.png'),
            )
            ->setIconImage(
                x1Path: public_path('images/laracon-icon.png'),
                x2Path: public_path('images/laracon-icon@2x.png'),
                x3Path: public_path('images/laracon-icon@3x.png'),
            )
            ->save();

        $barcode = Barcode::make(BarcodeType::QR, Str::random(32))->toArray();

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
                    'x1Path' => public_path('images/laracon-thumbnail.png'),
                    'x2Path' => public_path('images/laracon-thumbnail@2x.png'),
                    'x3Path' => public_path('images/laracon-thumbnail@3x.png'),
                ],
                'background' => [
                    'x1Path' => public_path('images/laracon-background.png'),
                    'x2Path' => public_path('images/laracon-background@2x.png'),
                    'x3Path' => public_path('images/laracon-background@3x.png'),
                ],
            ],
        ]);

        return $pass;
    }
}
