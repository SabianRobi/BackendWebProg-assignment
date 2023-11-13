<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        {{ config('app.name', 'PC Museum') }}
        @if (View::hasSection('title'))
            | @yield('title')
        @endif
    </title>

    <!-- Logo -->
    <link rel="shortcut icon" type="image/png" href="{{ asset('img/desktop-solid.svg') }}" />

    <!-- Font awesome -->
    <script src="https://kit.fontawesome.com/71af6a2087.js" crossorigin="anonymous"></script>

    <style>
        /*Header images*/
        .header {
            background-image: url(
            @if (View::hasSection('headerImg'))
                @yield('headerImg')
            @else
                {{ asset('img/header.jpg') }}
            @endif
            );
        }

        body.light-theme .header {
            background-image: url({{ asset('img/header.jpg') }});
        }
    </style>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/css/dorang.css', 'resources/js/app.js'])
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</head>

<body data-spy="scroll" data-target=".navbar" data-offset="40" id="home" class="dark-theme">
    <div class="min-h-screen">
        <!-- Navbar -->
        @include('layouts.navBar')
        {{-- @include('layouts.themeSelector') --}}

        <!-- Header -->
        @include('layouts.header')

        <!-- Content -->
        <main class="container page-container">
            @yield('content')
        </main>
        
        <!-- Footer -->
        @include('layouts.footer')
    </div>

    @if (View::hasSection('scripts'))
        @yield('scripts')
    @endif
</body>

</html>
