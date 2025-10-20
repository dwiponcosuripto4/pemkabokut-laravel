@extends('admin.layouts.navigation')

@section('title', 'Detail User - Sistem Admin Portal Informasi OKU Timur')

@section('content')
    <div class="container-fluid py-3">
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="h4 mb-1 text-gray-800 fw-bold">Detail User</h2>
                <p class="text-muted mb-0 small">Informasi lengkap pengguna sistem</p>
            </div>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row g-3">
            <!-- Main Profile Card -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            <!-- Profile Image -->
                            <div class="col-md-4 text-center mb-3 mb-md-0">
                                @if ($user->foto && file_exists(storage_path('app/public/users/' . $user->foto)))
                                    <img src="{{ asset('storage/users/' . $user->foto) }}"
                                        class="rounded-circle shadow-sm border" width="120" height="120"
                                        style="object-fit: cover; object-position: top;">
                                @else
                                    <div class="rounded-circle bg-gradient-primary text-white d-flex align-items-center justify-content-center shadow-sm mx-auto"
                                        style="width: 120px; height: 120px; font-size: 36px; font-weight: 600;">
                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                    </div>
                                @endif
                            </div>

                            <!-- Profile Info -->
                            <div class="col-md-8">
                                <h4 class="mb-1 fw-bold text-dark">{{ $user->name }}</h4>
                                <p class="text-muted mb-2">{{ $user->email }}</p>

                                <div class="d-flex flex-wrap gap-2 mb-3">
                                    <span class="badge bg-light text-dark px-2 py-1">
                                        <i class="fas fa-calendar-alt me-1"></i>
                                        Bergabung {{ $user->created_at->format('d M Y') }}
                                    </span>
                                    @if ($user->is_verified)
                                        <span class="badge bg-success px-2 py-1">
                                            <i class="fas fa-check-circle me-1"></i>
                                            Terverifikasi
                                        </span>
                                    @else
                                        <span class="badge bg-warning text-dark px-2 py-1">
                                            <i class="fas fa-exclamation-triangle me-1"></i>
                                            Belum Terverifikasi
                                        </span>
                                    @endif
                                    <span class="badge bg-info text-white px-2 py-1">
                                        <i class="fas fa-building me-1"></i>
                                        {{ $user->unit ?? '-' }}
                                    </span>
                                </div>

                                <div class="border-top pt-3">
                                    <small class="text-muted">ID Pengguna:</small>
                                    <span class="fw-bold ms-1">#{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="col-lg-4">
                <div class="row g-2">
                    <!-- Posts Stats -->
                    <div class="col-6">
                        <div class="card border-0 shadow-sm text-center">
                            <div class="card-body p-3">
                                <div class="text-primary mb-2">
                                    <i class="fas fa-newspaper fa-2x"></i>
                                </div>
                                <h5 class="mb-1 fw-bold">{{ \App\Models\Post::where('user_id', $user->id)->count() }}</h5>
                                <small class="text-muted">Posts</small>
                            </div>
                        </div>
                    </div>

                    <!-- Documents Stats -->
                    <div class="col-6">
                        <div class="card border-0 shadow-sm text-center">
                            <div class="card-body p-3">
                                <div class="text-success mb-2">
                                    <i class="fas fa-file-alt fa-2x"></i>
                                </div>
                                <h5 class="mb-1 fw-bold">{{ \App\Models\Document::where('user_id', $user->id)->count() }}
                                </h5>
                                <small class="text-muted">Documents</small>
                            </div>
                        </div>
                    </div>

                    <!-- Icons Stats -->
                    <div class="col-6">
                        <div class="card border-0 shadow-sm text-center">
                            <div class="card-body p-3">
                                <div class="text-info mb-2">
                                    <i class="fas fa-icons fa-2x"></i>
                                </div>
                                <h5 class="mb-1 fw-bold">{{ \App\Models\Icon::where('user_id', $user->id)->count() }}</h5>
                                <small class="text-muted">Icons</small>
                            </div>
                        </div>
                    </div>

                    <!-- Last Login -->
                    <div class="col-6">
                        <div class="card border-0 shadow-sm text-center">
                            <div class="card-body p-3">
                                <div class="text-warning mb-2">
                                    <i class="fas fa-clock fa-2x"></i>
                                </div>
                                <h6 class="mb-1 fw-bold">{{ $user->updated_at->diffForHumans() }}</h6>
                                <small class="text-muted">Last Activity</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if (auth()->id() === 1)
            <!-- Admin Actions -->
            <div class="row mt-3">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-primary text-white border-0">
                            <h6 class="mb-0 fw-bold">
                                <i class="fas fa-shield-alt me-2"></i>
                                Admin Actions
                            </h6>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.user.reset-password', $user->id) }}" method="POST"
                                class="d-inline">
                                @csrf
                                <div class="row align-items-end g-3">
                                    <div class="col-md-8">
                                        <label for="new_password" class="form-label fw-bold">Reset Password</label>
                                        <input type="password" name="new_password" id="new_password" class="form-control"
                                            placeholder="Masukkan password baru" required>
                                        <label for="confirm_password" class="form-label fw-bold mt-3">Konfirmasi
                                            Password</label>
                                        <input type="password" name="confirm_password" id="confirm_password"
                                            class="form-control" placeholder="Ulangi password baru" required>
                                    </div>
                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-danger w-100">
                                            <i class="fas fa-key me-1"></i>
                                            Reset Password
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    const form = document.querySelector('form[action*="reset-password"]');
                                    form.addEventListener('submit', function(e) {
                                        const password = document.getElementById('new_password').value;
                                        const confirm = document.getElementById('confirm_password').value;
                                        if (password !== confirm) {
                                            e.preventDefault();
                                            alert('Password dan konfirmasi password harus sama!');
                                            document.getElementById('confirm_password').focus();
                                        }
                                    });
                                });
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <style>
        .bg-gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .card {
            transition: transform 0.2s ease-in-out;
        }

        .card:hover {
            transform: translateY(-2px);
        }

        .badge {
            font-size: 0.75rem;
        }
    </style>
@endsection
