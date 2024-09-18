<x-app-layout>
    <div class="title-wrapper pt-30">
    </div>
    <div class="row">
        <div class="col">
            <div class="mb-30">
                <div class="title d-flex flex-wrap align-items-center justify-content-between mb-3">
                    <div class="left">
                        <h2>
                            Kasbon Karyawan
                        </h2>
                    </div>
                    <div class="right">
                        @if(auth()->user()->can('editor'))
                        <button type="button" class="main-btn primary-btn btn-hover" data-bs-toggle="modal"
                            data-bs-target="#addModal"><i class="lni lni-plus"></i>Kasbon Baru</button>
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
                    <table id="kasbon-table" class="table striped-table">
                        <thead>
                            <tr>
                                <th>
                                    <h6>No</h6>
                                </th>
                                <th>
                                    <h6>Tanggal Pinjam</h6>
                                </th>
                                <th>
                                    <h6>Nama Karyawan</h6>
                                </th>
                                <th>
                                    <h6>Nominal</h6>
                                </th>
                                <th>
                                    <h6>Keperluan</h6>
                                </th>
                                <th>
                                    <h6>Operator</h6>
                                </th>
                                <th>
                                    <h6>Status</h6>
                                </th>
                                <th>
                                    <h6>Aksi</h6>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kasbonUnPaids as $kasbon)
                            <tr>
                                <td class="text-center">
                                    {{ $loop->iteration }}
                                </td>
                                <td>
                                    {{$kasbon->tgl_pinjam }}
                                </td>
                                <td>
                                    {{$kasbon->nama }}
                                </td>
                                <td>
                                    {{ number_format($kasbon->nominal, 0, ',', '.') }}
                                </td>
                                <td>
                                    {{$kasbon->keterangan }}
                                </td>
                                <td>
                                    {{$kasbon->user->name }}
                                </td>
                                <td>
                                    <span class="text-sm bg-danger text-white py-1 px-2">{{$kasbon->is_paid ? 'Lunas' :
                                        'Belum
                                        Lunas'
                                        }}</span>
                                </td>
                                <td>
                                    <div class="action">
                                        {{-- <a href="{{ route('kasbon.edit', $kasbon->id) }}" class="text-primary">
                                            <i class="lni lni-pencil"></i>
                                        </a> --}}
                                        <button class="text-success" onclick="confirmPaid('{{ $kasbon->id }}')">
                                            <i class="lni lni-checkmark-circle"></i>
                                        </button>
                                        <button class="text-danger" onclick="confirmDelete('{{ $kasbon->id }}')">
                                            <i class="lni lni-trash-can"></i>
                                        </button>
                                        <form id="delete-form-{{ $kasbon->id }}"
                                            action="{{ route('kasbon.destroy', $kasbon->id) }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        <form id="paid-form-{{ $kasbon->id }}"
                                            action="{{ route('kasbon.toggleStatus', $kasbon->id) }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                            @method('PUT')
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
    <div class="row">
        <div class="col">
            <div class="mb-30">
                <div class="title d-flex flex-wrap align-items-center justify-content-between mb-3">
                    <div class="left">
                        <h2>
                            History Kasbon
                        </h2>
                    </div>
                </div>
                <div class="table-wrapper table-responsive">
                    <table id="history-table" class="table striped-table">
                        <thead>
                            <tr>
                                <th>
                                    <h6>No</h6>
                                </th>
                                <th>
                                    <h6>Tanggal Pinjam</h6>
                                </th>
                                <th>
                                    <h6>Tanggal Kembali</h6>
                                </th>
                                <th>
                                    <h6>Nama Karyawan</h6>
                                </th>
                                <th>
                                    <h6>Nominal</h6>
                                </th>
                                <th>
                                    <h6>Keperluan</h6>
                                </th>
                                <th>
                                    <h6>Operator</h6>
                                </th>
                                <th>
                                    <h6>Status</h6>
                                </th>
                                <th>
                                    <h6>Aksi</h6>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kasbonPaids as $kasbon)
                            <tr>
                                <td class="text-center">
                                    {{ $loop->iteration }}
                                </td>
                                <td>
                                    {{$kasbon->tgl_pinjam }}
                                </td>
                                <td>
                                    {{$kasbon->tgl_kembali }}
                                </td>
                                <td>
                                    {{$kasbon->nama }}
                                </td>
                                <td>
                                    {{ number_format($kasbon->nominal, 0, ',', '.') }}
                                </td>
                                <td>
                                    {{$kasbon->keterangan }}
                                </td>
                                <td>
                                    {{$kasbon->user->name }}
                                </td>
                                <td>
                                    <span class="text-sm bg-success text-white py-1 px-2">{{$kasbon->is_paid ? 'Lunas' :
                                        'Belum
                                        Lunas'
                                        }}</span>
                                </td>
                                <td>
                                    <div class="action">
                                        <button class="text-success" onclick="confirmPaid('{{ $kasbon->id }}')">
                                            <i class="lni lni-reload"></i>
                                        </button>
                                        <form id="paid-form-{{ $kasbon->id }}"
                                            action="{{ route('kasbon.toggleStatus', $kasbon->id) }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                            @method('PUT')
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
                    <h6>Kasbon Baru</h6>
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
                    <form method="post" action="{{route('kasbon.store')}}">
                        @csrf
                        <div class="input-style-1">
                            <label>Tanggal Pinjam</label>
                            <input name="tgl_pinjam" type="datetime-local" required />
                        </div>
                        <div class="input-style-1">
                            <label>Nama Karyawan</label>
                            <input name="nama" type="text" placeholder="masukan nama karyawan" required />
                        </div>
                        <div class="input-style-1">
                            <label>Nominal</label>
                            <input name="nominal" type="text" placeholder="masukan nominal" required />
                        </div>
                        <div class="input-style-1">
                            <label>Alasan</label>
                            <textarea name="keterangan" type="text" placeholder="masukkan tujuan pinjam"
                                required></textarea>
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
            function confirmPaid(code) {
                Swal.fire({
                    title: 'Apakah anda yakin?',
                    text: "Status kasbon akan diubah!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, tetap ubah!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('paid-form-' + code).submit();
                    }
                })
            }
            $(document).ready(function() {
                $('#kasbon-table').DataTable();
                $('#history-table').DataTable();
            });
        </script>
    </x-slot>
</x-app-layout>