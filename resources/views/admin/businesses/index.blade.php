@extends('admin.layouts.navigation')

@section('title', 'UMKM Management - Sistem Admin Portal Informasi OKU Timur')

@section('content')
    <!-- Blue Background Section -->
    <div
        style="background: linear-gradient(rgba(7, 63, 151, 0.8), rgba(7, 63, 151, 0.8)), url('{{ asset('images/Perjaya.jpg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat; position: relative; margin: -21px -23px 0 -23px; padding: 20px 20px 120px 20px;">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="h3 mb-1 text-white">UMKM Management</h1>
                            <p class="text-white-50 mb-0">Manage all registered UMKM businesses</p>
                        </div>
                        <div>
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light me-2">
                                <i class="fas fa-arrow-left me-1"></i>Back to Dashboard
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid" style="margin-top: -120px; position: relative; z-index: 10;">

        <!-- Filter Cards -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <div class="stat-icon bg-primary text-white rounded mb-2 mx-auto"
                            style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-store"></i>
                        </div>
                        <h5>{{ $businesses->total() }}</h5>
                        <p class="text-muted mb-0">Total UMKM</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <div class="stat-icon bg-success text-white rounded mb-2 mx-auto"
                            style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-check"></i>
                        </div>
                        <h5>{{ $businesses->where('status', 1)->count() }}</h5>
                        <p class="text-muted mb-0">Approved</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <div class="stat-icon bg-warning text-white rounded mb-2 mx-auto"
                            style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-clock"></i>
                        </div>
                        <h5>{{ $businesses->where('status', 0)->count() }}</h5>
                        <p class="text-muted mb-0">Pending</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Businesses Table -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header py-3">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <h6 class="m-0 font-weight-bold text-primary">UMKM List</h6>
                            <div class="d-flex gap-2 align-items-center flex-wrap">
                                <!-- Search Form -->
                                <form method="GET" action="{{ route('admin.businesses.index') }}"
                                    class="d-flex gap-2 align-items-center mb-0" id="searchForm">
                                    <div class="input-group" style="width: 250px;">
                                        <input type="text" class="form-control form-control-sm" name="search"
                                            placeholder="Search businesses..." value="{{ request('search') }}"
                                            id="searchInput">
                                        <button class="btn btn-outline-secondary btn-sm" type="submit">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                    <!-- Preserve status filter when searching -->
                                    @if (request('status'))
                                        <input type="hidden" name="status" value="{{ request('status') }}">
                                    @endif
                                </form>

                                <!-- Status Filter Form -->
                                <form method="GET" action="{{ route('admin.businesses.index') }}"
                                    class="d-flex gap-2 align-items-center mb-0" id="filterForm">
                                    <select class="form-select form-select-sm" id="status" name="status"
                                        style="width: 150px;">
                                        <option value="">All Status</option>
                                        <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Approved
                                        </option>
                                        <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Pending
                                        </option>
                                    </select>
                                    <!-- Preserve search term when filtering -->
                                    @if (request('search'))
                                        <input type="hidden" name="search" value="{{ request('search') }}">
                                    @endif
                                </form>

                                <!-- Clear Filters Button -->
                                @if (request('search') || request('status'))
                                    <a href="{{ route('admin.businesses.index') }}" class="btn btn-outline-danger btn-sm">
                                        <i class="fas fa-times"></i> Clear
                                    </a>
                                @endif

                                <!-- Report Button -->
                                <button type="button" class="btn btn-success btn-sm" onclick="downloadBusinessReport()">
                                    <i class="fas fa-file-pdf me-1"></i>Laporan
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if ($businesses->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Photo</th>
                                            <th>Name</th>
                                            <th>Owner</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Type</th>
                                            <th>Status</th>
                                            <th>Updated At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($businesses as $business)
                                            <tr>
                                                <td>
                                                    @if ($business->foto)
                                                        <img src="{{ asset('storage/' . $business->foto) }}"
                                                            class="rounded" alt="{{ $business->nama }}" width="50"
                                                            height="50" style="object-fit: cover;">
                                                    @else
                                                        <div class="bg-secondary text-white rounded d-flex align-items-center justify-content-center"
                                                            style="width: 50px; height: 50px; font-weight: bold;">
                                                            {{ strtoupper(substr($business->nama, 0, 2)) }}
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="font-weight-bold">{{ $business->nama }}</div>
                                                    <small
                                                        class="text-muted">{{ $business->user->name ?? 'No User' }}</small>
                                                </td>
                                                <td>{{ $business->owner }}</td>
                                                <td>{{ $business->email }}</td>
                                                <td>{{ $business->nomor_telepon }}</td>
                                                <td>{{ $business->jenis }}</td>
                                                <td>
                                                    @if ($business->status == 1)
                                                        <span class="badge bg-success">Approved</span>
                                                    @else
                                                        <span class="badge bg-warning">Pending</span>
                                                    @endif
                                                    <div class="mt-2">
                                                        @php
                                                            $user = $business->user;
                                                        @endphp
                                                        <div class="d-flex align-items-center">
                                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name ?? 'Unknown') }}&color=7F9CF5&background=EBF4FF&size=32"
                                                                alt="User" class="rounded-circle me-2" width="32"
                                                                height="32">
                                                            <div>
                                                                <div class="fw-medium">{{ $user->name ?? 'Unknown' }}
                                                                </div>
                                                                <small class="text-muted">ID:
                                                                    {{ $user->id ?? '-' }}</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $business->updated_at ? $business->updated_at->format('d-m-Y H:i') : '-' }}
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('admin.businesses.show', $business) }}"
                                                            class="btn btn-sm btn-outline-info" title="Detail">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('admin.businesses.edit', $business->id) }}"
                                                            class="btn btn-sm btn-outline-warning" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        @if ($business->status == 0)
                                                            <form
                                                                action="{{ route('admin.businesses.approve', $business->id) }}"
                                                                method="POST" style="display:inline;">
                                                                @csrf
                                                                <button type="submit"
                                                                    class="btn btn-sm btn-outline-success"
                                                                    onclick="return confirm('Setujui UMKM ini?')"
                                                                    title="Approve">
                                                                    <i class="fas fa-check"></i>
                                                                </button>
                                                            </form>
                                                        @else
                                                            <form
                                                                action="{{ route('admin.businesses.reject', $business->id) }}"
                                                                method="POST" style="display:inline;">
                                                                @csrf
                                                                <button type="submit"
                                                                    class="btn btn-sm btn-outline-secondary"
                                                                    onclick="return confirm('Tolak UMKM ini?')"
                                                                    title="Set to Pending">
                                                                    <i class="fas fa-times"></i>
                                                                </button>
                                                            </form>
                                                        @endif
                                                        <form
                                                            action="{{ route('admin.businesses.destroy', $business->id) }}"
                                                            method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                                onclick="return confirm('Hapus UMKM ini? Tindakan ini tidak dapat dibatalkan!')"
                                                                title="Delete">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="d-flex justify-content-center">
                                {{ $businesses->appends(request()->query())->links() }}
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-store fa-5x text-muted mb-3"></i>
                                <h5 class="text-muted">No UMKM businesses found</h5>
                                <p class="text-muted">There are no businesses matching your filter criteria.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .table th {
            background-color: #ffffff;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // CSRF Token for AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Status filter change handler
        document.getElementById('status').addEventListener('change', function() {
            document.getElementById('filterForm').submit();
        });

        // Search form enhancement - submit on Enter key
        document.getElementById('searchInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                document.getElementById('searchForm').submit();
            }
        });

        // Approve business function
        $(document).on('click', '.approve-btn', function() {
            const businessId = $(this).data('id');

            Swal.fire({
                title: 'Approve UMKM?',
                text: 'Are you sure you want to approve this business?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, approve it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post(`/admin/businesses/${businessId}/approve`)
                        .done(function(response) {
                            if (response.success) {
                                Swal.fire('Approved!', response.message, 'success');
                                location.reload();
                            }
                        })
                        .fail(function() {
                            Swal.fire('Error!', 'Something went wrong.', 'error');
                        });
                }
            });
        });

        // Reject business function
        $(document).on('click', '.reject-btn', function() {
            const businessId = $(this).data('id');

            Swal.fire({
                title: 'Set to Pending?',
                text: 'This will change the business status to pending.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ffc107',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, set to pending!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post(`/admin/businesses/${businessId}/reject`)
                        .done(function(response) {
                            if (response.success) {
                                Swal.fire('Changed!', response.message, 'success');
                                location.reload();
                            }
                        })
                        .fail(function() {
                            Swal.fire('Error!', 'Something went wrong.', 'error');
                        });
                }
            });
        });

        // Delete business function
        $(document).on('click', '.delete-btn', function() {
            const businessId = $(this).data('id');

            Swal.fire({
                title: 'Delete UMKM?',
                text: 'This action cannot be undone!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/admin/businesses/${businessId}`,
                        type: 'DELETE',
                        success: function(response) {
                            if (response.success) {
                                Swal.fire('Deleted!', response.message, 'success');
                                location.reload();
                            }
                        },
                        error: function() {
                            Swal.fire('Error!', 'Something went wrong.', 'error');
                        }
                    });
                }
            });
        });

        // Download Business Report Function
        function downloadBusinessReport() {
            const loadingBtn = event.target;
            const originalContent = loadingBtn.innerHTML;

            // Show loading state
            loadingBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Generating...';
            loadingBtn.disabled = true;

            // Create form to download PDF
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/admin/businesses/report';
            form.style.display = 'none';

            // Add CSRF token
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            form.appendChild(csrfToken);
            document.body.appendChild(form);
            form.submit();

            // Reset button after delay
            setTimeout(() => {
                loadingBtn.innerHTML = originalContent;
                loadingBtn.disabled = false;
                document.body.removeChild(form);
            }, 3000);
        }
    </script>
@endsection
