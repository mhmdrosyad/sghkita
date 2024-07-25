<x-app-layout>
    <div class="title-wrapper pt-30 pb-4">
        <div class="title d-flex flex-wrap align-items-center justify-content-between mb-3">
            <div class="left">
                <h2>Laporan Laba Rugi {{\Carbon\Carbon::createFromFormat('m-Y',
                    $period)->translatedFormat('F Y')}}</h2>
            </div>
            <div class="right">
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
                            Laba Rugi (Pendapatan)
                        </h2>
                    </div>
                    <div class="right">
                    </div>
                </div>
                <div class="table-wrapper table-responsive">
                    <table class="table striped-table">
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
                            <tr>
                                <td colspan="2"><strong>Total</strong></td>
                                <td><strong>{{ number_format($totalIncome, 0, ',', '.') }}</strong></td>
                            </tr>
                        </tbody>
                    </table>
                    <!-- end table -->
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card-style mb-30">
                <div class="title d-flex flex-wrap align-items-center justify-content-between mb-3">
                    <div class="left">
                        <h2>
                            Laba Rugi (Biaya)
                        </h2>
                    </div>
                    <div class="right">
                    </div>
                </div>
                <div class="table-wrapper table-responsive">
                    <table class="table striped-table">
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
                            <tr>
                                <td colspan="2"><strong>Total</strong></td>
                                <td><strong>{{ number_format($totalOutcome, 0, ',', '.') }}</strong></td>
                            </tr>
                        </tbody>
                    </table>
                    <!-- end table -->
                </div>
            </div>
        </div>
    </div>


    <x-slot name="scripts">
        <script>

        </script>
    </x-slot>
</x-app-layout>