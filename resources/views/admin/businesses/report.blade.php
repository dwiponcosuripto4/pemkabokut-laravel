<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan UMKM</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            font-size: 11px;
            line-height: 1.4;
            margin: 0;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #000;
            padding-bottom: 20px;
        }

        .header h1 {
            font-size: 18px;
            font-weight: bold;
            margin: 0;
            text-transform: uppercase;
        }

        .header h2 {
            font-size: 16px;
            margin: 5px 0;
            color: #333;
        }

        .header .subtitle {
            font-size: 12px;
            color: #666;
            margin-top: 10px;
        }

        .info-section {
            margin: 20px 0;
        }

        .info-row {
            display: table;
            width: 100%;
            margin-bottom: 8px;
        }

        .info-label {
            display: table-cell;
            width: 150px;
            font-weight: bold;
            padding-right: 10px;
        }

        .info-value {
            display: table-cell;
        }

        .statistics {
            background-color: #f8f9fa;
            padding: 15px;
            border: 1px solid #ddd;
            margin: 20px 0;
            border-radius: 4px;
        }

        .stats-grid {
            display: table;
            width: 100%;
        }

        .stats-row {
            display: table-row;
        }

        .stats-cell {
            display: table-cell;
            padding: 8px;
            text-align: center;
            border-right: 1px solid #ddd;
            width: 33.33%;
        }

        .stats-cell:last-child {
            border-right: none;
        }

        .stats-number {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
            display: block;
        }

        .stats-label {
            font-size: 11px;
            color: #666;
            text-transform: uppercase;
            margin-top: 5px;
        }

        .table-section {
            margin-top: 30px;
        }

        .section-title {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 15px;
            color: #333;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 9px;
        }

        th {
            background-color: #f1f1f1;
            font-weight: bold;
            text-align: center;
            padding: 6px 3px;
            border: 1px solid #ddd;
        }

        td {
            padding: 5px 3px;
            border: 1px solid #ddd;
            vertical-align: top;
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        .footer {
            margin-top: 40px;
            text-align: right;
            font-size: 11px;
        }

        .signature-section {
            margin-top: 30px;
            display: table;
            width: 100%;
        }

        .signature-left {
            display: table-cell;
            width: 50%;
            text-align: center;
            vertical-align: top;
        }

        .signature-right {
            display: table-cell;
            width: 50%;
            text-align: center;
            vertical-align: top;
        }

        .signature-box {
            margin-top: 80px;
            border-bottom: 1px solid #000;
            display: inline-block;
            min-width: 200px;
        }

        .break-word {
            word-wrap: break-word;
            word-break: break-all;
        }

        .status-badge {
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 8px;
            font-weight: bold;
        }

        .status-approved {
            background-color: #d4edda;
            color: #155724;
        }

        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-rejected {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Laporan Data UMKM</h1>
        <h2>Dinas Komunikasi dan Informatika</h2>
        <h2>Kabupaten Ogan Komering Ulu Timur</h2>
        <div class="subtitle">Periode: Bulan {{ date('F Y') }}</div>
    </div>

    <div class="info-section">
        <div class="info-row">
            <div class="info-label">Tanggal Laporan:</div>
            <div class="info-value">{{ date('d F Y, H:i') }} WIB</div>
        </div>
        <div class="info-row">
            <div class="info-label">Dicetak oleh:</div>
            <div class="info-value">{{ auth()->user()->name }} ({{ auth()->user()->email }})</div>
        </div>
    </div>

    <div class="statistics">
        <div class="section-title">Ringkasan Statistik</div>
        <div class="stats-grid">
            <div class="stats-row">
                <div class="stats-cell">
                    <span class="stats-number">{{ $totalBusinesses }}</span>
                    <div class="stats-label">Total UMKM</div>
                </div>
                <div class="stats-cell">
                    <span class="stats-number">{{ $totalApproved }}</span>
                    <div class="stats-label">UMKM Approved</div>
                </div>
                <div class="stats-cell">
                    <span class="stats-number">{{ $totalPending }}</span>
                    <div class="stats-label">UMKM Pending</div>
                </div>
            </div>
        </div>
    </div>

    <div class="table-section">
        <div class="section-title">Daftar UMKM Bulan {{ date('F Y') }}</div>
        <table>
            <thead>
                <tr>
                    <th style="width: 3%;">No</th>
                    <th style="width: 13%;">Nama</th>
                    <th style="width: 10%;">Pemilik</th>
                    <th style="width: 12%;">Email</th>
                    <th style="width: 8%;">No. Telepon</th>
                    <th style="width: 10%;">Jenis</th>
                    <th style="width: 8%;">Status</th>
                    <th style="width: 10%;">Approved By</th>
                    <th style="width: 13%;">Created At</th>
                    <th style="width: 13%;">Updated At</th>
                </tr>
            </thead>
            <tbody>
                @forelse($businesses as $business)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="break-word">{{ $business->nama }}</td>
                        <td>{{ $business->owner }}</td>
                        <td class="break-word">{{ $business->email }}</td>
                        <td class="text-center">{{ $business->nomor_telepon }}</td>
                        <td>{{ $business->jenis }}</td>
                        <td class="text-center">
                            @if ($business->status == 1)
                                <span class="status-badge status-approved">Approved</span>
                            @elseif($business->status == 0)
                                <span class="status-badge status-pending">Pending</span>
                            @else
                                <span class="status-badge status-rejected">Rejected</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if ($business->status == 1 && $business->user)
                                {{ $business->user->name }}
                            @elseif($business->status == 1)
                                Admin
                            @else
                                -
                            @endif
                        </td>
                        <td class="text-center">{{ date('d/m/Y H:i', strtotime($business->created_at)) }}</td>
                        <td class="text-center">{{ date('d/m/Y H:i', strtotime($business->updated_at)) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center">Tidak ada data UMKM pada bulan ini</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="signature-section">
        <div class="signature-left">
            <div>Mengetahui,</div>
            <div>Kepala Dinas</div>
            <div class="signature-box"></div>
            <div style="margin-top: 5px;">
                <strong>(_______________________)</strong>
            </div>
        </div>
        <div class="signature-right">
            <div>{{ date('d F Y') }}</div>
            <div>Administrator</div>
            <div class="signature-box"></div>
            <div style="margin-top: 5px;">
                <strong>{{ auth()->user()->name }}</strong>
            </div>
        </div>
    </div>

    <div class="footer">
        <div>Dokumen ini digenerate secara otomatis pada {{ date('d F Y, H:i:s') }} WIB</div>
    </div>
</body>

</html>
