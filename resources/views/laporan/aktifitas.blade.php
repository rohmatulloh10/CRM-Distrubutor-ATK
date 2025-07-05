@extends('layout.master')

@section('title', 'Laporan Aktifitas')

@section('content')
    @php $user = auth()->user(); @endphp
    <div class="content-wrapper">
        <div class="container-fluid mt-4">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Filter Laporan prospek Sales</h3>
                </div>
                <div class="card-body">
                    <form id="filterAktivitas">
                        <div class="row">
                            <div class="col-md-3">
                                <label>Sales</label>
                                <select name="sales_id" id="sales_id" class="form-control">
                                    <option value="All">Semua Sales</option>
                                    @foreach ($data2 as $data)
                                        <option value="{{ $data->id }}">{{ ucfirst($data->name) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="all">Pilih Status</option>
                                    @foreach ($data3 as $data)
                                        <option value="{{ $data->type }}">{{ ucfirst($data->type) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Tanggal awal</label>
                                <input type="date" name="start_date" id="start_date" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label>Tanggal Akhir</label>
                                <input type="date" name="end_date" id="end_date" class="form-control">
                            </div>
                        </div>
                        <button class="btn btn-primary mt-3" type="button" id="filter-btn"
                            onclick="tampil()">Tampilkan</button>
                    </form>
                </div>
            </div>
            <div class="card" id="datatoko" data-role="{{ auth()->user()->role }}">
                <div class="card-header">
                    <h3 class="card-title">Data Toko</h3>
                    <div class="card-tools">
                        <button onclick="exportPDF()" class="btn btn-danger">Cetak PDF</button>
                    </div>
                </div>
                <div class="card-body">
                    <table id="tabel-prospek" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>tanggal</th>
                                <th>Toko</th>
                                <th>Sales</th>
                                <th>jenis</th>
                                <th>keterangan</th>
                                {{-- <th>Tanggal</th> --}}
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('scripts')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <script src="{{ asset('AdminLTE/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('AdminLTE/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <!-- Buttons CSS (optional for better styling) -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap4.min.css">

    <!-- DataTables Buttons -->
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap4.min.js"></script>

    <!-- Export to Excel, PDF, and Print -->
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

    <!-- PDF Make (required for PDF export) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>

    <script>
        // const getId = $('#app').val();
        let isDataAvailable = false;
        let role = $('#userInfo').data('role');
        let id = $('#sales_id').val();
        let status = $('#status').val();
        let akhir = $('#end_date').val();
        let awal = $('#start_date').val();
        let tabelaktifitas;
        tabelaktifitas = $('#tabel-prospek').DataTable({
            serverSide: true,
            deferLoading: 0,
            ajax: {
                url: "{{ route('laporan.aktifitas') }}",
                data: function(d) {
                    d.sales_id = $('#sales_id').val();
                    d.status = $('#status').val();
                    d.end_date = $('#end_date').val();
                    d.start_date = $('#start_date').val();
                }
            },
            columns: [{
                    data: null,
                    render: function(data, type, row, meta) {
                        return meta.row + 1; // otomatis nomor urut
                    },
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'date',
                    title: 'tanggal'
                },
                {
                    data: 'store_name',
                    title: 'toko'
                },
                {
                    data: 'sales_name',
                    title: 'Sales'
                },
                {
                    data: 'type',
                    title: 'type'
                },
                {
                    data: 'description',
                    title: 'notes'
                },
                // {
                //     data: 'created_at',
                //     title: 'tanggal'
                // },
            ],
            responsive: true,
            autoWidth: false,
            paging: true,
            searching: true,

        });

        function tampil() {
            let id = $('#sales_id').val();
            let status = $('#status').val();
            let akhir = $('#end_date').val();
            let awal = $('#start_date').val();
            if (!id || !status || !akhir || !awal) {
                // alert('Semua data harus diisi terlebih dahulu!');
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops!',
                    text: 'Semua data harus diisi terlebih dahulu.',
                    confirmButtonText: 'OK'
                });

                return; // menghentikan eksekusi selanjutnya
            }
            // console.log(id + status + akhir + awal)
            // tabelaktifitas.ajax.reload();
            tabelaktifitas.ajax.reload(function(json) {
                if (json.data.length === 0) {
                    Swal.fire({
                        icon: 'info',
                        title: 'Tidak ada data',
                        text: 'Data tidak ditemukan untuk filter yang dipilih.',
                        confirmButtonText: 'OK'
                    });
                } else {
                    isDataAvailable = true;
                }
            });
        }

        function exportPDF() {
            const start = $('#start_date').val();
            const end = $('#end_date').val();
            const salesId = $('#sales_id').val();
            const status = $('#status').val();

            if (!isDataAvailable) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops!',
                    text: 'Tidak ada data yang bisa dicetak.',
                    confirmButtonText: 'OK'
                });
                return;
            }
            const query = $.param({
                start_date: start,
                end_date: end,
                sales_id: salesId,
                status: status
            });

            window.open("{{ route('laporan.aktifitas.pdf') }}?" + query, '_blank');
        }
    </script>
@endpush
