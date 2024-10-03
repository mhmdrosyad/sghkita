<x-app-layout>
    <div class="title-wrapper pt-30">
    </div>
    <div class="row">
        <div class="col">
            <div class="mb-30">
                <div class="title d-flex flex-wrap align-items-center justify-content-between mb-3">
                    <div class="left">
                        <h2>
                            User
                        </h2>
                    </div>
                    <div class="right">
                        @if(auth()->user()->can('add user'))
                        <button type="button" class="main-btn primary-btn btn-hover" data-bs-toggle="modal"
                            data-bs-target="#addModal"><i class="lni lni-plus"></i>Tambah User Baru</button>
                        @endif
                    </div>
                </div>
                @if ($errors->any())
                <div class="alert-box danger-alert" role="alert">
                    <div class=" alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif
                @if (session('success'))
                <div class="alert-box success-alert" role="alert">
                    <div class=" alert">
                        <p class="text-medium">
                            {{ session('success') }}
                        </p>
                    </div>
                </div>
                @endif
                <div class="table-wrapper table-responsive">
                    <table id="account-table" class="table striped-table">
                        <thead>
                            <tr>
                                <th>
                                    <h6>No</h6>
                                </th>
                                <th>
                                    <h6>Nama</h6>
                                </th>
                                <th>
                                    <h6>Username</h6>
                                </th>
                                <th>
                                    <h6>Email</h6>
                                </th>
                                <th>
                                    <h6>Status</h6>
                                </th>
                                <th>
                                    <h6>Jenis User</h6>
                                </th>
                                @if(auth()->user()->can('manage user'))
                                <th>
                                    <h6>Aksi</h6>
                                </th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td class="text-center">
                                    {{ $loop->iteration }}
                                </td>
                                <td>
                                    {{$user->name }}
                                </td>
                                <td>
                                    {{$user->username }}
                                </td>
                                <td>
                                    {{$user->email }}
                                </td>
                                <td>
                                    {{$user->status == true ? 'Aktif' : 'Tidak aktif' }}
                                </td>
                                <td>
                                    @foreach($user->roles as $role)
                                    {{ $role->name }}{{ !$loop->last ? ', ' : '' }}
                                    @endforeach
                                </td>
                                @if(auth()->user()->can('manage user'))
                                <td>
                                    <div class="action">
                                        <button
                                            class="badge py-1 px-2 me-2 rounded-pill fw-normal fs-6 {{ $user->status == true ? 'text-bg-danger' : 'text-bg-success' }}"
                                            onclick="confirmStatus('{{ $user->id }}')">
                                            {{ $user->status == true ? 'Nonaktifkan' : 'Aktifkan' }}
                                        </button>
                                        <a href="{{route('user.edit', $user->id)}}" class="text-primary">
                                            <i class="lni lni-pencil"></i>
                                        </a>
                                        <button class="text-danger" onclick="confirmDelete('{{ $user->id }}')">
                                            <i class="lni lni-trash-can"></i>
                                        </button>
                                        <form id="status-form-{{ $user->id }}"
                                            action="{{route('user.toggleStatus', $user->id)}}" method="POST"
                                            style="display: none;">
                                            @csrf
                                        </form>
                                        <form id="delete-form-{{ $user->id }}"
                                            action="{{route('user.destroy', $user->id)}}" method="POST"
                                            style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- end table -->
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h6>Tambah User</h6>
                    <button type="button" class="btn d-flex align-items-center fs-4 text-danger" data-bs-dismiss="modal"
                        aria-label="Close"><i class="lni lni-cross-circle"></i></button>
                </div>
                <div class="modal-body">
                    <div class="alert-box success-alert mb-3" style="display: none;">
                        <div class="alert">
                            <p id="success-message"></p>
                        </div>
                    </div>
                    <div class="alert-box danger-alert mb-3" style="display: none;">
                        <div class="alert">
                            <p id="error-message"></p>
                        </div>
                    </div>
                    <form method="post" action="{{route('user.store')}}">
                        @csrf
                        <div class="row">
                            <div class="col">
                                <div class="input-style-1">
                                    <label>Nama</label>
                                    <input name="name" type="text" placeholder="masukkan nama akun" required />
                                </div>
                            </div>
                            <div class="col">
                                <div class="input-style-1">
                                    <label>Username</label>
                                    <input name="username" type="text" placeholder="masukan username" required />
                                </div>
                            </div>
                        </div>

                        <div class="input-style-1">
                            <label>Email</label>
                            <input name="email" type="email" placeholder="masukan email" required />
                        </div>
                        <div class="input-style-1">
                            <label>Password</label>
                            <input name="password" type="password" placeholder="masukan password" required />
                        </div>
                        <div class="form-control mb-3">
                            <label>Roles</label>
                            @foreach($roles as $role)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="roles[]"
                                    value="{{ $role->name }}">
                                <label class="form-check-label">{{ $role->name }}</label>
                            </div>
                            @endforeach
                        </div>
                        <div class="col-12 d-flex gap-3">
                            <button type="reset" class="main-btn warning-btn btn-hover"><i
                                    class="lni lni-trash-can"></i></button>
                            <button type="submit" class="main-btn primary-btn btn-hover flex-fill">Tambah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="scripts">
        <script>
            function confirmDelete(code) {
                Swal.fire({
                    title: 'Apakah anda yakin?',
                    text: "Transaksi yang berkaitan degan user ini akan di hapus!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, tetap hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('delete-form-' + code).submit();
                    }
                })
            }
            function confirmStatus(id) {
                Swal.fire({
                    title: 'Apakah anda yakin?',
                    text: "Perubahan status user dapat mempengaruhi login mereka!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, tetap proses!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('status-form-' + id).submit();
                    }
                })
            }
            $(document).ready(function() {
                $('#account-table').DataTable();
            });
        </script>
    </x-slot>
</x-app-layout>