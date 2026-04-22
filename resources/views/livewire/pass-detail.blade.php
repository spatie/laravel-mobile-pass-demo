<div wire:poll.5s class="space-y-6 sm:space-y-8" data-pass-id="{{ $mobilePass->id }}">
    {{-- Page header --}}
    <div class="space-y-1 px-1">
        <a href="/" class="inline-flex items-center gap-1 text-sm font-medium text-ink-muted hover:text-teal">
            <svg class="size-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M17 10a.75.75 0 0 1-.75.75H5.612l4.158 3.96a.75.75 0 1 1-1.04 1.08l-5.5-5.25a.75.75 0 0 1 0-1.08l5.5-5.25a.75.75 0 1 1 1.04 1.08L5.612 9.25H16.25A.75.75 0 0 1 17 10Z" clip-rule="evenodd" /></svg>
            Back to all passes
        </a>
        <h1 class="text-2xl font-semibold tracking-tight text-ink sm:text-3xl">{{ $passType->label() }}</h1>
    </div>

    {{-- State hero: the one thing to do right now --}}
    @if (! $installed)
        <x-card class="sm:p-10">
            <div class="grid gap-8 sm:grid-cols-[auto_1fr] sm:items-center sm:gap-10">
                {{-- QR --}}
                <div class="mx-auto w-full max-w-[20rem] sm:mx-0 sm:w-64">
                    <div class="overflow-hidden rounded-lg bg-surface-sunken ring-1 ring-parchment-strong/70">
                        <div class="aspect-square">
                            {!! $downloadQr !!}
                        </div>
                    </div>
                </div>
                {{-- Copy + secondary CTA --}}
                <div class="space-y-5">
                    <p class="inline-flex items-center gap-2 rounded-full bg-teal-soft px-3 py-1 text-xs font-medium tracking-wide text-teal uppercase">
                        <span class="relative flex size-2" aria-hidden="true">
                            <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-teal opacity-75"></span>
                            <span class="relative inline-flex size-2 rounded-full bg-teal"></span>
                        </span>
                        Waiting for install
                    </p>
                    <div class="space-y-3">
                        <h2 class="max-w-[22ch] text-2xl font-semibold tracking-tight text-balance text-ink sm:text-3xl">
                            Scan to install on your iPhone
                        </h2>
                        <p class="max-w-[56ch] text-base/7 text-pretty text-ink-muted">
                            Point your iPhone camera at the QR code. Tap the link that surfaces, then tap
                            <em class="text-ink">Add to Apple Wallet</em>. This page flips the moment Wallet registers the pass.
                        </p>
                    </div>
                    <div class="flex flex-wrap items-center gap-x-5 gap-y-3">
                        <x-button :href="$downloadUrl" variant="secondary">
                            <svg class="size-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 3a1 1 0 0 1 1 1v9.586l2.293-2.293a1 1 0 1 1 1.414 1.414l-4 4a1 1 0 0 1-1.414 0l-4-4a1 1 0 1 1 1.414-1.414L11 13.586V4a1 1 0 0 1 1-1zM4 16a1 1 0 0 1 1 1v2h14v-2a1 1 0 1 1 2 0v3a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1z"/></svg>
                            Download .pkpass
                        </x-button>
                        <span class="text-sm text-ink-muted">or scan with your iPhone camera</span>
                    </div>
                </div>
            </div>
        </x-card>
    @elseif (! $hasChanged)
        <x-card class="sm:p-10">
            <div class="grid gap-8 sm:grid-cols-[auto_1fr] sm:items-center sm:gap-10">
                {{-- Success indicator --}}
                <div class="mx-auto flex size-24 items-center justify-center rounded-full bg-teal-soft text-teal sm:mx-0 sm:size-28">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="size-14 sm:size-16" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                    </svg>
                </div>
                {{-- Copy + primary CTA --}}
                <div class="space-y-5">
                    <p class="inline-flex items-center gap-2 rounded-full bg-teal-soft px-3 py-1 text-xs font-medium tracking-wide text-teal uppercase">
                        Installed on your iPhone
                    </p>
                    <div class="space-y-3">
                        <h2 class="max-w-[22ch] text-2xl font-semibold tracking-tight text-balance text-ink sm:text-3xl">
                            Now push a live update
                        </h2>
                        <p class="max-w-[56ch] text-base/7 text-pretty text-ink-muted">
                            Your pass is registered. Trigger a change and the package dispatches
                            <code class="rounded bg-teal-soft px-1.5 py-0.5 text-[0.8125rem] text-teal">PushPassUpdateJob</code>,
                            which calls Apple’s push service. Wallet pulls the new version within a minute.
                        </p>
                    </div>
                    <x-button wire:click="simulateChange" variant="primary">
                        {{ $passType->simulateChangeLabel() }}
                        <svg class="size-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M3 10a.75.75 0 0 1 .75-.75h10.638L10.23 5.29a.75.75 0 1 1 1.04-1.08l5.5 5.25a.75.75 0 0 1 0 1.08l-5.5 5.25a.75.75 0 1 1-1.04-1.08l4.158-3.96H3.75A.75.75 0 0 1 3 10Z" clip-rule="evenodd" /></svg>
                    </x-button>
                </div>
            </div>
        </x-card>
    @else
        <x-card class="sm:p-10">
            <div class="grid gap-8 sm:grid-cols-[auto_1fr] sm:items-center sm:gap-10">
                {{-- Pushing indicator --}}
                <div class="mx-auto flex size-24 items-center justify-center rounded-full bg-teal-soft sm:mx-0 sm:size-28">
                    <span class="relative flex size-8" aria-hidden="true">
                        <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-teal opacity-75"></span>
                        <span class="relative inline-flex size-8 rounded-full bg-teal"></span>
                    </span>
                </div>
                <div class="space-y-5">
                    <p class="inline-flex items-center gap-2 rounded-full bg-teal-soft px-3 py-1 text-xs font-medium tracking-wide text-teal uppercase">
                        Update queued
                    </p>
                    <div class="space-y-3">
                        <h2 class="max-w-[22ch] text-2xl font-semibold tracking-tight text-balance text-ink sm:text-3xl">
                            Apple has been notified
                        </h2>
                        <p class="max-w-[56ch] text-base/7 text-pretty text-ink-muted">
                            Your iPhone should pull the latest version within a minute. Apple rate-limits updates to the same pass, so a second change in a 10-minute window may take longer.
                        </p>
                    </div>
                </div>
            </div>
        </x-card>
    @endif

    {{-- Supporting content --}}
    <div class="grid gap-6 lg:grid-cols-5 lg:gap-8">
        <x-card class="lg:col-span-2">
            <div class="space-y-3">
                <h2 class="text-lg font-semibold text-ink">About this pass</h2>
                <p class="text-base/7 text-pretty text-ink-muted">{{ $passType->description() }}</p>
            </div>
        </x-card>

        <x-card class="lg:col-span-3">
            <div class="space-y-4">
                <div class="space-y-1">
                    <h2 class="text-lg font-semibold text-ink">How it’s built</h2>
                    <p class="text-sm/6 text-ink-muted">A single fluent builder call generates the pass, signs it with your Apple Developer cert, and stores it in your database.</p>
                </div>
                <x-code>{{ $passType->builderShortName() }}::make()
    ->setOrganisationName(...)
    ->setSerialNumber($id)
    ->setDescription(...)
    ->addField('event', 'Laracon US 2026')
    ->setLogoImage(public_path('images/logo.png'))
    ->save();</x-code>
                <p class="text-sm/6 text-ink-muted">
                    See the source for this exact example in <a class="font-medium text-ink underline decoration-parchment-strong underline-offset-4 hover:text-teal hover:decoration-teal" href="https://github.com/spatie/laravel-mobile-pass-demo/blob/main/app/Actions/Generate{{ str_replace(' ', '', \Illuminate\Support\Str::title(\Illuminate\Support\Str::headline($passType->label()))) }}.php" target="_blank" rel="noopener">Generate{{ str_replace(' ', '', \Illuminate\Support\Str::title(\Illuminate\Support\Str::headline($passType->label()))) }}.php</a>.
                </p>
            </div>
        </x-card>
    </div>
</div>
