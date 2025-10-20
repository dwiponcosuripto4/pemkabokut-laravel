@extends('admin.layouts.navigation')

@section('title', 'Data Files')

@section('content')
    <div class="card bg-white p-4 shadow rounded-4 border-0">
        <div class="d-flex justify-content-between mb-4">
            <div>
                <h4>Data Files</h4>
            </div>
        </div>

        {{-- Pesan Sukses di Simpan dan di Update --}}
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Informasi</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        {{-- Pesan Sukses di Simpan dan di Update --}}

        <form method="GET" action="{{ route('file.data') }}" class="mb-3 d-flex gap-2 align-items-center">
            <div class="position-relative" style="max-width: 200px;">
                <input type="text" name="search" id="searchInput" class="form-control" placeholder="Cari judul file..."
                    value="{{ request('search') }}">
                @if (request('search'))
                    <button type="button" onclick="document.getElementById('searchInput').value=''; this.form.submit();"
                        class="btn btn-sm btn-light position-absolute end-0 top-0" style="height:100%;"><span
                            aria-hidden="true">&times;</span></button>
                @endif
            </div>
            <select name="document_id" class="form-select" style="max-width: 200px;">
                <option value="">Semua Dokumen</option>
                @foreach ($documents as $document)
                    <option value="{{ $document->id }}" {{ request('document_id') == $document->id ? 'selected' : '' }}>
                        {{ $document->title }}</option>
                @endforeach
            </select>
            <!-- Tombol sort id -->
            @php
                // Default sort is asc, so toggle to desc if not set
                $currentSort = request('sort');
                $nextSort = $currentSort === 'id_desc' ? 'id_asc' : 'id_desc';
            @endphp
            <a href="?{{ http_build_query(array_merge(request()->except('sort'), ['sort' => $nextSort])) }}"
                class="btn btn-outline-secondary btn-sm d-flex align-items-center justify-content-center" title="Sort by ID"
                style="width: 32px; height: 32px; border-radius: 50%;">
                <i class="fas fa-sort text-primary"></i>
            </a>
            <button type="submit" class="btn btn-primary">Filter</button>
        </form>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Path</th>
                        <th>Date</th>
                        <th>Document</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($files as $file)
                        <tr>
                            <td>{{ $file->id }}</td>
                            <td>{{ $file->title ?? 'No Title' }}</td>
                            <td>{{ $file->file_path }}</td>
                            <td>{{ $file->file_date }}</td>
                            <td>{{ $file->document->title ?? 'No Document' }}</td>

                            <td>
                                <div class="d-flex gap-2">
                                    <a href="/file/show/{{ $file->id }}" class="btn btn-success">Show</a>
                                    <a href="{{ route('file.edit', $file->id) }}" class="btn btn-info">Edit</a>
                                    <form action="{{ route('file.destroy', $file->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this file?');"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
