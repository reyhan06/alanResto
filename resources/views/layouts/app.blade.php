<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}" type="text/css">

    @yield('head')
</head>

<body>
    <header>
        <nav class="navbar bg-primary">
            <div class="container">
                <a class="navbar-brand" href="#">
                    <img src="{{ asset('img/logo/logo.png') }}" width="40" height="40" class="d-inline-block align-top" alt="Logo">
                    <span class="text-white" style="font-size:150%;">{{ config('app.name') }}</span>
                </a>
            </div>
        </nav>
        <nav class="nav topnav bg-white" style="font-size:120%;">
            <div class="container">
                <a href="{{ route('products.index') }}"  @if($active_menu['products'])class="active" @endif>Food</a>
                <a href="{{ route('transactions') }}" @if($active_menu['transactions'])class="active" @endif>Transaksi</a>
            </div>
        </nav>
    </header>

    <div class="container">
        @yield('content')

        <footer class="pt-5">
            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    <p class="text-center">Alan Resto © 2021 | Developed by Reyhan Ramadhan</p>
                </div>
                <div class="col-md-4"></div>
            </div>
        </footer>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    @yield('scripts')
</body>

</html>
