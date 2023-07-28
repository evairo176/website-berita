@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('Language') }}</h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>{{ __('Create Languages') }}</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.language.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="lang">{{ __('Language ' . count(config('language'))) }}</label>
                        <select id="language-select" name="lang" class="form-control select2">
                            <option value="">---Select---</option>
                            @foreach (config('language') as $key => $lang)
                                <option value="{{ $key }}">{{ $lang['name'] . ' - ' . $lang['nativeName'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name">{{ __('Name') }}</label>
                        <input id="name" readonly name="name" type="text" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="slug">{{ __('Slug') }}</label>
                        <input id="slug" readonly name="slug" type="text" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="default">{{ __('Is it default?') }}</label>
                        <select name="default" class="form-control">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="status">{{ __('Status') }}</label>
                        <select name="status" class="form-control">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Create</button>
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
                let name = $(this).children(':selected').text();
                $('#slug').val(value);
                $('#name').val(name);
            })
        })
    </script>
@endpush
