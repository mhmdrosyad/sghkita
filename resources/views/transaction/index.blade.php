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
                        <button type="button" class="main-btn secondary-btn btn-hover" data-bs-toggle="modal"
                            data-bs-target="#mutationModal"><i class="lni lni-plus"></i>Mutasi</button>
                        <button type="button" class="main-btn primary-btn btn-hover" data-bs-toggle="modal"
                            data-bs-target="#addModal"><i class="lni lni-plus"></i>Tambah Uang Masuk</button>
                        <button type="button" class="main-btn warning-btn btn-hover" data-bs-toggle="modal"
                            data-bs-target="#addModalOut"><i class="lni lni-plus"></i>Tambah Uang Keluar</button>

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
                                <h6>Waktu</h6>
                            </th>
                            <th>
                                <h6>Uraian</h6>
                            </th>
                            <th>
                                <h6>Jenis Transaksi</h6>
                            </th>
                            <th>
                                <h6>Masuk</h6>
                            </th>
                            <th>
                                <h6>Keluar</h6>
                            </th>
                            <th>
                                <h6>Aksi</h6>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $transaction)
                        <tr>
                            <td>
                                <p>{{$transaction->transaction_at}}</p>
                            </td>
                            <td>
                                <p>{{$transaction->description}}</p>
                            </td>
                            <td>
                                <p>{{$transaction->category->name}}</p>
                            </td>
                            <td>
                                @if(isset($account))
                                <p>{{$transaction->category->debetAccount->code == $account->code ?
                                    number_format($transaction->nominal, 0,',', '.') : '-'}}
                                </p>
                                @else
                                <p>{{$transaction->category->type === 'in' ? number_format($transaction->nominal, 0,',',
                                    '.') : '-' }}</p>
                                @endif
                            </td>
                            <td>
                                @if(isset($account))
                                <p>{{$transaction->category->creditAccount->code == $account->code ?
                                    number_format($transaction->nominal, 0,',', '.') : '-'}}
                                </p>
                                @else
                                <p>{{$transaction->category->type === 'out' ? number_format($transaction->nominal, 0,
                                    ',', '.') : '-' }}</p>
                                @endif
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
                        <tr>
                            <td colspan="4" class="text-end">Total Saldo: </td>
                            <td colspan="2" class="text-center">
                                <p class="fw-bold fs-5">Rp. {{ number_format($totalBalance, 0, '.', '.') }}</p>
                            </td>
                        </tr>
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
    <x-slot name="scripts">
        <script>

        </script>
    </x-slot>
</x-app-layout>