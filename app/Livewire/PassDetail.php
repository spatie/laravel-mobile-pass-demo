<?php

namespace App\Livewire;

use App\Actions\GenerateQRCodeForPass;
use App\Support\PassType;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Spatie\LaravelMobilePass\Builders\Apple\AirlinePassBuilder;
use Spatie\LaravelMobilePass\Builders\Apple\CouponPassBuilder;
use Spatie\LaravelMobilePass\Builders\Apple\EventTicketPassBuilder;
use Spatie\LaravelMobilePass\Builders\Apple\GenericPassBuilder;
use Spatie\LaravelMobilePass\Builders\Apple\StoreCardPassBuilder;
use Spatie\LaravelMobilePass\Models\MobilePass;

#[Layout('components.layouts.app')]
class PassDetail extends Component
{
    public MobilePass $mobilePass;

    public bool $installed = false;

    public bool $hasChanged = false;

    public function mount(MobilePass $mobilePass): void
    {
        $this->mobilePass = $mobilePass;
    }

    public function simulateChange(): void
    {
        match ($this->mobilePass->builder_name) {
            CouponPassBuilder::name() => $this->expireCoupon(),
            AirlinePassBuilder::name() => $this->mobilePass->updateField('seat', $this->randomSeatNumber()),
            EventTicketPassBuilder::name() => $this->mobilePass->updateField('seat', $this->randomSeatAssignment()),
            StoreCardPassBuilder::name() => $this->mobilePass->updateField('balance', $this->randomBalance()),
            GenericPassBuilder::name() => $this->mobilePass->updateField('books-out', (string) rand(0, 12)),
        };

        $this->hasChanged = true;
    }

    public function render(): View
    {
        $this->installed = $this->mobilePass->registrations()->exists();

        return view('livewire.pass-detail')->with([
            'passType' => PassType::forMobilePass($this->mobilePass),
            'downloadQr' => app(GenerateQRCodeForPass::class)->execute($this->mobilePass),
            'downloadUrl' => route('pass.download', ['mobilePass' => $this->mobilePass]),
        ]);
    }

    protected function expireCoupon(): void
    {
        $this->mobilePass->updateField('expiry', 'Expired');
        $this->mobilePass->expire();
    }

    protected function randomSeatNumber(): string
    {
        $row = rand(0, 10) * 10;

        return "{$row}F";
    }

    protected function randomSeatAssignment(): string
    {
        $row = chr(rand(65, 80));
        $seat = rand(1, 120);

        return "Row {$row} · Seat {$seat}";
    }

    protected function randomBalance(): string
    {
        $points = rand(1, 10);

        return "{$points} / 10";
    }
}
