@extends('layout.master')

@section('title', 'Manajemen Aktifitas')

@section('content')
    @php $user = auth()->user(); @endphp
    <div class="content-wrapper">
        <div class="container-fluid mt-4">
            <div class="card" id="userInfo" data-role="{{ auth()->user()->role }}">
                <div class="card-header">
                    <h3 class="card-title">Data Aktifitas</h3>
                    <div class="card-tools">
                        <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#modalTambah">
                            <i class="fas fa-plus"></i> Tambah Data
                        </button>

                    </div>
                </div>
                <div class="card-body">
                    <table id="tabel-toko" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Nama Toko</th>
                                <th>Jenis Aktivitas</th>
                                {{-- @if ($user->role === 'admin') --}}
                                <th>Sales</th>
                                {{-- @endif --}}
                                <th>Detail</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal Tambah User -->
        <div class="modal fade" id="modalTambah" tabindex="-1" role="dialog" aria-labelledby="modalLabelTambahUser"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form id="formTambahUser">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Tambah Aktivitas</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Nama Toko</label>
                                <select name="lead_id" class="form-control select2bs4" id="toko" style="width: 100%;">
                                    <option></option>
                                    @foreach ($data2 as $data)
                                        <option value="{{ $data->id }}">{{ ucfirst($data->label) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>type</label>
                                <select name="type" class="form-control select2bs4" id="type" style="width: 100%;">
                                    <option value="email">Email</option>
                                    <option value="call">Call</option>
                                    <option value="kunjungan">Kunjungan</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Deskripsi</label>
                                <input type="text" name="description" class="form-control" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Simpan</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="modal fade" id="modalLihatDetail" tabindex="-1" role="dialog" aria-labelledby="modalLihatDetailLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <form id="formDetailAktivitas">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header bg-info">
                            <h5 class="modal-title" id="modalLihatDetailLabel">Detail Aktivitas</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input type="text" id="id" name="id" hidden>
                            <div class="container-fluid">
                                <div class="row">
                                    <!-- Kolom Kiri -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Nama Toko</label>
                                            <input type="text" name="nama_toko" id="nama_toko" class="form-control"
                                                readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>No HP</label>
                                            <input type="text" name="no_hp" id="no_hp" class="form-control"
                                                readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Nama Sales</label>
                                            <input type="text" name="nama_sales" id="nama_sales" class="form-control"
                                                readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Tanggal Aktivitas</label>
                                            <input type="text" name="tanggal_aktivitas" id="tanggal_aktivitas"
                                                class="form-control" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Dibuat Pada</label>
                                            <input type="text" name="dibuat_pada" id="dibuat_pada"
                                                class="form-control" readonly>
                                        </div>
                                    </div>

                                    <!-- Kolom Kanan -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Nama Pemilik</label>
                                            <input type="text" name="nama_pemilik" id="nama_pemilik"
                                                class="form-control" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Alamat</label>
                                            <textarea name="alamat" id="alamat" class="form-control" rows="2" readonly></textarea>
                                        </div>
                                        @if ($user->role != 'admin')
                                            <div class="form-group">
                                                <label>Jenis Aktivitas</label>
                                                <input type="text" name="jenis_aktivitas" id="jenis_aktivitas"
                                                    class="form-control" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label>Deskripsi</label>
                                                <textarea name="deskripsi" id="deskripsi" class="form-control" rows="2" readonly></textarea>
                                            </div>
                                        @else
                                            <div class="form-group">
                                                <label>type</label>
                                                <select name="jenis_aktivitas" class="form-control select2bs4"
                                                    id="jenis_aktivitas" style="width: 100%;">
                                                    <option value="email">Email</option>
                                                    <option value="call">Call</option>
                                                    <option value="kunjungan">Kunjungan</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Deskripsi</label>
                                                <textarea name="deskripsi" id="deskripsi" class="form-control" rows="2"></textarea>
                                            </div>
                                        @endif
                                        <div class="form-group">
                                            <label>Diperbarui Pada</label>
                                            <input type="text" name="diperbarui_pada" id="diperbarui_pada"
                                                class="form-control" readonly>
                                        </div>
                                    </div>
                                </div> <!-- /.row -->
                            </div> <!-- /.container-fluid -->
                        </div>
                        <div class="modal-footer">
                            @if ($user->role === 'admin')
                                <button type="submit" class="btn btn-success">Simpan</button>
                                <button type="button" class="btn btn-danger" onclick="dltpros()">Hapus</button>
                            @endif
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>


    </div>

@endsection
@push('scripts')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <script src="{{ asset('AdminLTE/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('AdminLTE/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <script src="{{ asset('AdminLTE/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $('#modalTambah').on('shown.bs.modal', function() {
            $('#pemilik').select2({
                theme: 'bootstrap4',
                dropdownParent: $('#modalTambah'),
                placeholder: 'Pilih Nama Toko',
                allowClear: true
            });
        });

        let role = $('#userInfo').data('role');
        const BASE_URL = '{{ url('/') }}';

        let tabeltoko;

        if (role === 'admin') {
            tabeltoko = $('#tabel-toko').DataTable({
                ajax: "{{ route('activities.index') }}",
                columns: [{
                        data: null,
                        render: function(data, type, row, meta) {
                            return meta.row + 1;
                        },
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'date'
                    },
                    {
                        data: 'store_name'
                    },
                    {
                        data: 'type'
                    },
                    {
                        data: 'sales_name'
                    },
                    {
                        data: 'id',
                        render: function(data) {
                            return `
                            <button class="btn btn-success btn-sm" onclick="lihatdetail(${data})">
                                <i class="fas fa-solid fa-eye"></i> Detail
                            </button>
                        `;
                        },
                        orderable: false
                    }
                ],
                responsive: true,
                autoWidth: false,
                paging: true,
                searching: true

            });

        } else {
            tabeltoko = $('#tabel-toko').DataTable({
                ajax: "{{ route('activities.index') }}",
                columns: [{
                        data: null,
                        render: function(data, type, row, meta) {
                            return meta.row + 1;
                        },
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'date'
                    },
                    {
                        data: 'store_name'
                    },
                    {
                        data: 'type'
                    },
                    {
                        data: 'sales_name'
                    },
                    {
                        data: 'id',
                        render: function(data) {
                            return `
                            <button class="btn btn-success btn-sm" onclick="lihatdetail(${data})">
                                <i class="fas fa-solid fa-eye"></i> Detail
                            </button>
                        `;
                        },
                        orderable: false
                    }
                ],
                responsive: true,
                autoWidth: false,
                paging: true,
                searching: true

            });
        }

        function getCurrentTimestamp() {
            const now = new Date();
            const pad = (n) => n < 10 ? '0' + n : n;
            return now.getFullYear() + '-' + pad(now.getMonth() + 1) + '-' + pad(now.getDate()) +
                ' ' + pad(now.getHours()) + ':' + pad(now.getMinutes()) + ':' + pad(now.getSeconds());
        }

        $('#formTambahUser').submit(function(e) {
            e.preventDefault();
            const submitButton = $('#formTambahUser button[type="submit"]');
            submitButton.prop('disabled', true);
            let formData = $(this).serializeArray();
            const waktu = getCurrentTimestamp();
            formData.push({
                name: 'created_at',
                value: waktu
            });
            formData.push({
                name: 'updated_at',
                value: waktu
            });
            formData.push({
                name: 'date',
                value: waktu
            });

            $.ajax({
                url: "{{ route('activities.store') }}",
                type: "POST",
                data: formData,
                success: function(res) {
                    if (res.success) {
                        Swal.fire('Sukses!', res.message, 'success');
                        $('#formTambahUser')[0].reset();
                        $('#formTambahUser input[name="name"]')
                            .focus();
                        tabeltoko.ajax.reload();
                    }
                },
                error: function(xhr) {
                    let errors = xhr.responseJSON?.errors;
                    let message = 'Terjadi kesalahan.';

                    if (errors) {
                        message = '';
                        for (const key in errors) {
                            message += errors[key][0] + '<br>';
                        }
                    }

                    Swal.fire('Gagal!', message, 'error');
                },
                complete: function() {
                    submitButton.prop('disabled', false);
                }
            });
        });

        function lihatdetail(id) {
            $.ajax({
                url: BASE_URL + "/activities/" + id + "/lihat",
                type: 'GET',
                success: function(data) {
                    if (data.length > 0) {
                        const d = data[0];

                        $('#id').val(d.id);
                        $('#nama_toko').val(d.nama_toko);
                        $('#nama_pemilik').val(d.nama_pemilik);
                        $('#no_hp').val(d.no_hp);
                        $('#alamat').val(d.alamat);
                        $('#nama_sales').val(d.nama_sales);
                        $('#jenis_aktivitas').val(d.jenis_aktivitas);
                        $('#tanggal_aktivitas').val(d.tanggal_aktivitas);
                        $('#deskripsi').val(d.deskripsi);
                        $('#dibuat_pada').val(d.dibuat_pada);
                        $('#diperbarui_pada').val(d.diperbarui_pada);
                        $('#modalLihatDetail').modal('show');
                        console.log(data);
                    } else {
                        alert('Data tidak ditemukan');
                    }
                },
                error: function() {
                    alert('Terjadi kesalahan saat mengambil data.');
                }
            });
        }

        $('#formDetailAktivitas').submit(function(e) {
            e.preventDefault();

            var id = $('#id').val();
            console.log(id);
            const waktu = getCurrentTimestamp();
            $('#formDetailAktivitas input[name="updated_at"]').remove();
            $(this).append(`<input type="hidden" name="updated_at" value="${waktu}">`);
            var formData = $(this).serialize();
            console.log(formData);


            $.ajax({
                url: BASE_URL + '/activities/' + id,
                method: 'POST',
                data: formData,
                success: function(res) {
                    $('#modalLihatDetail').modal('hide');
                    Swal.fire('Sukses', 'Data berhasil diperbarui', 'success');
                    tabeltoko.ajax.reload();
                },
                error: function(xhr) {
                    Swal.fire('Gagal', 'Terjadi kesalahan', 'error');
                    console.error(xhr.responseval);
                }
            });
        });

        function dltpros() {
            let id = $('#id').val();
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Data yang dihapus tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Hapus'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: BASE_URL + '/activities/' + id + '/delete',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(res) {
                            if (res.success) {
                                Swal.fire('Berhasil', 'Data berhasil dihapus', 'success');
                                $('#modalLihatDetail').modal('hide');
                                tabeltoko.ajax.reload();
                            }
                        },
                        error: function(xhr) {
                            Swal.fire('Gagal', 'Terjadi kesalahan saat menghapus', 'error');
                            console.error(xhr.responseText);
                        }
                    });
                }
            });
        }
    </script>
@endpush
