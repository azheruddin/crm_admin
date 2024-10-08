<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        <!-- @vite(['resources/css/app.css', 'resources/js/app.js']) -->

        <!-- Bootstrap CSS -->
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
        
        <!-- Vendor CSS -->
        <link rel="stylesheet" href="{{ asset('assets/vendors/feather/feather.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/vendors/ti-icons/css/themify-icons.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/vendors/font-awesome/css/font-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/vendors/typicons/typicons.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/vendors/simple-line-icons/css/simple-line-icons.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
        
        <!-- Plugin CSS for this page -->
        <link rel="stylesheet" href="{{ asset('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/js/select.dataTables.min.css') }}">
        
        <!-- Your Custom CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
        
        <!-- Favicon -->
        <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" />
        <!-- DataTables CSS -->
        <link href="{{ asset('css/dataTables.bootstrap5.css') }}" rel="stylesheet">
        <!-- Include other CSS files if needed -->
    </head>
<body class="with-welcome-text">
    <div class="container-scroller">
<!-- here topbar -->
<x-topbar />
    <div class="container-fluid page-body-wrapper">

<!-- here sidebar -->
<x-sidebar />
    <div class="main-panel">
          <div class="content-wrapper">
    <header>
      
                </header>

    <main class="py-4">
        @yield('content')
            </main>

    </div>
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
          <footer class="footer">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
              <span class="text-muted text-center text-sm-left d-block d-sm-inline-block"> <a href="" target="_blank"></a>HBT CREATIONS PVT LTD</span>
              <span class="float-none float-sm-end d-block mt-1 mt-sm-0 text-center">Copyright © 2024. All rights reserved.</span>
            </div>
          </footer>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>

    <footer>
        <!-- Footer content goes here -->
    </footer>
    

    <!-- Bootstrap JS -->
    <script src="{{ asset('public/js/bootstrap.min.js') }}"></script>
    
    <!-- Vendor JS -->
    <script src="{{ asset('public/assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('public/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    
    <!-- Plugin JS for this page -->
    <script src="{{ asset('public/assets/vendors/chart.js/chart.umd.js') }}"></script>
    <script src="{{ asset('public/assets/vendors/progressbar.js/progressbar.min.js') }}"></script>
    
    <!-- Your custom JS -->
    <script src="{{ asset('public/assets/js/off-canvas.js') }}"></script>
    <script src="{{ asset('public/assets/js/template.js') }}"></script>
    <script src="{{ asset('public/assets/js/settings.js') }}"></script>
    <script src="{{ asset('public/assets/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('public/assets/js/todolist.js') }}"></script>
    
    <!-- Custom JS for this page -->
    <script src="{{ asset('public/assets/js/jquery.cookie.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/assets/js/dashboard.js') }}"></script>

      <!-- DataTables JS -->
      <script src="{{ asset('public/js/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ asset('public/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('public/js/dataTables.bootstrap5.min.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.bootstrap5.js"></script>

    <!-- for stATE CITY  -->
    <script src="{{ asset('public/assets/myjs/cities.js') }}"></script>
    <script language="javascript">print_state("sts");</script>
    <!-- <script src="assets/myjs/cities.js"></script>  -->

      <!-- Custom JS for DataTable initialization -->
      <script>
        $(document).ready(function() {
            new DataTable('#example');
        });
    </script>
    </body>
</html>
