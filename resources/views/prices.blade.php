@extends('header')


@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin">
                    <div class="d-flex justify-content-between flex-wrap">
                        <div class="d-flex align-items-end flex-wrap">
                            <div class="mr-md-3 mr-xl-5">
                                <h2>Тарифы</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <p class="card-title">Таблица тарифов</p>
                            <table id="recent-purchases-listing" class="table">
                                <thead>
                                <tr>
                                    <th>Функционал</th>
                                    <th>Стоимость, руб.</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>Запросы конкурентов</td>
                                    <td>{{$price->conc_price}} руб. за задачу</td>
                                </tr>
                                <tr>
                                    <td>Кластеризатор по топу</td>
                                    <td>{{$price->cluster_price}} за одну строку</td>
                                </tr>
                                <tr>
                                    <td>Смысловые дубли</td>
                                    <td>{{$price->doubles_price}} за одну строку</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


            </div>
            <br>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <!-- partial -->
    </div>
@endsection
