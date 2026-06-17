<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h1 class="portal-title">رسالة من {{ $contact->name }}</h1>
                <p class="portal-muted mt-1">{{ $contact->created_at->format('Y/m/d - H:i') }}</p>
            </div>
            <a href="{{ route('admin.contacts.index') }}" class="portal-button-secondary">رجوع للرسائل</a>
        </div>
    </x-slot>

    <div class="portal-container max-w-3xl space-y-6">
        @if (session('status'))
            <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700 dark:border-emerald-900 dark:bg-emerald-950/40 dark:text-emerald-300">
                {{ session('status') }}
            </div>
        @endif

        <div class="portal-card">
            <div class="portal-card-body space-y-5">
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <p class="text-xs font-bold text-slate-400">الاسم</p>
                        <p class="mt-1 font-semibold text-slate-900 dark:text-white">{{ $contact->name }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400">الحالة</p>
                        <p class="mt-1"><x-status-badge :status="$contact->status" /></p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400">البريد الإلكتروني</p>
                        <a href="mailto:{{ $contact->email }}" class="mt-1 inline-block font-semibold text-brand-600" dir="ltr">{{ $contact->email }}</a>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400">رقم الهاتف</p>
                        <a href="tel:{{ $contact->phone }}" class="mt-1 inline-block font-semibold text-brand-600" dir="ltr">{{ $contact->phone }}</a>
                    </div>
                </div>

                <div>
                    <p class="text-xs font-bold text-slate-400">الرسالة</p>
                    <p class="mt-2 whitespace-pre-line rounded-lg bg-slate-50 p-4 text-sm leading-7 text-slate-700 dark:bg-slate-800/40 dark:text-slate-200">{{ $contact->message }}</p>
                </div>
            </div>
        </div>

        <div class="portal-card">
            <div class="portal-card-body flex flex-wrap items-center justify-between gap-4">
                <form method="POST" action="{{ route('admin.contacts.update', $contact) }}" class="flex flex-wrap items-center gap-3">
                    @csrf
                    @method('PATCH')
                    <select name="status" class="portal-input mt-0 w-48">
                        <option value="new" @selected($contact->status === 'new')>جديدة</option>
                        <option value="reviewed" @selected($contact->status === 'reviewed')>تمت المراجعة</option>
                        <option value="closed" @selected($contact->status === 'closed')>مغلقة</option>
                    </select>
                    <button class="portal-button">تحديث الحالة</button>
                </form>

                <form method="POST" action="{{ route('admin.contacts.destroy', $contact) }}" onsubmit="return confirm('هل تريد حذف هذه الرسالة؟');">
                    @csrf
                    @method('DELETE')
                    <button class="portal-button-danger">حذف</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
