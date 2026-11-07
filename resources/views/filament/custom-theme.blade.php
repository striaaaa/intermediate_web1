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

    /* Sembunyikan Topbar & Sidebar bawaan Filament karena kita memakai Shared Navbar yang identik dengan /peta */
    .fi-topbar,
    .fi-sidebar,
    .fi-sidebar-close-overlay {
        display: none !important;
    }

    /* Bento Cards, Sections & Tables */
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

    /* Primary Buttons & Inputs */
    .fi-btn-color-primary {
        background-color: #09A46E !important;
        border-radius: 12px !important;
        font-weight: 700 !important;
        box-shadow: none !important;
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

    .fi-header-heading {
        font-weight: 800 !important;
        letter-spacing: -0.02em !important;
        color: #17211C !important;
    }
</style>
