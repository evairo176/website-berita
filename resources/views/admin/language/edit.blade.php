@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('Language') }}</h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>{{ __('Edit Languages') }}</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.language.update', $language->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="lang">{{ __('Language ' . count(config('language'))) }}</label>
                        <select id="language-select" name="lang" class="form-control select2">
                            <option value="">---{{ __('Select') }}---</option>
                            @foreach (config('language') as $key => $lang)
                                <option data-name="{{ $lang['name'] . ' - ' . $lang['nativeName'] }}"
                                    @if ($language->lang === $key) selected @endif value="{{ $key }}">
                                    {{ $lang['name'] . ' - ' . $lang['nativeName'] }}
                                </option>
                            @endforeach
                        </select>
                        @error('lang')
                            <p style="font-size: 80%;
                        color: #dc3545;">
                                {{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="name">{{ __('Name') }}</label>
                        <input id="name" readonly value="{{ $language->name }}" name="name" type="text"
                            class="form-control">
                        @error('name')
                            <p style="font-size: 80%;
                        color: #dc3545;">
                                {{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="slug">{{ __('Slug') }}</label>
                        <input id="slug" value="{{ $language->slug }}" readonly name="slug" type="text"
                            class="form-control">
                        @error('slug')
                            <p style="font-size: 80%;
                        color: #dc3545;">
                                {{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="default">{{ __('Is it default?') }}</label>
                        <select name="default" class="form-control">
                            <option {{ $language->default === 0 ? 'selected' : '' }} value="0">{{ __('No') }}
                            </option>
                            <option {{ $language->default === 1 ? 'selected' : '' }} value="1">{{ __('Yes') }}
                            </option>
                        </select>
                        @error('default')
                            <p style="font-size: 80%;
                        color: #dc3545;">
                                {{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="status">{{ __('Status') }}</label>
                        <select name="status" class="form-control">
                            <option {{ $language->status === 1 ? 'selected' : '' }} value="1">{{ __('Active') }}
                            </option>
                            <option {{ $language->status === 0 ? 'selected' : '' }} value="0">{{ __('Inactive') }}
                            </option>
                        </select>
                        @error('status')
                            <p style="font-size: 80%;
                        color: #dc3545;">
                                {{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                </form>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $('#language-select').on('change', function() {
                let value = $(this).val();
                let name = $(this).children(':selected').attr("data-name");
                $('#slug').val(value);
                $('#name').val(name);
            })
        })
    </script>
@endpush
