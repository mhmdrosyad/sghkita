<x-app-layout>
    <div class="title-wrapper pt-30"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <!-- Tombol Tambah Data Customer -->
                <div class="d-flex justify-content-end mb-3">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCustomerModal">Tambah Data Customer</button>
                </div>

                <!-- Tabel Customer dengan Reservasi -->
                <div class="card">
                    <div class="card-header">
                        <h4 class="fw-bolder">Customer Aktif</h4>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif
                        <div class="table-wrapper table-responsive">
                            <table id="customersWithReservationsTable" class="table striped-table">
                                <thead>
                                    <tr>
                                        <th style="width: 5%">No</th>
                                        <th style="width: 15%">Nama</th>
                                        <th style="width: 15%">Instansi</th>
                                        <th style="width: 15%">No. HP 1</th>
                                        <th style="width: 15%">No. HP 2</th>
                                        <th class="text-center" style="width: 10%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($customersWithReservations as $customer)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $customer->name }}</td>
                                        <td>{{ $customer->agency }}</td>
                                        <td>{{ $customer->no_hp }}</td>
                                        <td>{{ $customer->no_hp_alt }}</td>
                                        <td>
                                            <div class="d-flex">
                                                <button class="btn btn-sm btn-warning me-2" data-bs-toggle="modal" data-bs-target="#editCustomerModal{{ $customer->id }}"><i class="lni lni-pencil"></i></button>
                                                <form action="{{ route('customer.destroy', $customer->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"><i class="lni lni-trash-can"></i></button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Modal Edit Customer -->
                                    <div class="modal fade" id="editCustomerModal{{ $customer->id }}" tabindex="-1" aria-labelledby="editCustomerModalLabel{{ $customer->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editCustomerModalLabel{{ $customer->id }}">Edit Data Customer</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('customer.update', $customer->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="name{{ $customer->id }}" class="form-label">Nama</label>
                                                            <input type="text" class="form-control" id="name{{ $customer->id }}" name="name" value="{{ $customer->name }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="agency{{ $customer->id }}" class="form-label">Instansi</label>
                                                            <input type="text" class="form-control" id="agency{{ $customer->id }}" name="agency" value="{{ $customer->agency }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="no_hp{{ $customer->id }}" class="form-label">No. HP 1</label>
                                                            <input type="text" class="form-control" id="no_hp{{ $customer->id }}" name="no_hp" value="{{ $customer->no_hp }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="no_hp_alt{{ $customer->id }}" class="form-label">No. HP 2</label>
                                                            <input type="text" class="form-control" id="no_hp_alt{{ $customer->id }}" name="no_hp_alt" value="{{ $customer->no_hp_alt }}">
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
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Tabel Semua Customer -->
                <div class="card mt-5">
                    <div class="card-header">
                        <h4 class="fw-bolder">Semua Customer</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-wrapper table-responsive">
                            <table id="allCustomersTable" class="table striped-table">
                                <thead>
                                    <tr>
                                        <th style="width: 5%">No</th>
                                        <th style="width: 15%">Nama</th>
                                        <th style="width: 15%">Instansi</th>
                                        <th style="width: 15%">No. HP 1</th>
                                        <th style="width: 15%">No. HP 2</th>
                                        <th class="text-center" style="width: 10%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($allCustomers as $customer)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $customer->name }}</td>
                                        <td>{{ $customer->agency }}</td>
                                        <td>{{ $customer->no_hp }}</td>
                                        <td>{{ $customer->no_hp_alt }}</td>
                                        <td>
                                            <div class="d-flex">
                                                <button class="btn btn-sm btn-warning me-2" data-bs-toggle="modal" data-bs-target="#editCustomerModal{{ $customer->id }}"><i class="lni lni-pencil"></i></button>
                                                <form action="{{ route('customer.destroy', $customer->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"><i class="lni lni-trash-can"></i></button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Modal Edit Customer -->
                                    <div class="modal fade" id="editCustomerModal{{ $customer->id }}" tabindex="-1" aria-labelledby="editCustomerModalLabel{{ $customer->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editCustomerModalLabel{{ $customer->id }}">Edit Data Customer</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('customer.update', $customer->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="name{{ $customer->id }}" class="form-label">Nama</label>
                                                            <input type="text" class="form-control" id="name{{ $customer->id }}" name="name" value="{{ $customer->name }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="agency{{ $customer->id }}" class="form-label">Instansi</label>
                                                            <input type="text" class="form-control" id="agency{{ $customer->id }}" name="agency" value="{{ $customer->agency }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="no_hp{{ $customer->id }}" class="form-label">No. HP 1</label>
                                                            <input type="text" class="form-control" id="no_hp{{ $customer->id }}" name="no_hp" value="{{ $customer->no_hp }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="no_hp_alt{{ $customer->id }}" class="form-label">No. HP 2</label>
                                                            <input type="text" class="form-control" id="no_hp_alt{{ $customer->id }}" name="no_hp_alt" value="{{ $customer->no_hp_alt }}">
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
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Tambah Data Customer -->
        <div class="modal fade" id="addCustomerModal" tabindex="-1" aria-labelledby="addCustomerModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addCustomerModalLabel">Tambah Data Customer</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('customer.store') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="agency" class="form-label">Instansi</label>
                                <input type="text" class="form-control" id="agency" name="agency" required>
                            </div>
                            <div class="mb-3">
                                <label for="no_hp" class="form-label">No. HP 1</label>
                                <input type="text" class="form-control" id="no_hp" name="no_hp" required>
                            </div>
                            <div class="mb-3">
                                <label for="no_hp_alt" class="form-label">No. HP 2</label>
                                <input type="text" class="form-control" id="no_hp_alt" name="no_hp_alt">
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
</x-app-layout>

<script>
    $(document).ready(function() {
        $('#customersWithReservationsTable').DataTable();
        $('#allCustomersTable').DataTable();
    });
</script>