<?php

namespace App\Actions;

use Spatie\LaravelMobilePass\Builders\Apple\GenericPassBuilder;
use Spatie\LaravelMobilePass\Models\MobilePass;

class GenerateExampleWifiPass
{
    public function execute(string $ssid, string $password): MobilePass
    {
        $pass = GenericPassBuilder::make()
            ->setOrganisationName('Wi-Fi share')
            ->setDescription("Wi-Fi credentials for {$ssid}")
            ->setDownloadName("wifi-pass-{$ssid}")
            ->setBackgroundColour('#0F172A')
            ->setForegroundColour('#F8FAFC')
            ->setLabelColour('#94A3B8')
            ->addHeaderField('type', 'WPA2/WPA3', label: 'Security')
            ->addField('ssid', $ssid, label: 'Network')
            ->addWifiNetwork($ssid, $password)
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
