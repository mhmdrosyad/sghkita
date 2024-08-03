<x-app-layout>
    <div class="title-wrapper pt-30">
    </div>
    <div class="container">
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        <div class="card mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="fw-bolder">Active Reservations</h4>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addReservationModal">
                        <i class="ti ti-plus"></i><span class="ms-1">Add Reservation</span>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-wrapper table-responsive">
                    <table id="reservationTableActive" class="table striped-table">
                        <thead class="thead-dark">
                            <tr>
                                <th>Code Order</th>
                                <th>Nama</th>
                                <th>Agency</th>
                                <th>Jenis Reservasi</th>
                                <th>Checkin</th>
                                <th>Sales</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($activeReservations as $reservation)
                            <tr>
                                <td>{{ $reservation->order_code }}</td>
                                <td>{{ $reservation->customer->name }}</td>
                                <td>{{ $reservation->customer->agency }}</td>
                                <td>{{ $reservation->resCategory->name }}</td>
                                <td>{{ $reservation->checkin->format('d-m-Y') }}</td>
                                <td>{{ optional($reservation->sales)->name }}</td>
                                <td>
                                    <div class="d-flex">
                                        <button class="btn btn-sm btn-primary me-2" data-bs-toggle="modal" data-bs-target="#detailReservationModal{{ $reservation->code_order }}">
                                            <i class="lni lni-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-warning me-2" data-bs-toggle="modal" data-bs-target="#editReservationModal{{ $reservation->code_order }}">
                                            <i class="lni lni-pencil"></i>
                                        </button>
                                        <!-- Assuming $reservation is your reservation model instance -->
                                        <form action="{{ route('reservations.destroy', $reservation->order_code) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                            <!-- Detail Reservation Modal -->
                            <div class="modal fade" id="detailReservationModal{{ $reservation->code_order }}" tabindex="-1" aria-labelledby="detailReservationModalLabel{{ $reservation->code_order }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">

                                        <div class="modal-header">
                                            <h5 class="modal-title" id="detailReservationModalLabel{{ $reservation->code_order }}">Detail Reservation</h5>
                                            <button type="button" class="btn-close btn-light" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>

                                        <div class="modal-body">
                                            <div class="container">
                                                <div class="row mb-3">
                                                    <div class="col-sm-4"><strong>Kode Reservasi</strong></div>
                                                    <div class="col-sm-8">{{ $reservation->order_code }}</div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-sm-4"><strong>Nama</strong></div>
                                                    <div class="col-sm-8">{{ $reservation->customer->name }}</div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-sm-4"><strong>No. Hp</strong></div>
                                                    <div class="col-sm-8">{{ $reservation->customer->no_hp }}</div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-sm-4"><strong>Instansi</strong></div>
                                                    <div class="col-sm-8">{{ $reservation->customer->agency }}</div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-sm-4"><strong>Jenis Pesanan</strong></div>
                                                    <div class="col-sm-8">{{ $reservation->resCategory->name }}</div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-sm-4"><strong>Checkin</strong></div>
                                                    <div class="col-sm-8">{{ $reservation->checkin->format('d-m-Y') }}</div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-sm-4"><strong>Checkout</strong></div>
                                                    <div class="col-sm-8">{{ $reservation->checkout->format('d-m-Y') }}</div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-sm-4"><strong>Pax</strong></div>
                                                    <div class="col-sm-8">{{ $reservation->pax }}</div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-sm-4"><strong>Rate / Pax</strong></div>
                                                    <div class="col-sm-8">Rp. {{ number_format($reservation->rate, 0, ',', '.') }}</div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-sm-4"><strong>Sales</strong></div>
                                                    <div class="col-sm-8">{{ $reservation->sales->name }}</div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-sm-4"><strong>Front Office</strong></div>
                                                    <div class="col-sm-8">{{ $reservation->user->name }}</div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-sm-4"><strong>Status</strong></div>
                                                    <div class="col-sm-8">
                                                        @if ($reservation->status == 'active')
                                                        <span class="badge text-bg-success">Active</span>
                                                        @elseif ($reservation->status == 'waiting_list')
                                                        <span class="badge text-bg-danger">Waiting List</span>
                                                        @else
                                                        <span class="badge text-bg-secondary">Unknown</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-sm-4"><strong>Keterangan</strong></div>
                                                    <div class="col-sm-8">{{ $reservation->keterangan }}</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <a href="{{ route('invoices.show', $reservation->invoice->id) }}" class="btn btn-sm btn-warning">
                                                <i class="ti ti-file-dollar me-1"></i> Invoice
                                            </a>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>

                                    </div>
                                </div>
                            </div>



                            <!-- Edit Reservation Modal -->
                            <div class="modal fade" id="editReservationModal{{ $reservation->id }}" tabindex="-1" aria-labelledby="editReservationModalLabel{{ $reservation->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header border-bottom">
                                            <h5 class="modal-title" id="editReservationModalLabel{{ $reservation->id }}">Edit Reservation</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('reservations.update', $reservation->order_code) }}" method="POST">

                                                @csrf
                                                @method('PUT')
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <label for="id_customer{{ $reservation->id }}" class="form-label">Customer</label>
                                                        <select name="id_customer" id="id_customer{{ $reservation->id }}" class="form-select" required>
                                                            <option value="" selected disabled>Select Customer</option>
                                                            @foreach($customers as $customer)
                                                            <option value="{{ $customer->id }}" {{ $reservation->customer_id == $customer->id ? 'selected' : '' }}>{{ $customer->name }} ({{ $customer->agency }})</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="id_rescategory{{ $reservation->id }}" class="form-label">Reservation Type</label>
                                                        <select name="id_rescategory" id="id_rescategory{{ $reservation->id }}" class="form-select" required>
                                                            <option value="" selected disabled>Select Category</option>
                                                            @foreach($resCategories as $resCategory)
                                                            <option value="{{ $resCategory->id }}" {{ $reservation->id_rescategory == $resCategory->id ? 'selected' : '' }}>{{ $resCategory->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <label for="checkin{{ $reservation->id }}" class="form-label">Checkin</label>
                                                        <input type="date" name="checkin" id="checkin{{ $reservation->id }}" class="form-control" value="{{ $reservation->checkin->format('Y-m-d') }}" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="checkout{{ $reservation->id }}" class="form-label">Checkout</label>
                                                        <input type="date" name="checkout" id="checkout{{ $reservation->id }}" class="form-control" value="{{ $reservation->checkout->format('Y-m-d') }}" required>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-3">
                                                        <label for="pax{{ $reservation->id }}" class="form-label">Pax</label>
                                                        <input type="number" name="pax" id="pax{{ $reservation->id }}" class="form-control" value="{{ $reservation->pax }}" required>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="rate{{ $reservation->id }}" class="form-label">Price / Pax</label>
                                                        <input type="number" name="rate" id="rate{{ $reservation->id }}" class="form-control" step="0.01" value="{{ $reservation->rate }}" required>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <label for="id_sp{{ $reservation->id }}" class="form-label">Sales</label>
                                                        <select name="id_sp" id="id_sp{{ $reservation->id }}" class="form-select" required>
                                                            <option value="" selected disabled>Select Sales</option>
                                                            @foreach($sales as $sp)
                                                            <option value="{{ $sp->id }}" {{ $reservation->id_sp == $sp->id ? 'selected' : '' }}>{{ $sp->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Waiting List Reservations -->
        <div class="card mb-4">
            <div class="card-header">
                <h4 class="fw-bolder">Waiting List Reservations</h4>
            </div>
            <div class="card-body">
                <div class="table-wrapper table-responsive">
                    <table id="reservationTableWaiting" class="table striped-table">
                        <thead class="thead-dark">
                            <tr>
                                <th>Code Order</th>
                                <th>Nama</th>
                                <th>Agency</th>
                                <th>Jenis Reservasi</th>
                                <th>Checkin</th>
                                <th>Sales</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($waitingListReservations as $reservation)
                            <tr>
                                <td>{{ $reservation->order_code }}</td>
                                <td>{{ $reservation->customer->name }}</td>
                                <td>{{ $reservation->customer->agency }}</td>
                                <td>{{ $reservation->resCategory->name }}</td>
                                <td>{{ $reservation->checkin->format('d-m-Y') }}</td>
                                <td>{{ $reservation->sales->name }}</td>
                                <td>
                                    <div class="d-flex">
                                        <button class="btn btn-sm btn-primary me-2" data-bs-toggle="modal" data-bs-target="#detailReservationModal{{ $reservation->order_code }}">
                                            <i class="lni lni-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-warning me-2" data-bs-toggle="modal" data-bs-target="#editReservationModal{{ $reservation->order_code }}">
                                            <i class="lni lni-pencil"></i>
                                        </button>
                                        <form action="{{ route('reservations.destroy', $reservation->order_code) }}" method="POST" class="mb-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </div>

                                </td>
                            </tr>
                            <!-- Detail Reservation Modal -->
                            <div class="modal fade" id="detailReservationModal{{ $reservation->order_code }}" tabindex="-1" aria-labelledby="detailReservationModalLabel{{ $reservation->order_code }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">

                                        <div class="modal-header ">
                                            <h5 class="modal-title" id="detailReservationModalLabel{{ $reservation->order_code }}">
                                                Detail Reservation
                                            </h5>
                                            <button type="button" class="btn-close btn-light" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>

                                        <div class="modal-body">
                                            <div class="container">
                                                <div class="row mb-3">
                                                    <div class="col-md-4"><strong>Kode Reservasi</strong></div>
                                                    <div class="col-md-8">{{ $reservation->order_code }}</div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-4"><strong>Nama</strong></div>
                                                    <div class="col-md-8">{{ $reservation->customer->name }}</div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-4"><strong>No. Hp</strong></div>
                                                    <div class="col-md-8">{{ $reservation->customer->no_hp }}</div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-4"><strong>Instansi</strong></div>
                                                    <div class="col-md-8">{{ $reservation->customer->agency }}</div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-4"><strong>Jenis Pesanan</strong></div>
                                                    <div class="col-md-8">{{ $reservation->resCategory->name }}</div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-4"><strong>Checkin</strong></div>
                                                    <div class="col-md-8">{{ $reservation->checkin->format('d-m-Y') }}</div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-4"><strong>Checkout</strong></div>
                                                    <div class="col-md-8">{{ $reservation->checkout->format('d-m-Y') }}</div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-4"><strong>Pax</strong></div>
                                                    <div class="col-md-8">{{ $reservation->pax }}</div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-4"><strong>Rate / Pax</strong></div>
                                                    <div class="col-md-8">Rp. {{ number_format($reservation->rate, 0, ',', '.') }}</div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-4"><strong>Sales</strong></div>
                                                    <div class="col-md-8">{{ $reservation->sales->name }}</div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-4"><strong>Front Office</strong></div>
                                                    <div class="col-md-8">{{ $reservation->user->name }}</div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-4"><strong>Status</strong></div>
                                                    <div class="col-md-8">
                                                        @if ($reservation->status == 'active')
                                                        <span class="badge text-bg-success">Active</span>
                                                        @elseif ($reservation->status == 'waiting_list')
                                                        <span class="badge text-bg-danger">Waiting List</span>
                                                        @else
                                                        <span class="badge text-bg-secondary">Unknown</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-4"><strong>Keterangan</strong></div>
                                                    <div class="col-md-8">{{ $reservation->keterangan }}</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <a href="{{ route('invoices.show', $reservation->invoice->id) }}" class="btn btn-sm btn-warning">
                                                <i class="ti ti-file-dollar me-1"></i> Invoice
                                            </a>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <!-- Edit Reservation Modal -->
                            <div class="modal fade" id="editReservationModal{{ $reservation->order_code }}" tabindex="-1" aria-labelledby="editReservationModalLabel{{ $reservation->order_code }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header border-bottom">
                                            <h5 class="modal-title" id="editReservationModalLabel{{ $reservation->order_code }}">Edit Reservation</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('reservations.update', $reservation->order_code) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <label for="id_customer{{ $reservation->id }}" class="form-label">Customer</label>
                                                        <select name="id_customer" id="id_customer{{ $reservation->id }}" class="form-select" required>
                                                            <option value="" selected disabled>Select Customer</option>
                                                            @foreach($customers as $customer)
                                                            <option value="{{ $customer->id }}" {{ $reservation->customer_id == $customer->id ? 'selected' : '' }}>{{ $customer->name }} ({{ $customer->agency }})</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="id_rescategory{{ $reservation->id }}" class="form-label">Reservation Type</label>
                                                        <select name="id_rescategory" id="id_rescategory{{ $reservation->id }}" class="form-select" required>
                                                            <option value="" selected disabled>Select Category</option>
                                                            @foreach($resCategories as $resCategory)
                                                            <option value="{{ $resCategory->id }}" {{ $reservation->id_rescategory == $resCategory->id ? 'selected' : '' }}>{{ $resCategory->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <label for="checkin{{ $reservation->id }}" class="form-label">Checkin</label>
                                                        <input type="date" name="checkin" id="checkin{{ $reservation->id }}" class="form-control" value="{{ $reservation->checkin->format('Y-m-d') }}" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="checkout{{ $reservation->id }}" class="form-label">Checkout</label>
                                                        <input type="date" name="checkout" id="checkout{{ $reservation->id }}" class="form-control" value="{{ $reservation->checkout->format('Y-m-d') }}" required>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-3">
                                                        <label for="pax{{ $reservation->id }}" class="form-label">Pax</label>
                                                        <input type="number" name="pax" id="pax{{ $reservation->id }}" class="form-control" value="{{ $reservation->pax }}" required>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="rate{{ $reservation->id }}" class="form-label">Price / Pax</label>
                                                        <input type="number" name="rate" id="rate{{ $reservation->id }}" class="form-control" step="0.01" value="{{ $reservation->rate }}" required>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <label for="id_sp{{ $reservation->id }}" class="form-label">Sales</label>
                                                        <select name="id_sp" id="id_sp{{ $reservation->id }}" class="form-select" required>
                                                            <option value="" selected disabled>Select Sales</option>
                                                            @foreach($sales as $sp)
                                                            <option value="{{ $sp->id }}" {{ $reservation->id_sp == $sp->id ? 'selected' : '' }}>{{ $sp->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Reservation Modal -->
    <div class="modal fade" id="addReservationModal" tabindex="-1" aria-labelledby="addReservationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header border-bottom">
                    <h5 class="modal-title" id="addReservationModalLabel">Add Reservation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('reservations.store') }}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="customer_id" class="form-label">Customer</label>
                                <select name="customer_id" id="customer_id" class="form-select" required>
                                    <option value="" selected disabled>Select Customer</option>
                                    @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->name }} ({{ $customer->agency }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="res_category_id" class="form-label">Reservation Type</label>
                                <select name="res_category_id" id="res_category_id" class="form-select" required>
                                    <option value="" selected disabled>Select Category</option>
                                    @foreach($resCategories as $resCategory)
                                    <option value="{{ $resCategory->id_rescategory }}">{{ $resCategory->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="checkin" class="form-label">Checkin</label>
                                <input type="date" name="checkin" id="checkin" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label for="checkout" class="form-label">Checkout</label>
                                <input type="date" name="checkout" id="checkout" class="form-control" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label for="pax" class="form-label">Pax</label>
                                <input type="number" name="pax" id="pax" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label for="rate" class="form-label">Price</label>
                                <input type="number" name="rate" id="rate" class="form-control" step="0.01" required>
                            </div>
                            <div class="col-md-5">
                                <label for="id_sp" class="form-label">Sales</label>
                                <select name="id_sp" id="id_sp" class="form-select">
                                    <option value="" selected disabled>Select Sales</option>
                                    @foreach($sales as $sp)
                                    <option value="{{ $sp->id }}">{{ $sp->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add Reservation</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <x-slot name="scripts">
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                $('#reservationTableActive, #reservationTableWaiting').DataTable();

                document.querySelectorAll('.delete-reservation').forEach(button => {
                    button.addEventListener('click', function() {
                        const reservationId = this.getAttribute('data-reservation-id');
                        if (confirm('Are you sure you want to delete this reservation?')) {
                            document.getElementById(`delete-form-${reservationId}`).submit();
                        }
                    });
                });
            });
        </script>
    </x-slot>
</x-app-layout>