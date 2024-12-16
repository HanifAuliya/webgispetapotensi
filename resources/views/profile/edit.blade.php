@section('title', 'Profile')
<x-app-layout>
    <div class="py-4">
        <div class="container">
            <!-- Update Profile Information -->
            {{-- <div class="row">
                <div class="col-12">
                    <div class="card mb-4 border-0 shadow-sm">
                        <div class="card-header bg-light">
                            <h2 class="h5 fw-semibold text-dark mb-0">
                                {{ __('Profile Information') }}
                            </h2>
                        </div>
                        <div class="card-body">
                            <p class="text-muted small mb-3">
                                {{ __("Update your account's profile information and email address.") }}
                            </p>
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>
                </div>
            </div> --}}

            <!-- Update Password -->
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4 border-0 shadow-sm">
                        <div class="card-header bg-light">
                            <h2 class="h5 fw-semibold text-dark mb-0">
                                {{ __('Update Password') }}
                            </h2>
                        </div>
                        <div class="card-body">
                            <p class="text-muted small mb-3">
                                {{ __('Ensure your account is using a long, random password to stay secure.') }}
                            </p>
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>
                </div>
            </div>

            <!-- Delete Account -->
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4 border-0 shadow-sm">
                        <div class="card-header bg-light">
                            <h2 class="h5 fw-semibold text-dark mb-0">
                                {{ __('Delete Account') }}
                            </h2>
                        </div>
                        <div class="card-body">
                            <p class="text-muted small mb-3">
                                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
                            </p>
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
