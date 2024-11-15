<x-app-layout>
    <div class="title-wrapper pt-30">
    </div>
    <div class="row">
        <div class="col">
            <div class="mb-30">
                <div class="title d-flex flex-wrap align-items-center justify-content-between mb-3">
                    <div class="left">
                        <h2>
                            Daftar Akun
                        </h2>
                    </div>
                    <div class="right">
                        @if ($totalInitialBalance == 0)
                        <a href="{{route('account.inputBalance')}}" class="main-btn warning-btn btn-hover"><i
                                class="lni lni-plus"></i>Tambah Saldo
                            Awal</a>
                        @endif
                        <button type="button" class="main-btn success-btn btn-hover" data-bs-toggle="modal"
                            data-bs-target="#importModal"><i class="lni lni-plus"></i>Import Akun</button>
                        <button type="button" class="main-btn primary-btn btn-hover" data-bs-toggle="modal"
                            data-bs-target="#addModal"><i class="lni lni-plus"></i>Tambah Akun</button>
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
                                    <h6>Kode</h6>
                                </th>
                                <th>
                                    <h6>Nama Akun</h6>
                                </th>
                                <th>
                                    <h6>Posisi</h6>
                                </th>
                                <th>
                                    <h6>Saldo Awal</h6>
                                </th>
                                <th>
                                    <h6>Saldo Akhir</h6>
                                </th>
                                <th>
                                    <h6>Aksi</h6>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($accounts as $account)
                            <tr>
                                <td class="text-center">
                                    {{ $account->code }}
                                </td>
                                <td>
                                    <a href="{{ route('transaction.index', ['account' => $account->code]) }}">
                                        {{$account->name }} </a>
                                </td>
                                <td>
                                    <span class="text-uppercase">
                                        @if ($account->position === 'asset')
                                        Aktiva
                                        @elseif ($account->position === 'liability')
                                        Passiva
                                        @else
                                        Laba Rugi
                                        @endif
                                    </span>
                                </td>
                                <td>
                                    {{ number_format($account->initial_balance, 0, ',', '.') }}
                                </td>
                                <td>
                                    {{ number_format($account->current_balance, 0, ',', '.') }}
                                </td>
                                <td>
                                    <div class="action">
                                        <a href="{{ route('account.edit', $account->code) }}" class="text-primary">
                                            <i class="lni lni-pencil"></i>
                                        </a>
                                        <button class="text-danger" onclick="confirmDelete('{{ $account->code }}')">
                                            <i class="lni lni-trash-can"></i>
                                        </button>
                                        <form id="delete-form-{{ $account->code }}"
                                            action="{{ route('account.destroy', $account->code) }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </td>
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
                    <form method="post" action="{{route('account.store')}}">
                        @csrf
                        <div class="input-style-1">
                            <label>Kode</label>
                            <input name="code" type="text" placeholder="masukan kode akun" required />
                        </div>
                        <div class="input-style-1">
                            <label>Nama Akun</label>
                            <input name="name" type="text" placeholder="masukkan nama akun" required />
                        </div>
                        <div class="select-style-1">
                            <label>Posisi</label>
                            <div class="select-position">
                                <select class="text-capitalize" name="position" required>
                                    <option value="" disabled selected>Pilih jenis</option>
                                    <option value="asset">Aktiva</option>
                                    <option value="liability">Passiva</option>
                                    <option value="revenue">Laba Rugi (Pendapatan)</option>
                                    <option value="expense">Laba Rugi (Biaya)</option>
                                </select>
                            </div>

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
    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h6>Import Akun</h6>
                    <button type="button" class="btn d-flex align-items-center fs-4 text-danger" data-bs-dismiss="modal"
                        aria-label="Close"><i class="lni lni-cross-circle"></i></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('account.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="input-style-1">
                            <label>Upload File Ecel:</label>
                            <input name="file" type="file" required />
                        </div>
                        <div class="col-12 d-flex gap-3">
                            <button type="reset" class="main-btn warning-btn btn-hover"><i
                                    class="lni lni-trash-can"></i></button>
                            <button type="submit" class="main-btn primary-btn btn-hover flex-fill">Upload</button>
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
                    text: "Transaksi yang berkaitan degan akun ini akan di hapus!",
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
            $(document).ready(function() {
                $('#account-table').DataTable();
            });
        </script>
    </x-slot>
</x-app-layout>