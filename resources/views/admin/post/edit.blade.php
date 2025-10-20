<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Edit Post - Sistem Admin Portal Informasi OKU Timur</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Summernote CSS -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">

    <!-- Summernote JS -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <style>
        /* Sidebar Styles adapted for Bootstrap 3.4.1 */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 250px;
            background: #2c3e50;
            transition: all 0.3s ease;
            z-index: 1000;
            overflow-y: auto;
        }

        .sidebar.collapsed {
            width: 70px;
        }

        .sidebar-header {
            padding: 1.2rem 1rem;
            border-bottom: 1px solid #34495e;
            display: flex;
            align-items: center;
            min-height: 70px;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            color: #fff;
            text-decoration: none;
            font-size: 1rem;
            gap: 12px;
            margin-left: 6px;
        }

        .brand-logo {
            width: 35px;
            height: 35px;
            object-fit: contain;
            flex-shrink: 0;
            margin-right: -5px;
        }

        .brand-text {
            display: flex;
            flex-direction: column;
            line-height: 1.2;
            transition: opacity 0.3s ease;
        }

        .brand-text-top {
            font-size: 1.6rem;
            font-weight: 500;
            color: #fff;
        }

        .brand-text-bottom {
            font-size: 1.3rem;
            font-weight: 400;
            color: #bdc3c7;
            margin-top: 2px;
        }

        .sidebar.collapsed .brand-text {
            opacity: 0;
            width: 0;
            overflow: hidden;
        }

        .sidebar.collapsed .brand-logo {
            margin: 0 auto;
        }

        .sidebar-toggle-btn {
            position: fixed;
            top: 15px;
            left: 265px;
            width: 40px;
            height: 40px;
            background: transparent;
            border: none;
            cursor: pointer;
            padding: 0;
            transition: all 0.3s ease;
            z-index: 1001;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sidebar-toggle-btn i {
            font-size: 2.55rem;
            color: #565656;
            transition: color 0.3s ease;
            margin: 0;
        }

        .sidebar-toggle-btn:hover {
            background-color: rgba(52, 152, 219, 0.1);
        }

        .sidebar-toggle-btn:hover i {
            color: #3498db;
        }

        .sidebar-content {
            padding: 0.5rem 0 0 0;
        }

        .nav-section {
            margin-top: 1.1rem;
            border-top: 1px solid rgba(52, 73, 94, 0.6);
            padding-top: 0.7rem;
            transition: border-top-color 0.3s ease;
        }

        .nav-section:first-child {
            border-top: none;
            padding-top: 0;
            margin-top: 0;
        }

        .sidebar-nav.first-nav {
            margin-bottom: 1rem;
        }

        /* Mengatur jarak antar item di first-nav */
        .sidebar-nav.first-nav .nav-item {
            margin-bottom: 0.5rem;
            /* Jarak antar item */
        }

        .sidebar-nav.first-nav .nav-item:last-child {
            margin-bottom: 0;
            /* Hilangkan margin di item terakhir */
        }

        .nav-section-title {
            padding: 1.3rem 1rem 1.5rem 1.6rem;
            font-size: 1.2rem;
            font-weight: 549;
            color: #7f8c8d;
            text-transform: uppercase;
            letter-spacing: 0.1px;
            transition: opacity 0.3s ease;
        }

        .sidebar.collapsed .nav-section-title {
            opacity: 0;
            height: 0;
            padding: 0;
            overflow: hidden;
        }

        .sidebar-nav {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .nav-item {
            position: relative;
            margin-bottom: 0.5rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 1rem 1rem;
            color: #bdc3c7;
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
            font-size: 1.6rem;
        }

        .nav-link:hover {
            background-color: #34495e;
            color: #fff;
            text-decoration: none;
            border-left: 3px solid transparent;
            border-left-color: #2980b9;
        }

        .nav-link.active {
            color: #fff;
            border-left-color: #2980b9;
            font-weight: 500;
        }

        .nav-link i {
            width: 32px;
            height: 20px;
            margin-right: 0.5rem;
            text-align: center;
            transition: margin 0.3s ease;
            font-size: 1.6rem;
        }

        .sidebar.collapsed .nav-link i {
            margin-right: 0;
        }

        .sidebar.collapsed .nav-link span {
            opacity: 0;
            width: 0;
            overflow: hidden;
        }

        /* Main Content */
        .main-content {
            margin-left: 250px;
            transition: all 0.3s ease;
        }

        .main-content.expanded {
            margin-left: 70px;
        }

        /* Top Navbar adapted for Bootstrap 3.4.1 */
        .top-navbar {
            background-color: #fff;
            height: 72px;
            border-bottom: -9px solid #e7e7e7;
            padding: 0.75rem 1rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .navbar-right-items {
            float: right;
            display: flex;
            align-items: center;
        }

        .notification-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background-color: #f8f9fa;
            margin-right: 15px;
            position: relative;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .notification-icon:hover {
            background-color: #e9ecef;
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-decoration: none;
        }

        .notification-icon .fas.fa-bell {
            font-size: 18px;
            line-height: 1;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6c757d
        }

        .user-profile-link {
            display: flex;
            align-items: center;
            padding: 8px 13px;
            border-radius: 25px;
            background-color: #f8f9fa;
            text-decoration: none;
            color: #000000;
            transition: all 0.3s ease;
            min-width: 185px;
            font-weight: 500;
            margin-right: 7px;
            margin-left: 7px;
        }

        .user-profile-link:hover {
            background-color: #e9ecef;
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-decoration: none;
            color: #333;
        }

        .badge-notification {
            position: absolute;
            top: -8px;
            right: -2px;
            background-color: #dc3545;
            color: white;
            border-radius: 50%;
            min-width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            line-height: 1;
            text-align: center;
            font-size: 1rem;
            font-weight: 600;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }

            100% {
                transform: scale(1);
            }
        }

        /* Dropdown styling untuk konsistensi */
        .dropdown-menu {
            border: none;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            border-radius: 8px;
            padding: 0.5rem 0;
        }

        .dropdown-menu li a {
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }

        .dropdown-menu li a:hover {
            background-color: #f8f9fa;
            transform: translateX(5px);
        }

        /* Class untuk responsive text */
        .d-none {
            display: none;
        }

        .d-md-inline {
            display: inline;
        }

        @media (max-width: 767px) {
            .d-md-inline {
                display: none !important;
            }
        }

        /* Page Content */
        .page-content {
            margin-top: -20px;
            padding: 20px;
        }

        /* Form Container with Background Image */
        .form-container {
            background-image: url('{{ asset('images/OKU Timur.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            position: relative;
        }

        /* Overlay */
        .form-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(110% 300% at 2% 0%, rgba(0, 39, 106, 0.999) 5%, rgba(0, 0, 0, 0.387) 62%);
        }

        .container {
            background-color: rgb(255, 255, 255);
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
            position: relative;
            z-index: 10;
        }

        .form-control,
        .select2-container--default .select2-selection--single {
            height: 44px;
            padding: 10px;
            font-size: 16px;
            border-radius: 4px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 4px;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .select2-container--default .select2-selection--single {
            border: 1px solid #ced4da;
            border-radius: 4px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 100%;
            top: 50%;
            transform: translateY(-50%);
        }

        .note-editor {
            border-radius: 4px;
        }

        #image-preview img {
            max-width: 100%;
            border-radius: 8px;
            margin-top: 15px;
        }

        .col-centered {
            margin-left: 94px;
            margin-right: auto;
        }

        .note-dialog {
            z-index: 1060 !important;
        }

        .note-modal {
            z-index: 1060 !important;
        }

        /* Tambahkan styling untuk pratinjau file */
        .file-item {
            position: relative;
            display: inline-block;
            margin-right: 10px;
            margin-top: 10px;
        }

        .remove-file-btn {
            position: absolute;
            top: -10px;
            right: -10px;
            background-color: red;
            color: white;
            border: none;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 12px;
            cursor: pointer;
        }

        /* Tambahkan Flexbox untuk layout tombol dan input */
        .d-flex {
            display: flex;
            align-items: center;
        }

        .me-2 {
            margin-right: 10px;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.collapsed {
                transform: translateX(-100%);
            }

            .main-content {
                margin-left: 0;
            }

            .main-content.expanded {
                margin-left: 0;
            }

            .sidebar-toggle-btn {
                left: 15px;
            }
        }
    </style>
</head>

<body>
    <!-- Sidebar Toggle Button -->
    <button class="sidebar-toggle-btn" id="sidebarToggle">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-brand">
                <img src="{{ asset('icons/logo_okutimur.png') }}" alt="Logo OKU Timur" class="brand-logo">
                <div class="brand-text">
                    <div class="brand-text-top">Sistem Admin</div>
                    <div class="brand-text-bottom">Portal Informasi OKU Timur</div>
                </div>
            </div>
        </div>

        <div class="sidebar-content">
            <ul class="sidebar-nav first-nav">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.users.index') }}" class="nav-link">
                        <i class="fas fa-users"></i>
                        <span>Users</span>
                    </a>
                </li>
            </ul>
            <div class="nav-section">
                <div class="nav-section-title">INFORMASI PUBLIK</div>
                <ul class="sidebar-nav">
                    <li class="nav-item">
                        <a href="{{ route('category.data') }}" class="nav-link">
                            <i class="fas fa-tags"></i>
                            <span>Category</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('post.data') }}" class="nav-link active">
                            <i class="fas fa-newspaper"></i>
                            <span>Posts</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('headline.data') }}" class="nav-link">
                            <i class="fas fa-bullhorn"></i>
                            <span>Headlines</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="nav-section">
                <div class="nav-section-title">DOKUMEN PUBLIK</div>
                <ul class="sidebar-nav">
                    <li class="nav-item">
                        <a href="{{ route('data.index') }}" class="nav-link">
                            <i class="fas fa-database"></i>
                            <span>Data</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('document.data') }}" class="nav-link">
                            <i class="fas fa-file-alt"></i>
                            <span>Dokumen</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('file.data') }}" class="nav-link">
                            <i class="fas fa-folder"></i>
                            <span>Files</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="nav-section">
                <div class="nav-section-title">LAYANAN MASYARAKAT</div>
                <ul class="sidebar-nav">
                    <li class="nav-item">
                        <a href="{{ route('icon.data') }}" class="nav-link">
                            <i class="fas fa-globe"></i>
                            <span>Portal</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.businesses.index') }}" class="nav-link">
                            <i class="fas fa-store"></i>
                            <span>UMKM</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <!-- Page Content with Background -->
        <div class="page-content form-container">
            <div class="container">
                <div class="row justify-content-md-center">
                    <div class="col-md-10 col-centered">
                        <div class="text-center" style="margin-bottom: 40px;">
                            <h1>Edit Post</h1>
                        </div>
                        <form action="{{ route('post.update', $post->id) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group" style="margin-bottom: 25px;">
                                <label for="title">Title:</label>
                                <input type="text" class="form-control" name="title" value="{{ $post->title }}">
                            </div>

                            <div class="form-group" style="margin-bottom: 25px;">
                                <label for="category_id">Category:</label>
                                <select name="category_id" class="form-control" id="category-select">
                                    <option value="">-- Select Category --</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ $post->category_id == $category->id ? 'selected' : '' }}>
                                            {{ $category->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group" style="margin-bottom: 25px;">
                                <label for="headline_id">Headline:</label>
                                <select name="headline_id" class="form-control" id="headline-select">
                                    <option value="">-- Select Headline --</option>
                                    @foreach ($headlines as $headline)
                                        <option value="{{ $headline->id }}"
                                            {{ $post->headline_id == $headline->id ? 'selected' : '' }}>
                                            {{ $headline->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Bagian ini menampilkan input gambar dan tombol Add -->
                            <div class="d-flex" style="margin-bottom: 15px;">
                                <div class="me-2" style="flex: 1;">
                                    <label for="image" class="form-label">Images:</label>
                                    <input type="file" class="form-control" name="images[]" id="image-upload"
                                        multiple>
                                </div>

                                <!-- Tombol untuk menambahkan gambar -->
                                <button type="button" id="add-image-btn" class="btn btn-default"
                                    style="margin-top: 25px;">Add Image</button>
                            </div>

                            <div id="image-preview" style="margin-top: 15px;">
                                @if ($post->image)
                                    @php
                                        $images = json_decode($post->image);
                                    @endphp
                                    @foreach ($images as $image)
                                        <div class="file-item">
                                            <img src="{{ asset('storage/' . $image) }}" class="img-fluid"
                                                alt="Uploaded Image" width="150">
                                            <button class="remove-file-btn"
                                                data-image="{{ $image }}">X</button>
                                            <!-- Tambahkan data-image -->
                                        </div>
                                    @endforeach
                                @endif
                            </div>

                            <div style="margin-bottom: 25px;">
                                <label for="description">Description:</label>
                                <textarea name="description" id="description" cols="30" rows="10">{{ $post->description }}</textarea>
                            </div>

                            <div class="form-group" style="margin-bottom: 25px;">
                                <label for="published_at">Tanggal publish:</label>
                                <input type="datetime-local" class="form-control" name="published_at"
                                    value="{{ $post->published_at ? $post->published_at->format('Y-m-d\TH:i') : '' }}">
                            </div>

                            <button type="submit" class="btn btn-lg btn-primary btn-block">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Sidebar toggle functionality
            $('#sidebarToggle').click(function() {
                const sidebar = $('#sidebar');
                const mainContent = $('#mainContent');
                const toggleBtn = $('#sidebarToggle');

                sidebar.toggleClass('collapsed');
                mainContent.toggleClass('expanded');

                // Update toggle button position
                if (sidebar.hasClass('collapsed')) {
                    toggleBtn.css('left', '85px');
                } else {
                    toggleBtn.css('left', '265px');
                }
            });

            // Initialize Summernote
            $('#description').summernote({
                placeholder: 'description...',
                tabsize: 2,
                height: 300
            });

            // Initialize Select2 for the category select
            $('#category-select').select2({
                placeholder: "-- Select Category --",
                allowClear: true
            });

            // Initialize Select2 for the headline select
            $('#headline-select').select2({
                placeholder: "-- Select Headline --",
                allowClear: true
            });

            const imageInput = document.getElementById('image-upload');
            const imagePreviewContainer = document.getElementById('image-preview');
            let selectedImages = new DataTransfer();

            // Fungsi untuk memperbarui pratinjau gambar baru
            function updateImagePreview(files) {
                Array.from(files).forEach((file, index) => {
                    const imageItem = document.createElement('div');
                    imageItem.classList.add('file-item');

                    const imageElement = document.createElement('img');
                    imageElement.src = URL.createObjectURL(file);
                    imageElement.width = 150;
                    imageElement.classList.add('me-2');

                    const removeBtn = document.createElement('button');
                    removeBtn.classList.add('remove-file-btn');
                    removeBtn.textContent = 'X';

                    // Hapus gambar ketika tombol X diklik
                    removeBtn.addEventListener('click', function(event) {
                        event.preventDefault(); // Mencegah aksi default tombol submit
                        event.stopPropagation(); // Mencegah event bubbling
                        imageItem.remove(); // Menghapus elemen gambar dari pratinjau
                        selectedImages.items.remove(index); // Menghapus gambar dari DataTransfer
                        imageInput.files = selectedImages.files; // Memperbarui file input

                        if (selectedImages.items.length === 0) {
                            imageInput.value = ''; // Reset input jika tidak ada gambar
                        }
                    });

                    imageItem.appendChild(imageElement);
                    imageItem.appendChild(removeBtn);
                    imagePreviewContainer.appendChild(imageItem);
                    selectedImages.items.add(file);
                });

                imageInput.files = selectedImages.files;
            }

            // Tombol "Add Image" memicu pemilihan gambar
            document.getElementById('add-image-btn').addEventListener('click', function() {
                imageInput.click();
            });

            // Perbarui pratinjau ketika gambar dipilih
            imageInput.addEventListener('change', function(event) {
                updateImagePreview(event.target.files);
            });

            // Menangani penghapusan gambar dari pratinjau dan server
            $(document).on('click', '.remove-file-btn', function(e) {
                e.preventDefault();
                const imageItem = $(this).closest('.file-item');
                const imageName = $(this).data('image');

                $.ajax({
                    url: '/post/delete-image', // Buat route untuk handle delete
                    method: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        image: imageName,
                        post_id: "{{ $post->id }}"
                    },
                    success: function(response) {
                        if (response.success) {
                            imageItem.remove(); // Menghapus elemen pratinjau gambar
                        } else {
                            alert('Gagal menghapus gambar.');
                        }
                    },
                    error: function() {
                        alert('Terjadi kesalahan.');
                    }
                });
            });

            // Load pending businesses notification
            function loadPendingBusinesses() {
                $.ajax({
                    url: '/admin/api/pending-businesses',
                    type: 'GET',
                    success: function(response) {
                        const pendingCount = response.count || 0;
                        const businesses = response.businesses || [];

                        // Update notification count
                        $('#pendingCount').text(pendingCount);

                        // Update badge visibility
                        if (pendingCount > 0) {
                            $('#pendingCount').css('display', 'flex').show();
                        } else {
                            $('#pendingCount').hide();
                        }

                        // Update business list
                        let businessHtml = '';
                        if (businesses.length > 0) {
                            businesses.forEach(function(business) {
                                businessHtml += `
                                    <li>
                                        <a href="/admin/businesses/${business.id}" style="padding: 8px 15px; display: block;">
                                            <div style="display: flex; align-items: center;">
                                                <div style="margin-right: 10px;">
                                                    ${business.foto && business.foto.length > 0 ? 
                                                        `<img src="/storage/${business.foto[0]}" class="img-circle" width="32" height="32" style="object-fit: cover;">` :
                                                        `<div class="img-circle" style="width: 32px; height: 32px; background-color: #6c757d; color: white; display: flex; align-items: center; justify-content: center; font-size: 12px;">${business.nama.substring(0, 2).toUpperCase()}</div>`
                                                    }
                                                </div>
                                                <div style="flex-grow: 1;">
                                                    <div style="font-weight: bold; max-width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">${business.nama}</div>
                                                    <div style="color: #6c757d; font-size: 12px;">${business.email}</div>
                                                </div>
                                                <div style="margin-left: 10px;">
                                                    <span class="label label-warning">Pending</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>`;
                            });
                        } else {
                            businessHtml =
                                '<li><div style="padding: 15px; text-align: center; color: #6c757d;">Tidak ada UMKM pending</div></li>';
                        }

                        $('#pendingBusinessList').html(businessHtml);
                    },
                    error: function() {
                        $('#pendingBusinessList').html(
                            '<li><div style="padding: 15px; text-align: center; color: #6c757d;">Error loading data</div></li>'
                        );
                    }
                });
            }

            // Load pending businesses on page load
            loadPendingBusinesses();

            // Refresh every 30 seconds
            setInterval(loadPendingBusinesses, 30000);

            // Refresh when dropdown is clicked
            $('#pendingBusinessNotification').on('click', function() {
                loadPendingBusinesses();
            });
        });
    </script>


</body>

</html>
