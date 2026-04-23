@use('App\Support\PassType')

<x-layouts.app>
    <div class="space-y-6 sm:space-y-10">
        <x-card>
            <div class="space-y-6">
                <h1 class="max-w-[22ch] text-4xl font-semibold tracking-tight text-balance text-ink sm:text-5xl lg:text-[3.25rem] lg:leading-[1.05]">
                    Apple Wallet passes, generated from Laravel.
                </h1>
                <p class="max-w-[60ch] text-base/7 text-pretty text-ink-muted">
                    This site is a live demo of <a class="font-medium text-ink underline decoration-parchment-strong underline-offset-4 hover:text-teal hover:decoration-teal" href="https://github.com/spatie/laravel-mobile-pass" target="_blank" rel="noopener">spatie/laravel-mobile-pass</a>. Pick any of the pass examples below and the demo generates a real, signed <code class="rounded bg-teal-soft px-1.5 py-0.5 text-[0.8125rem] text-teal">.pkpass</code> you can install on an iPhone, then push a live update and watch Wallet pull the change.
                </p>
                <div class="flex flex-wrap items-center gap-3">
                    <x-button href="https://spatie.be/docs/laravel-mobile-pass" variant="primary" target="_blank" rel="noopener">
                        Read the docs
                        <svg class="size-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M4.25 5.5a.75.75 0 0 0 0 1.5h8.69L3.22 16.72a.75.75 0 1 0 1.06 1.06L14 8.06v8.69a.75.75 0 0 0 1.5 0V5.5H4.25Z" clip-rule="evenodd" /></svg>
                    </x-button>
                    <x-button href="https://github.com/spatie/laravel-mobile-pass" variant="secondary" target="_blank" rel="noopener">
                        <svg viewBox="0 0 24 24" class="size-4" aria-hidden="true" fill="currentColor"><path d="M12 .5a11.5 11.5 0 0 0-3.6 22.4c.6.1.8-.3.8-.6v-2c-3.2.7-3.9-1.4-3.9-1.4-.5-1.3-1.3-1.7-1.3-1.7-1-.7.1-.7.1-.7 1.2.1 1.8 1.2 1.8 1.2 1 1.8 2.8 1.3 3.5 1 .1-.8.4-1.3.8-1.6-2.6-.3-5.4-1.3-5.4-5.8 0-1.3.5-2.4 1.2-3.2-.1-.3-.5-1.5.1-3.2 0 0 1-.3 3.3 1.2a11.4 11.4 0 0 1 6 0c2.3-1.5 3.3-1.2 3.3-1.2.6 1.7.2 2.9.1 3.2.7.8 1.2 1.9 1.2 3.2 0 4.5-2.8 5.5-5.4 5.8.4.4.8 1.1.8 2.2v3.3c0 .3.2.7.8.6A11.5 11.5 0 0 0 12 .5z"/></svg>
                        Package on GitHub
                    </x-button>
                    <a href="https://github.com/spatie/laravel-mobile-pass-demo" target="_blank" rel="noopener" class="inline-flex items-center gap-1.5 px-1 text-sm font-medium text-ink-muted hover:text-teal">
                        <svg viewBox="0 0 24 24" class="size-3.5" aria-hidden="true" fill="currentColor"><path d="M12 .5a11.5 11.5 0 0 0-3.6 22.4c.6.1.8-.3.8-.6v-2c-3.2.7-3.9-1.4-3.9-1.4-.5-1.3-1.3-1.7-1.3-1.7-1-.7.1-.7.1-.7 1.2.1 1.8 1.2 1.8 1.2 1 1.8 2.8 1.3 3.5 1 .1-.8.4-1.3.8-1.6-2.6-.3-5.4-1.3-5.4-5.8 0-1.3.5-2.4 1.2-3.2-.1-.3-.5-1.5.1-3.2 0 0 1-.3 3.3 1.2a11.4 11.4 0 0 1 6 0c2.3-1.5 3.3-1.2 3.3-1.2.6 1.7.2 2.9.1 3.2.7.8 1.2 1.9 1.2 3.2 0 4.5-2.8 5.5-5.4 5.8.4.4.8 1.1.8 2.2v3.3c0 .3.2.7.8.6A11.5 11.5 0 0 0 12 .5z"/></svg>
                        Demo source
                    </a>
                </div>
            </div>
        </x-card>

        <ul role="list" class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach (PassType::cases() as $type)
                <li>
                    <x-pass-tile :type="$type" />
                </li>
            @endforeach
        </ul>
    </div>
</x-layouts.app>
