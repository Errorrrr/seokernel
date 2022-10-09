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
