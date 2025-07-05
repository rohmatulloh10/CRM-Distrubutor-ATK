@extends('layout.master')

@section('title', 'Manajemen Prospek')

@section('content')
    @php $user = auth()->user(); @endphp
    <div class="content-wrapper">
        <div class="container-fluid mt-4">
            <div class="card" id="userInfo" data-role="{{ auth()->user()->role }}">
                <div class="card-header">
                    <h3 class="card-title">Data Prospek</h3>
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
                                <th>Nama Toko</th>
                                <th>Owner</th>
                                <th>No hp</th>
                                <th>Alamat</th>
                                <th>Status</th>
                                @if ($user->role === 'admin')
                                    <th>Sales</th>
                                @endif
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
                            <h5 class="modal-title">Tambah prospek</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Nama Toko</label>
                                <select name="store_id" class="form-control select2bs4" id="toko" style="width: 100%;">
                                    <option></option>
                                    @foreach ($data3 as $data)
                                        <option value="{{ $data->id }}">{{ ucfirst($data->name) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Pemilik</label>
                                <select name="owner_name" class="form-control select2-container--bootstrap4" id="pemilik">
                                    <option value=""></option>
                                    {{-- @foreach ($data3 as $data)
                                        <option value="{{ $data->id }}">{{ ucfirst($data->owner_name) }}</option>
                                    @endforeach --}}
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Status</label>
                                <select name="status" class="form-control select2bs4" id="status" style="width: 100%;">
                                    <option value="baru">Baru</option>
                                    <option value="follow_up">Follow-Up</option>
                                    <option value="closing">Closing</option>
                                    <option value="gagal">Gagal</option>
                                </select>
                            </div>
                            @if ($user->role === 'admin')
                                <div class="form-group">
                                    <label>Role</label>
                                    <select name="created_by" class="form-control">
                                        @foreach ($data2 as $data)
                                            <option value="{{ $data->id }}">{{ ucfirst($data->name) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @else
                                <select name="created_by" class="form-control" hidden>
                                    @foreach ($data2 as $data)
                                        <option value="{{ $data->id }}">{{ ucfirst($data->name) }}</option>
                                    @endforeach
                                </select>
                            @endif
                            <div class="form-group">
                                <label>notes</label>
                                <input type="text" name="notes" class="form-control" required>
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

        <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="modalEdit" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form id="formEditUser">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit prospek</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input type="text" name="id" class="form-control" id="id" hidden>
                            <div class="form-group">
                                <label>Nama Toko</label>
                                <input type="text" name="nama_toko" class="form-control" id="nama_toko2" readonly>
                            </div>
                            <div class="form-group">
                                <label>Pemilik</label>
                                <input type="text" name="pemilik" class="form-control" id="owner" readonly>
                            </div>
                            <div class="form-group">
                                <label>No Hp</label>
                                <input type="text" name="hp" class="form-control" id="phone" readonly>
                            </div>
                            <div class="form-group">
                                <label>Alamat</label>
                                <input type="text" name="alamat" class="form-control" id="alamat" readonly>
                            </div>
                            <div class="form-group">
                                <label>Status</label>
                                <select name="status" id="status" class="form-control" required>
                                    <option value="baru">baru</option>
                                    <option value="follow_up">Follow Up</option>
                                    <option value="closing">Closing</option>
                                    <option value="gagal">Gagal</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Catatan</label>
                                <input type="text" name="notes" class="form-control" required id="catatan">
                            </div>
                            @if ($user->role === 'admin')
                                <div class="form-group">
                                    <label>Sales</label>
                                    <select name="created_by" class="form-control select2bs4" id="sales"
                                        style="width: 100%;">
                                        <option></option>
                                        @foreach ($data2 as $data)
                                            <option value="{{ $data->id }}">{{ ucfirst($data->name) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @else
                                <input type="text" name="created_by" id="sales" hidden readonly>
                            @endif
                            <div class="form-group">
                                <label>Dibuat Pada</label>
                                <input type="text" name="disimpan" class="form-control" readonly id="Iat">
                            </div>
                            <div class="form-group">
                                <label>Diedit Pada</label>
                                <input type="text" name="diedit" class="form-control" readonly id="Uet">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Simpan</button>
                            @if ($user->role === 'admin')
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
        const BASE_URL = '{{ url('/') }}';
        $('#modalTambah').on('shown.bs.modal', function() {
            $('#pemilik').select2({
                theme: 'bootstrap4',
                dropdownParent: $('#modalTambah'),
                placeholder: 'Pilih Nama Toko',
                allowClear: true
            });
        });

        let role = $('#userInfo').data('role');

        let tabeltoko;

        if (role === 'admin') {
            tabeltoko = $('#tabel-toko').DataTable({
                ajax: "{{ route('leads.index') }}",
                columns: [{
                        data: null,
                        render: function(data, type, row, meta) {
                            return meta.row + 1;
                        },
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'store_name'
                    },
                    {
                        data: 'owner_name'
                    },
                    {
                        data: 'phone'
                    },

                    {
                        data: 'address'
                    },
                    {
                        data: 'status'
                    },
                    {
                        data: 'created_by'
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
                ajax: "{{ route('leads.index') }}",
                columns: [{
                        data: null,
                        render: function(data, type, row, meta) {
                            return meta.row + 1;
                        },
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'store_name'
                    },
                    {
                        data: 'owner_name'
                    },
                    {
                        data: 'phone'
                    },

                    {
                        data: 'address'
                    },
                    {
                        data: 'status'
                    },
                    // {
                    //     data: 'created_by'
                    // },
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

            $.ajax({
                url: "{{ route('leads.store') }}",
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
                url: BASE_URL + "/leads/" + id + "/edit",
                type: 'GET',
                success: function(data) {
                    if (data.length > 0) {
                        const d = data[0];

                        $('#modalEdit').modal('show');
                        $('#id').val(d.id);
                        $('#nama_toko2').val(d.name);
                        $('#owner').val(d.owner_name);
                        $('#phone').val(d.phone);
                        $('#alamat').val(d.address);
                        $('#status').val(d.status).trigger('change');
                        $('#catatan').val(d.notes);
                        if (role === 'admin') {
                            $('#sales').val(d.created_by).trigger('change');
                        } else {
                            $('#sales').val(d.created_by);
                        }
                        $('#Iat').val(d.created_at);
                        $('#Uet').val(d.updated_at);
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

        $('#formEditUser').submit(function(e) {
            e.preventDefault();

            var id = $('#id').val();
            const waktu = getCurrentTimestamp();
            $('#formEditUser input[name="updated_at"]').remove();
            $(this).append(`<input type="hidden" name="updated_at" value="${waktu}">`);
            var formData = $(this).serialize();

            $.ajax({
                url: BASE_URL + '/leads/' + id,
                method: 'POST',
                data: formData,
                success: function(res) {
                    $('#modalEdit').modal('hide');
                    Swal.fire('Sukses', 'Data berhasil diperbarui', 'success');
                    tabeltoko.ajax.reload();
                },
                error: function(xhr) {
                    Swal.fire('Gagal', 'Terjadi kesalahan', 'error');
                    console.error(xhr.responseText);
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
                        url: BASE_URL + '/leads/' + id + '/delete',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(res) {
                            if (res.success) {
                                Swal.fire('Berhasil', 'Data berhasil dihapus', 'success');
                                $('#modalEdit').modal('hide');
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

        $('#toko').change(function() {
            var tokoId = $(this).val();

            if (tokoId) {
                $.ajax({
                    url: BASE_URL + "/leads/" + tokoId + "/owner",
                    method: 'GET',
                    success: function(data) {
                        $('#pemilik').empty(); 
                        if (data.owner_name) {
                            $('#pemilik').append('<option value="' + tokoId + '">' + data.owner_name +
                                '</option>');
                        } else {
                            $('#pemilik').append('<option value="">Pemilik tidak ditemukan</option>');
                        }
                        // console.log(data);
                    },
                    error: function() {
                        $('#pemilik').empty().append('<option value="">Error loading owner</option>');
                    }
                });
            } else {
                $('#pemilik').empty().append('<option value="">Pilih Toko terlebih dahulu</option>');
            }
        });

    </script>
@endpush
