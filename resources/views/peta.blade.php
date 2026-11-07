<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Peta Lokasi Kantor & Posko — Koperasi Peduli Buruh Migran Indramayu</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <style>
        :root {
            --k-primary: #09A46E;
            --k-primary-hover: #064E3B;
            --k-bg: #F7F8F5;
            --k-border: #DCE3DE;
            --k-border-soft: #E4EDE8;
            --k-text: #17211C;
            --k-text-secondary: #526158;
        }

        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background-color: var(--k-bg);
            color: var(--k-text);
            height: 100vh;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            -webkit-font-smoothing: antialiased;
        }

        /* Top Header */
        .top-header {
            height: 68px;
            background: rgba(247, 248, 245, 0.94);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--k-border-soft);
            padding: 0 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            z-index: 1050;
            flex-shrink: 0;
        }
        .brand-box {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: inherit;
        }
        .brand-box img {
            height: 38px;
            width: auto;
            object-fit: contain;
        }
        .brand-title {
            font-size: 14px;
            font-weight: 700;
            color: var(--k-text);
            letter-spacing: -0.01em;
        }

        /* Center Navigation Tabs */
        .pill-nav {
            display: flex;
            align-items: center;
            gap: 4px;
            background: #FFFFFF;
            padding: 5px;
            border-radius: 9999px;
            border: 1px solid var(--k-border-soft);
            box-shadow: 0 2px 14px rgba(9, 164, 110, 0.04);
        }
        .pill-tab {
            padding: 7px 14px;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: 600;
            color: #6B7280;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.15s ease;
            white-space: nowrap;
        }
        .pill-tab:hover {
            color: #111827;
            background: #F2F6F4;
        }
        .pill-tab.active {
            background: var(--k-primary);
            color: #FFFFFF;
            font-weight: 700;
        }

        /* Header Actions */
        .header-actions {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .btn-action {
            padding: 8px 14px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            cursor: pointer;
            transition: all 0.15s ease;
            border: 1px solid var(--k-border);
            background: #FFFFFF;
            color: var(--k-text);
            font-family: inherit;
        }
        .btn-action:hover {
            border-color: var(--k-primary);
            color: var(--k-primary);
        }
        .btn-action.primary {
            background: var(--k-primary);
            color: #FFFFFF;
            border-color: var(--k-primary);
        }
        .btn-action.primary:hover {
            background: var(--k-primary-hover);
            border-color: var(--k-primary-hover);
        }
        .btn-action.pin-active {
            background: #111827;
            color: #FFFFFF;
            border-color: #111827;
        }

        /* Workspace */
        .workspace {
            flex: 1;
            display: flex;
            padding: 14px 24px 18px 24px;
            gap: 16px;
            overflow: hidden;
            max-width: 1600px;
            width: 100%;
            margin: 0 auto;
        }

        /* Left Panel */
        .left-panel {
            width: 390px;
            background: #FFFFFF;
            border: 1px solid var(--k-border);
            border-radius: 18px;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            flex-shrink: 0;
        }
        .panel-header {
            padding: 18px 20px 14px 20px;
            border-bottom: 1px solid #F0F3EF;
        }
        .panel-header h2 {
            margin: 0;
            font-size: 16px;
            font-weight: 700;
            color: var(--k-text);
        }
        .panel-header p {
            margin: 4px 0 0 0;
            font-size: 12px;
            color: var(--k-text-secondary);
            line-height: 1.45;
        }

        .panel-controls {
            padding: 12px 16px;
            background: #FAFDFB;
            border-bottom: 1px solid var(--k-border-soft);
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        .search-box {
            display: flex;
            align-items: center;
            gap: 8px;
            background: #FFFFFF;
            border: 1px solid var(--k-border);
            border-radius: 10px;
            padding: 7px 11px;
            color: #6B7280;
        }
        .search-box input {
            border: none;
            outline: none;
            width: 100%;
            font-size: 12.5px;
            font-family: inherit;
            color: var(--k-text);
            background: transparent;
        }
        .region-pills {
            display: flex;
            gap: 6px;
        }
        .region-btn {
            flex: 1;
            padding: 6px 8px;
            border-radius: 8px;
            font-size: 11.5px;
            font-weight: 600;
            border: 1px solid var(--k-border-soft);
            background: #FFFFFF;
            color: var(--k-text-secondary);
            cursor: pointer;
            transition: all 0.15s;
            font-family: inherit;
        }
        .region-btn:hover {
            color: var(--k-text);
            background: #F2F6F4;
        }
        .region-btn.active {
            background: var(--k-primary);
            color: #FFFFFF;
            border-color: var(--k-primary);
        }

        /* List Cards */
        .branch-list {
            flex: 1;
            overflow-y: auto;
            padding: 12px 16px;
        }
        .branch-card {
            background: #FFFFFF;
            border: 1px solid var(--k-border-soft);
            border-radius: 14px;
            padding: 14px;
            margin-bottom: 10px;
            cursor: pointer;
            transition: all 0.15s ease;
        }
        .branch-card:hover {
            border-color: var(--k-primary);
        }
        .branch-card.active {
            border-color: var(--k-primary);
            background: #F8FBF9;
            box-shadow: 0 0 0 1px var(--k-primary);
        }
        .branch-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 8px;
            margin-bottom: 4px;
        }
        .branch-name {
            font-size: 13.5px;
            font-weight: 700;
            color: var(--k-text);
            line-height: 1.35;
        }
        .branch-type {
            font-size: 11px;
            font-weight: 600;
            color: var(--k-primary);
            white-space: nowrap;
            flex-shrink: 0;
        }
        .branch-addr {
            font-size: 12px;
            color: var(--k-text-secondary);
            line-height: 1.45;
            margin-bottom: 10px;
        }
        .branch-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-top: 8px;
            border-top: 1px solid #F0F3EF;
            font-size: 11.5px;
        }
        .footer-link {
            color: var(--k-text-secondary);
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: color 0.15s;
        }
        .footer-link:hover {
            color: var(--k-primary);
        }

        /* Pin-Point Form View */
        .pinpoint-form-container {
            display: none;
            flex-direction: column;
            flex: 1;
            overflow-y: auto;
            padding: 18px 20px;
            background: #FFFFFF;
        }
        .pinpoint-form-container.active {
            display: flex;
        }
        .pin-guide {
            background: #F8FAF7;
            border: 1px solid var(--k-border-soft);
            border-radius: 10px;
            padding: 10px 12px;
            margin-bottom: 14px;
            font-size: 12px;
            color: var(--k-text-secondary);
            line-height: 1.45;
        }
        .form-group {
            margin-bottom: 12px;
        }
        .form-label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: var(--k-text);
            margin-bottom: 5px;
        }
        .form-input, .form-select, .form-textarea {
            width: 100%;
            padding: 8px 11px;
            border-radius: 10px;
            border: 1px solid var(--k-border);
            background: #FAFDFB;
            font-family: inherit;
            font-size: 12.5px;
            color: var(--k-text);
            outline: none;
        }
        .form-input:focus, .form-select:focus, .form-textarea:focus {
            border-color: var(--k-primary);
            background: #FFFFFF;
        }
        .coord-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }
        .coord-readonly {
            background: #F2F6F4 !important;
            font-family: monospace;
            font-weight: 600;
            color: #111827 !important;
        }
        .btn-submit {
            width: 100%;
            padding: 10px 16px;
            border-radius: 10px;
            background: var(--k-primary);
            color: #FFFFFF;
            font-weight: 600;
            font-size: 12.5px;
            border: none;
            cursor: pointer;
            font-family: inherit;
            margin-top: 4px;
        }
        .btn-submit:hover {
            background: var(--k-primary-hover);
        }
        .btn-secondary-link {
            width: 100%;
            padding: 9px 14px;
            border-radius: 10px;
            background: #F8FAF7;
            color: var(--k-text-secondary);
            font-weight: 600;
            font-size: 12px;
            border: 1px solid var(--k-border);
            text-align: center;
            text-decoration: none;
            display: block;
            margin-top: 8px;
        }
        .btn-secondary-link:hover {
            color: var(--k-text);
            background: #F0F3EF;
        }

        /* Map Container */
        .map-bento {
            flex: 1;
            background: #FFFFFF;
            border: 1px solid var(--k-border);
            border-radius: 18px;
            position: relative;
            overflow: hidden;
        }
        #map {
            width: 100%;
            height: 100%;
        }

        /* Map Search Bar */
        .map-floating-bar {
            position: absolute;
            top: 14px;
            left: 14px;
            z-index: 1000;
        }
        .geocode-search-bar {
            display: flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(8px);
            padding: 5px 6px 5px 12px;
            border-radius: 12px;
            border: 1px solid var(--k-border);
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.06);
            width: 340px;
            max-width: calc(100vw - 48px);
            color: #6B7280;
        }
        .geocode-search-bar input {
            border: none;
            outline: none;
            background: transparent;
            width: 100%;
            font-size: 12px;
            font-family: inherit;
            color: var(--k-text);
        }
        .geocode-search-bar button {
            background: var(--k-primary);
            color: #FFFFFF;
            border: none;
            border-radius: 8px;
            padding: 6px 12px;
            font-size: 11.5px;
            font-weight: 600;
            cursor: pointer;
            white-space: nowrap;
            font-family: inherit;
        }

        /* Legend */
        .legend-box {
            position: absolute;
            z-index: 1000;
            bottom: 20px;
            left: 14px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(6px);
            padding: 10px 14px;
            border-radius: 12px;
            border: 1px solid var(--k-border);
            box-shadow: 0 4px 12px rgba(0,0,0,0.06);
            font-size: 11.5px;
            line-height: 1.7;
        }
        .legend-title {
            font-weight: 700;
            margin-bottom: 4px;
            color: var(--k-text);
        }
        .legend-item {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--k-text-secondary);
        }
        .legend-dot {
            width: 9px;
            height: 9px;
            border-radius: 50%;
            display: inline-block;
        }
        .dot-kantor { background: #10B981; }
        .dot-posko { background: #0284C7; }
        .dot-rumah { background: #F59E0B; }
        .dot-pin { background: #EF4444; }

        .flash-banner {
            position: fixed;
            bottom: 24px;
            right: 24px;
            z-index: 2000;
            background: #111827;
            color: #FFFFFF;
            padding: 12px 18px;
            border-radius: 12px;
            font-size: 12.5px;
            font-weight: 600;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.18);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        @media (max-width: 960px) {
            .pill-nav { display: none; }
            .workspace { flex-direction: column-reverse; padding: 10px; }
            .left-panel { width: 100%; height: 45vh; }
            .map-bento { height: 55vh; }
            .legend-box { display: none; }
        }
    </style>
</head>
<body>

    @if(session('success'))
        <div class="flash-banner" id="flashBanner">
            <span>{{ session('success') }}</span>
            <button onclick="document.getElementById('flashBanner').remove()" style="background:none;border:none;color:#9CA3AF;cursor:pointer;">✕</button>
        </div>
        <script>setTimeout(() => { const el = document.getElementById('flashBanner'); if (el) el.remove(); }, 4000);</script>
    @endif

    <!-- Shared Consistent Header Navbar -->
    @include('components.shared-navbar')

    <!-- Workspace -->
    <div class="workspace">

        <!-- Left Panel -->
        <aside class="left-panel">

            <!-- View 1: Daftar Lokasi -->
            <div id="listViewContainer" style="display:flex; flex-direction:column; height:100%;">
                <div class="panel-header">
                    <h2>Kantor & Posko Layanan</h2>
                    <p>Pilih lokasi untuk memusatkan peta atau klik pada peta untuk menambahkan titik baru.</p>
                </div>

                <div class="panel-controls">
                    <div class="search-box">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                        <input type="text" id="filterSearchInput" placeholder="Cari nama kantor, desa, atau jalan..." oninput="filterCards()">
                    </div>
                    <div class="region-pills">
                        <button class="region-btn active" onclick="filterWilayah('all', this)">Semua ({{ count($branches) }})</button>
                        <button class="region-btn" onclick="filterWilayah('indramayu', this)">Indramayu</button>
                        <button class="region-btn" onclick="filterWilayah('jakarta', this)">DKI Jakarta</button>
                    </div>
                </div>

                <div class="branch-list" id="branchListContainer">
                    @foreach($branches as $index => $b)
                        @php
                            $isJkt = str_contains(strtolower($b->alamat . ' ' . $b->nama), 'jakarta');
                            $wilayahTag = $isJkt ? 'jakarta' : 'indramayu';
                            $typeLabel = match($b->jenis) {
                                'kantor' => 'Kantor Operasional',
                                'posko' => 'Posko Layanan',
                                'rumah_aman' => 'Rumah Aman',
                                default => ucfirst($b->jenis ?? 'Posko'),
                            };
                        @endphp
                        <div class="branch-card"
                             data-wilayah="{{ $wilayahTag }}"
                             data-search="{{ strtolower($b->nama . ' ' . $b->alamat) }}"
                             onclick="focusBranch({{ $index }})"
                             id="branch-card-{{ $index }}">
                            <div class="branch-top">
                                <div class="branch-name">{{ $b->nama }}</div>
                                <span class="branch-type">{{ $typeLabel }}</span>
                            </div>
                            <div class="branch-addr">{{ $b->alamat }}</div>
                            <div class="branch-footer">
                                @if($b->telepon)
                                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', $b->telepon) }}" class="footer-link" onclick="event.stopPropagation();">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                        <span>{{ $b->telepon }}</span>
                                    </a>
                                @else
                                    <span style="color:#9CA3AF;">-</span>
                                @endif
                                <div style="display:flex; gap:12px; align-items:center;">
                                    <a href="/admin/branches/{{ $b->id }}/edit" class="footer-link" onclick="event.stopPropagation();">Edit</a>
                                    <a href="https://www.google.com/maps/dir/?api=1&destination={{ $b->latitude }},{{ $b->longitude }}"
                                       target="_blank"
                                       class="footer-link"
                                       onclick="event.stopPropagation();">
                                        <span>Rute Maps</span>
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M7 17 17 7"/><path d="M7 7h10v10"/></svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- View 2: Form Tambah Titik Lokasi -->
            <div id="pinpointFormContainer" class="pinpoint-form-container">
                <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:12px; padding-bottom:10px; border-bottom:1px solid #F0F3EF;">
                    <h3 style="margin:0; font-size:15px; font-weight:700; color:#17211C;">Tambah Lokasi Baru</h3>
                    <button type="button" onclick="togglePinpointMode(false)" style="background:#F2F6F4; border:none; border-radius:8px; width:28px; height:28px; cursor:pointer; color:#526158;">✕</button>
                </div>

                <div class="pin-guide" id="pinStatusBanner">
                    Klik pada peta atau geser pin merah untuk mengisi koordinat dan alamat secara otomatis.
                </div>

                <form action="{{ route('peta.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Nama Kantor / Posko</label>
                        <input type="text" name="nama" id="inputNama" class="form-input" placeholder="Contoh: Posko Layanan Desa Lombang" required>
                    </div>

                    <div class="coord-grid">
                        <div class="form-group">
                            <label class="form-label">Kategori</label>
                            <select name="jenis" id="inputJenis" class="form-select" required>
                                <option value="posko">Posko Layanan PMI</option>
                                <option value="kantor">Kantor Operasional</option>
                                <option value="rumah_aman">Rumah Aman</option>
                                <option value="mitra">Mitra Komunitas</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Nomor Telepon</label>
                            <input type="text" name="telepon" id="inputTelepon" class="form-input" placeholder="+62 813-xxxx-xxxx">
                        </div>
                    </div>

                    <div class="coord-grid">
                        <div class="form-group">
                            <label class="form-label">Latitude</label>
                            <input type="number" step="any" name="latitude" id="inputLat" class="form-input coord-readonly" required readonly>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Longitude</label>
                            <input type="number" step="any" name="longitude" id="inputLng" class="form-input coord-readonly" required readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Alamat Lengkap</label>
                        <textarea name="alamat" id="inputAlamat" rows="3" class="form-textarea" placeholder="Klik titik di peta untuk mengisi alamat otomatis..." required></textarea>
                    </div>

                    <button type="submit" class="btn-submit">Simpan Lokasi</button>

                    <a href="/admin/branches/create" id="linkOpenFilament" class="btn-secondary-link">
                        Buka di Form Filament
                    </a>
                </form>
            </div>

        </aside>

        <!-- Right Map Container -->
        <main class="map-bento">
            <div class="map-floating-bar">
                <div class="geocode-search-bar">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                    <input type="text" id="mapPlaceSearch" placeholder="Cari desa atau kecamatan di peta..." onkeydown="if(event.key==='Enter') searchPlaceOnMap()">
                    <button type="button" onclick="searchPlaceOnMap()" id="btnSearchPlace">Cari</button>
                </div>
            </div>

            <div id="map"></div>

            <div class="legend-box">
                <div class="legend-title">Keterangan Titik</div>
                <div class="legend-item"><span class="legend-dot dot-kantor"></span> Kantor Operasional</div>
                <div class="legend-item"><span class="legend-dot dot-posko"></span> Posko Layanan PMI</div>
                <div class="legend-item"><span class="legend-dot dot-rumah"></span> Rumah Aman</div>
                <div class="legend-item"><span class="legend-dot dot-pin"></span> Titik Pilihan / Lokasi Anda</div>
            </div>
        </main>

    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        const branches = @json($branches);
        let currentRegion = 'all';
        let isPinpointMode = false;
        let pinMarker = null;

        const map = L.map('map', { zoomControl: false }).setView([-6.38, 107.60], 9);
        L.control.zoom({ position: 'bottomright' }).addTo(map);

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap'
        }).addTo(map);

        const greenIcon = new L.Icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
            iconSize: [25, 41], iconAnchor: [12, 41], popupAnchor: [1, -34], shadowSize: [41, 41]
        });
        const blueIcon = new L.Icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-blue.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
            iconSize: [25, 41], iconAnchor: [12, 41], popupAnchor: [1, -34], shadowSize: [41, 41]
        });
        const orangeIcon = new L.Icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-orange.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
            iconSize: [25, 41], iconAnchor: [12, 41], popupAnchor: [1, -34], shadowSize: [41, 41]
        });
        const redPinIcon = new L.Icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
            iconSize: [25, 41], iconAnchor: [12, 41], popupAnchor: [1, -34], shadowSize: [41, 41]
        });

        const markers = [];
        branches.forEach((b, i) => {
            let icon = blueIcon;
            let typeText = 'Posko Layanan PMI';
            if (b.jenis === 'kantor') {
                icon = greenIcon;
                typeText = 'Kantor Operasional';
            } else if (b.jenis === 'rumah_aman') {
                icon = orangeIcon;
                typeText = 'Rumah Aman';
            }

            const m = L.marker([b.latitude, b.longitude], { icon }).addTo(map);
            m.bindPopup(`
                <div style="min-width:210px; font-family:'Plus Jakarta Sans',sans-serif;">
                    <div style="font-size:11px; color:#09A46E; font-weight:700; margin-bottom:2px;">${typeText}</div>
                    <h4 style="margin:0 0 4px 0; font-size:14px; font-weight:700; color:#17211C;">${b.nama}</h4>
                    <p style="margin:0 0 8px 0; font-size:12px; color:#526158; line-height:1.45;">${b.alamat}</p>
                    <div style="display:flex; justify-content:space-between; align-items:center; border-top:1px solid #F0F3EF; padding-top:7px; font-size:11.5px;">
                        ${b.telepon ? `<a href="tel:${b.telepon}" style="color:#17211C; font-weight:600; text-decoration:none;">${b.telepon}</a>` : '<span></span>'}
                        <a href="https://www.google.com/maps/dir/?api=1&destination=${b.latitude},${b.longitude}" target="_blank" style="color:#09A46E; font-weight:700; text-decoration:none;">Buka Rute &rarr;</a>
                    </div>
                </div>
            `);
            markers.push(m);
        });

        if (markers.length) {
            map.fitBounds(L.featureGroup(markers).getBounds().pad(0.18));
        }

        // Poligon Wilayah Dampingan Indramayu
        const areaIndramayu = L.polygon([
            [-6.36, 108.38],
            [-6.36, 108.52],
            [-6.54, 108.55],
            [-6.53, 108.40]
        ], {
            color: '#09A46E',
            fillColor: '#10B981',
            fillOpacity: 0.08,
            weight: 1.5,
            dashArray: '5, 5'
        }).addTo(map);
        areaIndramayu.bindPopup('<b>Wilayah Layanan Indramayu</b><br>Kecamatan Juntinyuat, Karangampel, dan Krangkeng.');

        // Klik Peta untuk Pin-Point
        map.on('click', function(e) {
            const { lat, lng } = e.latlng;
            activatePinpointAt(lat, lng);
        });

        function togglePinpointMode(forceState) {
            isPinpointMode = typeof forceState === 'boolean' ? forceState : !isPinpointMode;
            const listEl = document.getElementById('listViewContainer');
            const formEl = document.getElementById('pinpointFormContainer');
            const btn = document.getElementById('btn-toggle-pinpoint');
            const btnText = document.getElementById('pinpoint-btn-text');

            if (isPinpointMode) {
                listEl.style.display = 'none';
                formEl.classList.add('active');
                btn.classList.remove('primary');
                btn.classList.add('pin-active');
                btnText.textContent = 'Tutup Mode Titik';

                if (!pinMarker) {
                    const center = map.getCenter();
                    activatePinpointAt(center.lat, center.lng);
                }
            } else {
                listEl.style.display = 'flex';
                formEl.classList.remove('active');
                btn.classList.remove('pin-active');
                btn.classList.add('primary');
                btnText.textContent = 'Tambah Titik Lokasi';
                if (pinMarker) {
                    map.removeLayer(pinMarker);
                    pinMarker = null;
                }
            }
        }

        async function activatePinpointAt(lat, lng) {
            if (!isPinpointMode) {
                togglePinpointMode(true);
            }

            const fLat = Number(lat).toFixed(7);
            const fLng = Number(lng).toFixed(7);

            document.getElementById('inputLat').value = fLat;
            document.getElementById('inputLng').value = fLng;

            if (!pinMarker) {
                pinMarker = L.marker([lat, lng], { icon: redPinIcon, draggable: true }).addTo(map);
                pinMarker.on('dragend', function(ev) {
                    const pos = ev.target.getLatLng();
                    activatePinpointAt(pos.lat, pos.lng);
                });
            } else {
                pinMarker.setLatLng([lat, lng]);
            }

            pinMarker.bindPopup(`<b>Titik Lokasi Baru</b><br><span style="font-family:monospace;font-size:11px;">${fLat}, ${fLng}</span>`).openPopup();

            const banner = document.getElementById('pinStatusBanner');
            banner.textContent = `Mengambil detail alamat untuk koordinat ${fLat}, ${fLng}...`;

            const filamentLink = document.getElementById('linkOpenFilament');
            filamentLink.href = `/admin/branches/create?lat=${fLat}&lng=${fLng}`;

            try {
                const res = await fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}&accept-language=id`);
                const data = await res.json();
                if (data && data.display_name) {
                    document.getElementById('inputAlamat').value = data.display_name;
                    filamentLink.href = `/admin/branches/create?lat=${fLat}&lng=${fLng}&alamat=${encodeURIComponent(data.display_name)}`;
                    banner.textContent = `Koordinat dan alamat berhasil terisi otomatis.`;
                } else {
                    banner.textContent = `Koordinat terkunci (${fLat}, ${fLng}). Silakan lengkapi alamat.`;
                }
            } catch (err) {
                banner.textContent = `Koordinat terkunci (${fLat}, ${fLng}). Silakan ketik alamat di bawah.`;
            }
        }

        async function searchPlaceOnMap() {
            const q = document.getElementById('mapPlaceSearch').value.trim();
            if (!q) return;
            const btn = document.getElementById('btnSearchPlace');
            btn.textContent = '...';
            try {
                const res = await fetch(`https://nominatim.openstreetmap.org/search?format=jsonv2&q=${encodeURIComponent(q)}&countrycodes=id&limit=1&accept-language=id`);
                const items = await res.json();
                if (items && items.length > 0) {
                    const place = items[0];
                    const lat = parseFloat(place.lat);
                    const lng = parseFloat(place.lon);
                    map.setView([lat, lng], 16, { animate: true });
                    activatePinpointAt(lat, lng);
                } else {
                    alert('Lokasi tidak ditemukan.');
                }
            } catch (e) {
                alert('Gagal mencari lokasi.');
            } finally {
                btn.textContent = 'Cari';
            }
        }

        function focusBranch(index) {
            const b = branches[index];
            if (!b) return;
            map.setView([b.latitude, b.longitude], 15, { animate: true });
            markers[index].openPopup();

            document.querySelectorAll('.branch-card').forEach(el => el.classList.remove('active'));
            const card = document.getElementById('branch-card-' + index);
            if (card) {
                card.classList.add('active');
                card.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }
        }

        function filterWilayah(region, btnEl) {
            currentRegion = region;
            document.querySelectorAll('.region-btn').forEach(b => b.classList.remove('active'));
            if (btnEl) btnEl.classList.add('active');
            filterCards();

            if (region === 'indramayu') {
                map.setView([-6.45, 108.45], 11, { animate: true });
            } else if (region === 'jakarta') {
                map.setView([-6.255, 106.843], 13, { animate: true });
            } else if (markers.length) {
                map.fitBounds(L.featureGroup(markers).getBounds().pad(0.18));
            }
        }

        function filterCards() {
            const q = document.getElementById('filterSearchInput').value.toLowerCase().trim();
            document.querySelectorAll('.branch-card').forEach(card => {
                const matchRegion = (currentRegion === 'all' || card.getAttribute('data-wilayah') === currentRegion);
                const matchText = (!q || card.getAttribute('data-search').includes(q));
                card.style.display = (matchRegion && matchText) ? 'block' : 'none';
            });
        }

        function jarakKm(lat1, lon1, lat2, lon2) {
            const R = 6371;
            const rad = d => d * Math.PI / 180;
            const dLat = rad(lat2 - lat1), dLon = rad(lon2 - lon1);
            const a = Math.sin(dLat / 2) ** 2 + Math.cos(rad(lat1)) * Math.cos(rad(lat2)) * Math.sin(dLon / 2) ** 2;
            return 2 * R * Math.asin(Math.sqrt(a));
        }

        let userMarker = null;
        document.getElementById('btn-near').addEventListener('click', () => {
            if (!navigator.geolocation) {
                alert('Geolocation tidak didukung oleh browser Anda.');
                return;
            }
            const btnText = document.getElementById('near-btn-text');
            btnText.textContent = 'Mendeteksi...';

            navigator.geolocation.getCurrentPosition(pos => {
                btnText.textContent = 'Lokasi Terdekat';
                const { latitude, longitude } = pos.coords;
                let best = null;
                branches.forEach((b, i) => {
                    const d = jarakKm(latitude, longitude, b.latitude, b.longitude);
                    if (!best || d < best.d) best = { d, i };
                });

                if (userMarker) map.removeLayer(userMarker);
                userMarker = L.circleMarker([latitude, longitude], {
                    radius: 8, color: '#ffffff', weight: 2, fillColor: '#EF4444', fillOpacity: 0.95
                }).addTo(map).bindPopup('<b>Lokasi Anda Saat Ini</b>').openPopup();

                if (best !== null) {
                    const b = branches[best.i];
                    markers[best.i].bindPopup(`
                        <div style="min-width:200px; font-family:'Plus Jakarta Sans',sans-serif;">
                            <div style="font-size:11px; color:#09A46E; font-weight:700; margin-bottom:2px;">Lokasi Terdekat (${best.d.toFixed(2)} km)</div>
                            <h4 style="margin:0 0 4px 0; font-size:14px; font-weight:700; color:#17211C;">${b.nama}</h4>
                            <p style="margin:0; font-size:12px; color:#526158;">${b.alamat}</p>
                        </div>
                    `).openPopup();
                    map.fitBounds(L.latLngBounds([[latitude, longitude], [b.latitude, b.longitude]]).pad(0.3));
                    focusBranch(best.i);
                }
            }, () => {
                btnText.textContent = 'Lokasi Terdekat';
                alert('Gagal mengakses GPS. Pastikan izin lokasi browser sudah diaktifkan.');
            });
        });

        const urlParams = new URLSearchParams(window.location.search);
        const qLat = parseFloat(urlParams.get('lat'));
        const qLng = parseFloat(urlParams.get('lng'));
        if (!isNaN(qLat) && !isNaN(qLng)) {
            map.setView([qLat, qLng], 15);
            const foundIdx = branches.findIndex(b => Math.abs(b.latitude - qLat) < 0.001 && Math.abs(b.longitude - qLng) < 0.001);
            if (foundIdx !== -1) {
                setTimeout(() => focusBranch(foundIdx), 450);
            }
        }
    </script>
</body>
</html>
