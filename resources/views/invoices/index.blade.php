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
                            <th>Total Tagihan</th>
                            <th>Sales</th>
                            <th>Status</th> <!-- New Column for Status -->
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoices as $invoice)
                        <tr>
                            <td>
                                @if($invoice->reservation)
                                {{ $invoice->reservation->order_code }}
                                @else
                                No reservation
                                @endif
                            </td>
                            <td>
                                @if($invoice->reservation && $invoice->reservation->customer)
                                {{ $invoice->reservation->customer->agency }}
                                @else
                                No customer data
                                @endif
                            </td>
                            <td>
                                @if($invoice->reservation && $invoice->reservation->customer)
                                {{ $invoice->reservation->customer->name }}
                                @else
                                No customer name
                                @endif
                            </td>
                            <td>Rp. {{ number_format($invoice->total_bill, 0, ',', '.') }}</td>
                            <td>
                                @if($invoice->reservation && $invoice->reservation->sales)
                                {{ $invoice->reservation->sales->name }}
                                @else
                                No sales data
                                @endif
                            </td>
                            <td>
                                <span class="badge 
                                    @if($invoice->status == 'done')
                                        bg-success
                                    @elseif($invoice->status == 'dp')
                                        bg-primary text-white
                                    @else
                                        bg-secondary text-white
                                    @endif
                                    ">
                                    {{ ucfirst($invoice->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('invoices.show', $invoice->id) }}" class="btn btn-sm btn-warning">Detail</a>
                            </td>
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