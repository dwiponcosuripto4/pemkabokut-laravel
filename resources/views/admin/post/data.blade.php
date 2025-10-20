@extends('admin.layouts.navigation')

@section('title', 'Data Posts')

@section('content')
    <style>
        #postsTable th:nth-child(5),
        #postsTable td:nth-child(5) {
            width: 140px;
            max-width: 140px;
            white-space: nowrap;
        }

        /* Custom styles for statistics cards */
        .stat-icon {
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }
    </style>
    <!-- Blue Background Section -->
    <div
        style="background: linear-gradient(rgba(7, 63, 151, 0.8), rgba(7, 63, 151, 0.8)), url('{{ asset('images/Perjaya.jpg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat; position: relative; margin: -21px -23px 0 -23px; padding: 20px 20px 120px 20px;">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center" style="margin-top: 20px;">
                        <div>
                            <h1 class="h3 mb-1 text-white">Post Management</h1>
                            <p class="text-white-50 mb-0">Kelola semua artikel dan berita yang dipublikasikan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid px-4" style="margin-top: -100px; position: relative; z-index: 10;">


        <!-- Statistics Cards -->
        <div class="row mb-4">
            <!-- Total Posts Card -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-0 shadow h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="stat-icon bg-primary text-white rounded me-3">
                            <i class="fas fa-newspaper"></i>
                        </div>
                        <div>
                            <div class="text-muted small">Total Posts</div>
                            <div class="h4 mb-0 font-weight-bold">{{ $posts->count() }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Published Card -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-0 shadow h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="stat-icon bg-success text-white rounded me-3">
                            <i class="fas fa-paper-plane"></i>
                        </div>
                        <div>
                            <div class="text-muted small">Published</div>
                            <div class="h4 mb-0 font-weight-bold">{{ $posts->where('draft', 0)->count() }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Draft Card -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-0 shadow h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="stat-icon bg-warning text-white rounded me-3">
                            <i class="fas fa-pencil-alt"></i>
                        </div>
                        <div>
                            <div class="text-muted small">Draft</div>
                            <div class="h4 mb-0 font-weight-bold">{{ $posts->where('draft', 1)->count() }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- With Thumbnail Card -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-0 shadow h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="stat-icon bg-info text-white rounded me-3">
                            <i class="fas fa-images"></i>
                        </div>
                        <div>
                            <div class="text-muted small">With Thumbnail</div>
                            <div class="h4 mb-0 font-weight-bold">{{ $posts->whereNotNull('image')->count() }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- With Category Card -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-0 shadow h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="stat-icon bg-secondary text-white rounded me-3">
                            <i class="fas fa-tags"></i>
                        </div>
                        <div>
                            <div class="text-muted small">With Category</div>
                            <div class="h4 mb-0 font-weight-bold">{{ $posts->whereNotNull('category_id')->count() }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- With Headline Card -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-0 shadow h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="stat-icon bg-danger text-white rounded me-3">
                            <i class="fas fa-star"></i>
                        </div>
                        <div>
                            <div class="text-muted small">With Headline</div>
                            <div class="h4 mb-0 font-weight-bold">{{ $posts->whereNotNull('headline_id')->count() }}</div>
                        </div>
                    </div>
                </div>
            </div>


        </div>

        <!-- Active Filters Info -->
        @if (($category_filter && $category_filter !== 'all') || ($headline_filter && $headline_filter !== 'all'))
            <div class="row mb-3">
                <div class="col-12">
                    <div class="alert alert-info d-flex align-items-center" role="alert">
                        <i class="fas fa-filter me-2"></i>
                        <div>
                            <strong>Active Filters:</strong>
                            @if ($category_filter && $category_filter !== 'all')
                                <span class="badge bg-primary ms-2">
                                    Category:
                                    @if ($category_filter === 'no_category')
                                        No Category
                                    @else
                                        {{ $categories->where('id', $category_filter)->first()->title ?? 'Unknown' }}
                                    @endif
                                </span>
                            @endif
                            @if ($headline_filter && $headline_filter !== 'all')
                                <span class="badge bg-success ms-2">
                                    Headline:
                                    @if ($headline_filter === 'no_headline')
                                        No Headline
                                    @else
                                        {{ $headlines->where('id', $headline_filter)->first()->title ?? 'Unknown' }}
                                    @endif
                                </span>
                            @endif
                            <a href="{{ url('/admin/post/data?sort_order=' . $sort_order) }}"
                                class="btn btn-sm btn-outline-secondary ms-3">
                                <i class="fas fa-times me-1"></i>Clear All Filters
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Posts Table -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Posts Data</h6>
                <div class="d-flex gap-2 align-items-center">
                    <!-- Search Input -->
                    <div class="input-group" style="width: 300px;">
                        <input type="text" class="form-control form-control-sm" placeholder="Search posts..."
                            id="searchPost">
                        <button class="btn btn-outline-secondary btn-sm" type="button">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>

                    <!-- Filter Form -->
                    <form method="GET" action="{{ url('/admin/post/data') }}" class="d-flex gap-2 align-items-center"
                        id="filterForm">
                        <!-- Preserve sort order -->
                        <input type="hidden" name="sort_order" value="{{ $sort_order }}">

                        <!-- Category Filter -->
                        <select name="category_filter" class="form-select form-select-sm" style="width: 150px;"
                            onchange="document.getElementById('filterForm').submit();">
                            <option value="all" {{ ($category_filter ?? 'all') === 'all' ? 'selected' : '' }}>All
                                Categories</option>
                            <option value="no_category" {{ ($category_filter ?? '') === 'no_category' ? 'selected' : '' }}>
                                No Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ ($category_filter ?? '') == $category->id ? 'selected' : '' }}>
                                    {{ $category->title }}
                                </option>
                            @endforeach
                        </select>

                        <!-- Headline Filter -->
                        <select name="headline_filter" class="form-select form-select-sm" style="width: 150px;"
                            onchange="document.getElementById('filterForm').submit();">
                            <option value="all" {{ ($headline_filter ?? 'all') === 'all' ? 'selected' : '' }}>All
                                Headlines</option>
                            <option value="no_headline" {{ ($headline_filter ?? '') === 'no_headline' ? 'selected' : '' }}>
                                No Headline</option>
                            @foreach ($headlines as $headline)
                                <option value="{{ $headline->id }}"
                                    {{ ($headline_filter ?? '') == $headline->id ? 'selected' : '' }}>
                                    {{ $headline->title }}
                                </option>
                            @endforeach
                        </select>

                        <!-- Clear Filters Button -->
                        @if (($category_filter && $category_filter !== 'all') || ($headline_filter && $headline_filter !== 'all'))
                            <a href="{{ url('/admin/post/data?sort_order=' . $sort_order) }}"
                                class="btn btn-outline-warning btn-sm" title="Clear Filters">
                                <i class="fas fa-times"></i>
                            </a>
                        @endif
                    </form>

                    <!-- Sort Button -->
                    <a href="{{ url(
                        '/admin/post/data?sort_order=' .
                            ($sort_order == 'asc' ? 'desc' : 'asc') .
                            ($category_filter ? '&category_filter=' . $category_filter : '') .
                            ($headline_filter ? '&headline_filter=' . $headline_filter : ''),
                    ) }}"
                        class="btn btn-outline-secondary btn-sm" title="Sort Posts">
                        <i class="fas fa-sort"></i>
                    </a>

                    <!-- Add Post Button -->
                    <a href="/admin/post/create" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus me-2"></i>Add Post
                    </a>

                    <!-- Report Button -->
                    <button class="btn btn-danger btn-sm" onclick="downloadPostReport()" title="Download Laporan PDF">
                        <i class="fas fa-file-pdf me-1"></i>Laporan
                    </button>
                </div>
            </div>
            <div class="card-body">
                {{-- Success Messages --}}
                @if (session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        <strong>Success!</strong> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="postsTable" width="100%" cellspacing="0">
                        <thead class="table-light">
                            <tr>
                                <th width="1%">ID</th>
                                <th width="17%">Image</th>
                                <th width="25%">Title</th>
                                <th width="10%">Author</th>
                                <th width="5%">Category</th>
                                <th width="10%">Headline</th>
                                <th width="5%">Published</th>
                                <th width="10%">Updated At</th>
                                <th width="5%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($posts as $post)
                                <tr>
                                    <td class="text-center">{{ $post->id }}</td>
                                    <td class="text-center">
                                        @php
                                            // Handle different image storage formats
                                            $imageUrl = null;
                                            $debugInfo = '';

                                            if ($post->image) {
                                                $debugInfo = 'Raw: ' . substr($post->image, 0, 50) . '...';

                                                // If image is stored as JSON array
                                                if (
                                                    is_string($post->image) &&
                                                    (str_starts_with($post->image, '[') ||
                                                        str_starts_with($post->image, '{"'))
                                                ) {
                                                    $images = json_decode($post->image, true);
                                                    if (is_array($images) && count($images) > 0) {
                                                        $imageUrl = is_array($images[0])
                                                            ? $images[0]['path'] ?? ($images[0]['url'] ?? $images[0])
                                                            : $images[0];
                                                    }
                                                    $debugInfo = 'JSON decoded, first: ' . ($imageUrl ?? 'null');
                                                } else {
                                                    // If image is stored as single string
                                                    $imageUrl = $post->image;
                                                    $debugInfo = 'String: ' . $imageUrl;
                                                }
                                            }
                                        @endphp

                                        @if ($imageUrl)
                                            <div class="image-container">
                                                @php
                                                    // Clean the image URL
                                                    $imageUrl = trim($imageUrl, '"\'');

                                                    // Try different possible paths where images might be stored
                                                    $possiblePaths = [
                                                        'storage/uploads/' . $imageUrl,
                                                        'storage/' . $imageUrl,
                                                        'upload/' . $imageUrl,
                                                        'uploads/' . $imageUrl,
                                                        'public/upload/' . $imageUrl,
                                                        'img/' . $imageUrl,
                                                        'images/' . $imageUrl,
                                                        $imageUrl,
                                                    ];

                                                    $imageSrc = null;

                                                    // Check if it's already a full URL
if (str_starts_with($imageUrl, 'http')) {
    $imageSrc = $imageUrl;
} else {
    // Try each possible path
    foreach ($possiblePaths as $path) {
        if (file_exists(public_path($path))) {
            $imageSrc = asset($path);
            break;
        }
    }

    // If no file found, default to storage/uploads path
    if (!$imageSrc) {
        $imageSrc = asset('storage/uploads/' . $imageUrl);
                                                        }
                                                    }
                                                @endphp

                                                <img src="{{ $imageSrc }}" alt="{{ $post->title }}"
                                                    class="post-thumbnail rounded"
                                                    onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjYwIiBoZWlnaHQ9IjYwIiBmaWxsPSIjRjNGNEY2Ii8+CjxwYXRoIGQ9Ik0yMCAyMkg0MFYzOEgyMFYyMloiIGZpbGw9IiM5Q0EzQUYiLz4KPHBhdGggZD0iTTI1IDI3QzI2LjEwNDYgMjcgMjcgMjYuMTA0NiAyNyAyNUMyNyAyMy44OTU0IDI2LjEwNDYgMjMgMjUgMjNDMjMuODk1NCAyMyAyMyAyMy44OTU0IDIzIDI1QzIzIDI2LjEwNDYgMjMuODk1NCAyNyAyNSAyN1oiIGZpbGw9IiM2Qjc3ODUiLz4KPHBhdGggZD0iTTM3IDM1TDMzIDMxTDI5IDM1SDM3WiIgZmlsbD0iIzZCNzc4NSIvPgo8L3N2Zz4K'; this.onerror=null;"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#imageModal{{ $post->id }}"
                                                    title="Debug: {{ $debugInfo ?? 'No debug info' }}">
                                            </div>

                                            <!-- Image Modal -->
                                            <div class="modal fade" id="imageModal{{ $post->id }}" tabindex="-1">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">{{ $post->title }}</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body text-center">
                                                            <img src="{{ $imageSrc }}" class="img-fluid"
                                                                alt="{{ $post->title }}"
                                                                onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjYwIiBoZWlnaHQ9IjYwIiBmaWxsPSIjRjNGNEY2Ii8+CjxwYXRoIGQ9Ik0yMCAyMkg0MFYzOEgyMFYyMloiIGZpbGw9IiM5Q0EzQUYiLz4KPHBhdGggZD0iTTI1IDI3QzI2LjEwNDYgMjcgMjcgMjYuMTA0NiAyNyAyNUMyNyAyMy44OTU0IDI2LjEwNDYgMjMgMjUgMjNDMjMuODk1NCAyMyAyMyAyMy44OTU0IDIzIDI1QzIzIDI2LjEwNDYgMjMuODk1NCAyNyAyNSAyN1oiIGZpbGw9IiM2Qjc3ODUiLz4KPHBhdGggZD0iTTM3IDM1TDMzIDMxTDI5IDM1SDM3WiIgZmlsbD0iIzZCNzc4NSIvPgo8L3N2Zz4K'; this.onerror=null;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="no-image-placeholder">
                                                <i class="fas fa-image text-muted"></i>
                                                <small class="text-muted d-block">No Image</small>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="post-title-container">
                                            <span class="post-title">{{ $post->title }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="user-avatar me-2">
                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($post->user->name ?? 'Unknown') }}&color=7F9CF5&background=EBF4FF&size=32"
                                                    alt="User" class="rounded-circle" width="32" height="32">
                                            </div>
                                            <div>
                                                <div class="fw-medium">{{ $post->user->name ?? 'Unknown' }}</div>
                                                <small class="text-muted">ID: {{ $post->user_id ?? 'N/A' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if ($post->category)
                                            <span class="badge bg-info rounded-pill px-3 py-1">
                                                {{ $post->category->title }}
                                            </span>
                                        @else
                                            <span class="badge bg-secondary rounded-pill px-3 py-1">No Category</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($post->headline)
                                            <span class="badge bg-success rounded-pill px-3 py-1">
                                                {{ Str::limit($post->headline->title, 20) }}
                                            </span>
                                        @else
                                            <span class="badge bg-secondary rounded-pill px-3 py-1">No Headline</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($post->published_at)
                                            <span class="text-sm">
                                                {{ $post->published_at->format('d/m/Y') }}
                                            </span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($post->updated_at)
                                            <span class="text-sm">{{ $post->updated_at->format('d/m/Y H:i') }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column align-items-center gap-1">
                                            <div class="d-flex justify-content-center gap-1 mb-1">
                                                <a href="/post/show/{{ $post->id }}" class="btn btn-success btn-sm"
                                                    title="View Post" target="_blank">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="/admin/post/edit/{{ $post->id }}"
                                                    class="btn btn-primary btn-sm" title="Edit Post">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-danger btn-sm" title="Delete Post"
                                                    onclick="deletePost({{ $post->id }}, '{{ addslashes($post->title) }}')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                            <form action="{{ route('admin.post.toggleDraft', $post->id) }}"
                                                method="POST" class="w-100 text-center">
                                                @csrf
                                                @method('PATCH')
                                                @if ($post->draft)
                                                    <button type="submit" class="btn btn-warning btn-sm w-100 mt-1"
                                                        title="Publish Post">
                                                        <i class="fas fa-upload"></i> Publish
                                                    </button>
                                                @else
                                                    <button type="submit" class="btn btn-secondary btn-sm w-100 mt-1"
                                                        title="Set as Draft">
                                                        <i class="fas fa-file-alt"></i> Draft
                                                    </button>
                                                @endif
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-newspaper fa-3x mb-3 text-gray-300"></i>
                                            <h5>No posts available</h5>
                                            <p>Create your first post to get started</p>
                                            <a href="/admin/post/create" class="btn btn-primary">
                                                <i class="fas fa-plus me-2"></i>Create Post
                                            </a>
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
                        Showing {{ $posts->count() }} posts
                    </div>
                    @if ($posts->count() > 10)
                        <nav aria-label="Posts pagination">
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

    <!-- Custom CSS for Posts Management -->
    <style>
        .border-left-primary {
            border-left: 0.25rem solid #4e73df !important;
        }

        .border-left-success {
            border-left: 0.25rem solid #1cc88a !important;
        }

        .border-left-info {
            border-left: 0.25rem solid #36b9cc !important;
        }

        .border-left-warning {
            border-left: 0.25rem solid #f6c23e !important;
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

        .post-thumbnail {
            width: 180px;
            height: 135px;
            object-fit: cover;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid #e3e6f0;
            display: block;
            margin: 0 auto;
        }

        .post-thumbnail:hover {
            transform: scale(1.05);
            border-color: #4e73df;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        .image-container {
            position: relative;
            display: inline-block;
            width: 180px;
            height: 135px;
        }

        .no-image-placeholder {
            width: 80px;
            height: 50px;
            background-color: #f8f9fc;
            border: 2px dashed #e3e6f0;
            border-radius: 8px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
        }

        .no-image-placeholder i {
            font-size: 16px;
            margin-bottom: 2px;
        }

        .no-image-placeholder small {
            font-size: 10px;
            line-height: 1;
        }

        .post-title {
            font-size: 0.9rem;
            line-height: 1.3;
            color: #333;
        }

        .post-title-container {
            max-width: 250px;
        }

        .user-avatar img {
            border: 2px solid #e3e6f0;
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

        .btn-group .btn {
            margin-right: 2px;
        }

        .btn-group .btn:last-child {
            margin-right: 0;
        }
    </style>

    <!-- JavaScript for Posts Management -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Search functionality
            const searchInput = document.getElementById('searchPost');
            const table = document.getElementById('postsTable');
            const filterForm = document.getElementById('filterForm');

            function filterTable() {
                const searchTerm = searchInput.value.toLowerCase();
                const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
                let visibleCount = 0;

                for (let i = 0; i < rows.length; i++) {
                    const row = rows[i];

                    // Skip empty state row
                    if (row.cells.length === 1) continue;

                    const title = row.cells[2].textContent.toLowerCase();
                    const author = row.cells[3].textContent.toLowerCase();
                    const category = row.cells[4].textContent.toLowerCase();

                    const matchesSearch = title.includes(searchTerm) ||
                        author.includes(searchTerm) ||
                        category.includes(searchTerm);

                    if (matchesSearch) {
                        row.style.display = '';
                        visibleCount++;
                    } else {
                        row.style.display = 'none';
                    }
                }

                // Update results counter
                updateResultsCounter(visibleCount);
            }

            function updateResultsCounter(count) {
                const existingCounter = document.getElementById('searchResultsCounter');
                if (existingCounter) {
                    existingCounter.remove();
                }

                if (searchInput.value.length > 0) {
                    const counter = document.createElement('small');
                    counter.id = 'searchResultsCounter';
                    counter.className = 'text-muted ms-2';
                    counter.textContent = `(${count} result${count !== 1 ? 's' : ''} found)`;
                    searchInput.parentNode.parentNode.appendChild(counter);
                }
            }

            // Add loading state to filter selects
            function addLoadingState(select) {
                select.style.opacity = '0.6';
                select.disabled = true;
            }

            function removeLoadingState(select) {
                select.style.opacity = '1';
                select.disabled = false;
            }

            // Enhanced filter change handling
            const categorySelect = document.querySelector('select[name="category_filter"]');
            const headlineSelect = document.querySelector('select[name="headline_filter"]');

            if (categorySelect) {
                categorySelect.addEventListener('change', function() {
                    addLoadingState(this);
                    addLoadingState(headlineSelect);
                });
            }

            if (headlineSelect) {
                headlineSelect.addEventListener('change', function() {
                    addLoadingState(this);
                    addLoadingState(categorySelect);
                });
            }

            searchInput.addEventListener('input', filterTable);

            // Clear search when filters change
            if (filterForm) {
                filterForm.addEventListener('submit', function() {
                    searchInput.value = '';
                });
            }
        });

        // Delete post function
        function deletePost(postId, postTitle) {
            if (confirm(`Are you sure you want to delete "${postTitle}"?`)) {
                // Create form and submit
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/post/delete/${postId}`;

                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                const methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                methodField.value = 'DELETE';

                form.appendChild(csrfToken);
                form.appendChild(methodField);
                document.body.appendChild(form);
                form.submit();
            }
        }

        // Toast notification for better UX
        function showToast(message, type) {
            const toastHtml = `
                <div class="toast align-items-center text-white bg-${type === 'success' ? 'success' : 'danger'} border-0" role="alert">
                    <div class="d-flex">
                        <div class="toast-body">${message}</div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                    </div>
                </div>
            `;

            if (!document.getElementById('toast-container')) {
                document.body.insertAdjacentHTML('beforeend',
                    '<div id="toast-container" style="position: fixed; top: 20px; right: 20px; z-index: 9999;"></div>');
            }

            const toastContainer = document.getElementById('toast-container');
            toastContainer.insertAdjacentHTML('beforeend', toastHtml);

            const toastElement = toastContainer.lastElementChild;
            const toast = new bootstrap.Toast(toastElement);
            toast.show();

            toastElement.addEventListener('hidden.bs.toast', () => {
                toastElement.remove();
            });
        }

        // Download Post Report Function
        function downloadPostReport() {
            const loadingBtn = event.target;
            const originalContent = loadingBtn.innerHTML;

            // Show loading state
            loadingBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Generating...';
            loadingBtn.disabled = true;

            // Create form to download PDF
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/admin/posts/report';
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
