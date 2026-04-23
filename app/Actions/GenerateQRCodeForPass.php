<?php

namespace App\Actions;

use chillerlan\QRCode\Output\QRMarkupSVG;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use Spatie\LaravelMobilePass\Models\MobilePass;

class GenerateQRCodeForPass
{
    public function execute(MobilePass $mobilePass): string
    {
        $downloadUrl = route('pass.download', ['mobilePass' => $mobilePass]);

        return (new QRCode($this->options()))->render($downloadUrl);
    }

    protected function options(): QROptions
    {
        return new QROptions([
            'outputInterface' => QRMarkupSVG::class,
            'outputBase64' => false,
            'drawLightModules' => true,
            'svgUseFillAttributes' => false,
            'connectPaths' => true,
            'svgDefs' => <<<'SVG'
                <linearGradient id="rainbow" x1="1" y2="1">
                    <stop stop-color="#F53003" offset="0"/>
                    <stop stop-color="#6f5ba7" offset="1"/>
                </linearGradient>
                <style><![CDATA[
                    .dark{fill: url(#rainbow);}
                    .light{fill: transparent;}
                ]]></style>
                SVG,
        ]);
    }
}
