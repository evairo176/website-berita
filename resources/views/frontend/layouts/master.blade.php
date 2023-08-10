<!DOCTYPE html>
<html lang="">

<head>
    <meta charset="utf-8">
    <title>Top News HTML template </title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset('/frontend') }}/assets/css/styles.css" rel="stylesheet">
</head>

<body>

    <!-- Header news -->
    @include('frontend.layouts.header')
    <!-- End Header news -->


    @yield('content')


    <!-- Footer  -->
    @include('frontend.layouts.footer')
    <!-- End Footer  -->

    <a href="javascript:" id="return-to-top"><i class="fa fa-chevron-up"></i></a>

    <script type="text/javascript" src="{{ asset('/frontend') }}/assets/js/index.bundle.js"></script>
    <script>
        $(document).ready(function() {
            $('#site-language').on('change', function() {
                let languageCode = $(this).val();
                $.ajax({
                    method: 'GET',
                    url: "{{ route('frontend.change-language') }}",
                    data: {
                        language_code: languageCode
                    },
                    success: function(data) {
                        if (data.status === 'success') {
                            window.location.reload();
                        }
                    },
                    error: function(error) {
                        console.error(error)
                    }
                })
            })
        })
    </script>
</body>

</html>