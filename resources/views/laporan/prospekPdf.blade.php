<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Prospek</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table,
        th,
        td {
            border: 1px solid #000;
        }

        th,
        td {
            padding: 5px;
            text-align: left;
        }

        .text-center {
            text-align: center;
        }

        .mb-2 {
            margin-bottom: 8px;
        }
    </style>
</head>

<body>

    <h3 class="text-center">LAPORAN DATA PROSPEK</h3>
    <p class="text-center">PT. DISTRIBUTOR ALAT TULIS</p>

    <p class="mb-2"><strong>Periode:</strong> {{ $periode }}</p>
    @if (!empty($salesName))
        <p class="mb-2"><strong>Sales:</strong> {{ $salesName }}</p>
    @endif
    @if (!empty($statusLabel))
        <p class="mb-2"><strong>Status:</strong> {{ $statusLabel }}</p>
    @endif
    <p class="mb-2"><strong>Dicetak pada:</strong> {{ $tanggalCetak }}</p>
    {{-- <p>Jumlah data: {{ $data->count() }}</p> --}}

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Toko</th>
                <th>Pemilik</th>
                <th>HP</th>
                <th>Alamat</th>
                <th>Sales</th>
                <th>Status</th>
                <th>Catatan</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $index => $row)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $row->store_name }}</td>
                    <td>{{ $row->owner_name }}</td>
                    <td>{{ $row->phone }}</td>
                    <td>{{ $row->address }}</td>
                    <td>{{ $row->sales_name }}</td>
                    <td>{{ ucfirst($row->status) }}</td>
                    <td>{{ $row->notes }}</td>
                    <td>{{ \Carbon\Carbon::parse($row->created_at)->format('d-m-Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <br><br>
    <p><strong>Dicetak oleh:</strong> {{ $adminName }}</p>

</body>

</html>
