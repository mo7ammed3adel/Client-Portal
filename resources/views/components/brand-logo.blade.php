@props(['chip' => false, 'class' => 'h-10'])

@if ($chip)
    <span class="inline-flex items-center justify-center rounded-xl bg-white p-1.5 shadow-sm">
        <img src="{{ asset('brand/logo.png') }}" alt="مكتب طلبة" {{ $attributes->merge(['class' => $class]) }}>
    </span>
@else
    <img src="{{ asset('brand/logo.png') }}" alt="مكتب طلبة" {{ $attributes->merge(['class' => $class]) }}>
@endif
