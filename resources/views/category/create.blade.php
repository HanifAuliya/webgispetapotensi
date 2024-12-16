<x-app-layout>
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">


                <!-- Tabel Daftar Kategori -->
                <div class="card shadow-sm border-light ">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">Daftar Kategori</h5>
                        <p class="small mb-0">Berikut adalah daftar kategori yang telah ditambahkan. Anda dapat
                            menghapus kategori yang tidak digunakan.</p>
                    </div>
                    <div class="card-body">
                        @if ($categories->isEmpty())
                            <p class="text-muted">Belum ada kategori yang tersedia.</p>
                        @else
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Kategori</th>
                                        <th>Icon</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $index => $category)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $category->name }}</td>
                                            <td>
                                                @if ($category->icon)
                                                    <img src="{{ asset('storage/' . $category->icon) }}" alt="Icon"
                                                        width="30">
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-danger delete-button"
                                                    data-id="{{ $category->id }}"
                                                    data-name="{{ $category->name }}">Hapus</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>

                <!-- Tambah Kategori -->
                <div class="card shadow-sm border-light mt-4">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-0">Tambah Kategori Baru</h5>
                            <p class="small mb-0">Gunakan form ini untuk menambahkan kategori baru ke dalam sistem.</p>
                        </div>
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-light btn-sm">Kembali ke Dashboard</a>
                    </div>
                    <div class="card-body">
                        <!-- Form Tambah Kategori -->
                        <form action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- Nama Kategori -->
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Kategori</label>
                                <input type="text" name="name" id="name" class="form-control"
                                    value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Icon Kategori -->
                            <div class="mb-3">
                                <label for="icon" class="form-label">Icon Kategori</label>
                                <input type="file" name="icon" id="icon" class="form-control">
                                @error('icon')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Tombol Submit -->
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('dashboard') }}" class="btn btn-secondary">Batal</a>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SweetAlert Script -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: '{{ session('success') }}'
                });
            @endif

            // Konfirmasi Hapus
            const deleteButtons = document.querySelectorAll('.delete-button');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const categoryId = this.dataset.id;
                    const categoryName = this.dataset.name;

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: `Kategori "${categoryName}" akan dihapus secara permanen.`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, Hapus',
                        cancelButtonText: 'Batal',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Kirim request delete menggunakan form
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = `/category/${categoryId}`;
                            form.innerHTML = `
                                @csrf
                                @method('DELETE')
                            `;
                            document.body.appendChild(form);
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
</x-app-layout>
