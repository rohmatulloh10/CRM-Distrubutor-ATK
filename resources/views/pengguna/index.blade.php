@extends('layout.master')

@section('title', 'Manajemen Pengguna')

@section('content')
    <div class="content-wrapper">
        <div class="container-fluid mt-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Pengguna</h3>
                    <div class="card-tools">
                        <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#modalTambah">
                            <i class="fas fa-plus"></i> Tambah Data
                        </button>

                    </div>
                </div>
                <div class="card-body">
                    {{-- <table id="tabel-rekap" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ ucfirst($user->role) }}</td>
                                    <td>
                                        <button class="btn btn-warning btn-sm" onclick="edt({{ $user->id }})">
                                            <i class="fas fa-edit"></i>Edit
                                        </button>
                                        <button class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i>Hapus
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table> --}}
                    <table id="tabel-rekap" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Role</th>
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
                            <h5 class="modal-title">Tambah User</h5>
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
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Role</label>
                                <select name="role" class="form-control">
                                    <option value="sales">Sales</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" required>
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
    <!-- Modal Edit -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-hidden="true" role="dialog"
        aria-labelledby="modalEditUser">
        <div class="modal-dialog" role="document">
            <form id="formEditUser">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="editUserId">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" name="name" id="editName" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" id="editEmail" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Role</label>
                            <select name="role" id="editRole" class="form-control">
                                <option value="admin">Admin</option>
                                <option value="sales">Sales</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Password (kosongkan jika tidak ingin mengubah)</label>
                            <input type="password" name="password" id="editPassword" class="form-control"
                                placeholder="********">
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

@endsection
@push('scripts')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <script src="{{ asset('AdminLTE/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('AdminLTE/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        const BASE_URL = '{{ url('/') }}';

        let tabelRekap = $('#tabel-rekap').DataTable({
            ajax: "{{ route('users.index') }}",
            columns: [{
                    data: 'name'
                },
                {
                    data: 'email'
                },
                {
                    data: 'role',
                    render: function(data) {
                        return data.charAt(0).toUpperCase() + data.slice(1);
                    }
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

        $('#formTambahUser').submit(function(e) {
            e.preventDefault();

            let formData = $(this).serializeArray();

            $.ajax({
                url: "{{ route('users.store') }}",
                type: "POST",
                data: formData,
                success: function(res) {
                    if (res.success) {
                        $('#modalTambahUser').modal('hide');
                        Swal.fire('Sukses!', res.message, 'success');
                        // location.reload();
                        tabelRekap.ajax.reload();
                    }
                },
                error: function(xhr) {
                    let errors = xhr.responseJSON.errors;
                    let message = '';
                    for (const key in errors) {
                        message += errors[key][0] + '<br>';
                    }
                    Swal.fire('Gagal!', message, 'error');
                }
            });
        });

        function edt(id) {
            $.get( BASE_URL + '/users/' + id + '/edit', function(data) {
                $('#editUserId').val(data.id);
                $('#editName').val(data.name);
                $('#editEmail').val(data.email);
                $('#editRole').val(data.role);
                $('#editUserModal').modal('show');
            });
        }

        $('#formEditUser').submit(function(e) {
            e.preventDefault();

            var id = $('#editUserId').val();
            var formData = $(this).serialize();

            $.ajax({
                url: BASE_URL + '/users/' + id,
                method: 'POST',
                data: formData,
                success: function(res) {
                    $('#editUserModal').modal('hide');
                    Swal.fire('Sukses', 'Data berhasil diperbarui', 'success');
                    // Swal.fire('Sukses', 'Data berhasil diperbarui', 'success').then(() => location
                    //     .reload());
                    tabelRekap.ajax.reload();
                },
                error: function() {
                    Swal.fire('Gagal', 'Terjadi kesalahan', 'error');
                }
            });
        });

        function dltusr(id) {
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: BASE_URL + '/users/' + id,
                        method: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function() {
                            Swal.fire('Berhasil', 'Data berhasil dihapus', 'success');
                            tabelRekap.ajax.reload();
                        },
                        error: function() {
                            Swal.fire('Gagal', 'Terjadi kesalahan', 'error');
                        }
                    });
                }
            });
        }
    </script>
@endpush
