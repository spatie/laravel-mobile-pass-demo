@props(['heading'])

<x-card class="sm:p-10">
    <div class="grid gap-8 sm:grid-cols-[auto_1fr] sm:items-center sm:gap-10">
        {{ $visual }}

        <div class="space-y-5">
            <p class="inline-flex items-center gap-2 rounded-full bg-teal-soft px-3 py-1 text-xs font-medium tracking-wide text-teal uppercase">
                {{ $pill }}
            </p>
            <div class="space-y-3">
                <h2 class="max-w-[22ch] text-2xl font-semibold tracking-tight text-balance text-ink sm:text-3xl">
                    {{ $heading }}
                </h2>
                {{ $slot }}
            </div>
            @isset($actions)
                {{ $actions }}
            @endisset
        </div>
    </div>
</x-card>
