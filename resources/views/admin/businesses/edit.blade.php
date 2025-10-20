@extends('admin.layouts.navigation')


@section('title', 'Edit UMKM - Kata Admin')

@section('content')
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-1 text-gray-800"><i class="fas fa-edit me-2"></i>Edit UMKM</h1>
                        <p class="text-muted mb-0">Perbarui data dan informasi UMKM <strong>{{ $business->nama }}</strong>
                        </p>
                    </div>
                    <div>
                        <a href="{{ route('admin.businesses.show', $business->id) }}" class="btn btn-outline-info me-2">
                            <i class="fas fa-eye me-1"></i>Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Foto & Status -->
            <div class="col-lg-4 mb-4">
                <div class="card shadow-sm mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Foto UMKM</h6>
                    </div>
                    <div class="card-body">
                        @if ($business->foto)
                            <div class="row" id="existing-photos">
                                <div class="col-md-6 mb-2">
                                    <div class="photo-container position-relative">
                                        <img src="{{ asset('storage/' . $business->foto) }}" class="img-thumbnail rounded"
                                            style="max-height: 120px; width: 100%; object-fit: cover;">
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <div class="bg-secondary text-white rounded d-flex align-items-center justify-content-center mx-auto"
                                    style="width: 100px; height: 100px; font-size: 2rem;">
                                    {{ strtoupper(substr($business->nama, 0, 2)) }}
                                </div>
                                <p class="text-muted mt-3">Belum ada foto</p>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="card shadow-sm">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Status</h6>
                    </div>
                    <div class="card-body text-center">
                        @if ($business->status == 1)
                            <div class="mb-3">
                                <i class="fas fa-check-circle fa-3x text-success"></i>
                            </div>
                            <h5 class="text-success">Approved</h5>
                            <p class="text-muted">UMKM sudah disetujui dan tampil di publik.</p>
                        @else
                            <div class="mb-3">
                                <i class="fas fa-clock fa-3x text-warning"></i>
                            </div>
                            <h5 class="text-warning">Pending</h5>
                            <p class="text-muted">UMKM menunggu persetujuan admin.</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Form Edit -->
            <div class="col-lg-8 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Form Edit UMKM</h6>
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
                        <form action="{{ route('admin.businesses.update', $business->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nama" class="form-label">Nama UMKM *</label>
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                        id="nama" name="nama" value="{{ old('nama', $business->nama) }}" required>
                                    @error('nama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="jenis" class="form-label">Jenis Usaha *</label>
                                    <select class="form-select @error('jenis') is-invalid @enderror" id="jenis"
                                        name="jenis" required>
                                        <option value="">Pilih Jenis Usaha</option>
                                        <option value="Makanan dan Minuman"
                                            {{ old('jenis', $business->jenis) == 'Makanan dan Minuman' ? 'selected' : '' }}>
                                            Makanan dan Minuman</option>
                                        <option value="Pakaian dan Aksesoris"
                                            {{ old('jenis', $business->jenis) == 'Pakaian dan Aksesoris' ? 'selected' : '' }}>
                                            Pakaian dan Aksesoris</option>
                                        <option value="Jasa"
                                            {{ old('jenis', $business->jenis) == 'Jasa' ? 'selected' : '' }}>Jasa</option>
                                        <option value="Kerajinan Tangan"
                                            {{ old('jenis', $business->jenis) == 'Kerajinan Tangan' ? 'selected' : '' }}>
                                            Kerajinan Tangan</option>
                                        <option value="Elektronik"
                                            {{ old('jenis', $business->jenis) == 'Elektronik' ? 'selected' : '' }}>
                                            Elektronik</option>
                                        <option value="Kesehatan"
                                            {{ old('jenis', $business->jenis) == 'Kesehatan' ? 'selected' : '' }}>Kesehatan
                                        </option>
                                        <option value="Transportasi"
                                            {{ old('jenis', $business->jenis) == 'Transportasi' ? 'selected' : '' }}>
                                            Transportasi</option>
                                        <option value="Pendidikan"
                                            {{ old('jenis', $business->jenis) == 'Pendidikan' ? 'selected' : '' }}>
                                            Pendidikan</option>
                                        <option value="Teknologi"
                                            {{ old('jenis', $business->jenis) == 'Teknologi' ? 'selected' : '' }}>Teknologi
                                        </option>
                                    </select>
                                    @error('jenis')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="owner" class="form-label">Nama Pemilik Usaha *</label>
                                    <input type="text" class="form-control @error('owner') is-invalid @enderror"
                                        id="owner" name="owner" value="{{ old('owner', $business->owner) }}"
                                        required>
                                    @error('owner')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="alamat" class="form-label">Alamat *</label>
                                    <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="2"
                                        required>{{ old('alamat', $business->alamat) }}</textarea>
                                    @error('alamat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nomor_telepon" class="form-label">Nomor Telepon *</label>
                                    <input type="tel" class="form-control @error('nomor_telepon') is-invalid @enderror"
                                        id="nomor_telepon" name="nomor_telepon"
                                        value="{{ old('nomor_telepon', $business->nomor_telepon) }}" required>
                                    @error('nomor_telepon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email *</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" value="{{ old('email', $business->email) }}"
                                        required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nib" class="form-label">NIB (Nomor Induk Berusaha)</label>
                                    <input type="text" class="form-control @error('nib') is-invalid @enderror"
                                        id="nib" name="nib" value="{{ old('nib', $business->nib) }}">
                                    @error('nib')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Opsional - jika sudah memiliki NIB</small>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="deskripsi" class="form-label">Deskripsi *</label>
                                    <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi"
                                        rows="2" required>{{ old('deskripsi', $business->deskripsi) }}</textarea>
                                    @error('deskripsi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="foto" class="form-label">Upload Foto Baru</label>
                                <input type="file" class="form-control @error('foto') is-invalid @enderror"
                                    id="foto" name="foto" accept="image/*">
                                @error('foto')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Opsional - Pilih satu foto untuk diupload</small>
                            </div>

                            <!-- Input Google Maps URL & Preview -->
                            <div class="mb-3">
                                <label for="input_url" class="form-label">Link Google Maps (Opsional)</label>
                                <input type="url" class="form-control @error('input_url') is-invalid @enderror"
                                    id="input_url" name="input_url" value="{{ old('input_url', $business->input_url) }}"
                                    placeholder="Contoh: https://maps.app.goo.gl/jJwhxr7QvHh5P3SVA atau https://www.google.com/maps/place/...">
                                @error('input_url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">
                                    <strong>Cara mendapat link:</strong><br>
                                    1. Buka Google Maps → 2. Cari lokasi usaha → 3. Klik 'Bagikan' → 4. Copy link dan paste
                                    di sini<br>
                                    <strong>Mendukung:</strong> Link pendek (maps.app.goo.gl) dan link panjang Google Maps
                                </small>
                                <!-- Preview Iframe -->
                                @php
                                    $lat = old('latitude', $business->latitude);
                                    $lng = old('longitude', $business->longitude);
                                    $inputUrl = old('input_url', $business->input_url);
                                    $embedUrl = '';
                                    if ($lat && $lng) {
                                        $embedUrl = "https://www.google.com/maps?q={$lat},{$lng}&z=16&hl=id&output=embed";
                                    } elseif ($inputUrl) {
                                        if (preg_match('/@(-?\d+(?:\.\d+)?),\s*(-?\d+(?:\.\d+)?)/', $inputUrl, $m)) {
                                            $lat = $m[1];
                                            $lng = $m[2];
                                            $embedUrl = "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3000!2d{$lng}!3d{$lat}!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zM40sNsKwMDAnMDAuMCJTIDEwN8KwMzEnMDAuMCJF!5e0!3m2!1sid!2sid!4v1234567890!5m2!1sid!2sid";
                                        } else {
                                            $embedUrl =
                                                'https://www.google.com/maps?q=' .
                                                urlencode($inputUrl) .
                                                '&z=16&hl=id&output=embed';
                                        }
                                    }
                                @endphp
                                <div id="previewContainer" class="mt-3"
                                    style="{{ $embedUrl ? '' : 'display:none;' }}">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <label class="form-label mb-0">Preview Google Maps:</label>
                                        <small class="text-muted">Klik peta untuk membuka di Google Maps</small>
                                    </div>
                                    <div class="ratio ratio-16x9 position-relative"
                                        style="border:1px solid #e5e7eb;border-radius:12px;overflow:hidden;">
                                        <iframe id="previewIframe" src="{{ $embedUrl }}"
                                            style="border:0; width:100%; height:100%;" loading="lazy"
                                            referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
                                        <!-- Clickable overlay -->
                                        <div id="mapClickOverlay" class="position-absolute top-0 start-0 w-100 h-100"
                                            style="background: transparent; cursor: pointer; z-index: 10;"
                                            onclick="openOriginalMapEdit()" title="Klik untuk membuka di Google Maps">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.businesses.index') }}" class="btn btn-secondary"><i
                                        class="fas fa-arrow-left me-1"></i>Kembali</a>
                                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Update
                                    UMKM</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .photo-container {
            position: relative !important;
            overflow: hidden !important;
            border-radius: 8px !important;
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Preview Google Maps logic
        let originalMapUrl = @json(old('input_url', $business->input_url));

        function showPreview(url) {
            const previewContainer = document.getElementById('previewContainer');
            const iframe = document.getElementById('previewIframe');
            if (!url) {
                previewContainer.style.display = 'none';
                iframe.src = '';
                return;
            }
            previewContainer.style.display = 'block';
            // Check if it's a short URL
            if (url.includes('maps.app.goo.gl') || url.includes('goo.gl/maps')) {
                fetch('/umkm/expand-url', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute(
                                'content') || ''
                        },
                        body: JSON.stringify({
                            url: url
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success && data.expandedUrl) {
                            generateEmbedUrl(data.expandedUrl, iframe);
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
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Tampilkan preview otomatis jika ada input_url
            const url = document.getElementById('input_url').value.trim();
            if (url) {
                showPreview(url);
            }
        });

        function openOriginalMapEdit() {
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
@endpush
