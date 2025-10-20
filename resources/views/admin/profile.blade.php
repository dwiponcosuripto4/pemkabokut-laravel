@extends('admin.layouts.navigation')

@section('title', 'Profile - Sistem Admin Portal Informasi OKU Timur')

@section('content')
    <div class="container-fluid">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="h3 mb-0 text-gray-800">Profile Admin</h2>
                        <p class="text-muted">Kelola informasi profile dan keamanan akun Anda</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Success Alert -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-check-circle me-3 fs-5"></i>
                    <div>
                        <strong>Berhasil!</strong> {{ session('success') }}
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-exclamation-triangle me-3 fs-5"></i>
                    <div>
                        <strong>Terjadi Kesalahan!</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row">
            <!-- Profile Information Card -->
            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex align-items-center">
                        <i class="fas fa-user text-primary me-2"></i>
                        <h6 class="m-0 font-weight-bold text-primary">Informasi Profile</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <!-- Photo Upload Section -->
                                <div class="col-md-4 mb-4">
                                    <div class="text-center">
                                        <div class="mb-3">
                                            @if ($user->foto && file_exists(storage_path('app/public/users/' . $user->foto)))
                                                <img src="{{ asset('storage/users/' . $user->foto) }}"
                                                    class="rounded-circle" width="150" height="150"
                                                    style="object-fit: cover; object-position: top;"
                                                    id="profilePhotoPreview">
                                            @else
                                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto img-thumbnail"
                                                    style="width: 150px; height: 150px; font-size: 48px; font-weight: bold;"
                                                    id="profilePhotoPreview">
                                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                                </div>
                                            @endif
                                        </div>

                                        <div class="mb-3">
                                            <input type="file" class="form-control @error('foto') is-invalid @enderror"
                                                id="foto" name="foto" accept="image/*" style="display: none;">
                                            <button type="button" class="btn btn-outline-primary btn-sm me-2"
                                                onclick="document.getElementById('foto').click();">
                                                <i class="fas fa-camera me-1"></i>Ganti Foto
                                            </button>
                                            @if ($user->foto)
                                                <a href="{{ route('admin.profile.delete-photo') }}"
                                                    class="btn btn-outline-danger btn-sm"
                                                    onclick="return confirm('Yakin ingin menghapus foto?')">
                                                    <i class="fas fa-trash me-1"></i>Hapus
                                                </a>
                                            @endif
                                        </div>
                                        @error('foto')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                        <p class="text-muted small">Format: JPG, PNG, GIF (max 2MB)</p>
                                    </div>
                                </div>

                                <!-- Form Fields -->
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Nama Lengkap</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="unit" class="form-label">Unit Diskominfo</label>
                                        <select class="form-control @error('unit') is-invalid @enderror" id="unit"
                                            name="unit" required>
                                            <option value="">-- Pilih Unit --</option>
                                            <option value="Bidang Infrastruktur Teknologi Informasi"
                                                {{ old('unit', $user->unit) == 'Bidang Infrastruktur Teknologi Informasi' ? 'selected' : '' }}>
                                                Bidang Infrastruktur Teknologi Informasi</option>
                                            <option value="Bidang Informasi dan Komunikasi Publik"
                                                {{ old('unit', $user->unit) == 'Bidang Informasi dan Komunikasi Publik' ? 'selected' : '' }}>
                                                Bidang Informasi dan Komunikasi Publik</option>
                                            <option value="Bidang Persandian dan Keamanan Informasi"
                                                {{ old('unit', $user->unit) == 'Bidang Persandian dan Keamanan Informasi' ? 'selected' : '' }}>
                                                Bidang Persandian dan Keamanan Informasi</option>
                                            <option value="Bidang Statistik"
                                                {{ old('unit', $user->unit) == 'Bidang Statistik' ? 'selected' : '' }}>
                                                Bidang Statistik</option>
                                            <option value="Sekretariat"
                                                {{ old('unit', $user->unit) == 'Sekretariat' ? 'selected' : '' }}>
                                                Sekretariat</option>
                                        </select>
                                        @error('unit')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Bergabung Sejak</label>
                                        <input type="text" class="form-control"
                                            value="{{ $user->created_at->format('d F Y') }}" readonly>
                                    </div>

                                    <div class="text-end">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save me-1"></i>Simpan Perubahan
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Change Password Card -->
            <div class="col-lg-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex align-items-center">
                        <i class="fas fa-lock text-warning me-2"></i>
                        <h6 class="m-0 font-weight-bold text-warning">Ubah Password</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.profile.update-password') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="current_password" class="form-label">Password Saat Ini</label>
                                <div class="input-group">
                                    <input type="password"
                                        class="form-control @error('current_password') is-invalid @enderror"
                                        id="current_password" name="current_password" required>
                                    <span class="input-group-text"
                                        onclick="togglePassword('current_password', 'eyeIconCurrent')"
                                        style="cursor:pointer;">
                                        <svg id="eyeIconCurrent" xmlns="http://www.w3.org/2000/svg"
                                            class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor" width="20" height="20">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </span>
                                </div>
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password Baru</label>
                                <div class="input-group">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        id="password" name="password" required>
                                    <span class="input-group-text" onclick="togglePassword('password', 'eyeIconNew')"
                                        style="cursor:pointer;">
                                        <svg id="eyeIconNew" xmlns="http://www.w3.org/2000/svg"
                                            class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor" width="20" height="20">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </span>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password_confirmation"
                                        name="password_confirmation" required>
                                    <span class="input-group-text"
                                        onclick="togglePassword('password_confirmation', 'eyeIconConfirm')"
                                        style="cursor:pointer;">
                                        <svg id="eyeIconConfirm" xmlns="http://www.w3.org/2000/svg"
                                            class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor" width="20" height="20">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </span>
                                </div>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-warning text-white">
                                    <i class="fas fa-key me-1"></i>Update Password
                                </button>
                            </div>
                            <script>
                                function togglePassword(inputId, iconId) {
                                    const passwordInput = document.getElementById(inputId);
                                    const eyeIcon = document.getElementById(iconId);
                                    if (passwordInput.type === 'password') {
                                        passwordInput.type = 'text';
                                        eyeIcon.innerHTML =
                                            `<path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.956 9.956 0 012.907-4.568M6.634 6.634A9.956 9.956 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.96 9.96 0 01-4.21 5.442M15 12a3 3 0 11-6 0 3 3 0 016 0z' /><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M3 3l18 18' />`;
                                    } else {
                                        passwordInput.type = 'password';
                                        eyeIcon.innerHTML =
                                            `<path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M15 12a3 3 0 11-6 0 3 3 0 016 0z' /><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z' />`;
                                    }
                                }
                            </script>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Horizontal Account Info Card -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex align-items-center">
                    <i class="fas fa-info-circle text-info me-2"></i>
                    <h6 class="m-0 font-weight-bold text-info">Informasi Akun</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-row flex-wrap justify-content-between align-items-center">
                        <div class="p-2">
                            <small class="text-muted">ID Pengguna:</small><br>
                            <span class="fw-bold">#{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        <div class="p-2">
                            <small class="text-muted">Terakhir Login:</small><br>
                            <span class="fw-bold">{{ now()->format('d F Y, H:i') }}</span>
                        </div>
                        <div class="info-card-horizontal p-2">
                            <div class="card card-horizontal border-left-primary shadow mb-0">
                                <div class="card-body d-flex align-items-center justify-content-between px-3 py-2">
                                    <div class="d-flex align-items-center gap-3">
                                        <i class="fas fa-newspaper fa-2x text-primary"></i>
                                        <div>
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Post
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                {{ \App\Models\Post::where('user_id', $user->id)->count() }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="info-card-horizontal p-2">
                            <div class="card card-horizontal border-left-success shadow mb-0">
                                <div class="card-body d-flex align-items-center justify-content-between px-3 py-2">
                                    <div class="d-flex align-items-center gap-3">
                                        <i class="fas fa-file-alt fa-2x text-success"></i>
                                        <div>
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Document</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                {{ \App\Models\Document::where('user_id', $user->id)->count() }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="info-card-horizontal p-2">
                            <div class="card card-horizontal border-left-info shadow mb-0">
                                <div class="card-body d-flex align-items-center justify-content-between px-3 py-2">
                                    <div class="d-flex align-items-center gap-3">
                                        <i class="fas fa-icons fa-2x text-info"></i>
                                        <div>
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Icon
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                {{ \App\Models\Icon::where('user_id', $user->id)->count() }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>

    <!-- Custom Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Photo preview functionality
            const photoInput = document.getElementById('foto');
            const photoPreview = document.getElementById('profilePhotoPreview');

            if (photoInput && photoPreview) {
                photoInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        // Validate file size (2MB)
                        if (file.size > 2 * 1024 * 1024) {
                            alert('Ukuran file terlalu besar. Maksimal 2MB.');
                            this.value = '';
                            return;
                        }

                        // Validate file type
                        const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
                        if (!allowedTypes.includes(file.type)) {
                            alert('Format file tidak didukung. Gunakan: JPEG, PNG, JPG, atau GIF.');
                            this.value = '';
                            return;
                        }

                        const reader = new FileReader();
                        reader.onload = function(e) {
                            if (photoPreview.tagName === 'IMG') {
                                photoPreview.src = e.target.result;
                            } else {
                                // Replace div with img
                                const newImg = document.createElement('img');
                                newImg.src = e.target.result;
                                newImg.className = 'rounded-circle img-thumbnail';
                                newImg.width = 150;
                                newImg.height = 150;
                                newImg.style.objectFit = 'cover';
                                newImg.id = 'profilePhotoPreview';
                                photoPreview.parentNode.replaceChild(newImg, photoPreview);
                            }
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }

            // Auto-hide alerts after 5 seconds
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            });

            // Confirm password change
            const passwordForm = document.querySelector('form[action*="password"]');
            if (passwordForm) {
                passwordForm.addEventListener('submit', function(e) {
                    const currentPassword = document.getElementById('current_password').value;
                    const newPassword = document.getElementById('password').value;
                    const confirmPassword = document.getElementById('password_confirmation').value;

                    if (newPassword !== confirmPassword) {
                        e.preventDefault();
                        alert('Password baru dan konfirmasi password tidak sama.');
                        return;
                    }

                    if (newPassword.length < 8) {
                        e.preventDefault();
                        alert('Password baru minimal 8 karakter.');
                        return;
                    }

                    if (!confirm('Yakin ingin mengubah password?')) {
                        e.preventDefault();
                    }
                });
            }

            // Form validation enhancement
            const forms = document.querySelectorAll('form');
            forms.forEach(function(form) {
                form.addEventListener('submit', function(e) {
                    const submitBtn = form.querySelector('button[type="submit"]');
                    if (submitBtn) {
                        submitBtn.disabled = true;
                        submitBtn.innerHTML =
                            '<i class="fas fa-spinner fa-spin me-1"></i>Memproses...';

                        // Re-enable after 3 seconds in case of error
                        setTimeout(function() {
                            submitBtn.disabled = false;
                            if (submitBtn.innerHTML.includes('Memproses')) {
                                submitBtn.innerHTML = submitBtn.innerHTML.replace(
                                    '<i class="fas fa-spinner fa-spin me-1"></i>Memproses...',
                                    submitBtn.dataset.originalText || 'Submit');
                            }
                        }, 3000);
                    }
                });
            });

            // Store original button text
            document.querySelectorAll('button[type="submit"]').forEach(function(btn) {
                btn.dataset.originalText = btn.innerHTML;
            });
        });
    </script>

    <style>
        .card {
            border: none;
            border-radius: 10px;
        }

        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 10px 10px 0 0 !important;
        }

        .card-header .text-primary,
        .card-header .text-warning,
        .card-header .text-info {
            color: white !important;
        }

        .btn-outline-primary:hover,
        .btn-outline-danger:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .alert {
            border-radius: 10px;
            border: none;
        }

        /* Card Info Akun Horizontal Custom */
        .info-card-horizontal {
            min-width: 260px;
            max-width: 320px;
            flex: 1 1 260px;
            display: flex;
            align-items: stretch;
        }

        .card-horizontal {
            width: 100%;
            min-height: 70px;
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: flex-start;
        }

        .card-horizontal .card-body {
            width: 100%;
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: flex-start;
        }

        .card-horizontal i {
            margin-right: 10px;
        }

        @media (max-width: 768px) {
            .info-card-horizontal {
                min-width: 180px;
                max-width: 100%;
            }

            .card-horizontal {
                min-height: 60px;
            }
        }
    </style>
@endsection
