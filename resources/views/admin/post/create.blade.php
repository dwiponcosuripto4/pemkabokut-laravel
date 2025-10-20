<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Create Post - Sistem Admin Portal Informasi OKU Timur</title>
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

    <!-- Modern Form Styles -->
    <style>
        /* Modern Header */
        .modern-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 20px;
            padding: 40px;
            margin-bottom: 30px;
            position: relative;
            overflow: hidden;
            color: white;
        }

        .modern-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            animation: rotate 20s linear infinite;
        }

        @keyframes rotate {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .header-content {
            display: flex;
            align-items: center;
            position: relative;
            z-index: 1;
        }

        .header-icon {
            font-size: 4rem;
            margin-right: 20px;
            opacity: 0.9;
        }

        .header-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin: 0 0 8px 0;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .header-subtitle {
            font-size: 1.1rem;
            margin: 0;
            opacity: 0.9;
        }

        .header-decoration {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #ff6b6b, #4ecdc4, #45b7d1, #96ceb4);
        }

        /* Modern Form Card */
        .modern-form-card {
            background: #fff;
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
            padding: 40px;
            position: relative;
            border: 1px solid #f0f0f0;
        }

        .modern-form-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #667eea, #764ba2);
            border-radius: 24px 24px 0 0;
        }

        /* Form Sections */
        .form-section {
            margin-bottom: 40px;
            border-bottom: 1px solid #f0f0f0;
            padding-bottom: 30px;
        }

        .form-section:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }

        .section-header {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
        }

        .section-icon {
            font-size: 1.5rem;
            color: #667eea;
            margin-right: 12px;
        }

        .section-title {
            font-size: 1.4rem;
            font-weight: 600;
            color: #2d3748;
            margin: 0;
        }

        /* Form Grid */
        .form-grid {
            display: grid;
            gap: 25px;
        }

        .form-grid.two-columns {
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        }

        /* Modern Form Groups */
        .form-group-modern {
            position: relative;
        }

        .form-group-modern.full-width {
            grid-column: 1 / -1;
        }

        /* Modern Labels */
        .modern-label {
            display: flex;
            align-items: center;
            font-weight: 600;
            color: #4a5568;
            font-size: 14px;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .modern-label i {
            margin-right: 8px;
            color: #667eea;
        }

        /* Input Wrapper */
        .input-wrapper {
            position: relative;
        }

        /* Modern Inputs */
        .modern-input {
            width: 100%;
            padding: 16px 20px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 16px;
            background: #fff;
            transition: all 0.3s ease;
            outline: none;
        }

        .modern-input:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            transform: translateY(-2px);
        }

        .input-border {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, #667eea, #764ba2);
            transition: width 0.3s ease;
        }

        .modern-input:focus+.input-border {
            width: 100%;
        }

        /* Select Wrapper */
        .select-wrapper {
            position: relative;
        }

        .modern-select {
            width: 100%;
            padding: 16px 20px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 16px;
            background: #fff;
            transition: all 0.3s ease;
            outline: none;
            cursor: pointer;
        }

        .modern-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        /* Image Upload Area */
        .image-upload-area {
            position: relative;
        }

        .upload-zone {
            border: 3px dashed #cbd5e0;
            border-radius: 16px;
            padding: 40px 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            position: relative;
            overflow: hidden;
        }

        .upload-zone::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(102, 126, 234, 0.1), transparent);
            transition: left 0.5s ease;
        }

        .upload-zone:hover {
            border-color: #667eea;
            background: linear-gradient(135deg, #f0f4ff 0%, #e6f0ff 100%);
            transform: translateY(-2px);
        }

        .upload-zone:hover::before {
            left: 100%;
        }

        .upload-icon {
            font-size: 3rem;
            color: #667eea;
            margin-bottom: 15px;
        }

        .upload-text h4 {
            font-size: 1.2rem;
            font-weight: 600;
            color: #2d3748;
            margin: 0 0 8px 0;
        }

        .upload-text p {
            color: #718096;
            margin: 0 0 10px 0;
        }

        .upload-text small {
            color: #a0aec0;
            font-size: 12px;
        }

        .hidden-input {
            display: none;
        }

        .btn-add-image {
            margin-top: 15px;
            padding: 12px 24px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-add-image:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        }

        /* Image Preview Grid */
        .image-preview-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 20px;
        }

        .file-item {
            position: relative;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            max-width: 100%;
        }

        .file-item:hover {
            transform: translateY(-2px);
        }

        .file-item img {
            max-width: 100%;
            height: auto;
            display: block;
            border-radius: 12px;
        }

        /* Image size variants untuk kontrol ukuran */
        .file-item.small img {
            max-width: 150px;
        }

        .file-item.medium img {
            max-width: 250px;
        }

        .file-item.large img {
            max-width: 350px;
        }

        /* Image info tooltip */
        .image-info {
            position: absolute;
            bottom: 8px;
            left: 8px;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 10px;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .file-item:hover .image-info {
            opacity: 1;
        }

        .remove-file-btn {
            position: absolute;
            top: 8px;
            right: 8px;
            width: 24px;
            height: 24px;
            background: #ff6b6b;
            color: white;
            border: none;
            border-radius: 50%;
            font-size: 12px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .remove-file-btn:hover {
            background: #ff5252;
            transform: scale(1.1);
        }

        /* Editor Wrapper */
        .editor-wrapper {
            border-radius: 12px;
            overflow: hidden;
            border: 2px solid #e2e8f0;
            transition: border-color 0.3s ease;
        }

        .editor-wrapper:focus-within {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        /* Submit Section */
        .submit-section {
            margin-top: 40px;
            padding-top: 30px;
            border-top: 2px solid #f0f0f0;
        }

        .submit-buttons {
            display: flex;
            gap: 15px;
            justify-content: flex-end;
            align-items: center;
        }

        .btn-draft {
            padding: 14px 28px;
            background: #f7fafc;
            color: #4a5568;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-draft:hover {
            background: #edf2f7;
            border-color: #cbd5e0;
            transform: translateY(-1px);
        }

        .btn-publish {
            padding: 14px 28px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-publish:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.5);
        }

        /* Error Messages */
        .error-message {
            color: #ff6b6b;
            font-size: 14px;
            margin-top: 8px;
            display: none;
            padding: 8px 12px;
            background: #fff5f5;
            border: 1px solid #fed7d7;
            border-radius: 6px;
        }

        .error-message.show {
            display: block;
        }

        /* Select2 Modern Styling */
        .select2-container--default .select2-selection--single {
            border: 2px solid #e2e8f0 !important;
            border-radius: 12px !important;
            height: 52px !important;
            padding: 8px 16px !important;
            font-size: 16px !important;
            background: #fff !important;
            transition: all 0.3s ease !important;
        }

        .select2-container--default.select2-container--focus .select2-selection--single {
            border-color: #667eea !important;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1) !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #2d3748 !important;
            line-height: 36px !important;
            padding-left: 0 !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 48px !important;
            right: 12px !important;
        }

        .select2-dropdown {
            border: 2px solid #e2e8f0 !important;
            border-radius: 12px !important;
            margin-top: 4px !important;
        }

        .select2-results__option {
            padding: 12px 16px !important;
            transition: all 0.2s ease !important;
        }

        .select2-results__option--highlighted[aria-selected] {
            background: #667eea !important;
        }

        /* Input focus states */
        .input-wrapper.focused .input-border {
            width: 100%;
        }

        /* Animation improvements */
        .modern-input,
        .modern-select {
            transition: all 0.3s cubic-bezier(0.4, 0.0, 0.2, 1);
        }

        .modern-input:hover,
        .modern-select:hover {
            border-color: #cbd5e0;
            transform: translateY(-1px);
        }

        /* Loading states */
        .btn-publish.loading {
            pointer-events: none;
            opacity: 0.7;
        }

        .btn-publish.loading::before {
            content: '';
            position: absolute;
            width: 16px;
            height: 16px;
            margin: auto;
            border: 2px solid transparent;
            border-top-color: #ffffff;
            border-radius: 50%;
            animation: spin 1s ease infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Success states */
        .input-success {
            border-color: #48bb78 !important;
        }

        .input-warning {
            border-color: #ffa500 !important;
        }

        .input-error {
            border-color: #ff6b6b !important;
        }

        /* Drag over state */
        .upload-zone.drag-over {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.2);
        }

        /* Character Counter */
        .char-counter {
            position: absolute;
            right: 12px;
            bottom: -24px;
            font-size: 11px;
            color: #a0aec0;
            font-weight: 500;
        }

        .char-counter.text-warning {
            color: #ffa500 !important;
        }

        .char-counter.text-danger {
            color: #ff6b6b !important;
        }

        /* Form section animations */
        .form-section {
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.6s ease;
        }

        /* Tooltip enhancements */
        [data-tooltip] {
            position: relative;
        }

        [data-tooltip]::after {
            content: attr(data-tooltip);
            position: absolute;
            bottom: -35px;
            left: 50%;
            transform: translateX(-50%);
            background: #2d3748;
            color: white;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12px;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
            z-index: 1000;
        }

        [data-tooltip]:hover::after {
            opacity: 1;
        }

        /* Progress indicator */
        .form-progress {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: #f0f0f0;
            z-index: 1001;
        }

        .form-progress-bar {
            height: 100%;
            background: linear-gradient(90deg, #667eea, #764ba2);
            width: 0%;
            transition: width 0.3s ease;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .modern-header {
                padding: 25px;
            }

            .header-content {
                flex-direction: column;
                text-align: center;
            }

            .header-icon {
                margin: 0 0 15px 0;
            }

            .header-title {
                font-size: 2rem;
            }

            .modern-form-card {
                padding: 25px;
            }

            .form-grid.two-columns {
                grid-template-columns: 1fr;
            }

            .submit-buttons {
                flex-direction: column;
            }

            .submit-buttons button {
                width: 100%;
                justify-content: center;
            }

            /* Image preview responsive */
            .image-preview-grid {
                flex-direction: column;
                align-items: center;
            }

            .file-item img {
                max-width: 100% !important;
                width: 100%;
            }

            .file-item {
                width: 100%;
                max-width: 300px;
            }
        }
    </style>
</head>

<body>
    <!-- Form Progress Indicator -->
    <div class="form-progress">
        <div class="form-progress-bar" id="formProgress"></div>
    </div>

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
                    <div class="col-md-11">
                        <!-- Header Section -->
                        <div class="modern-header">
                            <div class="header-content">
                                <div class="header-icon">
                                    <i class="fas fa-plus-circle"></i>
                                </div>
                                <div class="header-text">
                                    <h1 class="header-title">Create New Post</h1>
                                    <p class="header-subtitle">Membuat postingan berita untuk masyarakat</p>
                                </div>
                            </div>
                            <div class="header-decoration"></div>
                        </div>

                        <!-- Form Card -->
                        <div class="modern-form-card">
                            <form id="create-post-form" action="{{ route('post.store') }}" method="post"
                                enctype="multipart/form-data" novalidate>
                                @csrf

                                <!-- Form Row 1: Title -->
                                <div class="form-section">
                                    <div class="section-header">
                                        <i class="fas fa-heading section-icon"></i>
                                        <h3 class="section-title">Post Information</h3>
                                    </div>
                                    <div class="form-grid">
                                        <div class="form-group-modern full-width">
                                            <div class="input-wrapper">
                                                <label for="title" class="modern-label">
                                                    <i class="fas fa-pen"></i>
                                                    Title
                                                </label>
                                                <input type="text" class="modern-input" name="title"
                                                    id="title"
                                                    placeholder="Enter an engaging title for your post">
                                                <div class="input-border"></div>
                                            </div>
                                            <div id="title-error" class="error-message"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Form Row 2: Category & Headline -->
                                <div class="form-section">
                                    <div class="section-header">
                                        <i class="fas fa-tags section-icon"></i>
                                        <h3 class="section-title">Classification</h3>
                                    </div>
                                    <div class="form-grid two-columns">
                                        <div class="form-group-modern">
                                            <div class="select-wrapper">
                                                <label for="category_id" class="modern-label">
                                                    <i class="fas fa-folder"></i>
                                                    Category
                                                </label>
                                                <select name="category_id" class="modern-select"
                                                    id="category-select">
                                                    <option value="">Choose a category</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}">{{ $category->title }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div id="category-error" class="error-message"></div>
                                        </div>

                                        <div class="form-group-modern">
                                            <div class="select-wrapper">
                                                <label for="headline_id" class="modern-label">
                                                    <i class="fas fa-star"></i>
                                                    Headline
                                                </label>
                                                <select name="headline_id" class="modern-select"
                                                    id="headline-select">
                                                    <option value="">Choose a headline</option>
                                                    @foreach ($headlines as $headline)
                                                        <option value="{{ $headline->id }}">{{ $headline->title }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div id="headline-error" class="error-message"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Form Row 3: Images -->
                                <div class="form-section">
                                    <div class="section-header">
                                        <i class="fas fa-images section-icon"></i>
                                        <h3 class="section-title">Media Gallery</h3>
                                    </div>
                                    <div class="form-grid">
                                        <div class="image-upload-area">
                                            <div class="upload-zone"
                                                onclick="document.getElementById('image-upload').click()">
                                                <div class="upload-icon">
                                                    <i class="fas fa-cloud-upload-alt"></i>
                                                </div>
                                                <div class="upload-text">
                                                    <h4>Click to upload images</h4>
                                                    <p>or drag and drop your files here</p>
                                                    <small>Supports: JPG, PNG, GIF (Max: 5MB each)</small>
                                                </div>
                                                <input type="file" class="hidden-input" name="images[]"
                                                    id="image-upload" multiple>
                                            </div>
                                            <button type="button" id="add-image-btn" class="btn-add-image">
                                                <i class="fas fa-plus"></i>
                                                Add More Images
                                            </button>
                                        </div>
                                        <div id="image-preview" class="image-preview-grid"></div>
                                    </div>
                                </div>

                                <!-- Form Row 4: Content -->
                                <div class="form-section">
                                    <div class="section-header">
                                        <i class="fas fa-edit section-icon"></i>
                                        <h3 class="section-title">Content</h3>
                                    </div>
                                    <div class="form-grid">
                                        <div class="form-group-modern full-width">
                                            <label for="description" class="modern-label">
                                                <i class="fas fa-align-left"></i>
                                                Description
                                            </label>
                                            <div class="editor-wrapper">
                                                <textarea name="description" id="description" cols="30" rows="10"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Form Row 5: Publish Settings -->
                                <div class="form-section">
                                    <div class="section-header">
                                        <i class="fas fa-calendar-alt section-icon"></i>
                                        <h3 class="section-title">Publish Settings</h3>
                                    </div>
                                    <div class="form-grid">
                                        <div class="form-group-modern">
                                            <div class="input-wrapper">
                                                <label for="published_at" class="modern-label">
                                                    <i class="fas fa-clock"></i>
                                                    Publish Date & Time
                                                </label>
                                                <input type="datetime-local" class="modern-input" name="published_at"
                                                    id="published_at" value="{{ date('Y-m-d\TH:i') }}">
                                                <div class="input-border"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit Section -->
                                <div class="submit-section">
                                    <div class="submit-buttons">
                                        <button type="button" class="btn-draft">
                                            <i class="fas fa-save"></i>
                                            Save as Draft
                                        </button>
                                        <button type="submit" class="btn-publish">
                                            <i class="fas fa-rocket"></i>
                                            Publish Post
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Validasi form dengan styling baru
            $('#create-post-form').on('submit', function(e) {
                let valid = true;

                // Reset all error messages
                $('.error-message').removeClass('show').hide();

                // Title required
                const title = $('#title').val().trim();
                if (!title) {
                    $('#title-error').text('Title wajib diisi.').addClass('show').show();
                    $('#title').focus();
                    valid = false;
                }

                // Minimal salah satu category atau headline harus dipilih
                const category = $('#category-select').val();
                const headline = $('#headline-select').val();
                if (!category && !headline) {
                    $('#category-error').text('Pilih minimal salah satu Category atau Headline.').addClass(
                        'show').show();
                    $('#headline-error').text('Pilih minimal salah satu Category atau Headline.').addClass(
                        'show').show();
                    valid = false;
                }

                if (!valid) {
                    e.preventDefault();
                    // Smooth scroll to first error
                    $('html, body').animate({
                        scrollTop: $('.error-message.show:first').offset().top - 100
                    }, 500);
                }
            });
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

            // Initialize Summernote dengan kustomisasi untuk styling modern
            $('#description').summernote({
                placeholder: 'Write your post content here...',
                tabsize: 2,
                height: 300,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });

            // Initialize Select2 dengan styling modern
            $('#category-select').select2({
                placeholder: "Choose a category",
                allowClear: true,
                width: '100%',
                dropdownCssClass: 'modern-dropdown'
            });

            $('#headline-select').select2({
                placeholder: "Choose a headline",
                allowClear: true,
                width: '100%',
                dropdownCssClass: 'modern-dropdown'
            });

            // Input animations dan interactions
            $('.modern-input, .modern-select').on('focus', function() {
                $(this).parent().addClass('focused');
            }).on('blur', function() {
                if (!$(this).val()) {
                    $(this).parent().removeClass('focused');
                }
            });

            // Real-time validation feedback
            $('#title').on('input', function() {
                const value = $(this).val().trim();
                const errorDiv = $('#title-error');

                if (value.length === 0) {
                    errorDiv.text('Title is required').addClass('show').show();
                    $(this).css('border-color', '#ff6b6b');
                } else if (value.length < 10) {
                    errorDiv.text('Title should be at least 10 characters').addClass('show').show();
                    $(this).css('border-color', '#ffa500');
                } else {
                    errorDiv.removeClass('show').hide();
                    $(this).css('border-color', '#48bb78');
                }
            });

            // Drag and drop functionality for image upload
            const uploadZone = document.querySelector('.upload-zone');

            uploadZone.addEventListener('dragover', function(e) {
                e.preventDefault();
                this.classList.add('drag-over');
                this.style.borderColor = '#667eea';
                this.style.background = 'linear-gradient(135deg, #f0f4ff 0%, #e6f0ff 100%)';
            });

            uploadZone.addEventListener('dragleave', function(e) {
                e.preventDefault();
                this.classList.remove('drag-over');
                this.style.borderColor = '#cbd5e0';
                this.style.background = 'linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%)';
            });

            uploadZone.addEventListener('drop', function(e) {
                e.preventDefault();
                this.classList.remove('drag-over');
                this.style.borderColor = '#cbd5e0';
                this.style.background = 'linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%)';

                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    updateImagePreview(files);
                }
            });

            const imageInput = document.getElementById('image-upload');
            const imagePreviewContainer = document.getElementById('image-preview');
            let selectedImages = new DataTransfer();

            // Fungsi untuk memperbarui pratinjau gambar dengan ukuran asli
            function updateImagePreview(files) {
                Array.from(files).forEach((file, index) => {
                    const imageItem = document.createElement('div');
                    imageItem.classList.add('file-item');

                    const imageElement = document.createElement('img');
                    const objectUrl = URL.createObjectURL(file);
                    imageElement.src = objectUrl;

                    // Biarkan gambar tampil dengan ukuran asli (dengan batas maksimal)
                    imageElement.style.maxWidth = '300px';
                    imageElement.style.height = 'auto';
                    imageElement.style.display = 'block';
                    imageElement.style.borderRadius = '12px';

                    // Tambahkan info gambar
                    const imageInfo = document.createElement('div');
                    imageInfo.classList.add('image-info');

                    // Format ukuran file
                    const fileSize = (file.size / 1024).toFixed(1) + ' KB';
                    if (file.size > 1024 * 1024) {
                        fileSize = (file.size / (1024 * 1024)).toFixed(1) + ' MB';
                    }

                    imageInfo.innerHTML = `${file.name}<br>${fileSize}`;

                    // Load gambar untuk mendapatkan dimensi asli
                    imageElement.onload = function() {
                        const dimensions = `${this.naturalWidth}×${this.naturalHeight}`;
                        imageInfo.innerHTML = `${file.name}<br>${fileSize} • ${dimensions}px`;
                    };

                    const removeBtn = document.createElement('button');
                    removeBtn.classList.add('remove-file-btn');
                    removeBtn.innerHTML = '&times;';
                    removeBtn.type = 'button';

                    // Hapus gambar ketika tombol X diklik
                    removeBtn.addEventListener('click', function(e) {
                        e.stopPropagation();
                        imageItem.style.opacity = '0';
                        imageItem.style.transform = 'scale(0.8)';

                        setTimeout(() => {
                            imageItem.remove();
                            selectedImages.items.remove(index);
                            imageInput.files = selectedImages.files;

                            if (selectedImages.items.length === 0) {
                                imageInput.value = '';
                            }
                            // Clean up object URL
                            URL.revokeObjectURL(objectUrl);
                        }, 200);
                    });

                    imageItem.appendChild(imageElement);
                    imageItem.appendChild(imageInfo);
                    imageItem.appendChild(removeBtn);
                    imagePreviewContainer.appendChild(imageItem);
                    selectedImages.items.add(file);

                    // Animation for new items
                    imageItem.style.opacity = '0';
                    imageItem.style.transform = 'scale(0.8)';
                    setTimeout(() => {
                        imageItem.style.transition = 'all 0.3s ease';
                        imageItem.style.opacity = '1';
                        imageItem.style.transform = 'scale(1)';
                    }, 50);
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

            // Enhanced form submission with loading states
            $('#create-post-form').on('submit', function(e) {
                const submitBtn = $('.btn-publish');
                const originalText = submitBtn.html();

                // Add loading state
                submitBtn.addClass('loading')
                    .html('<i class="fas fa-spinner fa-spin"></i> Publishing...')
                    .prop('disabled', true);

                // If validation passes, keep the loading state
                // The form will submit naturally
                setTimeout(() => {
                    if (!e.isDefaultPrevented()) {
                        return; // Let the form submit
                    } else {
                        // If validation failed, restore button
                        submitBtn.removeClass('loading')
                            .html(originalText)
                            .prop('disabled', false);
                    }
                }, 100);
            });

            // Save as draft functionality
            $('.btn-draft').on('click', function() {
                const btn = $(this);
                const originalText = btn.html();

                btn.html('<i class="fas fa-spinner fa-spin"></i> Saving Draft...')
                    .prop('disabled', true);

                // Add draft field to form
                const draftInput = $('<input type="hidden" name="save_as_draft" value="1">');
                $('#create-post-form').append(draftInput);

                // Submit form
                $('#create-post-form').submit();
            });

            // Auto-save draft functionality (optional)
            let autoSaveTimeout;
            $('#title, #description').on('input', function() {
                clearTimeout(autoSaveTimeout);
                autoSaveTimeout = setTimeout(function() {
                    // Auto-save logic here (optional)
                    console.log('Auto-saving draft...');
                }, 5000); // Save after 5 seconds of inactivity
            });

            // Character counter for title
            $('#title').on('input', function() {
                const current = $(this).val().length;
                const max = 255; // Assuming max title length
                const remaining = max - current;

                let counterHtml =
                    `<small class="char-counter ${remaining < 20 ? 'text-warning' : ''} ${remaining < 0 ? 'text-danger' : ''}">${current}/${max} characters</small>`;

                // Remove existing counter
                $(this).parent().find('.char-counter').remove();

                // Add counter
                $(this).parent().append(counterHtml);
            });

            // Smooth animations for form sections
            $('.form-section').each(function(index) {
                $(this).css({
                    'opacity': '0',
                    'transform': 'translateY(20px)'
                });

                setTimeout(() => {
                    $(this).css({
                        'transition': 'all 0.6s ease',
                        'opacity': '1',
                        'transform': 'translateY(0)'
                    });
                }, index * 100);
            });

            // Form progress tracking
            function updateProgress() {
                let filledFields = 0;
                let totalFields = 4; // title, category/headline, description, publish_date

                // Check title
                if ($('#title').val().trim()) filledFields++;

                // Check category or headline
                if ($('#category-select').val() || $('#headline-select').val()) filledFields++;

                // Check description
                if ($('#description').summernote('code').trim() && $('#description').summernote('code') !==
                    '<p><br></p>') filledFields++;

                // Check publish date
                if ($('#published_at').val()) filledFields++;

                const percentage = (filledFields / totalFields) * 100;
                $('#formProgress').css('width', percentage + '%');
            }

            // Track progress on input changes
            $('#title, #published_at').on('input', updateProgress);
            $('#category-select, #headline-select').on('change', updateProgress);
            $('#description').on('summernote.change', updateProgress);

            // Initial progress check
            setTimeout(updateProgress, 1000);

            // Add tooltips to buttons
            $('.btn-publish').attr('data-tooltip', 'Publish your post immediately');
            $('.btn-draft').attr('data-tooltip', 'Save as draft for later editing');
        });
    </script>
</body>

</html>
