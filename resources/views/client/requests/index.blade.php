<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="portal-title">طلبات التوصيل</h1>
                <p class="portal-muted mt-1">تابع عناوين التوصيل وحالة كل طلب.</p>
            </div>
            <a href="{{ route('client.requests.create') }}" class="portal-button">طلب جديد</a>
        </div>
    </x-slot>

    <div class="portal-container">
        @if (session('status'))
            <div class="mb-5 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700 dark:border-emerald-900 dark:bg-emerald-950/40 dark:text-emerald-300">
                {{ session('status') }}
            </div>
        @endif

        @if ($tasks->isEmpty())
            <x-empty-state title="لا توجد طلبات توصيل بعد" message="أنشئ أول طلب توصيل باختيار نقطة على الخريطة.">
                <x-slot name="action">
                    <a href="{{ route('client.requests.create') }}" class="portal-button">إنشاء طلب</a>
                </x-slot>
            </x-empty-state>
        @else
            <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                @foreach ($tasks as $task)
                    <a href="{{ route('client.requests.show', $task) }}" class="portal-card transition hover:-translate-y-0.5 hover:shadow-md">
                        <div class="portal-card-body">
                            <div class="flex items-start justify-between gap-3">
                                <h2 class="font-bold text-slate-950 dark:text-white">طلب توصيل رقم {{ $task->id }}</h2>
                                <x-status-badge :status="$task->status" />
                            </div>
                            <p class="mt-3 line-clamp-3 text-sm text-slate-500 dark:text-slate-400">{{ $task->address_details ?? $task->description }}</p>
                            @if ($task->delivery_latitude && $task->delivery_longitude)
                                <p class="mt-3 text-xs font-semibold text-blue-600 dark:text-blue-400">
                                    {{ $task->delivery_latitude }}, {{ $task->delivery_longitude }}
                                </p>
                            @endif
                            <p class="mt-4 text-xs font-semibold text-slate-400">{{ $task->created_at->format('Y/m/d') }}</p>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-6">{{ $tasks->links() }}</div>
        @endif
    </div>
</x-app-layout>
