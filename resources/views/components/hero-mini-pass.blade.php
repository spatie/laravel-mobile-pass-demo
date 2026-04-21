@props([
    'eyebrow',
    'bg' => '#172A3D',
    'accent' => '#197593',
    'title',
    'label',
    'value',
])

<div {{ $attributes->merge(['class' => 'overflow-hidden rounded-lg bg-surface ring-1 ring-parchment-strong/60 shadow-md']) }}>
    <div class="flex items-center justify-between px-3 pt-3 pb-5" style="background: {{ $bg }};">
        <div class="flex items-center gap-1.5">
            <span class="block size-2 rounded-full" style="background: {{ $accent }};"></span>
            <span class="text-[9px] font-semibold tracking-[0.18em] text-white/95 uppercase">{{ $eyebrow }}</span>
        </div>
        <div class="flex items-center gap-0.5 text-white/60">
            <span class="block size-[3px] rounded-full bg-current"></span>
            <span class="block size-[3px] rounded-full bg-current"></span>
            <span class="block size-[3px] rounded-full bg-current"></span>
        </div>
    </div>
    <div class="relative h-0">
        <span class="absolute -top-1.5 -left-1.5 block size-3 rounded-full bg-surface ring-1 ring-parchment-strong/60"></span>
        <span class="absolute -top-1.5 -right-1.5 block size-3 rounded-full bg-surface ring-1 ring-parchment-strong/60"></span>
        <div class="mx-3 border-t border-dashed border-parchment-strong/80"></div>
    </div>
    <div class="space-y-2 p-3 pt-4">
        <div class="space-y-0.5">
            <p class="text-[9px] font-medium tracking-[0.12em] text-ink-muted uppercase">{{ $label }}</p>
            <p class="truncate text-xs font-semibold text-ink">{{ $value }}</p>
        </div>
        <p class="truncate text-sm font-semibold tracking-tight text-ink">{{ $title }}</p>
        <div class="flex items-end gap-px pt-1" aria-hidden="true">
            @foreach([5, 9, 4, 10, 6, 3, 8, 5, 9, 4, 7, 10, 3, 8, 5, 9, 4, 7] as $h)
                <span class="block w-px rounded-sm bg-ink/30" style="height: {{ $h * 1.5 }}px;"></span>
            @endforeach
        </div>
    </div>
</div>
