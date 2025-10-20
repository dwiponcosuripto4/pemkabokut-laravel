<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Portal Resmi Pemerintah Kabupaten Ogan Komering Ulu Timur')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Owl Carousel CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    @stack('styles')
</head>

<body>
    {{-- Navbar --}}
    <nav class="navbar {{ request()->is('/') ? 'navbar-index' : 'navbar-default' }} navbar-expand-lg shadow py-4">
        <div class="container-fluid d-flex justify-content-between">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ URL::asset('/icons/logo_horisontal.png') }}" height="60" alt="" />
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu"
                aria-controls="mobileMenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse d-none d-lg-flex" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active text-white" aria-current="page" href="{{ url('/') }}">Beranda</a>
                    </li>
                    @foreach ($categories as $category)
                        <li class="nav-item dropdown category-item">
                            <a class="nav-link dropdown-toggle text-white" href="#" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                {{ $category->title }}
                                <i class="bi bi-chevron-down transform transition-transform duration-300"></i>
                            </a>
                            <ul class="dropdown-menu">
                                @if ($category->id == 6 || $category->id == 7)
                                    @foreach ($category->data as $dataItem)
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ url('/data/show/' . $dataItem->id) }}">{{ $dataItem->title }}</a>
                                        </li>
                                    @endforeach
                                @elseif ($category->id == 8)
                                    @if ($category->headlines)
                                        @foreach ($category->headlines as $headline)
                                            <li>
                                                <a class="dropdown-item"
                                                    href="{{ url('/headlines/show/' . $headline->id) }}">{{ $headline->title }}</a>
                                            </li>
                                        @endforeach
                                    @endif
                                    @foreach ($category->posts as $post)
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ url('/post/show/' . $post->id) }}">{{ $post->title }}</a>
                                        </li>
                                    @endforeach
                                @else
                                    @foreach ($category->posts as $post)
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ url('/post/show/' . $post->id) }}">{{ $post->title }}</a>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </li>
                    @endforeach
                </ul>
                <!-- Admin Button -->
                <div class="dropdown ms-auto">
                    <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButton"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                            class="bi bi-plus-lg" viewBox="0 0 16 16">
                            <path
                                d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                        </svg>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        @auth
                            <!-- Menu untuk admin jika sudah login -->
                            <li><a class="dropdown-item" href="{{ url('/post/show/36') }}">Kebijakan Privasi</a></li>
                            <li><a class="dropdown-item" href="{{ url('admin/dashboard') }}">Admin</a></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </li>
                        @else
                            <!-- Menu untuk halaman login dan welcome jika belum login -->
                            <li><a class="dropdown-item" href="{{ url('/post/show/36') }}">Kebijakan Privasi</a></li>
                            <li><a class="dropdown-item" href="{{ url('/login') }}">Admin</a></li>
                        @endauth
                    </ul>
                </div>
                <!-- Admin Button -->
            </div>
        </div>
    </nav>
    {{-- Offcanvas Mobile Menu --}}
    <div class="offcanvas offcanvas-end offcanvas-mobile" tabindex="-1" id="mobileMenu"
        aria-labelledby="mobileMenuLabel">
        <div class="offcanvas-header">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ URL::asset('/icons/logo_horisontal.png') }}" height="50" alt="" />
            </a>
            <button type="button" class="btn-close btn-close-white text-reset" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <nav class="mobile-nav">
                <ul class="list-unstyled mb-3">
                    <li class="mb-2"><a href="{{ url('/') }}" class="mobile-nav-link">Beranda</a></li>
                    @foreach ($categories as $category)
                        <li class="mb-2">
                            @php $hasChildren = ($category->id == 6 || $category->id == 7) || ($category->id == 8 && ($category->headlines && $category->headlines->count())) || ($category->posts && $category->posts->count()); @endphp
                            @if ($hasChildren)
                                <button class="btn btn-toggle mobile-toggle w-100 text-start text-white"
                                    type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse-cat-{{ $category->id }}" aria-expanded="false">
                                    {{ $category->title }}
                                    <i class="bi bi-chevron-down ms-2 toggle-icon"></i>
                                </button>
                                <div class="collapse" id="collapse-cat-{{ $category->id }}">
                                    <ul class="list-unstyled ps-3 mt-2">
                                        @if ($category->id == 6 || $category->id == 7)
                                            @foreach ($category->data as $dataItem)
                                                <li class="mb-1"><a class="mobile-sub-link"
                                                        href="{{ url('/data/show/' . $dataItem->id) }}">{{ $dataItem->title }}</a>
                                                </li>
                                            @endforeach
                                        @elseif ($category->id == 8)
                                            @if ($category->headlines)
                                                @foreach ($category->headlines as $headline)
                                                    <li class="mb-1"><a class="mobile-sub-link"
                                                            href="{{ url('/headlines/show/' . $headline->id) }}">{{ $headline->title }}</a>
                                                    </li>
                                                @endforeach
                                            @endif
                                            @foreach ($category->posts as $post)
                                                <li class="mb-1"><a class="mobile-sub-link"
                                                        href="{{ url('/post/show/' . $post->id) }}">{{ $post->title }}</a>
                                                </li>
                                            @endforeach
                                        @else
                                            @foreach ($category->posts as $post)
                                                <li class="mb-1"><a class="mobile-sub-link"
                                                        href="{{ url('/post/show/' . $post->id) }}">{{ $post->title }}</a>
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                            @else
                                <a class="mobile-nav-link" href="#">{{ $category->title }}</a>
                            @endif
                        </li>
                    @endforeach
                </ul>

                <div class="mobile-admin">
                    <div class="mb-2">
                        <a class="btn btn-light w-100" href="{{ url('/post/show/36') }}">Kebijakan Privasi</a>
                    </div>
                    @auth
                        <div class="mb-2"><a class="btn btn-secondary w-100" href="{{ url('admin/dashboard') }}">Admin
                                Dashboard</a></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-outline-light w-100">Logout</button>
                        </form>
                    @else
                        <div class="mb-2"><a class="btn btn-secondary w-100" href="{{ url('/login') }}">Admin
                                Login</a></div>
                    @endauth
                </div>
            </nav>
        </div>
    </div>
    {{-- Navbar --}}

    <div class="container-fluid py-0">
        @yield('content')
        {{-- Social Icons, hidden on smaller screens --}}
        <div class="social-icons d-none d-lg-flex">
            <a href="https://www.facebook.com/diskominfo.okutimur.33?mibextid=ZbWKwL" target="_blank">
                <img src="{{ URL::asset('/images/facebook.png') }}" alt="Facebook">
            </a>
            <a href="https://www.tiktok.com/@diskominfokabokutimur?_t=8pSKpeZFB1m&_r=1" target="_blank">
                <img src="{{ URL::asset('/images/tiktok.png') }}" alt="Tiktok">
            </a>
            <a href="https://www.instagram.com/diskominfo.okutimur?igsh=dWdrenR0Y2Z4dHgy" target="_blank">
                <img src="{{ URL::asset('/images/instagram.png') }}" alt="Instagram">
            </a>
            <a href="https://youtube.com/@diskominfookutimur9504?si=Ke9dyfDnzkx-pAVN" target="_blank">
                <img src="{{ URL::asset('/images/youtube.png') }}" alt="YouTube">
            </a>
        </div>
    </div>

    <footer class="text-center text-white bg-dark mt-0 py-3">
        <div class="container">
            <p class="mb-1">Hak Cipta © 2012 <a href="http://pemkabokut-laravel.test//">Pemerintah Kabupaten Ogan
                    Komering Ulu Timur</a></p>
            <p class="mb-1">Jl. Lintas Sumatera KM 7, Kota Baru Selatan, Martapura, Prov. Sumatera Selatan, 32181</p>
            <p class="mb-1">Tel: 0735-481035, Fax: 0735-482750</p>
            <p>Email: <a href="mailto:info@okutimurkab.go.id" class="text-white">info@okutimurkab.go.id</a></p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('js/layout.js') }}"></script>
    <!-- Owl Carousel JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    @stack('scripts')

</body>

</html>
