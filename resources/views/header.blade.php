<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>ТурбоЯдро</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="/vendors/base/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <link rel="stylesheet" href="/vendors/datatables.net-bs4/dataTables.bootstrap4.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="/css/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="/images/favicon.png" />
    <style>
        .autocomplete ul {
            z-index: 100;
        }
    </style>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-T5BFF99');</script>
    <!-- End Google Tag Manager -->
</head>
<body>
<div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="navbar-brand-wrapper d-flex justify-content-center" style="padding:15px;">
            <div class="navbar-brand-inner-wrapper d-flex justify-content-between align-items-center w-100">
                <h4>Турбо ядро</h4>
            </div>
        </div>
        @if(isset($user))
        <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
            <ul class="navbar-nav navbar-nav-right">
                <div class="form-group" style="margin-top: 5px;">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-primary text-white"><i class="mdi mdi-cash-multiple"></i></span>
                        </div>
                        <input style="width:100px;"
                               type="text" class="form-control" value="{{$user->balance}}" aria-label="Amount (to the nearest dollar)" disabled>
                        <div class="input-group-append">
                            <button class="input-group-text bg-success text-white" data-toggle="modal" data-target="#exampleModal2">
                                    <i class="mdi mdi-plus-circle-outline" style="font-size:1rem;"></i>
                                </button>
                        </div>
                    </div>
                </div>

                <li class="nav-item nav-profile dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                        <i class="mdi mdi-account menu-icon" style="font-size:2rem;"></i>
                        <span class="nav-profile-name">Профиль</span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                        <a class="dropdown-item" href="/settings">
                            <i class="mdi mdi-settings text-primary"></i>
                            Настройки
                        </a>
                        <a class="dropdown-item" href="/prices">
                            <i class="mdi mdi-coin text-primary"></i>
                            Тарифы
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                        <a class="dropdown-item" href="{{route('logout')}}"
                           onclick="event.preventDefault();
                                                this.closest('form').submit();">
                            <i class="mdi mdi-logout text-primary"></i>
                            Выход

                        </a>
                        </form>

                    </div>
                </li>
            </ul>
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
                <span class="mdi mdi-menu"></span>
            </button>
        </div>
        @endif
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
            <ul class="nav">
                <li class="nav-item @if(Request::is('/queries')) active @endif" style="align-self: center;">
                    <a class="nav-link" href="/queries">
                        <i class="mdi mdi-diamond"></i>
                        <span class="menu-title" style="padding:10px;">Запросы конкурентов</span>
                    </a>
                </li>
                <li class="nav-item @if(Request::is('/clusters')) active @endif" style="align-self: center;">
                    <a class="nav-link" href="/clusters">
                        <i class="mdi mdi-animation"></i>
                        <span class="menu-title" style="padding:10px;">Кластеризатор    &nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                    </a>
                </li>
                <li class="nav-item @if(Request::is('/')) active @endif" style="align-self: center;">
                    <a class="nav-link" href="https://t.me/turbo_yadro_live">
                        <i class="mdi mdi-telegram"></i>
                        <span class="menu-title" style="padding:10px;">Задать вопрос &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                    </a>
                </li>
                <li class="nav-item" style="align-self: center;">
                    <button class="nav-link navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="modal" data-target="#exampleModal2" >
                        <i class="mdi mdi-plus-circle-outline"></i>
                        <span class="menu-title" style="padding:10px;">Пополнить баланс &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                    </button>
                </li>
                <li class="nav-item" style="align-self: center;">
                    <button class="nav-link navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize" >
                        <i class="mdi mdi-arrow-expand"></i>
                        <span class="menu-title" style="padding:10px;">Свернуть меню &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                    </button>
                </li>

            </ul>
        </nav>
        <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel2">Пополнить баланс</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form class="forms-sample" method="post" action="/payment">
                        @csrf
                        <div class="modal-body">
                            Введите сумму для пополнения в рублях
                            <input type="number" class="form-control" id="input" placeholder="Сумма" name="sum" min="1" value="1">
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Оплатить</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

        <!-- partial -->
        @yield('content')


        <!-- main-panel ends -->
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
    <!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->

<!-- plugins:js -->
<script src="/vendors/base/vendor.bundle.base.js"></script>
<script src="/js/app.js"></script>
<!-- endinject -->
<!-- Plugin js for this page-->
<script src="/vendors/chart.js/Chart.min.js"></script>
<script src="/vendors/datatables.net/jquery.dataTables.js"></script>
<script src="/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
<!-- End plugin js for this page-->
<!-- inject:js -->
<script src="/js/off-canvas.js"></script>
<script src="/js/hoverable-collapse.js"></script>
<script src="/js/template.js"></script>
<!-- endinject -->
<!-- Custom js for this page-->
<script src="/js/dashboard.js"></script>
<script src="/js/data-table.js"></script>
<script src="/js/jquery.dataTables.js"></script>
<script src="/js/dataTables.bootstrap4.js"></script>
<!-- End custom js for this page-->

<script>
    $('#exampleModal3').on('hidden.bs.modal', function (e) {
        let srcVideo = $('#videoHelp').attr('src');
        document.getElementById('videoHelp').remove();
        $("#videoBody").append('<iframe width="970" id="videoHelp" height="600" src="'+srcVideo+'" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>');

    });
</script>

</body>

</html>

