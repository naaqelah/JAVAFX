
{{-- resources/views/components/sidebar.blade.php --}}

<style>
    /* =====================================
       SIDEBAR BASE
    ===================================== */
    .app-sidebar,
    .app-sidebar * {
        box-sizing: border-box;
    }

    .app-sidebar {
        position: fixed;
        top: 0;
        left: 0;
        bottom: 0;
        width: 240px;
        height: 100vh;
        z-index: 1000;
        display: flex;
        flex-direction: column;
        padding: 14px 12px 12px;
        background: #141414;
        color: #fff;
        border-right: 1px solid #292929;
        font-family: 'Inter', system-ui, sans-serif;
        overflow-y: auto;
        overflow-x: hidden;
        transition: transform .28s ease, visibility .28s ease;
    }

    /* BRAND */
    .sidebar-brand {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 0 6px 12px;
        border-bottom: 1px solid #292929;
        flex-shrink: 0;
    }

    .brand-logo {
        width: 32px;
        height: 32px;
        flex: none;
        display: grid;
        place-items: center;
        border-radius: 8px;
        background: #A21E1E;
        color: #fff;
        font-size: 10px;
        font-weight: 700;
    }

    .brand-info h2 {
        margin: 0 0 2px;
        color: #fff;
        font-size: 13px;
        font-weight: 600;
        line-height: 1.2;
    }

    .brand-info span {
        color: #888;
        font-size: 10px;
        line-height: 1.2;
    }

    /* NAVIGATION */
    .sidebar-navigation {
        flex: 1;
        padding-top: 8px;
    }

    .nav-section {
        margin-bottom: 6px;
    }

    .nav-section-title {
        padding: 0 8px;
        margin: 0 0 2px;
        color: #777;
        font-size: 9px;
        font-weight: 600;
        line-height: 1.2;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    .nav-item {
        display: flex;
        align-items: center;
        gap: 10px;
        min-height: 32px;
        padding: 6px 10px;
        margin-bottom: 1px;
        border-radius: 7px;
        color: #aaa;
        text-decoration: none;
        font-size: 12px;
        font-weight: 500;
        transition: background .2s ease, color .2s ease;
    }

    .nav-item svg {
        width: 16px;
        height: 16px;
        flex: none;
    }

    .nav-item:hover {
        background: #222;
        color: #fff;
    }

    .nav-item.active {
        background: rgba(162, 30, 30, .18);
        color: #fff;
        border: 1px solid rgba(162, 30, 30, .35);
    }

    .nav-item.active svg {
        color: #e45b5b;
    }

    /* FOOTER */
    .sidebar-footer {
        flex-shrink: 0;
        padding: 10px 6px 2px;
        border-top: 1px solid #292929;
    }

    .footer-info {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 5px;
        color: #777;
        font-size: 9px;
    }

    .footer-dot {
        color: #555;
    }

    /* DESKTOP */
    .sidebar-overlay {
        display: none;
    }

    @media (min-width: 769px) {
        .app-sidebar {
            transform: translateX(0);
            visibility: visible;
        }
    }

    /* =====================================
       MOBILE RESPONSIVE
    ===================================== */
    @media (max-width: 768px) {
        .app-sidebar {
            position: fixed !important;
            top: 0;
            left: 0;
            bottom: 0;
            width: 240px;
            max-width: 85vw;
            height: 100dvh;
            z-index: 10000;
            padding: 14px 12px 12px;

            transform: translateX(-100%);
            visibility: hidden;

            box-shadow: 15px 0 40px rgba(0, 0, 0, .35);

            transition:
                transform .28s ease,
                visibility .28s ease;
        }

        .app-sidebar.mobile-open {
            transform: translateX(0);
            visibility: visible;
        }

        .sidebar-brand {
            padding-bottom: 12px;
        }

        .sidebar-navigation {
            padding-top: 8px;
        }

        .sidebar-overlay {
            display: block;
            position: fixed;
            inset: 0;
            z-index: 9999;
            background: rgba(0, 0, 0, .65);
            opacity: 0;
            visibility: hidden;
            pointer-events: none;

            transition:
                opacity .28s ease,
                visibility .28s ease;
        }

        .sidebar-overlay.active {
            opacity: 1;
            visibility: visible;
            pointer-events: auto;
        }

        body.sidebar-is-open {
            overflow: hidden;
        }
    }
</style>


{{-- =====================================
     SIDEBAR
===================================== --}}
<aside class="app-sidebar" id="appSidebar">

    {{-- SIDEBAR BRAND --}}
    <div class="sidebar-brand">
        <div class="brand-logo">JAVA</div>

        <div class="brand-info">
            <h2>Java Global Futures</h2>
            <span>Core Platform</span>
        </div>
    </div>


    {{-- NAVIGATION --}}
    <nav class="sidebar-navigation">

        {{-- TODAY --}}
        <div class="nav-section">
            <div class="nav-section-title">Today</div>

            <a href="{{ url('/my-work') }}"
               title="My Work"
               class="nav-item {{ request()->is('my-work') ? 'active' : '' }}">
                <svg><use href="#icon-list-checks"></use></svg>
                <span>My Work</span>
            </a>

            <a href="{{ url('/overview') }}"
               title="Overview"
               class="nav-item {{ request()->is('overview') ? 'active' : '' }}">
                <svg><use href="#icon-layout-dashboard"></use></svg>
                <span>Overview</span>
            </a>
        </div>


        {{-- PERFORMANCE --}}
        <div class="nav-section">
            <div class="nav-section-title">Performance</div>

            <a href="{{ url('/marketing-performance') }}"
               title="Marketing Performance"
               class="nav-item {{ request()->is('marketing-performance') ? 'active' : '' }}">
                <svg><use href="#icon-chart"></use></svg>
                <span>Marketing Performance</span>
            </a>

            <a href="{{ url('/social-media') }}"
               title="Social Media"
               class="nav-item {{ request()->is('social-media') ? 'active' : '' }}">
                <svg><use href="#icon-share"></use></svg>
                <span>Social Media</span>
            </a>

            <a href="{{ url('/team-scorecards') }}"
               title="Team Scorecards"
               class="nav-item {{ request()->is('team-scorecards') ? 'active' : '' }}">
                <svg><use href="#icon-users"></use></svg>
                <span>Team Scorecards</span>
            </a>
        </div>


        {{-- OPERATIONS --}}
        <div class="nav-section">
            <div class="nav-section-title">Operations</div>

            <a href="{{ url('/content-calendar') }}"
               title="Content Calendar"
               class="nav-item {{ request()->is('content-calendar') ? 'active' : '' }}">
                <svg><use href="#icon-calendar"></use></svg>
                <span>Content Calendar</span>
            </a>

            <a href="{{ url('/projects') }}"
               title="Project"
               class="nav-item {{ request()->is('projects') ? 'active' : '' }}">
                <svg><use href="#icon-square-check"></use></svg>
                <span>Project</span>
            </a>

            <a href="{{ url('/inventory') }}"
               title="Inventory"
               class="nav-item {{ request()->is('inventory*') ? 'active' : '' }}">
                <svg><use href="#icon-box"></use></svg>
                <span>Inventory</span>
            </a>

            <a href="{{ url('/promotors') }}"
               title="Promotors"
               class="nav-item {{ request()->is('promotors') ? 'active' : '' }}">
                <svg><use href="#icon-megaphone"></use></svg>
                <span>Promotors</span>
            </a>
        </div>


        {{-- SYSTEM --}}
        <div class="nav-section">
            <div class="nav-section-title">System</div>

            <a href="{{ url('/ai-assistant') }}"
               title="AI Assistant"
               class="nav-item {{ request()->is('ai-assistant') ? 'active' : '' }}">
                <svg><use href="#icon-terminal"></use></svg>
                <span>AI Assistant</span>
            </a>

            <a href="{{ url('/agent-office') }}"
               title="Agent Office"
               class="nav-item {{ request()->is('agent-office') ? 'active' : '' }}">
                <svg><use href="#icon-bot"></use></svg>
                <span>Agent Office</span>
            </a>

            <a href="{{ url('/integrations') }}"
               title="Integrations"
               class="nav-item {{ request()->is('integrations') ? 'active' : '' }}">
                <svg><use href="#icon-refresh"></use></svg>
                <span>Integrations</span>
            </a>
        </div>

    </nav>


    {{-- SIDEBAR FOOTER --}}
    <div class="sidebar-footer">
        <div class="footer-info">
            <span>Manager</span>
            <span class="footer-dot">·</span>
            <span>JAVAFX</span>
            <span class="footer-dot">·</span>
            <span>all modules</span>
        </div>
    </div>

</aside>


{{-- MOBILE OVERLAY --}}
<div class="sidebar-overlay" id="sidebarOverlay"></div>


{{-- =====================================
     SVG ICONS
===================================== --}}
<svg xmlns="http://www.w3.org/2000/svg" style="display:none">

    <symbol id="icon-list-checks" viewBox="0 0 24 24">
        <path d="M9 6h11M9 12h11M9 18h11M3 6l1 1 2-2M3 12l1 1 2-2M3 18l1 1 2-2"
              fill="none" stroke="currentColor" stroke-width="1.7"
              stroke-linecap="round" stroke-linejoin="round"/>
    </symbol>

    <symbol id="icon-layout-dashboard" viewBox="0 0 24 24">
        <rect x="3" y="3" width="8" height="8" rx="1.5"
              fill="none" stroke="currentColor" stroke-width="1.7"/>
        <rect x="14" y="3" width="7" height="5" rx="1.5"
              fill="none" stroke="currentColor" stroke-width="1.7"/>
        <rect x="14" y="11" width="7" height="10" rx="1.5"
              fill="none" stroke="currentColor" stroke-width="1.7"/>
        <rect x="3" y="14" width="8" height="7" rx="1.5"
              fill="none" stroke="currentColor" stroke-width="1.7"/>
    </symbol>

    <symbol id="icon-chart" viewBox="0 0 24 24">
        <path d="M4 20V12M10 20V5M16 20V9M22 20V2"
              fill="none" stroke="currentColor" stroke-width="1.7"
              stroke-linecap="round"/>
    </symbol>

    <symbol id="icon-share" viewBox="0 0 24 24">
        <circle cx="18" cy="5" r="3" fill="none"
                stroke="currentColor" stroke-width="1.7"/>
        <circle cx="6" cy="12" r="3" fill="none"
                stroke="currentColor" stroke-width="1.7"/>
        <circle cx="18" cy="19" r="3" fill="none"
                stroke="currentColor" stroke-width="1.7"/>
        <path d="m8.7 10.5 6.6-4M8.7 13.5l6.6 4"
              fill="none" stroke="currentColor" stroke-width="1.7"/>
    </symbol>

    <symbol id="icon-users" viewBox="0 0 24 24">
        <path d="M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2M10 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8ZM20 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"
              fill="none" stroke="currentColor" stroke-width="1.7"
              stroke-linecap="round"/>
    </symbol>

    <symbol id="icon-calendar" viewBox="0 0 24 24">
        <rect x="3" y="5" width="18" height="16" rx="2"
              fill="none" stroke="currentColor" stroke-width="1.7"/>
        <path d="M16 3v4M8 3v4M3 10h18"
              fill="none" stroke="currentColor" stroke-width="1.7"
              stroke-linecap="round"/>
    </symbol>

    <symbol id="icon-square-check" viewBox="0 0 24 24">
        <rect x="3" y="3" width="18" height="18" rx="2"
              fill="none" stroke="currentColor" stroke-width="1.7"/>
        <path d="m7 12 3 3 7-7"
              fill="none" stroke="currentColor" stroke-width="1.7"
              stroke-linecap="round" stroke-linejoin="round"/>
    </symbol>

    <symbol id="icon-box" viewBox="0 0 24 24">
        <path d="m12 2 9 5v10l-9 5-9-5V7l9-5Z"
              fill="none" stroke="currentColor" stroke-width="1.7"
              stroke-linejoin="round"/>
        <path d="m3.5 7.5 8.5 5 8.5-5M12 22V12.5"
              fill="none" stroke="currentColor" stroke-width="1.7"/>
    </symbol>

    <symbol id="icon-megaphone" viewBox="0 0 24 24">
        <path d="M3 11v2a2 2 0 0 0 2 2h3l10 5V4L8 9H5a2 2 0 0 0-2 2ZM8 15l2 6h4l-3-7"
              fill="none" stroke="currentColor" stroke-width="1.7"
              stroke-linejoin="round"/>
    </symbol>

    <symbol id="icon-terminal" viewBox="0 0 24 24">
        <rect x="3" y="3" width="18" height="18" rx="2"
              fill="none" stroke="currentColor" stroke-width="1.7"/>
        <path d="m7 9 3 3-3 3M13 15h4"
              fill="none" stroke="currentColor" stroke-width="1.7"
              stroke-linecap="round" stroke-linejoin="round"/>
    </symbol>

    <symbol id="icon-bot" viewBox="0 0 24 24">
        <rect x="4" y="7" width="16" height="13" rx="2"
              fill="none" stroke="currentColor" stroke-width="1.7"/>
        <path d="M12 3v4M8 12h.01M16 12h.01M9 16h6"
              fill="none" stroke="currentColor" stroke-width="1.7"
              stroke-linecap="round"/>
    </symbol>

    <symbol id="icon-refresh" viewBox="0 0 24 24">
        <path d="M20 7v5h-5M4 17v-5h5M5.5 9A7 7 0 0 1 18 6l2 6M4 12l2 6a7 7 0 0 0 12.5-3"
              fill="none" stroke="currentColor" stroke-width="1.7"
              stroke-linecap="round" stroke-linejoin="round"/>
    </symbol>

</svg>


{{-- =====================================
     MOBILE SIDEBAR SCRIPT
===================================== --}}
<script>
(function () {
    function initSidebar() {
        const sidebar = document.getElementById('appSidebar');
        const overlay = document.getElementById('sidebarOverlay');

        if (!sidebar || !overlay) return;

        const burger = document.getElementById('hdrBurger');

        function openSidebar() {
            sidebar.classList.add('mobile-open');
            overlay.classList.add('active');
            document.body.classList.add('sidebar-is-open');

            if (burger) {
                burger.setAttribute('aria-expanded', 'true');
                burger.setAttribute('aria-label', 'Close menu');
            }
        }

        function closeSidebar() {
            sidebar.classList.remove('mobile-open');
            overlay.classList.remove('active');
            document.body.classList.remove('sidebar-is-open');

            if (burger) {
                burger.setAttribute('aria-expanded', 'false');
                burger.setAttribute('aria-label', 'Open menu');
            }
        }

        // Menerima event dari tombol hamburger di app-header
        window.addEventListener('toggle-sidebar', function () {
            if (sidebar.classList.contains('mobile-open')) {
                closeSidebar();
            } else {
                openSidebar();
            }
        });

        // Klik overlay untuk menutup sidebar
        overlay.addEventListener('click', closeSidebar);

        // Escape untuk menutup sidebar
        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                closeSidebar();
            }
        });

        // Tutup setelah memilih menu
        sidebar.querySelectorAll('.nav-item').forEach(function (item) {
            item.addEventListener('click', closeSidebar);
        });

        // Tutup jika kembali ke desktop
        window.addEventListener('resize', function () {
            if (window.innerWidth > 768) {
                closeSidebar();
            }
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initSidebar);
    } else {
        initSidebar();
    }
})();
</script>
