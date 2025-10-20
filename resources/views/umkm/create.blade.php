@extends('layout')

@section('content')
    <div class="container mt-5" style="padding-top: 90px">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">Daftarkan UMKM</h4>
                            <a href="{{ route('umkm.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('umkm.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <!-- Nama UMKM -->
                                <div class="col-md-6 mb-3">
                                    <label for="nama" class="form-label">Nama UMKM <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nama" name="nama"
                                        value="{{ old('nama') }}" required>
                                </div>

                                <!-- Jenis Usaha -->
                                <div class="col-md-6 mb-3">
                                    <label for="jenis" class="form-label">Jenis Usaha <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select" id="jenis" name="jenis" required>
                                        <option value="">Pilih Jenis Usaha</option>
                                        <option value="Makanan dan Minuman"
                                            {{ old('jenis') == 'Makanan dan Minuman' ? 'selected' : '' }}>Makanan dan
                                            Minuman</option>
                                        <option value="Pakaian dan Aksesoris"
                                            {{ old('jenis') == 'Pakaian dan Aksesoris' ? 'selected' : '' }}>Pakaian dan
                                            Aksesoris</option>
                                        <option value="Jasa" {{ old('jenis') == 'Jasa' ? 'selected' : '' }}>Jasa</option>
                                        <option value="Kerajinan Tangan"
                                            {{ old('jenis') == 'Kerajinan Tangan' ? 'selected' : '' }}>Kerajinan Tangan
                                        </option>
                                        <option value="Elektronik" {{ old('jenis') == 'Elektronik' ? 'selected' : '' }}>
                                            Elektronik</option>
                                        <option value="Kesehatan" {{ old('jenis') == 'Kesehatan' ? 'selected' : '' }}>
                                            Kesehatan</option>
                                        <option value="Transportasi"
                                            {{ old('jenis') == 'Transportasi' ? 'selected' : '' }}>Transportasi</option>
                                        <option value="Pendidikan" {{ old('jenis') == 'Pendidikan' ? 'selected' : '' }}>
                                            Pendidikan</option>
                                        <option value="Teknologi" {{ old('jenis') == 'Teknologi' ? 'selected' : '' }}>
                                            Teknologi</option>
                                    </select>
                                </div>

                                <!-- Owner -->
                                <div class="col-md-6 mb-3">
                                    <label for="owner" class="form-label">Nama Pemilik <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="owner" name="owner"
                                        value="{{ old('owner') }}" required>
                                </div>

                                <!-- Link Google Maps (Opsional) -->
                                <div class="col-md-12 mb-3">
                                    <label for="input_url" class="form-label">Link Google Maps (Opsional)</label>
                                    <div class="input-group">
                                        <input type="url" class="form-control" id="input_url" name="input_url"
                                            value="{{ old('input_url') }}"
                                            placeholder="Contoh: https://maps.app.goo.gl/jJwhxr7QvHh5P3SVA atau https://www.google.com/maps/place/...">
                                        <button type="button" class="btn btn-outline-secondary"
                                            id="previewBtn">Preview</button>
                                    </div>
                                    <small class="text-muted">
                                        <strong>Cara mendapat link:</strong><br>
                                        1. Buka Google Maps → 2. Cari lokasi usaha → 3. Klik 'Bagikan' → 4. Copy link dan
                                        paste di sini<br>
                                        <strong>Mendukung:</strong> Link pendek (maps.app.goo.gl) dan link panjang Google
                                        Maps
                                    </small>
                                    <!-- Preview Iframe -->
                                    <div id="previewContainer" class="mt-3" style="display:none;">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <label class="form-label mb-0">Preview Google Maps:</label>
                                            <small class="text-muted">Klik peta untuk membuka di Google Maps</small>
                                        </div>
                                        <div class="ratio ratio-16x9 position-relative"
                                            style="border:1px solid #e5e7eb;border-radius:12px;overflow:hidden;">
                                            <iframe id="previewIframe" src=""
                                                style="border:0; width:100%; height:100%;" loading="lazy"
                                                referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
                                            <!-- Clickable overlay -->
                                            <div id="mapClickOverlay" class="position-absolute top-0 start-0 w-100 h-100"
                                                style="background: transparent; cursor: pointer; z-index: 10;"
                                                onclick="openOriginalMap()" title="Klik untuk membuka di Google Maps"></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Email -->
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email <span
                                            class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="{{ old('email') }}" required>
                                </div>

                                <!-- Nomor Telepon -->
                                <div class="col-md-6 mb-3">
                                    <label for="nomor_telepon" class="form-label">Nomor Telepon <span
                                            class="text-danger">*</span></label>
                                    <input type="tel" class="form-control" id="nomor_telepon" name="nomor_telepon"
                                        value="{{ old('nomor_telepon') }}" required>
                                </div>

                                <!-- NIB -->
                                <div class="col-md-12 mb-3">
                                    <label for="nib" class="form-label">NIB (Nomor Induk Berusaha) <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nib" name="nib"
                                        value="{{ old('nib') }}" required>
                                </div>

                                <!-- Alamat Lengkap -->
                                <div class="col-md-12 mb-3">
                                    <label for="alamat" class="form-label">Alamat Lengkap <span
                                            class="text-danger">*</span></label>
                                    <textarea class="form-control" id="alamat" name="alamat" rows="3" required
                                        placeholder="Masukkan alamat lengkap usaha Anda (contoh: Jl. Sudirman No. 123, Kelurahan ABC, Kecamatan XYZ, Kota Jakarta)">{{ old('alamat') }}</textarea>
                                </div>

                                <!-- Deskripsi -->
                                <div class="col-md-12 mb-3">
                                    <label for="deskripsi" class="form-label">Deskripsi Usaha <span
                                            class="text-danger">*</span></label>
                                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="5" required>{{ old('deskripsi') }}</textarea>
                                    <small class="text-muted">Ceritakan tentang usaha Anda, produk/jasa yang ditawarkan,
                                        dll.</small>
                                </div>

                                <!-- Upload Foto -->
                                <div class="col-md-12 mb-3">
                                    <label for="foto" class="form-label">Foto Usaha</label>
                                    <input type="file" class="form-control" id="foto" name="foto"
                                        accept="image/*" onchange="previewImages()">
                                    <small class="text-muted">Format: JPG, JPEG, PNG, GIF. Maksimal 2MB.</small>

                                    <!-- Preview Images -->
                                    <div id="image-preview" class="mt-3 row"></div>
                                </div>
                            </div>

                            <hr>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('umkm.index') }}" class="btn btn-secondary">Batal</a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Daftarkan UMKM
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewImages() {
            const input = document.getElementById('foto');
            const preview = document.getElementById('image-preview');
            preview.innerHTML = '';

            if (input.files && input.files[0]) {
                const file = input.files[0];
                const reader = new FileReader();
                reader.onload = function(e) {
                    const col = document.createElement('div');
                    col.className = 'col-md-3 mb-2';
                    col.innerHTML = `
                        <div class="card">
                            <img src="${e.target.result}" class="card-img-top" style="height: 150px; object-fit: cover;">
                            <div class="card-body p-2">
                                <small class="text-muted">${file.name}</small>
                            </div>
                        </div>
                    `;
                    preview.appendChild(col);
                };
                reader.readAsDataURL(file);
            }
        }

        // Preview Google Maps logic
        let originalMapUrl = ''; // Store the original URL

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('previewBtn').addEventListener('click', function() {
                const url = document.getElementById('input_url').value.trim();
                const previewContainer = document.getElementById('previewContainer');
                const iframe = document.getElementById('previewIframe');

                if (!url) {
                    alert('Silakan masukkan URL Google Maps terlebih dahulu');
                    return;
                }

                // Store the original URL for later use
                originalMapUrl = url;

                // Show preview container
                previewContainer.style.display = 'block';

                // Check if it's a short URL
                if (url.includes('maps.app.goo.gl') || url.includes('goo.gl/maps')) {
                    // Expand short URL via backend
                    fetch('/umkm/expand-url', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    ?.getAttribute('content') || ''
                            },
                            body: JSON.stringify({
                                url: url
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success && data.expandedUrl) {
                                generateEmbedUrl(data.expandedUrl, iframe);
                                // Update originalMapUrl with expanded URL if available
                                originalMapUrl = data.expandedUrl;
                            } else {
                                generateEmbedUrl(url, iframe);
                            }
                        })
                        .catch(error => {
                            console.error('Error expanding URL:', error);
                            generateEmbedUrl(url, iframe);
                        });
                } else {
                    generateEmbedUrl(url, iframe);
                }
            });
        });

        function openOriginalMap() {
            if (originalMapUrl) {
                window.open(originalMapUrl, '_blank');
            } else {
                alert('URL Google Maps tidak tersedia');
            }
        }

        function generateEmbedUrl(url, iframe) {
            let embedUrl = '';

            // Try to extract lat,lng from URL
            let match = url.match(/@(-?\d+(?:\.\d+)?),\s*(-?\d+(?:\.\d+)?)/);
            if (match) {
                const lat = match[1];
                const lng = match[2];
                embedUrl =
                    `https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3000!2d${lng}!3d${lat}!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zM40sNsKwMDAnMDAuMCJTIDEwN8KwMzEnMDAuMCJF!5e0!3m2!1sid!2sid!4v1234567890!5m2!1sid!2sid`;
            } else if (url) {
                embedUrl =
                    `https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3000!2d106.8456!3d-6.2088!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNsKwMTInMzEuNyJTIDEwNsKwNTAnNDQuMiJF!5e0!3m2!1sid!2sid!4v1234567890!5m2!1sid!2sid`;
            } else {
                embedUrl =
                    `https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3000!2d106.8456!3d-6.2088!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNsKwMTInMzEuNyJTIDEwNsKwNTAnNDQuMiJF!5e0!3m2!1sid!2sid!4v1234567890!5m2!1sid!2sid`;
            }

            iframe.src = embedUrl;
        }
    </script>

    <style>
        .gap-2 {
            gap: 0.5rem;
        }

        .form-label {
            font-weight: 600;
            color: #495057;
        }

        .text-danger {
            color: #dc3545 !important;
        }

        .position-relative {
            position: relative !important;
        }

        .position-absolute {
            position: absolute !important;
        }

        .top-0 {
            top: 0 !important;
        }

        .start-0 {
            left: 0 !important;
        }

        .w-100 {
            width: 100% !important;
        }

        .h-100 {
            height: 100% !important;
        }
    </style>
@endsection
