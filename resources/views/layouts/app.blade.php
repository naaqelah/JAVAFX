
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Java Global Futures')</title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

    @stack('styles')

    <style>
        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            min-height: 100%;
            background: #141414;
            color: #fff;
            font-family: 'Inter', system-ui, sans-serif;
        }

        .app-layout {
            min-height: 100vh;
            width: 100%;
        }

        .main-content {
            min-height: 100vh;
            margin-left: 240px;               /* was 285px */
            width: calc(100% - 240px);        /* was calc(100% - 285px) */
            min-width: 0;
            transition: margin-left .28s ease, width .28s ease;
        }

        .dashboard-main {
            width: 100%;
            min-width: 0;
            min-height: 100vh;
        }

        /* Overlay sidebar mobile */
        .sidebar-overlay {
            display: none;
        }

        @media (max-width: 768px) {
            .main-content {
                width: 100%;
                margin-left: 0;
                min-height: 100vh;
            }

            .dashboard-main {
                width: 100%;
                overflow-x: hidden;
            }

            .sidebar-overlay {
                display: block;
                position: fixed;
                inset: 0;
                z-index: 9998;
                background: rgba(0, 0, 0, .65);
                opacity: 0;
                visibility: hidden;
                transition: opacity .28s ease, visibility .28s ease;
            }

            .sidebar-overlay.active {
                opacity: 1;
                visibility: visible;
            }

            body.sidebar-is-open {
                overflow: hidden;
            }
        }
    </style>
</head>

<body>
    <div class="app-layout">

        @include('components.sidebar')

        <div class="sidebar-overlay" id="sidebarOverlay"></div>

        <main class="main-content">
            <div class="dashboard-main">

                @include('components.header')

                @yield('content')

            </div>
        </main>

    </div>

    @stack('scripts')
</body>
</html>
