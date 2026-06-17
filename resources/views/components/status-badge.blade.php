@props(['status'])

@php
    $classes = [
        'pending' => 'border-amber-200 bg-amber-50 text-amber-700 dark:border-amber-900/60 dark:bg-amber-950/40 dark:text-amber-300',
        'in_progress' => 'border-blue-200 bg-blue-50 text-blue-700 dark:border-blue-900/60 dark:bg-blue-950/40 dark:text-blue-300',
        'completed' => 'border-emerald-200 bg-emerald-50 text-emerald-700 dark:border-emerald-900/60 dark:bg-emerald-950/40 dark:text-emerald-300',
        'paid' => 'border-emerald-200 bg-emerald-50 text-emerald-700 dark:border-emerald-900/60 dark:bg-emerald-950/40 dark:text-emerald-300',
        'overdue' => 'border-red-200 bg-red-50 text-red-700 dark:border-red-900/60 dark:bg-red-950/40 dark:text-red-300',
    ];
    $labels = [
        'pending' => 'قيد الانتظار',
        'in_progress' => 'قيد التنفيذ',
        'completed' => 'مكتمل',
        'paid' => 'مدفوع',
        'overdue' => 'متأخر',
    ];
    $label = $labels[$status] ?? \Illuminate\Support\Str::headline($status);
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center rounded-lg border px-2.5 py-1 text-xs font-bold '.($classes[$status] ?? 'border-slate-200 bg-slate-50 text-slate-600')]) }}>
    {{ $label }}
</span>
