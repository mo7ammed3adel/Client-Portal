<x-public-layout title="السياسات والشروط">
    @php
        $base = rtrim(rtrim(number_format($baseFee, 2), '0'), '.');
        $baseKm = rtrim(rtrim(number_format($baseDistanceKm, 2), '0'), '.');
        $rate = rtrim(rtrim(number_format($costPerKm, 2), '0'), '.');
        $sections = [
            'scope' => 'نطاق الخدمة',
            'terms' => 'الشروط والأحكام',
            'payment' => 'سياسة الدفع',
            'refund' => 'سياسة الإلغاء والاسترجاع',
            'delivery' => 'سياسة التوصيل',
            'prohibited' => 'الشحنات الممنوعة',
            'privacy' => 'سياسة الخصوصية',
            'contact' => 'التواصل والشكاوى',
        ];
    @endphp

    {{-- Header --}}
    <section class="relative overflow-hidden bg-ink-900 py-16 text-white">
        <div class="hex absolute -right-10 -top-10 h-44 w-44 bg-brand-500/15"></div>
        <div class="section relative text-center">
            <span class="chip mx-auto border-white/15 bg-white/10 text-brand-200">سياسات الاستخدام</span>
            <h1 class="mt-5 text-4xl font-black sm:text-5xl">السياسات والشروط</h1>
            <p class="mx-auto mt-4 max-w-2xl text-slate-300">سياسات مكتب طلبة للشحن والتوصيل الداخلي في محافظة الدقهلية. آخر تحديث: {{ now()->translatedFormat('F Y') }}.</p>
        </div>
    </section>

    <section class="bg-white py-14">
        <div class="section grid gap-10 lg:grid-cols-4">
            {{-- TOC --}}
            <aside class="lg:col-span-1">
                <div class="lg:sticky lg:top-24 rounded-2xl border border-slate-100 bg-slate-50/60 p-5">
                    <p class="text-sm font-black text-ink-900">المحتويات</p>
                    <ul class="mt-3 space-y-2 text-sm">
                        @foreach ($sections as $id => $label)
                            <li><a href="#{{ $id }}" class="text-slate-500 hover:font-bold hover:text-brand-700">{{ $label }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </aside>

            {{-- Body --}}
            <div class="space-y-10 lg:col-span-3">
                <section id="scope" class="scroll-mt-24">
                    <h2 class="text-2xl font-black text-ink-900">١. نطاق الخدمة</h2>
                    <div class="mt-3 space-y-3 leading-8 text-slate-600">
                        <p>مكتب طلبة هو مكتب خدمات شحن وتوصيل يعمل داخل <span class="font-bold text-ink-900">محافظة الدقهلية فقط</span>، ومقره الرئيسي والوحيد في <span class="font-bold text-ink-900">بلقاس - الدقهلية</span>. نقدّم خدمة استلام الشحنات من المرسِل وتوصيلها إلى المستلِم داخل مراكز ومدن المحافظة.</p>
                        <p>لا يقدّم المكتب أي خدمات شحن خارج محافظة الدقهلية، ولا خدمات شحن دولي أو بحري أو جوي.</p>
                    </div>
                </section>

                <section id="terms" class="scroll-mt-24">
                    <h2 class="text-2xl font-black text-ink-900">٢. الشروط والأحكام</h2>
                    <ul class="mt-3 list-disc space-y-2 pe-5 leading-8 text-slate-600">
                        <li>باستخدامك للموقع وإنشاء طلب، فإنك توافق على هذه الشروط بالكامل.</li>
                        <li>يلتزم العميل بإدخال بيانات صحيحة وكاملة للمرسِل والمستلِم وعنواني الاستلام والتسليم.</li>
                        <li>يتحمّل العميل مسؤولية صحة محتوى الشحنة ومطابقتها للقوانين المعمول بها.</li>
                        <li>يحق للمكتب رفض أو إلغاء أي طلب يخالف هذه السياسات مع رد المبلغ المدفوع إن وُجد.</li>
                        <li>الأسعار وشروط الخدمة قابلة للتعديل، ويُعمل بالسعر المعروض وقت إتمام الطلب.</li>
                    </ul>
                </section>

                <section id="payment" class="scroll-mt-24">
                    <h2 class="text-2xl font-black text-ink-900">٣. سياسة الدفع والتسعير</h2>
                    <div class="mt-3 space-y-3 leading-8 text-slate-600">
                        <p>تُحسب تكلفة الشحن تلقائيًا حسب المسافة على الخريطة كالتالي: <span class="font-bold text-ink-900">{{ $base }} جنيهًا لأول {{ $baseKm }} كيلومتر، ثم {{ $rate }} جنيهات عن كل كيلومتر إضافي</span>. ويظهر الإجمالي بوضوح قبل الدفع.</p>
                        <p>تتم جميع المدفوعات إلكترونيًا بالجنيه المصري (EGP) عبر بوابة الدفع الإلكتروني الآمنة <span class="font-bold text-ink-900">Kashier</span>، باستخدام البطاقات البنكية أو المحافظ الإلكترونية.</p>
                        <p>لا يتم إنشاء الطلب أو تأكيده إلا بعد نجاح عملية الدفع. في حال فشل الدفع لا يُخصم أي مبلغ ولا يُنشأ طلب.</p>
                    </div>
                </section>

                <section id="refund" class="scroll-mt-24">
                    <h2 class="text-2xl font-black text-ink-900">٤. سياسة الإلغاء والاسترجاع</h2>
                    <ul class="mt-3 list-disc space-y-2 pe-5 leading-8 text-slate-600">
                        <li>يمكن للعميل طلب إلغاء الطلب قبل استلام المندوب للشحنة، ويُسترد كامل المبلغ المدفوع.</li>
                        <li>إذا تعذّر تنفيذ التوصيل لسبب يخص المكتب، يُسترد كامل قيمة الطلب.</li>
                        <li>تتم عمليات الاسترداد إلى نفس وسيلة الدفع المستخدمة خلال مدة من <span class="font-bold text-ink-900">٧ إلى ١٤ يوم عمل</span> حسب إجراءات البنك وبوابة الدفع.</li>
                        <li>بعد استلام المندوب للشحنة وبدء التوصيل، لا يمكن استرداد قيمة خدمة التوصيل المنفّذة.</li>
                        <li>لطلب الإلغاء أو الاسترجاع، تواصل مع خدمة العملاء عبر بيانات التواصل أدناه مع ذكر رقم التتبع.</li>
                    </ul>
                </section>

                <section id="delivery" class="scroll-mt-24">
                    <h2 class="text-2xl font-black text-ink-900">٥. سياسة التوصيل</h2>
                    <div class="mt-3 space-y-3 leading-8 text-slate-600">
                        <p>نلتزم بتوصيل الشحنة في أسرع وقت ممكن داخل محافظة الدقهلية مع الحفاظ على سلامتها.</p>
                        <p>يتم تأكيد الاستلام والتسليم عبر كود تحقّق (OTP) يضمن وصول الشحنة إلى الشخص الصحيح. ويمكن للعميل متابعة حالة الشحنة لحظيًا عبر صفحة التتبع برقم التتبع الخاص به.</p>
                        <p>قد تتأثر مواعيد التوصيل بالظروف الجوية أو المرورية أو القوة القاهرة.</p>
                    </div>
                </section>

                <section id="prohibited" class="scroll-mt-24">
                    <h2 class="text-2xl font-black text-ink-900">٦. الشحنات الممنوعة</h2>
                    <p class="mt-3 leading-8 text-slate-600">يُمنع شحن أي مواد مخالفة للقانون أو خطرة، ومنها على سبيل المثال: المواد المخدرة أو المحظورة، الأسلحة والذخائر، المواد القابلة للاشتعال أو الانفجار، الأموال النقدية، والمواد المخالفة للآداب العامة. ويتحمّل المرسِل المسؤولية القانونية الكاملة عن مخالفة ذلك.</p>
                </section>

                <section id="privacy" class="scroll-mt-24">
                    <h2 class="text-2xl font-black text-ink-900">٧. سياسة الخصوصية</h2>
                    <ul class="mt-3 list-disc space-y-2 pe-5 leading-8 text-slate-600">
                        <li>نجمع البيانات اللازمة لتنفيذ الخدمة فقط (الأسماء، أرقام الهواتف، العناوين، وتفاصيل الطلب).</li>
                        <li>لا تتم معالجة أو تخزين بيانات البطاقات البنكية لدينا؛ تتم المدفوعات بالكامل عبر بوابة Kashier الآمنة.</li>
                        <li>لا نشارك بياناتك مع أي طرف ثالث إلا بالقدر اللازم لتنفيذ التوصيل أو حسب ما يقتضيه القانون.</li>
                        <li>نتّخذ إجراءات معقولة لحماية بياناتك، ويحق للعميل طلب تعديل أو حذف بياناته.</li>
                    </ul>
                </section>

                <section id="contact" class="scroll-mt-24">
                    <h2 class="text-2xl font-black text-ink-900">٨. التواصل والشكاوى</h2>
                    <div class="mt-3 rounded-2xl border border-slate-100 bg-slate-50/60 p-5 leading-8 text-slate-600">
                        <p>لأي استفسار أو شكوى تواصل معنا:</p>
                        <p class="mt-2">الهاتف / واتساب: <span class="font-bold text-ink-900" dir="ltr">{{ $content['contact_phone'] }}</span></p>
                        <p>البريد الإلكتروني: <span class="font-bold text-ink-900" dir="ltr">{{ $content['contact_email'] }}</span></p>
                        <p>العنوان: <span class="font-bold text-ink-900">{{ $content['contact_address'] }}</span></p>
                        <p>مواعيد العمل: <span class="font-bold text-ink-900">{{ $content['contact_hours'] }}</span></p>
                        <a href="{{ route('contact') }}" class="btn-brand mt-4">إرسال رسالة</a>
                    </div>
                </section>
            </div>
        </div>
    </section>
</x-public-layout>
