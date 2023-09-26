@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('Subscribers') }}</h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>{{ __('Send Mail To Subscribers') }}</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.subscribers.store') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="subject">{{ __('Subject') }}</label>
                        <input type="text" name="subject" class="form-control">
                        @error('subject')
                            <p style="font-size: 80%;
                    color: #dc3545;">
                                {{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="message">{{ __('Message') }}</label>
                        <textarea class="summernote" name="message" cols="30" rows="10"></textarea>
                        @error('message')
                            <p style="font-size: 80%;
                    color: #dc3545;">
                                {{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">{{ __('Send') }}</button>
                </form>
            </div>
        </div>
    </section>
    <section class="section">
        <div class="card card-primary">
            <div class="card-header">
                <h4>{{ __('All Subscriber') }}</h4>
                {{-- <div class="card-header-action">
                    <a href="{{ route('admin.category.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i>{{ __(' Create new') }}
                    </a>
                </div> --}}
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped data-table w-100" id="table-1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('Email') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(function() {
            var table = $('#table-1').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.subscribers.index') }}",
                    // data: function(d) {
                    //     d.language = $('#myTab2 .nav-link.active').attr(
                    //         'data-language'); // Pass the selected category to the server
                    // }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: true
                    },
                ]
            });



        });
    </script>
@endpush
