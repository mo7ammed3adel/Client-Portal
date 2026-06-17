<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <h1 class="portal-title">Delivery Order #{{ $task->id }}</h1>
                <p class="portal-muted mt-1">Created {{ $task->created_at->format('M d, Y') }}</p>
            </div>
            <x-status-badge :status="$task->status" />
        </div>
    </x-slot>

    <div class="portal-container max-w-4xl">
        <div class="grid gap-5 lg:grid-cols-[1.2fr_0.8fr]">
            <div class="portal-card">
                <div class="portal-card-body">
                    <h2 class="font-bold text-slate-950 dark:text-white">تفاصيل العنوان</h2>
                    <p class="mt-3 whitespace-pre-line text-sm leading-6 text-slate-600 dark:text-slate-300">{{ $task->address_details ?? $task->description }}</p>
                </div>
            </div>

            <div class="portal-card">
                <div class="portal-card-body">
                    <h2 class="font-bold text-slate-950 dark:text-white">Location</h2>
                    @if ($task->delivery_latitude && $task->delivery_longitude)
                        <div class="mt-4 rounded-lg border border-slate-200 bg-slate-50 p-4 dark:border-slate-800 dark:bg-slate-950">
                            <p class="text-sm font-semibold text-slate-700 dark:text-slate-200">
                                {{ $task->delivery_latitude }}, {{ $task->delivery_longitude }}
                            </p>
                            <a
                                href="https://www.openstreetmap.org/?mlat={{ $task->delivery_latitude }}&mlon={{ $task->delivery_longitude }}#map=17/{{ $task->delivery_latitude }}/{{ $task->delivery_longitude }}"
                                target="_blank"
                                class="mt-3 inline-flex text-sm font-semibold text-blue-600 dark:text-blue-400"
                            >
                                Open on map
                            </a>
                        </div>
                    @else
                        <p class="mt-3 text-sm text-slate-500 dark:text-slate-400">No location selected.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
