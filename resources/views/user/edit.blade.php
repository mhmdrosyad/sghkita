<x-app-layout>
    <div class="title-wrapper pt-30">
    </div>
    <div class="row">
        <div class="col">
            <div class="card-style mb-30">
                <div class="title d-flex flex-wrap align-items-center justify-content-between mb-3">
                    <div class="left">
                        <h2>
                            Edit {{$user->name}}
                        </h2>
                    </div>
                    <div class="right">
                        <a href="{{route('user.index')}}" class="main-btn primary-btn btn-hover"><i
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
                <form action="{{ route('user.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="input-style-1">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ $user->name }}"
                            required>
                    </div>
                    <div class="input-style-1">
                        <label for="username">Username</label>
                        <input type="text" name="username" id="username" class="form-control"
                            value="{{ $user->username }}" required>
                    </div>

                    <div class="input-style-1">
                        <label for="email">Email</label>
                        <input type="text" name="email" id="email" class="form-control" value="{{ $user->email }}"
                            required>
                    </div>

                    <div class="input-style-1">
                        <label for="password">Password (Leave blank if not changing)</label>
                        <input type="password" name="password" id="password" class="form-control">
                    </div>

                    <div class="form-control mb-3">
                        <label>Roles</label>
                        @foreach($roles as $role)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->name }}" {{
                                $user->hasRole($role->name) ? 'checked' : '' }}>
                            <label class="form-check-label">{{ $role->name }}</label>
                        </div>
                        @endforeach
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