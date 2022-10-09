@extends('header')


@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin">
                    <div class="d-flex justify-content-between flex-wrap">
                        <div class="d-flex align-items-end flex-wrap">
                            <div class="mr-md-3 mr-xl-5">
                                <h2>Добавить задачу</h2>
                            </div>
                            <div class="d-flex">

                                <button type="button" class="btn btn-outline-secondary btn-rounded btn-icon">
                                    <i class="mdi mdi-comment-question-outline"></i>
                                </button>
                                <span style="padding:10px;">Инструкция</span>

                            </div>
                            <div class="d-flex">

                                <button type="button" class="btn btn-outline-secondary btn-rounded btn-icon">
                                    <i class="mdi mdi-play-box-outline"></i>
                                </button>
                                <span style="padding:10px;">Видео-инструкция</span>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <span>
                        Выберите основной коммерческий запрос страницы. Его можно взять из H1 конкурента.
                        Выберите топ-10 или топ-20 отобразить конкурентов. Выберите из необходимых.
                        Нажмите "Запустить".
                    </span>

                </div>
            </div>
            <div id="app">
                <add-query></add-query>
            </div>



        </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <!-- partial -->
    </div>
@endsection
