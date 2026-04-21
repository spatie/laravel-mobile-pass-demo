@props(['type'])

@php /** @var \App\Support\PassType $type */ @endphp

<a
    href="{{ route('new-pass', ['type' => $type->value]) }}"
    class="group flex h-full flex-col gap-4 rounded bg-surface p-5 ring-1 ring-parchment-strong/60 shadow-sm transition-all hover:-translate-y-0.5 hover:ring-teal focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-teal sm:p-6"
>
    <div class="flex size-10 items-center justify-center rounded bg-teal-soft text-teal transition-colors group-hover:bg-teal group-hover:text-surface">
        <span class="size-5">{!! $type->icon() !!}</span>
    </div>

    <div class="flex flex-1 flex-col gap-1.5">
        <h3 class="text-base font-semibold text-ink">{{ $type->label() }}</h3>
        <p class="text-sm/6 text-pretty text-ink-muted">{{ $type->tagline() }}</p>
    </div>

    <div class="flex items-center gap-1.5 text-sm font-medium text-teal">
        Generate
        <svg class="size-4 transition-transform group-hover:translate-x-0.5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M3 10a.75.75 0 0 1 .75-.75h10.638L10.23 5.29a.75.75 0 1 1 1.04-1.08l5.5 5.25a.75.75 0 0 1 0 1.08l-5.5 5.25a.75.75 0 1 1-1.04-1.08l4.158-3.96H3.75A.75.75 0 0 1 3 10Z" clip-rule="evenodd" /></svg>
    </div>
</a>
