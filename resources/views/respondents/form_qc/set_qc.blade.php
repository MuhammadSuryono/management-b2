<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>MRI B2 | @yield('title')</title>

    <!-- Bootstrap -->
    <link href="cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <link href="{{url('../assets/gentelella')}}/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{url('../assets/gentelella')}}/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{url('../assets/gentelella')}}/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="{{url('../assets/gentelella')}}/vendors/iCheck/skins/flat/green.css" rel="stylesheet">

    <!-- Switchery -->
    <link href="{{url('../assets/gentelella')}}/vendors/switchery/dist/switchery.min.css" rel="stylesheet">
    <!-- Datatables -->
    <link href="{{url('../assets/gentelella')}}/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="{{url('../assets/gentelella')}}/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="{{url('../assets/gentelella')}}/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="{{url('../assets/gentelella')}}/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="{{url('../assets/gentelella')}}/build/css/custom.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.js" integrity="sha256-BTlTdQO9/fascB1drekrDVkaKd9PkwBymMlHOiG+qLI=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pretty-checkbox@3.0/dist/pretty-checkbox.min.css">

    <style>
        .vl {
            border-left: 6px solid green;
            height: 500px;
        }

        .flex {
            display: flex;
            flex-direction: row;
        }

        .flex>.split {
            height: 80vh;
            overflow-y: scroll;
            width: 100%;
        }

        .gutter.gutter-horizontal {
            cursor: ew-resize;
        }

        .gutter {
            background-color: #eee;
            background-repeat: no-repeat;
            background-position: 50%;
        }

        .gutter.gutter-horizontal {
            background-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAUAAAAeCAYAAADkftS9AAAAIklEQVQoU2M4c+bMfxAGAgYYmwGrIIiDjrELjpo5aiZeMwF+yNnOs5KSvgAAAABJRU5ErkJggg==');
        }

        .heading {
            padding: 15px;
            background: #eeeeee;
            text-align: center;
            font-weight: 800;
            color: #0062cc;
            letter-spacing: 2px;
        }

        h5 {
            color: black;
        }

        input {
            width: 100%;
        }

        .left_col p {
            color: white;
        }

        div.ex1 {
            overflow: scroll;
            width: 100%;
            height: 400px;
        }
    </style>
</head>

