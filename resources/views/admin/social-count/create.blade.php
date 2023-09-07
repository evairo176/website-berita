@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('Social Count') }}</h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>{{ __('Create Social Link') }}</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.social-count.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="language">{{ __('Language ' . count($languages)) }}</label>
                        <select id="language-select" name="language" class="form-control select2">
                            <option value="">---{{ __('Select') }}---</option>
                            @foreach ($languages as $lang)
                                <option data-name="{{ $lang->name }}" value="{{ $lang->lang }}">{{ $lang->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('language')
                            <p style="font-size: 80%;
                        color: #dc3545;">
                                {{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="icon">{{ __('Icon') }}</label>
                        <br>
                        <button class="btn btn-primary" name="icon" role="iconpicker"></button>
                        @error('icon')
                            <p style="font-size: 80%;
                        color: #dc3545;">
                                {{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="url">{{ __('Url') }}</label>
                        <input id="url" name="url" type="text" class="form-control">
                        @error('url')
                            <p style="font-size: 80%;
                        color: #dc3545;">
                                {{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="fan_count">{{ __('Fan Count') }}</label>
                        <input id="fan_count" name="fan_count" type="text" class="form-control">
                        @error('fan_count')
                            <p style="font-size: 80%;
                        color: #dc3545;">
                                {{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="fan_type">{{ __('Fan Type') }}</label>
                        <input id="fan_type" name="fan_type" type="text" class="form-control"
                            placeholder="ex: like, fans, followes">
                        @error('fan_type')
                            <p style="font-size: 80%;
                        color: #dc3545;">
                                {{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="button_text">{{ __('Button Text') }}</label>
                        <input id="button_text" name="button_text" type="text" class="form-control">
                        @error('button_text')
                            <p style="font-size: 80%;
                        color: #dc3545;">
                                {{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="color">Pick Your Color</label>
                        <div class="input-group colorpickerinput colorpicker-element" data-colorpicker-id="2">
                            <input name="color" type="text" class="form-control">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <i class="fas fa-fill-drip"></i>
                                </div>
                            </div>
                        </div>
                        @error('color')
                            <p style="font-size: 80%;
                    color: #dc3545;">
                                {{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="status">{{ __('Status') }}</label>
                        <select name="status" class="form-control">
                            <option value="1">{{ __('Active') }}</option>
                            <option value="0">{{ __('Inactive') }}</option>
                        </select>
                        @error('status')
                            <p style="font-size: 80%;
                        color: #dc3545;">
                                {{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">{{ __('Create') }}</button>
                </form>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script>
        $(".colorpickerinput").colorpicker({
            format: 'hex',
            component: '.input-group-append',
        });
    </script>
@endpush
