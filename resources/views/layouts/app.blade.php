<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', 'Beack IT')</title>


        <meta content="" name="description">
        <meta content="" name="keywords">
    
        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <!-- Google Fonts -->
        <link href="https://fonts.gstatic.com" rel="preconnect">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    
        

        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @stack('styles')
    </head>
   
    <body class="min-h-screen w-full bg-fixed bg-slate-900">

        <!-- ======= Header ======= -->
        <x-header />
    
        <!-- End Header -->

        <!-- ======= Sidebar ======= -->
        {{-- <x-sidebar /> --}}
    
        <!-- End Sidebar-->

        @yield('content')


        <!-- Template Main JS File -->
        <script src="{{  asset('assets/js/main.js') }}"></script>
        @stack('scripts')
    </body>

</html>
