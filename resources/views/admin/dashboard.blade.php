@extends('admin.layouts.navigation')

@section('title', 'Dashboard - Sistem Admin Portal Informasi OKU Timur')

@section('content')
    <!-- Blue Background Section -->
    <div
        style="background: linear-gradient(rgba(7, 63, 151, 0.8), rgba(7, 63, 151, 0.8)), url('{{ asset('images/Perjaya.jpg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat; position: relative; margin: -21px -23px 0 -23px; padding: 20px 20px 210px 20px;">
        <div class="container-fluid">
            <!-- Page Header -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="h3 mb-1 text-white">Dashboard</h1>
                            <p class="text-white-50 mb-0" id="welcomeText">Selamat datang, Admin - <span
                                    id="currentDateTime"></span></p>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <div class="dropdown">
                                <button class="btn btn-light dropdown-toggle" type="button" id="createNewDropdown"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-plus me-1"></i>Create New
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="createNewDropdown">
                                    <li><a class="dropdown-item" href="{{ route('post.create') }}"><i
                                                class="fas fa-file-alt me-2"></i>Post</a></li>
                                    <li><a class="dropdown-item" href="{{ route('document.create') }}"><i
                                                class="fas fa-file-pdf me-2"></i>Dokumen</a></li>
                                    <li><a class="dropdown-item" href="{{ route('icon.create') }}"><i
                                                class="fas fa-globe me-2"></i>Portal</a></li>
                                </ul>
                            </div>
                            <a href="/" class="btn btn-primary" target="_blank" rel="noopener">
                                <i class="fas fa-home me-1"></i>Main Dashboard
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid" style="margin-top: -210px; position: relative; z-index: 10;">

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="stat-icon bg-primary text-white rounded me-3">
                            <i class="fas fa-list"></i>
                        </div>
                        <div>
                            <div class="text-muted small">Categories</div>
                            <div class="h4 mb-0 font-weight-bold">
                                {{ isset($statistics['categories']) ? number_format($statistics['categories']) : '0' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="stat-icon bg-info text-white rounded me-3">
                            <i class="fas fa-newspaper"></i>
                        </div>
                        <div>
                            <div class="text-muted small">Headlines</div>
                            <div class="h4 mb-0 font-weight-bold">
                                {{ isset($statistics['headlines']) ? number_format($statistics['headlines']) : '0' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="stat-icon bg-success text-white rounded me-3">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <div>
                            <div class="text-muted small">Posts</div>
                            <div class="h4 mb-0 font-weight-bold">
                                {{ isset($statistics['posts']) ? number_format($statistics['posts']) : '0' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="stat-icon bg-warning text-white rounded me-3">
                            <i class="fas fa-database"></i>
                        </div>
                        <div>
                            <div class="text-muted small">Data</div>
                            <div class="h4 mb-0 font-weight-bold">
                                {{ isset($statistics['data']) ? number_format($statistics['data']) : '0' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Second Row of Statistics Cards -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="stat-icon bg-danger text-white rounded me-3">
                            <i class="fas fa-file-pdf"></i>
                        </div>
                        <div>
                            <div class="text-muted small">Documents</div>
                            <div class="h4 mb-0 font-weight-bold">
                                {{ isset($statistics['documents']) ? number_format($statistics['documents']) : '0' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="stat-icon bg-dark text-white rounded me-3">
                            <i class="fas fa-folder"></i>
                        </div>
                        <div>
                            <div class="text-muted small">Files</div>
                            <div class="h4 mb-0 font-weight-bold">
                                {{ isset($statistics['files']) ? number_format($statistics['files']) : '0' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="stat-icon bg-purple text-white rounded me-3"
                            style="background-color: #6f42c1 !important;">
                            <i class="fas fa-store"></i>
                        </div>
                        <div>
                            <div class="text-muted small">UMKM</div>
                            <div class="h4 mb-0 font-weight-bold">
                                {{ isset($statistics['businesses']) ? number_format($statistics['businesses']) : '0' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="stat-icon bg-secondary text-white rounded me-3">
                            <i class="fas fa-icons"></i>
                        </div>
                        <div>
                            <div class="text-muted small">Portal</div>
                            <div class="h4 mb-0 font-weight-bold">
                                {{ isset($statistics['icons']) ? number_format($statistics['icons']) : '0' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Calendar Row -->
        <div class="row">
            <!-- Calendar Card -->
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary me-3">Kalender</h6>
                            <h5 class="m-0 text-gray-800" id="calendarTitle">Agustus 2025</h5>
                        </div>
                        <div class="d-flex align-items-center">
                            <button id="prevButton" class="btn btn-sm btn-outline-primary me-2">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <button id="todayButton" class="btn btn-sm btn-primary me-2">Today</button>
                            <button id="nextButton" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Log Aktivitas -->
        <a id="log-aktivitas"></a>
        <div class="row">
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Log Aktivitas</h6>
                    </div>
                    <div class="card-body">
                        <!-- Search Form -->
                        <form method="GET" action="#log-aktivitas" class="mb-3">
                            <div class="input-group">
                                <input type="text" name="search_log" class="form-control"
                                    placeholder="Cari aktivitas, user, atau jenis..."
                                    value="{{ request('search_log') }}">
                                <button class="btn btn-outline-primary" type="submit"><i class="fas fa-search"></i>
                                    Cari</button>
                            </div>
                        </form>
                        <div class="table-responsive" style="max-height:400px; overflow-y:auto; overflow-x:auto;">
                            <table class="table table-bordered mb-0">
                                <thead class="text-muted small">
                                    <tr>
                                        <th>Tanggal & Waktu</th>
                                        <th>Aktivitas</th>
                                        <th>User</th>
                                        <th>Jenis Aktivitas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $perPage = 10;
                                        $page = request()->query('page', 1);
                                        $search = request()->query('search_log');
                                        $logsQuery = App\Models\LogAktivitas::with('user')->orderByDesc('datetime');
                                        if ($search) {
                                            $logsQuery->where(function ($q) use ($search) {
                                                $q->where('model', 'like', "%$search%")
                                                    ->orWhere('title', 'like', "%$search%")
                                                    ->orWhere('type', 'like', "%$search%")
                                                    ->orWhereHas('user', function ($uq) use ($search) {
                                                        $uq->where('name', 'like', "%$search%");
                                                    });
                                            });
                                        }
                                        $logs = $logsQuery->get();
                                        $total = $logs->count();
                                        $logsPage = $logs->slice(($page - 1) * $perPage, $perPage);
                                    @endphp
                                    @foreach ($logsPage as $log)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($log->datetime)->format('d M Y, H:i') }}</td>
                                            <td>{{ $log->model }}: {{ $log->title }}</td>
                                            <td>{{ $log->user ? $log->user->name : '-' }}</td>
                                            <td>
                                                @if ($log->type == 'Create')
                                                    <span class="badge bg-success">Create</span>
                                                @elseif ($log->type == 'Update')
                                                    <span class="badge bg-warning text-dark">Update</span>
                                                @elseif ($log->type == 'Delete')
                                                    <span class="badge bg-danger">Delete</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-end mt-3">
                            @php
                                $lastPage = ceil($total / $perPage);
                            @endphp
                            @if ($lastPage > 1)
                                <nav>
                                    <ul class="pagination pagination-sm mb-0">
                                        <li class="page-item {{ $page == 1 ? 'disabled' : '' }}">
                                            <a class="page-link"
                                                href="?page={{ $page - 1 }}@if (request('search_log')) &search_log={{ request('search_log') }} @endif#log-aktivitas">&laquo;</a>
                                        </li>
                                        @for ($i = 1; $i <= $lastPage; $i++)
                                            <li class="page-item {{ $page == $i ? 'active' : '' }}">
                                                <a class="page-link"
                                                    href="?page={{ $i }}@if (request('search_log')) &search_log={{ request('search_log') }} @endif#log-aktivitas">{{ $i }}</a>
                                            </li>
                                        @endfor
                                        <li class="page-item {{ $page == $lastPage ? 'disabled' : '' }}">
                                            <a class="page-link"
                                                href="?page={{ $page + 1 }}@if (request('search_log')) &search_log={{ request('search_log') }} @endif#log-aktivitas">&raquo;</a>
                                        </li>
                                    </ul>
                                </nav>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>


    <style>
        /* Custom style for FullCalendar more popover */
        .fc-more-popover {
            max-height: 300px !important;
            overflow-y: auto !important;
            min-width: 250px !important;
            max-width: 350px !important;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15) !important;
            border-radius: 8px !important;
        }

        .fc-popover-body {
            padding-right: 8px !important;
        }

        /* Fix pagination width and prevent overflow */
        .pagination {
            max-width: 100%;
            overflow-x: auto;
            flex-wrap: wrap;
            gap: 2px;
        }

        .pagination li {
            flex: none;
        }

        /* Make sure pagination stays inside its container */
        .d-flex.justify-content-end {
            overflow-x: auto;
            max-width: 100%;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Function to update current date and time
        function updateDateTime() {
            const now = new Date();
            const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
            ];

            const dayName = days[now.getDay()];
            const day = now.getDate();
            const month = months[now.getMonth()];
            const year = now.getFullYear();
            const hours = now.getHours().toString().padStart(2, '0');
            const minutes = now.getMinutes().toString().padStart(2, '0');

            const dateTimeString = `${dayName}, ${day} ${month} ${year} - ${hours}:${minutes} WIB`;

            const dateTimeElement = document.getElementById('currentDateTime');
            if (dateTimeElement) {
                dateTimeElement.textContent = dateTimeString;
            }
        }

        // Initialize FullCalendar
        document.addEventListener('DOMContentLoaded', function() {
            // Update date time immediately and every minute
            updateDateTime();
            setInterval(updateDateTime, 60000); // Update every minute

            const calendarEl = document.getElementById('calendar');
            let calendar;

            if (calendarEl) {
                calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    locale: 'id',
                    headerToolbar: false, // We'll use custom buttons
                    height: 'auto',
                    aspectRatio: 2.5,
                    firstDay: 1, // Start week on Monday
                    dayMaxEvents: 3,
                    moreLinkClick: 'popover',
                    dayHeaderFormat: {
                        weekday: 'short'
                    },
                    titleFormat: {
                        year: 'numeric',
                        month: 'long'
                    },
                    datesSet: function(dateInfo) {
                        // Update the custom calendar title
                        updateCalendarTitle(dateInfo.view.title);
                    },
                    events: {
                        url: '{{ route('admin.api.calendar-events') }}',
                        method: 'GET',
                        failure: function() {
                            // Fallback to static events if AJAX fails
                            return @json($calendarEvents ?? []);
                        }
                    },
                    eventClick: function(info) {
                        const eventDetails = info.event.extendedProps.description ||
                            'Tidak ada deskripsi';
                        Swal.fire({
                            title: info.event.title,
                            html: `<strong>Tanggal:</strong> ${info.event.startStr}<br><strong>Deskripsi:</strong> ${eventDetails}`,
                            icon: 'info',
                            confirmButtonText: 'OK'
                        });
                    },
                    dayCellDidMount: function(info) {
                        // Highlight today
                        if (info.date.toDateString() === new Date().toDateString()) {
                            info.el.style.backgroundColor = '#f8f9fc';
                            info.el.style.border = '2px solid #4e73df';
                        }
                    },
                    eventDidMount: function(info) {
                        // Add hover effects
                        info.el.style.cursor = 'pointer';
                        info.el.addEventListener('mouseenter', function() {
                            this.style.opacity = '0.8';
                        });
                        info.el.addEventListener('mouseleave', function() {
                            this.style.opacity = '1';
                        });
                    }
                });

                calendar.render();

                // Function to update calendar title
                function updateCalendarTitle(title) {
                    document.getElementById('calendarTitle').textContent = title;
                }

                // Initialize title
                updateCalendarTitle(calendar.view.title);

                // Custom button handlers
                document.getElementById('prevButton').addEventListener('click', function() {
                    calendar.prev();
                });

                document.getElementById('todayButton').addEventListener('click', function() {
                    calendar.today();
                });

                document.getElementById('nextButton').addEventListener('click', function() {
                    calendar.next();
                });
            }
        });

        // CSRF Token for AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }); // Approve business function
        $(document).on('click', '.approve-btn', function() {
            const businessId = $(this).data('id');
            const button = $(this);

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
    </script>
@endsection
