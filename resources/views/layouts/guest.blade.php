<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="/vendors/mdi/css/materialdesignicons.min.css">
        <link rel="stylesheet" href="/vendors/base/vendor.bundle.base.css">
        <!-- endinject -->
        <!-- plugin css for this page -->
        <link rel="stylesheet" href="/vendors/datatables.net-bs4/dataTables.bootstrap4.css">
        <!-- End plugin css for this page -->
        <!-- inject:css -->
        <link rel="stylesheet" href="/css/style.css">

        <!-- Scripts -->

        <script src="{{ asset('js/app.js') }}" defer></script>

    </head>
    <body>
        <div class="font-sans text-gray-900 antialiased">
            {{ $slot }}
        </div>
        <footer class="footer">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
                <span class="text-muted text-center text-sm-left d-block d-sm-inline-block"><h2>Турбо Ядро</h2><p>семантика за минуту</p> © 2022 </span>
                <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Дни работы поддержки:<p>пн-вс: 7:00 - 20:00 по Москве</p></span>
                <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">help@turbo-yadro.ru<p>+7-960-996-95-76</p></span>
                <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">
                <a href="/pc-oferta">Пользовательское соглашение</a><br>
                <a href="/policy">Политика оплаты и возврата</a>
                    <!--
                                    <a >Политика использование Cookie</a>
                    -->
            </span>
            </div>
        </footer>
    </body>
</html>
