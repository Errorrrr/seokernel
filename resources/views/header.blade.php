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
                            <span class="input-group-text bg-success text-white">
                                    <i class="mdi mdi-plus-circle-outline" style="font-size:1rem;"></i>
                                </span>
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
                        <span class="menu-title" style="padding:10px;">Телеграм &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                    </a>
                </li>
                <li class="nav-item" style="align-self: center;">
                    <button class="nav-link navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize" >
                        <i class="mdi mdi-arrow-expand"></i>
                        <span class="menu-title" style="padding:10px;">Свернуть меню &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                    </button>
                </li>

            </ul>
        </nav>
        <!-- partial -->
        @yield('content')


        <!-- main-panel ends -->
    </div>
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
</body>

</html>

