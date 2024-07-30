<x-app-layout>
    <div class="title-wrapper pt-30">
    </div>
    <div class="container">
        <!-- Active Reservations -->
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
                <div class="table-wrapper table-responsive">
                    <table id="reservationTableActive" class="table striped-table">
                        <thead class="thead-dark">
                            <tr>
                                <th>Order Code</th>
                                <th>Name</th>
                                <th>Institution</th>
                                <th>Order Type</th>
                                <th>Pax</th>
                                <th>Checkin</th>
                                <th>Sales</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($activeReservations as $reservation)
                            <tr>
                                <td>{{ $reservation->kode_order }}</td>
                                <td>{{ $reservation->customer->nama }}</td>
                                <td>{{ $reservation->customer->instansi }}</td>
                                <td>{{ $reservation->resCategory->name }}</td>
                                <td>{{ $reservation->pax }}</td>
                                <td>{{ $reservation->checkin->format('d-m-Y') }}</td>
                                <td>{{ $reservation->sales->nama }}</td>
                                <td>
                                    <div class="d-flex">
                                        <button class="btn btn-sm btn-primary me-2" data-bs-toggle="modal" data-bs-target="#detailReservationModal{{ $reservation->id }}">
                                            <i class="lni lni-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-warning me-2" data-bs-toggle="modal" data-bs-target="#editReservationModal{{ $reservation->id }}">
                                            <i class="lni lni-pencil"></i>
                                        </button>
                                        <form id="delete-form-{{ $reservation->id }}" action="{{ route('reservations.destroy', $reservation->id) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-danger delete-reservation" data-reservation-id="{{ $reservation->id }}">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            <!-- Detail Reservation Modal -->
                            <!-- Detail Reservation Modal -->
                            <div class="modal fade" id="detailReservationModal{{ $reservation->id }}" tabindex="-1" aria-labelledby="detailReservationModalLabel{{ $reservation->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">

                                        <div class="modal-header border-bottom">
                                            <h5 class="modal-title" id="detailReservationModalLabel{{ $reservation->id }}">
                                                Detail Reservation</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="container">
                                                <div class="row py-2">
                                                    <div class="col-sm-2"><strong>Kode Reservasi</strong></div>
                                                    <div class="col-sm-1">:</div>
                                                    <div class="col-sm-9">{{ $reservation->kode_order }}</div>
                                                </div>
                                                <div class="row py-2">
                                                    <div class="col-sm-2"><strong>Nama</strong></div>
                                                    <div class="col-sm-1">:</div>
                                                    <div class="col-sm-9">{{ $reservation->customer->nama }}</div>
                                                </div>
                                                <div class="row py-2">
                                                    <div class="col-sm-2"><strong>No. Hp</strong></div>
                                                    <div class="col-sm-1">:</div>
                                                    <div class="col-sm-9">{{ $reservation->customer->no_hp }}</div>
                                                </div>
                                                <div class="row py-2">
                                                    <div class="col-sm-2"><strong>Instansi</strong></div>
                                                    <div class="col-sm-1">:</div>
                                                    <div class="col-sm-9">{{ $reservation->customer->instansi }}</div>
                                                </div>
                                                <div class="row py-2">
                                                    <div class="col-sm-2"><strong>Jenis Pesanan</strong></div>
                                                    <div class="col-sm-1">:</div>
                                                    <div class="col-sm-9">{{ $reservation->resCategory->name }}</div>
                                                </div>
                                                <div class="row py-2">
                                                    <div class="col-sm-2"><strong>Checkin</strong></div>
                                                    <div class="col-sm-1">:</div>
                                                    <div class="col-sm-9">{{ $reservation->checkin->format('d-m-Y') }}</div>
                                                </div>
                                                <div class="row py-2">
                                                    <div class="col-sm-2"><strong>Checkout</strong></div>
                                                    <div class="col-sm-1">:</div>
                                                    <div class="col-sm-9">{{ $reservation->checkout->format('d-m-Y') }}</div>
                                                </div>
                                                <div class="row py-2">
                                                    <div class="col-sm-2"><strong>Pax</strong></div>
                                                    <div class="col-sm-1">:</div>
                                                    <div class="col-sm-9">{{ $reservation->pax }}</div>
                                                </div>
                                                <div class="row py-2">
                                                    <div class="col-sm-2"><strong>Harga / Pax</strong></div>
                                                    <div class="col-sm-1">:</div>
                                                    <div class="col-sm-9">Rp. {{ number_format($reservation->harga, 0, ',', '.') }}</div>
                                                </div>
                                                <div class="row py-2">
                                                    <div class="col-sm-2"><strong>Sales</strong></div>
                                                    <div class="col-sm-1">:</div>
                                                    <div class="col-sm-9">{{ $reservation->sales->nama }}</div>
                                                </div>
                                                <div class="row py-2">
                                                    <div class="col-sm-2"><strong>Front Office</strong></div>
                                                    <div class="col-sm-1">:</div>
                                                    <div class="col-sm-9">{{ $reservation->user->name }}</div>
                                                </div>
                                                <div class="row py-2">
                                                    <div class="col-sm-2"><strong>Status</strong></div>
                                                    <div class="col-sm-1">:</div>
                                                    <div class="col-sm-9">
                                                        <span class="badge text-bg-success">{{ ($reservation->status == 'Active') ? 'Active' : 'Inactive' }}</span>
                                                    </div>
                                                </div>
                                                <div class="row py-2">
                                                    <div class="col-sm-2"><strong>Keterangan</strong></div>
                                                    <div class="col-sm-1">:</div>
                                                    <div class="col-sm-9">{{ $reservation->keterangan }}</div>
                                                </div>
                                                <a href="{{ route('invoices.show', $reservation->invoice->id) }}" class="mt-3 btn btn-primary">
                                                    <i class="ti ti-file-dollar me-1"></i>Invoice
                                                </a>
                                            </div>
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
                                            <form action="{{ route('reservations.update', $reservation->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <label for="id_customer{{ $reservation->id }}" class="form-label">Customer</label>
                                                        <select name="id_customer" id="id_customer{{ $reservation->id }}" class="form-select" required>
                                                            <option value="" selected disabled>Select Customer</option>
                                                            @foreach($customers as $customer)
                                                            <option value="{{ $customer->id }}" {{ $reservation->customer_id == $customer->id ? 'selected' : '' }}>{{ $customer->nama }} ({{ $customer->instansi }})</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="id_rescategory{{ $reservation->id }}" class="form-label">Reservation Type</label>
                                                        <select name="id_rescategory" id="id_rescategory{{ $reservation->id }}" class="form-select" required>
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
                                                        <label for="harga{{ $reservation->id }}" class="form-label">Price / Pax</label>
                                                        <input type="number" name="harga" id="harga{{ $reservation->id }}" class="form-control" step="0.01" value="{{ $reservation->harga }}" required>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <label for="id_sp{{ $reservation->id }}" class="form-label">Sales</label>
                                                        <select name="id_sp" id="id_sp{{ $reservation->id }}" class="form-select" required>
                                                            <option value="" selected disabled>Select Sales</option>
                                                            @foreach($sales as $sp)
                                                            <option value="{{ $sp->id }}" {{ $reservation->id_sp == $sp->id ? 'selected' : '' }}>{{ $sp->nama }}</option>
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
                                <th>Order Code</th>
                                <th>Name</th>
                                <th>Institution</th>
                                <th>Order Type</th>
                                <th>Pax</th>
                                <th>Harga</th>
                                <th>Checkin</th>
                                <th>Sales</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($waitingListReservations as $reservation)
                            <tr>
                                <td>{{ $reservation->kode_order }}</td>
                                <td>{{ $reservation->customer->nama }}</td>
                                <td>{{ $reservation->customer->instansi }}</td>
                                <td>{{ $reservation->resCategory->name }}</td>
                                <td>{{ $reservation->pax }}</td>
                                <td>{{ $reservation->harga }}</td>
                                <td>{{ $reservation->checkin->format('d-m-Y') }}</td>
                                <td>{{ $reservation->sales->nama }}</td>
                                <td>
                                    <div class="d-flex">
                                        <button class="btn btn-sm btn-primary me-2" data-bs-toggle="modal" data-bs-target="#detailReservationModal{{ $reservation->id }}">
                                            <i class="lni lni-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-warning me-2" data-bs-toggle="modal" data-bs-target="#editReservationModal{{ $reservation->id }}">
                                            <i class="lni lni-pencil"></i>
                                        </button>
                                        <form id="delete-form-{{ $reservation->id }}" action="{{ route('reservations.destroy', $reservation->id) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-danger delete-reservation" data-reservation-id="{{ $reservation->id }}">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            <!-- Detail Reservation Modal -->
                            <!-- Detail Reservation Modal -->
                            <div class="modal fade" id="detailReservationModal{{ $reservation->id }}" tabindex="-1" aria-labelledby="detailReservationModalLabel{{ $reservation->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">

                                        <div class="modal-header border-bottom">
                                            <h5 class="modal-title" id="detailReservationModalLabel{{ $reservation->id }}">
                                                Detail Reservation</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="container">
                                                <div class="row py-2">
                                                    <div class="col-sm-2"><strong>Kode Reservasi</strong></div>
                                                    <div class="col-sm-1">:</div>
                                                    <div class="col-sm-9">{{ $reservation->kode_order }}</div>
                                                </div>
                                                <div class="row py-2">
                                                    <div class="col-sm-2"><strong>Nama</strong></div>
                                                    <div class="col-sm-1">:</div>
                                                    <div class="col-sm-9">{{ $reservation->customer->nama }}</div>
                                                </div>
                                                <div class="row py-2">
                                                    <div class="col-sm-2"><strong>No. Hp</strong></div>
                                                    <div class="col-sm-1">:</div>
                                                    <div class="col-sm-9">{{ $reservation->customer->no_hp }}</div>
                                                </div>
                                                <div class="row py-2">
                                                    <div class="col-sm-2"><strong>Instansi</strong></div>
                                                    <div class="col-sm-1">:</div>
                                                    <div class="col-sm-9">{{ $reservation->customer->instansi }}</div>
                                                </div>
                                                <div class="row py-2">
                                                    <div class="col-sm-2"><strong>Jenis Pesanan</strong></div>
                                                    <div class="col-sm-1">:</div>
                                                    <div class="col-sm-9">{{ $reservation->resCategory->name }}</div>
                                                </div>
                                                <div class="row py-2">
                                                    <div class="col-sm-2"><strong>Checkin</strong></div>
                                                    <div class="col-sm-1">:</div>
                                                    <div class="col-sm-9">{{ $reservation->checkin->format('d-m-Y') }}</div>
                                                </div>
                                                <div class="row py-2">
                                                    <div class="col-sm-2"><strong>Checkout</strong></div>
                                                    <div class="col-sm-1">:</div>
                                                    <div class="col-sm-9">{{ $reservation->checkout->format('d-m-Y') }}</div>
                                                </div>
                                                <div class="row py-2">
                                                    <div class="col-sm-2"><strong>Pax</strong></div>
                                                    <div class="col-sm-1">:</div>
                                                    <div class="col-sm-9">{{ $reservation->pax }}</div>
                                                </div>
                                                <div class="row py-2">
                                                    <div class="col-sm-2"><strong>Harga / Pax</strong></div>
                                                    <div class="col-sm-1">:</div>
                                                    <div class="col-sm-9">Rp. {{ number_format($reservation->harga, 0, ',', '.') }}</div>
                                                </div>
                                                <div class="row py-2">
                                                    <div class="col-sm-2"><strong>Sales</strong></div>
                                                    <div class="col-sm-1">:</div>
                                                    <div class="col-sm-9">{{ $reservation->sales->nama }}</div>
                                                </div>
                                                <div class="row py-2">
                                                    <div class="col-sm-2"><strong>Front Office</strong></div>
                                                    <div class="col-sm-1">:</div>
                                                    <div class="col-sm-9">{{ $reservation->user->name }}</div>
                                                </div>
                                                <div class="row py-2">
                                                    <div class="col-sm-2"><strong>Status</strong></div>
                                                    <div class="col-sm-1">:</div>
                                                    <div class="col-sm-9">
                                                        <span class="badge text-bg-success">{{ ($reservation->status == 'Active') ? 'Active' : 'Inactive' }}</span>
                                                    </div>
                                                </div>
                                                <div class="row py-2">
                                                    <div class="col-sm-2"><strong>Keterangan</strong></div>
                                                    <div class="col-sm-1">:</div>
                                                    <div class="col-sm-9">{{ $reservation->keterangan }}</div>
                                                </div>
                                                <button href=" " class=" mt-3 btn btn-primary">
                                                    <i class="ti ti-file-dollar me-1"></i>Invoice
                                                </button>

                                            </div>
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
                                            <form action="{{ route('reservations.update', $reservation->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <label for="id_customer{{ $reservation->id }}" class="form-label">Customer</label>
                                                        <select name="id_customer" id="id_customer{{ $reservation->id }}" class="form-select" required>
                                                            <option value="" selected disabled>Select Customer</option>
                                                            @foreach($customers as $customer)
                                                            <option value="{{ $customer->id }}" {{ $reservation->customer_id == $customer->id ? 'selected' : '' }}>{{ $customer->nama }} ({{ $customer->instansi }})</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="id_rescategory{{ $reservation->id }}" class="form-label">Reservation Type</label>
                                                        <select name="id_rescategory" id="id_rescategory{{ $reservation->id }}" class="form-select" required>
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
                                                        <label for="harga{{ $reservation->id }}" class="form-label">Price / Pax</label>
                                                        <input type="number" name="harga" id="harga{{ $reservation->id }}" class="form-control" step="0.01" value="{{ $reservation->harga }}" required>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <label for="id_sp{{ $reservation->id }}" class="form-label">Sales</label>
                                                        <select name="id_sp" id="id_sp{{ $reservation->id }}" class="form-select" required>
                                                            <option value="" selected disabled>Select Sales</option>
                                                            @foreach($sales as $sp)
                                                            <option value="{{ $sp->id }}" {{ $reservation->id_sp == $sp->id ? 'selected' : '' }}>{{ $sp->nama }}</option>
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
                                <label for="id_customer" class="form-label">Customer</label>
                                <select name="id_customer" id="id_customer" class="form-select" required>
                                    <option value="" selected disabled>Select Customer</option>
                                    @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->nama }} ({{ $customer->instansi }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="id_rescategory" class="form-label">Reservation Type</label>
                                <select name="id_rescategory" id="id_rescategory" class="form-select" required>
                                    @foreach($resCategories as $resCategory)
                                    <option value="{{ $resCategory->id }}">{{ $resCategory->name }}</option>
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
                                <label for="harga" class="form-label">Price / Pax</label>
                                <input type="number" name="harga" id="harga" class="form-control" step="0.01" required>
                            </div>
                            <div class="col-md-5">
                                <label for="id_sp" class="form-label">Sales</label>
                                <select name="id_sp" id="id_sp" class="form-select" required>
                                    <option value="" selected disabled>Select Sales</option>
                                    @foreach($sales as $sp)
                                    <option value="{{ $sp->id }}">{{ $sp->nama }}</option>
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