<body class="nav-md">
    <div class="x_content">
        <div class="row">
            <div class="col-sm-12">
                <div class="card-box table-responsive">
                    @if(isset($cropNotif))
                    <div class="offset-md-3 col-sm-6">
                        @endif
                        @if (session('status'))
                        <div class="x_content bs-example-popovers">
                            <div align="center" class="alert alert-info alert-dismissible " role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                                </button>
                                <strong>Status Proses! </strong> {{ session('status') }}
                            </div>
                            @elseif (session('status-fail'))
                            <div class="x_content bs-example-popovers">
                                <div align="center" class="alert alert-info alert-dismissible" role="alert" style="background-color: red;">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                                    </button>
                                    <strong>Status Proses! </strong> {{ session('status-fail') }}
                                </div>
                                @endif
                                @if(isset($add_url))
                                <a href="{{$add_url}}" class="btn btn-primary btn-block">{{isset($add_title) ? $add_title : 'Add'}} </a>
                                @endif
                            </div>

                            @if(isset($cropNotif))
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col">
                <div class="left_col scroll-view" style="padding: 20px;">
                    <?php
                    $id = explode('/', url()->current());
                    $id = $id[count($id) - 1]; ?>
                    <!-- sidebar menu -->
                    <p>Nama: <?= $respondent->respname ?></p>
                    <p>Gender: <?= $respondent->gender->gender ?></p>
                    <p>Alamat: <?= $respondent->address ?></p>
                    <p>Kota: <?= $respondent->kota->kota ?></p>
                    <p>Pekerjaan: <?= isset($respondent->pekerjaan->pekerjaan) ? $respondent->pekerjaan->pekerjaan : '-' ?></p>
                    <p>HP: <?= $respondent->mobilephone ?></p>
                    <div class="row ml-1">
                        <p>Status Callback: <?= isset($respondent->status_callback->keterangan_callback) ? $respondent->status_callback->keterangan_callback : '-' ?>
                            <?php if ($checkPengecekanRekaman) : ?>
                                <a class="btn btn-sm text-primary" href="<?= url('form_pengecekan/') . "/" . $checkPengecekanRekaman->id . "/edit" ?>" target="_blank" data-toggle="tooltip" data-placement="bottom" title="Pengecekan Rekaman"><i class="fa fa-external-link"></i></a>
                            <?php endif; ?>
                            <span data-toggle="modal" data-target="#formCallbackModal">
                                <button type="button" data-toggle="tooltip" data-placement="bottom" title="Ubah Status Callback" class="btn btn-sm text-primary"><i class="fa fa-edit"></i></button>
                            </span>
                        </p>
                    </div>

                    <div class="item form-group">
                        <p class="pt-3">Form Callback </p>
                        <button class="btn btn-primary ml-1" type="button" data-target="#formQcModal" data-toggle="modal" <?= ($checkFilled > 0) ? '' : 'disabled' ?>>Form Laporan Callback</button>
                    </div>
                </div>
                <!-- /sidebar menu -->
            </div>
        </div>
        <!-- page content -->
        <!-- <p>test</p> -->
        <div class="right_col" role="main">
            <div class="card mb-3 p-2">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6">
                            <p style="font-size: 15px;" class="text-dark">Alur Fitur Worksheet Callback:</p>
                            <p class="text-dark">1. Status Callback Terhubung</p>
                            <p class="text-dark">2. Melakukan pengisian Worksheet QC dan menekan tombol Save</p>
                            <p class="text-dark">3. Mengisi Form QC</p>
                        </div>
                        <div class="col-lg-6">
                            <p style="font-size: 15px;" class="text-dark">Keterangan Tambahan:</p>
                            <p class="text-dark">1. Callback Dilakukan sebanyak 3x</p>
                            <p class="text-dark">2. Ketika Callback gagal dilakukan form pengecekan rekaman akan otomatis muncul</p>
                            <p class="text-dark">3. Ketika Callback berhasil pertanyaan yang sebelumnya diatur akan muncul</p>
                        </div>
                    </div>
                </div>

            </div>
            <div class="card" style="height: 100%; padding-bottom: 50px;">

                <!-- <div class="card-body"> -->
                <div class="heading">
                    Question
                </div>
                <?php if ($respondent->status_callback_id != 1) : ?>
                    <h4>Status Callback belum terhubung</h4>
                <?php else : ?>
                    <form class="" action="{{url('form_qc/store_qc_respondent')}}" method="post" id="form-respondent">
                        @csrf
                        <input type="hidden" name="respondent_id" value="<?= $respondent->id ?>">
                        <input type="hidden" name="project_id" value="<?= $project->id ?>">
                        <div class="flex">
                            <div id="one" class="split" style="padding: 10px;">
                                <div class="col-lg-6">
                                    <?php $i = 1; ?>
                                    <?php foreach ($questQuestion as $q) : ?>
                                        <?php if ($i % 2 != 0) : ?>
                                            <div style="min-height: 200px;">
                                                <h5 style="margin-top: 10px;">{{$i}}. {{$q->pertanyaan}}</h5>
                                                <?php if ($q->jenis == 'fa') : ?>
                                                    <?php $answer = DB::table('quest_answers')->where('quest_question_id', '=', $q->id)->where('respondent_id', $respondent->id)->first(); ?>
                                                    <?php if (isset($answer->answer)) : ?>
                                                        <input class="form-control" type="text" name="answer_<?= $i ?>_<?= $q->id ?>" value="<?= is_null($answer->answer) ? '' : $answer->answer ?>">
                                                    <?php else : ?>
                                                        <input class="form-control" type="text" name="answer_<?= $i ?>_<?= $q->id ?>" value="">
                                                    <?php endif; ?>
                                                <?php
                                                elseif ($q->jenis == 'ma') :
                                                    $option = DB::table('quest_options')->where('quest_question_id', $q->id)->orderBy('value')->get();
                                                    $answer = DB::table('quest_answers')->where('quest_question_id', '=', $q->id)->where('respondent_id', $respondent->id)->get();
                                                    $arrAnswer = [];
                                                    foreach ($answer as $a) {

                                                        $arrLastChar = explode('_', $a->answer_code);
                                                        $lastChar = $arrLastChar[count($arrLastChar) - 1];
                                                        $arrAnswer[$lastChar] = $a->answer;
                                                    }
                                                ?>
                                                    <?php foreach ($option as $o) : ?>

                                                        <div class="form-check" style="text-align: left;">
                                                            <?php if ($arrAnswer) : ?>

                                                                <input class="form-check-input col-md-1" type="checkbox" name="answer_<?= $i ?>_<?= $q->id ?>[]" id="answer_<?= $i ?>_<?= $o->option ?>" value="<?= $o->value ?>" <?= ($arrAnswer[$o->value] == 1) ? 'checked' : '' ?>>
                                                            <?php else : ?>
                                                                <input class="form-check-input col-md-1" type="checkbox" name="answer_<?= $i ?>_<?= $q->id ?>[]" id="answer_<?= $i ?>_<?= $o->option ?>" value="<?= $o->value ?>">

                                                            <?php endif; ?>
                                                            <label class="form-check-label" for="answer_<?= $i ?>_<?= $o->option ?>">
                                                                {{$o->option}}
                                                            </label>
                                                        </div>
                                                    <?php endforeach; ?>
                                                <?php
                                                elseif ($q->jenis == 'sa') :
                                                    $option = DB::table('quest_options')->where('quest_question_id', $q->id)->orderBy('value')->get();

                                                    $answer = DB::table('quest_answers')->where('quest_question_id', $q->id)->where('respondent_id', $respondent->id)->get();
                                                    $finalAnswer = '';
                                                    foreach ($answer as $a) {
                                                        $finalAnswer = $a->answer;
                                                    }
                                                ?>
                                                    <?php foreach ($option as $o) : ?>
                                                        <div class="form-check" style="text-align: left;">
                                                            <?php if ($finalAnswer == '') : ?>
                                                                <input class="form-check-input col-md-1" type="radio" name="answer_<?= $i ?>_<?= $q->id ?>[]" id="answer_<?= $i ?>_<?= $o->option ?>" value="<?= $o->value ?>">
                                                            <?php else : ?>
                                                                <input class="form-check-input col-md-1" type="radio" name="answer_<?= $i ?>_<?= $q->id ?>[]" id="answer_<?= $i ?>_<?= $o->option ?>" value="<?= $o->value ?>" <?= ($finalAnswer == $o->value) ? 'checked'  : '' ?>>
                                                            <?php endif; ?>
                                                            <label class="form-check-label" for="answer_<?= $i ?>_<?= $o->option ?>">
                                                                {{$o->option}}
                                                            </label>
                                                        </div>
                                                    <?php endforeach; ?>
                                                    <!-- </div> -->
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                        <?php $i++ ?>
                                    <?php endforeach; ?>
                                </div>
                                <!-- </div> -->
                                <!-- <div id="two" class="split" style="padding: 10px;"> -->

                                <div class="col-lg-6">
                                    <?php $i = 1; ?>
                                    <?php foreach ($questQuestion as $q) : ?>
                                        <?php if ($i % 2 == 0) : ?>
                                            <div style="min-height: 200px;">
                                                <h5 style="margin-top: 10px;">{{$i}}. {{$q->pertanyaan}}</h5>
                                                <?php if ($q->jenis == 'fa') : ?>
                                                    <?php $answer = DB::table('quest_answers')->where('quest_question_id', '=', $q->id)->where('respondent_id', $respondent->id)->first(); ?>
                                                    <?php if (isset($answer->answer)) : ?>
                                                        <input class="form-control" type="text" name="answer_<?= $i ?>_<?= $q->id ?>" value="<?= is_null($answer->answer) ? '' : $answer->answer ?>">
                                                    <?php else : ?>
                                                        <input class="form-control" type="text" name="answer_<?= $i ?>_<?= $q->id ?>" value="">
                                                    <?php endif; ?>
                                                <?php
                                                elseif ($q->jenis == 'ma') :
                                                    $option = DB::table('quest_options')->where('quest_question_id', $q->id)->orderBy('value')->get();
                                                    $answer = DB::table('quest_answers')->where('quest_question_id', '=', $q->id)->where('respondent_id', $respondent->id)->get();
                                                    $arrAnswer = [];
                                                    foreach ($answer as $a) {
                                                        $arrLastChar = explode('_', $a->answer_code);
                                                        $lastChar = $arrLastChar[count($arrLastChar) - 1];
                                                        $arrAnswer[$lastChar] = $a->answer;
                                                    }
                                                ?>
                                                    <?php foreach ($option as $o) : ?>

                                                        <div class="form-check" style="text-align: left;">
                                                            <?php
                                                            ?>
                                                            <?php if ($arrAnswer) : ?>
                                                                <?php if (isset($arrAnswer[$o->value])) : ?>
                                                                    <input class="form-check-input col-md-1" type="checkbox" name="answer_<?= $i ?>_<?= $q->id ?>[]" id="answer_<?= $i ?>_<?= $o->option ?>" value="<?= $o->value ?>" <?= ($arrAnswer[$o->value] == 1) ? 'checked' : '' ?>>
                                                                <?php else : ?>
                                                                    <input class="form-check-input col-md-1" type="checkbox" name="answer_<?= $i ?>_<?= $q->id ?>[]" id="answer_<?= $i ?>_<?= $o->option ?>" value="<?= $o->value ?>">
                                                                <?php endif; ?>
                                                            <?php else : ?>
                                                                <input class="form-check-input col-md-1" type="checkbox" name="answer_<?= $i ?>_<?= $q->id ?>[]" id="answer_<?= $i ?>_<?= $o->option ?>" value="<?= $o->value ?>">
                                                            <?php endif; ?>
                                                            <label class="form-check-label" for="answer_<?= $i ?>_<?= $o->option ?>">
                                                                {{$o->option}}
                                                            </label>
                                                        </div>

                                                    <?php endforeach; ?>

                                                <?php
                                                elseif ($q->jenis == 'sa') :
                                                    $option = DB::table('quest_options')->where('quest_question_id', $q->id)->orderBy('value')->get();
                                                    $answer = DB::table('quest_answers')->where('quest_question_id', $q->id)->where('respondent_id', $respondent->id)->get();
                                                    $finalAnswer = '';
                                                    foreach ($answer as $a) {
                                                        $finalAnswer = $a->answer;
                                                    }
                                                ?>
                                                    <?php foreach ($option as $o) : ?>
                                                        <div class="form-check" style="text-align: left;">
                                                            <input class="form-check-input col-md-1" type="radio" name="answer_<?= $i ?>_<?= $q->id ?>[]" id="answer_<?= $i ?>_<?= $o->option ?>" value="<?= $o->value ?>" <?= ($finalAnswer == $o->value) ? 'checked'  : '' ?>>
                                                            <label class="form-check-label" for="answer_<?= $i ?>_<?= $o->option ?>">
                                                                {{$o->option}}
                                                            </label>
                                                        </div>
                                                    <?php endforeach; ?>
                                                    <!-- </div> -->
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                        <?php $i++ ?>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </form>
                <?php endif; ?>
                <hr>
                <!-- </div> -->
                <?php if ($respondent->status_callback_id == 1) : ?>
                    <div class="row">
                        <div class="offset-md-10 col-md-1">
                            @if($getQuestAnswer && Session::get('role_id') != 6)
                            <?php if ($checkFilled > 0) : ?>
                                <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#checkModal">Check</button>
                            <?php endif; ?>
                            @endif
                        </div>
                        <div class="col-md-1">
                            <button type="submit" id="btn-save" class="btn btn-sm btn-primary">Save</button>
                        </div>
                    <?php endif; ?>
                    </div>
            </div>
        </div>
        <!-- /page content -->

        <!-- footer content -->
        @include('layouts.gentelella.footer')
        <!-- /footer content -->
    </div>
    </div>

    <div class="modal fade bd-example-modal-lg" id="checkModal" tabindex="-1" role="dialog" aria-labelledby="checkModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="checkModalLabel">Pengecekan Jawaban</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <p><strong>Kiri: Jawaban hasil QC</strong></p>
                    <p><b>Kanan: Jawaban Upload QC</b></p>
                    <?php
                    $checkDuplicate = [];
                    foreach ($getQuestAnswer as $g) :
                        $getQuestion = DB::table('quest_questions')->where('id', $g->quest_question_id)->first();
                        $check = DB::table('quest_answer_uploads')->where('respondent_id', $id)->where('answer_code', strtolower($getQuestion->quest_code))->first();
                        if (!is_null($check)) {
                            if ($g->answer != $check->answer) :
                                if (!in_array($getQuestion->pertanyaan, $checkDuplicate)) :
                                    array_push($checkDuplicate, $getQuestion->pertanyaan);
                    ?>
                                    <p style="color: black;"></p>
                                    <div class="heading">
                                        <?= $getQuestion->pertanyaan ?>
                                    </div>

                                    <div class="flex">
                                        <div id="one" class="split" style="height:100px" style="padding: 10px;">
                                            <?php if ($getQuestion->jenis == 'fa') : ?>
                                                <?php $answer = DB::table('quest_answers')->where('quest_question_id', $getQuestion->id)->where('respondent_id', $respondent->id)->get(); ?>
                                                <?php foreach ($answer as $a) :  ?>
                                                    <p><?= isset($a->answer) ? $a->answer : '' ?></p>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                            <?php if ($getQuestion->jenis == 'sa') : ?>
                                                <?php $answer = DB::table('quest_answers')->where('quest_question_id', $getQuestion->id)->where('respondent_id', $respondent->id)->get();
                                                ?>
                                                <?php foreach ($answer as $a) : ?>
                                                    <?php $optionAnswer = DB::table('quest_options')->where('quest_question_id', $getQuestion->id)->where('value', $a->answer)->first(); ?>
                                                    <p><?= isset($optionAnswer->option) ? $optionAnswer->option : '' ?></p>
                                                <?php endforeach; ?>
                                            <?php endif; ?>

                                        </div>
                                        <div id="two" class="split" style="height:100px" style="padding: 10px;">
                                            <?php if ($getQuestion->jenis == 'fa') : ?>
                                                <?php $answer = DB::table('quest_answers')->join('quest_questions', 'quest_questions.id', '=', 'quest_answers.quest_question_id')->where('quest_question_id', $getQuestion->id)->where('respondent_id', $respondent->id)->get(); ?>
                                                <?php foreach ($answer as $a) :  ?>
                                                    <?php $answerUploads = DB::table('quest_answer_uploads')->where('answer_code', $a->quest_code)->where('respondent_id', $id)->first(); ?>
                                                    <p><?= isset($answerUploads->answer) ? $answerUploads->answer : '' ?></p>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                            <?php if ($getQuestion->jenis == 'sa') : ?>
                                                <?php $answer = DB::table('quest_answers')->join('quest_questions', 'quest_questions.id', '=', 'quest_answers.quest_question_id')->where('quest_question_id', $getQuestion->id)->where('respondent_id', $respondent->id)->get(); ?>
                                                <?php foreach ($answer as $a) :  ?>
                                                    <?php $answerUploads = DB::table('quest_answer_uploads')->where('answer_code', $a->quest_code)->where('respondent_id', $id)->first(); ?>
                                                    <?php $optionAnswer = DB::table('quest_options')->where('quest_question_id', $getQuestion->id)->where('value', $answerUploads->answer)->first(); ?>
                                                    <p><?= isset($optionAnswer->option) ? $optionAnswer->option : '' ?></p>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <?php
                                endif;
                            endif;
                        } else {
                            if ($getQuestion->jenis == 'ma') :
                                $status = 0;
                                $check = DB::table('quest_answer_uploads')->where('respondent_id', $id)->where('answer_code', 'like', strtolower($getQuestion->quest_code) . '%')->get();
                                foreach ($check as $c) {
                                    $explode = explode('_', $c->answer_code);
                                    $result = '';
                                    for ($i = 0; $i < count($explode) - 1; $i++) {
                                        $result .= $explode[$i];
                                        if ($i < count($explode) - 2)
                                            $result .= '_';
                                    }


                                    $questAnswer = DB::table('quest_questions')->join('quest_answers', 'quest_answers.quest_question_id', '=', 'quest_questions.id')->where('quest_code_id', '=', $getQuestion->quest_code_id)->where('quest_code', '=', $result)->where('answer_code', '=', $explode[count($explode) - 1])->where('quest_answers.respondent_id', '=', $id)->first();

                                    if (!is_null($questAnswer)) {
                                        if ($questAnswer->answer == $c->answer) {
                                            $status = 0;
                                        } else {
                                            $status = 1;
                                            break;
                                        }
                                    }
                                }

                                if ($status == 1) :
                                    if (!in_array($getQuestion->pertanyaan, $checkDuplicate)) :
                                        array_push($checkDuplicate, $getQuestion->pertanyaan);
                                    ?>
                                        <div class="heading">
                                            <?= $getQuestion->pertanyaan ?>
                                        </div>
                                        <div class="flex">
                                            <div id="one" class="split" style="height:100px" style="padding: 10px;">
                                                <?php $answer = DB::table('quest_answers')->where('quest_question_id', $getQuestion->id)->where('respondent_id', $respondent->id)->get(); ?>
                                                <?php foreach ($answer as $a) :  ?>
                                                    <?php if ($a->answer == 1) : ?>
                                                        <?php
                                                        $key = $a->answer_code;
                                                        $explodeString = explode('_', $key);
                                                        $questionId = $explodeString[count($explodeString) - 1];
                                                        ?>
                                                        <?php $optionAnswer = DB::table('quest_options')->where('quest_question_id', $getQuestion->id)->where('value', $questionId)->get(); ?>
                                                        <?php foreach ($optionAnswer as $o) : ?>
                                                            <p><?= isset($o->option) ? $o->option : '' ?></p>

                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </div>
                                            <div id="two" class="split" style="height:100px" style="padding: 10px;">

                                                <?php
                                                $check = DB::table('quest_answer_uploads')->where('respondent_id', $id)->where('answer_code', 'like', strtolower($getQuestion->quest_code) . '%')->get();
                                                foreach ($check as $c) {
                                                    if ($c->answer == 1) {
                                                        $explode = explode('_', $c->answer_code);
                                                        $result = '';
                                                        for ($i = 0; $i < count($explode) - 1; $i++) {
                                                            $result .= $explode[$i];
                                                            if ($i < count($explode) - 2)
                                                                $result .= '_';
                                                        }
                                                        $getOption = DB::table('quest_options')->where('quest_question_id', '=', $g->id)->where('value', '=', $explode[count($explode) - 1])->first();
                                                        echo isset($getOption->option) ? $getOption->option : '';
                                                        echo "<br>";
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>
                    <?php
                                    endif;
                                endif;

                            endif;
                        }

                    endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="formQcModal" tabindex="-1" role="dialog" aria-labelledby="formQcModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formQcModalLabel">Form Laporan Callback</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ url('/form_qc/store_form_qc/')}}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{$respondent->id}}">

                        <div class="form-group">
                            <label for="tanggal_qc">Tanggal QC</label>
                            <input type="date" class="form-control" id="tanggal_qc" name="tanggal_qc" placeholder="" required>
                        </div>
                        <div class="form-group">
                            <label for="jam_qc">Jam QC</label>
                            <input type="time" class="form-control" id="jam_qc" name="jam_qc" placeholder="" required>
                        </div>
                        <div class="form-group">
                            <label for="jumlah_qc">Callback Ke Berapa</label>
                            <input type="number" class="form-control" id="jumlah_qc" name="jumlah_qc" placeholder="" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="jumlah_qc">Bukti Rekaman <a type="button" style="color: lightblue; text-decoration: none; cursor: help;" data-toggle="tooltip" data-placement="top" title="Maks. size 5MB"> <i class="fa fa-fw fa-question-circle"></i></a></label>
                            <div class="custom-file">
                                <input type="file" accept="audio/mp3,audio/*;capture=microphone" class="custom-file-input" name="file" id="file" required>
                                <label class="custom-file-label" for="inputGroupFile01" id="fileText">Choose file</label>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="btn-submit-form-qc" name="button">Submit</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="formCallbackModal" tabindex="-1" role="dialog" aria-labelledby="formCallbackModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formCallbackModalLabel">Form Status Callback</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ url('/form_qc/set_callback/')}}">
                        @csrf
                        <input type="hidden" name="id" value="{{$respondent->id}}">

                        <div class="item form-group">
                            <p>Status Callback</p>
                            <select id="status_callback_id" name="value" class="form-control" required>
                                <option value="">-</option>
                                @foreach($status_callback as $db)
                                <option value="<?= $db->id ?>"> <?= $db->keterangan_callback ?> </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="container">
                            <div class="row">
                                <div class="col-lg-1">
                                    <div>
                                        <b>#</b>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="text-center">
                                        <b>Status Callback</b>
                                    </div>
                                </div>
                                <div class="col-lg-5">
                                    <div class="text-center">
                                        <b>Timestamp</b>
                                    </div>
                                </div>
                            </div>
                            @foreach($logCallback as $lq)
                            <div class="row">
                                <div class="col-lg-1">
                                    <div>
                                        {{$loop->iteration}}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div>
                                        {{$lq->status_callback->keterangan_callback}}
                                    </div>
                                </div>
                                <div class="col-lg-5">
                                    <div class="text-center">
                                        {{$lq->created_at}}
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <!-- <div class="form-group">
                            <label for="tanggal_qc">Tanggal QC</label>
                            <input type="date" class="form-control" id="tanggal_qc" name="tanggal_qc" placeholder="" required>
                        </div>
                        <div class="form-group">
                            <label for="jam_qc">Jam QC</label>
                            <input type="time" class="form-control" id="jam_qc" name="jam_qc" placeholder="" required>
                        </div>
                        <div class="form-group">
                            <label for="jumlah_qc">Callback Ke Berapa</label>
                            <input type="number" class="form-control" id="jumlah_qc" name="jumlah_qc" placeholder="" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="jumlah_qc">Bukti Rekaman</label>
                            <div class="custom-file">
                                <input type="file" accept="audio/mp3,audio/*;capture=microphone" class="custom-file-input" name="file" id="file" required>
                                <label class="custom-file-label" for="inputGroupFile01" id="fileText">Choose file</label>
                            </div>
                        </div> -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="btn-submit-callback" name="button">Submit</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="formPengecekanModal" tabindex="-1" role="dialog" aria-labelledby="formPengecekanModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formPengecekanModalLabel">Form Pengecekan Rekaman</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><b>Rekaman </b></p>
                    <?php
                    $ext = pathinfo($respondent->rekaman, PATHINFO_EXTENSION);
                    $audioExt = ['mp3', 'wav', 'ogg', 'flac'];
                    if (in_array($ext, $audioExt)) :
                    ?>
                        <div class="text-center">
                            <audio controls>
                                <source src="{{$respondent->rekaman}}" type="audio/ogg">
                                <source src="{{$respondent->rekaman}}" type="audio/mpeg">
                                Your browser does not support the audio element.
                            </audio>
                        </div>
                    <?php endif; ?>
                    <p>Klik <a target="_blank" href="{{$respondent->rekaman}}" class="text-primary">disini</a> untuk mendownload</p>
                    <hr>
                    <br>
                    <form method="post" action="{{ url('/form_pengecekan/')}}" id="form-pengecekan-rekaman">
                        @csrf
                        <input type="hidden" name="id" value="{{$respondent->id}}">
                        <?php $i = 1; ?>
                        <?php foreach ($status_pengecekan as $sp) : ?>
                            <div class="form-group">
                                <div>
                                    <p><?= $i . '. ' . $sp['keterangan_gagal_pengecekan'] ?></p>
                                    <div class="form-check float-left">
                                        <input class="form-check-input " type="radio" id="s<?= $i ?>y" value="1" name="s<?= $i ?>">
                                        <label class="form-check-label ml-3" for="s<?= $i ?>y">Ya</label>
                                    </div>
                                    <div class="form-check float-left">
                                        <input class="form-check-input" type="radio" id="s<?= $i ?>n" value="0" name="s<?= $i ?>">
                                        <label class="form-check-label ml-4" for="s<?= $i ?>n">Tidak</label>
                                    </div>
                                </div>
                                <br>
                            </div>
                            <?php $i++; ?>
                        <?php endforeach; ?>
                        <div class="form-group">
                            <label for="temuan">Temuan (isi secara mendetail)</label>
                            <textarea class="form-control" id="temuan" name="temuan" rows="3"></textarea>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btn-submit-form-pengecekan" name="button" value="tl">Submit</button>
                </div>
                </form>
            </div>
        </div>
    </div>


    <!-- jQuery -->
    <script src="{{url('../assets/gentelella')}}/vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="{{url('../assets/gentelella')}}/vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- FastClick -->
    <script src="{{url('../assets/gentelella')}}/vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="{{url('../assets/gentelella')}}/vendors/nprogress/nprogress.js"></script>
    <!-- iCheck -->
    <script src="{{url('../assets/gentelella')}}/vendors/iCheck/icheck.min.js"></script>
    <!-- Datatables -->
    <script src="{{url('../assets/gentelella')}}/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="{{url('../assets/gentelella')}}/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="{{url('../assets/gentelella')}}/vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="{{url('../assets/gentelella')}}/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="{{url('../assets/gentelella')}}/vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="{{url('../assets/gentelella')}}/vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="{{url('../assets/gentelella')}}/vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="{{url('../assets/gentelella')}}/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="{{url('../assets/gentelella')}}/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="{{url('../assets/gentelella')}}/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="{{url('../assets/gentelella')}}/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="{{url('../assets/gentelella')}}/vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
    <script src="{{url('../assets/gentelella')}}/vendors/jszip/dist/jszip.min.js"></script>
    <script src="{{url('../assets/gentelella')}}/vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="{{url('../assets/gentelella')}}/vendors/pdfmake/build/vfs_fonts.js"></script>
    <!-- Switchery -->
    <script src="{{url('../assets/gentelella')}}/vendors/switchery/dist/switchery.min.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="{{url('../assets/gentelella')}}/build/js/custom.min.js"></script>

    {{-- SCRIPT --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>

    <script>
        const showPengecekanRekaman = '<?= $showPengecekanRekaman ?>';
        // console.log(showPengecekanRekaman);
        if (showPengecekanRekaman) {
            $('#formPengecekanModal').modal('show');
        }

        $(document).ready(function() {
            $('#btn-submit-form-pengecekan').click(function() {
                const i = parseInt('<?= $i ?>') - 1;
                let globalStatus = 0;
                for (let x = 1; x <= i; x++) {
                    const getInput = document.querySelectorAll(`input[name=s${x}]`);
                    let status = 0;
                    getInput.forEach(function(e) {
                        if (e.checked) status = 1;
                    })
                    if (status != 0) {
                        globalStatus++;
                    }
                }
                if (globalStatus == i && $('#temuan').val()) {
                    document.getElementById("form-pengecekan-rekaman").submit();
                } else {
                    $('#form-pengecekan-rekaman').submit(function(e) {
                        e.preventDefault();
                    })
                    alert('Seluruh pertanyaan harus dijawab.');
                }
            });

            $('#btn-save').click(function(e) {
                console.log($('#code').val());
                if ($('#code').val() != '') {
                    $("#form-respondent").submit();
                } else {
                    alert('Harap Mengisi data dengan benar.')
                }
            })

            // $('#status_callback_id').change(function() {
            //     // console.log($(this).val());
            //     console.log();
            //     const value = $(this).val();
            //     $.ajax({
            //         url: "{{url('form_qc/set_callback')}}",
            //         type: 'post',
            //         data: {
            //             value: value,
            //             id: <?= $id ?>,
            //             _token: "{{ csrf_token() }}"
            //         },
            //         success: function(hasil) {
            //             console.log(hasil);
            //             document.location.href = "{{ url('/form_qc/qc_respondent')}}/" + <?= $id ?>;
            //         }
            //     });
            // })

            // $('#btn-submit-form-qc').click(function(e) {
            //     console.log($(this).val());
            //     e.preventDefault();

            //     const tanggal_qc = $('#tanggal_qc').val();
            //     const jam_qc = $('#jam_qc').val();
            //     const jumlah_qc = $('#jumlah_qc').val();

            //     let image = $('input[name=file]').prop('files')[0];
            //     form_data = new FormData();
            //     form_data.append("file", image);
            //     form_data.append("tanggal_qc", tanggal_qc);
            //     form_data.append("jam_qc", jam_qc);
            //     form_data.append("jumlah_qc", jumlah_qc);
            //     form_data.append("id", <?= $id ?>);

            //     $.ajaxSetup({
            //         headers: {
            //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //         }
            //     });

            //     $.ajax({
            //         url: "{{ url('form_qc/store_form_qc')}}",
            //         type: 'post',
            //         data: form_data,
            //         processData: false,
            //         contentType: false,
            //         success: function(hasil) {
            //             console.log(hasil);
            //         },
            //         error: function(xhr, ajaxOptions, thrownError) {
            //             alert(xhr.responseText);
            //         }
            //     });
            // })


            const inputFile1 = $('#file');
            inputFile1.change(function() {
                let string = $(this).val().split('\\');
                $('#fileText').text(string[string.length - 1]);
            })
        })
    </script>
</body>

</html>