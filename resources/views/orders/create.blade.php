<x-public-layout title="إنشاء طلب توصيل">
    @push('styles')
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
        <style>
            .leaflet-container { font-family: inherit; border-radius: 1rem; }
        </style>
    @endpush

    <section class="bg-slate-50 py-10 lg:py-14">
        <div class="section">
            <div class="reveal is-visible mb-8 text-center lg:text-right">
                <span class="chip">طلب جديد</span>
                <h1 class="mt-3 text-3xl font-black text-ink-900 sm:text-4xl">أنشئ طلب توصيل</h1>
                <p class="mt-2 text-slate-500">حدّد موقع الاستلام والتسليم على الخريطة، واملأ البيانات — التكلفة بتتحسب تلقائيًا.</p>
            </div>

            @if ($errors->any())
                <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm font-semibold text-red-700">
                    <p>برجاء مراجعة البيانات التالية:</p>
                    <ul class="mt-2 list-disc space-y-1 pe-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('order.store') }}"
                  id="order-form"
                  data-cost-per-km="{{ $costPerKm }}"
                  data-base-fee="{{ $baseFee }}"
                  data-base-distance="{{ $baseDistanceKm }}"
                  data-min-cost="{{ $minOrderCost }}"
                  class="grid gap-8 lg:grid-cols-3">
                @csrf

                {{-- ===== Left: form ===== --}}
                <div class="space-y-6 lg:col-span-2">
                    {{-- Pickup --}}
                    <div class="rounded-3xl border border-slate-100 bg-white p-6 shadow-sm">
                        <div class="flex items-center gap-3">
                            <span class="grid h-9 w-9 place-items-center rounded-full bg-brand-600 text-sm font-black text-white">1</span>
                            <h2 class="text-lg font-black text-ink-900">موقع الاستلام (من)</h2>
                        </div>
                        <div class="mt-4 flex flex-col gap-2 sm:flex-row">
                            <input type="search" data-map="pickup" data-role="search" class="field mt-0" placeholder="ابحث: بلقاس، المنصورة، ميت غمر...">
                            <button type="button" data-map="pickup" data-role="search-btn" class="btn-outline shrink-0 py-2.5">بحث</button>
                            <button type="button" data-map="pickup" data-role="locate" class="btn-outline shrink-0 py-2.5">موقعي</button>
                        </div>
                        <div id="pickup-map" class="mt-3 h-72 w-full overflow-hidden rounded-2xl border border-slate-200"></div>
                        <p data-map="pickup" data-role="status" class="mt-2 min-h-5 text-xs font-semibold text-slate-400"></p>
                        <label class="field-label mt-3 block">عنوان الاستلام التفصيلي</label>
                        <textarea name="pickup_address" data-map="pickup" data-role="address" rows="2" required class="field" placeholder="العنوان يظهر تلقائيًا بعد التحديد — أضف رقم العمارة/الدور.">{{ old('pickup_address') }}</textarea>
                        <input type="hidden" name="pickup_lat" data-map="pickup" data-role="lat" value="{{ old('pickup_lat') }}">
                        <input type="hidden" name="pickup_lng" data-map="pickup" data-role="lng" value="{{ old('pickup_lng') }}">
                    </div>

                    {{-- Drop-off --}}
                    <div class="rounded-3xl border border-slate-100 bg-white p-6 shadow-sm">
                        <div class="flex items-center gap-3">
                            <span class="grid h-9 w-9 place-items-center rounded-full bg-ink-900 text-sm font-black text-white">2</span>
                            <h2 class="text-lg font-black text-ink-900">موقع التسليم (إلى)</h2>
                        </div>
                        <div class="mt-4 flex flex-col gap-2 sm:flex-row">
                            <input type="search" data-map="dropoff" data-role="search" class="field mt-0" placeholder="ابحث عن منطقة التسليم داخل الدقهلية...">
                            <button type="button" data-map="dropoff" data-role="search-btn" class="btn-outline shrink-0 py-2.5">بحث</button>
                            <button type="button" data-map="dropoff" data-role="locate" class="btn-outline shrink-0 py-2.5">موقعي</button>
                        </div>
                        <div id="dropoff-map" class="mt-3 h-72 w-full overflow-hidden rounded-2xl border border-slate-200"></div>
                        <p data-map="dropoff" data-role="status" class="mt-2 min-h-5 text-xs font-semibold text-slate-400"></p>
                        <label class="field-label mt-3 block">عنوان التسليم التفصيلي</label>
                        <textarea name="dropoff_address" data-map="dropoff" data-role="address" rows="2" required class="field" placeholder="العنوان يظهر تلقائيًا بعد التحديد — أضف رقم العمارة/الدور.">{{ old('dropoff_address') }}</textarea>
                        <input type="hidden" name="dropoff_lat" data-map="dropoff" data-role="lat" value="{{ old('dropoff_lat') }}">
                        <input type="hidden" name="dropoff_lng" data-map="dropoff" data-role="lng" value="{{ old('dropoff_lng') }}">
                    </div>

                    {{-- Sender / Receiver --}}
                    <div class="grid gap-6 sm:grid-cols-2">
                        <div class="rounded-3xl border border-slate-100 bg-white p-6 shadow-sm">
                            <div class="flex items-center gap-3">
                                <span class="grid h-9 w-9 place-items-center rounded-full bg-brand-600 text-sm font-black text-white">3</span>
                                <h2 class="text-lg font-black text-ink-900">بيانات المرسِل</h2>
                            </div>
                            <div class="mt-4 space-y-4">
                                <div>
                                    <label class="field-label">اسم المرسِل</label>
                                    <input name="sender_name" type="text" value="{{ old('sender_name') }}" required class="field" placeholder="الاسم">
                                </div>
                                <div>
                                    <label class="field-label">هاتف المرسِل</label>
                                    <input name="sender_phone" type="tel" value="{{ old('sender_phone') }}" required class="field" placeholder="01xxxxxxxxx" dir="ltr">
                                </div>
                            </div>
                        </div>
                        <div class="rounded-3xl border border-slate-100 bg-white p-6 shadow-sm">
                            <div class="flex items-center gap-3">
                                <span class="grid h-9 w-9 place-items-center rounded-full bg-ink-900 text-sm font-black text-white">4</span>
                                <h2 class="text-lg font-black text-ink-900">بيانات المستلِم</h2>
                            </div>
                            <div class="mt-4 space-y-4">
                                <div>
                                    <label class="field-label">اسم المستلِم</label>
                                    <input name="receiver_name" type="text" value="{{ old('receiver_name') }}" required class="field" placeholder="الاسم">
                                </div>
                                <div>
                                    <label class="field-label">هاتف المستلِم</label>
                                    <input name="receiver_phone" type="tel" value="{{ old('receiver_phone') }}" required class="field" placeholder="01xxxxxxxxx" dir="ltr">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Notes --}}
                    <div class="rounded-3xl border border-slate-100 bg-white p-6 shadow-sm">
                        <div class="flex items-center gap-3">
                            <span class="grid h-9 w-9 place-items-center rounded-full bg-brand-600 text-sm font-black text-white">5</span>
                            <h2 class="text-lg font-black text-ink-900">تفاصيل الشحنة</h2>
                        </div>
                        <textarea name="notes" rows="3" class="field mt-4" placeholder="نوع الشحنة، الوزن التقريبي، أو أي ملاحظات للكابتن...">{{ old('notes') }}</textarea>
                    </div>
                </div>

                {{-- ===== Right: summary ===== --}}
                <div class="lg:col-span-1">
                    <div class="lg:sticky lg:top-24">
                        <div class="overflow-hidden rounded-3xl border border-slate-100 bg-white shadow-xl shadow-slate-900/5">
                            <div class="bg-ink-900 p-6 text-white">
                                <h2 class="text-lg font-black">ملخص الطلب</h2>
                                <p class="mt-1 text-sm text-slate-300">راجع التفاصيل قبل الدفع</p>
                            </div>
                            <div class="space-y-4 p-6">
                                <div class="space-y-3 text-sm">
                                    <div class="flex items-start gap-2">
                                        <span class="mt-0.5 h-2.5 w-2.5 shrink-0 rounded-full bg-brand-500"></span>
                                        <div><p class="font-bold text-ink-900">الاستلام</p><p data-summary="pickup" class="text-slate-500">لم يتم التحديد بعد</p></div>
                                    </div>
                                    <div class="flex items-start gap-2">
                                        <span class="mt-0.5 h-2.5 w-2.5 shrink-0 rounded-full bg-ink-900"></span>
                                        <div><p class="font-bold text-ink-900">التسليم</p><p data-summary="dropoff" class="text-slate-500">لم يتم التحديد بعد</p></div>
                                    </div>
                                </div>

                                <div class="space-y-2.5 rounded-2xl bg-slate-50 p-4 text-sm">
                                    <div class="flex items-center justify-between"><span class="text-slate-500">المسافة التقديرية</span><span data-summary="distance" class="font-bold text-ink-900">—</span></div>
                                    <div class="flex items-center justify-between"><span class="text-slate-500">أول {{ rtrim(rtrim(number_format($baseDistanceKm, 2), '0'), '.') }} كم</span><span class="font-bold text-ink-900">{{ rtrim(rtrim(number_format($baseFee, 2), '0'), '.') }} جنيه</span></div>
                                    <div class="flex items-center justify-between"><span class="text-slate-500">كل كم إضافي</span><span class="font-bold text-ink-900">{{ rtrim(rtrim(number_format($costPerKm, 2), '0'), '.') }} جنيه</span></div>
                                    <div class="my-1 border-t border-slate-200"></div>
                                    <div class="flex items-center justify-between text-base"><span class="font-black text-brand-700">الإجمالي</span><span data-summary="total" class="text-2xl font-black text-brand-700">—</span></div>
                                </div>

                                <div>
                                    <p class="field-label mb-2">طريقة الدفع</p>
                                    <div class="grid grid-cols-2 gap-3">
                                        <label class="flex cursor-pointer items-center justify-center gap-2 rounded-xl border-2 border-brand-500 bg-brand-50 px-3 py-2.5 text-sm font-bold text-brand-700 has-[:checked]:border-brand-500 has-[:checked]:bg-brand-50">
                                            <input type="radio" name="payment_method" value="card" class="text-brand-600 focus:ring-brand-500" checked> بطاقة
                                        </label>
                                        <label class="flex cursor-pointer items-center justify-center gap-2 rounded-xl border-2 border-slate-200 px-3 py-2.5 text-sm font-bold text-slate-600 has-[:checked]:border-brand-500 has-[:checked]:bg-brand-50 has-[:checked]:text-brand-700">
                                            <input type="radio" name="payment_method" value="wallet" class="text-brand-600 focus:ring-brand-500"> محفظة
                                        </label>
                                    </div>
                                </div>

                                <button type="submit" id="pay-button" disabled
                                        class="btn-brand w-full justify-center py-3.5 text-base disabled:cursor-not-allowed disabled:opacity-50 disabled:hover:translate-y-0">
                                    <span id="pay-label">حدد الموقعين أولًا</span>
                                </button>
                                <p class="text-center text-xs text-slate-400">سيتم تأكيد الطلب بعد إتمام الدفع بنجاح فقط.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>

    @push('scripts')
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
        <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('order-form');
            const costPerKm = parseFloat(form.dataset.costPerKm) || 0;
            const baseFee = parseFloat(form.dataset.baseFee) || 0;
            const baseDistance = parseFloat(form.dataset.baseDistance) || 0;
            const minCost = parseFloat(form.dataset.minCost) || 0;
            // Centre the maps on Belqas, Dakahlia.
            const CAIRO = [31.2103, 31.3478];

            const fmt = (n) => Number(n).toLocaleString('ar-EG', { maximumFractionDigits: 2 });

            const el = (map, role) => document.querySelector(`[data-map="${map}"][data-role="${role}"]`);
            const summary = (key) => document.querySelector(`[data-summary="${key}"]`);

            const controllers = {};

            function haversine(a, b) {
                const R = 6371, toRad = (d) => d * Math.PI / 180;
                const dLat = toRad(b[0] - a[0]), dLng = toRad(b[1] - a[1]);
                const x = Math.sin(dLat / 2) ** 2 + Math.cos(toRad(a[0])) * Math.cos(toRad(b[0])) * Math.sin(dLng / 2) ** 2;
                return R * 2 * Math.atan2(Math.sqrt(x), Math.sqrt(1 - x));
            }

            function updateSummary() {
                const p = controllers.pickup, d = controllers.dropoff;
                const pSet = p.point !== null, dSet = d.point !== null;
                summary('pickup').textContent = pSet ? (el('pickup', 'address').value || 'تم التحديد على الخريطة') : 'لم يتم التحديد بعد';
                summary('dropoff').textContent = dSet ? (el('dropoff', 'address').value || 'تم التحديد على الخريطة') : 'لم يتم التحديد بعد';

                const btn = document.getElementById('pay-button');
                const label = document.getElementById('pay-label');

                if (pSet && dSet) {
                    const dist = haversine(p.point, d.point);
                    const extra = Math.max(0, dist - baseDistance);
                    let total = baseFee + extra * costPerKm;
                    if (total < minCost) total = minCost;
                    summary('distance').textContent = fmt(dist) + ' كم';
                    summary('total').textContent = fmt(total) + ' ج';
                    btn.disabled = false;
                    label.textContent = 'ادفع ' + fmt(total) + ' جنيه';
                } else {
                    summary('distance').textContent = '—';
                    summary('total').textContent = '—';
                    btn.disabled = true;
                    label.textContent = 'حدد الموقعين أولًا';
                }
            }

            function makeController(name) {
                const latIn = el(name, 'lat'), lngIn = el(name, 'lng');
                const statusEl = el(name, 'status'), addressEl = el(name, 'address');
                const searchEl = el(name, 'search');

                const hasOld = latIn.value && lngIn.value;
                const start = hasOld ? [parseFloat(latIn.value), parseFloat(lngIn.value)] : CAIRO;

                const map = L.map(`${name}-map`, { scrollWheelZoom: true }).setView(start, hasOld ? 15 : 11);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19, attribution: '&copy; OpenStreetMap',
                }).addTo(map);

                const ctrl = { map, marker: null, point: hasOld ? start : null };
                controllers[name] = ctrl;

                let geoTimer = null;
                function reverseGeocode(lat, lng) {
                    if (geoTimer) clearTimeout(geoTimer);
                    statusEl.textContent = 'جاري جلب العنوان...';
                    geoTimer = setTimeout(async () => {
                        try {
                            const r = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&accept-language=ar`, { headers: { Accept: 'application/json' } });
                            const data = await r.json();
                            if (data && data.display_name && !addressEl.dataset.touched) {
                                addressEl.value = data.display_name;
                            }
                            statusEl.textContent = data && data.display_name ? data.display_name : 'تم تحديد الموقع.';
                        } catch (e) {
                            statusEl.textContent = 'تم تحديد الموقع (تعذّر جلب العنوان تلقائيًا).';
                        }
                        updateSummary();
                    }, 350);
                }

                function setPoint(lat, lng, zoom) {
                    const point = [Number(lat), Number(lng)];
                    ctrl.point = point;
                    if (!ctrl.marker) {
                        ctrl.marker = L.marker(point, { draggable: true }).addTo(map);
                        ctrl.marker.on('dragend', () => {
                            const ll = ctrl.marker.getLatLng();
                            applyPoint(ll.lat, ll.lng, map.getZoom());
                        });
                    } else {
                        ctrl.marker.setLatLng(point);
                    }
                    map.setView(point, zoom || map.getZoom());
                    latIn.value = point[0].toFixed(7);
                    lngIn.value = point[1].toFixed(7);
                }

                function applyPoint(lat, lng, zoom) {
                    setPoint(lat, lng, zoom);
                    reverseGeocode(lat, lng);
                }

                if (hasOld) setPoint(start[0], start[1], 15);

                addressEl.addEventListener('input', () => {
                    addressEl.dataset.touched = '1';
                    updateSummary();
                });

                map.on('click', (e) => applyPoint(e.latlng.lat, e.latlng.lng, Math.max(map.getZoom(), 14)));

                async function doSearch() {
                    const q = searchEl.value.trim();
                    if (!q) { statusEl.textContent = 'اكتب اسم منطقة للبحث.'; return; }
                    statusEl.textContent = 'جاري البحث...';
                    try {
                        const r = await fetch(`https://nominatim.openstreetmap.org/search?format=json&limit=1&accept-language=ar&countrycodes=eg&q=${encodeURIComponent(q)}`, { headers: { Accept: 'application/json' } });
                        const res = await r.json();
                        if (!Array.isArray(res) || res.length === 0) { statusEl.textContent = 'لم يتم العثور على نتائج.'; return; }
                        addressEl.dataset.touched = '';
                        applyPoint(res[0].lat, res[0].lon, 15);
                    } catch (e) {
                        statusEl.textContent = 'تعذر البحث الآن. حدد المكان يدويًا من الخريطة.';
                    }
                }

                el(name, 'search-btn').addEventListener('click', doSearch);
                searchEl.addEventListener('keydown', (e) => { if (e.key === 'Enter') { e.preventDefault(); doSearch(); } });

                el(name, 'locate').addEventListener('click', () => {
                    if (!navigator.geolocation) { statusEl.textContent = 'المتصفح لا يدعم تحديد الموقع.'; return; }
                    statusEl.textContent = 'جاري تحديد موقعك...';
                    navigator.geolocation.getCurrentPosition(
                        (pos) => { addressEl.dataset.touched = ''; applyPoint(pos.coords.latitude, pos.coords.longitude, 16); },
                        () => { statusEl.textContent = 'تعذر تحديد موقعك. اختر المكان يدويًا.'; },
                        { enableHighAccuracy: true, timeout: 10000 }
                    );
                });

                setTimeout(() => map.invalidateSize(), 200);
            }

            makeController('pickup');
            makeController('dropoff');
            updateSummary();

            form.addEventListener('submit', (e) => {
                if (!controllers.pickup.point || !controllers.dropoff.point) {
                    e.preventDefault();
                    alert('من فضلك حدد موقع الاستلام والتسليم على الخريطة.');
                    return;
                }
                const btn = document.getElementById('pay-button');
                btn.disabled = true;
                document.getElementById('pay-label').textContent = 'جاري التحويل للدفع...';
            });
        });
        </script>
    @endpush
</x-public-layout>
