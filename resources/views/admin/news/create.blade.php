@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('News') }}</h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>{{ __('Create News') }}</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="language">{{ __('Language ' . count($languages)) }}</label>
                        <select id="language-select" name="language" class="form-control select2">
                            <option value="">---{{ __('Select') }}---</option>
                            @foreach ($languages as $lang)
                                <option data-name="{{ $lang->name }}" value="{{ $lang->lang }}"
                                    {{ old('language') == $lang->lang ? 'selected' : '' }}>
                                    {{ $lang->name }}</option>
                            @endforeach
                        </select>
                        @error('language')
                            <p style="font-size: 80%;
                        color: #dc3545;">
                                {{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="category">{{ __('Category') }}</label>
                        <select id="category" data-old="{{ old('category') }}" name="category"
                            class="form-control select2">
                            <option value="">---{{ __('Select') }}---</option>
                        </select>
                        @error('category')
                            <p style="font-size: 80%;
                        color: #dc3545;">
                                {{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="image">{{ __('Image') }}</label>
                        <div id="image-preview" class="image-preview">
                            <label for="image-upload" id="image-label">{{ __('Choose File') }}</label>
                            <input type="file" name="image" id="image-upload">
                        </div>
                        @error('image')
                            <p style="font-size: 80%;
                            color: #dc3545;">
                                {{ $message }}</p>
                        @enderror

                    </div>
                    <div class="form-group">
                        <label for="title">{{ __('Title') }}</label>
                        <input value="{{ old('title') }}" name="title" type="text" class="form-control">
                        @error('title')
                            <p style="font-size: 80%;
                        color: #dc3545;">
                                {{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="content">{{ __('Content') }}</label>
                        <textarea name="content" class="summernote">{{ old('content') }}</textarea>
                        @error('content')
                            <p style="font-size: 80%;
                        color: #dc3545;">
                                {{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="tags">{{ __('Tags') }}</label>
                        <input value="{{ old('tags') }}" name="tags" type="text" class="form-control inputtags">
                        @error('tags')
                            <p style="font-size: 80%;
                        color: #dc3545;">
                                {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="meta_title">{{ __('Meta Title') }}</label>
                        <input value="{{ old('title') }}" name="meta_title" type="text" class="form-control">
                        @error('meta_title')
                            <p style="font-size: 80%;
                        color: #dc3545;">
                                {{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="meta_description">{{ __('Meta Description') }}</label>
                        <textarea name="meta_description" type="text" class="form-control" cols="30" rows="10">{{ old('meta_description') }}</textarea>
                        @error('meta_title')
                            <p style="font-size: 80%;
                        color: #dc3545;">
                                {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="control-label">{{ __('Status') }}</div>
                                <label class="custom-switch mt-2">
                                    <input {{ old('status') == '1' ? 'checked' : '' }} value="1" type="checkbox"
                                        name="status" class="custom-switch-input">
                                    <span class="custom-switch-indicator"></span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="control-label">{{ __('Is Breaking News') }}</div>
                                <label class="custom-switch mt-2">
                                    <input {{ old('is_breaking_news') == '1' ? 'checked' : '' }} value="1"
                                        type="checkbox" name="is_breaking_news" class="custom-switch-input">
                                    <span class="custom-switch-indicator"></span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="control-label">{{ __('Show At Slider') }}</div>
                                <label class="custom-switch mt-2">
                                    <input {{ old('show_at_slider') == '1' ? 'checked' : '' }} value="1"
                                        type="checkbox" name="show_at_slider" class="custom-switch-input">
                                    <span class="custom-switch-indicator"></span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="control-label">{{ __('Show At Popular') }}</div>
                                <label class="custom-switch mt-2">
                                    <input {{ old('show_at_popular') == '1' ? 'checked' : '' }} value="1"
                                        type="checkbox" name="show_at_popular" class="custom-switch-input">
                                    <span class="custom-switch-indicator"></span>
                                </label>
                            </div>
                        </div>

                    </div>
                    <button type="submit" class="btn btn-primary">{{ __('Create') }}</button>
                </form>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            // Get the current value of the "category" input from Laravel's old data
            var oldCategoryValue = "{{ old('category') }}";
            let oldLanguage = $('#language-select').val();

            // Trigger the change event of the language select on page load if oldCategoryValue is not empty
            if (oldCategoryValue !== '') {
                $.ajax({
                    method: "GET",
                    url: "{{ route('admin.fetch-news-category') }}",
                    data: {
                        lang: oldLanguage
                    },
                    success: function(data) {
                        $('#category').html("");
                        $('#category').append(
                            `<option value="">---{{ __('Select') }}---</option>`);

                        $.each(data, function(index, data) {
                            // Check if the current data.id matches the oldCategoryValue and set "selected" attribute
                            let selectedAttribute = (data.id == oldCategoryValue) ?
                                'selected' : '';
                            $('#category').append(
                                `<option value="${data.id}" ${selectedAttribute}>${data.name}</option>`
                            );
                        })

                    },
                    error: function(error) {
                        console.log(error)
                    }
                })
            }


            $('#language-select').on('change', function() {
                let lang = $(this).val();
                $.ajax({
                    method: "GET",
                    url: "{{ route('admin.fetch-news-category') }}",
                    data: {
                        lang: lang
                    },
                    success: function(data) {
                        $('#category').html("");
                        $('#category').append(
                            `<option value="">---{{ __('Select') }}---</option>`);

                        $.each(data, function(index, data) {
                            // Check if the current data.id matches the oldCategoryValue and set "selected" attribute
                            let selectedAttribute = (data.id == oldCategoryValue) ?
                                'selected' : '';
                            $('#category').append(
                                `<option value="${data.id}" ${selectedAttribute}>${data.name}</option>`
                            );
                        })

                    },
                    error: function(error) {
                        console.log(error)
                    }
                })
            })


            // image old preview

            // Get the element by its ID or class
            var element = document.getElementById('image-preview'); // Replace 'yourElementId' with the actual ID

            // Get the inline style attribute
            var inlineStyle = element.style.backgroundImage;

            // Extract the URL from the style
            var url = inlineStyle.match(/url\(["']?([^"']*)["']?\)/)[1];

            console.log(url);
        })
    </script>
@endpush
