@props(['padded' => true])

<div {{ $attributes->merge(['class' => 'bg-surface ring-1 ring-parchment-strong/60 rounded shadow-sm']) }}>
    <div @class(['p-6 sm:p-8' => $padded])>
        {{ $slot }}
    </div>
</div>
