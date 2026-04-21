<?php

namespace App\Actions;

use Illuminate\Support\Str;
use Spatie\LaravelMobilePass\Builders\Apple\Entities\Barcode;
use Spatie\LaravelMobilePass\Builders\Apple\StoreCardPassBuilder;
use Spatie\LaravelMobilePass\Enums\BarcodeType;
use Spatie\LaravelMobilePass\Models\MobilePass;

class GenerateExampleStoreCard
{
    public function execute(): MobilePass
    {
        $pass = StoreCardPassBuilder::make()
            ->setOrganisationName('Brew & Code')
            ->setSerialNumber('pending')
            ->setDescription('Brew & Code loyalty card')
            ->setBackgroundColour('#3B2417')
            ->setForegroundColour('#F7E6C4')
            ->setLabelColour('#E2C299')
            ->addHeaderField('member-since', 'Since 2024', label: 'Member')
            ->addField('balance', '7 / 10', label: 'Points', changeMessage: 'You now have :value points')
            ->addSecondaryField('member', 'Freek Van der Herten')
            ->addSecondaryField('tier', 'Roaster')
            ->addAuxiliaryField('next-reward', 'Free flat white', label: 'Next reward')
            ->setLogoImage(
                x1Path: public_path('images/brew-code-logo.png'),
                x2Path: public_path('images/brew-code-logo@2x.png'),
                x3Path: public_path('images/brew-code-logo@3x.png'),
            )
            ->setIconImage(
                x1Path: public_path('images/brew-code-icon.png'),
                x2Path: public_path('images/brew-code-icon@2x.png'),
                x3Path: public_path('images/brew-code-icon@3x.png'),
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
                'strip' => [
                    'x1Path' => public_path('images/brew-code-strip.png'),
                    'x2Path' => public_path('images/brew-code-strip@2x.png'),
                    'x3Path' => public_path('images/brew-code-strip@3x.png'),
                ],
            ],
        ]);

        return $pass;
    }
}
