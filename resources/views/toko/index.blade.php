@extends('layout.master')

@section('title', 'Manajemen Pengguna')

@section('content')
    @php $user = auth()->user(); @endphp
    <div class="content-wrapper">
        <div class="container-fluid mt-4">
            <div class="card" id="userInfo" data-role="{{ auth()->user()->role }}">
                <div class="card-header">
                    <h3 class="card-title">Data Toko</h3>
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
                                <th>Nama Toko</th>
                                <th>Owner</th>
                                <th>No hp</th>
                                <th>Alamat</th>
                                @if ($user->role === 'admin')
                                    <th>created by</th>
                                @endif
                                <th>tgl_buat</th>
                                <th>tgl_edit</th>
                                <th>Aksi</th>
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
                            <h5 class="modal-title">Tambah Daftar Toko</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Pemilik</label>
                                <input type="text" name="owner_name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>No Hp</label>
                                <input type="text" name="phone" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Nama Sales</label>
                                <select name="created_by" class="form-control select2bs4" id="created_by">
                                    <option></option>
                                    @foreach ($data2 as $data)
                                        <option value="{{ $data->id }}">{{ ucfirst($data->name) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Alamat</label>
                                <input type="text" name="address" class="form-control" required>
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
                            <h5 class="modal-title">Edit Toko</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input type="text" name="idj" id="id" hidden>
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" name="namej" id="name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Pemilik</label>
                                <input type="text" name="owner_namej" id="owner_name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>No Hp</label>
                                <input type="text" name="phonej" id="phone" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Nama Sales</label>
                                <select name="created_byj" class="form-control select2bs4" id="created_byj">
                                    @foreach ($data2 as $data)
                                    <option value="{{ $data->id }}">{{ ucfirst($data->name) }}</option>
                                    @endforeach
                                    {{-- <option></option> --}}
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Alamat</label>
                                <input type="text" name="addressj" id="address" class="form-control" required>
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
        let role = $('#userInfo').data('role');
        $('#modalTambah').on('shown.bs.modal', function() {
            $('#created_by').select2({
                theme: 'bootstrap4',
                dropdownParent: $('#modalTambah'),
                placeholder: 'Pilih Nama Sales',
                allowClear: true
            });
        });

        let tabeltoko;
        if (role === 'admin') {
            tabeltoko = $('#tabel-toko').DataTable({
                ajax: "{{ route('stores.index') }}",
                columns: [{
                        data: 'name'
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
                        data: 'nm_sales'
                    },
                    {
                        data: 'created_at'
                    },
                    {
                        data: 'updated_at'
                    },
                    {
                        data: 'id',
                        render: function(data, type, row) {
                            return `
                    <button class="btn btn-warning btn-sm" onclick="edt(${data})">
                        <i class="fas fa-edit"></i> Edit
                    </button>
                    <button class="btn btn-danger btn-sm" onclick="dltusr(${data})">
                        <i class="fas fa-trash"></i> Hapus
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
                ajax: "{{ route('stores.index') }}",
                columns: [{
                        data: 'name'
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
                        data: 'created_at'
                    },
                    {
                        data: 'updated_at'
                    },
                    {
                        data: 'id',
                        render: function(data, type, row) {
                            return `
                    <button class="btn btn-warning btn-sm" onclick="edt(${data})">
                        <i class="fas fa-edit"></i> Edit
                    </button>
                    <button class="btn btn-danger btn-sm" onclick="dltusr(${data})">
                        <i class="fas fa-trash"></i> Hapus
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

            // Disable tombol submit untuk cegah double klik
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

            //  console.log('Data yang dikirim:', formData);


            $.ajax({
                url: "{{ route('stores.store') }}",
                type: "POST",
                data: formData,
                success: function(res) {
                    if (res.success) {
                        Swal.fire('Sukses!', res.message, 'success');
                        $('#formTambahUser')[0].reset(); // Kosongkan form
                        $('#formTambahUser input[name="name"]')
                            .focus(); // Fokus kembali ke input pertama
                        tabeltoko.ajax.reload(); // Reload tabel tanpa refresh
                        console.log('Response dari server:', res.dataIddisimpan);
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
                    submitButton.prop('disabled', false); // Enable kembali tombol submit
                }
            });
        });

        function edt(id) {
            $.ajax({
                url: BASE_URL + "/stores/" + id + "/edit",
                type: "GET",
                success: function(data) {
                    // Isi form edit dengan data dari server
                    $('#id').val(id);
                    $('#name').val(data.name);
                    $('#owner_name').val(data.owner_name);
                    $('#phone').val(data.phone);
                    $('#created_by').val(data.created_by);
                    $('#address').val(data.address);
                    $('#modalEdit').modal('show');
                    // console.log(data);
                    

                },
                error: function(xhr) {
                    Swal.fire('Gagal!', 'Gagal mengambil data', 'error');
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
                url: BASE_URL + '/stores/' + id,
                method: 'POST',
                data: formData,
                success: function(res) {
                    $('#modalEdit').modal('hide');
                    Swal.fire('Sukses', 'Data berhasil diperbarui', 'success');
                    tabeltoko.ajax.reload();
                },
                error: function(xhr) {
                    Swal.fire('Gagal', 'Terjadi kesalahan', 'error');
                    console.error(xhr.responseText); // debug
                }
            });
        });

        function dltusr(id) {
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
                        url: BASE_URL + '/stores/' + id + '/delete',
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

    </script>
@endpush
