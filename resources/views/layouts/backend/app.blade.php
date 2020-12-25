<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Missing Person And Crime Reporting System</title>

    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/flaticon/flaticon.css') }}">

</head>
<body class="hold-transition dark layout-fixed layout-navbar-fixed layout-footer-fixed">

    <div class="wrapper" id="app">
        @include('layouts.backend.nav')
        @php
            $emp = explode(".", Route::currentRouteName())[0];
            if(Route::currentRouteName() == 'employee.edit_account')
            $emp = strtolower($employee->role);
        @endphp

        @if(Auth::guard('employee')->user()->password_changed == true)
            @include("layouts.backend.sidebars.$emp")
        @endif

        @yield('content')

        @include('layouts.backend.controlbar')
        @include('layouts.backend.footer')
    </div>
    <!-- ./wrapper -->

    <!-- Scripts -->
    <script src="{{ asset('js/admin.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('table.datatable-custom').DataTable();
            $('a[data-toggle="tooltip"]').tooltip({
                animated: 'fade',
                placement: 'bottom',
                html: true
            });

            $('.datatable-custom').on('click', '.delete', function(event) {
                event.preventDefault();
                console.log('some');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        let id = $(this).attr('id');
                        $(`#delete${id}`).submit();
                    }
                });
            })
        });
        function makeTitle(slug) {
            var words = slug.split('-');
            for (var i = 0; i < words.length; i++) {
                var word = words[i];
                words[i] = word.charAt(0).toUpperCase() + word.slice(1);
            }
            return words.join(' ');
        }
    </script>
    @if(session()->has('success'))
    <script>
        $(document).ready(function() {
            Swal.fire('Success', "{{session('message')}}", 'success');
        })
    </script>
    @endif()
    @yield('js')

</body>

</html>
