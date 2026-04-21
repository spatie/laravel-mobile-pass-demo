<?php

namespace App\Livewire;

use App\Actions\GenerateQRCodeForPass;
use Livewire\Component;
use Spatie\LaravelMobilePass\Builders\Apple\AirlinePassBuilder;
use Spatie\LaravelMobilePass\Builders\Apple\CouponPassBuilder;
use Spatie\LaravelMobilePass\Builders\Apple\Entities\FieldContent;
use Spatie\LaravelMobilePass\Builders\Apple\EventTicketPassBuilder;
use Spatie\LaravelMobilePass\Builders\Apple\GenericPassBuilder;
use Spatie\LaravelMobilePass\Builders\Apple\StoreCardPassBuilder;
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
            CouponPassBuilder::name() => $this->expireCoupon(),
            AirlinePassBuilder::name() => $this->updateField('seat', rand(0, 10) * 10 .'F'),
            EventTicketPassBuilder::name() => $this->updateField('seat', (string) rand(1, 120)),
            StoreCardPassBuilder::name() => $this->updateField('balance', rand(1, 10).' / 10'),
            GenericPassBuilder::name() => $this->updateField('books-out', (string) rand(0, 12)),
        };

        $this->hasChanged = true;
    }

    protected function expireCoupon(): void
    {
        $this->mobilePass
            ->builder()
            ->updateField('expiry', fn (FieldContent $field) => $field->withValue('Expired'))
            ->save();

        $this->mobilePass->expire();
    }

    protected function updateField(string $key, string $value): void
    {
        $this->mobilePass
            ->builder()
            ->updateField($key, fn (FieldContent $field) => $field->withValue($value))
            ->save();
    }

    protected function simulatedChangeSummary(): string
    {
        return match ($this->mobilePass->builder_name) {
            CouponPassBuilder::name() => 'Simulate expired coupon',
            AirlinePassBuilder::name() => 'Simulate seat change',
            EventTicketPassBuilder::name() => 'Simulate seat reassignment',
            StoreCardPassBuilder::name() => 'Simulate points change',
            GenericPassBuilder::name() => 'Simulate books-on-loan change',
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
