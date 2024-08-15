<x-app-layout>
    <div class="title-wrapper pt-30 pb-4">
        <div class="title d-flex flex-wrap align-items-center justify-content-between mb-3">
            <div class="left">
                <h2>Laporan Laba Rugi {{\Carbon\Carbon::createFromFormat('m-Y',
                    $period)->translatedFormat('F Y')}}</h2>
            </div>
            <div class="right d-flex gap-2">
                <button type="button" class="main-btn success-btn btn-hover" data-bs-toggle="modal"
                    data-bs-target="#importModal"><i class="lni lni-plus"></i>Import Lap. Bulanan</button>
                <div class="dropdown">
                    <button class="main-btn primary-btn dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Pilih Bulan
                    </button>
                    <ul class="dropdown-menu">
                        @foreach($periods as $period)
                        <li><a class="dropdown-item"
                                href="{{route('accounting.profitLoss', ['period' => $period->month])}}">{{\Carbon\Carbon::createFromFormat('m-Y',
                                $period->month)->translatedFormat('F Y')}}</a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
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
    </div>
    <div class="row">
        <div class="col">
            <div class="card-style mb-30">
                <p>
                    <strong>Total laba rugi: </strong>
                    <span>{{ number_format($totalIncome - $totalOutcome, 0, ',', '.') }}</span>
                </p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="card-style mb-30">
                <div class="title d-flex flex-wrap align-items-center justify-content-between mb-3">
                    <div class="left">
                        <h2>
                            Pendapatan
                        </h2>
                    </div>
                    <div class="right">
                    </div>
                </div>
                <div class="table-wrapper table-responsive">
                    <table id="profit-table" class="table striped-table">
                        <thead>
                            <tr>
                                <th>
                                    <h6>Kode</h6>
                                </th>
                                <th>
                                    <h6>Nama Akun</h6>
                                </th>
                                <th>
                                    <h6>Saldo</h6>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($incomeAccounts as $item)
                            <tr>
                                <td>{{ $item['account']->code }}</td>
                                <td>{{ $item['account']->name }}</td>
                                <td>{{ number_format($item['balance'], 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- end table -->
                </div>
                <div class="row mt-3">
                    <div class="col-md-3">
                        <strong>Total</strong>
                    </div>
                    <div class="col-md-1">
                        <strong>:</strong>
                    </div>
                    <div class="col">
                        <strong>{{ number_format($totalIncome, 0, ',', '.') }}</strong>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card-style mb-30">
                <div class="title d-flex flex-wrap align-items-center justify-content-between mb-3">
                    <div class="left">
                        <h2>
                            Beban / Biaya
                        </h2>
                    </div>
                    <div class="right">
                    </div>
                </div>
                <div class="table-wrapper table-responsive">
                    <table id="loss-table" class="table striped-table">
                        <thead>
                            <tr>
                                <th>
                                    <h6>Kode</h6>
                                </th>
                                <th>
                                    <h6>Nama Akun</h6>
                                </th>
                                <th>
                                    <h6>Saldo</h6>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($outcomeAccounts as $item)
                            <tr>
                                <td>{{ $item['account']->code }}</td>
                                <td>{{ $item['account']->name }}</td>
                                <td>{{ number_format($item['balance'], 0, ',', '.') }}</td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                    <!-- end table -->
                </div>
                <div class="row mt-3">
                    <div class="col-md-3">
                        <strong>Total</strong>
                    </div>
                    <div class="col-md-1">
                        <strong>:</strong>
                    </div>
                    <div class="col">
                        <strong>{{ number_format($totalOutcome, 0, ',', '.') }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h6>Import Lap. Bulanan</h6>
                    <button type="button" class="btn d-flex align-items-center fs-4 text-danger" data-bs-dismiss="modal"
                        aria-label="Close"><i class="lni lni-cross-circle"></i></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('accounting.import') }}" method="POST" enctype="multipart/form-data">
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
            $(document).ready(function() {
                $('#profit-table, #loss-table').DataTable();
            });
        </script>
    </x-slot>
</x-app-layout>