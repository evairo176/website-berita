@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('Home Section Setting') }}</h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>{{ __('All Category') }}</h4>
                <div class="card-header-action">
                    <a href="{{ route('admin.category.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i>{{ __(' Create new') }}
                    </a>
                </div>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs" id="myTab2" role="tablist">
                    @foreach ($languages as $language)
                        <li class="nav-item">
                            <a class="nav-link {{ $loop->index === 0 ? 'active' : '' }}" id="home-tab2" data-toggle="tab"
                                href="#home-{{ $language->lang }}" role="tab" aria-controls="home"
                                aria-selected="true">{{ $language->name }}</a>
                        </li>
                    @endforeach
                </ul>
                <div class="tab-content tab-bordered" id="myTab3Content">
                    @foreach ($languages as $language)
                        @php
                            $categories = \App\Models\Category::where('language', $language->lang)
                                ->orderByDesc('id')
                                ->get();
                            // $homeSectionSetting = \App\Models\HomeSectionSetting::where('language', $language->lang)->first();
                        @endphp
                        <div class="tab-pane fade show {{ $loop->index === 0 ? 'active' : '' }}"
                            id="home-{{ $language->lang }}" role="tabpanel" aria-labelledby="home-tab2">
                            <div class="w-100">
                                <form action="{{ route('admin.home-section-setting.update') }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="">{{ __('admin.Category Section one') }}</label>
                                        <input type="hidden" name="language" value="{{ $language->lang }}">
                                        <select name="category_section_one" id="" class="form-control select2">
                                            <option value="">---{{ __('admin.Select') }}---</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('category_section_one')
                                            <p style="font-size: 80%;
                        color: #dc3545;">
                                                {{ $message }}</p>
                                        @enderror

                                    </div>

                                    <div class="form-group">
                                        <label for="">{{ __('admin.Category Section Two') }}</label>
                                        <select name="category_section_two" id="" class="form-control select2">
                                            <option value="">---{{ __('admin.Select') }}---</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('category_section_two')
                                            <p style="font-size: 80%;
                                    color: #dc3545;">
                                                {{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="">{{ __('admin.Category Section Three') }}</label>
                                        <select name="category_section_three" id="" class="form-control select2">
                                            <option value="">---{{ __('admin.Select') }}---</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('category_section_three')
                                            <p style="font-size: 80%;
                                    color: #dc3545;">
                                                {{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="">{{ __('admin.Category Section Four') }}</label>
                                        <select name="category_section_four" id="" class="form-control select2">
                                            <option value="">---{{ __('admin.Select') }}---</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('category_section_four')
                                            <p style="font-size: 80%;
                                    color: #dc3545;">
                                                {{ $message }}</p>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-primary">{{ __('admin.Save') }}</button>
                                </form>
                            </div>
                        </div>
                    @endforeach


                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                Toast.fire({
                    icon: "error",
                    title: "{{ $error }}"
                });
            @endforeach
        @endif
        $(function() {});
    </script>
@endpush
