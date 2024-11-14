<x-app-layout>
    <div class="title-wrapper pt-30">
    </div>
    <div class="row">
        <div class="col">
            <div class="mb-30">
                <div class="title d-flex flex-wrap align-items-center justify-content-between mb-3">
                    <div class="left">
                        <h2>
                            Monthly Balance
                        </h2>
                    </div>
                    <div class="right">
                        <form action="{{ route('balance.current.month') }}" method="POST">
                            @csrf
                            <button class="main-btn warning-btn btn-hover" type="submit" class="btn btn-primary">
                                Balancing Saldo Bulan Ini
                            </button>
                        </form>
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
                                    <h6>Bulan</h6>
                                </th>
                                <th>
                                    <h6>Aksi</h6>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($months as $month)
                            <tr>
                                <td class="text-center">
                                    {{ $loop->iteration }}
                                </td>
                                <td>
                                    {{$month->month }}
                                </td>
                                <td>
                                    <div class="action">
                                        <button class="text-danger" onclick="confirmDelete('{{ $month->month }}')">
                                            <i class="lni lni-trash-can"></i>
                                        </button>
                                        <form id="delete-form-{{ $month->month }}"
                                            action="{{ route('monthly_balance.destroy', $month->month) }}" method="POST"
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