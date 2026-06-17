<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="portal-title">مناديب الشحن</h1>
            <p class="portal-muted mt-1">أنشئ حسابات المناديب لاستخدام تطبيق "طلبة كابتن".</p>
        </div>
    </x-slot>

    <div class="portal-container max-w-5xl space-y-6">
        @if (session('status'))
            <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700 dark:border-emerald-900 dark:bg-emerald-950/40 dark:text-emerald-300">
                {{ session('status') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-700">
                <ul class="list-disc space-y-1 pe-5">
                    @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
        @endif

        <div class="grid gap-6 lg:grid-cols-3">
            {{-- New courier form --}}
            <div class="lg:col-span-1">
                <div class="portal-card">
                    <div class="border-b border-slate-100 px-5 py-4 dark:border-slate-800">
                        <h2 class="font-bold text-slate-950 dark:text-white">إضافة مندوب</h2>
                    </div>
                    <form method="POST" action="{{ route('admin.couriers.store') }}" class="portal-card-body space-y-4">
                        @csrf
                        <div>
                            <label class="portal-label">الاسم</label>
                            <input name="name" type="text" value="{{ old('name') }}" required class="portal-input">
                        </div>
                        <div>
                            <label class="portal-label">البريد الإلكتروني (للدخول)</label>
                            <input name="email" type="email" value="{{ old('email') }}" required class="portal-input" dir="ltr">
                        </div>
                        <div>
                            <label class="portal-label">رقم الهاتف</label>
                            <input name="phone" type="text" value="{{ old('phone') }}" class="portal-input" dir="ltr">
                        </div>
                        <div>
                            <label class="portal-label">كلمة المرور</label>
                            <input name="password" type="text" required class="portal-input" dir="ltr" placeholder="6 أحرف على الأقل">
                        </div>
                        <button class="portal-button w-full">إنشاء الحساب</button>
                    </form>
                </div>
            </div>

            {{-- Couriers list --}}
            <div class="lg:col-span-2">
                @if ($couriers->isEmpty())
                    <x-empty-state title="لا يوجد مناديب" message="أضف أول مندوب من النموذج المجاور." />
                @else
                    <div class="portal-card overflow-x-auto">
                        <table class="portal-table">
                            <thead>
                                <tr>
                                    <th>الاسم</th>
                                    <th>البريد / الهاتف</th>
                                    <th>تم تسليمها</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                                @foreach ($couriers as $courier)
                                    <tr>
                                        <td class="font-semibold text-slate-900 dark:text-white">{{ $courier->name }}</td>
                                        <td class="text-slate-500">
                                            <span dir="ltr">{{ $courier->email }}</span><br>
                                            <span dir="ltr" class="text-xs">{{ $courier->phone }}</span>
                                        </td>
                                        <td class="font-semibold">{{ $courier->deliveries_count }}</td>
                                        <td>
                                            <form method="POST" action="{{ route('admin.couriers.destroy', $courier) }}" onsubmit="return confirm('حذف هذا المندوب؟');">
                                                @csrf
                                                @method('DELETE')
                                                <button class="text-sm font-semibold text-red-600">حذف</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-6">{{ $couriers->links() }}</div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
