<x-app-layout>
    <div class="title-wrapper pt-30">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="title">
                    <h2>Dashboard</h2>
                </div>
            </div>
            <!-- end col -->

            <!-- end col -->
        </div>
        <!-- end row -->
    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5>Kas FO</h5>
                    <p class="fw-semibold">Rp. {{number_format($foBalance,0, '.', '.')}}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5>Saldo BCA</h5>
                    <p class="fw-semibold">Rp. {{number_format($bcaBalance,0, '.', '.')}}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5>Saldo BCA Payroll</h5>
                    <p class="fw-semibold">Rp. {{number_format($bcaPayrollBalance,0, '.', '.')}}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="title-wrapper pt-30">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="title">
                    <h3 class="fw-semibold">Laba</h3>
                </div>
            </div>
            <!-- end col -->

            <!-- end col -->
        </div>
        <!-- end row -->
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5>Laba Bulan Ini</h5>
                    <p class="fw-semibold">Rp. {{number_format($totalRevenue,0, '.', '.')}}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5>Laba Tahun Berjalan</h5>
                    <p class="fw-semibold">Rp. {{number_format($annualRevenue,0, '.', '.')}}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>