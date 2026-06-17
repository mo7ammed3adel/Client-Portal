{{-- طلبة brand mark: rounded badge with a delivery pin + package --}}
<span {{ $attributes->merge(['class' => 'inline-grid place-items-center']) }}>
    <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-full w-full">
        <defs>
            <linearGradient id="talbaGrad" x1="0" y1="0" x2="48" y2="48" gradientUnits="userSpaceOnUse">
                <stop stop-color="#14abb5" />
                <stop offset="1" stop-color="#0e8b95" />
            </linearGradient>
        </defs>
        <rect width="48" height="48" rx="13" fill="url(#talbaGrad)" />
        <path d="M24 10c-5.247 0-9.5 4.06-9.5 9.07 0 6.34 7.86 14.93 9.1 16.25.214.228.486.34.4.34s.186-.112.4-.34c1.24-1.32 9.1-9.91 9.1-16.25C33.5 14.06 29.247 10 24 10Z" fill="#fff" fill-opacity="0.18"/>
        <path d="m24 16-6 3.2v6.4c0 .43.23.83.6 1.04L24 30l5.4-3.36c.37-.21.6-.61.6-1.04v-6.4L24 16Z" fill="#ffffff"/>
        <path d="m18 19.2 6 3.2 6-3.2M24 22.4V30" stroke="#0e8b95" stroke-width="1.4" stroke-linejoin="round"/>
        <circle cx="24" cy="19.2" r="1.5" fill="#14abb5"/>
    </svg>
</span>
