@props(['title', 'message', 'action' => null])

<div class="portal-card">
    <div class="portal-card-body flex min-h-52 flex-col items-center justify-center text-center">
        <div class="mb-4 grid h-11 w-11 place-items-center rounded-lg bg-blue-50 text-blue-600 dark:bg-blue-950/40 dark:text-blue-300">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M12 5v14M5 12h14" stroke-linecap="round" />
            </svg>
        </div>
        <h3 class="text-base font-bold text-slate-950 dark:text-white">{{ $title }}</h3>
        <p class="mt-1 max-w-md text-sm text-slate-500 dark:text-slate-400">{{ $message }}</p>
        @if ($action)
            <div class="mt-5">{{ $action }}</div>
        @endif
    </div>
</div>

