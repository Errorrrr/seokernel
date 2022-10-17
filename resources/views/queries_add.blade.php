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

                                <button type="button" class="btn btn-outline-secondary btn-rounded btn-icon" data-toggle="modal" data-target="#exampleModal">
                                    <i class="mdi mdi-comment-question-outline"></i>
                                </button>
                                <span style="padding:10px;cursor: pointer;" data-toggle="modal" data-target="#exampleModal">Инструкция</span>
                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document" style="max-width: 1000px;">
                                        <div class="modal-content" >
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Запросы конкурентов</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p style="font-size:1rem;"><b>Зачем нужен:</b> Мгновенно получить все запросы конкурнетов.<br>
                                                    Незачем собирать семантику руками, когда она есть готовая у лидеров ниши.<br>
                                                    <br>
                                                    <b>Отличие от сбора по «старинке»</b><br>
                                                    Не нужно парсить данные, разбираться в сложных программах, покупать прокси и аккаунты, подбирать маркеры, тратить целый день, чтобы дождаться сбора всех данных и следить за процессом, и самое печальное, возможность ошибиться (человеческий фактор).<br>
                                                    <br>
                                                    Это позволяет удешевлять процесс и зарабатывать больше на разнице. Легче найти помощника, легче обучить и делегировать семантику или вовсе обойтись без него. Не нужно проверять за ним работу.<br>
                                                    <br>
                                                    <b>Как пользоваться:</b><br>
                                                <ol style="font-size:1rem;">
                                                    <li>Укажите основной ключ. Если не знаете какой, найдите несколько конкурентов, откройте их меню и найдите подходящий пункт, возьмите на этой странице из заголовка h1.</li>
                                                    <li>Нажмите кнопку «Выбрать конкурентов», отобразятся их страницы.</li>
                                                    <li>Исключите не подходящие по 2-м критериям: 1. Известный бренд (пример Яндекс, Озон, Ламода, валберис, любой агрегатор). 2. Не похожие на вашу страницу (агрегатор, а у вас, к примеру страница услуг). На против этих сайтов нажмите кнопку «Убрать», они должны сменить цвет на серый.</li>
                                                    <li>Нажмите «Запустить» и скачайте результат в виде файла, путем нажатия на кнопку «Ексель».</li>
                                                </ol>
                                                <br>

                                                Запрещено использовать запросы, которые относятся к запрещенной деятельности в России.<br></p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="d-flex">

                                <button type="button" class="btn btn-outline-secondary btn-rounded btn-icon" data-toggle="modal" data-target="#exampleModal3">
                                    <i class="mdi mdi-play-box-outline"></i>
                                </button>
                                <span style="padding:10px;cursor: pointer;" data-toggle="modal" data-target="#exampleModal3">Видео-инструкция</span>
                                <div class="modal fade" id="exampleModal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel3" aria-hidden="true">
                                    <div class="modal-dialog" role="document" style="max-width: 1000px;">
                                        <div class="modal-content" >
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Запросы конкурентов</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body" id="videoBody">
                                                <iframe width="970" id="videoHelp" height="600" src="https://www.youtube.com/embed/5I2PtHkshqQ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

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
