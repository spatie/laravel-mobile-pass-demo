<x-layouts.app>
    <div class="space-y-6 sm:space-y-10">
        {{-- Hero --}}
        <x-card>
            <div class="space-y-6">
                <p class="inline-flex items-center gap-2 rounded-full bg-teal-soft px-3 py-1 text-xs font-medium tracking-wide text-teal uppercase">
                    spatie/laravel-mobile-pass
                </p>
                <h1 class="max-w-[22ch] text-4xl font-semibold tracking-tight text-balance text-ink sm:text-5xl lg:text-[3.25rem] lg:leading-[1.05]">
                    Apple Wallet passes, generated from Laravel.
                </h1>
                <p class="max-w-[58ch] text-base/7 text-pretty text-ink-muted">
                    Pick any of the five Apple Wallet pass templates below. The demo generates a real, signed <code class="rounded bg-teal-soft px-1.5 py-0.5 text-[0.8125rem] text-teal">.pkpass</code> file you can install on an iPhone, then push a live update and watch Wallet pull the change.
                </p>
                <div class="flex flex-wrap items-center gap-3">
                    <x-button href="https://github.com/spatie/laravel-mobile-pass" variant="primary" target="_blank" rel="noopener">
                        Get the package
                        <svg class="size-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M3 10a.75.75 0 0 1 .75-.75h10.638L10.23 5.29a.75.75 0 1 1 1.04-1.08l5.5 5.25a.75.75 0 0 1 0 1.08l-5.5 5.25a.75.75 0 1 1-1.04-1.08l4.158-3.96H3.75A.75.75 0 0 1 3 10Z" clip-rule="evenodd" /></svg>
                    </x-button>
                    <a href="https://spatie.be/docs/laravel-mobile-pass" target="_blank" rel="noopener" class="inline-flex items-center gap-1.5 px-1 text-sm font-medium text-ink-muted hover:text-teal">
                        Read the docs
                        <svg class="size-3.5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M4.25 5.5a.75.75 0 0 0 0 1.5h8.69L3.22 16.72a.75.75 0 1 0 1.06 1.06L14 8.06v8.69a.75.75 0 0 0 1.5 0V5.5H4.25Z" clip-rule="evenodd" /></svg>
                    </a>
                </div>
            </div>
        </x-card>

        {{-- Pass picker --}}
        <section aria-labelledby="pass-picker" class="space-y-4">
            <div class="flex items-end justify-between gap-4 px-1">
                <div class="space-y-1">
                    <p class="text-xs font-medium tracking-[0.12em] text-teal uppercase">Templates</p>
                    <h2 id="pass-picker" class="text-2xl font-semibold tracking-tight text-ink">Generate a pass</h2>
                    <p class="max-w-[60ch] text-sm/6 text-ink-muted">Each tile maps to one of the package's Apple builders. Tap one to create a signed <code class="rounded bg-teal-soft px-1.5 py-0.5 text-[0.8125rem] text-teal">.pkpass</code> and install it on your iPhone.</p>
                </div>
            </div>
            <ul role="list" class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-5">
                @foreach (\App\Support\PassType::cases() as $type)
                    <li>
                        <x-pass-tile :type="$type" />
                    </li>
                @endforeach
            </ul>
        </section>

        {{-- How it works --}}
        <section aria-labelledby="how-it-works" class="space-y-4">
            <div class="space-y-1 px-1">
                <p class="text-xs font-medium tracking-[0.12em] text-teal uppercase">How it works</p>
                <h2 id="how-it-works" class="text-2xl font-semibold tracking-tight text-ink">Three steps, zero JavaScript</h2>
            </div>
            <div class="grid gap-4 lg:grid-cols-3">
                <x-card>
                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <span class="flex size-9 items-center justify-center rounded bg-teal text-surface text-sm font-semibold tabular-nums">1</span>
                            <h3 class="text-base font-semibold text-ink">Pick a template</h3>
                        </div>
                        <p class="text-sm/6 text-pretty text-ink-muted">
                            Each tile maps to one of the package's Apple builders: airline, coupon, event ticket, store card, or generic.
                        </p>
                    </div>
                </x-card>
                <x-card>
                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <span class="flex size-9 items-center justify-center rounded bg-teal text-surface text-sm font-semibold tabular-nums">2</span>
                            <h3 class="text-base font-semibold text-ink">Install on iPhone</h3>
                        </div>
                        <p class="text-sm/6 text-pretty text-ink-muted">
                            Scan the on-screen QR code with your iPhone's camera and tap <em class="text-ink">Add to Apple Wallet</em>.
                        </p>
                    </div>
                </x-card>
                <x-card>
                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <span class="flex size-9 items-center justify-center rounded bg-teal text-surface text-sm font-semibold tabular-nums">3</span>
                            <h3 class="text-base font-semibold text-ink">Push an update</h3>
                        </div>
                        <p class="text-sm/6 text-pretty text-ink-muted">
                            Trigger a change from the detail page. Apple notifies the device and Wallet pulls the new version automatically.
                        </p>
                    </div>
                </x-card>
            </div>
        </section>
    </div>
</x-layouts.app>
