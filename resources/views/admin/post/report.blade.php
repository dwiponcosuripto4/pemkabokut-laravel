<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Post {{ $current_month }}</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        .header {
            text-align: center;
            border-bottom: 3px solid #073f97;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .header h1 {
            color: #073f97;
            margin: 0;
            font-size: 20px;
            font-weight: bold;
        }

        .header p {
            margin: 5px 0;
            color: #666;
        }

        .info-section {
            margin-bottom: 25px;
        }

        .info-section h3 {
            color: #073f97;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
            margin-bottom: 15px;
            font-size: 14px;
        }

        .stats-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 20px;
        }

        .stat-box {
            flex: 1;
            min-width: 120px;
            padding: 10px;
            border: 1px solid #ddd;
            background-color: #f9f9f9;
            text-align: center;
        }

        .stat-number {
            font-size: 18px;
            font-weight: bold;
            color: #073f97;
        }

        .stat-label {
            font-size: 11px;
            color: #666;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 10px;
        }

        .table th {
            background-color: #073f97;
            color: white;
            padding: 8px 5px;
            text-align: left;
            border: 1px solid #ddd;
            font-weight: bold;
        }

        .table td {
            padding: 6px 5px;
            border: 1px solid #ddd;
            vertical-align: top;
            word-wrap: break-word;
        }

        .table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 11px;
        }

        .signature-area {
            margin-top: 50px;
            text-align: right;
        }

        .page-break {
            page-break-after: always;
        }

        .status-badge {
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
        }

        .published {
            background-color: #d4edda;
            color: #155724;
        }

        .draft {
            background-color: #fff3cd;
            color: #856404;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header">
        <h1>LAPORAN POST ARTIKEL</h1>
        <p>Dinas Komunikasi dan Informatika</p>
        <p>Periode: {{ $current_month }}</p>
        <p>Tanggal Laporan: {{ $report_date }}</p>
    </div>

    <!-- Summary Statistics -->
    <div class="info-section">
        <h3>RINGKASAN STATISTIK POST</h3>
        <div class="stats-grid">
            <div class="stat-box">
                <div class="stat-number">{{ $total_posts }}</div>
                <div class="stat-label">Total Post</div>
            </div>
            <div class="stat-box">
                <div class="stat-number">{{ $total_categories }}</div>
                <div class="stat-label">Total Category</div>
            </div>
            <div class="stat-box">
                <div class="stat-number">{{ $total_headlines }}</div>
                <div class="stat-label">Total Headline</div>
            </div>
            <div class="stat-box">
                <div class="stat-number">{{ $posts_with_category }}</div>
                <div class="stat-label">Post dengan Category</div>
            </div>
            <div class="stat-box">
                <div class="stat-number">{{ $posts_with_headline }}</div>
                <div class="stat-label">Post dengan Headline</div>
            </div>
            <div class="stat-box">
                <div class="stat-number">{{ $published_posts }}</div>
                <div class="stat-label">Post Published</div>
            </div>
            <div class="stat-box">
                <div class="stat-number">{{ $draft_posts }}</div>
                <div class="stat-label">Post Draft</div>
            </div>
        </div>
    </div>

    <!-- Detailed Posts Table -->
    <div class="info-section">
        <h3>DETAIL POST BULAN {{ strtoupper($current_month) }}</h3>

        @if ($posts_this_month->count() > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 5%">No</th>
                        <th style="width: 35%">Title</th>
                        <th style="width: 15%">Author</th>
                        <th style="width: 12%">Category</th>
                        <th style="width: 12%">Headline</th>
                        <th style="width: 10%">Tanggal Publish</th>
                        <th style="width: 11%">Tanggal Update</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($posts_this_month as $index => $post)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <strong>{{ $post->title }}</strong>
                                <br>
                                <span class="status-badge {{ $post->draft ? 'draft' : 'published' }}">
                                    {{ $post->draft ? 'Draft' : 'Published' }}
                                </span>
                            </td>
                            <td>{{ $post->user->name ?? 'N/A' }}</td>
                            <td>{{ $post->category->name ?? '-' }}</td>
                            <td>{{ $post->headline->name ?? '-' }}</td>
                            <td>{{ $post->published_at ? $post->published_at->format('d/m/Y') : '-' }}</td>
                            <td>{{ $post->updated_at->format('d/m/Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Summary Table -->
            <div style="margin-top: 20px;">
                <strong>RINGKASAN POST BULAN INI:</strong>
                <table class="table" style="margin-top: 10px;">
                    <tr>
                        <td><strong>Total Post Dibuat Bulan Ini:</strong></td>
                        <td><strong>{{ $posts_this_month->count() }}</strong></td>
                    </tr>
                    <tr>
                        <td><strong>Post Published Bulan Ini:</strong></td>
                        <td><strong>{{ $posts_this_month->where('draft', false)->count() }}</strong></td>
                    </tr>
                    <tr>
                        <td><strong>Post Draft Bulan Ini:</strong></td>
                        <td><strong>{{ $posts_this_month->where('draft', true)->count() }}</strong></td>
                    </tr>
                    <tr>
                        <td><strong>Post dengan Category:</strong></td>
                        <td><strong>{{ $posts_this_month->whereNotNull('category_id')->count() }}</strong></td>
                    </tr>
                    <tr>
                        <td><strong>Post dengan Headline:</strong></td>
                        <td><strong>{{ $posts_this_month->whereNotNull('headline_id')->count() }}</strong></td>
                    </tr>
                </table>
            </div>
        @else
            <p style="text-align: center; color: #666; padding: 20px;">
                Tidak ada post yang dibuat pada bulan ini.
            </p>
        @endif
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Laporan ini digenerate otomatis pada {{ now()->format('d F Y H:i:s') }} WIB</p>

        <div class="signature-area">
            <p>Mengetahui,</p>
            <br><br><br>
            <p><strong>Kepala Dinas Komunikasi dan Informatika</strong></p>
        </div>
    </div>
</body>

</html>
