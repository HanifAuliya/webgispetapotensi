<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ asset('../assets/css/dashboard.css') }}" rel="stylesheet">

    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">



    <!-- Lightbox CSS -->
    <link href="https://cdn.jsdelivr.net/npm/lightbox2@2.11.4/dist/css/lightbox.min.css" rel="stylesheet">

    <link rel="icon" href="{{ asset('assets/images/tabalong.png') }}" type="image/x-icon">


</head>

<body class="bg-light">
    <!-- Header -->
    @include('layouts.navigation')

    <!-- Page Content -->
    <div class="container py-4">
        @isset($header)
            <header class="bg-white rounded shadow-sm p-3 mb-4">
                <h1 class="h5 mb-0 text-primary">
                    {{ $header }}
                </h1>
            </header>
        @endisset

        <main>
            {{ $slot }}
        </main>
    </div>

    <!-- Footer -->
    <footer class="bg-white text-center py-3 shadow-sm mt-4 ">
        <p class="mb-0 text-secondary">&copy; {{ date('Y') }} Dinas Penanaman Modal dan Pelayanan Terpadu Satu
            pintu. All rights reserved.</p>
    </footer>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>

</html>
