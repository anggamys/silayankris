<style>
    /* ===== NAVLINK Hover + Active ===== */
    .navbar .nav-link {
        color: #555;
        padding-bottom: 4px;
        border-bottom: 2px solid transparent;
        transition: .2s ease;
    }

    .navbar .nav-link:hover,
    .navbar .nav-link.active {
        color: #008080 !important;
        border-bottom-color: #008080;
    }

    /* ===== MOBILE LAYOUT FIX ===== */
    @media (max-width: 991px) {

        .navbar {
            min-height: 60px;
            position: relative;
        }

        /* Container tinggi fix supaya logo tidak terdorong */
        .navbar .container {
            position: relative;
            height: 60px;
        }

        /* Collapse muncul sebagai panel di bawah navbar */
        .navbar-collapse {
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            background: #fff;
            padding: 12px 20px;
            z-index: 5;
        }

        /* Mobile Logo: benar-benar CENTER */
        .mobile-logo {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            z-index: 10;
        }

        /* Profile icon posisi kanan */
        .nav-profile-mobile {
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            z-index: 10;
        }

        /* Dropdown mobile tidak mepet */
        #navbarLanding .dropdown-menu {
            margin-left: 10px;
        }
    }
</style>
<nav class="navbar navbar-expand-lg bg-white shadow-sm py-3 position-relative">
    <div class="container">

        <!-- Toggle (Left - Mobile) -->
        <button class="navbar-toggler me-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarLanding">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Logo Mobile (Center) -->
        <a class="navbar-brand mobile-logo d-lg-none" href="/">
            <img src="{{ asset('assets/img/logo.png') }}" height="34">
        </a>

        <!-- Logo Desktop -->
        <a class="navbar-brand d-none d-lg-flex align-items-center gap-2" href="/">
            <img src="{{ asset('assets/img/logo.png') }}" height="34">
            <span class="fw-bold fs-5 text-primary">SILAYANKRIS</span>
        </a>

        <!-- Profile Mobile (Right) -->
        @auth
            <div class="nav-profile-mobile d-lg-none">
                <div class="dropdown">
                    <a data-bs-toggle="dropdown">
                        <img src="{{ $profilePhotoUrl ?? asset('assets/img/avatars/1.png') }}" class="rounded-circle"
                            width="40">
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end mt-2 shadow">
                        <li class="px-3 py-2">
                            <strong>{{ auth()->user()->name }}</strong><br>
                            <small class="text-muted">{{ auth()->user()->role }}</small>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#">Profil</a></li>
                        <li><a class="dropdown-item" href="{{ route('logout') }}">Keluar</a></li>
                    </ul>
                </div>
            </div>
        @endauth

        <!-- Menu (Collapse) -->
        <div class="collapse navbar-collapse justify-content-end" id="navbarLanding">

            <ul class="navbar-nav ms-lg-4 gap-lg-4">

                <li class="nav-item">
                    <a class="nav-link {{ request()->is('/') || request()->is('home') ? 'active' : '' }}"
                        href="/">Home</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->is(ltrim('berita*', '/')) ? 'active' : '' }}" href="/berita">Berita</a>
                </li>
                @guest
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('layanan') ? 'active' : '' }}" href="/layanan">Layanan</a>
                    </li>
                @endguest
                
                @auth
                @if (auth()->user()->role == 'guru' || auth()->user()->role == 'staff-gereja')
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Layanan</a>
                        <ul class="dropdown-menu">
                            @if (auth()->user()->role == 'guru')
                                <li><a class="dropdown-item" href="{{ route('user.perbulan.index') }}">Berkas Perbulan</a></li>
                                <li><a class="dropdown-item" href="{{ route('user.persemester.index') }}">Berkas Persemester</a></li>
                                <li><a class="dropdown-item" href="{{ route('user.pertahun.index') }}">Berkas Pertahun</a></li>
                            @endif
                            @if (auth()->user()->role == 'staff-gereja')
                                <li><a class="dropdown-item" href="/user/pendataan-gereja">Pendataan Gereja</a></li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if (auth()->user()->role == 'admin')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}"
                            href="/admin/dashboard">Dashboard</a>
                    </li>
                @endif
                @endauth
                
                @auth
                    <!-- Desktop Profile -->
                    <li class="nav-item dropdown d-none d-lg-block">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown">
                            <img src="{{ $profilePhotoUrl ?? asset('assets/img/avatars/1.png') }}"
                                class="rounded-circle me-2" width="35">
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end shadow">
                            <li class="px-3 py-2">
                                <strong>{{ auth()->user()->name }}</strong><br>
                                <small class="text-muted">{{ auth()->user()->role }}</small>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#">Profil</a></li>
                            <li><a class="dropdown-item" href="{{ route('logout') }}">Keluar</a></li>
                        </ul>
                    </li>
                @endauth

                @guest
                    <a href="/login" class="btn btn-primary px-4 py-2 rounded-3 fw-semibold mt-3 mt-lg-0">
                        Masuk
                    </a>
                @endguest

            </ul>

        </div>

    </div>
</nav>
