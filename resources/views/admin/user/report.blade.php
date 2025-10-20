<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan User {{ $current_month }}</title>
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
            gap: 20px;
            margin-bottom: 20px;
        }

        .stat-box {
            flex: 1;
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
        }

        .table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .unit-stats {
            margin-bottom: 20px;
        }

        .unit-item {
            display: flex;
            justify-content: space-between;
            padding: 5px 0;
            border-bottom: 1px dotted #ccc;
        }

        .unit-name {
            font-weight: 500;
        }

        .unit-count {
            color: #073f97;
            font-weight: bold;
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
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header">
        <h1>LAPORAN PENGGUNA SISTEM</h1>
        <p>Dinas Komunikasi dan Informatika</p>
        <p>Periode: {{ $current_month }}</p>
        <p>Tanggal Laporan: {{ $report_date }}</p>
    </div>

    <!-- Summary Statistics -->
    <div class="info-section">
        <h3>RINGKASAN STATISTIK</h3>
        <div class="stats-grid">
            <div class="stat-box">
                <div class="stat-number">{{ $total_users }}</div>
                <div class="stat-label">Total User Terdaftar</div>
            </div>
            <div class="stat-box">
                <div class="stat-number">{{ $users_this_month->count() }}</div>
                <div class="stat-label">User Baru Bulan Ini</div>
            </div>
            <div class="stat-box">
                <div class="stat-number">{{ $users_this_month->where('is_verified', true)->count() }}</div>
                <div class="stat-label">User Terverifikasi</div>
            </div>
        </div>
    </div>

    <!-- Users Per Unit -->
    <div class="info-section">
        <h3>DISTRIBUSI USER PER UNIT</h3>
        <div class="unit-stats">
            @foreach ($users_per_unit as $unit => $count)
                <div class="unit-item">
                    <span class="unit-name">{{ $unit ?: 'Belum Ditentukan' }}</span>
                    <span class="unit-count">{{ $count }} orang</span>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Detailed User Table -->
    <div class="info-section">
        <h3>DETAIL USER BARU BULAN {{ strtoupper($current_month) }}</h3>

        @if ($user_activities->count() > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 5%">No</th>
                        <th style="width: 20%">Nama</th>
                        <th style="width: 25%">Email</th>
                        <th style="width: 15%">Unit</th>
                        <th style="width: 10%">Tgl Bergabung</th>
                        <th style="width: 7%">Post</th>
                        <th style="width: 7%">Doc</th>
                        <th style="width: 7%">Portal</th>
                        <th style="width: 7%">UMKM</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($user_activities as $index => $activity)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $activity['user']->name }}</td>
                            <td>{{ $activity['user']->email }}</td>
                            <td>{{ $activity['user']->unit ?: '-' }}</td>
                            <td>{{ $activity['user']->created_at->format('d/m/Y') }}</td>
                            <td style="text-align: center;">{{ $activity['posts_count'] }}</td>
                            <td style="text-align: center;">{{ $activity['documents_count'] }}</td>
                            <td style="text-align: center;">{{ $activity['portals_count'] }}</td>
                            <td style="text-align: center;">{{ $activity['umkm_approved_count'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Summary Table -->
            <div style="margin-top: 20px;">
                <strong>RINGKASAN AKTIVITAS:</strong>
                <table class="table" style="margin-top: 10px;">
                    <tr>
                        <td><strong>Total Post Dibuat:</strong></td>
                        <td><strong>{{ $user_activities->sum('posts_count') }}</strong></td>
                    </tr>
                    <tr>
                        <td><strong>Total Document Dibuat:</strong></td>
                        <td><strong>{{ $user_activities->sum('documents_count') }}</strong></td>
                    </tr>
                    <tr>
                        <td><strong>Total Portal Dibuat:</strong></td>
                        <td><strong>{{ $user_activities->sum('portals_count') }}</strong></td>
                    </tr>
                    <tr>
                        <td><strong>Total UMKM Disetujui:</strong></td>
                        <td><strong>{{ $user_activities->sum('umkm_approved_count') }}</strong></td>
                    </tr>
                </table>
            </div>
        @else
            <p style="text-align: center; color: #666; padding: 20px;">
                Tidak ada user baru yang terdaftar pada bulan ini.
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
