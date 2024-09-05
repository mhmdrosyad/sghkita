<x-app-layout>
    <div class="title-wrapper pt-30 mb-5">
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
            <div class="border-end mb-30">
                <div class="title d-flex flex-wrap align-items-center justify-content-center mb-3">
                    <div class="left">
                        <h3 class="fw-semibold">
                            Aktiva
                        </h3>
                    </div>
                    <div class="right">
                    </div>
                </div>
                <div class="table-wrapper table-responsive">
                    <table id="activa-table" class="table striped-table">
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
                        </tbody>
                    </table>
                    <!-- end table -->

                </div>
                <div class="row mt-3">
                    <div class="col-md-3">
                        <strong>Total Aktiva</strong>
                    </div>
                    <div class="col-md-1">
                        <strong>:</strong>
                    </div>
                    <div class="col">
                        <strong>{{ number_format($totalActiva, 0, ',', '.') }}</strong>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="mb-30">
                <div class="title d-flex flex-wrap align-items-center justify-content-center mb-3">
                    <div class="left text-center">
                        <h3 class="fw-semibold">
                            Passiva
                        </h3>
                    </div>
                    <div class="right">
                    </div>
                </div>
                <div class="table-wrapper table-responsive">
                    <table id="passiva-table" class="table striped-table">
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
                        </tbody>
                    </table>
                    <!-- end table -->
                </div>
                <div class="row mt-3">
                    <div class="col-md-3">
                        <strong>Total Passiva</strong>
                    </div>
                    <div class="col-md-1">
                        <strong>:</strong>
                    </div>
                    <div class="col">
                        <strong>{{ number_format($totalPassiva, 0, ',', '.') }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="fs-5 py-4 d-flex justify-content-start align-items-center">

                <span>Selisih Aktiva Pasiva: </span>
                <span
                    class="ms-1 text-white px-2 py-1 fw-semibold {{$totalActiva-$totalPassiva == 0 ? 'bg-success' : 'bg-danger'}}">Rp.
                    {{ number_format($totalActiva -
                    $totalPassiva, 0, ',',
                    '.') }}</span>

            </div>
        </div>
    </div>
    <x-slot name="scripts">
        <script>
            $(document).ready(function() {
                $('#activa-table, #passiva-table').DataTable();
            });
        </script>
    </x-slot>
</x-app-layout>