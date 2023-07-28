@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('Profile') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">{{ __('Dashboard') }}</a></div>
                <div class="breadcrumb-item">{{ __('Profile') }}</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">{{ __($user->name) }}</h2>
            <p class="section-lead">
                {{ __('Change information about yourself on this page.') }}
            </p>

            <div class="row mt-sm-4">
                <div class="col-12 col-md-6 ">
                    <div class="card">
                        <form method="post" action="{{ route('admin.profile.update', $user->id) }}"
                            class="needs-validation" novalidate="" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-header">
                                <h4>{{ __('Edit Profile') }}</h4>
                            </div>
                            <div class="card-body">
                                <div class="form-group col-12">
                                    <div id="image-preview" class="image-preview">
                                        <label for="image-upload" id="image-label">{{ __('Choose File') }}</label>
                                        <input name="image" type="file" name="image" id="image-upload">
                                        <input name="old_image" type="hidden" value="{{ $user->image }}">
                                    </div>
                                    @error('image')
                                        <p style="font-size: 80%;
                                        color: #dc3545;">
                                            {{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group col-12">
                                    <label>{{ __('Name') }}</label>
                                    <input name="name" type="text" class="form-control" value="{{ $user->name }}"
                                        required="">
                                    <div class="invalid-feedback">
                                        {{ __('Please fill in the name') }}
                                    </div>
                                    @error('name')
                                        <p style="font-size: 80%;
                                color: #dc3545;">
                                            {{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group col-12">
                                    <label>{{ __('Email') }}</label>
                                    <input name="email" type="text" class="form-control" value="{{ $user->email }}"
                                        required="">
                                    <div class="invalid-feedback">
                                        {{ __('Please fill in the email') }}
                                    </div>
                                    @error('email')
                                        <p style="font-size: 80%;
                                color: #dc3545;">
                                            {{ $message }}</p>
                                    @enderror

                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button class="btn btn-primary">{{ __('Save Changes') }}</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-12 col-md-6 ">
                    <div class="card">
                        <form method="post" action="{{ route('admin.profile-password.update', $user->id) }}"
                            class="needs-validation" novalidate="">
                            @csrf
                            @method('PUT')
                            <div class="card-header">
                                <h4>{{ __('Update Password') }}</h4>
                            </div>
                            <div class="card-body">
                                <div class="form-group col-12">
                                    <label>{{ __('Old Password') }}</label>
                                    <input name="current_password" type="password" class="form-control" required="">
                                    <div class="invalid-feedback">
                                        {{ __('Please fill in the Old Password') }}
                                    </div>
                                    @error('current_password')
                                        <p style="font-size: 80%;
                                    color: #dc3545;">
                                            {{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group col-12">
                                    <label>{{ __('New Password') }}</label>
                                    <input name="password" type="password" class="form-control" required="">
                                    <div class="invalid-feedback">
                                        {{ __('Please fill in the New Password') }}
                                    </div>
                                    @error('password')
                                        <p style="font-size: 80%;
                                    color: #dc3545;">
                                            {{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group col-12">
                                    <label>{{ __('Confirmed Password') }}</label>
                                    <input name="password_confirmation" type="password" class="form-control" required="">
                                    <div class="invalid-feedback">
                                        {{ __('Please fill in the Confirmed Password') }}
                                    </div>
                                    @error('password_confirmation')
                                        <p style="font-size: 80%;
                                    color: #dc3545;">
                                            {{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button class="btn btn-primary">{{ __('Save Changes') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $('.image-preview').css({
                "background-image": "url({{ asset($user->image) }})",
                "background-size": "cover",
                "background-position": "center center"
            })
        })
    </script>
@endpush
