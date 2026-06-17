<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="portal-title">العملاء</h1>
                <p class="portal-muted mt-1">إنشاء وإدارة حسابات العملاء.</p>
            </div>
            <a href="{{ route('admin.clients.create') }}" class="portal-button">إنشاء عميل</a>
        </div>
    </x-slot>

    <div class="portal-container">
        @if (session('status'))
            <div class="mb-5 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700 dark:border-emerald-900 dark:bg-emerald-950/40 dark:text-emerald-300">
                {{ session('status') }}
            </div>
        @endif

        <form method="GET" class="mb-5 flex gap-3">
            <input name="search" value="{{ $search }}" placeholder="ابحث عن عميل..." class="portal-input mt-0">
            <button class="portal-button-secondary">بحث</button>
        </form>

        <div class="portal-card overflow-hidden">
            @if ($clients->isEmpty())
                <div class="p-8 text-center text-sm text-slate-500">لا يوجد عملاء.</div>
            @else
                <div class="overflow-x-auto">
                    <table class="portal-table">
                        <thead>
                            <tr>
                                <th>الاسم</th>
                                <th>البريد الإلكتروني</th>
                                <th>الطلبات</th>
                                <th>الفواتير</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                            @foreach ($clients as $client)
                                <tr>
                                    <td class="font-bold">{{ $client->name }}</td>
                                    <td>{{ $client->email }}</td>
                                    <td>{{ $client->tasks_count }}</td>
                                    <td>{{ $client->invoices_count }}</td>
                                    <td>
                                        <div class="flex justify-end gap-2">
                                            <a href="{{ route('admin.clients.edit', $client) }}" class="portal-button-secondary px-3 py-2">تعديل</a>
                                            <form method="POST" action="{{ route('admin.clients.destroy', $client) }}" onsubmit="return confirm('هل تريد حذف هذا العميل وكل البيانات المرتبطة به؟')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="portal-button-danger px-3 py-2">حذف</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="p-4">{{ $clients->links() }}</div>
            @endif
        </div>
    </div>
</x-app-layout>
