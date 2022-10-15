@extends('header')


@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="d-flex justify-content-between flex-wrap">
                    <div class="d-flex align-items-end flex-wrap">
                        <div class="mr-md-3 mr-xl-5">
                            <h2>Кластеризация</h2>
                        </div>
                        <div class="d-flex">

                            <button type="button" class="btn btn-outline-secondary btn-rounded btn-icon" data-toggle="modal" data-target="#exampleModal">
                                <i class="mdi mdi-comment-question-outline"></i>
                            </button>
                            <span style="padding:10px;">Инструкция</span>
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Запросы конкурентов</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <b>Зачем нужен:</b> Автоматизировать распределение запросов, выбрать подходящие для 1 конкретной страницы.<br>
                                            Залог успешного продвижения в топ-10, это правильно выбранные запросы, которые не конкурируют друг с другом (частая ошибка специалистов).<br>
                                            Ошибки из-за человеческого фактора на этом этапе не допустимы, эффективнее доверить это роботу.<br>
                                            <br>
                                            <b>Отличие от сбора по «старинке»</b><br>
                                            Анализ по лидерам ТОП-а<br>
                                            Не нужно тратить время и мучиться в принятии решений о том, чтобы объединять или дробить запросы.<br>
                                            Сразу получаете готовую семантику с частотой, правильным порядком слов (самая частотная форма), отсутствие смысловых дублей и очищенная от неподходящих слов.<br>
                                            <br>
                                            <b>Как пользоваться:</b><br>
                                            <ol>
                                                <li>Укажите основной ключ. Если не знаете какой, найдите несколько конкурентов, откройте их меню и найдите подходящий пункт, возьмите на этой странице из заголовка h1.</li>
                                                <li>Нажмите кнопку «Выбрать конкурентов», отобразятся их страницы.</li>
                                                <li>Исключите не подходящие по 2-м критериям: 1. Известный бренд (пример Яндекс, Озон, Ламода, валберис, любой агрегатор). 2. Не похожие на вашу страницу (агрегатор, а у вас, к примеру страница услуг). На против этих сайтов нажмите кнопку «Убрать», они должны сменить цвет на серый.</li>
                                                <li>Нажмите «далее» и вставьте список запросов (до 10 тыс. строк). Запросы можете взять готовые в разделе «Запросы конкурентов» или вставить свои подготовленные.</li>
                                                <li>Нажмите «Запустить», увидите название задачи и отображение процесса выполнения задачи.</li>
                                                <li>Дождитесь выполнения. Скачайте результат нажав на кнопку «Ексель». </li>
                                            </ol>
                                            <br>

                                            Важно выбрать правильный запрос при постановке задачи. Введите в Яндексе и посмотрите какой в выдаче у конкурентов, перейдите на их страницы и сверьте со своей, похожа ли (тип страниц), иначе выберите другой запрос.<br>
                                            Если у вас коммерческий сайт, желательно добавить к нему приставки (купить, цена, название города), это всегда будет правильный запрос.<br>
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
            <a href="/clusters/add_tusk">
                <div class="col-md-12 grid-margin stretch-card">
                    <button type="button" class="btn btn-primary" >Добавить задачу</button>

                </div>
            </a>
        </div>
        <div id="app"><query-cluster></query-cluster></div>
    </div>
    <!-- content-wrapper ends -->
    <!-- partial:partials/_footer.html -->
    <!-- partial -->
</div>
@endsection
