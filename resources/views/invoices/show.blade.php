<x-app-layout>
    <div class="title-wrapper pt-30"></div>
    <div class="container">
        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        <div class="card">
            <div class="card-header text-center">
                <h3>
                    Invoice Code : <strong class="text-primary">{{ $invoice->reservation->order_code }}</strong> |
                    {{ $invoice->reservation->customer->agency }}
                </h3>
            </div>


            <div class="card-body">
                <div class="invoice-details mb-4">
                    <h4 class="mb-4">Invoice Details</h4>
                    <div class="row mb-2">
                        <div class="col-sm-3"><strong>Instansi</strong></div>
                        <div class="col-sm-8">: {{ $invoice->reservation->customer->agency }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-3"><strong>Customer Name</strong></div>
                        <div class="col-sm-8">: {{ $invoice->reservation->customer->name }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-3"><strong>Order Code</strong></div>
                        <div class="col-sm-8">: {{ $invoice->reservation->order_code }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-3"><strong>Reservation Category</strong></div>
                        <div class="col-sm-8">: {{ $invoice->reservation->resCategory->name }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-3"><strong>Number of Pax</strong></div>
                        <div class="col-sm-8">: {{ $invoice->reservation->pax }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-3"><strong>Rate per Pax</strong></div>
                        <div class="col-sm-8">: {{ number_format($invoice->reservation->rate, 0, '.', '.') }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-3"><strong>Total Amount</strong></div>
                        <div class="col-sm-8">: {{ number_format($invoice->reservation->rate * $invoice->reservation->pax, 0, '.', '.') }}</div>
                    </div>
                </div>


                <!-- Invoice Items Section -->
                <div class="invoice-items mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4>Invoice Items</h4>
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addItemModal">Add Item</button>
                    </div>
                    <div class="table-wrapper table-responsive">
                        <table class="table striped-table">
                            <thead>
                                <tr>
                                    <th>Description</th>
                                    <th>Rate</th>
                                    <th>Qty</th>
                                    <th>Total</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $invoice->reservation->resCategory->name }}</td>
                                    <td>{{ number_format($invoice->reservation->rate, 0, '.', '.') }}</td>
                                    <td>{{ number_format($invoice->reservation->pax) }}</td>
                                    <td>{{ number_format($invoice->reservation->rate * $invoice->reservation->pax, 0, '.', '.') }}</td>
                                    <td></td>
                                </tr>
                                @foreach($invoice->items as $item)
                                <tr>
                                    <td>{{ $item->description }}</td>
                                    <td>{{ number_format($item->rate, 0, '.', '.') }}</td>
                                    <td>{{ $item->pax }}</td>
                                    <td>{{ number_format($item->rate * $item->pax, 0, '.', '.') }}</td>
                                    <td class="text-center">
                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editItemModal-{{ $item->id }}">Edit</button>
                                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteItemModal-{{ $item->id }}">Delete</button>
                                    </td>
                                </tr>
                                @endforeach
                                <!-- Total Row -->
                                <tr class="">
                                    <td colspan="3" class="text-end"><strong>Total:</strong></td> <!-- Adjust colspan to 3 -->
                                    <td class="text-primary"><strong>
                                            Rp. {{ number_format(
                        $invoice->items->sum(function($item) {
                            return $item->rate * $item->pax;
                        }) + ($invoice->reservation->rate * $invoice->reservation->pax),
                        0, '.', '.'
                    ) }}
                                        </strong></td>
                                    <td></td> <!-- Empty cell to align with action column -->
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Add Payment Button -->
                <button class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#addPaymentModal">Add Payment</button>

                <!-- Payments List -->
                @if($invoice->payments->isNotEmpty())
                <div class="invoice-items mt-4">
                    <h4 class="mb-2">Payments</h4>
                    <div class="table-wrapper table-responsive">
                        <table class="table striped-table">
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Transaction ID</th>
                                    <th>Date</th>
                                    <th>Nominal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($invoice->payments as $payment)
                                <tr>
                                    <td>{{ $payment->type }}</td>
                                    <td>{{ $payment->transaction_id }}</td>
                                    <td>{{ $payment->created_at->format('d/m/Y') }}</td>
                                    <td>{{ number_format($payment->transaction->nominal, 0, '.', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif

                <!-- Kurang Bayar -->
                <div class="kurang-bayar-container mt-4 text-end">
                    <div class="p-3 border rounded bg-light d-inline-block">
                        <h4 class="mb-0">
                            <span>Kurang Bayar:</span>
                            <span class="text-danger ms-2">
                                Rp. {{ number_format(
                    ($invoice->items->sum(function($item) {
                        return $item->rate * $item->pax;
                    }) + ($invoice->reservation->rate * $invoice->reservation->pax)) - $invoice->payments->sum('transaction.nominal'),
                    0, '.', '.'
                ) }}
                            </span>
                        </h4>
                    </div>
                </div>



                <!-- Add Payment Modal -->
                <div class="modal fade" id="addPaymentModal" tabindex="-1" aria-labelledby="addPaymentModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addPaymentModalLabel">Add Payment</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('payments.store') }}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <input type="hidden" name="reservation_code" value="{{ $invoice->reservation->order_code }}">
                                    <input type="hidden" name="category_code" value="008">

                                    <div class="mb-3">
                                        <label for="type" class="form-label">Payment Type</label>
                                        <select class="form-control" id="type" name="type" required>
                                            <option value="008">Deposit Tamu Grup</option>
                                            <option value="064">Deposit Tamu via BCA</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="total" class="form-label">Total Amount</label>
                                        <input type="number" step="0.01" class="form-control" id="total" name="total" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save Payment</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- End of Modals -->

                <!-- Add Item Modal -->
                <div class="modal fade" id="addItemModal" tabindex="-1" aria-labelledby="addItemModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addItemModalLabel">Add Invoice Item</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('invoice_items.add', $invoice->id) }}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description</label>
                                        <input type="text" class="form-control" id="description" name="description" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="rate" class="form-label">Rate</label>
                                        <input type="number" step="0.01" class="form-control" id="rate" name="rate" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="pax" class="form-label">Qty</label>
                                        <input type="number" class="form-control" id="pax" name="pax" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save Item</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- End of Modals -->

                <!-- Edit Item Modal -->
                @foreach($invoice->items as $item)
                <div class="modal fade" id="editItemModal-{{ $item->id }}" tabindex="-1" aria-labelledby="editItemModalLabel-{{ $item->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editItemModalLabel-{{ $item->id }}">Edit Invoice Item</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('invoice_items.update', ['invoice' => $invoice->id, 'item' => $item->id]) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description</label>
                                        <input type="text" class="form-control" id="description" name="description" value="{{ $item->description }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="rate" class="form-label">Rate</label>
                                        <input type="number" step="0.01" class="form-control" id="rate" name="rate" value="{{ $item->rate }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="pax" class="form-label">Qty</label>
                                        <input type="number" class="form-control" id="pax" name="pax" value="{{ $item->pax }}" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
                <!-- End of Edit Item Modals -->

                <!-- Delete Item Confirmation Modal -->
                @foreach($invoice->items as $item)
                <div class="modal fade" id="deleteItemModal-{{ $item->id }}" tabindex="-1" aria-labelledby="deleteItemModalLabel-{{ $item->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteItemModalLabel-{{ $item->id }}">Confirm Delete</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('invoice_items.destroy', ['invoice' => $invoice->id, 'item' => $item->id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <div class="modal-body">
                                    <p>Are you sure you want to delete this item?</p>
                                    <p><strong>Description:</strong> {{ $item->description }}</p>
                                    <p><strong>Rate:</strong> {{ number_format($item->rate, 0, '.', '.') }}</p>
                                    <p><strong>Qty:</strong> {{ $item->pax }}</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
                <!-- End of Delete Item Modals -->
            </div>
        </div>
    </div>
</x-app-layout>