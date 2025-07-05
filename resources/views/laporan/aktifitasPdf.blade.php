<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Aktivitas</title>
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

    <h3 class="text-center">LAPORAN AKTIVITAS SALES</h3>
    <p class="text-center">PT. DISTRIBUTOR ALAT TULIS</p>

    <p class="mb-2"><strong>Periode:</strong> {{ $periode }}</p>
    @if (!empty($salesName))
        <p class="mb-2"><strong>Sales:</strong> {{ $salesName }}</p>
    @endif
    @if (!empty($jenisAktivitas))
        <p class="mb-2"><strong>Jenis Aktivitas:</strong> {{ $jenisAktivitas }}</p>
    @endif
    <p class="mb-2"><strong>Dicetak pada:</strong> {{ $tanggalCetak }}</p>
    {{-- <p>Jumlah data: {{ $data->count() }}</p> --}}

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nama Toko</th>
                <th>Jenis Aktivitas</th>
                <th>Sales</th>
                <th>Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $index => $row)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($row->date)->format('d-m-Y') }}</td>
                    <td>{{ $row->store_name }}</td>
                    <td>{{ ucfirst($row->type) }}</td>
                    <td>{{ $row->sales_name }}</td>
                    <td>{{ $row->description }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <br><br>
    <p><strong>Dicetak oleh:</strong> {{ $adminName }}</p>

</body>

</html>
