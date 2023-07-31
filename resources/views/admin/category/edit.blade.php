@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('Category') }}</h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>{{ __('Update Category') }}</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.category.update', $category->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="language">{{ __('Language ' . count($languages)) }}</label>
                        <select id="language-select" name="language" class="form-control select2">
                            <option value="">---{{ __('Select') }}---</option>
                            @foreach ($languages as $lang)
                                <option {{ $lang->lang === $category->language ? 'selected' : '' }}
                                    data-name="{{ $lang->name }}" value="{{ $lang->lang }}">{{ $lang->name }}
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
                        <label for="name">{{ __('Name') }}</label>
                        <input id="name" value="{{ $category->name }}" name="name" type="text"
                            class="form-control">
                        @error('name')
                            <p style="font-size: 80%;
                        color: #dc3545;">
                                {{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="show_at_nav">{{ __('Show at Nav') }}</label>
                        <select name="show_at_nav" class="form-control">
                            <option {{ $category->show_at_nav === 0 ? 'selected' : '' }} value="0">
                                {{ __('No') }}</option>
                            <option {{ $category->show_at_nav === 1 ? 'selected' : '' }} value="1">
                                {{ __('Yes') }}</option>
                        </select>
                        @error('show_at_nav')
                            <p style="font-size: 80%;
                        color: #dc3545;">
                                {{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="status">{{ __('Status') }}</label>
                        <select name="status" class="form-control">
                            <option {{ $category->status === 1 ? 'selected' : '' }} value="1">{{ __('Active') }}
                            </option>
                            <option {{ $category->status === 0 ? 'selected' : '' }} value="0">{{ __('Inactive') }}
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
@endpush
