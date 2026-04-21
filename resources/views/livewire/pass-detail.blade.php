<div wire:poll class="w-full max-w-lg">
    <div class="flex items-center justify-between text-xs mb-4">
        <a href="/" class="hover:underline text-[#F53003]">Make new pass</a>

        <div class="text-xs flex space-x-2 items-center">
            <div @class([
                'w-2 h-2 outline-2 rounded-full' => true,
                'outline-green-500/40 bg-green-500' => $installed,
                'outline-yellow-500/40 bg-yellow-500 animate-pulse' => ! $installed,
            ])></div>
            <div>
                @if ($installed)
                    Installed
                @else
                    Waiting for installation...
                @endif
            </div>
        </div>
    </div>

    @if (! $installed)
        <div class="text-center flex flex-col items-center justify-center space-y-4">
            <div class="mx-auto w-xs text-sm font-medium bg-white dark:bg-[#161615] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d] rounded">
                {!! $downloadQr !!}
            </div>

            <div class="text-sm text-[#706f6c] dark:text-[#A1A09A]">
                Scan with an iPhone, or download the <code class="text-[#1b1b18] dark:text-[#EDEDEC]">.pkpass</code> below.
            </div>

            <a href="{{ $downloadUrl }}" class="inline-flex items-center gap-2 px-4 py-2 rounded bg-[#1b1b18] text-white hover:bg-[#F53003] transition-colors text-sm font-medium">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                    <path d="M12 3a1 1 0 0 1 1 1v9.586l2.293-2.293a1 1 0 1 1 1.414 1.414l-4 4a1 1 0 0 1-1.414 0l-4-4a1 1 0 1 1 1.414-1.414L11 13.586V4a1 1 0 0 1 1-1zM4 16a1 1 0 0 1 1 1v2h14v-2a1 1 0 1 1 2 0v3a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1z"/>
                </svg>
                Download .pkpass
            </a>
        </div>
    @elseif (! $hasChanged)
        <div class="text-center flex flex-col items-center justify-center space-y-4">
            <div class="flex items-center justify-center space-y-2 aspect-square p-4 mx-auto w-xs text-sm font-medium bg-white dark:bg-[#161615] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d] rounded">
                <button class="w-1/2 p-2 rounded-sm border block" wire:click="simulateChange">
                    {{ $changeSummary }}
                </button>
            </div>

            <div class="text-sm">
                Now try making a change to the pass!
            </div>
        </div>
    @else
        <div class="text-center flex flex-col items-center justify-center space-y-4">
            <div class="space-y-2 aspect-square p-4 mx-auto w-xs text-sm font-medium bg-white dark:bg-[#161615] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d] rounded">
                <div>
                    We've notified Apple that the pass has changed, and your device should pull the latest version shortly.
                </div>

                <div>
                    The speed of this process varies, and there's usually a delay of ~1 minute when modifying the same pass multiple times within a 10 minute window.
                </div>
            </div>
        </div>
    @endif
</div>
