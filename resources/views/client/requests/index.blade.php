<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="portal-title">Requests</h1>
                <p class="portal-muted mt-1">Track creative and marketing work in one place.</p>
            </div>
            <a href="{{ route('client.requests.create') }}" class="portal-button">New Request</a>
        </div>
    </x-slot>

    <div class="portal-container">
        @if (session('status'))
            <div class="mb-5 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700 dark:border-emerald-900 dark:bg-emerald-950/40 dark:text-emerald-300">
                {{ session('status') }}
            </div>
        @endif

        @if ($tasks->isEmpty())
            <x-empty-state title="No requests yet" message="Create your first request with a clear brief and optional reference image.">
                <x-slot name="action">
                    <a href="{{ route('client.requests.create') }}" class="portal-button">Create Request</a>
                </x-slot>
            </x-empty-state>
        @else
            <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                @foreach ($tasks as $task)
                    <a href="{{ route('client.requests.show', $task) }}" class="portal-card transition hover:-translate-y-0.5 hover:shadow-md">
                        @if ($task->reference_url)
                            <img src="{{ $task->reference_url }}" alt="" class="h-40 w-full rounded-t-lg object-cover">
                        @endif
                        <div class="portal-card-body">
                            <div class="flex items-start justify-between gap-3">
                                <h2 class="font-bold text-slate-950 dark:text-white">{{ $task->title }}</h2>
                                <x-status-badge :status="$task->status" />
                            </div>
                            <p class="mt-3 line-clamp-3 text-sm text-slate-500 dark:text-slate-400">{{ $task->description }}</p>
                            <p class="mt-4 text-xs font-semibold text-slate-400">{{ $task->created_at->format('M d, Y') }}</p>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-6">{{ $tasks->links() }}</div>
        @endif
    </div>
</x-app-layout>

