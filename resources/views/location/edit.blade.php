@section('title', 'Edit')
<x-app-layout>
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm border-light">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Edit Lokasi</h5>
                        <p class="small mb-0">Gunakan form ini untuk mengubah data lokasi yang sudah terdaftar. Pastikan
                            semua data terisi dengan benar sebelum menyimpan perubahan.</p>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('location.update', $location->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')

                            <!-- Nama Lokasi -->
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Potensi</label>
                                <input type="text" name="name" id="name" class="form-control"
                                    value="{{ old('name', $location->name) }}" required>
                                @error('name')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Kategori -->
                            <div class="mb-3">
                                <label for="category_id" class="form-label">Kategori</label>
                                <select name="category_id" id="category_id" class="form-select" required>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ $location->category_id == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Informasi Tambahan -->
                            <div class="mb-3">
                                <label for="additional_info" class="form-label">Informasi Tambahan</label>
                                <textarea name="additional_info" id="additional_info" class="form-control" rows="3"
                                    placeholder="Tambahkan informasi tambahan terkait lokasi jika ada.">{{ old('additional_info', $location->additional_info) }}</textarea>
                                @error('additional_info')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Koordinat -->
                            <div class="mb-3">
                                <label for="coords" class="form-label">Koordinat</label>
                                <mark class="small p-0">Cttn: jangan ada spasi</mark>

                                <input type="text" name="coords" id="coords" class="form-control"
                                    value="{{ old('coords', $location->coords) }}" required>
                                @error('coords')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Gambar -->
                            <div class="mb-3">
                                <label for="image" class="form-label">Gambar Lokasi </label>
                                @if ($location->image)
                                    <img src="{{ asset('storage/' . $location->image) }}" alt="Gambar Lokasi"
                                        width="100" class="d-block mb-2">
                                @endif
                                <input type="file" name="image" id="image" class="form-control">
                                @error('image')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Deskripsi -->
                            <div class="mb-3">
                                <label for="description" class="form-label">Deskripsi</label>
                                <textarea name="description" id="description" class="form-control">{{ old('description', $location->description) }}</textarea>
                                @error('description')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Instansi -->
                            <div class="mb-3">
                                <label for="agency" class="form-label">Instansi</label>
                                <input type="text" name="agency" id="agency" class="form-control"
                                    value="{{ old('agency', $location->agency) }}">
                                @error('agency')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                <a href="{{ route('dashboard') }}" class="btn btn-secondary">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Hidden SweetAlert Messages -->
    <div id="success-alert" style="display: none;">
        @if (session('success'))
            {{ session('success') }}
        @endif
    </div>
    <div id="error-alert" style="display: none;">
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        @endif
    </div>

    <!-- SweetAlert Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Success Alert
            const successAlert = document.getElementById('success-alert');
            if (successAlert && successAlert.innerHTML.trim()) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: successAlert.innerHTML.trim()
                });
            }

            // Error Alert
            const errorAlert = document.getElementById('error-alert');
            if (errorAlert && errorAlert.innerHTML.trim()) {
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    html: errorAlert.innerHTML.trim()
                });
            }
        });
    </script>
</x-app-layout>
