<?php

namespace App\Livewire;

use App\Actions\GenerateQRCodeForPass;
use App\Support\PassType;
use Livewire\Component;
use Spatie\LaravelMobilePass\Builders\Apple\AirlinePassBuilder;
use Spatie\LaravelMobilePass\Builders\Apple\CouponPassBuilder;
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
            EventTicketPassBuilder::name() => $this->updateField('seat', 'Row '.chr(rand(65, 80)).' · Seat '.rand(1, 120)),
            StoreCardPassBuilder::name() => $this->updateField('balance', rand(1, 10).' / 10'),
            GenericPassBuilder::name() => $this->updateField('books-out', (string) rand(0, 12)),
        };

        $this->hasChanged = true;
    }

    protected function expireCoupon(): void
    {
        $this->mobilePass
            ->builder()
            ->updateField('expiry', 'Expired')
            ->save();

        $this->mobilePass->expire();
    }

    protected function updateField(string $key, string $value): void
    {
        $this->mobilePass
            ->builder()
            ->updateField($key, $value)
            ->save();
    }

    public function passType(): PassType
    {
        return collect(PassType::cases())
            ->first(fn (PassType $type) => $type->builderName() === $this->mobilePass->builder_name);
    }

    public function render()
    {
        $this->installed = $this->mobilePass->registrations()->exists();

        return view('livewire.pass-detail')->with([
            'passType' => $this->passType(),
            'downloadQr' => app(GenerateQRCodeForPass::class)->execute($this->mobilePass),
            'downloadUrl' => route('pass.download', ['mobilePass' => $this->mobilePass]),
        ]);
    }
}
