@props(['type'])

@php
    /** @var \App\Support\PassType $type */
    [$headerBg, $eyebrow] = match ($type->value) {
        'boarding-pass' => ['#172A3D', 'Airline'],
        'coupon' => ['#F53003', 'Coupon'],
        'event-ticket' => ['#0A0A0A', 'Event'],
        'store-card' => ['#197593', 'Loyalty'],
        'generic' => ['#5B6B7D', 'Generic'],
    };
@endphp

<a
    href="{{ route('new-pass', ['type' => $type->value]) }}"
    class="group relative flex h-full flex-col overflow-hidden rounded-lg bg-surface shadow-sm ring-1 ring-parchment-strong/60 transition-all hover:-translate-y-1 hover:shadow-lg focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-teal"
>
    {{-- Colored header strip --}}
    <div class="relative flex items-start justify-between px-4 pt-4 pb-7" style="background: {{ $headerBg }};">
        <div class="flex items-center gap-2">
            <span class="flex size-7 items-center justify-center rounded bg-white/15 text-white">
                <span class="size-4">{!! $type->icon() !!}</span>
            </span>
            <span class="text-[10px] font-semibold tracking-[0.18em] text-white/95 uppercase">
                {{ $eyebrow }}
            </span>
        </div>
        <div class="flex items-center gap-0.5 text-white/60" aria-hidden="true">
            <span class="block size-1 rounded-full bg-current"></span>
            <span class="block size-1 rounded-full bg-current"></span>
            <span class="block size-1 rounded-full bg-current"></span>
        </div>
    </div>

    {{-- Perforation --}}
    <div class="relative h-0" aria-hidden="true">
        <span class="absolute -top-2 -left-2 block size-4 rounded-full bg-parchment"></span>
        <span class="absolute -top-2 -right-2 block size-4 rounded-full bg-parchment"></span>
        <div class="mx-4 border-t border-dashed border-parchment-strong/80"></div>
    </div>

    {{-- Body --}}
    <div class="flex flex-1 flex-col gap-4 p-4 pt-5">
        <div class="space-y-1.5">
            <h3 class="text-base font-semibold text-ink">{{ $type->label() }}</h3>
            <p class="text-sm/6 text-pretty text-ink-muted">{{ $type->tagline() }}</p>
        </div>
        <div class="mt-auto flex items-center justify-between pt-1">
            <div class="flex items-end gap-px" aria-hidden="true">
                @foreach([6, 10, 5, 11, 7, 4, 9, 6, 10, 5, 8, 11, 4, 9, 6] as $h)
                    <span class="block w-0.5 rounded-sm bg-ink/25" style="height: {{ $h * 1.8 }}px;"></span>
                @endforeach
            </div>
            <span class="flex items-center gap-1.5 text-sm font-medium text-teal">
                Generate
                <svg class="size-4 transition-transform group-hover:translate-x-0.5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M3 10a.75.75 0 0 1 .75-.75h10.638L10.23 5.29a.75.75 0 1 1 1.04-1.08l5.5 5.25a.75.75 0 0 1 0 1.08l-5.5 5.25a.75.75 0 1 1-1.04-1.08l4.158-3.96H3.75A.75.75 0 0 1 3 10Z" clip-rule="evenodd" /></svg>
            </span>
        </div>
    </div>
</a>
