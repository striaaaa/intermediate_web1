<div
    x-data="{
        map: null,
        marker: null,
        searchQuery: '',
        searching: false,
        reverseLoading: false,
        statusText: 'Klik pada peta atau geser pin hijau untuk memilih titik lokasi.',
        currentLat: -6.4633000,
        currentLng: 108.4528000,
        autoFillAddress: true,

        initMap() {
            if (!document.getElementById('leaflet-css-filament')) {
                const link = document.createElement('link');
                link.id = 'leaflet-css-filament';
                link.rel = 'stylesheet';
                link.href = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css';
                document.head.appendChild(link);
            }

            const startLeaflet = () => {
                if (typeof L === 'undefined') {
                    setTimeout(startLeaflet, 150);
                    return;
                }
                this.setupMapInstance();
            };

            if (!document.getElementById('leaflet-js-filament')) {
                const script = document.createElement('script');
                script.id = 'leaflet-js-filament';
                script.src = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js';
                script.onload = startLeaflet;
                document.head.appendChild(script);
            } else {
                startLeaflet();
            }
        },

        setupMapInstance() {
            if (this.map) return;

            const urlParams = new URLSearchParams(window.location.search);
            const urlLat = parseFloat(urlParams.get('lat'));
            const urlLng = parseFloat(urlParams.get('lng'));
            const urlAlamat = urlParams.get('alamat');

            const wireLat = parseFloat(this.$wire.get('data.latitude'));
            const wireLng = parseFloat(this.$wire.get('data.longitude'));

            if (!isNaN(urlLat) && !isNaN(urlLng)) {
                this.currentLat = urlLat;
                this.currentLng = urlLng;
                this.$wire.set('data.latitude', urlLat.toFixed(7));
                this.$wire.set('data.longitude', urlLng.toFixed(7));
                if (urlAlamat) {
                    this.$wire.set('data.alamat', urlAlamat);
                } else {
                    this.fetchReverseGeocode(urlLat, urlLng);
                }
            } else if (!isNaN(wireLat) && !isNaN(wireLng)) {
                this.currentLat = wireLat;
                this.currentLng = wireLng;
            } else {
                this.$wire.set('data.latitude', this.currentLat.toFixed(7));
                this.$wire.set('data.longitude', this.currentLng.toFixed(7));
            }

            this.map = L.map(this.$refs.mapContainer).setView([this.currentLat, this.currentLng], 13);

            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap'
            }).addTo(this.map);

            const pinIcon = new L.Icon({
                iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
                shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            });

            this.marker = L.marker([this.currentLat, this.currentLng], {
                draggable: true,
                icon: pinIcon
            }).addTo(this.map);

            this.marker.bindPopup('<b>Titik Lokasi Terpilih</b><br><span style=\'font-size:11px;\'>Geser pin atau klik peta untuk mengubah</span>').openPopup();

            this.map.on('click', (e) => {
                const { lat, lng } = e.latlng;
                this.updatePoint(lat, lng, true);
            });

            this.marker.on('dragend', (e) => {
                const pos = e.target.getLatLng();
                this.updatePoint(pos.lat, pos.lng, true);
            });

            setTimeout(() => {
                this.map.invalidateSize();
            }, 250);
        },

        updatePoint(lat, lng, doReverse = true) {
            this.currentLat = parseFloat(lat);
            this.currentLng = parseFloat(lng);

            const formattedLat = this.currentLat.toFixed(7);
            const formattedLng = this.currentLng.toFixed(7);

            if (this.marker) {
                this.marker.setLatLng([this.currentLat, this.currentLng]);
            }

            this.$wire.set('data.latitude', formattedLat);
            this.$wire.set('data.longitude', formattedLng);

            this.statusText = `Koordinat dipilih: ${formattedLat}, ${formattedLng}`;

            if (doReverse && this.autoFillAddress) {
                this.fetchReverseGeocode(this.currentLat, this.currentLng);
            }
        },

        async fetchReverseGeocode(lat, lng) {
            this.reverseLoading = true;
            try {
                const res = await fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}&accept-language=id`);
                const data = await res.json();
                if (data && data.display_name) {
                    this.$wire.set('data.alamat', data.display_name);
                    this.statusText = `Alamat terdeteksi: ${data.display_name.substring(0, 80)}...`;
                }
            } catch (err) {
                console.warn('Reverse geocoding gagal:', err);
            } finally {
                this.reverseLoading = false;
            }
        },

        async searchLocation() {
            if (!this.searchQuery.trim()) return;
            this.searching = true;
            try {
                const q = encodeURIComponent(this.searchQuery.trim());
                const res = await fetch(`https://nominatim.openstreetmap.org/search?format=jsonv2&q=${q}&countrycodes=id&limit=1&accept-language=id`);
                const results = await res.json();
                if (results && results.length > 0) {
                    const place = results[0];
                    const lat = parseFloat(place.lat);
                    const lng = parseFloat(place.lon);
                    this.map.setView([lat, lng], 16, { animate: true });
                    this.updatePoint(lat, lng, false);
                    if (this.autoFillAddress && place.display_name) {
                        this.$wire.set('data.alamat', place.display_name);
                    }
                    this.statusText = `Lokasi ditemukan: ${place.display_name.substring(0, 80)}...`;
                } else {
                    this.statusText = 'Lokasi tidak ditemukan. Coba gunakan kata kunci yang lebih umum.';
                }
            } catch (e) {
                this.statusText = 'Gagal melakukan pencarian lokasi.';
            } finally {
                this.searching = false;
            }
        },

        flyToPreset(lat, lng, zoom, label) {
            if (!this.map) return;
            this.map.setView([lat, lng], zoom, { animate: true });
            this.updatePoint(lat, lng, true);
            this.statusText = `Fokus wilayah: ${label}`;
        },

        detectMyLocation() {
            if (!navigator.geolocation) {
                alert('Browser tidak mendukung Geolocation.');
                return;
            }
            this.statusText = 'Mendeteksi lokasi GPS...';
            navigator.geolocation.getCurrentPosition(
                (pos) => {
                    const { latitude, longitude } = pos.coords;
                    this.map.setView([latitude, longitude], 16, { animate: true });
                    this.updatePoint(latitude, longitude, true);
                },
                () => {
                    this.statusText = 'Gagal mengakses GPS.';
                }
            );
        }
    }"
    x-init="initMap()"
    wire:ignore
    style="display: flex; flex-direction: column; gap: 12px;"
