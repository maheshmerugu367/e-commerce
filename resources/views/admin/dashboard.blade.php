<!-- resources/views/admin/admin.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Admin Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    @yield('styles')
</head>


<!-- Local CSS files -->
<link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

<!-- Plugin CSS for this page -->
<link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">

<!-- Favicon -->
<link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" />

<!-- Local JS files -->
<script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
<script src="{{ asset('assets/vendors/chart.js/Chart.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.cookie.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/off-canvas.js') }}"></script>
<script src="{{ asset('assets/js/hoverable-collapse.js') }}"></script>
<script src="{{ asset('assets/js/misc.js') }}"></script>
<script src="{{ asset('assets/js/dashboard.js') }}"></script>
<script src="{{ asset('assets/js/todolist.js') }}"></script>

<body>
    <div class="container-scroller">

        @include('admin.components.header')

        <div class="container-fluid page-body-wrapper">

            @include('admin.components.sidebar')

            <div class="main-panel">

            @yield('content')
               
            </div>

            @include('admin.components.footer')




        </div>


    </div>

    <script src="{{ asset('js/admin.js') }}"></script>
    @yield('scripts')
</body>

</html>