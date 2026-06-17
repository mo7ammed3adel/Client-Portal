@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
@endpush

<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="portal-title">طلب توصيل جديد</h1>
            <p class="portal-muted mt-1">اختار عنوان الطلب من الخريطة واكتب تفاصيل العنوان.</p>
        </div>
    </x-slot>

    <div class="portal-container max-w-5xl">
        <form method="POST" action="{{ route('client.requests.store') }}" class="portal-card">
            @csrf
            <div class="portal-card-body space-y-5">
                <div>
                    <label for="map-search" class="portal-label">ابحث عن المنطقة أو الشارع</label>
                    <div class="mt-1 flex flex-col gap-2 sm:flex-row">
                        <input id="map-search" type="search" class="portal-input mt-0" placeholder="مثال: مدينة نصر، التجمع، المهندسين">
                        <button id="map-search-button" type="button" class="portal-button-secondary shrink-0">بحث</button>
                        <button id="use-current-location" type="button" class="portal-button-secondary shrink-0">موقعي الحالي</button>
                    </div>
                    <p id="map-search-status" class="mt-2 min-h-5 text-xs font-semibold text-slate-500 dark:text-slate-400"></p>
                </div>

                <div>
                    <label class="portal-label">عنوان الطلب على الخريطة</label>
                    <div id="delivery-map" class="mt-2 h-[420px] w-full overflow-hidden rounded-lg border border-slate-300 dark:border-slate-700"></div>
                    <x-input-error :messages="$errors->get('delivery_latitude')" class="mt-2" />
                    <x-input-error :messages="$errors->get('delivery_longitude')" class="mt-2" />
                </div>

                <input id="delivery_latitude" name="delivery_latitude" type="hidden" value="{{ old('delivery_latitude') }}">
                <input id="delivery_longitude" name="delivery_longitude" type="hidden" value="{{ old('delivery_longitude') }}">

                <div>
                    <label for="address_details" class="portal-label">تفاصيل العنوان</label>
                    <textarea id="address_details" name="address_details" rows="4" class="portal-input" required placeholder="رقم العمارة، الدور، الشقة، علامة مميزة، أو أي تفاصيل تساعد الكابتن يوصل بسرعة.">{{ old('address_details') }}</textarea>
                    <x-input-error :messages="$errors->get('address_details')" class="mt-2" />
                </div>

                <div class="flex justify-end gap-3">
                    <a href="{{ route('client.requests.index') }}" class="portal-button-secondary">إلغاء</a>
                    <button class="portal-button">إرسال طلب التوصيل</button>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const defaultPoint = [
                    Number(document.getElementById('delivery_latitude').value) || 30.0444,
                    Number(document.getElementById('delivery_longitude').value) || 31.2357,
                ];
                const map = L.map('delivery-map', {
                    zoomControl: true,
                    scrollWheelZoom: true,
                }).setView(defaultPoint, defaultPoint[0] === 30.0444 ? 12 : 16);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; OpenStreetMap contributors',
                }).addTo(map);

                const marker = L.marker(defaultPoint, { draggable: true }).addTo(map);
                const latInput = document.getElementById('delivery_latitude');
                const lngInput = document.getElementById('delivery_longitude');
                const status = document.getElementById('map-search-status');
                const searchInput = document.getElementById('map-search');

                const setPoint = (lat, lng, zoom = map.getZoom()) => {
                    const point = [Number(lat), Number(lng)];
                    marker.setLatLng(point);
                    map.setView(point, zoom);
                    latInput.value = point[0].toFixed(7);
                    lngInput.value = point[1].toFixed(7);
                };

                setPoint(defaultPoint[0], defaultPoint[1], map.getZoom());

                map.on('click', (event) => {
                    setPoint(event.latlng.lat, event.latlng.lng, Math.max(map.getZoom(), 15));
                });

                marker.on('dragend', () => {
                    const point = marker.getLatLng();
                    setPoint(point.lat, point.lng, map.getZoom());
                });

                const search = async () => {
                    const query = searchInput.value.trim();
                    if (!query) {
                        status.textContent = 'اكتب اسم منطقة أو شارع للبحث.';
                        return;
                    }

                    status.textContent = 'جاري البحث...';

                    try {
                        const response = await fetch(`https://nominatim.openstreetmap.org/search?format=json&limit=6&addressdetails=1&q=${encodeURIComponent(query)}`, {
                            headers: { 'Accept': 'application/json' },
                        });
                        const results = await response.json();

                        if (!Array.isArray(results) || results.length === 0) {
                            status.textContent = 'لم يتم العثور على نتائج. جرّب اسم منطقة أو شارع أقرب.';
                            return;
                        }

                        const first = results[0];
                        setPoint(first.lat, first.lon, 16);
                        status.textContent = first.display_name || 'تم تحديد أول نتيجة على الخريطة.';
                    } catch (error) {
                        status.textContent = 'تعذر البحث الآن. يمكنك تحديد المكان يدويًا من الخريطة.';
                    }
                };

                document.getElementById('map-search-button').addEventListener('click', search);
                searchInput.addEventListener('keydown', (event) => {
                    if (event.key === 'Enter') {
                        event.preventDefault();
                        search();
                    }
                });

                document.getElementById('use-current-location').addEventListener('click', () => {
                    if (!navigator.geolocation) {
                        status.textContent = 'المتصفح لا يدعم تحديد الموقع الحالي.';
                        return;
                    }

                    status.textContent = 'جاري تحديد موقعك...';
                    navigator.geolocation.getCurrentPosition(
                        (position) => {
                            setPoint(position.coords.latitude, position.coords.longitude, 17);
                            status.textContent = 'تم تحديد موقعك الحالي.';
                        },
                        () => {
                            status.textContent = 'لم نقدر نحدد موقعك. اختار النقطة يدويًا من الخريطة.';
                        },
                        { enableHighAccuracy: true, timeout: 10000 }
                    );
                });
            });
        </script>
    @endpush
</x-app-layout>
