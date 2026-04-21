<x-layouts.app>
    <div class="space-y-6 sm:space-y-8">
        {{-- Hero --}}
        <x-card>
            <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                <div class="space-y-4">
                    <p class="inline-flex items-center gap-2 rounded-full bg-teal-soft px-3 py-1 text-xs font-medium tracking-wide text-teal uppercase">
                        spatie/laravel-mobile-pass
                    </p>
                    <h1 class="max-w-[24ch] text-4xl font-semibold tracking-tight text-balance text-ink sm:text-5xl">
                        Apple Wallet passes, generated from Laravel.
                    </h1>
                    <p class="max-w-[60ch] text-base/7 text-pretty text-ink-muted">
                        Pick any of the five Apple Wallet pass templates below and the demo will generate a real, signed <code class="rounded bg-teal-soft px-1.5 py-0.5 text-[0.8125rem] text-teal">.pkpass</code> file you can install on an iPhone. Once installed, simulate an update and watch Wallet pull the change.
                    </p>
                </div>
                <div class="shrink-0 lg:max-w-xs">
                    <x-button href="https://github.com/spatie/laravel-mobile-pass" variant="primary" target="_blank" rel="noopener" class="w-full">
                        Get the package
                        <svg class="size-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M3 10a.75.75 0 0 1 .75-.75h10.638L10.23 5.29a.75.75 0 1 1 1.04-1.08l5.5 5.25a.75.75 0 0 1 0 1.08l-5.5 5.25a.75.75 0 1 1-1.04-1.08l4.158-3.96H3.75A.75.75 0 0 1 3 10Z" clip-rule="evenodd" /></svg>
                    </x-button>
                </div>
            </div>
        </x-card>

        {{-- Pass picker --}}
        <section aria-labelledby="pass-picker">
            <div class="mb-4 flex items-end justify-between gap-4 px-1">
                <div>
                    <h2 id="pass-picker" class="text-xl font-semibold tracking-tight text-ink">Generate a pass</h2>
                    <p class="text-sm/6 text-ink-muted">Each tile creates an example pass you can install in Apple Wallet.</p>
                </div>
            </div>
            <ul role="list" class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-5">
                @foreach (\App\Support\PassType::cases() as $type)
                    <li>
                        <x-pass-tile :type="$type" />
                    </li>
                @endforeach
            </ul>
        </section>

        {{-- How it works --}}
        <section aria-labelledby="how-it-works" class="grid gap-4 lg:grid-cols-3">
            <x-card>
                <div class="space-y-2">
                    <div class="flex size-9 items-center justify-center rounded bg-teal-soft text-teal">
                        <svg viewBox="0 0 20 20" class="size-5" fill="currentColor"><path d="M3 4a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4Zm3 1.5a.5.5 0 0 0 0 1h8a.5.5 0 0 0 0-1H6Zm0 3a.5.5 0 0 0 0 1h8a.5.5 0 0 0 0-1H6Zm0 3a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1H6Z"/></svg>
                    </div>
                    <h3 id="how-it-works" class="text-base font-semibold text-ink">1. Pick a template</h3>
                    <p class="text-sm/6 text-pretty text-ink-muted">
                        Each tile maps to one of the package’s Apple builders: airline, coupon, event ticket, store card, or generic.
                    </p>
                </div>
            </x-card>
            <x-card>
                <div class="space-y-2">
                    <div class="flex size-9 items-center justify-center rounded bg-teal-soft text-teal">
                        <svg viewBox="0 0 20 20" class="size-5" fill="currentColor"><path d="M5 3a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1H5Zm3 4h4v1H8V7Zm-1 3h6v1H7v-1Zm0 3h6v1H7v-1Z"/></svg>
                    </div>
                    <h3 class="text-base font-semibold text-ink">2. Install on iPhone</h3>
                    <p class="text-sm/6 text-pretty text-ink-muted">
                        Scan the on-screen QR code with your iPhone’s camera and tap <em class="text-ink">Add to Apple Wallet</em>.
                    </p>
                </div>
            </x-card>
            <x-card>
                <div class="space-y-2">
                    <div class="flex size-9 items-center justify-center rounded bg-teal-soft text-teal">
                        <svg viewBox="0 0 20 20" class="size-5" fill="currentColor"><path d="M10 2a8 8 0 1 0 8 8h-2a6 6 0 1 1-6-6V2Zm5 1.6a1 1 0 0 0-1.4 1.4l1.4 1.4-3 3 1.4 1.4 3-3 1.4 1.4a1 1 0 0 0 1.4-1.4l-4.2-4.2Z"/></svg>
                    </div>
                    <h3 class="text-base font-semibold text-ink">3. Push an update</h3>
                    <p class="text-sm/6 text-pretty text-ink-muted">
                        Trigger a change from the detail page. Apple notifies the device and Wallet pulls the new version automatically.
                    </p>
                </div>
            </x-card>
        </section>
    </div>
</x-layouts.app>
