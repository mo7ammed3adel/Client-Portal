<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="portal-title">رسائل التواصل</h1>
            <p class="portal-muted mt-1">راجع الرسائل الواردة من نموذج "تواصل معنا".</p>
        </div>
    </x-slot>

    <div class="portal-container">
        @if (session('status'))
            <div class="mb-5 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700 dark:border-emerald-900 dark:bg-emerald-950/40 dark:text-emerald-300">
                {{ session('status') }}
            </div>
        @endif

        <form method="GET" class="mb-5 flex flex-wrap gap-3">
            <select name="status" class="portal-input mt-0 w-52">
                <option value="">كل الرسائل</option>
                <option value="new" @selected($status === 'new')>جديدة</option>
                <option value="reviewed" @selected($status === 'reviewed')>تمت المراجعة</option>
                <option value="closed" @selected($status === 'closed')>مغلقة</option>
            </select>
            <button class="portal-button-secondary">تصفية</button>
        </form>

        @if ($contacts->isEmpty())
            <x-empty-state title="لا توجد رسائل" message="رسائل العملاء ستظهر هنا." />
        @else
            <div class="portal-card overflow-x-auto">
                <table class="portal-table">
                    <thead>
                        <tr>
                            <th>الاسم</th>
                            <th>البريد / الهاتف</th>
                            <th>الرسالة</th>
                            <th>التاريخ</th>
                            <th>الحالة</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @foreach ($contacts as $contact)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50">
                                <td class="font-semibold text-slate-900 dark:text-white">{{ $contact->name }}</td>
                                <td class="text-slate-500">
                                    <span dir="ltr">{{ $contact->email }}</span><br>
                                    <span dir="ltr" class="text-xs">{{ $contact->phone }}</span>
                                </td>
                                <td class="max-w-xs"><p class="line-clamp-2">{{ $contact->message }}</p></td>
                                <td class="text-slate-500">{{ $contact->created_at->format('Y/m/d') }}</td>
                                <td><x-status-badge :status="$contact->status" /></td>
                                <td><a href="{{ route('admin.contacts.show', $contact) }}" class="text-sm font-semibold text-brand-600">عرض</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-6">{{ $contacts->links() }}</div>
        @endif
    </div>
</x-app-layout>
