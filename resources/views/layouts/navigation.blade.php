<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">


        <a class="navbar-brand text-primary fw-bold" href="{{ route('dashboard') }}">
            <img src="{{ '../assets/images/tabalong.png' }}" alt="Logo" width="60" class="me-2" />
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>



        <!-- Navbar Links -->
        <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
            <!-- Navbar Kiri -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active text-primary' : '' }}"
                        href="{{ route('dashboard') }}">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('location.create') ? 'active text-primary' : '' }}"
                        href="{{ route('location.create') }}">Lokasi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('category.create') ? 'active text-primary' : '' }}"
                        href="{{ route('category.create') }}">Kategori</a>
                </li>
            </ul>

            <!-- Navbar Kanan -->
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('landing') }}">Halaman Utama</a>
                </li>
                <!-- Dropdown Profile & Logout -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        {{ Auth::user()->name }} <!-- Nama User -->
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('profile.edit') ? 'active text-primary' : '' }}"
                                href="{{ route('profile.edit') }}">Profile</a>
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>



    </div>
</nav>
