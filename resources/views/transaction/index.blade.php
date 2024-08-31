<x-app-layout>
    <div class="title-wrapper pt-30">
    </div>
    <div class="row">
        <div class="col">
            <div class="card-style mb-30">
                <div class="title d-flex flex-wrap align-items-center justify-content-between mb-3">
                    <div class="left">
                        <h2>
                            Cash Flow @isset($account) {{ $account->name }} @endisset
                        </h2>
                    </div>
                    <div class="right">
                        {{-- <button type="button" class="main-btn secondary-btn btn-hover" data-bs-toggle="modal"
                            data-bs-target="#mutationModal"><i class="lni lni-plus"></i>Mutasi</button> --}}
                        <button type="button" class="main-btn success-btn btn-hover" data-bs-toggle="modal"
                            data-bs-target="#importModal"><i class="lni lni-upload"></i>Import</button>
                        <button type="button" class="main-btn primary-btn btn-hover" data-bs-toggle="modal"
                            data-bs-target="#addModal"><i class="lni lni-plus"></i>Transaksi Masuk</button>
                        <button type="button" class="main-btn warning-btn btn-hover" data-bs-toggle="modal"
                            data-bs-target="#addModalOut"><i class="lni lni-plus"></i>Transaksi Keluar</button>

                    </div>
                </div>

                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                @if (session('success'))
                <div class="alert-box success-alert" role="alert">
                    <div class=" alert">
                        <p class="text-medium">
                            {{ session('success') }}
                        </p>
                    </div>
                </div>
                @endif
                <div class="row my-3">
                    <form action="{{ route('transaction.index') }}" method="get" class="col-lg-4">
                        @isset($account)
                        <input type="hidden" name="account" value="{{ $account->code }}">
                        @endisset
                        <div class="row">
                            <div class="col">
                                <div class="input-style-1">
                                    <label>Tanggal Awal</label>
                                    <input type="date" name="start_date" value="{{ $startDateFormatted }}"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="col">
                                <div class="input-style-1">
                                    <label>Tanggal Akhir</label>
                                    <input type="date" name="end_date" value="{{ $endDateFormatted }}"
                                        class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <button type="submit" class="main-btn primary-btn btn-hover">
                                    Filter</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="table-wrapper table-responsive">
                    <table id="ledgerTable" class="table striped-table">
                        <thead>
                            <tr>
                                <th>Waktu</th>
                                <th>Uraian</th>
                                <th>Jenis Transaksi</th>
                                <th>Masuk</th>
                                <th>Keluar</th>
                                <th>Saldo</th>
                                <th>Aksi</th>
                                <th>Nota</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>

                <div class="mt-3 fs-5 fw-bold d-flex flex-column text-danger">
                    <div>Saldo Awal: {{number_format($startingBalance, 0, ',', '.')}}</div>
                    <div>Saldo Akhir: {{number_format($totalBalance, 0, ',', '.')}}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h6>Tambah Uang Masuk</h6>
                    <button type="button" class="btn d-flex align-items-center fs-4 text-danger" data-bs-dismiss="modal"
                        aria-label="Close"><i class="lni lni-cross-circle"></i></button>
                </div>
                <div class="modal-body">
                    <div class="alert-box success-alert mb-3" style="display: none;">
                        <div class="alert">
                            <p id="success-message"></p>
                        </div>
                    </div>
                    <div class="alert-box danger-alert mb-3" style="display: none;">
                        <div class="alert">
                            <p id="error-message"></p>
                        </div>
                    </div>
                    <form method="post" action="{{route('transaction.store')}}">
                        @csrf
                        @isset($account)
                        <input name="account_code" type="hidden" value="{{$account->code}}" />
                        @endisset
                        <div class="input-style-1">
                            <label>Uraian</label>
                            <input name="description" type="text" placeholder="masukkan uraian" required />
                        </div>
                        <div class="input-style-1">
                            <label>Nominal</label>
                            <input name="nominal" type="number" autocomplete="off" required />
                        </div>
                        <div class="select-style-1">
                            <label>Jenis Transaksi</label>
                            <div class="select-position">
                                <select class="text-capitalize" name="category_code" required>
                                    <option value="" disabled selected>Pilih jenis</option>
                                    @if(isset($inCategories))
                                    @foreach($inCategories as $category)
                                    @if($category->type == 'in')
                                    <option value="{{$category->code}}">{{$category->name}}</option>
                                    @endif
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-12 d-flex gap-3">
                            <button type="reset" class="main-btn warning-btn btn-hover"><i
                                    class="lni lni-trash-can"></i></button>
                            <button type="submit" class="main-btn primary-btn btn-hover flex-fill">Tambah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addModalOut" tabindex="-1" aria-labelledby="addModalOutLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h6>Tambah Uang Keluar</h6>
                    <button type="button" class="btn d-flex align-items-center fs-4 text-danger" data-bs-dismiss="modal"
                        aria-label="Close"><i class="lni lni-cross-circle"></i></button>
                </div>
                <div class="modal-body">
                    <div class="alert-box success-alert mb-3" style="display: none;">
                        <div class="alert">
                            <p id="success-message"></p>
                        </div>
                    </div>
                    <div class="alert-box danger-alert mb-3" style="display: none;">
                        <div class="alert">
                            <p id="error-message"></p>
                        </div>
                    </div>
                    <form method="post" action="{{route('transaction.store')}}" enctype="multipart/form-data">
                        @csrf
                        @isset($account)
                        <input name="account_code" type="hidden" value="{{$account->code}}" />
                        @endisset
                        <div class="input-style-1">
                            <label>Uraian</label>
                            <input name="description" type="text" placeholder="masukkan uraian" required />
                        </div>
                        <div class="input-style-1">
                            <label>Nominal</label>
                            <input name="nominal" type="number" autocomplete="off" required />
                        </div>
                        <div class="select-style-1">
                            <label>Jenis Transaksi</label>
                            <div class="select-position">
                                <select class="text-capitalize" name="category_code" required>
                                    <option value="" disabled selected>Pilih jenis</option>
                                    @if(isset($outCategories))
                                    @foreach($outCategories as $category)
                                    @if($category->type == 'out')
                                    <option value="{{$category->code}}">{{$category->name}}</option>
                                    @endif
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <label class="mb-3 fw-bold">Foto Nota</label>
                        <div class="mb-3 d-flex justify-content-center">
                            <div id="my_camera"></div>
                        </div>
                        <div class="mb-3 d-flex justify-content-center">
                            <button class="main-btn primary-btn btn-hover mb-3" type=button value="Take Snapshot"
                                onClick="take_snapshot()">Tangkap</button>
                        </div>
                        <div class="mb-3 d-flex justify-content-center">
                            <div id="results"></div>
                        </div>
                        <input type="hidden" name="image" id="imageInput" required>
                        <div class="col-12 d-flex gap-3">
                            <button type="reset" class="main-btn warning-btn btn-hover"><i
                                    class="lni lni-trash-can"></i></button>
                            <button type="submit" class="main-btn primary-btn btn-hover flex-fill">Tambah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="mutationModal" tabindex="-1" aria-labelledby="mutationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h6>Tambah Mutasi</h6>
                    <button type="button" class="btn d-flex align-items-center fs-4 text-danger" data-bs-dismiss="modal"
                        aria-label="Close"><i class="lni lni-cross-circle"></i></button>
                </div>
                <div class="modal-body">
                    <div class="alert-box success-alert mb-3" style="display: none;">
                        <div class="alert">
                            <p id="success-message"></p>
                        </div>
                    </div>
                    <div class="alert-box danger-alert mb-3" style="display: none;">
                        <div class="alert">
                            <p id="error-message"></p>
                        </div>
                    </div>
                    <form method="post" action="{{route('transaction.store')}}">
                        @csrf
                        <div class="input-style-1">
                            <label>Uraian</label>
                            <input name="description" type="text" placeholder="masukkan nama akun" required />
                        </div>
                        <div class="input-style-1">
                            <label>Nominal</label>
                            <input name="nominal" type="number" autocomplete="off" required />
                        </div>
                        <div class="select-style-1">
                            <label>Jenis Transaksi</label>
                            <div class="select-position">
                                <select class="text-capitalize" name="category_code" required>
                                    <option value="" disabled selected>Pilih jenis</option>
                                    @if(isset($mutationCategories))
                                    @foreach($mutationCategories as $category)
                                    <option value="{{$category->code}}">{{$category->name}}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-12 d-flex gap-3">
                            <button type="reset" class="main-btn warning-btn btn-hover"><i
                                    class="lni lni-trash-can"></i></button>
                            <button type="submit" class="main-btn primary-btn btn-hover flex-fill">Tambah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h6>Import Cash Flow</h6>
                    <button type="button" class="btn d-flex align-items-center fs-4 text-danger" data-bs-dismiss="modal"
                        aria-label="Close"><i class="lni lni-cross-circle"></i></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('transaction.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="input-style-1">
                            <label>Bulan</label>
                            <input name="periode" type="text" placeholder="MM-YYYY" required />
                        </div>
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
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h6>Nota Transaksi</h6>
                    <button type="button" class="btn d-flex align-items-center fs-4 text-danger" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="lni lni-cross-circle"></i>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" alt="Note Image" class="img-fluid" />
                </div>
            </div>
        </div>
    </div>
    <x-slot name="scripts">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js"></script>
        {{-- <script language="JavaScript">
            Webcam.set({
                width: 320,
                height: 240,
                image_format: 'jpeg',
                jpeg_quality: 90
            });
            Webcam.attach('#my_camera');
        
            function take_snapshot() {
                Webcam.snap(function(data_uri) {
                    document.getElementById('results').innerHTML = 
                        '<img src="'+data_uri+'"/>';
                    document.getElementById('imageInput').value = data_uri;
                });
            }
        </script> --}}

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var imageModal = document.getElementById('imageModal');
                imageModal.addEventListener('show.bs.modal', function(event) {
                    var button = event.relatedTarget;
                    var imageUrl = button.getAttribute('data-image');
                    var modalImage = imageModal.querySelector('#modalImage');
                    modalImage.src = imageUrl;
                });
            });
        </script>

        <script>
            $(document).ready(function() {
                var table = $('#ledgerTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('transaction.index') }}",
                        data: function (d) {
                            d.account = "{{ request('account') }}";
                            d.start_date = $('input[name="start_date"]').val();
                            d.end_date = $('input[name="end_date"]').val();
                        }
                    },
                    columns: [
                        { data: 'entry_date', name: 'entry_date' },
                        { data: 'description', name: 'transaction.description' },
                        { data: 'category_name', name: 'transaction.category.name' },
                        { data: 'debit', name: 'debit' },
                        { data: 'credit', name: 'credit' },
                        { data: 'balance', name: 'balance' },
                        { data: 'action', name: 'action', orderable: false, searchable: false },
                        { data: 'view_image', name: 'view_image' },
                    ],
                    // order: [[0, 'desc']]
                });

                $('#ledgerTable').on('click', '.delete-button', function() {
                    var id = $(this).data('id');
                    var url = '/transaction/delete/' + id;
                    
                    Swal.fire({
                        title: 'Apakah anda yakin?',
                        text: "Kamu tidak bisa mengembalikan data yang hilang!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, tetap hapus!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: url,
                                type: 'DELETE',
                                data: {
                                    _token: '{{ csrf_token() }}'
                                },
                                success: function(response) {
                                    if (response.success) {
                                        Swal.fire(
                                            'Deleted!',
                                            response.success,
                                            'success'
                                        )
                                        table.ajax.reload();
                                    } else {
                                        Swal.fire(
                                            'Error!',
                                            response.error,
                                            'error'
                                        )
                                    }
                                },
                                error: function(xhr) {
                                    Swal.fire(
                                        'Error!',
                                        'An error occurred while deleting the account.',
                                        'error'
                                    )
                                }
                            });
                        }
                    });
                });
            });
        </script>
    </x-slot>
</x-app-layout>