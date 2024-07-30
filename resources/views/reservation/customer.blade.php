<x-app-layout>
    <div class="title-wrapper pt-30">
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="fw-bolder">Customer</h4>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                                <i class="ti ti-plus"></i><span class="ms-1">Tambah Customer</span>
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
                            <table class="table striped-table">
                                <thead>
                                    <tr>
                                        <th style="width: 5%">No</th>
                                        <th style="width: 15%">Nama</th>
                                        <th style="width: 15%">Instansi</th>
                                        <th style="width: 15%">No. HP 1</th>
                                        <th style="width: 15%">No. HP 2</th>
                                        <th style="width: 10%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($customers as $customer)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $customer->name }}</td>
                                        <td>{{ $customer->agency }}</td>
                                        <td>{{ $customer->no_hp }}</td>
                                        <td>{{ $customer->no_hp_alt }}</td>
                                        <td>
                                            <div class="d-flex">
                                                <button class="btn btn-sm btn-warning me-2" data-bs-toggle="modal" data-bs-target="#editModal{{ $customer->id }}"><i class="lni lni-pencil"></i></button>
                                                <form action="{{ route('customer.destroy', $customer->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"><i class="lni lni-trash-can"></i></button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Modal Edit Customer -->
                                    <div class="modal fade" id="editModal{{ $customer->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $customer->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header border-bottom">
                                                    <h5 class="modal-title" id="editModalLabel{{ $customer->id }}">Edit
                                                        Customer</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('customer.update', $customer->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="edit_name{{ $customer->id }}" class="form-label">Nama</label>
                                                            <input type="text" class="form-control" id="edit_name{{ $customer->id }}" name="name" value="{{ $customer->name }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="edit_agency{{ $customer->id }}" class="form-label">Instansi</label>
                                                            <input type="text" class="form-control" id="edit_agency{{ $customer->id }}" name="agency" value="{{ $customer->agency }}">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="edit_no_hp{{ $customer->id }}" class="form-label">No. HP 1</label>
                                                            <input type="text" class="form-control" id="edit_no_hp{{ $customer->id }}" name="no_hp" value="{{ $customer->no_hp }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="edit_no_hp_alt{{ $customer->id }}" class="form-label">No. HP 2</label>
                                                            <input type="text" class="form-control" id="edit_no_hp_alt{{ $customer->id }}" name="no_hp_alt" value="{{ $customer->no_hp_alt }}">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Save
                                                            changes</button>
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
    </div>

    <!-- Modal Create Customer -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border-bottom">
                    <h5 class="modal-title" id="createModalLabel">Tambah Customer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('customer.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="create_name" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="create_name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="create_agency" class="form-label">Instansi</label>
                            <input type="text" class="form-control" id="create_agency" name="agency">
                        </div>
                        <div class="mb-3">
                            <label for="create_no_hp" class="form-label">No. HP 1</label>
                            <input type="text" class="form-control" id="create_no_hp" name="no_hp" required>
                        </div>
                        <div class="mb-3">
                            <label for="create_no_hp_alt" class="form-label">No. HP 2</label>
                            <input type="text" class="form-control" id="create_no_hp_alt" name="no_hp_alt">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <x-slot name="scripts">
        <script>
            $(document).ready(function() {
                $('#customersTable').DataTable();
            });
        </script>
    </x-slot>
</x-app-layout>