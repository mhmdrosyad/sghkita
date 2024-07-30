<x-app-layout>
    <div class="title-wrapper pt-30">
    </div>
    <div class="row">
        <div class="col">
            <div class="card-style mb-30">
                <div class="title d-flex flex-wrap align-items-center justify-content-between mb-3">
                    <div class="left">
                        <h2>
                            Tambah Jenis Transaksi
                        </h2>
                    </div>
                    <div class="right">
                        <a href="{{route('category.index')}}" class="main-btn primary-btn btn-hover"><i
                                class="lni lni-arrow-left"></i>Kembali</a>
                    </div>
                </div>
                @if ($errors->any())
                <div class="mb-3 alert-box danger-alert" role="alert">
                    <div class="alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif
                @if (session('success'))
                <div class="alert-box success-alert alert-dismissible fade show" role="alert">
                    <div class="alert">
                        <p class="text-medium">
                            {{ session('success') }}
                        </p>
                    </div>
                </div>
                @endif
                <form method="post" action="{{route('category.store')}}">
                    @csrf
                    <div class="input-style-1">
                        <label>Kode</label>
                        <input name="code" type="text" placeholder="masukan kode akun" required />
                    </div>
                    <div class="input-style-1">
                        <label>Nama Kategori</label>
                        <input name="name" type="text" placeholder="masukkan nama akun" required />
                    </div>
                    <div class="select-style-1">
                        <label>Jenis</label>
                        <div class="select-position">
                            <select class="text-capitalize" name="type" required>
                                <option value="" disabled selected>Pilih jenis</option>
                                <option value="in">Masuk</option>
                                <option value="out">Keluar</option>
                                <option value="mutation">Mutasi</option>
                            </select>
                        </div>
                    </div>
                    <div class="select-style-1">
                        <label>Debit</label>
                        <div class="select-position">
                            <select class="text-capitalize" name="debet" required>
                                <option value="" disabled selected>Pilih jenis</option>
                                @foreach($accounts as $account)
                                <option value="{{$account->code}}">{{$account->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="select-style-1">
                        <label>Kredit</label>
                        <div class="select-position">
                            <select class="text-capitalize" name="credit" required>
                                <option value="" disabled selected>Pilih jenis</option>
                                @foreach($accounts as $account)
                                <option value="{{$account->code}}">{{$account->name}}</option>
                                @endforeach
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
    <x-slot name="scripts">
        <script>

        </script>
    </x-slot>
</x-app-layout>