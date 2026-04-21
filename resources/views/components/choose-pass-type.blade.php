@props([
    'name' => '',
    'type' => '',
])

<a href="{{ route('new-pass', ['type' => $type]) }}" class="p-6 flex space-y-4 flex-col items-center justify-center text-center text-sm font-medium aspect-square bg-white dark:bg-[#161615] dark:text-[#EDEDEC] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d] rounded">
    <div class="w-8 h-8">
        {{ $slot }}
    </div>
    <div>
        {{ $name }}
    </div>
</a>
