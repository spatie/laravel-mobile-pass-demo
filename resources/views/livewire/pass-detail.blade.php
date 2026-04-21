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

            <div class="text-sm">
                Scan this code on an iPhone to <a class="hover:underline text-[#F53003]" href="{{ $downloadUrl }}">download the pass</a>
            </div>
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
