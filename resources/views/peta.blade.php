<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>GIS Jaringan Layanan & Posko — Koperasi Peduli Buruh Migran Indramayu</title>

    <!-- Google Font: Plus Jakarta Sans (Sesuai Design.md OpsiProyek1) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <style>
        :root {
            --k-primary: #09A46E;
            --k-primary-dark: #0B6B4F;
            --k-primary-hover: #064E3B;
            --k-surface-soft: #E8F7F1;
            --k-bg: #F7F8F5;
            --k-card: #FFFFFF;
            --k-border: #DCE3DE;
            --k-border-soft: #E4EDE8;
            --k-text: #17211C;
            --k-text-secondary: #526158;
            --k-text-muted: #7A857F;
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

        /* ─── TOP HEADER BAR (Persis Gaya AdminLayout.tsx OpsiProyek1) ─── */
        .top-header {
            height: 70px;
            background: rgba(247, 248, 245, 0.92);
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
            height: 40px;
            width: auto;
            object-fit: contain;
        }
        .brand-text-wrap {
            display: flex;
            flex-direction: column;
        }
        .brand-pill {
            font-size: 9px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--k-primary);
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .brand-pill::before {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--k-primary);
            display: inline-block;
        }
        .brand-title {
            font-size: 14px;
            font-weight: 800;
            color: var(--k-text);
            letter-spacing: -0.01em;
        }

        /* Floating White Pill Navigation Tabs */
        .pill-nav {
            display: flex;
            align-items: center;
            gap: 4px;
            background: #FFFFFF;
            padding: 5px;
            border-radius: 9999px;
            border: 1px solid var(--k-border-soft);
            box-shadow: 0 2px 16px rgba(9, 164, 110, 0.05);
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
            transition: all 0.2s ease;
            border: none;
            background: transparent;
            cursor: pointer;
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
            box-shadow: 0 2px 8px rgba(9, 164, 110, 0.25);
        }
        .pill-badge {
            background: var(--k-primary);
            color: #FFFFFF;
            font-size: 10px;
            font-weight: 800;
            padding: 1px 6px;
            border-radius: 9999px;
        }
        .pill-tab.active .pill-badge {
            background: #FFFFFF;
            color: var(--k-primary);
        }

        /* Header Right Actions */
        .header-actions {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .btn-action {
            padding: 8px 15px;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
            transition: all 0.2s ease;
            border: 1px solid var(--k-border);
            background: #FFFFFF;
            color: var(--k-text);
            font-family: inherit;
        }
        .btn-action:hover {
            border-color: var(--k-primary);
            color: var(--k-primary);
            background: #FAFDFB;
        }
        .btn-action.primary {
            background: var(--k-primary);
            color: #FFFFFF;
            border-color: var(--k-primary);
            box-shadow: 0 4px 12px rgba(9, 164, 110, 0.25);
        }
        .btn-action.primary:hover {
            background: var(--k-primary-hover);
            border-color: var(--k-primary-hover);
        }
        .btn-action.pin-active {
            background: #FEF3C7;
            color: #92400E;
            border-color: #F59E0B;
            animation: pulseBorder 1.8s infinite;
        }

        @keyframes pulseBorder {
            0%, 100% { box-shadow: 0 0 0 0 rgba(245, 158, 11, 0.35); }
            50% { box-shadow: 0 0 0 6px rgba(245, 158, 11, 0); }
        }

        /* ─── MAIN WORKSPACE ─── */
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

        /* ─── LEFT BENTO PANEL (DAFTAR & FORM PIN-POINT) ─── */
        .left-panel {
            width: 410px;
            background: #FFFFFF;
            border: 1px solid var(--k-border);
            border-radius: 20px;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            box-shadow: 0 2px 14px rgba(9, 164, 110, 0.04);
            flex-shrink: 0;
        }

        .panel-header {
            padding: 18px 20px 14px 20px;
            border-bottom: 1px solid #F0F3EF;
        }
        .panel-eyebrow {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 4px;
        }
        .eyebrow-tag {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            color: var(--k-primary);
        }
        .eyebrow-tag span {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: var(--k-primary);
        }
        .count-pill {
            font-size: 11px;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 9999px;
            background: var(--k-surface-soft);
            color: var(--k-primary);
            border: 1px solid rgba(9, 164, 110, 0.25);
        }
        .panel-header h2 {
            margin: 0;
            font-size: 17px;
            font-weight: 800;
            color: var(--k-text);
            letter-spacing: -0.01em;
        }
        .panel-header p {
            margin: 3px 0 0 0;
            font-size: 12px;
            color: var(--k-text-secondary);
            line-height: 1.4;
        }

        /* Search & Region Filter inside Left Panel */
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
            border-radius: 12px;
            padding: 7px 12px;
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
            border-radius: 10px;
            font-size: 11.5px;
            font-weight: 700;
            border: 1px solid var(--k-border-soft);
            background: #FFFFFF;
            color: var(--k-text-secondary);
            cursor: pointer;
            transition: all 0.15s;
            font-family: inherit;
        }
        .region-btn:hover {
            border-color: var(--k-primary);
            color: var(--k-primary);
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
            padding: 14px 16px;
        }
        .branch-card {
            background: #FFFFFF;
            border: 1px solid var(--k-border-soft);
            border-radius: 16px;
            padding: 14px;
            margin-bottom: 10px;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .branch-card:hover {
            border-color: var(--k-primary);
            background: #FAFDFB;
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(9, 164, 110, 0.08);
        }
        .branch-card.active {
            border-color: var(--k-primary);
            background: #F0FDF4;
            box-shadow: 0 0 0 1.5px var(--k-primary);
        }
        .branch-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 8px;
            margin-bottom: 6px;
        }
        .branch-name {
            font-size: 13.5px;
            font-weight: 800;
            color: var(--k-text);
            line-height: 1.35;
        }
        .badge {
            font-size: 10px;
            font-weight: 700;
            padding: 3px 8px;
            border-radius: 9999px;
            white-space: nowrap;
            flex-shrink: 0;
        }
        .badge-kantor { background: #E8F7F1; color: #09A46E; border: 1px solid rgba(9,164,110,0.25); }
        .badge-posko { background: #E0F2FE; color: #0284C7; border: 1px solid rgba(2,132,199,0.25); }
        .badge-rumah_aman { background: #FEF3C7; color: #B45309; border: 1px solid rgba(180,83,9,0.25); }
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
            border-top: 1px dashed var(--k-border-soft);
            font-size: 11.5px;
        }
        .phone-link {
            color: var(--k-primary-dark);
            font-weight: 700;
            text-decoration: none;
        }
        .phone-link:hover { text-decoration: underline; }
        .route-link {
            color: #2563EB;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }
        .route-link:hover { text-decoration: underline; }

        /* ─── PIN-POINT ADD FORM VIEW (INSIDE LEFT PANEL) ─── */
        .pinpoint-form-container {
            display: none;
            flex-direction: column;
            flex: 1;
            overflow-y: auto;
            padding: 16px 18px;
            background: #FFFFFF;
        }
        .pinpoint-form-container.active {
            display: flex;
        }
        .pin-guide-banner {
            background: #F0FDF4;
            border: 1px solid rgba(9, 164, 110, 0.3);
            border-radius: 14px;
            padding: 12px 14px;
            margin-bottom: 14px;
            font-size: 12px;
            color: #064E3B;
            line-height: 1.45;
        }
        .form-group {
            margin-bottom: 12px;
        }
        .form-label {
            display: block;
            font-size: 11.5px;
            font-weight: 700;
            color: var(--k-text);
            margin-bottom: 5px;
        }
        .form-input, .form-select, .form-textarea {
            width: 100%;
            padding: 9px 12px;
            border-radius: 12px;
            border: 1px solid var(--k-border);
            background: #FAFDFB;
            font-family: inherit;
            font-size: 12.5px;
            color: var(--k-text);
            outline: none;
            transition: border-color 0.15s;
        }
        .form-input:focus, .form-select:focus, .form-textarea:focus {
            border-color: var(--k-primary);
            background: #FFFFFF;
            box-shadow: 0 0 0 3px rgba(9, 164, 110, 0.1);
        }
        .coord-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }
        .coord-badge-input {
            background: #E8F7F1 !important;
            border-color: rgba(9, 164, 110, 0.35) !important;
            color: #064E3B !important;
            font-family: monospace;
            font-weight: 700;
        }
        .btn-submit-pin {
            width: 100%;
            padding: 11px 16px;
            border-radius: 12px;
            background: var(--k-primary);
            color: #FFFFFF;
            font-weight: 800;
            font-size: 13px;
            border: none;
            cursor: pointer;
            font-family: inherit;
            box-shadow: 0 4px 14px rgba(9, 164, 110, 0.25);
            transition: all 0.2s;
            margin-top: 4px;
        }
        .btn-submit-pin:hover {
            background: var(--k-primary-hover);
        }
        .btn-open-filament {
            width: 100%;
            padding: 9px 14px;
            border-radius: 12px;
            background: #F0F3EF;
            color: var(--k-text);
            font-weight: 700;
            font-size: 12px;
            border: 1px solid var(--k-border);
            cursor: pointer;
            font-family: inherit;
            text-align: center;
            text-decoration: none;
            display: block;
            margin-top: 8px;
        }
        .btn-open-filament:hover {
            background: #E4EDE8;
        }

        /* ─── RIGHT MAP BENTO CONTAINER ─── */
        .map-bento {
            flex: 1;
            background: #FFFFFF;
            border: 1px solid var(--k-border);
            border-radius: 20px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 2px 14px rgba(9, 164, 110, 0.04);
        }
        #map {
            width: 100%;
            height: 100%;
        }

        /* Floating Map Overlay Bar (Top of Map) */
        .map-floating-bar {
            position: absolute;
            top: 14px;
            left: 14px;
            right: 14px;
            z-index: 1000;
            display: flex;
            justify-content: space-between;
            align-items: center;
            pointer-events: none;
            gap: 10px;
        }
        .map-floating-bar > * {
            pointer-events: auto;
        }
        .geocode-search-bar {
            display: flex;
            align-items: center;
            gap: 6px;
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(8px);
            padding: 6px 8px 6px 14px;
            border-radius: 9999px;
            border: 1px solid var(--k-border);
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
            width: 370px;
            max-width: 100%;
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
            border-radius: 9999px;
            padding: 6px 12px;
            font-size: 11px;
            font-weight: 700;
            cursor: pointer;
            white-space: nowrap;
            font-family: inherit;
        }

        .pinpoint-toast {
            background: rgba(17, 24, 39, 0.92);
            color: #FFFFFF;
            padding: 8px 16px;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 14px rgba(0,0,0,0.18);
        }

        /* Legend Box */
        .legend-box {
            position: absolute;
            z-index: 1000;
            bottom: 20px;
            left: 16px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(6px);
            padding: 12px 16px;
            border-radius: 16px;
            border: 1px solid var(--k-border);
            box-shadow: 0 4px 16px rgba(0,0,0,0.08);
            font-size: 11.5px;
            line-height: 1.75;
        }
        .legend-title {
            font-weight: 800;
            margin-bottom: 4px;
            color: var(--k-text);
            font-size: 12px;
        }
        .legend-item {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--k-text-secondary);
            font-weight: 500;
        }
        .legend-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            display: inline-block;
        }
        .dot-kantor { background: #10B981; }
        .dot-posko { background: #0284C7; }
        .dot-rumah { background: #F59E0B; }
        .dot-pin { background: #EF4444; }

        /* Flash Alert */
        .flash-banner {
            position: fixed;
            bottom: 24px;
            right: 24px;
            z-index: 2000;
            background: #064E3B;
            color: #FFFFFF;
            padding: 12px 20px;
            border-radius: 14px;
            font-size: 13px;
            font-weight: 700;
            box-shadow: 0 8px 24px rgba(6, 78, 59, 0.3);
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
            <span>✅ {{ session('success') }}</span>
            <button onclick="document.getElementById('flashBanner').remove()" style="background:none;border:none;color:#A7F3D0;cursor:pointer;font-weight:800;">✕</button>
        </div>
        <script>setTimeout(() => { const el = document.getElementById('flashBanner'); if (el) el.remove(); }, 5000);</script>
    @endif

    <!-- ─── TOP HEADER BAR (Desain Pengurus OpsiProyek1) ─── -->
    <header class="top-header">
        <a href="/admin" class="brand-box">
            <img src="/images/logo.png" alt="Logo Koperasi" onerror="this.style.display='none'">
            <div class="brand-text-wrap">
                <span class="brand-pill">Portal Sekretaris & GIS</span>
                <span class="brand-title">Koperasi Peduli Buruh Migran Indramayu</span>
            </div>
        </a>

        <!-- Center Pill Tabs -->
        <nav class="pill-nav" aria-label="Menu Utama Sekretaris">
            <a href="/admin" class="pill-tab">
                <span>Dashboard</span>
            </a>
            <a href="/admin/members" class="pill-tab">
                <span>Verifikasi & Anggota</span>
                @if(($stats['pending_members'] ?? 0) > 0)
                    <span class="pill-badge">{{ $stats['pending_members'] }}</span>
                @endif
            </a>
            <a href="/admin/branches" class="pill-tab">
                <span>Data Kantor & Posko</span>
                <span class="pill-badge">{{ $stats['total_branches'] ?? count($branches) }}</span>
            </a>
            <a href="/peta" class="pill-tab active">
                <span>🗺️ Peta GIS Interaktif</span>
            </a>
        </nav>

        <!-- Right Quick Actions -->
        <div class="header-actions">
            <button type="button" class="btn-action" id="btn-near" title="Cari Kantor/Posko Terdekat (Haversine)">
                <span>🎯</span>
                <span>Posko Terdekat</span>
            </button>
            <button type="button" class="btn-action primary" id="btn-toggle-pinpoint" onclick="togglePinpointMode()">
                <span id="pinpoint-btn-icon">📍</span>
                <span id="pinpoint-btn-text">+ Tambah via Pin-Point</span>
            </button>
        </div>
    </header>

    <!-- ─── MAIN WORKSPACE ─── -->
    <div class="workspace">

        <!-- LEFT BENTO PANEL -->
        <aside class="left-panel">

            <!-- VIEW 1: DAFTAR KANTOR & POSKO -->
            <div id="listViewContainer" style="display:flex; flex-direction:column; height:100%;">
                <div class="panel-header">
                    <div class="panel-eyebrow">
                        <div class="eyebrow-tag"><span></span> Direktori Spasial Migrant CARE</div>
                        <span class="count-pill">{{ count($branches) }} Titik Aktif</span>
                    </div>
                    <h2>Kantor & Posko Layanan</h2>
                    <p>Klik salah satu kartu untuk memusatkan peta atau klik langsung titik mana saja di peta untuk menambah lokasi baru.</p>
                </div>

                <div class="panel-controls">
                    <div class="search-box">
                        <span>🔍</span>
                        <input type="text" id="filterSearchInput" placeholder="Cari nama posko, desa, atau jalan..." oninput="filterCards()">
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
                            $badgeClass = match($b->jenis) {
                                'kantor' => 'badge-kantor',
                                'posko' => 'badge-posko',
                                'rumah_aman' => 'badge-rumah_aman',
                                default => 'badge-posko',
                            };
                            $badgeLabel = match($b->jenis) {
                                'kantor' => 'Kantor Operasional',
                                'posko' => 'Posko Layanan PMI',
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
                                <span class="badge {{ $badgeClass }}">{{ $badgeLabel }}</span>
                            </div>
                            <div class="branch-addr">{{ $b->alamat }}</div>
                            <div class="branch-footer">
                                @if($b->telepon)
                                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', $b->telepon) }}" class="phone-link" onclick="event.stopPropagation();">
                                        📞 {{ $b->telepon }}
                                    </a>
                                @else
                                    <span style="color:#9CA3AF;">Hotline Terpadu</span>
                                @endif
                                <div style="display:flex; gap:10px; align-items:center;">
                                    <a href="/admin/branches/{{ $b->id }}/edit" class="route-link" style="color:#09A46E;" onclick="event.stopPropagation();">
                                        ✏️ Edit
                                    </a>
                                    <a href="https://www.google.com/maps/dir/?api=1&destination={{ $b->latitude }},{{ $b->longitude }}"
                                       target="_blank"
                                       class="route-link"
                                       onclick="event.stopPropagation();">
                                        🧭 Rute Maps
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- VIEW 2: FORM TAMBAH PIN-POINT OTOMATIS -->
            <div id="pinpointFormContainer" class="pinpoint-form-container">
                <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:10px; padding-bottom:10px; border-bottom:1px solid #F0F3EF;">
                    <div>
                        <div class="eyebrow-tag"><span></span> Mode Pin-Point Otomatis</div>
                        <h3 style="margin:2px 0 0 0; font-size:16px; font-weight:800; color:#17211C;">Tambah Kantor / Posko Baru</h3>
                    </div>
                    <button type="button" onclick="togglePinpointMode(false)" style="background:#F0F3EF; border:none; border-radius:9999px; width:30px; height:30px; cursor:pointer; font-weight:800; color:#526158;">✕</button>
                </div>

                <div class="pin-guide-banner" id="pinStatusBanner">
                    💡 <strong>Klik di mana saja pada peta</strong> atau geser pin merah — koordinat <strong>Latitude, Longitude, dan Alamat</strong> di bawah akan terisi secara otomatis!
                </div>

                <form action="{{ route('peta.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Nama Kantor / Posko Layanan *</label>
                        <input type="text" name="nama" id="inputNama" class="form-input" placeholder="Contoh: Posko DESBUMI Desa Lombang" required>
                    </div>

                    <div class="coord-grid">
                        <div class="form-group">
                            <label class="form-label">Kategori Lokasi *</label>
                            <select name="jenis" id="inputJenis" class="form-select" required>
                                <option value="posko">Posko Layanan PMI</option>
                                <option value="kantor">Kantor Operasional</option>
                                <option value="rumah_aman">Rumah Aman</option>
                                <option value="mitra">Mitra Komunitas</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Hotline / Telepon PIC</label>
                            <input type="text" name="telepon" id="inputTelepon" class="form-input" placeholder="+62 813-xxxx-xxxx">
                        </div>
                    </div>

                    <div class="coord-grid">
                        <div class="form-group">
                            <label class="form-label">Latitude (Otomatis) *</label>
                            <input type="number" step="any" name="latitude" id="inputLat" class="form-input coord-badge-input" required readonly>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Longitude (Otomatis) *</label>
                            <input type="number" step="any" name="longitude" id="inputLng" class="form-input coord-badge-input" required readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Alamat Lengkap (Otomatis dari Pin Peta) *</label>
                        <textarea name="alamat" id="inputAlamat" rows="3" class="form-textarea" placeholder="Klik titik pada peta untuk mengisi alamat jalan/desa otomatis..." required></textarea>
                    </div>

                    <button type="submit" class="btn-submit-pin">
                        💾 Simpan Titik Lokasi Sekarang
                    </button>

                    <a href="/admin/branches/create" id="linkOpenFilament" class="btn-open-filament">
                        ↗️ Buka & Lanjutkan di Form Filament Admin
                    </a>
                </form>
            </div>

        </aside>

        <!-- RIGHT MAP BENTO -->
        <main class="map-bento">
            <div class="map-floating-bar">
                <!-- Search Location Bar on Map -->
                <div class="geocode-search-bar">
                    <span>🔎</span>
                    <input type="text" id="mapPlaceSearch" placeholder="Cari tempat/desa di peta (misal: Karangampel / Mampang)..." onkeydown="if(event.key==='Enter') searchPlaceOnMap()">
                    <button type="button" onclick="searchPlaceOnMap()" id="btnSearchPlace">Cari Peta</button>
                </div>

                <!-- Hint Badge -->
                <div class="pinpoint-toast" id="mapHintBadge">
                    <span>💡 Tips: Klik titik mana saja di peta untuk Pin-Point lokasi baru otomatis</span>
                </div>
            </div>

            <div id="map"></div>

            <!-- Legend -->
            <div class="legend-box">
                <div class="legend-title">🗺️ Indikator Titik Layanan</div>
                <div class="legend-item"><span class="legend-dot dot-kantor"></span> Kantor Operasional / Pusat (Hijau)</div>
                <div class="legend-item"><span class="legend-dot dot-posko"></span> Posko Layanan DESBUMI (Biru)</div>
                <div class="legend-item"><span class="legend-dot dot-rumah"></span> Rumah Aman & Konseling (Oranye)</div>
                <div class="legend-item"><span class="legend-dot dot-pin"></span> Pin-Point Baru / Lokasi Anda (Merah)</div>
            </div>
        </main>

    </div>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        const branches = @json($branches);
        let currentRegion = 'all';
        let isPinpointMode = false;
        let pinMarker = null;

        // Inisialisasi Peta
        const map = L.map('map', { zoomControl: false }).setView([-6.38, 107.60], 9);
        L.control.zoom({ position: 'bottomright' }).addTo(map);

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap | GIS Koperasi Peduli Buruh Migran Indramayu'
        }).addTo(map);

        // Marker Icons
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

        // Render Markers
        const markers = [];
        branches.forEach((b, i) => {
            let icon = blueIcon;
            let badgeBg = '#E0F2FE', badgeColor = '#0284C7', badgeText = 'Posko Layanan PMI';

            if (b.jenis === 'kantor') {
                icon = greenIcon;
                badgeBg = '#E8F7F1'; badgeColor = '#09A46E'; badgeText = 'Kantor Operasional';
            } else if (b.jenis === 'rumah_aman') {
                icon = orangeIcon;
                badgeBg = '#FEF3C7'; badgeColor = '#B45309'; badgeText = 'Rumah Aman';
            }

            const m = L.marker([b.latitude, b.longitude], { icon }).addTo(map);
            m.bindPopup(`
                <div style="min-width:220px; font-family:'Plus Jakarta Sans',sans-serif;">
                    <span style="font-size:10px; background:${badgeBg}; color:${badgeColor}; padding:3px 8px; border-radius:9999px; font-weight:800;">${badgeText}</span>
                    <h4 style="margin:8px 0 4px 0; font-size:14px; font-weight:800; color:#17211C;">${b.nama}</h4>
                    <p style="margin:0 0 8px 0; font-size:12px; color:#526158; line-height:1.45;">${b.alamat}</p>
                    <div style="font-family:monospace; font-size:10.5px; color:#09A46E; background:#F0FDF4; padding:3px 7px; border-radius:6px; margin-bottom:8px;">
                        📍 ${Number(b.latitude).toFixed(6)}, ${Number(b.longitude).toFixed(6)}
                    </div>
                    <div style="display:flex; justify-content:space-between; align-items:center; border-top:1px dashed #DCE3DE; padding-top:7px; font-size:11.5px;">
                        ${b.telepon ? `<a href="tel:${b.telepon}" style="color:#09A46E; font-weight:700; text-decoration:none;">📞 ${b.telepon}</a>` : '<span></span>'}
                        <a href="https://www.google.com/maps/dir/?api=1&destination=${b.latitude},${b.longitude}" target="_blank" style="color:#2563EB; font-weight:700; text-decoration:none;">🧭 Rute Maps</a>
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
            fillOpacity: 0.10,
            weight: 2,
            dashArray: '6, 6'
        }).addTo(map);
        areaIndramayu.bindPopup('<b>Wilayah Dampingan Utama Komunitas PMI Indramayu</b><br>Kecamatan Juntinyuat, Karangampel, & Krangkeng.');

        // GeoJSON Zona Koordinasi Jakarta
        L.geoJSON({
            "type": "Feature",
            "geometry": {
                "type": "Polygon",
                "coordinates": [[[106.81, -6.23], [106.87, -6.23], [106.87, -6.28], [106.81, -6.28], [106.81, -6.23]]]
            }
        }, {
            style: { color: '#0284C7', weight: 1.5, fillOpacity: 0.08, dashArray: '4, 4' }
        }).addTo(map).bindPopup('<b>Zona Koordinasi & Advokasi Nasional DKI Jakarta</b>');

        // ─── FITUR UTAMA: KLIK PETA (PIN-POINT) OTOMATIS ISI LATITUDE, LONGITUDE & ALAMAT ───
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
                btnText.textContent = 'Mode Pin-Point Aktif (Klik Peta)';

                if (!pinMarker) {
                    const center = map.getCenter();
                    activatePinpointAt(center.lat, center.lng);
                }
            } else {
                listEl.style.display = 'flex';
                formEl.classList.remove('active');
                btn.classList.remove('pin-active');
                btn.classList.add('primary');
                btnText.textContent = '+ Tambah via Pin-Point';
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

            pinMarker.bindPopup(`<b>📍 Titik Baru Terpilih</b><br><span style="font-family:monospace;font-size:11px;">${fLat}, ${fLng}</span>`).openPopup();

            const banner = document.getElementById('pinStatusBanner');
            banner.innerHTML = `⏳ <strong>Mendeteksi nama jalan/desa otomatis...</strong> (${fLat}, ${fLng})`;

            // Update link ke Filament Create
            const filamentLink = document.getElementById('linkOpenFilament');
            filamentLink.href = `/admin/branches/create?lat=${fLat}&lng=${fLng}`;

            // Reverse Geocoding Nominatim OpenStreetMap
            try {
                const res = await fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}&accept-language=id`);
                const data = await res.json();
                if (data && data.display_name) {
                    document.getElementById('inputAlamat').value = data.display_name;
                    filamentLink.href = `/admin/branches/create?lat=${fLat}&lng=${fLng}&alamat=${encodeURIComponent(data.display_name)}`;
                    banner.innerHTML = `✅ <strong>Koordinat & Alamat Terkunci!</strong> Silakan isi nama posko lalu klik Simpan.`;
                } else {
                    banner.innerHTML = `✅ <strong>Koordinat Terkunci (${fLat}, ${fLng})</strong>. Silakan lengkapi alamat di bawah.`;
                }
            } catch (err) {
                banner.innerHTML = `✅ <strong>Koordinat Terkunci (${fLat}, ${fLng})</strong>. Silakan ketik alamat di bawah.`;
            }
        }

        // Cari lokasi di peta via Nominatim
        async function searchPlaceOnMap() {
            const q = document.getElementById('mapPlaceSearch').value.trim();
            if (!q) return;
            const btn = document.getElementById('btnSearchPlace');
            btn.textContent = '⏳...';
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
                    alert('Tempat tidak ditemukan. Coba gunakan kata kunci seperti "Karangampel Indramayu" atau "Pancoran Jakarta".');
                }
            } catch (e) {
                alert('Gagal melakukan pencarian lokasi.');
            } finally {
                btn.textContent = 'Cari Peta';
            }
        }

        // Fokus ke cabang dari daftar kiri
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

        // Filter Wilayah & Pencarian Kartu
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

        // Rumus Haversine (Posko Terdekat)
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
            const btn = document.getElementById('btn-near');
            btn.innerHTML = '<span>⏳</span><span>Mendeteksi...</span>';

            navigator.geolocation.getCurrentPosition(pos => {
                btn.innerHTML = '<span>🎯</span><span>Posko Terdekat</span>';
                const { latitude, longitude } = pos.coords;
                let best = null;
                branches.forEach((b, i) => {
                    const d = jarakKm(latitude, longitude, b.latitude, b.longitude);
                    if (!best || d < best.d) best = { d, i };
                });

                if (userMarker) map.removeLayer(userMarker);
                userMarker = L.circleMarker([latitude, longitude], {
                    radius: 9, color: '#ffffff', weight: 2, fillColor: '#EF4444', fillOpacity: 0.95
                }).addTo(map).bindPopup('<b>📍 Lokasi Anda Saat Ini</b>').openPopup();

                if (best !== null) {
                    const b = branches[best.i];
                    markers[best.i].bindPopup(`
                        <div style="min-width:210px; font-family:'Plus Jakarta Sans',sans-serif;">
                            <span style="font-size:10px; background:#09A46E; color:#fff; padding:3px 8px; border-radius:9999px; font-weight:800;">⭐ POSKO TERDEKAT</span>
                            <h4 style="margin:7px 0 3px 0; font-size:14px; font-weight:800; color:#17211C;">${b.nama}</h4>
                            <p style="margin:0 0 6px 0; font-size:12px; color:#526158;">${b.alamat}</p>
                            <p style="margin:0; font-size:13px; font-weight:800; color:#09A46E;">Jarak: ${best.d.toFixed(2)} km</p>
                        </div>
                    `).openPopup();
                    map.fitBounds(L.latLngBounds([[latitude, longitude], [b.latitude, b.longitude]]).pad(0.3));
                    focusBranch(best.i);
                }
            }, () => {
                btn.innerHTML = '<span>🎯</span><span>Posko Terdekat</span>';
                alert('Gagal mengakses GPS. Pastikan izin lokasi browser sudah diaktifkan.');
            });
        });

        // Support URL Query (?lat=...&lng=...)
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