>
    <!-- Search Bar & Quick Region Buttons -->
    <div style="display: flex; flex-wrap: wrap; gap: 8px; align-items: center; justify-content: space-between;">
        <div style="flex: 1; min-width: 240px; display: flex; gap: 6px;">
            <input
                type="text"
                x-model="searchQuery"
                @keydown.enter.prevent="searchLocation()"
                placeholder="Cari desa, jalan, atau kecamatan (contoh: Juntinyuat Indramayu)..."
                style="flex: 1; padding: 8px 12px; border-radius: 10px; border: 1px solid #DCE3DE; background: #FAFDFB; font-size: 13px; color: #17211C; outline: none;"
            />
            <button
                type="button"
                @click="searchLocation()"
                style="padding: 8px 14px; border-radius: 10px; background: #09A46E; color: #ffffff; font-size: 12px; font-weight: 600; border: none; cursor: pointer; white-space: nowrap;"
            >
                <span x-show="!searching">Cari Lokasi</span>
                <span x-show="searching">Mencari...</span>
            </button>
        </div>

        <div style="display: flex; gap: 6px; flex-wrap: wrap; align-items: center;">
            <button
                type="button"
                @click="flyToPreset(-6.4633000, 108.4528000, 13, 'Indramayu')"
                style="padding: 7px 12px; border-radius: 8px; background: #F2F6F4; color: #17211C; font-size: 12px; font-weight: 600; border: 1px solid #DCE3DE; cursor: pointer;"
            >
                Indramayu
            </button>
            <button
                type="button"
                @click="flyToPreset(-6.2514000, 106.8315000, 14, 'DKI Jakarta')"
                style="padding: 7px 12px; border-radius: 8px; background: #F2F6F4; color: #17211C; font-size: 12px; font-weight: 600; border: 1px solid #DCE3DE; cursor: pointer;"
            >
                DKI Jakarta
            </button>
            <button
                type="button"
                @click="detectMyLocation()"
                style="padding: 7px 12px; border-radius: 8px; background: #FFFFFF; color: #09A46E; font-size: 12px; font-weight: 600; border: 1px solid #DCE3DE; cursor: pointer;"
            >
                Lokasi Saya
            </button>
            <label style="display: inline-flex; align-items: center; gap: 6px; font-size: 12px; font-weight: 500; color: #526158; margin-left: 4px; cursor: pointer;">
                <input type="checkbox" x-model="autoFillAddress" style="accent-color: #09A46E; cursor: pointer;">
                <span>Isi alamat otomatis</span>
            </label>
        </div>
    </div>

    <!-- Map Canvas -->
    <div
        x-ref="mapContainer"
        style="width: 100%; height: 350px; border-radius: 12px; border: 1px solid #DCE3DE; overflow: hidden; z-index: 1;"
    ></div>

    <!-- Status Bar -->
    <div style="display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 8px; font-size: 12px; color: #526158;">
        <div>
            <span x-show="reverseLoading">Mengambil detail alamat...</span>
            <span x-show="!reverseLoading" x-text="statusText"></span>
        </div>
        <div style="font-family: monospace; font-size: 11.5px; color: #17211C; font-weight: 600;">
            <span x-text="Number(currentLat).toFixed(6)"></span>, <span x-text="Number(currentLng).toFixed(6)"></span>
        </div>
    </div>
</div>
