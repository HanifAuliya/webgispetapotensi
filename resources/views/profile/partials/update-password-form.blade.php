<section class="mb-4">
    <header class="mb-3">
        <h2 class="h5 fw-bold text-dark">
            {{ __('Update Password') }}
        </h2>
        <p class="text-muted small">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="row g-3">
        @csrf
        @method('put')

        <!-- Current Password -->
        <div class="col-12">
            <label for="update_password_current_password" class="form-label">
                {{ __('Current Password') }}
            </label>
            <input id="update_password_current_password" name="current_password" type="password" class="form-control"
                autocomplete="current-password" required>
            @if ($errors->updatePassword->has('current_password'))
                <div class="text-danger small mt-1">
                    {{ $errors->updatePassword->first('current_password') }}
                </div>
            @endif
        </div>

        <!-- New Password -->
        <div class="col-12">
            <label for="update_password_password" class="form-label">
                {{ __('New Password') }}
            </label>
            <input id="update_password_password" name="password" type="password" class="form-control"
                autocomplete="new-password" required>
            @if ($errors->updatePassword->has('password'))
                <div class="text-danger small mt-1">
                    {{ $errors->updatePassword->first('password') }}
                </div>
            @endif
        </div>

        <!-- Confirm Password -->
        <div class="col-12">
            <label for="update_password_password_confirmation" class="form-label">
                {{ __('Confirm Password') }}
            </label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password"
                class="form-control" autocomplete="new-password" required>
            @if ($errors->updatePassword->has('password_confirmation'))
                <div class="text-danger small mt-1">
                    {{ $errors->updatePassword->first('password_confirmation') }}
                </div>
            @endif
        </div>

        <!-- Save Button -->
        <div class="col-12 d-flex align-items-center">
            <button type="submit" class="btn btn-primary">
                {{ __('Save') }}
            </button>
            @if (session('status') === 'password-updated')
                <span class="text-success small ms-3">
                    {{ __('Saved.') }}
                </span>
            @endif
        </div>
    </form>
</section>
