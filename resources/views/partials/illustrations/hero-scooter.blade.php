{{-- Animated delivery scene: map card + scooter + floating badges --}}
<div class="relative mx-auto max-w-lg">
    {{-- Glow --}}
    <div class="absolute inset-6 rounded-[2.5rem] bg-brand-500/30 blur-2xl"></div>

    {{-- Map card --}}
    <div class="relative overflow-hidden rounded-[2rem] border border-white/10 bg-gradient-to-br from-ink-800 to-ink-900 p-2 shadow-2xl">
        <svg viewBox="0 0 460 380" class="w-full" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="رسم توضيحي لخدمة التوصيل">
            <defs>
                <linearGradient id="road" x1="0" y1="0" x2="0" y2="1">
                    <stop offset="0" stop-color="#0f2a4d"/><stop offset="1" stop-color="#0b1f3a"/>
                </linearGradient>
                <linearGradient id="box" x1="0" y1="0" x2="1" y2="1">
                    <stop offset="0" stop-color="#34d399"/><stop offset="1" stop-color="#059669"/>
                </linearGradient>
            </defs>

            {{-- map background grid --}}
            <rect x="10" y="10" width="440" height="360" rx="22" fill="url(#road)"/>
            <g stroke="#1e3a5f" stroke-width="1.5" opacity="0.7">
                <path d="M10 90H450M10 170H450M10 250H450M10 330H450"/>
                <path d="M110 10V370M210 10V370M310 10V370M410 10V370"/>
            </g>

            {{-- dashed route --}}
            <path d="M70 300 C 150 300, 150 150, 250 150 S 380 80, 400 70"
                  fill="none" stroke="#10b981" stroke-width="4" stroke-linecap="round" stroke-dasharray="2 16">
                <animate attributeName="stroke-dashoffset" from="0" to="-180" dur="3s" repeatCount="indefinite"/>
            </path>

            {{-- pickup pin --}}
            <g transform="translate(58,272)">
                <circle cx="12" cy="28" r="5" fill="#10b981" opacity="0.35"/>
                <path d="M12 0C5.4 0 0 5.2 0 11.6 0 20.5 12 30 12 30s12-9.5 12-18.4C24 5.2 18.6 0 12 0Z" fill="#34d399"/>
                <circle cx="12" cy="11.5" r="4.5" fill="#0b1f3a"/>
            </g>
            {{-- dropoff pin --}}
            <g transform="translate(388,40)">
                <circle cx="12" cy="28" r="5" fill="#fff" opacity="0.25"/>
                <path d="M12 0C5.4 0 0 5.2 0 11.6 0 20.5 12 30 12 30s12-9.5 12-18.4C24 5.2 18.6 0 12 0Z" fill="#fff"/>
                <circle cx="12" cy="11.5" r="4.5" fill="#059669"/>
            </g>

            {{-- scooter (moving) --}}
            <g class="animate-drive">
                <g transform="translate(150,210)">
                    {{-- shadow --}}
                    <ellipse cx="70" cy="92" rx="76" ry="9" fill="#000" opacity="0.25"/>
                    {{-- wheels --}}
                    <circle cx="26" cy="78" r="22" fill="#0b1f3a" stroke="#334e6f" stroke-width="4"/>
                    <circle cx="26" cy="78" r="8" fill="#1e3a5f"/>
                    <circle cx="120" cy="78" r="22" fill="#0b1f3a" stroke="#334e6f" stroke-width="4"/>
                    <circle cx="120" cy="78" r="8" fill="#1e3a5f"/>
                    {{-- body --}}
                    <path d="M18 60 L44 60 L60 40 L96 40 L104 60 L120 60" fill="none" stroke="#10b981" stroke-width="7" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M44 60 q14 -2 26 0" fill="none" stroke="#059669" stroke-width="6"/>
                    {{-- delivery box --}}
                    <rect x="78" y="14" width="40" height="34" rx="6" fill="url(#box)"/>
                    <path d="M98 14V48 M78 31H118" stroke="#065f46" stroke-width="2"/>
                    {{-- handle --}}
                    <path d="M44 60 L34 36 L24 34" fill="none" stroke="#cbd5e1" stroke-width="5" stroke-linecap="round"/>
                    {{-- rider --}}
                    <circle cx="66" cy="22" r="11" fill="#facc15"/>
                    <path d="M56 24 q10 6 20 0" stroke="#0b1f3a" stroke-width="2" fill="none"/>
                    <path d="M60 33 L52 56 L40 58" fill="none" stroke="#1d4ed8" stroke-width="8" stroke-linecap="round"/>
                </g>
            </g>

            {{-- speed lines --}}
            <g stroke="#10b981" stroke-width="3" stroke-linecap="round" opacity="0.6">
                <path d="M150 230H120"><animate attributeName="opacity" values="0;0.8;0" dur="1s" repeatCount="indefinite"/></path>
                <path d="M150 250H110"><animate attributeName="opacity" values="0;0.8;0" dur="1s" begin="0.3s" repeatCount="indefinite"/></path>
            </g>
        </svg>
    </div>

    {{-- floating badge: time --}}
    <div class="absolute -left-3 top-10 animate-float rounded-2xl border border-slate-100 bg-white p-3 shadow-xl sm:-left-6">
        <div class="flex items-center gap-2.5">
            <div class="grid h-9 w-9 place-items-center rounded-xl bg-brand-100 text-brand-700">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
            </div>
            <div><p class="text-xs text-slate-400">وقت التوصيل</p><p class="text-sm font-black text-ink-900">~ 45 دقيقة</p></div>
        </div>
    </div>

    {{-- floating badge: paid --}}
    <div class="absolute -right-2 bottom-8 animate-float-slow rounded-2xl border border-slate-100 bg-white p-3 shadow-xl sm:-right-6">
        <div class="flex items-center gap-2.5">
            <div class="grid h-9 w-9 place-items-center rounded-xl bg-brand-600 text-white">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
            </div>
            <div><p class="text-xs text-slate-400">الدفع</p><p class="text-sm font-black text-ink-900">تم بنجاح</p></div>
        </div>
    </div>
</div>
