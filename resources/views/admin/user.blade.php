@extends('admin.layouts.navigation')

@section('title', 'Daftar User - Admin Dashboard')

@section('content')
    <!-- Blue Background Section -->
    <div
        style="background: linear-gradient(rgba(7, 63, 151, 0.8), rgba(7, 63, 151, 0.8)), url('{{ asset('images/Perjaya.jpg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat; position: relative; margin: -21px -23px 0 -23px; padding: 20px 20px 120px 20px;">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="h3 mb-1 text-white">Daftar User</h1>
                            <p class="text-white-50 mb-0">Kelola pengguna yang terdaftar dalam sistem</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid px-4" style="margin-top: -120px; position: relative; z-index: 10;">
        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total User</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $users->count() }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    User Terverifikasi</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $users->where('is_verified', true)->count() }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-check fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    User Belum Verifikasi</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $users->where('is_verified', false)->count() }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-times fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    User Baru (Bulan Ini)</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $users->where('created_at', '>=', now()->startOfMonth())->count() }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-plus fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Table -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Data User</h6>
                <div class="d-flex gap-2">
                    <div class="input-group" style="width: 250px;">
                        <input type="text" class="form-control form-control-sm" placeholder="Cari user..."
                            id="searchUser">
                        <button class="btn btn-outline-secondary btn-sm" type="button">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                    <select class="form-select form-select-sm" style="width: 150px;" id="filterStatus">
                        <option value="">Semua Status</option>
                        <option value="active">Terverifikasi</option>
                        <option value="inactive">Belum terverifikasi</option>
                    </select>
                    <!-- Report Button -->
                    <button class="btn btn-danger btn-sm" onclick="downloadReport()" title="Download Laporan PDF">
                        <i class="fas fa-file-pdf me-1"></i>Laporan
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="userTable" width="100%" cellspacing="0">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">ID</th>
                                <th width="15%">Foto</th>
                                <th width="20%">Nama</th>
                                <th width="20%">Email</th>
                                <th width="15%">Unit</th>
                                <th width="10%">Status</th>
                                <th width="10%">Terdaftar</th>
                                <th width="15%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $index => $user)
                                <tr>
                                    <td class="text-center fw-bold">{{ $user->id }}</td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center">
                                            @if ($user->foto)
                                                <img src="{{ asset('storage/users/' . $user->foto) }}"
                                                    alt="{{ $user->name }}" class="rounded-circle"
                                                    style="width: 50px; height: 50px; object-fit: cover; object-position: top;">
                                            @else
                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&color=7F9CF5&background=EBF4FF&size=40"
                                                    alt="{{ $user->name }}"
                                                    class="rounded-circle {{ $user->email_verified_at ? '' : 'opacity-50' }}"
                                                    width="50" height="50">
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span
                                                class="fw-medium {{ $user->is_verified ? '' : 'text-muted' }}">{{ $user->name }}</span>
                                            <small
                                                class="text-muted">{{ $user->is_verified ? 'Terverifikasi' : 'Belum Verifikasi' }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <span
                                            class="{{ $user->is_verified ? 'text-primary' : 'text-muted' }}">{{ $user->email }}</span>
                                    </td>
                                    <td>
                                        <span class="fw-medium">{{ $user->unit ?? '-' }}</span>
                                    </td>
                                    <td>
                                        @if ($user->is_verified)
                                            <span class="badge bg-success px-3 py-2">
                                                <i class="fas fa-check-circle me-1"></i>Terverifikasi
                                            </span>
                                        @else
                                            <span class="badge bg-warning px-3 py-2">
                                                <i class="fas fa-clock me-1"></i>Belum Verifikasi
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span
                                                class="fw-medium {{ $user->email_verified_at ? '' : 'text-muted' }}">{{ $user->created_at->format('d M Y') }}</span>
                                            <small class="text-muted">{{ $user->created_at->format('H:i') }} WIB</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <button class="btn btn-info btn-sm" title="Lihat Detail"
                                                onclick="viewUser({{ $user->id }})">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            @if ($user->id != 1 && auth()->id() === 1)
                                                <button class="btn btn-warning btn-sm" title="Nonaktifkan"
                                                    onclick="deactivateUser({{ $user->id }})">
                                                    <i class="fas fa-user-slash"></i>
                                                </button>
                                            @endif
                                            @if (!$user->is_verified && auth()->id() === 1)
                                                <button class="btn btn-success btn-sm" title="Verifikasi User"
                                                    onclick="verifyUser({{ $user->id }})">
                                                    <i class="fas fa-user-check"></i>
                                                </button>
                                                <form action="{{ route('admin.user.destroy', $user->id) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        title="Hapus User"
                                                        onclick="return confirm('Yakin ingin menghapus user ini?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-users fa-3x mb-3 text-gray-300"></i>
                                            <h5>Belum ada user terdaftar</h5>
                                            <p>User yang mendaftar akan muncul di sini</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="text-muted">
                        Menampilkan {{ $users->count() }} user
                    </div>
                    @if ($users->count() > 10)
                        <nav aria-label="User pagination">
                            <ul class="pagination pagination-sm mb-0">
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1">Previous</a>
                                </li>
                                <li class="page-item active">
                                    <a class="page-link" href="#">1</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">2</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">3</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">Next</a>
                                </li>
                            </ul>
                        </nav>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Custom CSS for this page -->
    <style>
        .border-left-primary {
            border-left: 0.25rem solid #4e73df !important;
        }

        .border-left-success {
            border-left: 0.25rem solid #1cc88a !important;
        }

        .border-left-warning {
            border-left: 0.25rem solid #f6c23e !important;
        }

        .border-left-info {
            border-left: 0.25rem solid #36b9cc !important;
        }

        .table th {
            background-color: #ffffff;
            border-color: #e3e6f0;
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table td {
            border-color: #e3e6f0;
            vertical-align: middle;
        }

        .btn-sm {
            padding: 0.375rem 0.5rem;
            font-size: 0.775rem;
        }

        .badge {
            font-size: 0.75rem;
            font-weight: 500;
        }

        .card {
            border: none;
            border-radius: 0.5rem;
        }

        .card-header {
            background-color: #ffffff;
            border-bottom: 1px solid #e3e6f0;
        }

        .table-hover tbody tr:hover {
            background-color: #f8f9fc;
        }

        .opacity-50 {
            opacity: 0.5;
        }

        .btn-danger:hover {
            background-color: #dc3545;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(220, 53, 69, 0.3);
        }

        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
    </style>

    <!-- JavaScript for table interactions -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Search functionality
            const searchInput = document.getElementById('searchUser');
            const filterStatus = document.getElementById('filterStatus');
            const table = document.getElementById('userTable');

            function filterTable() {
                const searchTerm = searchInput.value.toLowerCase();
                const statusFilter = filterStatus.value;
                const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

                for (let i = 0; i < rows.length; i++) {
                    const row = rows[i];

                    // Skip empty state row
                    if (row.cells.length === 1) continue;

                    const name = row.cells[2].textContent.toLowerCase();
                    const email = row.cells[3].textContent.toLowerCase();
                    const statusBadge = row.cells[4].querySelector('.badge');

                    if (!statusBadge) continue;

                    const statusText = statusBadge.textContent.toLowerCase();
                    let status = '';
                    if (statusText.includes('terverifikasi') && !statusText.includes('belum terverifikasi')) {
                        status = 'active';
                    } else {
                        status = 'inactive';
                    }

                    const matchesSearch = name.includes(searchTerm) || email.includes(searchTerm);
                    const matchesStatus = statusFilter === '' || status === statusFilter;

                    row.style.display = matchesSearch && matchesStatus ? '' : 'none';
                }
            }

            searchInput.addEventListener('input', filterTable);
            filterStatus.addEventListener('change', filterTable);
        });

        // User management functions
        function viewUser(userId) {
            window.location.href = `/admin/users/${userId}`;
        }

        function deactivateUser(userId) {
            if (confirm('Apakah Anda yakin ingin menonaktifkan user ini?')) {
                fetch(`/admin/users/${userId}/deactivate`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showToast(data.message, 'success');
                            setTimeout(() => location.reload(), 1500);
                        } else {
                            showToast(data.message, 'error');
                        }
                    })
                    .catch(error => {
                        showToast('Terjadi kesalahan', 'error');
                        console.error('Error:', error);
                    });
            }
        }

        function activateUser(userId) {
            if (confirm('Apakah Anda yakin ingin mengaktifkan user ini?')) {
                fetch(`/admin/users/${userId}/activate`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showToast(data.message, 'success');
                            setTimeout(() => location.reload(), 1500);
                        } else {
                            showToast(data.message, 'error');
                        }
                    })
                    .catch(error => {
                        showToast('Terjadi kesalahan', 'error');
                        console.error('Error:', error);
                    });
            }
        }

        function verifyUser(userId) {
            if (confirm('Verifikasi user ini?')) {
                fetch(`/admin/users/${userId}/verify`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showToast(data.message, 'success');
                            setTimeout(() => location.reload(), 1500);
                        } else {
                            showToast(data.message, 'error');
                        }
                    })
                    .catch(error => {
                        showToast('Terjadi kesalahan', 'error');
                        console.error('Error:', error);
                    });
            }
        }

        // Toast notification function
        function showToast(message, type) {
            const toastHtml = `
                <div class="toast align-items-center text-white bg-${type === 'success' ? 'success' : 'danger'} border-0" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            ${message}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            `;

            // Add toast container if it doesn't exist
            if (!document.getElementById('toast-container')) {
                document.body.insertAdjacentHTML('beforeend',
                    '<div id="toast-container" style="position: fixed; top: 20px; right: 20px; z-index: 9999;"></div>');
            }

            const toastContainer = document.getElementById('toast-container');
            toastContainer.insertAdjacentHTML('beforeend', toastHtml);

            // Initialize and show toast
            const toastElement = toastContainer.lastElementChild;
            const toast = new bootstrap.Toast(toastElement);
            toast.show();

            // Remove toast element after it's hidden
            toastElement.addEventListener('hidden.bs.toast', () => {
                toastElement.remove();
            });
        }
        // Download Report Function
        function downloadReport() {
            const loadingBtn = event.target;
            const originalContent = loadingBtn.innerHTML;

            // Show loading state
            loadingBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Generating...';
            loadingBtn.disabled = true;

            // Create form to download PDF
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/admin/users/report';
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
