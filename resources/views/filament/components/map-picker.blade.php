<div
    x-data="{
        map: null,
        marker: null,
        searchQuery: '',
        searching: false,
        reverseLoading: false,
        statusText: 'Klik pada peta atau geser pin merah untuk memilih titik lokasi.',
        currentLat: -6.4633000,
        currentLng: 108.4528000,
        autoFillAddress: true,

        initMap() {
            // Load Leaflet CSS & JS dynamically if not yet loaded
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

            // Cek apakah ada nilai awal dari form (Edit mode) atau dari URL parameter (?lat=...&lng=...)
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
                attribution: '&copy; OpenStreetMap | GIS Migrant CARE'
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

            this.marker.bindPopup('<b>📍 Titik Lokasi Terpilih</b><br><span style=\'font-size:11px;\'>Geser pin atau klik peta untuk mengubah</span>').openPopup();

            // Event saat klik di mana saja pada peta
            this.map.on('click', (e) => {
                const { lat, lng } = e.latlng;
                this.updatePoint(lat, lng, true);
            });

            // Event saat pin selesai digeser (dragend)
            this.marker.on('dragend', (e) => {
                const pos = e.target.getLatLng();
                this.updatePoint(pos.lat, pos.lng, true);
            });

            // Pastikan ukuran peta direfresh
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

            // Set nilai ke state Livewire Filament
            this.$wire.set('data.latitude', formattedLat);
            this.$wire.set('data.longitude', formattedLng);

            this.statusText = `✓ Koordinat terkunci: ${formattedLat}, ${formattedLng}`;

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
                    this.statusText = `✓ Otomatis terisi: ${data.display_name.substring(0, 75)}...`;
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
                    this.statusText = `✓ Ditemukan: ${place.display_name.substring(0, 75)}...`;
                } else {
                    this.statusText = '⚠️ Lokasi tidak ditemukan. Coba kata kunci yang lebih umum (misal: Karangampel Indramayu).';
                }
            } catch (e) {
                this.statusText = '⚠️ Gagal mencari lokasi.';
            } finally {
                this.searching = false;
            }
        },

        flyToPreset(lat, lng, zoom, label) {
            if (!this.map) return;
            this.map.setView([lat, lng], zoom, { animate: true });
            this.updatePoint(lat, lng, true);
            this.statusText = `📍 Berpindah ke ${label}`;
        },

        detectMyLocation() {
            if (!navigator.geolocation) {
                alert('Browser tidak mendukung Geolocation.');
                return;
            }
            this.statusText = '⏳ Mendeteksi titik GPS perangkat Anda...';
            navigator.geolocation.getCurrentPosition(
                (pos) => {
                    const { latitude, longitude } = pos.coords;
                    this.map.setView([latitude, longitude], 16, { animate: true });
                    this.updatePoint(latitude, longitude, true);
                },
                () => {
                    this.statusText = '⚠️ Gagal mengakses GPS. Pastikan izin lokasi diaktifkan.';
                }
            );
        }
    }"
    x-init="initMap()"
    wire:ignore
    style="background: #ffffff; border: 1px solid #DCE3DE; border-radius: 16px; padding: 18px; box-shadow: 0 2px 12px rgba(9, 164, 110, 0.04);"
