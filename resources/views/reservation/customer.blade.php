<x-app-layout>
    <div class="title-wrapper pt-30"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex justify-content-end mb-3">
                    <!-- Tombol Import Data Customer -->
                    <button class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#importCustomerModal">
                        <!-- SVG untuk ikon download -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                            <path d="M8 0a.5.5 0 0 1 .5.5V9.707L12.854 5.854a.5.5 0 1 1 .707.707L8.707 10.5a.5.5 0 0 1-.707 0L4.439 6.561a.5.5 0 1 1 .707-.707L8 9.707V.5A.5.5 0 0 1 8 0z" />
                            <path d="M0 13.5a.5.5 0 0 1 .5-.5h15a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H.5a.5.5 0 0 1-.5-.5v-1z" />
                        </svg>
                        Import
                    </button>

                    <!-- Tombol Tambah Data Customer -->
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCustomerModal">
                        <!-- SVG untuk ikon tambah pengguna -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-plus" viewBox="0 0 16 16">
                            <path d="M14 15v-1a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v1H1v1h1v1h1v-1h10v1h1v-1h1v-1h-1z" />
                            <path d="M8 8a3 3 0 1 1 0-6 3 3 0 0 1 0 6zm-2 6a5.978 5.978 0 0 1-3.5-1.035A5.978 5.978 0 0 1 0 11c0-2.486 2.014-4.5 4.5-4.5S9 8.514 9 11a5.978 5.978 0 0 1-3 1z" />
                            <path d="M14.5 8a.5.5 0 0 1-.5-.5V5.707L11.854 8.854a.5.5 0 0 1-.707-.707L13.293 5.5H10a.5.5 0 0 1-.5-.5V4a.5.5 0 0 1 .5-.5h3.293L11.146.854a.5.5 0 0 1 .707-.707L15 3.293V0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3.293L15.146 2.854a.5.5 0 0 1-.707.707L12.707 1.5H14a.5.5 0 0 1 .5.5v2.707L14.854 6.854a.5.5 0 0 1-.707.707L12.293 5.5H15a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-.5.5z" />
                        </svg>
                        Tambah
                    </button>
                </div>

                <!-- Modal Import Customer -->
                <div class="modal fade" id="importCustomerModal" tabindex="-1" aria-labelledby="importCustomerModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="importCustomerModalLabel">Import Data Customer</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('customer.import') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="file" class="form-label">Pilih File Excel</label>
                                        <input class="form-control" type="file" name="file" required>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-success">Import</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
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
                                        <th style="width: 15%">Status</th>
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
                                            <span class="badge 
                                                @if($customer->status == 'Customer Aktif')
                                                    bg-success
                                                @elseif($customer->status == 'Calon Customer')
                                                    bg-warning text-dark
                                                @endif
                                                ">
                                                {{ $customer->status }}
                                            </span>
                                        </td>
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