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
                                                <p style="font-size:1rem;"><b>Зачем нужен:</b> Автоматизировать распределение запросов, выбрать подходящие для 1 конкретной страницы.<br><br>
                                                    Залог успешного продвижения в топ-10, это правильно выбранные запросы, которые не конкурируют друг с другом (частая ошибка специалистов).<br><br>
                                                    Ошибки из-за человеческого фактора на этом этапе не допустимы, эффективнее доверить это роботу.<br><br>
                                                    <br>
                                                    <b>Отличие от сбора по «старинке»:</b> Анализ по лидерам ТОП-а<br><br>
                                                    Не нужно тратить время и мучиться в принятии решений о том, чтобы объединять или дробить запросы.<br><br>
                                                    Сразу получаете готовую семантику с частотой, правильным порядком слов (самая частотная форма), отсутствие смысловых дублей и очищенная от неподходящих слов.<br><br>
                                                    <br>
                                                    <b>Как пользоваться:</b><br>
                                                <ol style="font-size:1rem;">
                                                    <li>Укажите основной ключ. Если не знаете какой, найдите несколько конкурентов, откройте их меню и найдите подходящий пункт, возьмите на этой странице из заголовка h1.</li>
                                                    <li>Нажмите кнопку «Выбрать конкурентов», отобразятся их страницы.</li>
                                                    <li>Исключите не подходящие по 2-м критериям: 1. Известный бренд (пример Яндекс, Озон, Ламода, валберис, любой агрегатор). 2. Не похожие на вашу страницу (агрегатор, а у вас, к примеру страница услуг). На против этих сайтов нажмите кнопку «Убрать», они должны сменить цвет на серый.</li>
                                                    <li>Нажмите «далее» и вставьте список запросов (до 10 тыс. строк). Запросы можете взять готовые в разделе «Запросы конкурентов» или вставить свои подготовленные.</li>
                                                    <li>Нажмите «Запустить», увидите название задачи и отображение процесса выполнения задачи.</li>
                                                    <li>Дождитесь выполнения. Скачайте результат нажав на кнопку «Ексель». </li>
                                                </ol>
                                                <br>

                                                Важно выбрать правильный запрос при постановке задачи. Введите в Яндексе и посмотрите какой в выдаче у конкурентов, перейдите на их страницы и сверьте со своей, похожа ли (тип страниц), иначе выберите другой запрос.<br><br>
                                                Если у вас коммерческий сайт, желательно добавить к нему приставки (купить, цена, название города), это всегда будет правильный запрос.<br></p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

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
                <add-cluster></add-cluster>
            </div>



        </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <!-- partial -->
    </div>
@endsection
