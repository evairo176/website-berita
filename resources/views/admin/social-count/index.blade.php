@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('Social Link') }}</h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>{{ __('All Social Link') }}</h4>
                <div class="card-header-action">
                    <a href="{{ route('admin.social-count.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i>{{ __(' Create new') }}
                    </a>
                </div>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs" id="myTab2" role="tablist">
                    @foreach ($languages as $language)
                        <li class="nav-item">
                            <a data-language="{{ $language->lang }}"
                                class="nav-link {{ $loop->index === 0 ? 'active' : '' }}" id="home-tab2" data-toggle="tab"
                                href="#tab-{{ $language->lang }}" role="tab" aria-controls="home"
                                aria-selected="true">{{ $language->name }}</a>
                        </li>
                    @endforeach
                </ul>
                <div class="tab-content tab-bordered" id="myTab3Content">
                    @foreach ($languages as $language)
                        <div class="tab-pane fade show {{ $loop->index === 0 ? 'active' : '' }}"
                            id="tab-{{ $language->lang }}" role="tabpanel" aria-labelledby="home-tab2">
                            <div class="table-responsive">
                                <table class="table table-striped data-table w-100" id="table-{{ $language->lang }}">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('Language Code') }}</th>
                                            <th>{{ __('Icon') }}</th>
                                            <th>{{ __('Url') }}</th>
                                            <th>{{ __('Fan Count') }}</th>
                                            <th>{{ __('Fan Type') }}</th>
                                            <th>{{ __('Button Text') }}</th>
                                            <th>{{ __('Color') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            <th>{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
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
        $(function() {
            var table = $('#table-' + $('#myTab2 .nav-link.active').attr(
                'data-language')).DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.social-count.index') }}",
                    data: function(d) {
                        d.language = $('#myTab2 .nav-link.active').attr(
                            'data-language'); // Pass the selected category to the server
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'language',
                        name: 'language'
                    },
                    {
                        data: 'icon',
                        name: 'icon'
                    },
                    {
                        data: 'url',
                        name: 'url'
                    },
                    {
                        data: 'fan_count',
                        name: 'fan_count'
                    },
                    {
                        data: 'fan_type',
                        name: 'fan_type'
                    },
                    {
                        data: 'button_text',
                        name: 'button_text'
                    },
                    {
                        data: 'color',
                        name: 'color'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: true
                    },
                ]
            });

            // Function to get the value of the data-language attribute of the active tab
            function getActiveTabLanguage() {
                var activeTabLanguage = $('#myTab2 .nav-link.active').attr('data-language');
                table.ajax.reload(null, false);
                return activeTabLanguage
                // You can use the activeTabLanguage as needed
            }
            // Add a click event listener to the language tabs
            $('#myTab2 a[data-toggle="tab"]').on('click', function() {

                // Remove the "active" class from all tabs
                $('#myTab2 a[data-toggle="tab"]').removeClass('active');
                // Add the "active" class to the clicked tab
                $(this).addClass('active');

                // Get the data-language attribute of the active tab when a tab is clicked
                getActiveTabLanguage();


            });

            // Get the initial data-language attribute value of the active tab on page load
            getActiveTabLanguage();



        });
    </script>
@endpush
