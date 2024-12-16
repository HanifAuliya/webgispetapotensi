<x-app-layout>
    <div class="py-4">
        <div class="container">
            <div class="row">
                <!-- Header Card -->
                <div class="col-12 mb-4">
                    <div class="card h-100 border-light shadow-sm">
                        <div class="card-body">
                            <h2 class="h5 fw-semibold text-dark mb-0">
                                {{ __('Dashboard - Daftar Lokasi') }}
                            </h2>
                            <p class="text-muted small">
                                Halaman ini menampilkan daftar lokasi yang sudah terdaftar. Anda dapat mencari lokasi
                                berdasarkan nama, kategori, atau instansi, dan juga dapat menambahkan atau menghapus
                                data.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons Card -->
                <div class="col-12 mb-4">
                    <div class="card h-100 border-light shadow-sm">
                        <div class="card-body d-flex align-items-center justify-content-between flex-wrap">
                            <!-- Keterangan -->
                            <div class="mb-2 mb-md-0">
                                <h5 class="fw-semibold mb-0 text-dark">Aksi Cepat</h5>
                                <p class="text-muted small mb-0">
                                    Gunakan tombol berikut untuk menambahkan lokasi baru atau kategori lokasi baru.
                                </p>
                            </div>
                            <!-- Tombol Aksi -->
                            <div class="d-flex gap-2">
                                <a href="{{ route('category.create') }}" class="btn btn-outline-info btn-sm">Tambah
                                    Kategori</a>
                                <a href="{{ route('location.create') }}" class="btn btn-outline-success btn-sm">Tambah
                                    Lokasi</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Search Form -->
                <div class="col-md-12 mb-3">
                    <form method="GET" action="{{ route('dashboard') }}" class="d-flex align-items-center">
                        <div class="flex-grow-1 me-2">
                            <input type="text" name="search" class="form-control" placeholder="Cari lokasi..."
                                value="{{ request('search') }}">
                        </div>
                        <div class="me-2">
                            <select name="category_filter" class="form-select">
                                <option value="">-- Semua Kategori --</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ request('category_filter') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary ">Search</button>
                        </div>
                    </form>
                </div>


                <!-- Card Table -->
                <div class="col-12">
                    <div class="card h-100 border-light shadow-sm">
                        <div class="card-body">
                            @if ($locations->isEmpty())
                                <!-- Pesan jika tidak ada hasil -->
                                <div class="alert alert-warning text-center" role="alert">
                                    <strong>Tidak ada hasil ditemukan.</strong> Coba gunakan kata kunci atau filter
                                    lain.
                                </div>
                            @else
                                <!-- Table Scrollable -->
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th class="text-center" style="width: 50px;">No</th>
                                                <th>Nama Potensi</th>
                                                <th>Kategori</th>
                                                <th>Alamat</th>
                                                <th>Instansi</th>
                                                <th>Gambar</th>
                                                <th>Deskripsi</th>
                                                <th>Coordinate</th>
                                                <th class="text-center" style="width: 150px;">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($locations as $location)
                                                <tr>
                                                    <td class="text-center">{{ $loop->iteration }}</td>
                                                    <td>{{ $location->name }}</td>
                                                    <td>{{ $location->category->name ?? '-' }}</td>
                                                    <td>{{ $location->additional_info }}</td>
                                                    <td>{{ $location->agency }}</td>
                                                    <td class="text-center">
                                                        @if ($location->image)
                                                            <img src="{{ asset('storage/' . $location->image) }}"
                                                                alt="Gambar Lokasi" width="50" class="rounded">
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <!-- Deskripsi Singkat -->
                                                        <div class="description" id="description-{{ $location->id }}">
                                                            {{ Str::limit($location->description, 100) }}
                                                        </div>
                                                        <!-- Teks "Lihat Selengkapnya" -->
                                                        @if (strlen($location->description) > 100)
                                                            <div class="see-more-container">
                                                                <span class="see-more"
                                                                    onclick="showFullDescription({{ $location->id }})">
                                                                    Lihat Selengkapnya
                                                                </span>
                                                            </div>
                                                        @endif

                                                        <!-- Deskripsi Lengkap -->
                                                        <div class="description-full d-none"
                                                            id="description-full-{{ $location->id }}">
                                                            {{ $location->description }}
                                                            <div class="see-less-container">
                                                                <span class="see-less"
                                                                    onclick="showShortDescription({{ $location->id }})">
                                                                    Sembunyikan
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </td>


                                                    <td>{{ $location->coords }}</td>
                                                    <td class="text-center">
                                                        <!-- Tombol Aksi -->
                                                        <div class="d-flex justify-content-center gap-2">
                                                            <!-- Tombol Edit -->
                                                            <a href="{{ route('location.edit', $location->id) }}"
                                                                class="btn btn-sm btn-warning">Edit</a>
                                                            <!-- Tombol Delete -->
                                                            <form
                                                                action="{{ route('dashboard.destroy', $location->id) }}"
                                                                method="POST" class="delete-form">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="button"
                                                                    class="btn btn-sm btn-danger delete-button">Hapus</button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Pagination Links -->
                                <div class="d-flex justify-content-center mt-3">
                                    {{ $locations->links() }}
                                </div>
                            @endif

                            <script>
                                function showFullDescription(id) {
                                    // Sembunyikan deskripsi singkat
                                    document.getElementById(`description-${id}`).classList.add('d-none');
                                    // Sembunyikan "Lihat Selengkapnya"
                                    document.querySelector(`#description-${id} + .see-more-container`).classList.add('d-none');
                                    // Tampilkan deskripsi lengkap
                                    document.getElementById(`description-full-${id}`).classList.remove('d-none');
                                }

                                function showShortDescription(id) {
                                    // Sembunyikan deskripsi lengkap
                                    document.getElementById(`description-full-${id}`).classList.add('d-none');
                                    // Tampilkan deskripsi singkat
                                    document.getElementById(`description-${id}`).classList.remove('d-none');
                                    // Tampilkan "Lihat Selengkapnya"
                                    document.querySelector(`#description-${id} + .see-more-container`).classList.remove('d-none');
                                }
                            </script>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div id="success-alert" style="display: none;">
        @if (session('success'))
            {{ session('success') }}
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const successAlert = document.getElementById('success-alert');
            if (successAlert && successAlert.innerHTML.trim()) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: successAlert.innerHTML.trim()
                });
            }

            const deleteButtons = document.querySelectorAll('.delete-button');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const form = this.closest('.delete-form');

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Data ini tidak dapat dikembalikan setelah dihapus!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
</x-app-layout>
