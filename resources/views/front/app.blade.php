<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Vendor styles -->
        <link rel="stylesheet" href="{{ asset('vendors/zwicon/zwicon.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendors/animate.css/animate.min.css') }}">
        <!-- overlayScrollbar -->
        <!-- <link rel="stylesheet" href="{{ asset('vendors/overlay-scrollbars/OverlayScrollbars.min.css') }}"> -->
        <!-- Sweet Alert -->        
        <!-- <link rel="stylesheet" href="{{ asset('vendors/sweetalert2/sweetalert2.min.css') }}"> -->
        <!-- Select2 plugin -->        
        <!-- <link rel="stylesheet" href="{{ asset('vendors/select2/css/select2.min.css') }}"> -->
        <!-- dropzone for csv upload -->        
        <!-- <link rel="stylesheet" href="{{ asset('vendors/dropzone/dropzone.css') }}"> -->
        <!-- App styles -->
        <link rel="stylesheet" href="{{ asset('css/app.min.css') }}">
        <!-- toastr notification -->
        <!-- <link rel="stylesheet" href="{{ asset('vendors/toastr/toastr.min.css') }}"> -->
        <!-- Load multistep form assets if page is csv upload -->
        @if (!empty(parse_url(url()->current())['path']) && parse_url(url()->current())['path'] == '/csv')
            <link rel="stylesheet" href="{{ asset('vendors/smartwizard/smart_wizard.min.css') }}">
            <link rel="stylesheet" href="{{ asset('vendors/smartwizard/smart_wizard_theme_arrows.min.css') }}">  
        @endif

        <!-- Custom Style -->
        <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
    </head>
    <body class="body">
        <main class="main">
            <div class="page-loader">
                <div class="page-loader__spinner">
                    <svg viewBox="25 25 50 50">
                        <circle cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
                    </svg>
                </div>
            </div>            
            <section class="content">
                @yield('content')     
            </section>
            @yield('content1')
        </main>
        <!-- Javascript -->
        <!-- Vendors -->
        <script src="{{ asset('vendors/jquery/jquery.min.js') }}"></script>
        <!-- <script src="{{ asset('vendors/popper.js/popper.min.js') }}"></script> -->
        <script src="{{ asset('vendors/bootstrap/js/bootstrap.min.js') }}"></script>
        <!-- overlayScrollbar -->
        <!-- <script src="{{ asset('vendors/overlay-scrollbars/jquery.overlayScrollbars.min.js') }}"></script> -->
        <!-- toastr notification -->
        <!-- <script src="{{ asset('vendors/toastr/toastr.min.js') }}"></script> -->
        <!-- Vendors: Data tables -->
        <!-- <script src="{{ asset('vendors/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('vendors/datatables/datatables-buttons/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('vendors/datatables/datatables-buttons/buttons.print.min.js') }}"></script>        
        <script src="{{ asset('vendors/jszip/jszip.min.js') }}"></script>
        <script src="{{ asset('vendors/datatables/datatables-buttons/buttons.html5.min.js') }}"></script> -->

        
        <!-- Select2 plugin -->
        <!-- <script src="{{ asset('vendors/autosize/autosize.min.js') }}"></script>
        <script src="{{ asset('vendors/select2/js/select2.full.min.js') }}"></script> -->
        <!-- dropzone for csv upload -->        
        <!-- <script src="{{ asset('vendors/dropzone/dropzone.min.js') }}"></script> -->
        <!-- Sweet Alert -->        
        <!-- <script src="{{ asset('vendors/sweetalert2/sweetalert2.all.min.js') }}"></script> -->

        <!-- App functions and actions -->
        <script src="{{ asset('js/app.min.js') }}"></script>
        <!-- Load multistep form assets if page is csv upload -->
        @if (!empty(parse_url(url()->current())['path']) && parse_url(url()->current())['path'] == '/csv')
            <!-- <script src="{{ asset('vendors/smartwizard/jquery.min.js') }}"></script> -->
            <script src="{{ asset('vendors/smartwizard/jquery.smartWizard.min.js') }}"></script>            
        @endif
        <!-- Custom js -->
        <script src="{{ asset('js/custom.js') }}"></script>
        <script>
        $(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });
    </script>
    </body>
</html>