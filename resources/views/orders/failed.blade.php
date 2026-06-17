<x-public-layout title="لم يكتمل الدفع">
    <section class="bg-slate-50 py-16 lg:py-24">
        <div class="section max-w-xl">
            <div class="reveal is-visible rounded-3xl border border-slate-100 bg-white p-8 text-center shadow-xl shadow-slate-900/5 sm:p-10">
                <div class="mx-auto grid h-16 w-16 place-items-center rounded-full bg-amber-100 text-amber-600">
                    <svg class="h-9 w-9" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z"/></svg>
                </div>
                <h1 class="mt-5 text-2xl font-black text-ink-900">لم يكتمل الدفع</h1>
                <p class="mt-3 leading-7 text-slate-500">
                    لم نتمكن من تأكيد عملية الدفع، لذلك <span class="font-bold text-ink-900">لم يتم إنشاء الطلب</span>.
                    لا تقلق — لم يتم خصم أي مبلغ في حال فشل العملية. يمكنك إعادة المحاولة.
                </p>

                <div class="mt-7 flex flex-col gap-3 sm:flex-row">
                    @if ($order)
                        <form action="{{ route('order.retry', $order) }}" method="POST" class="flex-1">
                            @csrf
                            <button class="btn-brand w-full justify-center py-3.5">إعادة محاولة الدفع</button>
                        </form>
                    @else
                        <a href="{{ route('order.create') }}" class="btn-brand flex-1 justify-center py-3.5">إنشاء طلب جديد</a>
                    @endif
                    <a href="{{ route('home') }}" class="btn-outline flex-1 justify-center py-3.5">العودة للرئيسية</a>
                </div>

                <p class="mt-6 text-sm text-slate-400">واجهت مشكلة؟ <a href="{{ route('contact') }}" class="font-bold text-brand-600 hover:underline">تواصل مع الدعم</a></p>
            </div>
        </div>
    </section>
</x-public-layout>
