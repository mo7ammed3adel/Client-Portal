<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <h1 class="portal-title">{{ $task->title }}</h1>
                <p class="portal-muted mt-1">Created {{ $task->created_at->format('M d, Y') }}</p>
            </div>
            <x-status-badge :status="$task->status" />
        </div>
    </x-slot>

    <div class="portal-container max-w-4xl">
        <div class="grid gap-5 lg:grid-cols-[1.2fr_0.8fr]">
            <div class="portal-card">
                <div class="portal-card-body">
                    <h2 class="font-bold text-slate-950 dark:text-white">Brief</h2>
                    <p class="mt-3 whitespace-pre-line text-sm leading-6 text-slate-600 dark:text-slate-300">{{ $task->description }}</p>
                    @if ($task->notes)
                        <h3 class="mt-6 font-bold text-slate-950 dark:text-white">Notes</h3>
                        <p class="mt-3 whitespace-pre-line text-sm leading-6 text-slate-600 dark:text-slate-300">{{ $task->notes }}</p>
                    @endif
                </div>
            </div>

            <div class="portal-card">
                <div class="portal-card-body">
                    <h2 class="font-bold text-slate-950 dark:text-white">Reference</h2>
                    @if ($task->reference_url)
                        <img src="{{ $task->reference_url }}" alt="" class="mt-4 rounded-lg border border-slate-200 object-cover dark:border-slate-800">
                    @else
                        <p class="mt-3 text-sm text-slate-500 dark:text-slate-400">No reference image attached.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

