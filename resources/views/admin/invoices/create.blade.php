<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="portal-title">إنشاء فاتورة</h1>
            <p class="portal-muted mt-1">سجل دفع مرتبط بأحد العملاء.</p>
        </div>
    </x-slot>

    <div class="portal-container max-w-3xl">
        <form method="POST" action="{{ route('admin.invoices.store') }}" class="portal-card">
            @csrf
            <div class="portal-card-body space-y-5">
                <div>
                    <label for="client_id" class="portal-label">العميل</label>
                    <select id="client_id" name="client_id" class="portal-input" required>
                        <option value="">اختر العميل</option>
                        @foreach ($clients as $client)
                            <option value="{{ $client->id }}" @selected(old('client_id') == $client->id)>{{ $client->name }} · {{ $client->email }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('client_id')" class="mt-2" />
                </div>

                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label for="invoice_number" class="portal-label">رقم الفاتورة</label>
                        <input id="invoice_number" name="invoice_number" value="{{ old('invoice_number') }}" class="portal-input" placeholder="INV-1002" required>
                        <x-input-error :messages="$errors->get('invoice_number')" class="mt-2" />
                    </div>
                    <div>
                        <label for="amount" class="portal-label">المبلغ</label>
                        <input id="amount" name="amount" type="number" step="0.01" min="0.01" value="{{ old('amount') }}" class="portal-input" required>
                        <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                    </div>
                </div>

                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label for="due_date" class="portal-label">تاريخ الاستحقاق</label>
                        <input id="due_date" name="due_date" type="date" value="{{ old('due_date') }}" class="portal-input" required>
                        <x-input-error :messages="$errors->get('due_date')" class="mt-2" />
                    </div>
                    <div>
                        <label for="status" class="portal-label">الحالة</label>
                        <select id="status" name="status" class="portal-input" required>
                            <option value="pending" @selected(old('status', 'pending') === 'pending')>قيد الانتظار</option>
                            <option value="paid" @selected(old('status') === 'paid')>مدفوع</option>
                            <option value="overdue" @selected(old('status') === 'overdue')>متأخر</option>
                        </select>
                        <x-input-error :messages="$errors->get('status')" class="mt-2" />
                    </div>
                </div>

                <div class="flex justify-end gap-3">
                    <a href="{{ route('admin.invoices.index') }}" class="portal-button-secondary">إلغاء</a>
                    <button class="portal-button">إنشاء الفاتورة</button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
