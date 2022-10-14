@extends('header')


@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin">
                    <div class="d-flex justify-content-between flex-wrap">
                        <div class="d-flex align-items-end flex-wrap">
                            <div class="mr-md-3 mr-xl-5">
                                <h2>Настройки</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <p class="card-title">Персональная информация</p>
                            <p>Почта: {{$user->email}}</p>
                            <p>Telegram Логин: {{'@'.$user->name}}</p>
                            <p>Дата регистрации: {{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $user->created_at)->format('Y-m-d');}}</p>

                        </div>
                    </div>
                </div>


            </div>
            <br>
            <div id="app">
                @if($user->is_admin == 1)
                    <change-price></change-price>
                    <change-stop-list></change-stop-list>
                @endif
                    <change-password></change-password>

            </div>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <!-- partial -->
    </div>
@endsection
