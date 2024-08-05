<x-app-layout>
    <div class="title-wrapper pt-30">
    </div>
    <div class="container">
        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="fw-bolder">Daftar Invoice</h4>
                </div>
            </div>

            <div class="table-wrapper table-responsive">
                <table id="invoicesTable" class="table striped-table">
                    <thead>
                        <tr>
                            <th>Kode Reservasi</th>
                            <th>Instansi</th>
                            <th>Nama</th>
                            <!-- <th>Pax</th> -->
                            <!-- <th>Harga/pax</th> -->
                            <th>Total Tagihan</th>
                            <th>Sales</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoices as $invoice)
                        <tr>
                            <td>{{$invoice->reservation->order_code}}</td>
                            <td>{{$invoice->reservation->customer->agency}}</td>
                            <td>{{$invoice->reservation->customer->name}}</td>
                            <!-- <td>{{$invoice->reservation->pax}}</td> -->
                            <!-- <td>{{$invoice->reservation->rate}}</td> -->
                            <td>Rp. {{number_format($invoice->total_bill, 0, ',', '.')}}</td>
                            <td>{{$invoice->reservation->sales->name}}</td>
                            <td><a href="{{route('invoices.show', $invoice->id)}}" class="btn btn-sm btn-warning">Detail</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <x-slot name="scripts">
        <script>
            $(document).ready(function() {
                $('#invoicesTable').DataTable();
            });
        </script>
    </x-slot>
</x-app-layout>