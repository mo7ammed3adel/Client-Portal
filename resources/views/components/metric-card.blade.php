@props(['label', 'value', 'hint' => null])

<div class="portal-card">
    <div class="portal-card-body">
        <p class="text-sm font-semibold text-slate-500 dark:text-slate-400">{{ $label }}</p>
        <p class="mt-2 text-2xl font-black text-slate-950 dark:text-white">{{ $value }}</p>
        @if ($hint)
            <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">{{ $hint }}</p>
        @endif
    </div>
</div>