>
    <!-- Header Pin-Point Picker ala Dashboard Pengurus OpsiProyek1 -->
    <div style="display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 12px; margin-bottom: 14px; padding-bottom: 12px; border-bottom: 1px solid #F0F3EF;">
        <div>
            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
                <span style="width: 8px; height: 8px; border-radius: 9999px; background: #09A46E; display: inline-block;"></span>
                <span style="font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.06em; color: #09A46E;">
                    Interactive GIS Pin-Point Picker
                </span>
            </div>
            <h4 style="margin: 0; font-size: 15px; font-weight: 700; color: #17211C;">
                Pilih Titik Lokasi Kantor / Posko di Peta
            </h4>
            <p style="margin: 2px 0 0 0; font-size: 12px; color: #526158;">
                Klik langsung pada peta atau geser pin hijau — <strong>Latitude, Longitude, dan Alamat Lengkap</strong> akan terisi otomatis.
            </p>
        </div>

        <!-- Toggle Auto-fill Alamat -->
        <label style="display: inline-flex; align-items: center; gap: 8px; padding: 6px 12px; border-radius: 9999px; background: #E8F7F1; border: 1px solid rgba(9,164,110,0.25); font-size: 12px; font-weight: 600; color: #064E3B; cursor: pointer;">
            <input type="checkbox" x-model="autoFillAddress" style="accent-color: #09A46E; width: 15px; height: 15px; cursor: pointer;">
            <span>Isi Alamat Otomatis (Reverse Geocode)</span>
        </label>
    </div>

    <!-- Search Bar & Quick Region Buttons -->
    <div style="display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 12px;">
        <div style="flex: 1; min-width: 240px; display: flex; gap: 6px;">
            <input
                type="text"
                x-model="searchQuery"
                @keydown.enter.prevent="searchLocation()"
                placeholder="Ketik nama desa, jalan, atau kecamatan (contoh: Juntinyuat Indramayu / Mampang Jakarta)..."
                style="flex: 1; padding: 8px 14px; border-radius: 12px; border: 1px solid #DCE3DE; background: #FAFDFB; font-size: 13px; color: #17211C; outline: none;"
            />
            <button
                type="button"
                @click="searchLocation()"
                style="padding: 8px 16px; border-radius: 12px; background: #09A46E; color: #ffffff; font-size: 12px; font-weight: 700; border: none; cursor: pointer; white-space: nowrap; transition: background 0.2s;"
            >
                <span x-show="!searching">🔍 Cari Titik</span>
                <span x-show="searching">⏳ Mencari...</span>
            </button>
        </div>

        <div style="display: flex; gap: 6px; flex-wrap: wrap;">
            <button
                type="button"
                @click="flyToPreset(-6.4633000, 108.4528000, 13, 'Pusat Indramayu (Karangampel)')"
                style="padding: 7px 12px; border-radius: 9999px; background: #F0F3EF; color: #17211C; font-size: 11px; font-weight: 700; border: 1px solid #DCE3DE; cursor: pointer;"
            >
                📍 Indramayu
            </button>
            <button
                type="button"
                @click="flyToPreset(-6.2514000, 106.8315000, 14, 'Sekretariat Jakarta (Mampang)')"
                style="padding: 7px 12px; border-radius: 9999px; background: #F0F3EF; color: #17211C; font-size: 11px; font-weight: 700; border: 1px solid #DCE3DE; cursor: pointer;"
            >
                📍 DKI Jakarta
            </button>
            <button
                type="button"
                @click="detectMyLocation()"
                style="padding: 7px 12px; border-radius: 9999px; background: #E8F7F1; color: #09A46E; font-size: 11px; font-weight: 700; border: 1px solid rgba(9,164,110,0.3); cursor: pointer;"
            >
                🎯 GPS Saya
            </button>
        </div>
    </div>

    <!-- Map Canvas -->
    <div
        x-ref="mapContainer"
        style="width: 100%; height: 360px; border-radius: 14px; border: 1px solid #DCE3DE; overflow: hidden; z-index: 1;"
    ></div>

    <!-- Live Status Bar -->
    <div style="margin-top: 10px; padding: 10px 14px; border-radius: 12px; background: #F7F8F5; border: 1px solid #E4EDE8; display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 8px; font-size: 12px;">
        <div style="display: flex; align-items: center; gap: 8px; color: #17211C; font-weight: 600;">
            <span x-show="reverseLoading" style="color: #C78A18;">⏳ Mengambil nama jalan/desa otomatis...</span>
            <span x-show="!reverseLoading" x-text="statusText"></span>
        </div>
        <div style="font-family: monospace; font-size: 11px; background: #E8F7F1; color: #09A46E; padding: 3px 10px; border-radius: 9999px; font-weight: 700;">
            LAT: <span x-text="Number(currentLat).toFixed(6)"></span> | LNG: <span x-text="Number(currentLng).toFixed(6)"></span>
        </div>
    </div>
</div>

