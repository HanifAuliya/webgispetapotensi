@section('title', 'Tambah Lokasi')
<x-app-layout>
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm border-light">
                    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-0">Input Lokasi Baru</h5>
                            <p class="small mb-0">Gunakan form ini untuk menambahkan lokasi baru ke dalam sistem.
                                Pastikan semua data terisi dengan benar.</p>
                        </div>
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-light btn-sm">Kembali</a>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('location.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <!-- Nama Lokasi -->
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Potensi</label>
                                <input type="text" name="name" id="name" class="form-control"
                                    value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Kategori -->
                            <div class="mb-3">
                                <label for="category" class="form-label">Kategori</label>
                                <select name="category_id" id="category" class="form-control" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="additional_info" class="form-label">Informasi Tambahan</label>
                                <textarea name="additional_info" id="additional_info" class="form-control" rows="3"
                                    placeholder="Masukkan informasi tambahan tentang lokasi jika ada.">{{ old('additional_info') }}</textarea>
                                @error('additional_info')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>


                            <!-- Koordinat -->
                            <div class="mb-3">
                                <label for="coords" class="form-label">Koordinat (Latitude, Longitude)</label>
                                <input type="text" name="coords" id="coords" class="form-control"
                                    value="{{ old('coords') }}" required>
                                @error('coords')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Deskripsi -->
                            <div class="mb-3">
                                <label for="description" class="form-label">Deskripsi</label>
                                <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Instansi/Agency -->
                            <div class="mb-3">
                                <label for="agency" class="form-label">Instansi/Agency</label>
                                <input type="text" name="agency" id="agency" class="form-control"
                                    value="{{ old('agency') }}">
                                @error('agency')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Gambar Lokasi -->
                            <div class="mb-3">
                                <label for="image" class="form-label">Gambar Lokasi</label>
                                <input type="file" name="image" id="image" class="form-control">
                                @error('image')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- <!-- Informasi Tambahan -->
                            <div class="mb-3">
                                <label for="additional_info" class="form-label">Informasi Tambahan</label>
                                <textarea name="additional_info" id="additional_info" class="form-control">{{ old('additional_info') }}</textarea>
                                @error('additional_info')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div> --}}

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

    <!-- Hidden elements for SweetAlert2 -->
    <div id="error-alert" style="display: none;">
        @if ($errors->any())
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
    </div>

    <!-- SweetAlert2 Script -->
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
