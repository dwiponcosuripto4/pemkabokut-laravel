@extends('admin.layouts.navigation')

@section('title', 'Data Documents')

@section('content')
    <!-- Blue Background Section -->
    <div
        style="background: linear-gradient(rgba(7, 63, 151, 0.8), rgba(7, 63, 151, 0.8)), url('{{ asset('images/Perjaya.jpg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat; position: relative; margin: -21px -23px 0 -23px; padding: 20px 20px 120px 20px;">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center" style="margin-top: 20px;">
                        <div>
                            <h1 class="h3 mb-1 text-white">Documents Management</h1>
                            <p class="text-white-50 mb-0">Kelola semua dokumen yang ada di sistem</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid px-4" style="margin-top: -100px; position: relative; z-index: 10;">


        <!-- Documents Table -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Documents Data</h6>
                <div class="d-flex gap-2 align-items-center">
                    <!-- Search Input -->
                    <div class="input-group" style="width: 300px;">
                        <input type="text" class="form-control form-control-sm" placeholder="Cari dokumen..."
                            id="searchDocument">
                        <button class="btn btn-outline-secondary btn-sm" type="button">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                    <!-- Filter Data -->
                    <form method="GET" action="{{ url('/admin/document/data') }}" class="d-flex gap-2 align-items-center"
                        id="filterForm">
                        <select name="data_filter" class="form-select form-select-sm" style="width: 180px;">
                            <option value="all" {{ ($data_filter ?? 'all') === 'all' ? 'selected' : '' }}>Semua Data
                            </option>
                            <option value="no_data" {{ ($data_filter ?? '') === 'no_data' ? 'selected' : '' }}>Tanpa Data
                            </option>
                            @foreach ($datas as $data)
                                <option value="{{ $data->id }}"
                                    {{ ($data_filter ?? '') == $data->id ? 'selected' : '' }}>
                                    {{ $data->title }}</option>
                            @endforeach
                        </select>
                    </form>
                    <!-- Add Document Button -->
                    <a href="{{ route('document.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus me-2"></i>Add Document
                    </a>

                    <!-- Report Button -->
                    <button class="btn btn-danger btn-sm" onclick="downloadDocumentReport()" title="Download Laporan PDF">
                        <i class="fas fa-file-pdf me-1"></i>Laporan
                    </button>
                </div>
            </div>
            <div class="card-body">
                @if (session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        <strong>Success!</strong> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="documentsTable" width="100%" cellspacing="0">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">ID</th>
                                <th width="20%">Title</th>
                                <th width="20%">Data</th>
                                <th width="10%">File</th>
                                <th width="15%">Date</th>
                                <th width="15%">User ID</th>
                                <th width="15%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($documents as $document)
                                <tr>
                                    <td class="text-center fw-bold">{{ $document->id }}</td>
                                    <td>{{ $document->title }}</td>
                                    <td data-id="{{ $document->data->id ?? '' }}">
                                        {{ $document->data->title ?? 'No Data' }}</td>
                                    <td class="text-center">{{ $document->file->count() }}</td>
                                    <td>{{ $document->date ?? '-' }}</td>
                                    <td class="text-center">
                                        @if ($document->user)
                                            <div class="d-flex align-items-center justify-content-center">
                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($document->user->name ?? 'Unknown') }}&color=7F9CF5&background=EBF4FF&size=32"
                                                    alt="User" class="rounded-circle me-2" width="32"
                                                    height="32">
                                                <div>
                                                    <div class="fw-medium">{{ $document->user->name ?? 'Unknown' }}</div>
                                                    <small class="text-muted">ID: {{ $document->user_id ?? '-' }}</small>
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div style="display: flex; gap: 8px; align-items: center;">
                                            <a href="{{ route('document.show', $document->id) }}"
                                                class="btn btn-success btn-sm">Show</a>
                                            <a href="{{ route('document.edit', $document->id) }}"
                                                class="btn btn-info btn-sm">Edit</a>
                                            <form action="{{ route('document.destroy', $document->id) }}" method="POST"
                                                style="margin: 0;">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Are you sure you want to delete this document?')">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchDocument');
            const dataFilter = document.querySelector('select[name="data_filter"]');
            const table = document.getElementById('documentsTable');
            const rows = table.querySelectorAll('tbody tr');

            function filterTable() {
                const searchValue = searchInput.value.toLowerCase();
                const filterValue = dataFilter.value;

                rows.forEach(row => {
                    const title = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                    const dataCell = row.querySelector('td:nth-child(3)');
                    const dataTitle = dataCell.textContent;
                    const dataId = dataCell.getAttribute('data-id');

                    let show = true;

                    // Filter by search
                    if (searchValue && !title.includes(searchValue)) {
                        show = false;
                    }

                    // Filter by data
                    if (filterValue !== 'all') {
                        if (filterValue === 'no_data' && dataTitle !== 'No Data') {
                            show = false;
                        } else if (filterValue !== 'no_data' && dataId !== filterValue) {
                            show = false;
                        }
                    }

                    row.style.display = show ? '' : 'none';
                });
            }

            searchInput.addEventListener('input', filterTable);
            dataFilter.addEventListener('change', filterTable);
        });

        // Download Document Report Function
        function downloadDocumentReport() {
            const loadingBtn = event.target;
            const originalContent = loadingBtn.innerHTML;

            // Show loading state
            loadingBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Generating...';
            loadingBtn.disabled = true;

            // Create form to download PDF
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/admin/documents/report';
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
