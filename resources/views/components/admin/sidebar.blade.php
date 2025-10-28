<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
  <div class="app-brand demo">
    <a href="{{ route('admin.dashboard') }}" class="app-brand-link d-flex align-items-center">
      <span class="app-brand-logo demo">
        <img 
          src="{{ asset('assets/img/logo.png') }}" 
          alt="Logo" 
          style="height: 32px; width: auto; object-fit: contain;"
        >
      </span>
      <span class="app-brand-text demo menu-text fw-bolder ms-2 fs-5">SILAYANKRIS</span>
    </a>

    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
      <i class="bx bx-chevron-left bx-sm align-middle"></i>
    </a>
  </div>

  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-1 flex-grow-1">
    <!-- Dashboard -->
    <li class="menu-item {{ request()->is(ltrim("dashboard", '/')) ? 'active' : ''  }}">
      <a href="{{ route('admin.dashboard') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-home-circle"></i>
        <div>Dashboard</div>
      </a>
    </li>

    <!-- Master Data -->
    <li class="menu-header small text-uppercase">
      <span class="menu-header-text">Master Data</span>
    </li>

    <li class="menu-item {{ request()->is(ltrim("users", '/')) ? 'active' : ''  }}">
      <a href="/users" class="menu-link">
        <i class="menu-icon tf-icons bx bx-user"></i>
        <div>Pengguna</div>
      </a>
    </li>

    <li class="menu-item {{ request()->is(ltrim("institutes", '/')) ? 'active' : ''  }}">
      <a href="/institutes" class="menu-link">
        <i class="menu-icon tf-icons bx bx-building"></i>
        <div>Institusi</div>
      </a>
    </li>

    <li class="menu-item">
      <a href="/documents" class="menu-link">
        <i class="menu-icon tf-icons bx bx-file"></i>
        <div>Dokumen</div>
      </a>
    </li>
  </ul>

  <!-- PROFIL PENGGUNA -->
  <div class="menu-footer border-top p-3 mt-auto">
    <div class="d-flex align-items-center">
      <div class="avatar flex-shrink-0 me-3">
        <span class="avatar-initial rounded-circle bg-primary text-white fw-bold">
          {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
        </span>
      </div>
      <div class="d-flex flex-column">
        <span class="fw-semibold">{{ Auth::user()->name ?? 'Admin' }}</span>
        <small class="text-muted">{{ Auth::user()->role ?? 'Administrator' }}</small>
      </div>
    </div>
  </div>
</aside>
