<x-app-layout>
    <div class="title-wrapper pt-30">
    </div>
    <div class="row">
        <div class="col">
            <div class="card-style mb-30">
                <div class="title d-flex flex-wrap align-items-center justify-content-between mb-3">
                    <div class="left">
                        <h2>
                            Daftar Jenis Transaksi
                        </h2>
                    </div>
                    <div class="right">
                        <button type="button" class="main-btn success-btn btn-hover" data-bs-toggle="modal"
                            data-bs-target="#addModal"><i class="lni lni-plus"></i>Import</button>
                        <a href="{{route('category.add')}}" class="main-btn primary-btn btn-hover"><i
                                class="lni lni-plus"></i>Tambah Jenis Transaksi</a>
                    </div>
                </div>
                @if ($errors->any())
                <div>
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                @if (session('success'))
                <div class="alert-box success-alert alert-dismissible fade show" role="alert"">
                    <div class=" alert">
                    <p class="text-medium">
                        {{ session('success') }}
                    </p>
                </div>
            </div>
            @endif
            <div class="table-wrapper table-responsive">
                <table class="table striped-table">
                    <thead>
                        <tr>
                            <th>
                                <h6>Kode</h6>
                            </th>
                            <th>
                                <h6>Nama</h6>
                            </th>
                            <th>
                                <h6>Jenis</h6>
                            </th>
                            <th>
                                <h6>Debit</h6>
                            </th>
                            <th>
                                <h6>Kredit</h6>
                            </th>
                            <th>
                                <h6>Aksi</h6>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                        <tr>
                            <td>
                                <p>{{ $category->code }}</p>
                            </td>
                            <td>
                                <p>{{ $category->name }}</p>
                            </td>
                            <td>
                                <p>
                                    @if ($category->type === 'in')
                                    Masuk
                                    @elseif ($category->type === 'out')
                                    Keluar
                                    @elseif ($category->type === 'mutation')
                                    Mutasi
                                    @endif
                                </p>
                            </td>
                            <td>
                                <p>{{ $category->debetAccount->name }}</p>
                            </td>
                            <td>
                                <p>{{ $category->creditAccount->name }}</p>
                            </td>
                            <td>
                                <div class="action">
                                    <button class="text-danger">
                                        <i class="lni lni-trash-can"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- end table -->
            </div>
        </div>
    </div>
    </div>

    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h6>Import Kategori</h6>
                    <button type="button" class="btn d-flex align-items-center fs-4 text-danger" data-bs-dismiss="modal"
                        aria-label="Close"><i class="lni lni-cross-circle"></i></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('category.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="input-style-1">
                            <label>Upload File Ecel:</label>
                            <input name="file" type="file" required />
                        </div>
                        <div class="col-12 d-flex gap-3">
                            <button type="reset" class="main-btn warning-btn btn-hover"><i
                                    class="lni lni-trash-can"></i></button>
                            <button type="submit" class="main-btn primary-btn btn-hover flex-fill">Upload</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <x-slot name="scripts">
        <script>

        </script>
    </x-slot>
</x-app-layout>