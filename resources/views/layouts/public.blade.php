<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ? $title.' · مكتب طلبة' : 'مكتب طلبة · شحن وتوصيل داخل الدقهلية' }}</title>
    <meta name="description" content="مكتب طلبة للشحن والتوصيل السريع داخل محافظة الدقهلية. احسب تكلفة الشحن حسب المسافة على الخريطة، ادفع أونلاين، وأرسل شحنتك في دقائق.">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=tajawal:400,500,700,800,900&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="font-sans antialiased bg-white text-slate-800">
    <a href="#main" class="sr-only focus:not-sr-only focus:absolute focus:z-[100] focus:m-3 focus:rounded-lg focus:bg-brand-600 focus:px-4 focus:py-2 focus:text-white">تجاوز إلى المحتوى</a>

    @include('layouts.partials.public-nav')

    <main id="main">
        {{ $slot }}
    </main>

    @include('layouts.partials.public-footer')

    @stack('scripts')

    <script>
        // Scroll reveal animations
        document.addEventListener('DOMContentLoaded', () => {
            const reveals = document.querySelectorAll('.reveal');
            if (!('IntersectionObserver' in window) || reveals.length === 0) {
                reveals.forEach((el) => el.classList.add('is-visible'));
                return;
            }
            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.12 });
            reveals.forEach((el) => observer.observe(el));
        });
    </script>
</body>
</html>
