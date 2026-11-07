<!-- Google Fonts: Plus Jakarta Sans (Identik dengan Dashboard Pengurus OpsiProyek1) -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">

<style>
    :root {
        --font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif !important;
        --k-primary: #09A46E;
        --k-primary-hover: #064E3B;
        --k-bg: #F7F8F5;
        --k-border: #DCE3DE;
        --k-border-soft: #E4EDE8;
    }

    body, .fi-body, .fi-main, .fi-simple-layout {
        font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif !important;
        background-color: #F7F8F5 !important;
        color: #17211C !important;
    }

    /* ─── TOPBAR PILL NAVIGATION (Identik dengan AdminLayout.tsx OpsiProyek1) ─── */
    .fi-topbar > nav {
        background-color: rgba(247, 248, 245, 0.92) !important;
        backdrop-filter: blur(12px) !important;
        border-bottom: 1px solid #E4EDE8 !important;
        box-shadow: none !important;
        min-height: 68px !important;
    }

    .fi-topbar-nav-groups {
        background: #FFFFFF !important;
        padding: 5px 6px !important;
        border-radius: 9999px !important;
        border: 1px solid #E4EDE8 !important;
        box-shadow: 0 2px 16px rgba(9, 164, 110, 0.05) !important;
        gap: 4px !important;
    }

    .fi-topbar-item-btn, .fi-topbar-item > a, .fi-topbar-item > button {
        border-radius: 9999px !important;
        padding: 7px 14px !important;
        font-size: 12px !important;
        font-weight: 600 !important;
        transition: all 0.2s ease !important;
    }

    .fi-topbar-item-active > a,
    .fi-topbar-item-active > button,
    .fi-topbar-item-btn.fi-active {
        background-color: #09A46E !important;
        color: #FFFFFF !important;
        font-weight: 700 !important;
        box-shadow: 0 2px 8px rgba(9, 164, 110, 0.25) !important;
    }

    .fi-topbar-item-active svg,
    .fi-topbar-item-btn.fi-active svg,
    .fi-topbar-item-active span {
        color: #FFFFFF !important;
    }

    /* ─── BENTO CARDS, SECTIONS & TABLES (Identik dengan MemberManagement.tsx) ─── */
    .fi-section,
    .fi-ta-ctn,
    .fi-wi-stats-overview-stat {
        border-radius: 18px !important;
        border: 1px solid #DCE3DE !important;
        box-shadow: 0 2px 12px rgba(9, 164, 110, 0.04) !important;
        background-color: #FFFFFF !important;
        overflow: hidden;
    }

    .fi-section-header {
        border-bottom: 1px solid #F0F3EF !important;
        padding: 18px 22px !important;
    }

    .fi-ta-header-cell {
        background-color: #F8FAF7 !important;
        font-size: 11px !important;
        font-weight: 700 !important;
        text-transform: uppercase !important;
        letter-spacing: 0.05em !important;
        color: #526158 !important;
    }

    /* ─── PRIMARY BUTTONS & INPUTS ─── */
    .fi-btn-color-primary {
        background-color: #09A46E !important;
        border-radius: 12px !important;
        font-weight: 700 !important;
        box-shadow: 0 4px 12px rgba(9, 164, 110, 0.2) !important;
    }
    .fi-btn-color-primary:hover {
        background-color: #064E3B !important;
    }

    .fi-input-wrp {
        border-radius: 12px !important;
        border-color: #DCE3DE !important;
        background-color: #FAFDFB !important;
    }
    .fi-input-wrp:focus-within {
        border-color: #09A46E !important;
        background-color: #FFFFFF !important;
        box-shadow: 0 0 0 3px rgba(9, 164, 110, 0.12) !important;
    }

    /* Page Header Title Styling */
    .fi-header-heading {
        font-weight: 800 !important;
        letter-spacing: -0.02em !important;
        color: #17211C !important;
    }
</style>

