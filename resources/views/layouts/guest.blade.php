<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', 'BeacK IT')</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/4.1.13/lib.min.js">
        <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
                
        <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>



        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen w-full bg-fixed bg-slate-900 font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 text-gray-100">
            <div class="w-full sm:max-w-md mt-6 px-6 py-4 max-w-lg bg-slate-900/60 backdrop-blur-lg rounded-2xl border border-slate-700 p-8 shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
