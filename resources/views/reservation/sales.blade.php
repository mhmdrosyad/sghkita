<x-app-layout>
    <div class="title-wrapper pt-30">
    </div>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="fw-bolder">Sales</h4>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                    <i class="ti ti-plus"></i><span class="ms-1">Tambah Sales</span>
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
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <div class="table-wrapper table-responsive">
                <table class="table striped-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>NIK</th>
                            <th>Alamat Domisili</th>
                            <th>Alamat KTP</th>
                            <th>No. HP 1</th>
                            <th>No. HP 2</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sales as $sale)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $sale->name }}</td>
                            <td>{{ $sale->nik }}</td>
                            <td>{{ $sale->address }}</td>
                            <td>{{ $sale->ktp_address }}</td>
                            <td>{{ $sale->no_hp }}</td>
                            <td>{{ $sale->no_hp_alt }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center">
                                    <button class="btn btn-sm btn-primary me-1" data-bs-toggle="modal" data-bs-target="#ktpModal{{ $sale->id }}"><i class="ti ti-eye"></i><span class="ms-1">KTP</span></button>
                                    <button class="btn btn-sm btn-warning me-1" data-bs-toggle="modal" data-bs-target="#editModal{{ $sale->id }}"><i class="lni lni-pencil"></i></button>
                                    <form action="{{ route('sales.destroy', $sale->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"><i class="lni lni-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <div class="modal fade" id="ktpModal{{ $sale->id }}" tabindex="-1" aria-labelledby="ktpModalLabel{{ $sale->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="ktpModalLabel{{ $sale->id }}">Identitas Sales</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col">
                                                <img src="{{ asset('storage/foto_ktp/' . $sale->foto_ktp) }}" alt="Foto KTP" class="img-fluid">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal Edit -->
                        <div class="modal fade" id="editModal{{ $sale->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $sale->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModalLabel{{ $sale->id }}">Edit Sales</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('sales.update', $sale->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="edit_name{{ $sale->id }}" class="form-label">Nama</label>
                                                        <input type="text" class="form-control" id="edit_name{{ $sale->id }}" name="name" value="{{ $sale->name }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="edit_nik{{ $sale->id }}" class="form-label">NIK</label>
                                                        <input type="text" class="form-control" id="edit_nik{{ $sale->id }}" name="nik" value="{{ $sale->nik }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="edit_no_hp{{ $sale->id }}" class="form-label">No. HP
                                                            1</label>
                                                        <input type="text" class="form-control" id="edit_no_hp{{ $sale->id }}" name="no_hp" value="{{ $sale->no_hp }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="edit_no_hp_alt{{ $sale->id }}" class="form-label">No. HP
                                                            2</label>
                                                        <input type="text" class="form-control" id="edit_no_hp_alt{{ $sale->id }}" name="no_hp_alt" value="{{ $sale->no_hp_alt }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="edit_address{{ $sale->id }}" class="form-label">Alamat</label>
                                                        <textarea class="form-control" id="edit_address{{ $sale->id }}" name="address" required>{{ $sale->address }}</textarea>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="edit_address_ktp{{ $sale->id }}" class="form-label">Alamat KTP</label>
                                                        <textarea class="form-control" id="edit_address_ktp{{ $sale->id }}" name="address_ktp" required>{{ $sale->ktp_address }}</textarea>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="edit_foto_ktp{{ $sale->id }}" class="form-label">Ganti
                                                            Foto
                                                            KTP</label>
                                                        <input type="file" class="form-control" id="create_foto_ktp" name="foto_ktp" accept="image/*">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Identitas</label>
                                                        <img src="{{ asset('storage/foto_ktp/' . $sale->foto_ktp) }}" alt="Foto KTP" class="img-fluid">
                                                    </div>
                                                </div>
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

        <!-- Modal Create -->
        <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header border-bottom">
                        <h5 class="modal-title" id="createModalLabel">Tambah Sales</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('sales.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="create_name" class="form-label">Nama</label>
                                        <input type="text" class="form-control" id="create_name" name="name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="create_nik" class="form-label">NIK</label>
                                        <input type="text" class="form-control" id="create_nik" name="nik" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="create_no_hp" class="form-label">No.HP</label>
                                        <input type="text" class="form-control" id="create_no_hp" name="no_hp" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="create_no_hp_alt" class="form-label">No.HP 2 (Jika Ada)</label>
                                        <input type="text" class="form-control" id="create_no_hp_alt" name="no_hp_alt">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="create_address" class="form-label">Alamat</label>
                                        <textarea class="form-control" id="create_address" name="address" required></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="create_ktp_address" class="form-label">Alamat KTP</label>
                                        <textarea class="form-control" id="create_ktp_address" name="ktp_address" required></textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label for="create_foto_ktp" class="form-label">Foto KTP</label>
                                        <input type="file" class="form-control" id="create_foto_ktp" name="foto_ktp" accept="image/*">
                                    </div>
                                </div>
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
        <x-slot name="scripts">
            <script>
                $(document).ready(function() {
                    $('#salesTable').DataTable();
                });
            </script>
        </x-slot>
</x-app-layout>