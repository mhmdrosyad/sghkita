<x-app-layout>
    <div class="title-wrapper pt-30 pb-4">
        <div class="title d-flex flex-wrap align-items-center justify-content-between mb-3">
            <div class="left">
                <h2>Neraca {{\Carbon\Carbon::createFromFormat('m-Y',
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
                                href="{{route('accounting.balanceSheet', ['period' => $period->month])}}">{{\Carbon\Carbon::createFromFormat('m-Y',
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
                <div class="title d-flex flex-wrap align-items-center justify-content-between mb-3">
                    <div class="left">
                        <h2>
                            Aktiva
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
                            @foreach($activaAccounts as $item)
                            <tr>
                                <td>{{ $item['account']->code }}</td>
                                <td>{{ $item['account']->name }}</td>
                                <td>{{ number_format($item['balance'], 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                            <tr>
                                <td colspan="2"><strong>Total Activa</strong></td>
                                <td><strong>{{ number_format($totalActiva, 0, ',', '.') }}</strong></td>
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
                            Passiva
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
                            @foreach($passivaAccounts as $item)
                            <tr>
                                <td>{{ $item['account']->code }}</td>
                                <td>{{ $item['account']->name }}</td>
                                <td>{{ number_format($item['balance'], 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                            <tr>
                                <td colspan="2"><strong>Total Passiva</strong></td>
                                <td><strong>{{ number_format($totalPassiva, 0, ',', '.') }}</strong></td>
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