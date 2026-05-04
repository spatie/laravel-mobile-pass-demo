<?php

namespace App\Actions;

use Illuminate\Support\Str;
use Spatie\LaravelMobilePass\Builders\Apple\GenericPassBuilder;
use Spatie\LaravelMobilePass\Enums\BarcodeType;
use Spatie\LaravelMobilePass\Enums\DateType;
use Spatie\LaravelMobilePass\Models\MobilePass;

class GenerateExampleGenericPass
{
    public function execute(): MobilePass
    {
        $pass = GenericPassBuilder::make()
            ->setOrganizationName('Spatie Library')
            ->setDescription('Spatie Library — Member Card')
            ->setBackgroundColor('#F7F1E3')
            ->setForegroundColor('#1B1B18')
            ->setLabelColor('#4C5389')
            ->addHeaderField('tier', 'Lifetime', label: 'Membership')
            ->addField('member', 'Freek Van der Herten')
            ->addSecondaryField('member-no', 'SL-0001', label: 'Member №')
            ->addSecondaryField('branch', 'Antwerp Central')
            ->addAuxiliaryField(
                'valid-until',
                now()->addYears(99)->toIso8601String(),
                label: 'Valid until',
                dateStyle: DateType::Medium,
            )
            ->addAuxiliaryField(
                'books-out',
                '3',
                label: 'Books on loan',
                changeMessage: 'You now have :value books on loan',
            )
            ->setLogoImage(
                x1Path: public_path('images/spatie-library-logo.png'),
                x2Path: public_path('images/spatie-library-logo@2x.png'),
                x3Path: public_path('images/spatie-library-logo@3x.png'),
            )
            ->setIconImage(
                x1Path: public_path('images/spatie-library-icon.png'),
                x2Path: public_path('images/spatie-library-icon@2x.png'),
                x3Path: public_path('images/spatie-library-icon@3x.png'),
            )
            ->setBarcode(BarcodeType::Qr, Str::random(24))
            ->save();

        $pass->update([
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
