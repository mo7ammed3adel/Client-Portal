<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="portal-title">Delivery Orders</h1>
            <p class="portal-muted mt-1">Review client delivery orders and update progress.</p>
        </div>
    </x-slot>

    <div class="portal-container">
        @if (session('status'))
            <div class="mb-5 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700 dark:border-emerald-900 dark:bg-emerald-950/40 dark:text-emerald-300">
                {{ session('status') }}
            </div>
        @endif

        <form method="GET" class="mb-5 flex flex-wrap gap-3">
            <select name="status" class="portal-input mt-0 w-56">
                <option value="">All statuses</option>
                <option value="pending" @selected($status === 'pending')>Pending</option>
                <option value="in_progress" @selected($status === 'in_progress')>In Progress</option>
                <option value="completed" @selected($status === 'completed')>Completed</option>
            </select>
            <button class="portal-button-secondary">Filter</button>
        </form>

        @if ($tasks->isEmpty())
            <x-empty-state title="No delivery orders" message="Delivery orders from clients will appear here." />
        @else
            <div class="grid gap-4 lg:grid-cols-2">
                @foreach ($tasks as $task)
                    <div class="portal-card">
                        <div class="portal-card-body">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <h2 class="font-bold text-slate-950 dark:text-white">Delivery Order #{{ $task->id }}</h2>
                                    <p class="mt-1 text-sm text-slate-500">{{ $task->client->name }} · {{ $task->created_at->format('M d, Y') }}</p>
                                </div>
                                <x-status-badge :status="$task->status" />
                            </div>
                            <p class="mt-4 line-clamp-3 text-sm leading-6 text-slate-600 dark:text-slate-300">{{ $task->address_details ?? $task->description }}</p>
                            @if ($task->delivery_latitude && $task->delivery_longitude)
                                <a
                                    href="https://www.openstreetmap.org/?mlat={{ $task->delivery_latitude }}&mlon={{ $task->delivery_longitude }}#map=17/{{ $task->delivery_latitude }}/{{ $task->delivery_longitude }}"
                                    target="_blank"
                                    class="mt-4 inline-flex text-sm font-semibold text-blue-600 dark:text-blue-400"
                                >
                                    Open location
                                </a>
                            @endif
                            <form method="POST" action="{{ route('admin.requests.update', $task) }}" class="mt-5 flex flex-wrap items-center gap-3">
                                @csrf
                                @method('PATCH')
                                <select name="status" class="portal-input mt-0 w-48">
                                    <option value="pending" @selected($task->status === 'pending')>Pending</option>
                                    <option value="in_progress" @selected($task->status === 'in_progress')>In Progress</option>
                                    <option value="completed" @selected($task->status === 'completed')>Completed</option>
                                </select>
                                <button class="portal-button-secondary">Update</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-6">{{ $tasks->links() }}</div>
        @endif
    </div>
</x-app-layout>
