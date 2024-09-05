<section>
    <header>
        <h4 class="fw-semibold">
            {{ __('Update Password') }}
        </h4>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form class="mt-3" method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div class="input-style-1">
            <label for="update_password_current_password">Current Password</label>
            <input class="form-control" id="update_password_current_password" name="current_password" type="password"
                class="mt-1 block w-full" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div class="input-style-1">
            <label for="update_password_password">New Password</label>
            <input class="form-control" id="update_password_password" name="password" type="password"
                class="mt-1 block w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div class="input-style-1">
            <label for="update_password_password_confirmation">Confirm Password</label>
            <input class="form-control" id="update_password_password_confirmation" name="password_confirmation"
                type="password" class="mt-1 block w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <button class="main-btn primary-btn">Ganti Password</button>

            @if (session('status') === 'password-updated')
            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                class="text-sm text-gray-600">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>