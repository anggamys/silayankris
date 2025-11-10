<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'KEBAYAPAIS')</title>
    @vite(['resources/js/app.js', 'resources/scss/app.scss'])
    <style>
        /* Sidebar styling hijau Kemenag */
        .sidebar {
            background-color: #1b3a2f;
            /* hijau gelap */
            color: #e0f2f1;
            /* teks soft */
        }

        .sidebar .nav-link {
            color: #b2dfdb;
            /* teks link */
            padding: 12px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-radius: 8px;
            transition: all 0.25s ease;
            font-weight: 500;
        }

        .sidebar .nav-link:hover {
            background-color: #2a5d44;
            /* hover hijau medium */
            color: #fff;
            box-shadow: inset 0 0 8px rgba(0, 0, 0, 0.15);
            transform: translateX(3px);
        }

        .sidebar .nav-link.active {
            background-color: #4caf50;
            /* active hijau terang */
            color: #fff;
        }

        .sidebar .nav-link i {
            font-size: 20px;
        }

        .sidebar .sidebar-header {
            text-align: center;
            padding: 24px 12px;
            border-bottom: 1px solid #264d3c;
        }

        .sidebar .sidebar-header img {
            height: 50px;
            width: 50px;
            object-fit: contain;
        }

        .sidebar .sidebar-header h5 {
            margin-top: 8px;
            font-size: 1.2rem;
            font-weight: bold;
            color: #e0f2f1;
        }

        /* User Info styling */
        .sidebar .user-info {
            margin: 12px;
            padding: 16px;
            border-radius: 12px;
            background-color: rgba(255, 255, 255, 0.05);
            box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .sidebar .user-info .avatar img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #4caf50;
            margin-bottom: 8px;
        }

        .sidebar .user-info p {
            margin-bottom: 4px;
            font-size: 0.85rem;
            color: #c8e6c9;
        }

        .sidebar .user-info .fw-bold {
            color: #fff;
        }

        .sidebar .user-info .btn {
            width: 100%;
            border-radius: 25px;
            transition: all 0.2s;
        }

        .sidebar .user-info .btn:hover {
            background-color: #4caf50;
            color: #fff;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.25);
        }

        /* Mobile offcanvas styling */
        .offcanvas-body .nav-link {
            color: #1b3a2f;
        }

        .offcanvas-body .nav-link.active {
            font-weight: bold;
            color: #4caf50;
        }

        .offcanvas-body .nav-link:hover {
            color: #2a5d44;
        }

        .offcanvas-body .user-info-mobile {
            margin-top: auto;
            padding: 12px;
            text-align: center;
            border-top: 1px solid #264d3c;
        }

        .offcanvas-body .user-info-mobile p {
            margin-bottom: 4px;
            font-size: 0.85rem;
            color: #1b3a2f;
        }

        .offcanvas-body .user-info-mobile .fw-bold {
            color: #1b3a2f;
        }

        .offcanvas-body .user-info-mobile .btn:hover {
            background-color: #4caf50;
            color: #fff;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row min-vh-100">

            {{-- Sidebar desktop --}}
            <nav class="col-md-2 d-none d-md-block sidebar p-0">
                <div class="d-flex flex-column pt-3" style="position:sticky; top:0; height:100vh;">
                    <div class="sidebar-header">
                        <img src="{{ asset('/assets/images/logo.png') }}" alt="Logo">
                        <h5>KEBAYAPAIS</h5>
                    </div>

                    <ul class="nav flex-column mt-4 px-2">
                        <li class="nav-item mb-1">
                            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                                href="{{ route('admin.dashboard') }}">
                                <i class="bi bi-house"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item mb-1">
                            <a class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}"
                                href="{{ route('admin.users.index') }}">
                                <i class="bi bi-people"></i> Users
                            </a>
                        </li>
                    </ul>

                    <div class="user-info mt-auto">
                        <p class="fw-bold mb-0">{{ Auth::user()->name }}</p>
                        <p class="small mb-1">{{ ucfirst(Auth::user()->role) }}</p>
                        <p class="mb-3">{{ Auth::user()->email }}</p>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-light btn-sm">Logout</button>
                        </form>
                    </div>
                </div>
            </nav>

            {{-- Navbar mobile --}}
            <nav class="navbar bg-body-tertiary fixed-top d-md-none border-bottom">
                <div class="container-fluid">
                    <a class="navbar-brand fw-bold" href="{{ route('admin.dashboard') }}">
                        KEBAYAPAIS
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasSidebar" aria-controls="offcanvasSidebar"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
            </nav>

            {{-- Offcanvas sidebar mobile --}}
            <div class="offcanvas offcanvas-start d-md-none" tabindex="-1" id="offcanvasSidebar"
                aria-labelledby="offcanvasSidebarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasSidebarLabel">Menu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>

                <div class="offcanvas-body d-flex flex-column justify-content-between">
                    <ul class="nav flex-column">
                        <li class="nav-item mb-1">
                            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                                href="{{ route('admin.dashboard') }}">
                                <i class="bi bi-house"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item mb-1">
                            <a class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}"
                                href="{{ route('admin.users.index') }}">
                                <i class="bi bi-people"></i> Users
                            </a>
                        </li>
                        <li class="nav-item mb-1">
                            <a class="nav-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}"
                                href="/">
                                <i class="bi bi-gear"></i> Settings
                            </a>
                        </li>
                    </ul>

                    <div class="user-info-mobile border-top pt-3 mt-3 text-center">
                        <p class="fw-bold mb-1">{{ Auth::user()->name }}</p>
                        <p class="small mb-1">{{ ucfirst(Auth::user()->role) }}</p>
                        <p class="mb-2">{{ Auth::user()->email }}</p>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-light btn-sm w-100">Logout</button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Main content --}}
            <main class="col-md-10 ms-sm-auto px-4 py-4" style="background-color: #e8f5e9">
                <div class="pt-md-0 pt-5" style="overflow-y:auto;">
                    <nav aria-label="breadcrumb" class="mb-3">
                        <ol class="breadcrumb">
                            @yield('breadcrumb')
                        </ol>
                    </nav>

                    @yield('content')
                </div>
            </main>
        </div>
    </div>
</body>

</html>
