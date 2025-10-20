@extends('layout')

@section('content')
    {{-- Background Section with Search Form --}}
    <!-- Search Form Section -->
    <section id="search-section" style="position: relative;">
        <!-- Bootstrap Carousel for Background Images -->
        <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel"
            style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 0; overflow: hidden;">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="{{ asset('images/kantor.jpg') }}" class="d-block w-100"
                        style="height: 100%; object-fit: cover;">
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('images/Perjaya.jpg') }}" class="d-block w-100"
                        style="height: 100%; object-fit: cover;">
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('images/Bendungan-Perjaya.jpg') }}" class="d-block w-100"
                        style="height: 100%; object-fit: cover;">
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('images/sawah.jpg') }}" class="d-block w-100"
                        style="height: 100%; object-fit: cover;">
                </div>
            </div>
        </div>

        <!-- Overlay to darken the background for readability -->
        <div
            style="background: radial-gradient(110% 300% at 2% 0%, #00276aff 5%, rgba(0, 0, 0, 0.200) 62%);
            position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 1;">
        </div>

        <!-- Search Form and Icon Section (on top of the carousel) -->
        <div class="container-fluid d-flex flex-column justify-content-center align-items-center"
            style="height: 100%; position: relative; z-index: 2;">
            <!-- Welcome Text -->
            <h1 id="welcomePopup" class="text-white text-center fw-bold text-uppercase mb-3 popup-scale"
                style="transform: translateY(60px);">
                Selamat Datang<br>Pemerintah Kabupaten OKU TIMUR
            </h1>
            <p id="infoPopup" class="text-white fs-5 text-center mb-4 popup-left" style="transform: translateY(60px);">
                Temukan informasi publik terkini dari Kabupaten OKU TIMUR
            </p>
            <style>
                .popup-scale {
                    opacity: 0;
                    transform: scale(0.2) translateY(60px);
                    transition: opacity 0.7s cubic-bezier(.68, -0.55, .27, 1.55), transform 0.7s cubic-bezier(.68, -0.55, .27, 1.55);
                    z-index: 9999;
                }

                .popup-scale.show {
                    opacity: 1;
                    transform: scale(1) translateY(0);
                }

                .popup-left {
                    opacity: 0;
                    transform: translateX(-100vw);
                    transition: opacity 0.7s cubic-bezier(.68, -0.55, .27, 1.55), transform 0.7s cubic-bezier(.68, -0.55, .27, 1.55);
                    z-index: 9999;
                }

                .popup-left.show {
                    opacity: 1;
                    transform: translateX(0);
                }
            </style>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var welcome = document.getElementById('welcomePopup');
                    var info = document.getElementById('infoPopup');
                    setTimeout(function() {
                        welcome.classList.add('show');
                    }, 200);
                    setTimeout(function() {
                        info.classList.add('show');
                    }, 900);
                });
            </script>

            <!-- Search Form -->
            <form class="search-form d-flex justify-content-between align-items-center" method="GET"
                action="{{ route('post.search') }}">
                <div class="input-group">
                    <span class="input-group-text bg-white border-0">
                        <i class="bi bi-search"></i> <!-- Icon pencarian -->
                    </span>
                    <input type="text" name="query" class="form-control border-0"
                        placeholder="Cari informasi, berita, dan dokumen disini...." aria-label="Search">
                </div>
                <button class="btn btn-primary btn-search" type="submit">Cari</button>
            </form>

            <!-- Icon Section -->
            <div class="icon-section d-flex flex-wrap justify-content-center rounded-3 py-3 mt-3" id="iconAccordion">
                @foreach ($icons as $icon)
                    <div class="icon-container d-flex flex-column gap-2 justify-content-center align-items-center">
                        <div class="card bg-opacity-60 text-center">
                            <div class="card-body">
                                <!-- Icon image -->
                                <img src="{{ asset('storage/' . $icon->image) }}" alt="{{ $icon->title }}"
                                    class="img-fluid submenu-toggle" data-icon-id="{{ $icon->id }}">
                            </div>
                        </div>
                        <div class="portal-title">
                            <p class="text-center text-white">{{ $icon->title }}</p>
                        </div>
                        <!-- Portal Submenu Collapse -->
                        <div id="iconMenu{{ $icon->id }}" class="submenu-collapse">
                            <ul>
                                @foreach ($icon->dropdowns as $dropdown)
                                    <li style="display: flex; align-items: center; gap: 10px; padding: 8px 0;">
                                        @if ($dropdown->icon_dropdown)
                                            <img src="{{ asset('storage/' . $dropdown->icon_dropdown) }}" alt="icon"
                                                style="width: 28px; height: 28px; object-fit: cover; border-radius: 4px;">
                                        @endif
                                        <a href="{{ $dropdown->link }}" target="_blank"
                                            style="flex: 1;">{{ $dropdown->title }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endforeach

                <!-- Manual UMKM Icon Menu -->
                @if (!$umkmSettings['hide_menu'])
                    <div class="icon-container d-flex flex-column gap-2 justify-content-center align-items-center">
                        <div class="card bg-opacity-60 text-center">
                            <div class="card-body">
                                <!-- UMKM Icon image - using logo as fallback -->
                                <img src="{{ asset('icons/market.png') }}" alt="UMKM" class="img-fluid submenu-toggle"
                                    data-icon-id="umkm">
                            </div>
                        </div>
                        <div class="portal-title">
                            <p class="text-center text-white">UMKM</p>
                        </div>
                        <!-- UMKM Submenu Collapse -->
                        <div id="iconMenuumkm" class="submenu-collapse">
                            <ul>
                                @if (!$umkmSettings['hide_registration'])
                                    <li>
                                        <a href="{{ route('umkm.index') }}" target="_blank"
                                            style="display: flex; align-items: center; gap: 10px; padding: 12px 8px; border-bottom: 1px solid #e9ecef;">
                                            <div
                                                style="width: 40px; height: 40px; background: linear-gradient(45deg, #007bff, #0056b3); border-radius: 4px; flex-shrink: 0; display: flex; align-items: center; justify-content: center;">
                                                <i class="bi bi-plus-circle" style="color: white; font-size: 18px;"></i>
                                            </div>
                                            <div style="flex: 1;">
                                                <strong>Pendaftaran UMKM</strong>
                                                <div style="font-size: 11px; color: #6c757d;">Daftarkan bisnis Anda</div>
                                            </div>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                            @if ($approvedBusinesses->isEmpty())
                                <ul>
                                    <li style="padding: 20px; text-align: center;">
                                        <div style="color: #6c757d; font-style: italic;">
                                            <i class="bi bi-info-circle"
                                                style="font-size: 18px; margin-bottom: 8px; display: block;"></i>
                                            <div style="font-size: 14px;">Belum ada UMKM yang terdaftar</div>
                                            <div style="font-size: 12px; margin-top: 4px;">Silakan daftarkan bisnis Anda
                                                @if (!$umkmSettings['hide_registration'])
                                                    menggunakan tombol "Pendaftaran UMKM" di atas
                                                @else
                                                    dengan menghubungi admin
                                                @endif
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            @else
                                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">
                                    @foreach ($approvedBusinesses as $index => $business)
                                        <div style="width: 100%; min-width: 0;">
                                            <a href="{{ route('umkm.show', $business->id) }}" target="_blank"
                                                @if ($index === 0) class="newest-business" @endif
                                                style="display: flex; align-items: center; gap: 10px; padding: 12px 8px; border-bottom: 1px solid #f1f3f4; transition: all 0.2s ease; text-decoration: none; width: 100%;">
                                                @php
                                                    $businessPhoto = $business->foto; // foto sekarang hanya satu string
                                                @endphp

                                                @if ($businessPhoto)
                                                    <!-- Foto Business dengan bentuk persegi -->
                                                    @if (Str::startsWith($businessPhoto, ['http://', 'https://']))
                                                        <img src="{{ $businessPhoto }}" alt="{{ $business->nama }}"
                                                            style="width: 40px; height: 40px; object-fit: cover; border-radius: 4px; flex-shrink: 0; border: 2px solid #e9ecef;">
                                                    @else
                                                        <img src="{{ asset('storage/' . $businessPhoto) }}"
                                                            alt="{{ $business->nama }}"
                                                            style="width: 40px; height: 40px; object-fit: cover; border-radius: 4px; flex-shrink: 0; border: 2px solid #e9ecef;">
                                                    @endif
                                                @else
                                                    <!-- Placeholder jika tidak ada foto -->
                                                    <div
                                                        style="width: 40px; height: 40px; background: linear-gradient(135deg, #f8f9fa, #e9ecef); border-radius: 4px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; border: 2px solid #dee2e6;">
                                                        <i class="bi bi-building"
                                                            style="color: #6c757d; font-size: 16px;"></i>
                                                    </div>
                                                @endif

                                                <div style="flex: 1; min-width: 0;">
                                                    <div
                                                        style="font-weight: 500; color: #333; font-size: 14px; line-height: 1.2; margin-bottom: 2px; white-space: normal; overflow-wrap: break-word; word-break: break-word;">
                                                        {{ $business->nama }}
                                                        @if ($index === 0)
                                                            <span
                                                                style="font-size: 9px; background: linear-gradient(45deg, #28a745, #20c997); color: white; padding: 2px 5px; border-radius: 10px; margin-left: 3px; font-weight: bold; text-transform: uppercase;">NEW</span>
                                                        @endif
                                                    </div>
                                                    <div style="font-size: 11px; color: #6c757d; line-height: 1.1;">
                                                        @if ($business->jenis)
                                                            {{ $business->jenis }}
                                                        @else
                                                            Bisnis UMKM
                                                        @endif
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    {{-- Section Berita dan Pengumuman --}}
    <section id="pengumuman-section" style="background-image: url('images/cover.png')">
        {{-- Main Container for the Section --}}
        <div class="container pengumuman-container d-flex justify-content-center" style="padding-top: 40px;">
            {{-- Berita Terkini --}}
            <div class="col-md-8" style="margin-top: -50px; width: 832px;">
                {{-- Judul "Berita Terkini" --}}
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="text-dark" style="font-weight: 600; font-size: 22px; margin-top: 40px;">Berita Terkini
                    </h2>
                    {{-- Nav untuk carousel --}}
                    <div class="d-flex" style="margin-top: 30px;">
                        <button class="owl-prev btn btn-light" style="border: 1px solid #ccc; border-radius: 4px;">
                            <i class="bi bi-chevron-left"></i>
                        </button>
                        <button class="owl-next btn btn-light ms-2" style="border: 1px solid #ccc; border-radius: 4px;">
                            <i class="bi bi-chevron-right"></i>
                        </button>
                    </div>
                </div>

                {{-- Garis Bawah untuk Judul --}}
                <div class="mb-2 d-flex align-items-center" style="margin-top: -11px">
                    <div style="width: 50px; height: 6px; background-color: #2F4F7F;"></div>
                    <div style="flex-grow: 1; height: 2px; background-color: #2F4F7F;"></div>
                </div>

                {{-- Container Pengumuman with Owl Carousel --}}
                <div class="container py-4" style="margin-top: -20px; margin-left: -12px; width: 104%;">
                    <div id="latestArticle" class="owl-carousel owl-theme">
                        @foreach ($posts->where('draft', false)->take(4) as $post)
                            {{-- Menampilkan hanya 4 item --}}
                            <div class="item">
                                <div class="card border-0 shadow-sm mb-3">
                                    <div class="row g-0">
                                        <div class="col-md-4" style="width: 55%;">
                                            {{-- Gambar untuk Post --}}
                                            @php
                                                $images = json_decode($post->image); // Dekode JSON untuk mendapatkan array gambar
                                                $firstImage = $images ? $images[0] : null; // Ambil gambar pertama
                                            @endphp

                                            @if ($firstImage)
                                                {{-- Jika gambar berupa link eksternal --}}
                                                @if (Str::startsWith($firstImage, ['http://', 'https://']))
                                                    <img src="{{ $firstImage }}" class="img-fluid" alt="Gambar Post"
                                                        style="width: 90%; height: 250px; object-fit: cover; border-radius: 5px;">
                                                @else
                                                    {{-- Jika gambar dari folder storage/uploads --}}
                                                    <img src="{{ asset('storage/' . $firstImage) }}" class="img-fluid"
                                                        alt="Gambar Post"
                                                        style="width: 90%; height: 250px; object-fit: cover; border-radius: 5px;">
                                                @endif
                                            @else
                                                {{-- Placeholder jika tidak ada gambar --}}
                                                <img src="{{ asset('images/placeholder.png') }}" class="img-fluid"
                                                    alt="Placeholder Image"
                                                    style="width: 100%; height: 250px; object-fit: cover; border-radius: 5px;">
                                            @endif
                                        </div>
                                        <div class="col-md-8" style="width: 40%; margin-left: -40px; margin-top: -15px;">
                                            <div class="card-body" style="width: 420px">
                                                <h5 class="card-title title-clamp">{{ $post->title }}</h5>
                                                <div
                                                    class="d-flex justify-content-start align-items-center text-muted mb-2">
                                                    <span class="me-3"><i class="bi bi-calendar"></i>
                                                        @if ($post->published_at)
                                                            {{ $post->published_at->format('d M Y') }}
                                                        @else
                                                            Tanggal tidak tersedia
                                                        @endif
                                                    </span>
                                                    <small><i class="bi bi-person"></i>
                                                        {{ $post->user ? $post->user->name : 'User' }} &nbsp; <i
                                                            class="bi bi-eye"></i> {{ $post->views }}</small>
                                                </div>
                                                <p class="card-text description-clamp">
                                                    {{ Str::limit(html_entity_decode(strip_tags($post->description)), 200, '...') }}
                                                </p>
                                                <a href="/post/show/{{ $post->id }}"
                                                    class="btn btn-link text-primary p-0">Selengkapnya <i
                                                        class="bi bi-arrow-right"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Pengumuman --}}
            <div class="col-md-4" style="width: 400px;">
                <h5 class="mb-3" style="font-weight: 600; font-size: 22px; margin-top: -13px;">Pengumuman</h5>
                {{-- Garis Bawah untuk Judul --}}
                <div class="mb-2 d-flex align-items-center" style="margin-top: 2px">
                    <div style="width: 50px; height: 6px; background-color: #2F4F7F;"></div>
                    <div style="flex-grow: 1; height: 2px; background-color: #2F4F7F;"></div>
                </div>
                <div class="list-group">
                    {{-- Looping untuk menampilkan 2 dokumen terbaru dengan tanda [ title document ] blink hijau --}}
                    @foreach ($documents->sortByDesc('id')->take(2) as $document)
                        <a href="{{ route('document.show', $document->id) }}"
                            class="list-group-item list-group-item-action">
                            <div class="d-flex align-items-center">
                                <img src="{{ asset('/icons/dokumen.jpg') }}" alt="Document Icon" class="me-3"
                                    style="width: 100px; height: 100px; object-fit: cover; border-radius: 5px;">
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="blink-green" style="font-weight:bold; font-size:16px;">
                                            [ {{ $document->title }} ]
                                        </span>
                                    </div>
                                    <small><i class="bi bi-calendar"></i>
                                        {{ $document->created_at->format('d M Y') }}</small>
                                </div>
                            </div>
                        </a>
                    @endforeach
                    <style>
                        .blink-green {
                            color: #28a745;
                            animation: blink 1s linear infinite;
                        }

                        @keyframes blink {
                            0% {
                                opacity: 1;
                            }

                            50% {
                                opacity: 0.2;
                            }

                            100% {
                                opacity: 1;
                            }
                        }
                    </style>
                </div>
            </div>
        </div>
    </section>

    {{-- Headline --}}
    <section id="headline" class="py-4" style="background-image: url('images/cover.png');">
        <div class="headline-container">
            <h2 class="mb-4" style="font-family: 'Roboto', serif; font-size: 23px;">Berita Lainnya</h2>
            {{-- Garis Bawah untuk Judul --}}
            <div class="mb-2 d-flex align-items-center" style="margin-top: -15px">
                <div style="width: 50px; height: 6px; background-color: #2F4F7F;"></div>
                <div style="flex-grow: 1; height: 2px; background-color: #2F4F7F;"></div>
            </div>
            <div class="row" style="margin-top: 20px">
                @foreach ($posts->where('draft', false)->whereNotNull('headline_id')->sortByDesc('id')->take(6) as $post)
                    <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                        <a href="/post/show/{{ $post->id }}" class="text-decoration-none">
                            <div class="card border-0 shadow-sm">
                                @php
                                    // Dekode JSON untuk mendapatkan array gambar
                                    $images = json_decode($post->image);
                                    $firstImage = $images ? $images[0] : null;
                                @endphp

                                @if ($firstImage)
                                    {{-- Jika gambar berupa link eksternal --}}
                                    @if (Str::startsWith($firstImage, ['http://', 'https://']))
                                        <img src="{{ $firstImage }}" class="img-fluid" alt="Gambar Post"
                                            style="width: 100%; height: 250px; object-fit: cover; border-radius: 5px;">
                                    @else
                                        {{-- Jika gambar dari folder storage/uploads --}}
                                        <img src="{{ asset('storage/' . $firstImage) }}" class="img-fluid"
                                            alt="Gambar Post"
                                            style="width: 100%; height: 250px; object-fit: cover; border-radius: 5px;">
                                    @endif
                                @else
                                    {{-- Placeholder jika tidak ada gambar --}}
                                    <img src="{{ asset('images/placeholder.png') }}" class="img-fluid"
                                        alt="Placeholder Image"
                                        style="width: 100%; height: 250px; object-fit: cover; border-radius: 5px;">
                                @endif

                                <div class="card-body p-3"
                                    style="position: absolute; bottom: 0; left: 0; right: 0; background-color: rgba(0, 0, 0, 0.7); border-radius: 0 0 10px 10px;">
                                    <h5 class="card-title text-white" style="font-size: 16px;">{{ $post->title }}</h5>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-white-50" style="font-size: 12px;">
                                            <i class="bi bi-calendar"></i>
                                            @if ($post->published_at)
                                                Published on {{ $post->published_at->format('d M Y') }}
                                            @endif
                                        </span>
                                        <span class="text-white-50" style="font-size: 12px;">
                                            <i class="bi bi-person"></i> {{ $post->user ? $post->user->name : 'User' }}
                                            &nbsp;
                                        </span>
                                        <span class="text-white-50" style="font-size: 12px;">
                                            <i class="bi bi-eye"></i> {{ $post->views }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
            <div class="d-flex justify-content-end">
                <a href="{{ route('headline.show', ['id' => $post->headline_id]) }}" class="btn btn-outline-primary">
                    Selengkapnya <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </section>
    {{-- Headline --}}

    <link rel="stylesheet" href="{{ asset('css/index.css') }}">

    <!-- jQuery (required for Owl Carousel) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Owl Carousel JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="{{ asset('js/index.js') }}"></script>
@endsection
