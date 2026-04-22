<?php

namespace App\Livewire;

use App\Actions\GenerateExampleWifiPass;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Attributes\Validate;
use Livewire\Component;

class WifiPassForm extends Component
{
    #[Validate('required|string|max:32')]
    public string $ssid = '';

    #[Validate('required|string|min:8|max:63')]
    public string $password = '';

    public function generate()
    {
        $this->validate();

        $key = 'new-pass:'.request()->ip();

        if (RateLimiter::tooManyAttempts($key, 30)) {
            abort(429, 'Too Many Requests');
        }

        RateLimiter::hit($key, 3600);

        $mobilePass = app(GenerateExampleWifiPass::class)->execute($this->ssid, $this->password);

        return redirect()->route('pass', ['mobilePass' => $mobilePass]);
    }

    public function render()
    {
        return view('livewire.wifi-pass-form');
    }
}
