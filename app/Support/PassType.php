<?php

namespace App\Support;

use App\Actions\GenerateExampleBoardingPass;
use App\Actions\GenerateExampleCoupon;
use App\Actions\GenerateExampleEventTicket;
use App\Actions\GenerateExampleGenericPass;
use App\Actions\GenerateExampleStoreCard;
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

    public static function forMobilePass(MobilePass $mobilePass): ?self
    {
        foreach (self::cases() as $type) {
            if ($type->builderName() === $mobilePass->builder_name) {
                return $type;
            }
        }

        return null;
    }

    public function label(): string
    {
        return match ($this) {
            self::BoardingPass => 'Boarding pass',
            self::Coupon => 'Coupon',
            self::EventTicket => 'Event ticket',
            self::StoreCard => 'Store card',
            self::Generic => 'Generic',
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
        };
    }

    public function eyebrow(): string
    {
        return match ($this) {
            self::BoardingPass => 'Airline',
            self::Coupon => 'Coupon',
            self::EventTicket => 'Event',
            self::StoreCard => 'Loyalty',
            self::Generic => 'Generic',
        };
    }

    public function headerBackground(): string
    {
        return match ($this) {
            self::BoardingPass => '#172A3D',
            self::Coupon => '#F53003',
            self::EventTicket => '#0A0A0A',
            self::StoreCard => '#197593',
            self::Generic => '#5B6B7D',
        };
    }

    public function simulateChangeLabel(): string
    {
        return match ($this) {
            self::BoardingPass => 'Change seat',
            self::Coupon => 'Mark coupon expired',
            self::EventTicket => 'Reassign seat',
            self::StoreCard => 'Award a point',
            self::Generic => 'Loan another book',
        };
    }

    public function builderClass(): string
    {
        return match ($this) {
            self::BoardingPass => AirlinePassBuilder::class,
            self::Coupon => CouponPassBuilder::class,
            self::EventTicket => EventTicketPassBuilder::class,
            self::StoreCard => StoreCardPassBuilder::class,
            self::Generic => GenericPassBuilder::class,
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
        };
    }

    public function actionShortName(): string
    {
        return class_basename($this->actionClass());
    }
}
