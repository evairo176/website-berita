<!DOCTYPE html>
<html lang="">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title')</title>
    <meta name="description" content="@yield('meta_description')">
    <meta name="og:title" content="@yield('meta_og_title')">
    <meta name="og:description" content="@yield('meta_og_description')">
    <meta name="og:image" content="@yield('meta_og_image')">
    <meta name="twitter:title" content="@yield('meta_tw_title')">
    <meta name="twitter:description" content="@yield('meta_tw_description')">
    <meta name="twitter:image" content="@yield('meta_tw_image')">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <!-- Bootstrap CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" />
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" />
    {{-- <!-- Bootstrap-Iconpicker -->
    <link rel="stylesheet" href="{{ asset('/frontend') }}/dist/css/bootstrap-iconpicker.min.css" /> --}}

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


    <!-- jQuery CDN -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <!-- Bootstrap CDN -->
    <script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.bundle.min.js">
    </script>
    {{-- <!-- Bootstrap-Iconpicker Bundle -->
    <script type="text/javascript" src="dist/js/bootstrap-iconpicker.bundle.min.js"></script> --}}

    <script type="text/javascript" src="{{ asset('/frontend') }}/assets/js/index.bundle.js"></script>
    {{-- sweet alert  --}}
    @include('sweetalert::alert')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

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

            // subscribe newsletter
            $(".newsletter-form").on("submit", function(e) {
                e.preventDefault();
                $.ajax({
                    method: "post",
                    url: "{{ route('subscribe-newsletter') }}",
                    data: $(this).serialize(),
                    beforeSend: function(e) {
                        $(".newsletter-button").text("Loading...");
                        $(".newsletter-button").attr("disabled", true);
                    },
                    success: function(data) {
                        console.log(data)
                        if (data.status = "success") {
                            Toast.fire({
                                icon: "success",
                                title: data.message
                            })
                            $(".newsletter-form")[0].reset();
                            $(".newsletter-button").text("SIGN UP");
                            $(".newsletter-button").attr("disabled", false);
                        }
                    },
                    error: function(data) {
                        console.log(data)
                        if (data.status === 422) {
                            let errors = data.responseJSON.errors;
                            $.each(errors, function(index, value) {
                                Toast.fire({
                                    icon: "error",
                                    title: value[0]
                                })
                            })
                            $(".newsletter-button").text("SIGN UP");
                            $(".newsletter-button").attr("disabled", false);
                        }

                    }
                })
            })
        })
    </script>
    @stack('content')
</body>

</html>
