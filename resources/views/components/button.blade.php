@props([
    'variant' => 'primary',
    'as' => 'button',
    'href' => null,
])

@php
    $base = 'inline-flex items-center justify-center gap-2 rounded px-4 py-2.5 text-sm font-medium transition-colors focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-teal';
    $styles = match ($variant) {
        'primary' => 'bg-ink text-surface ring-1 ring-ink hover:bg-ink/90',
        'secondary' => 'bg-surface text-ink ring-1 ring-parchment-strong hover:bg-parchment',
        default => '',
    };
    $tag = $href ? 'a' : $as;
@endphp

<{{ $tag }}
    @if ($href) href="{{ $href }}" @endif
    {{ $attributes->merge(['class' => "$base $styles"]) }}
>
    {{ $slot }}
</{{ $tag }}>
