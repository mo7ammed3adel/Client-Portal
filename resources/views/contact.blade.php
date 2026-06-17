<x-public-layout title="تواصل معنا">
    <section class="relative overflow-hidden bg-ink-900 py-20 text-white">
        <div class="absolute -left-24 -top-20 h-80 w-80 rounded-full bg-brand-500/20 blur-3xl animate-float"></div>
        <div class="section relative text-center">
            <span class="chip mx-auto border-white/15 bg-white/10 text-brand-200">تواصل معنا</span>
            <h1 class="mt-5 text-4xl font-black sm:text-5xl">احنا هنا لمساعدتك</h1>
            <p class="mx-auto mt-5 max-w-2xl text-lg leading-8 text-slate-300">عندك سؤال أو طلب خاص؟ ابعتلنا رسالة وفريق الدعم هيرد عليك في أقرب وقت.</p>
        </div>
    </section>

    <section class="bg-white py-20">
        <div class="section grid gap-10 lg:grid-cols-5">
            {{-- Contact info --}}
            <div class="reveal lg:col-span-2">
                <h2 class="text-2xl font-black text-ink-900">معلومات التواصل</h2>
                <p class="mt-3 leading-8 text-slate-500">يمكنك التواصل معنا مباشرة عبر القنوات التالية.</p>
                <div class="mt-8 space-y-5">
                    @php
                        $channels = [
                            ['l' => 'خط خدمة العملاء', 'v' => $content['contact_phone'], 'dir' => 'ltr', 'i' => 'M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z'],
                            ['l' => 'واتساب', 'v' => $content['contact_whatsapp'], 'dir' => 'ltr', 'i' => 'M8.625 9.75a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a5.969 5.969 0 0 1-.474-.065 4.48 4.48 0 0 0 .978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z'],
                            ['l' => 'البريد الإلكتروني', 'v' => $content['contact_email'], 'dir' => 'ltr', 'i' => 'M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75'],
                            ['l' => 'العنوان', 'v' => $content['contact_address'], 'dir' => 'rtl', 'i' => 'M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z'],
                            ['l' => 'مواعيد العمل', 'v' => $content['contact_hours'], 'dir' => 'rtl', 'i' => 'M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z'],
                        ];
                    @endphp
                    @foreach ($channels as $c)
                        <div class="flex items-center gap-4 rounded-2xl border border-slate-100 bg-slate-50/60 p-4">
                            <div class="grid h-11 w-11 shrink-0 place-items-center rounded-xl bg-brand-100 text-brand-700">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $c['i'] }}"/></svg>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400">{{ $c['l'] }}</p>
                                <p class="font-bold text-ink-900" dir="{{ $c['dir'] }}">{{ $c['v'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Contact form --}}
            <div class="reveal lg:col-span-3">
                <div class="rounded-3xl border border-slate-100 bg-white p-6 shadow-lg shadow-slate-900/5 sm:p-8">
                    @if (session('status'))
                        <div x-data="{ show: true }" x-show="show" class="mb-6 flex items-start gap-3 rounded-2xl border border-brand-200 bg-brand-50 p-4 text-brand-800">
                            <svg class="mt-0.5 h-6 w-6 shrink-0 text-brand-600" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                            <div>
                                <p class="font-black">تم الإرسال بنجاح</p>
                                <p class="mt-1 text-sm">{{ session('status') }}</p>
                            </div>
                            <button @click="show = false" class="mr-auto text-brand-600 hover:text-brand-800" aria-label="إغلاق">&times;</button>
                        </div>
                    @endif

                    <h2 class="text-2xl font-black text-ink-900">أرسل لنا رسالة</h2>
                    <p class="mt-2 text-sm text-slate-500">املأ البيانات وسنعاود التواصل معك.</p>

                    <form method="POST" action="{{ route('contact.store') }}" class="mt-6 space-y-5">
                        @csrf
                        <div>
                            <label for="name" class="field-label">الاسم بالكامل</label>
                            <input id="name" name="name" type="text" value="{{ old('name') }}" required class="field" placeholder="اكتب اسمك">
                            @error('name') <p class="mt-1.5 text-sm font-semibold text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div class="grid gap-5 sm:grid-cols-2">
                            <div>
                                <label for="email" class="field-label">البريد الإلكتروني</label>
                                <input id="email" name="email" type="email" value="{{ old('email') }}" required class="field" placeholder="name@example.com" dir="ltr">
                                @error('email') <p class="mt-1.5 text-sm font-semibold text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="phone" class="field-label">رقم الهاتف</label>
                                <input id="phone" name="phone" type="tel" value="{{ old('phone') }}" required class="field" placeholder="01xxxxxxxxx" dir="ltr">
                                @error('phone') <p class="mt-1.5 text-sm font-semibold text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <div>
                            <label for="message" class="field-label">سبب التواصل / رسالتك</label>
                            <textarea id="message" name="message" rows="5" required class="field" placeholder="اكتب استفسارك أو طلبك بالتفصيل...">{{ old('message') }}</textarea>
                            @error('message') <p class="mt-1.5 text-sm font-semibold text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <button class="btn-brand w-full justify-center py-3.5 text-base">
                            إرسال الرسالة
                            <svg class="h-5 w-5 rtl:-scale-x-100" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5"/></svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</x-public-layout>
