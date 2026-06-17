<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="portal-title">الإعدادات</h1>
            <p class="portal-muted mt-1">تحكّم في أسعار التوصيل ومحتوى الموقع وبيانات التواصل.</p>
        </div>
    </x-slot>

    <div class="portal-container max-w-4xl">
        @if (session('status'))
            <div class="mb-5 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700 dark:border-emerald-900 dark:bg-emerald-950/40 dark:text-emerald-300">
                {{ session('status') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="mb-5 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-700">
                <ul class="list-disc space-y-1 pe-5">
                    @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-6">
            @csrf
            @method('PATCH')

            {{-- Pricing --}}
            <div class="portal-card">
                <div class="border-b border-slate-100 px-5 py-4 dark:border-slate-800">
                    <h2 class="font-bold text-slate-950 dark:text-white">تسعير التوصيل</h2>
                    <p class="portal-muted mt-1">التكلفة = الرسوم الأساسية (تغطي أول مسافة محددة) + (الكيلومترات الإضافية × سعر الكيلومتر). مثال: 20ج لأول 2 كم ثم 10ج لكل كم إضافي.</p>
                </div>
                <div class="portal-card-body grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                    <div>
                        <label class="portal-label">الرسوم الأساسية (جنيه)</label>
                        <input type="number" step="0.01" min="0" name="base_fee" value="{{ old('base_fee', $settings['base_fee']) }}" class="portal-input" required>
                    </div>
                    <div>
                        <label class="portal-label">المسافة المشمولة بالرسوم (كم)</label>
                        <input type="number" step="0.01" min="0" name="base_distance_km" value="{{ old('base_distance_km', $settings['base_distance_km']) }}" class="portal-input" required>
                    </div>
                    <div>
                        <label class="portal-label">سعر الكيلومتر الإضافي (جنيه)</label>
                        <input type="number" step="0.01" min="0" name="cost_per_km" value="{{ old('cost_per_km', $settings['cost_per_km']) }}" class="portal-input" required>
                    </div>
                    <div>
                        <label class="portal-label">حد أدنى للطلب (جنيه)</label>
                        <input type="number" step="0.01" min="0" name="min_order_cost" value="{{ old('min_order_cost', $settings['min_order_cost']) }}" class="portal-input" required>
                    </div>
                </div>
            </div>

            {{-- Contact details --}}
            <div class="portal-card">
                <div class="border-b border-slate-100 px-5 py-4 dark:border-slate-800">
                    <h2 class="font-bold text-slate-950 dark:text-white">بيانات التواصل</h2>
                </div>
                <div class="portal-card-body grid gap-5 sm:grid-cols-2">
                    <div>
                        <label class="portal-label">هاتف الدعم</label>
                        <input type="text" name="contact_phone" value="{{ old('contact_phone', $settings['contact_phone']) }}" class="portal-input" dir="ltr">
                    </div>
                    <div>
                        <label class="portal-label">واتساب</label>
                        <input type="text" name="contact_whatsapp" value="{{ old('contact_whatsapp', $settings['contact_whatsapp']) }}" class="portal-input" dir="ltr">
                    </div>
                    <div>
                        <label class="portal-label">البريد الإلكتروني</label>
                        <input type="text" name="contact_email" value="{{ old('contact_email', $settings['contact_email']) }}" class="portal-input" dir="ltr">
                    </div>
                    <div>
                        <label class="portal-label">مواعيد العمل</label>
                        <input type="text" name="contact_hours" value="{{ old('contact_hours', $settings['contact_hours']) }}" class="portal-input">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="portal-label">العنوان</label>
                        <input type="text" name="contact_address" value="{{ old('contact_address', $settings['contact_address']) }}" class="portal-input">
                    </div>
                </div>
            </div>

            {{-- About content --}}
            <div class="portal-card">
                <div class="border-b border-slate-100 px-5 py-4 dark:border-slate-800">
                    <h2 class="font-bold text-slate-950 dark:text-white">محتوى صفحة "من نحن"</h2>
                </div>
                <div class="portal-card-body space-y-5">
                    <div>
                        <label class="portal-label">مقدمة المكتب</label>
                        <textarea name="about_intro" rows="3" class="portal-input">{{ old('about_intro', $settings['about_intro']) }}</textarea>
                    </div>
                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <label class="portal-label">الرؤية</label>
                            <textarea name="about_vision" rows="3" class="portal-input">{{ old('about_vision', $settings['about_vision']) }}</textarea>
                        </div>
                        <div>
                            <label class="portal-label">الرسالة</label>
                            <textarea name="about_mission" rows="3" class="portal-input">{{ old('about_mission', $settings['about_mission']) }}</textarea>
                        </div>
                    </div>
                    <div>
                        <label class="portal-label">شروط التعاون (كل سطر بند)</label>
                        <textarea name="about_terms" rows="6" class="portal-input">{{ old('about_terms', $settings['about_terms']) }}</textarea>
                    </div>
                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <label class="portal-label">هاتف رسمي (صفحة من نحن)</label>
                            <input type="text" name="about_phone" value="{{ old('about_phone', $settings['about_phone']) }}" class="portal-input" dir="ltr">
                        </div>
                        <div>
                            <label class="portal-label">بريد رسمي (صفحة من نحن)</label>
                            <input type="text" name="about_email" value="{{ old('about_email', $settings['about_email']) }}" class="portal-input" dir="ltr">
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button class="portal-button px-8">حفظ الإعدادات</button>
            </div>
        </form>
    </div>
</x-app-layout>
