<?php

namespace App\Livewire;

use App\Actions\GenerateQRCodeForPass;
use Livewire\Component;
use Spatie\LaravelMobilePass\Builders\Apple\AirlinePassBuilder;
use Spatie\LaravelMobilePass\Builders\Apple\CouponPassBuilder;
use Spatie\LaravelMobilePass\Builders\Apple\Entities\FieldContent;
use Spatie\LaravelMobilePass\Models\MobilePass;

class PassDetail extends Component
{
    public MobilePass $mobilePass;

    public bool $installed = false;

    public bool $hasChanged = false;

    public function mount(MobilePass $mobilePass): void
    {
        $this->mobilePass = $mobilePass;
        $this->installed = $mobilePass->registrations()->exists();
    }

    public function simulateChange(): void
    {
        match ($this->mobilePass->builder_name) {
            CouponPassBuilder::name() => $this->simulateExpiredCoupon(),
            AirlinePassBuilder::name() => $this->simulateSeatChange(),
        };

        $this->hasChanged = true;
    }

    protected function simulateExpiredCoupon(): void
    {
        $this->mobilePass
            ->builder()
            ->updateField('expiry', fn (FieldContent $field) => $field->withValue('Expired'))
            ->save();

        $this->mobilePass->expire();
    }

    protected function simulateSeatChange(): void
    {
        $newSeat = rand(0, 10) * 10 .'F';

        $this->mobilePass
            ->builder()
            ->updateField('seat', fn (FieldContent $field) => $field->withValue($newSeat))
            ->save();
    }

    protected function simulatedChangeSummary(): string
    {
        return match ($this->mobilePass->builder_name) {
            CouponPassBuilder::name() => 'Simulate expired coupon',
            AirlinePassBuilder::name() => 'Simulate seat change',
        };
    }

    public function render()
    {
        $this->installed = $this->mobilePass->registrations()->exists();

        return view('livewire.pass-detail')->with([
            'downloadQr' => app(GenerateQRCodeForPass::class)->execute($this->mobilePass),
            'downloadUrl' => route('pass.download', ['mobilePass' => $this->mobilePass]),
            'changeSummary' => $this->simulatedChangeSummary(),
        ]);
    }
}
