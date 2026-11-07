@if(!request()->is('admin/login*'))
@php
    $isPeta = request()->is('peta*');
    $isMembers = request()->is('admin/members*');
    $isBranches = request()->is('admin/branches*');
    $isDashboard = !$isPeta && !$isMembers && !$isBranches;
    $currentUser = auth()->user();
@endphp

<style>
    .k-shared-navbar {
        height: 68px;
        background: rgba(247, 248, 245, 0.95);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border-bottom: 1px solid #E4EDE8;
        padding: 0 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: sticky;
        top: 0;
        z-index: 1050;
        width: 100%;
        font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        box-sizing: border-box;
        flex-shrink: 0;
    }

    .k-shared-navbar * {
        box-sizing: border-box;
    }

    .k-nav-brand {
        display: flex;
        align-items: center;
        gap: 12px;
        text-decoration: none !important;
        color: #17211C !important;
        flex-shrink: 0;
    }

    .k-nav-brand img {
        height: 38px;
        width: auto;
        object-fit: contain;
        display: block;
    }

    .k-nav-brand-title {
        font-size: 14px;
        font-weight: 700;
        color: #17211C;
        letter-spacing: -0.01em;
        white-space: nowrap;
    }

    /* Center Pill Navigation — Terkunci tepat di tengah layar agar 100% konsisten */
    .k-pill-nav {
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        align-items: center;
        gap: 4px;
        background: #FFFFFF;
        padding: 5px;
        border-radius: 9999px;
        border: 1px solid #E4EDE8;
        box-shadow: 0 2px 14px rgba(9, 164, 110, 0.04);
    }

    .k-pill-tab {
        padding: 7px 15px;
        border-radius: 9999px;
        font-size: 12px;
        font-weight: 600;
        color: #6B7280 !important;
        text-decoration: none !important;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.15s ease;
        white-space: nowrap;
        line-height: 1.2;
    }

    .k-pill-tab:hover {
        color: #111827 !important;
        background: #F2F6F4;
    }

    .k-pill-tab.active {
        background: #09A46E !important;
        color: #FFFFFF !important;
        font-weight: 700;
    }

    /* Right Actions */
    .k-nav-actions {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-shrink: 0;
    }

    .k-nav-btn {
        padding: 8px 14px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        cursor: pointer;
        transition: all 0.15s ease;
        border: 1px solid #DCE3DE;
        background: #FFFFFF;
        color: #17211C !important;
        text-decoration: none !important;
        font-family: inherit;
        line-height: 1.2;
    }

    .k-nav-btn:hover {
        border-color: #09A46E;
        color: #09A46E !important;
    }

    .k-nav-btn.primary {
        background: #09A46E;
        color: #FFFFFF !important;
        border-color: #09A46E;
    }

    .k-nav-btn.primary:hover {
        background: #064E3B;
        border-color: #064E3B;
        color: #FFFFFF !important;
    }

    .k-nav-btn.pin-active {
        background: #111827;
        color: #FFFFFF !important;
        border-color: #111827;
    }

    .k-user-pill {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 4px 12px 4px 5px;
        border-radius: 9999px;
        background: #FFFFFF;
        border: 1px solid #E4EDE8;
        font-size: 12px;
        font-weight: 600;
        color: #17211C;
    }

    .k-user-avatar {
        width: 28px;
        height: 28px;
        border-radius: 9999px;
        background: #09A46E;
        color: #FFFFFF;
        font-size: 11px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .k-logout-btn {
        width: 34px;
        height: 34px;
        border-radius: 9999px;
        background: #FFFFFF;
        border: 1px solid #E4EDE8;
        color: #6B7280;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.15s;
    }

    .k-logout-btn:hover {
        background: #FEF2F2;
        border-color: #FECACA;
        color: #DC2626;
    }

    @media (max-width: 1100px) {
        .k-pill-nav {
            position: static;
            transform: none;
        }
        .k-nav-brand-title {
            display: none;
        }
    }

    @media (max-width: 768px) {
        .k-shared-navbar {
            padding: 0 12px;
        }
        .k-pill-tab {
            padding: 6px 10px;
            font-size: 11px;
        }
    }
</style>

<header class="k-shared-navbar">
    <!-- Left: Brand Logo & Title -->
    <a href="/admin" class="k-nav-brand">
        <img src="/images/logo.png" alt="Logo Koperasi" onerror="this.style.display='none'">
        <span class="k-nav-brand-title">Koperasi Peduli Buruh Migran Indramayu</span>
    </a>

    <!-- Center: Consistent 4 Pill Navigation Tabs -->
    <nav class="k-pill-nav" aria-label="Menu Utama">
        <a href="/admin" class="k-pill-tab {{ $isDashboard ? 'active' : '' }}">
            Dashboard
        </a>
        <a href="/admin/members" class="k-pill-tab {{ $isMembers ? 'active' : '' }}">
            Manajemen Anggota
        </a>
        <a href="/admin/branches" class="k-pill-tab {{ $isBranches ? 'active' : '' }}">
            Data Kantor & Posko
        </a>
        <a href="/peta" class="k-pill-tab {{ $isPeta ? 'active' : '' }}">
            Peta GIS
        </a>
    </nav>

    <!-- Right: Contextual Actions & User Info -->
    <div class="k-nav-actions">
        @if($isPeta)
            <button type="button" class="k-nav-btn" id="btn-near">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="3 11 22 2 13 21 11 13 3 11"/></svg>
                <span id="near-btn-text">Lokasi Terdekat</span>
            </button>
            <button type="button" class="k-nav-btn primary" id="btn-toggle-pinpoint" onclick="togglePinpointMode()">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                <span id="pinpoint-btn-text">Tambah Titik Lokasi</span>
            </button>
        @else
            <a href="/admin/branches/create" class="k-nav-btn primary">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                <span>Tambah Titik Lokasi</span>
            </a>
            @if($currentUser)
                <div class="k-user-pill" title="{{ $currentUser->email }}">
                    <span class="k-user-avatar">{{ strtoupper(substr($currentUser->name, 0, 1)) }}</span>
                    <span>{{ explode(' ', $currentUser->name)[0] }}</span>
                </div>
                <form action="{{ filament()->getLogoutUrl() }}" method="POST" style="margin:0; display:inline-flex;">
                    @csrf
                    <button type="submit" class="k-logout-btn" title="Keluar (Logout)">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/></svg>
                    </button>
                </form>
            @endif
        @endif
    </div>
</header>
@endif
