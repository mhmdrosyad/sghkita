<x-app-layout>
    <div class="title-wrapper pt-30">
    </div>
    <div class="row">
        <div class="col">
            <div class="card-style mb-30">
                <div class="title d-flex flex-wrap align-items-center justify-content-between mb-3">
                    <div class="left">
                        <h2>
                            Edit Akun {{$account->name}}
                        </h2>
                    </div>
                    <div class="right">
                        <a href="{{route('account.index')}}" class="main-btn primary-btn btn-hover"><i
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
                <form action="{{ route('account.update', $account->code) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="input-style-1">
                        <label for="code">Kode</label>
                        <input type="text" name="code" id="code" class="form-control" value="{{ $account->code }}"
                            required>
                    </div>
                    <div class="input-style-1">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ $account->name }}"
                            required>
                    </div>

                    <div class="select-style-1">
                        <label for="position">Position</label>
                        <div class="select-position">
                            <select name="position" id="position" required>
                                <option value="asset" {{ $account->position == 'asset' ? 'selected' : '' }}>Aktiva
                                </option>
                                <option value="liability" {{ $account->position == 'liability' ? 'selected' : ''
                                    }}>Passiva
                                </option>
                                <option value="profit_loss" {{ $account->position == 'profit_loss' ? 'selected' : ''
                                    }}>Laba
                                    Rugi</option>
                            </select>
                        </div>

                    </div>

                    <button type="submit" class="main-btn primary-btn">Update</button>
                </form>
            </div>
        </div>
    </div>
    <x-slot name="scripts">
        <script>

        </script>
    </x-slot>
</x-app-layout>