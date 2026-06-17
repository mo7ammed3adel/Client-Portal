{{-- Delivery van / truck illustration --}}
<div class="relative mx-auto max-w-md">
    <div class="absolute inset-8 rounded-full bg-brand-500/20 blur-3xl"></div>
    <svg viewBox="0 0 440 320" class="relative w-full" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="شاحنة توصيل">
        <defs>
            <linearGradient id="van" x1="0" y1="0" x2="0" y2="1">
                <stop offset="0" stop-color="#ffffff"/><stop offset="1" stop-color="#e2e8f0"/>
            </linearGradient>
            <linearGradient id="cab" x1="0" y1="0" x2="1" y2="1">
                <stop offset="0" stop-color="#34d399"/><stop offset="1" stop-color="#059669"/>
            </linearGradient>
        </defs>

        {{-- floating packages --}}
        <g class="animate-float">
            <rect x="40" y="40" width="56" height="48" rx="8" fill="#10b981"/>
            <path d="M68 40v48M40 64h56" stroke="#065f46" stroke-width="2.5"/>
        </g>
        <g class="animate-float-slow">
            <rect x="350" y="60" width="44" height="38" rx="7" fill="#a7f3d0"/>
            <path d="M372 60v38M350 79h44" stroke="#059669" stroke-width="2"/>
        </g>

        {{-- ground --}}
        <ellipse cx="220" cy="280" rx="180" ry="16" fill="#0b1f3a" opacity="0.08"/>

        {{-- van body --}}
        <g transform="translate(70,130)">
            <rect x="0" y="20" width="190" height="110" rx="14" fill="url(#van)" stroke="#cbd5e1" stroke-width="2"/>
            {{-- cab --}}
            <path d="M190 40 H250 L290 84 V130 H190 Z" fill="url(#cab)"/>
            <path d="M205 52 H243 L268 84 H205 Z" fill="#d1fae7" opacity="0.85"/>
            {{-- door line + handle --}}
            <path d="M95 28V128" stroke="#cbd5e1" stroke-width="2"/>
            <rect x="70" y="74" width="16" height="5" rx="2.5" fill="#94a3b8"/>
            {{-- brand stripe --}}
            <rect x="14" y="60" width="70" height="14" rx="7" fill="#10b981"/>
            {{-- bumper --}}
            <rect x="285" y="118" width="14" height="16" rx="4" fill="#94a3b8"/>
        </g>

        {{-- wheels --}}
        <g>
            <circle cx="135" cy="262" r="28" fill="#0b1f3a"/>
            <circle cx="135" cy="262" r="11" fill="#475569"/>
            <circle cx="300" cy="262" r="28" fill="#0b1f3a"/>
            <circle cx="300" cy="262" r="11" fill="#475569"/>
        </g>

        {{-- motion --}}
        <g stroke="#10b981" stroke-width="4" stroke-linecap="round" opacity="0.6">
            <path d="M40 200H6"><animate attributeName="opacity" values="0;0.8;0" dur="1.1s" repeatCount="indefinite"/></path>
            <path d="M40 220H18"><animate attributeName="opacity" values="0;0.8;0" dur="1.1s" begin="0.3s" repeatCount="indefinite"/></path>
        </g>
    </svg>
</div>
