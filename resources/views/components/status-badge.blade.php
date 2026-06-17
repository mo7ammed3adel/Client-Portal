@props(['status'])

@php
    $classes = [
        'pending_payment' => 'border-slate-200 bg-slate-50 text-slate-600 dark:border-slate-800 dark:bg-slate-900 dark:text-slate-300',
        'confirmed' => 'border-blue-200 bg-blue-50 text-blue-700 dark:border-blue-900/60 dark:bg-blue-950/40 dark:text-blue-300',
        'processing' => 'border-amber-200 bg-amber-50 text-amber-700 dark:border-amber-900/60 dark:bg-amber-950/40 dark:text-amber-300',
        'out_for_delivery' => 'border-indigo-200 bg-indigo-50 text-indigo-700 dark:border-indigo-900/60 dark:bg-indigo-950/40 dark:text-indigo-300',
        'delivered' => 'border-emerald-200 bg-emerald-50 text-emerald-700 dark:border-emerald-900/60 dark:bg-emerald-950/40 dark:text-emerald-300',
        'cancelled' => 'border-red-200 bg-red-50 text-red-700 dark:border-red-900/60 dark:bg-red-950/40 dark:text-red-300',
        'new' => 'border-brand-200 bg-brand-50 text-brand-700 dark:border-brand-900/60 dark:bg-brand-950/40 dark:text-brand-300',
        'reviewed' => 'border-blue-200 bg-blue-50 text-blue-700 dark:border-blue-900/60 dark:bg-blue-950/40 dark:text-blue-300',
        'closed' => 'border-slate-200 bg-slate-50 text-slate-600 dark:border-slate-800 dark:bg-slate-900 dark:text-slate-300',
    ];
    $labels = [
        'pending_payment' => 'بانتظار الدفع',
        'confirmed' => 'تم التأكيد',
        'processing' => 'قيد التجهيز',
        'out_for_delivery' => 'في الطريق',
        'delivered' => 'تم التسليم',
        'cancelled' => 'ملغي',
        'new' => 'جديدة',
        'reviewed' => 'تمت المراجعة',
        'closed' => 'مغلقة',
    ];
    $label = $labels[$status] ?? \Illuminate\Support\Str::headline($status);
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center rounded-lg border px-2.5 py-1 text-xs font-bold '.($classes[$status] ?? 'border-slate-200 bg-slate-50 text-slate-600')]) }}>
    {{ $label }}
</span>
