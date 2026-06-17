{{-- Original navy + orange delivery scooter (vector, sharp at any size) --}}
<svg viewBox="0 0 600 420" class="w-full" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="موتوسيكل توصيل طلبة">
    <defs>
        <linearGradient id="boxG" x1="0" y1="0" x2="0" y2="1">
            <stop offset="0" stop-color="#fb963a"/><stop offset="1" stop-color="#e8650a"/>
        </linearGradient>
        <linearGradient id="bodyG" x1="0" y1="0" x2="0" y2="1">
            <stop offset="0" stop-color="#316fbd"/><stop offset="1" stop-color="#1f56a0"/>
        </linearGradient>
    </defs>

    {{-- ground --}}
    <ellipse cx="300" cy="360" rx="240" ry="20" fill="#1f56a0" opacity="0.10"/>

    {{-- motion lines --}}
    <g stroke="#e8650a" stroke-width="7" stroke-linecap="round" opacity="0.7">
        <path d="M70 150h70"><animate attributeName="opacity" values="0;.8;0" dur="1.1s" repeatCount="indefinite"/></path>
        <path d="M40 185h95"><animate attributeName="opacity" values="0;.8;0" dur="1.1s" begin=".25s" repeatCount="indefinite"/></path>
        <path d="M70 220h70"><animate attributeName="opacity" values="0;.8;0" dur="1.1s" begin=".5s" repeatCount="indefinite"/></path>
    </g>

    {{-- delivery box --}}
    <rect x="150" y="120" width="120" height="100" rx="12" fill="url(#boxG)"/>
    <path d="M210 120v100M150 170h120" stroke="#7c3711" stroke-width="3" opacity="0.55"/>
    <rect x="186" y="146" width="48" height="20" rx="4" fill="#fff" opacity="0.9"/>

    {{-- scooter body --}}
    <path d="M150 250 q-8-40 28-44 l60 0 q40 0 60 34 l40 10 60 0" fill="none" stroke="url(#bodyG)" stroke-width="16" stroke-linecap="round" stroke-linejoin="round"/>
    <path d="M398 250 q40-2 70-40 l28 0 q14 0 12 16 l-6 28" fill="url(#bodyG)"/>
    {{-- front shield --}}
    <path d="M470 210 q26-4 30 30 l4 26" fill="none" stroke="url(#bodyG)" stroke-width="14" stroke-linecap="round"/>
    {{-- handlebar --}}
    <path d="M486 190 l34-16" stroke="#213a61" stroke-width="9" stroke-linecap="round"/>
    <circle cx="524" cy="172" r="7" fill="#e8650a"/>
    {{-- seat --}}
    <path d="M250 246 q60-6 96 2" stroke="#14233f" stroke-width="14" stroke-linecap="round"/>

    {{-- headlight --}}
    <circle cx="506" cy="232" r="9" fill="#fdbd72"/>

    {{-- wheels --}}
    <g>
        <circle cx="198" cy="296" r="50" fill="#14233f"/>
        <circle cx="198" cy="296" r="24" fill="#5690d3"/>
        <circle cx="198" cy="296" r="9" fill="#fff"/>
        <circle cx="446" cy="296" r="50" fill="#14233f"/>
        <circle cx="446" cy="296" r="24" fill="#5690d3"/>
        <circle cx="446" cy="296" r="9" fill="#fff"/>
    </g>
</svg>
