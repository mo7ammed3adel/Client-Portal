<x-app-layout>
    <x-slot name="header">
        <div dir="rtl" class="text-right">
            <p class="text-sm font-semibold text-blue-500">الشروط والأحكام</p>
            <h1 class="mt-1 text-2xl font-black text-slate-950 dark:text-white">سياسات التعامل</h1>
        </div>
    </x-slot>

    <div dir="rtl" class="mx-auto max-w-5xl px-4 py-8 text-right sm:px-6 lg:px-8">
        <div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_320px]">
            <section class="space-y-5 rounded-lg border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <article class="space-y-3">
                    <h2 class="text-xl font-black text-slate-950 dark:text-white">نبذة عن المنصة</h2>
                    <p class="leading-8 text-slate-700 dark:text-slate-300">
                        هذه المنصة مخصصة لتسهيل عمليات السداد والتحصيل المالي بين شركة التوصيل والعملاء المتعاقدين معها، مثل المطاعم والمتاجر والسوبر ماركت.
                    </p>
                    <p class="leading-8 text-slate-700 dark:text-slate-300">
                        لا تقدم المنصة خدمات بيع أو شراء المنتجات بشكل مباشر، وإنما تُستخدم فقط كوسيلة إلكترونية لإدارة وتسوية مستحقات خدمات التوصيل المقدمة من شركة التوصيل للعملاء المتعاقدين معها بموجب عقود واتفاقيات مستقلة.
                    </p>
                </article>

                <article class="space-y-3 border-t border-slate-200 pt-5 dark:border-slate-800">
                    <h2 class="text-xl font-black text-slate-950 dark:text-white">الهدف من المنصة</h2>
                    <ul class="space-y-2 text-slate-700 dark:text-slate-300">
                        <li>تسهيل عمليات الدفع والتحصيل المالي.</li>
                        <li>تقليل التعاملات النقدية المباشرة.</li>
                        <li>توفير سجل إلكتروني واضح للمدفوعات والمعاملات المالية.</li>
                        <li>تحسين كفاءة إدارة مستحقات خدمات التوصيل.</li>
                    </ul>
                </article>

                <article class="space-y-3 border-t border-slate-200 pt-5 dark:border-slate-800">
                    <h2 class="text-xl font-black text-slate-950 dark:text-white">سياسة التعامل</h2>
                    <ul class="space-y-2 text-slate-700 dark:text-slate-300">
                        <li>استخدام المنصة متاح فقط للعملاء المتعاقدين مع الشركة.</li>
                        <li>جميع الخدمات المقدمة تخضع للعقود والاتفاقيات المبرمة بين الشركة والعميل.</li>
                        <li>لا تعتبر المنصة طرفاً في عمليات بيع المنتجات أو الخدمات الخاصة بالعميل النهائي.</li>
                    </ul>
                </article>

                <article class="space-y-3 border-t border-slate-200 pt-5 dark:border-slate-800">
                    <h2 class="text-xl font-black text-slate-950 dark:text-white">سياسة الاسترجاع</h2>
                    <p class="leading-8 text-slate-700 dark:text-slate-300">
                        نظراً لأن المدفوعات التي تتم عبر المنصة تمثل تسوية لمستحقات خدمات التوصيل المتفق عليها تعاقدياً، فإن أي طلبات استرداد أو تسوية مالية يتم مراجعتها وفقاً للعقد المبرم بين الشركة والعميل، وبعد التحقق من أسباب الطلب والمستندات الداعمة له.
                    </p>
                    <p class="leading-8 text-slate-700 dark:text-slate-300">
                        لأي استفسارات أو طلبات متعلقة بالمدفوعات، يمكن التواصل مع إدارة الشركة عبر وسائل التواصل المعتمدة.
                    </p>
                </article>
            </section>

            <aside class="space-y-4">
                <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                    <h2 class="text-lg font-black text-slate-950 dark:text-white">بيانات التواصل</h2>
                    <div class="mt-4 space-y-4">
                        <div>
                            <p class="text-sm font-semibold text-slate-500 dark:text-slate-400">البريد الإلكتروني</p>
                            <a href="mailto:melsaprot2001@gmail.com" class="mt-1 block break-all text-base font-bold text-blue-600 dark:text-blue-300">
                                melsaprot2001@gmail.com
                            </a>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-500 dark:text-slate-400">رقم التواصل</p>
                            <a href="tel:01068851272" dir="ltr" class="mt-1 block text-base font-bold text-blue-600 dark:text-blue-300">
                                01068851272
                            </a>
                        </div>
                    </div>
                </div>

                <div class="rounded-lg border border-blue-200 bg-blue-50 p-5 text-blue-950 dark:border-blue-900/60 dark:bg-blue-950/30 dark:text-blue-100">
                    <p class="text-sm leading-7">
                        المنصة مخصصة لإدارة وتسوية مستحقات خدمات التوصيل فقط، ولا تمثل سوقاً لبيع أو شراء المنتجات.
                    </p>
                </div>
            </aside>
        </div>
    </div>
</x-app-layout>
