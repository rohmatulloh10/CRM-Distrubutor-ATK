@extends('layout.master')

@section('title', 'Manajemen Prospek')

@section('content')
    @php $user = auth()->user(); @endphp
    <div class="content-wrapper">
        <div class="container-fluid mt-4">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Filter Laporan Aktivitas Sales</h3>
                </div>
                <div class="card-body">
                    <form id="filterAktivitas">
                        <div class="row">
                            <div class="col-md-4">
                                <label>Sales</label>
                                <select name="sales_id" id="sales_id" class="form-control">
                                    <option value="All">Semua Sales</option>
                                    @foreach ($data2 as $data)
                                        <option value="{{ $data->id }}">{{ ucfirst($data->name) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>Tanggal Mulai</label>
                                <input type="date" name="start_date" id="start_date" class="form-control">
                            </div>
                            <div class="col-md-4">
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
                        {{-- <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#modalTambah">
                            <i class="fas fa-plus"></i> Tambah Data
                        </button> --}}
                        <button onclick="exportPDF()" class="btn btn-danger">Cetak PDF</button>
                    </div>
                </div>
                <div class="card-body">
                    <table id="tabel-toko" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Toko</th>
                                <th>Owner</th>
                                <th>Hp</th>
                                @if ($user->role === 'admin')
                                    <th>Sales</th>
                                @endif
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
        let tabeltoko;
        let isDataAvailable = false;
        let role = $('#userInfo').data('role');
        let id = $('#sales_id').val();
        let awal = $('#start_date').val();
        let akhir = $('#end_date').val();
        tabeltoko = $('#tabel-toko').DataTable({
            serverSide: true,
            deferLoading: 0,
            ajax: {
                url: "{{ route('laporan.toko') }}",
                data: function(d) {
                    d.sales_id = $('#sales_id').val();
                    d.start_date = $('#start_date').val();
                    d.end_date = $('#end_date').val();
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
                    data: 'name',
                    title: 'Nama Toko'
                },
                {
                    data: 'owner_name',
                    title: 'Owner'
                },
                {
                    data: 'phone',
                    title: 'HP'
                },
                {
                    data: 'nm_sales',
                    title: 'Sales'
                }
            ],
            responsive: true,
            autoWidth: false,
            paging: true,
            searching: true,

        });

        function tampil() {
            let id = $('#sales_id').val();
            let awal = $('#start_date').val();
            let akhir = $('#end_date').val();
            if (!id || !awal || !akhir) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops!',
                    text: 'Semua data harus diisi terlebih dahulu.',
                    confirmButtonText: 'OK'
                });

                return;
            }
            tabeltoko.ajax.reload(function(json) {
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
                sales_id: salesId
            });

            window.open("{{ route('laporan.toko.pdf') }}?" + query, '_blank');
        }
    </script>
@endpush
