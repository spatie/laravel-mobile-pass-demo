<?php

namespace App\Support;

use App\Actions\GenerateExampleBoardingPass;
use App\Actions\GenerateExampleCoupon;
use App\Actions\GenerateExampleEventTicket;
use App\Actions\GenerateExampleGenericPass;
use App\Actions\GenerateExampleStoreCard;
use App\Actions\GenerateExampleWifiPass;
use Spatie\LaravelMobilePass\Builders\Apple\AirlinePassBuilder;
use Spatie\LaravelMobilePass\Builders\Apple\CouponPassBuilder;
use Spatie\LaravelMobilePass\Builders\Apple\EventTicketPassBuilder;
use Spatie\LaravelMobilePass\Builders\Apple\GenericPassBuilder;
use Spatie\LaravelMobilePass\Builders\Apple\StoreCardPassBuilder;
use Spatie\LaravelMobilePass\Models\MobilePass;

enum PassType: string
{
    case BoardingPass = 'boarding-pass';
    case Coupon = 'coupon';
    case EventTicket = 'event-ticket';
    case StoreCard = 'store-card';
    case Generic = 'generic';
    case WifiPass = 'wifi-pass';

    public function label(): string
    {
        return match ($this) {
            self::BoardingPass => 'Boarding pass',
            self::Coupon => 'Coupon',
            self::EventTicket => 'Event ticket',
            self::StoreCard => 'Store card',
            self::Generic => 'Generic',
            self::WifiPass => 'Wi-Fi pass',
        };
    }

    public function tagline(): string
    {
        return match ($this) {
            self::BoardingPass => 'For flights, trains, and ferries.',
            self::Coupon => 'For time-limited offers and promotions.',
            self::EventTicket => 'For concerts, conferences, and sporting events.',
            self::StoreCard => 'For loyalty cards, gift cards, and store credit.',
            self::Generic => 'For membership cards, IDs, and anything else.',
            self::WifiPass => 'Share a Wi-Fi network through a QR-coded pass.',
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::BoardingPass => 'Boarding passes use the airline layout, with prominent departure and destination codes, a footer image strip, and PDF417 or Aztec barcodes that gate scanners can read at speed.',
            self::Coupon => 'Coupons feature a top strip image and large header field, perfect for showing brand artwork above an offer. They can be voided when redeemed, which greys them out in the user’s wallet.',
            self::EventTicket => 'Event tickets can show a full-bleed background image with a small thumbnail, giving the pass a poster-like feel. Headers usually carry the event date and time.',
            self::StoreCard => 'Store cards highlight a primary balance value and let you push updates as the balance changes. The strip image is ideal for branded artwork.',
            self::Generic => 'Generic passes are the fallback layout, useful for membership cards, library cards, and anything that doesn’t fit the other pass types.',
            self::WifiPass => 'A generic pass with a Wi-Fi QR code as its barcode. Scan it with any iPhone or Android camera and the OS offers to join the network. Handy to pin in Wallet for guest networks at home, in an office, or a co-working space.',
        };
    }

    public function builderClass(): string
    {
        return match ($this) {
            self::BoardingPass => AirlinePassBuilder::class,
            self::Coupon => CouponPassBuilder::class,
            self::EventTicket => EventTicketPassBuilder::class,
            self::StoreCard => StoreCardPassBuilder::class,
            self::Generic, self::WifiPass => GenericPassBuilder::class,
        };
    }

    public function builderShortName(): string
    {
        return class_basename($this->builderClass());
    }

    public function builderName(): string
    {
        return $this->builderClass()::name();
    }

    public function actionClass(): string
    {
        return match ($this) {
            self::BoardingPass => GenerateExampleBoardingPass::class,
            self::Coupon => GenerateExampleCoupon::class,
            self::EventTicket => GenerateExampleEventTicket::class,
            self::StoreCard => GenerateExampleStoreCard::class,
            self::Generic => GenerateExampleGenericPass::class,
            self::WifiPass => GenerateExampleWifiPass::class,
        };
    }

    public function actionShortName(): string
    {
        return class_basename($this->actionClass());
    }

    public function simulateChangeLabel(): string
    {
        return match ($this) {
            self::BoardingPass => 'Change seat',
            self::Coupon => 'Mark coupon expired',
            self::EventTicket => 'Reassign seat',
            self::StoreCard => 'Award a point',
            self::Generic => 'Loan another book',
            self::WifiPass => 'Rotate the password',
        };
    }

    public static function forMobilePass(MobilePass $mobilePass): ?self
    {
        if (str_starts_with($mobilePass->download_name ?? '', 'wifi-pass')) {
            return self::WifiPass;
        }

        return collect(self::cases())
            ->first(fn (self $type) => $type !== self::WifiPass && $type->builderName() === $mobilePass->builder_name);
    }

