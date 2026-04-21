<div wire:poll.5s class="space-y-6 sm:space-y-8" data-pass-id="{{ $mobilePass->id }}">
    {{-- Page header --}}
    <div class="flex flex-col gap-4 px-1 sm:flex-row sm:items-center sm:justify-between">
        <div class="space-y-1">
            <a href="/" class="inline-flex items-center gap-1 text-sm font-medium text-ink-muted hover:text-teal">
                <svg class="size-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M17 10a.75.75 0 0 1-.75.75H5.612l4.158 3.96a.75.75 0 1 1-1.04 1.08l-5.5-5.25a.75.75 0 0 1 0-1.08l5.5-5.25a.75.75 0 1 1 1.04 1.08L5.612 9.25H16.25A.75.75 0 0 1 17 10Z" clip-rule="evenodd" /></svg>
                Back to all passes
            </a>
            <h1 class="text-2xl font-semibold tracking-tight text-ink sm:text-3xl">{{ $passType->label() }}</h1>
        </div>
        <x-status-pill :installed="$installed" />
    </div>

    <div class="grid gap-6 sm:gap-8 lg:grid-cols-5">
        {{-- Left: about + code --}}
        <div class="space-y-6 sm:space-y-8 lg:col-span-3">
            <x-card>
                <div class="space-y-3">
                    <h2 class="text-lg font-semibold text-ink">About this pass</h2>
                    <p class="max-w-[64ch] text-base/7 text-pretty text-ink-muted">{{ $passType->description() }}</p>
                </div>
            </x-card>

            <x-card>
                <div class="space-y-4">
                    <div>
                        <h2 class="text-lg font-semibold text-ink">How it’s built</h2>
                        <p class="text-sm/6 text-ink-muted">A single fluent builder call generates the pass, signs it with your Apple Developer cert, and stores it in your database.</p>
                    </div>
                    <x-code>{{ $passType->builderShortName() }}::make()
    ->setOrganisationName(...)
    ->setSerialNumber($id)
    ->setDescription(...)
    ->addPrimaryField('event', 'Laracon US 2026')
    ->setLogoImage(Image::make(...))
    ->save();</x-code>
                    <p class="text-sm/6 text-ink-muted">
                        See the source for this exact example in <a class="font-medium text-ink underline decoration-parchment-strong underline-offset-4 hover:text-teal hover:decoration-teal" href="https://github.com/spatie/laravel-mobile-pass-demo/blob/main/app/Actions/Generate{{ str_replace(' ', '', \Illuminate\Support\Str::title(\Illuminate\Support\Str::headline($passType->label()))) }}.php" target="_blank" rel="noopener">Generate{{ str_replace(' ', '', \Illuminate\Support\Str::title(\Illuminate\Support\Str::headline($passType->label()))) }}.php</a>.
                    </p>
                </div>
            </x-card>

            @if (! $installed)
                <x-card>
                    <div class="space-y-3">
                        <h2 class="text-lg font-semibold text-ink">Try it on your iPhone</h2>
                        <ol class="space-y-2 pl-5 text-base/7 text-ink-muted [list-style-type:decimal]">
                            <li>Point your iPhone’s camera at the QR code on the right.</li>
                            <li>Tap the link the camera surfaces, then tap <em class="text-ink">Add to Apple Wallet</em>.</li>
                            <li>Come back to this page. The status will flip to <strong class="text-ink">Installed</strong> automatically.</li>
                        </ol>
                    </div>
                </x-card>
            @elseif (! $hasChanged)
                <x-card>
                    <div class="space-y-4">
                        <div>
                            <h2 class="text-lg font-semibold text-ink">Push an update</h2>
                            <p class="max-w-[64ch] text-sm/6 text-pretty text-ink-muted">
                                Your pass is registered. Trigger a change and the package will dispatch <code class="rounded bg-teal-soft px-1.5 py-0.5 text-[0.8125rem] text-teal">PushPassUpdateJob</code>, which calls Apple’s push service. Wallet on your device will pull the new version within a minute.
                            </p>
                        </div>
                        <x-button wire:click="simulateChange" variant="primary">
                            {{ $passType->simulateChangeLabel() }}
                            <svg class="size-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M3 10a.75.75 0 0 1 .75-.75h10.638L10.23 5.29a.75.75 0 1 1 1.04-1.08l5.5 5.25a.75.75 0 0 1 0 1.08l-5.5 5.25a.75.75 0 1 1-1.04-1.08l4.158-3.96H3.75A.75.75 0 0 1 3 10Z" clip-rule="evenodd" /></svg>
                        </x-button>
                    </div>
                </x-card>
            @else
                <x-card>
                    <div class="space-y-3">
                        <h2 class="text-lg font-semibold text-ink">Update sent</h2>
                        <p class="max-w-[64ch] text-base/7 text-pretty text-ink-muted">
                            Apple has been notified. Your iPhone should pull the latest version within a minute. Apple rate-limits updates to the same pass, so a second change in a 10-minute window may take longer.
                        </p>
                    </div>
                </x-card>
            @endif
        </div>

        {{-- Right: download / QR --}}
        <aside class="space-y-4 lg:col-span-2">
            <x-card>
                <div class="space-y-5">
                    <div class="space-y-1">
                        <p class="text-xs font-medium tracking-wide text-ink-muted uppercase">.pkpass</p>
                        <h2 class="text-lg font-semibold text-ink">Install on a device</h2>
                    </div>

                    <div class="overflow-hidden rounded bg-surface-sunken ring-1 ring-parchment-strong/70">
                        <div class="aspect-square w-full">
                            {!! $downloadQr !!}
                        </div>
                    </div>

                    <p class="text-sm/6 text-pretty text-ink-muted">
                        Scan the code with your iPhone, or use the button below to grab the file.
                    </p>

                    <x-button :href="$downloadUrl" variant="primary" class="w-full">
                        <svg class="size-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 3a1 1 0 0 1 1 1v9.586l2.293-2.293a1 1 0 1 1 1.414 1.414l-4 4a1 1 0 0 1-1.414 0l-4-4a1 1 0 1 1 1.414-1.414L11 13.586V4a1 1 0 0 1 1-1zM4 16a1 1 0 0 1 1 1v2h14v-2a1 1 0 1 1 2 0v3a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1z"/></svg>
                        Download .pkpass
                    </x-button>
                </div>
            </x-card>

            <dl class="grid grid-cols-1 gap-3 text-sm sm:grid-cols-2 lg:grid-cols-1">
                <div class="rounded bg-surface ring-1 ring-parchment-strong/60 px-4 py-3">
                    <dt class="text-xs font-medium tracking-wide text-ink-muted uppercase">Builder</dt>
                    <dd class="mt-0.5 font-medium text-ink">{{ $passType->builderShortName() }}</dd>
                </div>
                <div class="rounded bg-surface ring-1 ring-parchment-strong/60 px-4 py-3">
                    <dt class="text-xs font-medium tracking-wide text-ink-muted uppercase">Pass type</dt>
                    <dd class="mt-0.5 font-medium text-ink tabular-nums">{{ $passType->label() }}</dd>
                </div>
                <div class="rounded bg-surface ring-1 ring-parchment-strong/60 px-4 py-3 sm:col-span-2 lg:col-span-1">
                    <dt class="text-xs font-medium tracking-wide text-ink-muted uppercase">Serial number</dt>
                    <dd class="mt-0.5 truncate font-mono text-[0.8125rem] text-ink-muted">{{ $mobilePass->id }}</dd>
                </div>
            </dl>
        </aside>
    </div>
</div>
