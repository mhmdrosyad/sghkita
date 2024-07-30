<x-app-layout>
    <div class="title-wrapper pt-30">
    </div>
    <div class="row">
        <div class="col">
            <div class="card-style mb-30">
                <div class="title d-flex flex-wrap align-items-center justify-content-between mb-3">
                    <div class="left">
                        <h2>
                            Input Saldo Awal
                        </h2>
                    </div>
                    <div class="right">

                    </div>
                </div>
                @if ($errors->any())
                <div class="alert-box danger-alert" role="alert">
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
                <div class="alert-box success-alert" role="alert">
                    <div class="alert">
                        <p class="text-medium">
                            {{ session('success') }}
                        </p>
                    </div>
                </div>
                @endif
                <form method="post" action="{{route('account.store.initialBalance')}}">
                    @csrf
                    <div class="row">
                        <div class="col">
                            <h4 class="mb-3">Aktiva</h4>
                            @foreach($accounts as $account)
                            @if($account->position == 'activa')
                            <div class="input-style-1">
                                <label>{{$account->name}}</label>
                                <input name="account[{{$account->code}}]" type="text" placeholder="masukan saldo awal"
                                    value="{{ old('account.'.$account->code) }}" />
                            </div>
                            @endif
                            @endforeach
                        </div>
                        <div class="col">
                            <h4 class="mb-3">Passiva</h4>
                            @foreach($accounts as $account)
                            @if($account->position == 'passiva')
                            <div class="input-style-1">
                                <label>{{$account->name}}</label>
                                <input name="account[{{$account->code}}]" type="text" placeholder="masukan saldo awal"
                                    value="{{ old('account.'.$account->code) }}" />
                            </div>
                            @endif
                            @endforeach
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