    public function icon(): string
    {
        return match ($this) {
            self::BoardingPass => '<svg viewBox="0 0 576 512" xmlns="http://www.w3.org/2000/svg" fill="currentColor"><path d="M482.3 192c34.2 0 93.7 29 93.7 64c0 36-59.5 64-93.7 64l-116.6 0L265.2 495.9c-5.7 10-16.3 16.1-27.8 16.1l-56.2 0c-10.6 0-18.3-10.2-15.4-20.4l49-171.6L112 320 68.8 377.6c-3 4-7.8 6.4-12.8 6.4l-42 0c-7.8 0-14-6.3-14-14c0-1.3 .2-2.6 .5-3.9L32 256 .5 145.9c-.4-1.3-.5-2.6-.5-3.9c0-7.8 6.3-14 14-14l42 0c5 0 9.8 2.4 12.8 6.4L112 192l102.9 0-49-171.6C162.9 10.2 170.6 0 181.2 0l56.2 0c11.5 0 22.1 6.2 27.8 16.1L365.7 192l116.6 0z"/></svg>',
            self::Coupon => '<svg viewBox="0 0 384 512" xmlns="http://www.w3.org/2000/svg" fill="currentColor"><path d="M14 2.2C22.5-1.7 32.5-.3 39.6 5.8L80 40.4 120.4 5.8c9-7.7 22.3-7.7 31.2 0L192 40.4 232.4 5.8c9-7.7 22.3-7.7 31.2 0L304 40.4 344.4 5.8c7.1-6.1 17.1-7.5 25.6-3.6s14 12.4 14 21.8l0 464c0 9.4-5.5 17.9-14 21.8s-18.5 2.5-25.6-3.6L304 471.6l-40.4 34.6c-9 7.7-22.3 7.7-31.2 0L192 471.6l-40.4 34.6c-9 7.7-22.3 7.7-31.2 0L80 471.6 39.6 506.2c-7.1 6.1-17.1 7.5-25.6 3.6S0 497.4 0 488L0 24C0 14.6 5.5 6.1 14 2.2zM96 144c-8.8 0-16 7.2-16 16s7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 144zM80 352c0 8.8 7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 336c-8.8 0-16 7.2-16 16zM96 240c-8.8 0-16 7.2-16 16s7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 240z"/></svg>',
            self::EventTicket => '<svg viewBox="0 0 576 512" xmlns="http://www.w3.org/2000/svg" fill="currentColor"><path d="M64 64C28.7 64 0 92.7 0 128L0 192c0 8.8 7.4 15.7 15.7 18.6C34.5 217.1 48 235 48 256s-13.5 38.9-32.3 45.4C7.4 304.3 0 311.2 0 320l0 64c0 35.3 28.7 64 64 64l448 0c35.3 0 64-28.7 64-64l0-64c0-8.8-7.4-15.7-15.7-18.6C541.5 294.9 528 277 528 256s13.5-38.9 32.3-45.4c8.3-2.9 15.7-9.8 15.7-18.6l0-64c0-35.3-28.7-64-64-64L64 64zm64 112l0 160c0 8.8 7.2 16 16 16l288 0c8.8 0 16-7.2 16-16l0-160c0-8.8-7.2-16-16-16l-288 0c-8.8 0-16 7.2-16 16zM96 160c0-17.7 14.3-32 32-32l320 0c17.7 0 32 14.3 32 32l0 192c0 17.7-14.3 32-32 32l-320 0c-17.7 0-32-14.3-32-32l0-192z"/></svg>',
            self::StoreCard => '<svg viewBox="0 0 576 512" xmlns="http://www.w3.org/2000/svg" fill="currentColor"><path d="M64 32C28.7 32 0 60.7 0 96L0 416c0 35.3 28.7 64 64 64l448 0c35.3 0 64-28.7 64-64l0-320c0-35.3-28.7-64-64-64L64 32zm48 256l160 0c8.8 0 16 7.2 16 16s-7.2 16-16 16l-160 0c-8.8 0-16-7.2-16-16s7.2-16 16-16zm192-112c0 8.8-7.2 16-16 16l-176 0c-8.8 0-16-7.2-16-16s7.2-16 16-16l176 0c8.8 0 16 7.2 16 16zM0 128l576 0 0 64L0 192l0-64z"/></svg>',
            self::Generic => '<svg viewBox="0 0 448 512" xmlns="http://www.w3.org/2000/svg" fill="currentColor"><path d="M96 0C43 0 0 43 0 96L0 416c0 53 43 96 96 96l288 0 32 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l0-64c17.7 0 32-14.3 32-32l0-320c0-17.7-14.3-32-32-32L384 0 96 0zm0 384l256 0 0 64L96 448c-17.7 0-32-14.3-32-32s14.3-32 32-32zm32-240c0-8.8 7.2-16 16-16l192 0c8.8 0 16 7.2 16 16s-7.2 16-16 16l-192 0c-8.8 0-16-7.2-16-16zm16 48l192 0c8.8 0 16 7.2 16 16s-7.2 16-16 16l-192 0c-8.8 0-16-7.2-16-16s7.2-16 16-16z"/></svg>',
            self::WifiPass => '<svg viewBox="0 0 640 512" xmlns="http://www.w3.org/2000/svg" fill="currentColor"><path d="M54.2 202.9C123.2 136.7 216.8 96 320 96s196.8 40.7 265.8 106.9c12.8 12.2 33 11.8 45.2-.9s11.8-33-.9-45.2C549.7 79.5 440.4 32 320 32S90.3 79.5 9.8 156.7C-2.9 169-3.3 189.2 8.9 202s32.5 13.2 45.2 .9zM320 256c56.8 0 108.6 21.1 148.2 56c13.3 11.7 33.5 10.4 45.2-2.8s10.4-33.5-2.8-45.2C459.8 219.2 393 192 320 192s-139.8 27.2-190.5 72c-13.3 11.7-14.5 31.9-2.8 45.2s31.9 14.5 45.2 2.8c39.5-34.9 91.3-56 148.2-56zm64 160c0-35.3-28.7-64-64-64s-64 28.7-64 64s28.7 64 64 64s64-28.7 64-64z"/></svg>',
        };
    }
}
