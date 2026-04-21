<?php

namespace App\Actions;

use Illuminate\Support\Str;
use Spatie\LaravelMobilePass\Builders\Apple\Entities\Barcode;
use Spatie\LaravelMobilePass\Builders\Apple\Entities\Colour;
use Spatie\LaravelMobilePass\Builders\Apple\Entities\FieldContent;
use Spatie\LaravelMobilePass\Builders\Apple\Entities\Image;
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
            ->setHeaderFields(
                FieldContent::make('doors')
                    ->withLabel('Doors')
                    ->withValue('2026-07-28T08:30:00-04:00')
                    ->usingDateType(DateType::Medium)
                    ->usingTimeType(TimeStyleType::Short),
            )
            ->setPrimaryFields(
                FieldContent::make('event')
                    ->withLabel('Event')
                    ->withValue('Laracon US 2026'),
            )
            ->setSecondaryFields(
                FieldContent::make('attendee')
                    ->withLabel('Attendee')
                    ->withValue('Freek Van der Herten'),
                FieldContent::make('venue')
                    ->withLabel('Venue')
                    ->withValue('SoWa Power Station'),
            )
            ->setAuxiliaryFields(
                FieldContent::make('location')
                    ->withLabel('Location')
                    ->withValue('Boston, MA'),
                FieldContent::make('seat')
                    ->withLabel('Seat')
                    ->withValue('General Admission')
                    ->showMessageWhenChanged('Your seat has changed to %@'),
            )
            ->setLogoImage(
                Image::make(
                    x1Path: public_path('images/laracon-logo.png'),
                    x2Path: public_path('images/laracon-logo@2x.png'),
                    x3Path: public_path('images/laracon-logo@3x.png'),
                )
            )
            ->setIconImage(
                Image::make(
                    x1Path: public_path('images/laracon-icon.png'),
                    x2Path: public_path('images/laracon-icon@2x.png'),
                    x3Path: public_path('images/laracon-icon@3x.png'),
                )
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
