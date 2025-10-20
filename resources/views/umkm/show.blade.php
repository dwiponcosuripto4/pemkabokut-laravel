@extends('layout')

@section('content')
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

    <style>
        body {
            font-family: 'Segoe UI', 'Roboto', Arial, sans-serif;
            background: #f6f8fa;
        }

        .umkm-header {
            background: linear-gradient(90deg, #4e54c8 0%, #8f94fb 100%);
            color: #fff;
            border-radius: 16px 16px 0 0;
            padding: 32px 24px 24px 24px;
            position: relative;
            box-shadow: 0 4px 16px rgba(78, 84, 200, 0.08);
        }

        .umkm-header .icon {
            font-size: 2.5rem;
            margin-right: 12px;
        }

        .umkm-card {
            border-radius: 16px;
            box-shadow: 0 2px 16px rgba(0, 0, 0, 0.07);
            border: none;
            overflow: hidden;
        }

        .umkm-badge {
            font-size: 1rem;
            padding: 6px 18px;
            border-radius: 12px;
        }

        .umkm-section-title {
            font-weight: 600;
            color: #4e54c8;
            margin-bottom: 8px;
        }

        .foto-umkm-card {
            /* dihapus, tidak digunakan lagi */
        }

        .foto-umkm-card:hover {
            transform: scale(1.04);
            box-shadow: 0 6px 16px rgba(78, 84, 200, 0.13);
        }

        .foto-umkm-img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            display: block;
            margin: 0 auto;
            cursor: pointer;
            object-fit: unset;
        }

        .map-container {
            position: relative;
        }

        .map-container #map {
            transition: box-shadow 0.3s ease;
            z-index: 1;
            border-radius: 10px;
        }

        .map-container #map:hover {
            box-shadow: 0 4px 12px rgba(78, 84, 200, 0.15);
        }

        .leaflet-container {
            font-family: inherit;
        }

        .btn-custom {
            background: linear-gradient(90deg, #4e54c8 0%, #8f94fb 100%);
            color: #fff;
            border: none;
            border-radius: 8px;
            transition: background 0.2s;
        }

        .btn-custom:hover {
            background: linear-gradient(90deg, #8f94fb 0%, #4e54c8 100%);
            color: #fff;
        }
    </style>

    <div class="container mt-5" style="padding-top: 70px; max-width: 900px;">
        <div class="umkm-card card">
            <div class="umkm-header d-flex align-items-center">
                <span class="icon"><i class="fas fa-store"></i></span>
                <div>
                    <h2 class="mb-1" style="font-weight:700;">{{ $business->nama }}</h2>
                    <div class="d-flex align-items-center gap-2">
                        <span class="umkm-badge badge {{ $business->status == 1 ? 'bg-success' : 'bg-warning' }}">
                            {{ $business->status == 1 ? 'Approved' : 'Pending' }}
                        </span>
                        <span class="text-light small px-2 py-1" style="background:rgba(0,0,0,0.15);border-radius:6px;">
                            {{ $business->jenis }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="umkm-section-title">Foto UMKM</div>
                        <div class="row g-3">
                            @if ($business->foto)
                                <div class="col-md-4 col-sm-6">
                                    <img src="{{ asset('storage/' . $business->foto) }}" class="foto-umkm-img"
                                        alt="Foto UMKM"
                                        onclick="showImageModal('{{ asset('storage/' . $business->foto) }}', 'Foto UMKM')">
                                </div>
                            @else
                                <div class="col-12">
                                    <div class="text-muted">Belum ada foto yang diupload</div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="umkm-section-title">Deskripsi</div>
                        @if ($business->deskripsi)
                            <div style="text-align: justify; white-space: pre-line;">{{ $business->deskripsi }}</div>
                        @else
                            <div class="text-muted">Belum ada deskripsi</div>
                        @endif
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6 mb-2">
                        <div class="umkm-section-title">Informasi Utama</div>
                        <dl class="row mb-0">
                            <dt class="col-sm-5">Owner:</dt>
                            <dd class="col-sm-7">{{ $business->owner }}</dd>
                            <dt class="col-sm-5">Email:</dt>
                            <dd class="col-sm-7">{{ $business->email }}</dd>
                            <dt class="col-sm-5">Telepon:</dt>
                            <dd class="col-sm-7">{{ $business->nomor_telepon }}</dd>
                        </dl>
                    </div>
                    <div class="col-md-6 mb-2">
                        <div class="umkm-section-title">Legalitas & Tanggal</div>
                        <dl class="row mb-0">
                            <dt class="col-sm-5">NIB:</dt>
                            <dd class="col-sm-7">{{ $business->nib ?: 'Belum ada' }}</dd>
                            <dt class="col-sm-5">Tanggal Daftar:</dt>
                            <dd class="col-sm-7">{{ $business->created_at->format('d M Y') }}</dd>
                        </dl>
                    </div>
                </div>

                <hr>

                <div class="row mb-3">
                    <div class="col-12">
                        <div class="umkm-section-title">Alamat</div>
                        <div class="mb-2"><i class="fas fa-map-marker-alt text-danger"></i> {{ $business->alamat }}</div>
                    </div>
                </div>

                <hr>

                <div class="row mb-3">
                    <div class="col-12">
                        <div class="umkm-section-title">Preview Lokasi (Google Maps)</div>
                        @if ($embed)
                            <div class="ratio ratio-16x9 mb-2 position-relative"
                                style="border-radius:10px;overflow:hidden;">
                                <iframe id="showMapIframe" src="{{ $embed }}" width="100%" height="320"
                                    style="border:0;" allowfullscreen loading="lazy"
                                    referrerpolicy="no-referrer-when-downgrade"></iframe>
                                <div id="showMapClickOverlay" class="position-absolute top-0 start-0 w-100 h-100"
                                    style="background: transparent; cursor: pointer; z-index: 10;"
                                    onclick="openOriginalMap()" title="Klik untuk membuka di Google Maps"></div>
                            </div>
                        @else
                            <div class="text-muted">Lokasi tidak tersedia</div>
                        @endif
                        <small class="text-muted"><i class="fas fa-map-marker-alt"></i> {{ $business->alamat }}</small>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('umkm.index') }}" class="btn btn-custom"><i class="fas fa-arrow-left"></i>
                        Kembali</a>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>

    <!-- Modal untuk menampilkan foto dalam ukuran besar -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Foto UMKM</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" class="img-fluid rounded shadow" alt="Foto UMKM">
                </div>
            </div>
        </div>
    </div>

    <!-- Font Awesome & Leaflet JavaScript -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <script>
        function showImageModal(imageSrc, imageTitle) {
            document.getElementById('modalImage').src = imageSrc;
            document.getElementById('imageModalLabel').textContent = imageTitle;
            var imageModal = new bootstrap.Modal(document.getElementById('imageModal'));
            imageModal.show();
        }

        // Fungsi untuk membuka lokasi asli di Google Maps
        function openOriginalMap() {
            // Prioritas: input_url → koordinat → alamat → nama
            var url = @json($business->input_url ?? null);
            if (url) {
                window.open(url, '_blank');
            } else if (@json($business->latitude) && @json($business->longitude)) {
                var lat = @json($business->latitude);
                var lng = @json($business->longitude);
                window.open(`https://www.google.com/maps?q=${lat},${lng}`, '_blank');
            } else if (@json($business->alamat)) {
                var alamat = @json($business->alamat);
                window.open(`https://www.google.com/maps?q=${encodeURIComponent(alamat)}`, '_blank');
            } else {
                var nama = @json($business->nama);
                window.open(`https://www.google.com/maps?q=${encodeURIComponent(nama)}`, '_blank');
            }
        }
    </script>
@endsection
