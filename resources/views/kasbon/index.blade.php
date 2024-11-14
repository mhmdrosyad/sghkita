<x-app-layout>
    <div class="title-wrapper pt-30">
    </div>
    <div class="row">
        <div class="col">
            <div class="mb-30">
                <div class="title d-flex flex-wrap align-items-center justify-content-between mb-3">
                    <div class="left">
                        <h2>
                            Kasbon
                        </h2>
                    </div>
                    <div class="right">
                        @if(auth()->user()->can('add kasbon'))
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
                @if (session('error'))
                <div class="alert-box danger-alert" role="alert">
                    <div class=" alert">
                        <p class="text-medium">
                            {{ session('error') }}
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
                                    <h6>Dibayar</h6>
                                </th>
                                <th>
                                    <h6>Jenis Kasbon</h6>
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
                                @if(auth()->user()->can('manage kasbon'))
                                <th>
                                    <h6>Aksi</h6>
                                </th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kasbons as $kasbon)
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
                                    {{ number_format($kasbon->nominal_kembali, 0, ',', '.') }}
                                </td>
                                <td class="text-capitalize">
                                    {{$kasbon->tipe }}
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
                                @if(auth()->user()->can('manage kasbon'))

                                <td>
                                    <div class="action">
                                        {{-- <a href="{{ route('kasbon.edit', $kasbon->id) }}" class="text-primary">
                                            <i class="lni lni-pencil"></i>
                                        </a> --}}
                                        @if($kasbon->tipe == 'operasional')
                                        <button class="text-success" onclick="confirmPaid('{{ $kasbon->id }}')">
                                            <i class="lni lni-checkmark-circle"></i>
                                        </button>
                                        @endif

                                        @if($kasbon->tipe == 'pribadi')
                                        @if(auth()->user()->can('manage kasbon payroll'))
                                        <button class="text-success" data-bs-toggle="modal"
                                            data-bs-target="#payrollModal" data-kasbon-id="{{ $kasbon->id }}">
                                            <i class="lni lni-checkmark"></i>
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
                                        @endif
                                        @endif


                                        <form id="paid-form-{{ $kasbon->id }}"
                                            action="{{ route('kasbon.toggleStatus', $kasbon->id) }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                            @method('PUT')
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
                        <div class="select-style-1">
                            <label>Keperluan</label>
                            <div class="select-position">
                                <select class="text-capitalize" name="tipe" required>
                                    <option value="" disabled selected>Pilih jenis</option>
                                    <option value="operasional">Operasional</option>
                                    <option value="pribadi">Kasbon Pribadi</option>
                                </select>
                            </div>
                        </div>
                        <div class="input-style-1">
                            <label>Keterangan</label>
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

    <div class="modal fade" id="payrollModal" tabindex="-1" aria-labelledby="payrollModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h6>Pembayaran Kasbon Payroll</h6>
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
                    <form method="post" action="" id="payrollForm">
                        @csrf
                        @method('PUT')
                        <div class="input-style-1">
                            <label>Nominal</label>
                            <input name="nominal" type="text" placeholder="masukan nominal" id="nominalInput"
                                required />
                        </div>
                        <div class="col-12 d-flex gap-3">
                            <button type="reset" class="main-btn warning-btn btn-hover"><i
                                    class="lni lni-trash-can"></i></button>
                            <button type="submit" class="main-btn primary-btn btn-hover flex-fill">Bayar</button>
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

            document.addEventListener('DOMContentLoaded', function () {
                // Tangkap elemen modal dan form di dalamnya
                var payrollModal = document.getElementById('payrollModal');
                var payrollForm = document.getElementById('payrollForm');
                var nominalInput = document.getElementById('nominalInput'); 

                function formatNumber(number) {
                    return new Intl.NumberFormat('id-ID').format(number);
                }

                // Event listener untuk modal, setiap kali akan ditampilkan
                payrollModal.addEventListener('show.bs.modal', function (event) {
                    // Tombol yang memicu modal
                    var button = event.relatedTarget;
                    // Ambil data-kasbon-id dari tombol
                    var kasbonId = button.getAttribute('data-kasbon-id');

                    // Update action form dengan ID kasbon yang didapat
                    payrollForm.action = "/kasbon/payment-payroll/" + kasbonId;
                });

                payrollForm.addEventListener('submit', function (event) {
                    event.preventDefault(); // Mencegah form submit langsung
                    var nominal = nominalInput.value;

                    // Tampilkan SweetAlert konfirmasi
                    Swal.fire({
                        title: 'Konfirmasi Pembayaran',
                        text: "Apakah Anda yakin ingin membayar kasbon sebesar " + formatNumber(nominal) + "?" ,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Bayar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            payrollForm.submit(); // Lanjutkan submit jika dikonfirmasi
                        }
                    });
                });
            });

        </script>
    </x-slot>
</x-app-layout>