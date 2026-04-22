<div class="space-y-6 sm:space-y-8">
    {{-- Page header --}}
    <div class="space-y-1 px-1">
        <a href="/" class="inline-flex items-center gap-1 text-sm font-medium text-ink-muted hover:text-teal">
            <svg class="size-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M17 10a.75.75 0 0 1-.75.75H5.612l4.158 3.96a.75.75 0 1 1-1.04 1.08l-5.5-5.25a.75.75 0 0 1 0-1.08l5.5-5.25a.75.75 0 1 1 1.04 1.08L5.612 9.25H16.25A.75.75 0 0 1 17 10Z" clip-rule="evenodd" /></svg>
            Back to all passes
        </a>
        <h1 class="text-2xl font-semibold tracking-tight text-ink sm:text-3xl">Wi-Fi pass</h1>
    </div>

    <x-card class="sm:p-10">
        <div class="grid gap-8 sm:grid-cols-[1fr_auto] sm:items-start sm:gap-10">
            <div class="space-y-5 max-w-[54ch]">
                <p class="inline-flex items-center gap-2 rounded-full bg-teal-soft px-3 py-1 text-xs font-medium tracking-wide text-teal uppercase">
                    Create a pass
                </p>
                <div class="space-y-3">
                    <h2 class="text-2xl font-semibold tracking-tight text-balance text-ink sm:text-3xl">
                        Share your Wi-Fi network
                    </h2>
                    <p class="text-base/7 text-pretty text-ink-muted">
                        Enter your network's SSID and password. We generate an Apple Wallet pass with the credentials encoded as a Wi-Fi QR code. Anyone with an iPhone or Android device scans the pass's barcode and the OS offers to join the network.
                    </p>
                </div>

                <form wire:submit="generate" class="space-y-5 pt-2">
                    <div class="space-y-1.5">
                        <label for="wifi-ssid" class="block text-sm font-medium text-ink">Network SSID</label>
                        <input
                            id="wifi-ssid"
                            type="text"
                            wire:model="ssid"
                            class="block w-full rounded border border-parchment-strong/70 bg-surface px-3 py-2 text-sm text-ink shadow-sm focus:border-teal focus:outline-none focus:ring-1 focus:ring-teal"
                            placeholder="e.g. Spatie Guest"
                            autocomplete="off"
                            spellcheck="false"
                            required
                        />
                        @error('ssid') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-1.5">
                        <label for="wifi-password" class="block text-sm font-medium text-ink">Password</label>
                        <input
                            id="wifi-password"
                            type="text"
                            wire:model="password"
                            class="block w-full rounded border border-parchment-strong/70 bg-surface px-3 py-2 text-sm text-ink shadow-sm focus:border-teal focus:outline-none focus:ring-1 focus:ring-teal"
                            autocomplete="off"
                            spellcheck="false"
                            required
                        />
                        @error('password') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                        <p class="text-xs text-ink-muted">At least 8 characters, the WPA2/WPA3 minimum.</p>
                    </div>

                    <div class="flex flex-wrap items-center gap-3 pt-2">
                        <x-button type="submit" variant="primary">
                            Generate pass
                            <svg class="size-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M3 10a.75.75 0 0 1 .75-.75h10.638L10.23 5.29a.75.75 0 1 1 1.04-1.08l5.5 5.25a.75.75 0 0 1 0 1.08l-5.5 5.25a.75.75 0 1 1-1.04-1.08l4.158-3.96H3.75A.75.75 0 0 1 3 10Z" clip-rule="evenodd" /></svg>
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </x-card>

    <x-card>
        <div class="space-y-3">
            <h2 class="text-lg font-semibold text-ink">How it's built</h2>
            <p class="text-sm/6 text-ink-muted">A generic Apple Wallet pass with the SSID and password as fields, and a QR-code barcode whose contents use the standard Wi-Fi URI scheme (<code class="rounded bg-teal-soft px-1.5 py-0.5 text-[0.8125rem] text-teal">WIFI:S:ssid;T:WPA;P:password;;</code>). iOS and Android's camera apps recognise that format and prompt the user to join.</p>
            <x-code>GenericPassBuilder::make()
    ->setOrganisationName('Wi-Fi share')
    ->setDescription('Wi-Fi credentials for '.$ssid)
    ->addField('ssid', $ssid, label: 'Network')
    ->addSecondaryField('password', $password, label: 'Password')
    ->setBarcode(
        BarcodeType::Qr,
        "WIFI:S:{$ssid};T:WPA;P:{$password};;",
        altText: $ssid,
    )
    ->save();</x-code>
            <p class="text-sm/6 text-ink-muted">
                See the source in <a class="font-medium text-ink underline decoration-parchment-strong underline-offset-4 hover:text-teal hover:decoration-teal" href="https://github.com/spatie/laravel-mobile-pass-demo/blob/main/app/Actions/GenerateExampleWifiPass.php" target="_blank" rel="noopener">GenerateExampleWifiPass.php</a>.
            </p>
        </div>
    </x-card>
</div>
