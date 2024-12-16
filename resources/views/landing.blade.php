<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webgis Potensi Tabalong</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.css">


    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- css -->
    <link rel="stylesheet" href="{{ '../assets/css/style.css' }}" />

    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    <link rel="icon" href="{{ asset('assets/images/tabalong.png') }}" type="image/x-icon">


</head>

<body>
    <!-- Header -->
    <div id="header"
        class="d-flex align-items-center justify-content-between bg-light shadow-sm px-4 py-2 sticky-top">
        <!-- Logo dan Judul -->
        <div class="d-flex align-items-center">
            <img src="{{ '../assets/images/tabalong.png' }}" alt="Logo" width="60" class="me-2" />
            <h1 style="font-size: 1.5rem">
                Peta Potensi dan Peluang Investasi
                <br />
                <small class="text-muted" style="font-size: 0.9rem">
                    Kabupaten Tabalong
                </small>
            </h1>
        </div>


        <!-- Menu Navigasi -->
        <div class="nav-buttons">
            <!-- Tombol Menu untuk Mobile -->
            <button id="toggleSidebarBtn" class="btn btn-warning">List Potensi</button>
            @auth
                <!-- Jika sudah login, tampilkan tombol ke Dashboard -->
                <a class="btn btn-outline-primary" href="{{ route('dashboard') }}">Dashboard</a>
            @else
                <!-- Jika belum login, tampilkan tombol ke Login -->
                <a class="btn btn-outline-primary" href="{{ route('login') }}">Login</a>
            @endauth
        </div>


    </div>
    <!-- Main Content -->
    <div class="container-flex d-flex">
        <!-- Sidebar -->
        <div id="sidebar" class="col-3">
            <h4 class="mb-4">Daftar Kategori</h4>
            <div class="row flex-column">
                <!-- Tambahkan flex-column untuk memastikan tampil vertikal -->
                @foreach ($categories as $category)
                    <div class="col mb-3">
                        <div class="card btn-category w-100" onclick="toggleCategory('{{ $category->name }}', this)">
                            <div class="card-body d-flex align-items-center">
                                <img src="{{ asset('storage/' . $category->icon) }}" alt="Icon Kategori" width="30"
                                    class="me-2">
                                <span>{{ $category->name }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <button class="btn btn-danger w-100 mb-3" onclick="resetMarkers()">Reset</button>
        </div>
        <!-- Map -->
        <div id="map" class="col-9"></div>

        <!-- Modal -->
        @foreach ($locations as $location)
            <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="imageModalLabel">Detail Gambar</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                            <img src="" alt="Gambar Lokasi" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const sidebar = document.getElementById("sidebar");
            const toggleSidebarBtn = document.getElementById("toggleSidebarBtn");

            // Toggle Sidebar
            toggleSidebarBtn.addEventListener("click", () => {
                sidebar.classList.toggle("active");
            });

            // Tutup Sidebar jika klik di luar area pada perangkat kecil
            document.addEventListener("click", function(e) {
                if (!sidebar.contains(e.target) && !toggleSidebarBtn.contains(e.target)) {
                    sidebar.classList.remove("active");
                }
            });
        });
    </script>
    <script>
        const categories = @json($categories);
        const locations = @json($locations);
    </script>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
    <!-- leafglet zip -->
    <script src="https://unpkg.com/shpjs/dist/shp.min.js"></script>

    {{-- sweet alert 2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="{{ '../assets/js/script.js' }}"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


</body>

</html>
