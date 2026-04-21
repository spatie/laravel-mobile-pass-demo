@props(['installed' => false])

<span @class([
    'inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-medium ring-1',
    'bg-emerald-50 text-emerald-700 ring-emerald-200' => $installed,
    'bg-amber-50 text-amber-700 ring-amber-200' => ! $installed,
])>
    <span @class([
        'size-1.5 rounded-full',
        'bg-emerald-500' => $installed,
        'bg-amber-500 animate-pulse' => ! $installed,
    ])></span>
    {{ $installed ? 'Installed on a device' : 'Waiting for installation' }}
</span>
