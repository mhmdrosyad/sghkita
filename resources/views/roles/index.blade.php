<x-app-layout>
    <div class="title-wrapper pt-30">
    </div>
    <div class="row">
        <div class="col">
            <div class="mb-30">
                <div class="title d-flex flex-wrap align-items-center justify-content-between mb-3">
                    <div class="left">
                        <h2>
                            Role
                        </h2>
                    </div>
                    <div class="right">
                        @if(auth()->user()->can('manage role'))
                        <button type="button" class="main-btn primary-btn btn-hover" data-bs-toggle="modal"
                            data-bs-target="#addModal"><i class="lni lni-plus"></i>Tambah Role</button>
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
                                    <h6>Permission</h6>
                                </th>
                                @if(auth()->user()->can('manage role'))
                                <th>
                                    <h6>Aksi</h6>
                                </th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($roles as $role)
                            <tr>
                                <td class="text-center">
                                    {{ $loop->iteration }}
                                </td>
                                <td>
                                    {{$role->name }}
                                </td>
                                <td>
                                    @foreach($role->permissions as $permission)
                                    <span class="badge bg-primary fw-normal">{{ $permission->name }}</span>
                                    @endforeach
                                </td>
                                @if(auth()->user()->can('manage role'))
                                <td>
                                    <div class="action">
                                        <a href="{{ route('roles.edit', $role->id) }}" class="text-primary">
                                            <i class="lni lni-pencil"></i>
                                        </a>
                                        <button class="text-danger" onclick="confirmRoleDelete('{{ $role->id }}')">
                                            <i class="lni lni-trash-can"></i>
                                        </button>
                                        <form id="delete-role-{{ $role->id }}"
                                            action="{{ route('roles.destroy', $role->id) }}" method="POST"
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
    <div class="row">
        <div class="col">
            <div class="mb-30">
                <div class="title d-flex flex-wrap align-items-center justify-content-between mb-3">
                    <div class="left">
                        <h2>
                            Permission
                        </h2>
                    </div>
                    <div class="right">
                        @if(auth()->user()->can('manage permission'))
                        <button type="button" class="main-btn primary-btn btn-hover" data-bs-toggle="modal"
                            data-bs-target="#addPermissionModal"><i class="lni lni-plus"></i>Tambah Permission</button>
                        @endif
                    </div>
                </div>
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
                                @if(auth()->user()->can('manage permission'))
                                <th>
                                    <h6>Aksi</h6>
                                </th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($permissions as $permission)
                            <tr>
                                <td class="text-center">
                                    {{ $loop->iteration }}
                                </td>
                                <td>
                                    {{$permission->name }}
                                </td>

                                @if(auth()->user()->can('manage permission'))
                                <td>
                                    <div class="action">
                                        <button
                                            class="bg-danger text-white px-3 py-1 gap-2 d-flex align-items-center fs-6"
                                            onclick="confirmDelete('{{ $permission->id }}')">
                                            Hapus <i class="lni lni-trash-can"></i>
                                        </button>
                                        <form id="delete-permission-{{ $permission->id }}"
                                            action="{{ route('permission.destroy', $permission->id) }}" method="POST"
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
                    <h6>Tambah Akun</h6>
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
                    <form method="post" action="{{route('roles.store')}}">
                        @csrf
                        <div class="input-style-1">
                            <label>Nama Role</label>
                            <input name="name" type="text" placeholder="masukkan nama role" required />
                        </div>
                        <div class="form-control mb-3">
                            <label>Permissions</label>
                            @foreach($permissions as $permission)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="permissions[]"
                                    value="{{ $permission->name }}">
                                <label class="form-check-label">{{ $permission->name }}</label>
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
    <div class="modal fade" id="addPermissionModal" tabindex="-1" aria-labelledby="addPermissionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h6>Tambah Permission</h6>
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
                    <form method="post" action="{{route('permission.store')}}">
                        @csrf
                        <div class="input-style-1">
                            <label>Nama Permission</label>
                            <input name="name" type="text" placeholder="masukkan nama permission" required />
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
                    text: "Menghapus permission mungkin akan menyebabkan beberapa kode tidak berfungsi!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, tetap hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('delete-permission-' + code).submit();
                    }
                })
            }
            function confirmRoleDelete(id) {
                Swal.fire({
                    title: 'Apakah anda yakin?',
                    text: "Menghapus role mungkin akan menyebabkan beberapa kode tidak berfungsi!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, tetap hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('delete-role-' + id).submit();
                    }
                })
            }
            // $(document).ready(function() {
            //     $('#account-table').DataTable();
            // });
        </script>
    </x-slot>
</x-app-layout>