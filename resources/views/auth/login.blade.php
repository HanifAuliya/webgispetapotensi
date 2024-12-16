<x-guest-layout>

    <div class="row w-100 h-100">

        <!-- Kiri - Gambar dan Penjelasan -->
        <div class="col-md-7 d-flex flex-column justify-content-center align-items-center px-5">
            <!-- Gambar -->
            <div class="mb-4">
                <img src="{{ asset('assets/images/location.png') }}" alt="Ilustrasi" class="img-fluid"
                    style="max-width: 300px;">
            </div>

            <!-- Penjelasan -->
            <div class="text-center">
                <h2 class="fw-bold mb-3">Peta Potensi dan Peluang Investasi</h2>
                <p class="text-muted">
                    Aplikasi ini menyediakan <span class="text-primary fw-semibold">data lokasi</span> serta
                    <span class="text-primary fw-semibold">informasi kategori potensi</span> yang ada di Kabupaten
                    Tabalong.
                    Dirancang untuk memudahkan pengguna dalam mencari, mengakses, dan mengelola data potensi serta
                    peluang investasi
                    secara <span class="text-primary fw-semibold">terstruktur</span> dan <span
                        class="text-primary fw-semibold">interaktif</span>.
                </p>
            </div>

        </div>

        <!-- Kanan - Form Login -->
        <div class="ml-2 col-md-5 d-flex justify-content-center align-items-center bg-white shadow-sm rounded-5">
            <div class="p-5 rounded-3" style="max-width: 400px; width: 100%;">
                <!-- Header -->
                <div class="text-center mb-4">
                    <h3 class="fw-bold">Login</h3>
                    <p class="text-muted small">Dengan Email</p>
                </div>

                <!-- Form Login -->
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input id="username" type="text" name="username" value="{{ old('username') }}"
                            class="form-control @error('username') is-invalid @enderror" required autofocus>
                        @error('username')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input id="password" type="password" name="password"
                            class="form-control @error('password') is-invalid @enderror" required>
                        @error('password')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Lupa Password -->
                    <div class="d-flex justify-content-end mb-3">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="small text-primary text-decoration-none">
                                Lupa Password ?
                            </a>
                        @endif
                    </div>

                    <!-- Tombol Login -->
                    <div class="d-grid">
                        <button type="submit" class="btn btn-dark">Login</button>
                    </div>

                    <!-- Info Tambahan -->
                    <p class="text-danger small text-center mt-3">
                        Login website ini hanya untuk pegawai DPMPTSP.
                    </p>
                </form>

                <!-- Footer -->
                <div class="text-center mt-4 small text-muted">
                    © Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu<br>
                    Kabupten Tabalong
                </div>
            </div>
        </div>
    </div>

    <!-- Styling Tambahan -->
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .shadow-sm {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1) !important;
        }
    </style>
</x-guest-layout>
