@extends('maingentelellatable')
@section('title', 'Daftar Responden : ' . $respondents->count())



@section('content')

{{-- Filter --}}
<div class="col-md-12 col-sm-12 ">
    <div class="x_panel">
        <div class="x_title">
            <h2>Filter:</h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card-box">
                        <p class="text-muted font-13 m-b-30">
                            Filter kriteria yang anda pilih:
                        </p>

                        <form class="form-horizontal form-label-left" method="get" action="{{url('/respondents')}}">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div align="left" class="col-md-4 col-sm-4 col-xs-12">
                                            <!-- Project -->
                                            <div class="form-group row">
                                                <label class="col-form-label col-md-3 col-sm-3" for="project_imported_id">Project
                                                    <a type="button" style="color: lightblue; text-decoration: none; cursor: help;" data-toggle="tooltip" data-placement="top" title="Show filter project terlebih dahulu"> <i class="fa fa-fw fa-question-circle"></i></a>
                                                </label>
                                                <div class="col-md-9 col-sm-9">
                                                    <select id="project_imported_id" name="project_imported_id" data-live-search="true" class="form-control pull-right selectpicker">
                                                        <option value="all">All</option>
                                                        @foreach($project_importeds as $db)
                                                        @if(isset($_GET['project_imported_id']) and $_GET['project_imported_id'] == $db['id'])
                                                        <option value="{{$db['id']}}" selected>{{$db['project_imported']}}</option>
                                                        @else
                                                        <option value="{{$db['id']}}"> {{$db['project_imported']}}</option>
                                                        @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Kota -->
                                            <div class="form-group row">
                                                <label class="col-form-label col-md-3 col-sm-3" for="kota_id">Kota</label>
                                                <div class="col-md-9 col-sm-9">
                                                    <select id="kota_id" name="kota_id" class="form-control selectpicker" data-live-search="true">
                                                        <option value="all">All</option>
                                                        @foreach($kotas as $db)
                                                        @if(isset($_GET['kota_id']) and $_GET['kota_id'] == $db['id'])
                                                        <option value="{{$db['id']}}" selected>{{$db['kota']}}</option>
                                                        @else
                                                        <option value="{{$db['id']}}"> {{$db['kota']}}</option>
                                                        @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <!-- Gender -->
                                            <div class="form-group row">
                                                <label class="col-form-label col-md-3 col-sm-3" for="gender_id">Gender</label>
                                                <div class="col-md-9 col-sm-9">
                                                    <select id="gender_id" name="gender_id" class="form-control pull-right">
                                                        <option value="all">All</option>
                                                        @foreach($genders as $db)
                                                        @if(isset($_GET['gender_id']) and $_GET['gender_id'] == $db['id'])
                                                        <option value="{{$db['id']}}" selected>{{$db['gender']}}</option>
                                                        @else
                                                        <option value="{{$db['id']}}"> {{$db['gender']}}</option>
                                                        @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div align="left" class="col-md-4 col-sm-4 col-xs-12">
                                            <!-- SES -->
                                            <div class="form-group row">
                                                <label class="col-form-label col-md-3 col-sm-3" for="ses_final_id">SES</label>
                                                <div class="col-md-9 col-sm-9">
                                                    <select id="ses_final_id" name="ses_final_id" class="form-control">
                                                        <option value="all">All</option>
                                                        @foreach($ses_finals as $db)
                                                        @if(isset($_GET['ses_final_id']) and $_GET['ses_final_id'] == $db['id'])
                                                        <option value="{{$db['id']}}" selected>{{$db['ses_final']}}</option>
                                                        @else
                                                        <option value="{{$db['id']}}"> {{$db['ses_final']}}</option>
                                                        z @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <!-- Pendidikan -->
                                            <div class="form-group row">
                                                <label class="col-form-label col-md-3 col-sm-3" for="pendidikan_id">Pendidikan</label>
                                                <div class="col-md-9 col-sm-9">
                                                    <select id="pendidikan_id" name="pendidikan_id" class="form-control">
                                                        <option value="all">All</option>
                                                        @foreach($pendidikans as $db)
                                                        @if(isset($_GET['pendidikan_id']) && $_GET['pendidikan_id'] == $db['id'])
                                                        <option value="{{$db['id']}}" selected>{{$db['pendidikan']}}</option>
                                                        @else
                                                        <option value="{{$db['id']}}"> {{$db['pendidikan']}}</option>
                                                        @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>


                                            <!-- Pekerjaan -->
                                            <div class="form-group row">
                                                <label class="col-form-label col-md-3 col-sm-3" for="pekerjaan_id">Pekerjaan</label>
                                                <div class="col-md-9 col-sm-9">
                                                    <select id="pekerjaan_id" name="pekerjaan_id" class="form-control">
                                                        <option value="all">All</option>
                                                        @foreach($pekerjaans as $db)
                                                        @if(isset($_GET['pekerjaan_id']) && $_GET['pekerjaan_id'] == $db['id'])
                                                        <option value="{{$db['id']}}" selected>{{$db['pekerjaan']}}</option>
                                                        @else
                                                        <option value="{{$db['id']}}"> {{$db['pekerjaan']}}</option>
                                                        @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div align="left" class="col-md-4 col-sm-4 col-xs-12">
                                            <!-- Valid Data  -->
                                            <div class="form-group row">
                                                <label class="col-form-label col-md-3 col-sm-3" for="is_valid_id">Responden Valid</label>
                                                <div class="col-md-9 col-sm-9">
                                                    <select id="is_valid_id" name="is_valid_id" class="form-control">
                                                        <option value="all">All</option>
                                                        @foreach($is_valids as $db)
                                                        @if(isset($_GET['is_valid_id']) && $_GET['is_valid_id'] == $db['id'])
                                                        <option value="{{$db['id']}}" selected>{{$db['is_valid']}}</option>
                                                        @else
                                                        <option value="{{$db['id']}}"> {{$db['is_valid']}}</option>
                                                        @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-form-label col-md-3 col-sm-3" for="interviewer">Interviewer</label>
                                                <div class="col-md-9 col-sm-9">
                                                    <select id="interviewer" name="interviewer_id" class="form-control selectpicker"  data-live-search="true">
                                                        <option value="all">All</option>
                                                        @foreach($interviewers as $db)
                                                        @if(isset($_GET['interviewer_id']) && isset($db['id']))
                                                        @if($_GET['interviewer_id'] == $db['id'])
                                                        <option value="{{$db['id']}}" selected>{{$db['nama']}}</option>
                                                        @else
                                                        <option value="{{$db['id']}}"> {{$db['nama']}}</option>
                                                        @endif
                                                        @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-form-label col-md-3 col-sm-3" for="segment_worksheet">Segment Worksheet</label>
                                                <div class="col-md-9 col-sm-9">
                                                    <select id="segment_worksheet" name="segment_worksheet" class="form-control">
                                                        <option value="all">All</option>
                                                        @foreach($segment as $db)
                                                        @if(isset($_GET['segment_worksheet']) && isset($db['worksheet']))
                                                        @if($_GET['segment_worksheet'] == $db['worksheet'])
                                                        <option value="{{$db['worksheet']}}" selected>{{$db['worksheet']}}</option>
                                                        @else
                                                        <option value="{{$db['worksheet']}}"> {{$db['worksheet']}}</option>
                                                        @endif
                                                        @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" id="link_from" name="link_from" value="{{session('link_from')}}">

                                    </div>

                                    <div align="center" class="form-group">
                                        <a href="{{url()->current()}}" type="button" class="btn btn-info text-white"> Reset </a>
                                        <button type="submit" class="btn btn-info"> Show </button>
                                        <?php
                                        $request = "";
                                        // $request = isset($_SERVER['QUERY_STRING']) ? ltrim($_SERVER['QUERY_STRING'], !empty($_SERVER['QUERY_STRING']))ltrim($_SERVER['QUERY_STRING'], !empty($_SERVER['QUERY_STRING'])) ;
                                        ?>
                                        <a href="{{url('respondents/pick_respondent?')}}{{$request}}" type="button" class="btn btn-info" id="btn-pick-respondent">Pick Respondent </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$totalData = ($respondents) ? count($respondents) : 0;

$witness = 0;
$aktualStatusQc1 = 0;
$dropOut = 0;
$lolosQc = 0;
foreach ($respondents as $r) {
    if ($r['pewitness']) $witness++;
    if ($r['status_qc_id'] == 2 || $r['status_qc_id'] == 3 || $r['status_qc_id'] == 6 || $r['status_qc_id'] == 9) $dropOut++;
    else if ($r['status_qc_id'] == 5) $lolosQc++;
}

$totalBersih = $totalData - $dropOut;
if (($dropOut + $aktualStatusQc1 + $lolosQc) == 0) {
    $persentaseDropOut = 0;
    $persentaseLolosQc = 0;
} else {
    $persentaseDropOut = ($totalData) ? number_format((float)($dropOut / $totalData), 2, '.', '') : 0;
    $persentaseLolosQc = ($totalBersih) ? number_format((float)($lolosQc / $totalBersih), 2, '.', '') : 0;
}

$targetQc = ceil($totalBersih * 0.3);
$persentaseTargetQc = ($totalBersih) ? number_format((float)($targetQc / $totalBersih), 2, '.', '') : 0;
$persentaseWitness = ($totalBersih) ? number_format((float)($witness / $totalBersih), 2, '.', '') : 0;
$belumQc = (($targetQc - ($witness + $lolosQc)) > 0) ? ($targetQc - ($witness + $lolosQc)) : 0;
$persentaseBelumQc = ($totalBersih) ? number_format((float)($belumQc / $totalBersih), 2, '.', '') : 0;
?>

{{-- Filter --}}
<div class="col-md-12 col-sm-12 ">
    <div class="x_panel">
        <div class="x_title">
            <h2>Data Persentase</h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card-box">
                        <div class="row tile_count justify-content-center">
                            <div align="center" class="col-md-2 col-sm-3 col-xs-3 tile_stats_count">
                                <a href=""> <span class="count_top "><b> Total Data </b></span>
                                    <div class="count " style="color: green"><?= ($totalData) ?></div>
                                </a>
                                <hr>
                            </div>
                            <div align="center" class="col-md-2 col-sm-3 col-xs-3 tile_stats_count">
                                <a href="projects"> <span class="count_top "> <b>Drop Out </b></span>
                                    <div class="count " style="color: green"><?= $dropOut ?></div>
                                </a>
                                <hr>
                                <a href=""> <span class="count_top "><b> </b></span>
                                    <div class="count " style="color: green"><?= $persentaseDropOut * 100 ?>%</div>
                                </a>
                            </div>
                            <div align="center" class="col-md-2 col-sm-3 col-xs-3 tile_stats_count">
                                <a href=""> <span class="count_top "><b> Total Bersih </b></span>
                                    <div class="count " style="color: green"><?= ($totalBersih) ?></div>
                                </a>
                                <hr>
                            </div>
                        </div>
                        <div class="row tile_count justify-content-center">
                            <div align="center" class="col-md-2 col-sm-3 col-xs-3 tile_stats_count">
                                <a href=""> <span class="count_top "><b> Target QC </b></span>
                                    <div class="count " style="color: green"><?= $targetQc ?></div>
                                </a>
                                <hr>
                                <a href=""> <span class="count_top "><b> </b></span>
                                    <div class="count " style="color: green"><?= $persentaseTargetQc * 100 ?>%</div>
                                </a>
                            </div>
                            <div align="center" class="col-md-2 col-sm-3 col-xs-3 tile_stats_count">
                                <a href=""> <span class="count_top "><b> Lolos QC </b></span>
                                    <div class="count " style="color: green"><?= $lolosQc ?></div>
                                </a>
                                <hr>
                                <a href=""> <span class="count_top "><b> </b></span>
                                    <div class="count " style="color: green"><?= $persentaseLolosQc * 100 ?>%</div>
                                </a>
                            </div>
                            <div align="center" class="col-md-2 col-sm-3 col-xs-3 tile_stats_count">
                                <a href="teams"> <span class="count_top "> <b>Belum di QC </b></span>
                                    <div class="count " style="color: green"><?= $belumQc ?></div>
                                </a>
                                <hr>
                                <a href=""> <span class="count_top "><b> </b></span>
                                    <div class="count " style="color: green"><?= $persentaseBelumQc * 100 ?>%</div>
                                </a>
                            </div>
                            <div align="center" class="col-md-2 col-sm-3 col-xs-3 tile_stats_count">
                                <a href=""> <span class="count_top "><b> Witness </b></span>
                                    <div class="count " style="color: green"><?= $witness ?></div>
                                </a>
                                <hr>
                                <a href=""> <span class="count_top "><b> </b></span>
                                    <div class="count " style="color: green"><?= $persentaseWitness * 100 ?>%</div>
                                </a>
                            </div>

                        </div>
                        <!-- </form> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


{{-- Standard Table TOP --}}
@include('layouts/gentelella/table_top')
{{-- End of Standard table TOP --}}
<div class="row position-absolute" style="top: -10px;right: 137px">
    <div class="col-lg-9">
    </div>
    <div class="col align-self-end">
        <img style="width: 25px; height: 15px;" src="{{ url('images/indianred.jfif') }}" /> <strong class="ml-2">Drop Out</strong>
    </div>
</div>

<div class="row position-absolute" style="top: -10px;right:47px">
    <div class="col-lg-9">
    </div>
    <div class="col align-self-end">
        <img style="width: 25px; height: 15px;" src="{{ url('images/greenyellow.jpg') }}" /> <strong class="ml-2">Ok</strong>
    </div>
</div>

<div class="row position-absolute" style="right: 50px; top: 10px;">
    <div class="col-lg-9">
    </div>
    <div class="col align-self-end">
        <img style="width: 25px; height: 15px;" src="{{ url('images/yellow.png') }}" /> <strong class="ml-2">Perbaikan/On Progress</strong>
    </div>
</div>
<div class="row position-absolute" style="right: 60px; top: 30px;">
    <div class="col-lg-9">
    </div>
    <div class="col align-self-end">
        <img style="width: 25px; height: 15px;" src="{{ url('images/lightblue.png') }}" /> <strong class="ml-2">Ok Setelah Perbaikan</strong>
    </div>
</div>
<div class="row position-absolute" style="right: 127px; top: 50px; margin-bottom: 30px;">
    <div class="col-lg-9">
    </div>
    <div class="col align-self-end">
        <img style="width: 25px; height: 15px;" src="{{ url('images/orange.jpg') }}" /> <strong class="ml-2">Flag Rules</strong>
    </div>
</div>
<thead>
    <tr>
        <th>No.</th>
        <th>Nama</th>
        <th>Gender</th>
        <th>Kota</th>
        <th>Kelurahan</th>
        <th>HP</th>
        <th>Interviewer</th>
        <th>Pewitness</th>
        <th>Status QC</th>
        <th>Keterangan QC</th>

        <!-- Primary -->
        <th>Last Update QC</th>
        <th>Last Update QC By</th>
        <th>SbjNum</th>
        @if(count($user_role)>0)
        <th>Email</th>
        @endif
        <th>Usia</th>
        <th>Pendidikan</th>
        <th>Pekerjaan</th>
        <th>Jam Mulai</th>
        <th>Jam Selesai</th>
        <th>Tanggal Interview</th>
        <th>Longitude, Lattitude</th>
        <th>Link Rekaman</th>
        <th>Keterangan Rekaman</th>
        <th>Evaluasi Witness</th>
        <th>Status Callback</th>
        <th>Keterangan Callback</th>
        <th>SES</th>
        <th>Valid</th>
        <th>Last Update</th>
        <th>Tanggal Back to field</th>
        <th>Tanggal OK</th>
        <th>Flag Status</th>
        <th>Flag Rules</th>
        <th>Kategori Honor</th>
        <th>Kategori Honor DO</th>
        <th>Update oleh</th>
        <th>Status On QC</th>
        <th>Temuan DP</th>
        <th>Keterangan Temuan DP</th>
        <th>Update Temuan DP oleh</th>
        <th>Action</th>
    </tr>
</thead>
<tbody>
    @foreach ($respondents as $respondent)
    <?php if ($respondent->status_qc_id == 2 || $respondent->status_qc_id == 3 || $respondent->status_qc_id == 6 || $respondent->status_qc_id == 9) : ?>
        <tr style="background-color: indianred;">
        <?php elseif ($respondent->status_qc_id == 4) : ?>
        <tr style="background-color: yellow;">
        <?php elseif ($respondent->status_qc_id == 5) : ?>
        <tr style="background-color: greenyellow;">
        <?php elseif ($respondent->status_qc_id == 10) : ?>
        <tr style="background-color: lightblue;">
        <?php elseif (in_array($respondent->id, $arrRespondentsWithFlag) || $respondent->status_qc_id == 7) : ?>
        <tr style="background-color: orange;">
        <?php endif; ?>
        <th scope='row'>{{$loop->iteration}}</th>
        <td>{{$respondent->respname}}</td>
        <td>
            @if(isset($respondent->gender->gender))
            {{$respondent->gender->gender}} {{$respondent->id}}
            @endif
        </td>
        <td>
            @if(isset($respondent->kota->kota))
            {{$respondent->kota->kota}}
            @endif
        </td>
        <td>
            @if(isset($respondent->kelurahan->kelurahan))
            {{$respondent->kelurahan->kelurahan}}
            @endif
        </td>
            <td>{{$respondent->mobilephone}}</td>
        <td>
            <?php
            if ($respondent->srvyr) {
                $pwtCode = substr($respondent->srvyr, 3, 6);
                $pwtCode = (int)$pwtCode;

                $cityCode = substr($respondent->srvyr, 0, 3);
                $cityCode = (int)$cityCode;
                $pwt = DB::table('teams')
                    ->where('no_team', $pwtCode)
                    ->where('kota_id', $cityCode)
                    ->first();

                if ($pwt) {
                    echo $pwt->nama;
                } else {
                    echo "Kosong";
                }
            } else {
                echo "Kosong";
            }
            ?>
        </td>
        <td>
            <?php
            if ($respondent->pewitness) {
                $pwt = DB::table('teams')->where('id', $respondent->pewitness)->first();
                if ($pwt) {
                    echo $pwt->nama;
                } else {
                    echo "Kosong";
                }
            } else {
                echo "Kosong";
            }
            ?>
        </td>
        <td>
            @if(isset($respondent->status_qc->keterangan_qc))
            {{$respondent->status_qc->keterangan_qc}}
            @else
            Kosong
            @endisset
        </td>
        <td>
            @if(isset($respondent->keterangan_qc))
            {{$respondent->keterangan_qc}}
            @else
            Kosong
            @endisset
        </td>
        <td>
            @if(isset($respondent->tanggal_update_qc))
            {{$respondent->tanggal_update_qc}}
            @else
            Kosong
            @endisset
        </td>
        <td>
            <?php
            if ($respondent->id_user_qc) {
                $user = DB::table('users')->where('id', $respondent->id_user_qc)->first();
                if ($user) {
                    echo $user->nama;
                } else {
                    echo "Kosong";
                }
            } else {
                echo "Kosong";
            }
            ?>
        </td>
        <td>
            @if(isset($respondent->sbjnum))
            {{$respondent->sbjnum}}
            @else
            Kosong
            @endisset
        </td>
        @if(count($user_role)>0)
        <td>
            @if(isset($respondent->email))
            {{$respondent->email}}
            @endif
        </td>
        @endif
        <td>{{$respondent->usia + date('Y') - date_format(date_create($respondent->intvdate),'Y' )   }}</td>
        <td>
            @if(isset($respondent->pendidikan->pendidikan))
            {{$respondent->pendidikan->pendidikan}}
            @else
            Kosong
            @endisset
        </td>
        <td>
            @if(isset($respondent->pekerjaan->pekerjaan))
            {{$respondent->pekerjaan->pekerjaan}}
            @else
            Kosong
            @endisset
        </td>
        <td>{{$respondent->vstart}}</td>
        <td>{{$respondent->vend}}</td>
        <td>{{$respondent->intvdate}}</td>
        <td><?= ($respondent->longitude) ? $respondent->longitude : '-' ?>, <?= ($respondent->latitude) ? $respondent->latitude : '-' ?></td>
        <td>
            <?php if (Session::get('role_id') == 6) : ?>
                <?php if ($respondent->status_callback_id != 0 && $respondent->status_callback_id != 1 && $respondent->status_callback_id != 2) : ?>
                    @if(($respondent->rekaman))
                    <a href="{{$respondent->rekaman}}" target="_blank" rel="noopener noreferrer">{{$respondent->rekaman}}</a>
                    @else
                    Kosong
                    @endif
                <?php else : ?>
                    Locked
                <?php endif; ?>
            <?php else : ?>
                @if(($respondent->rekaman))
                <a href="{{$respondent->rekaman}}" target="_blank" rel="noopener noreferrer">{{$respondent->rekaman}}</a>
                @else
                Kosong
                @endif
            <?php endif; ?>
        </td>
        <td>
            <?php if (Session::get('role_id') == 6) : ?>
                <?php if ($respondent->status_callback_id != 0 && $respondent->status_callback_id != 2) : ?>
                    @if(isset($respondent->cek_rekaman))
                    {{$respondent->cek_rekaman}}
                    @else
                    Kosong
                    @endisset
                <?php else : ?>
                    Locked
                <?php endif; ?>
            <?php else : ?>
                @if(isset($respondent->cek_rekaman))
                {{$respondent->cek_rekaman}}
                @else
                Kosong
                @endisset
            <?php endif; ?>
        </td>
        <td>
            @if($respondent->pewitness)
            <button class='btn btn-primary btn-sm btn-modal' id="evaluasiButton" type="button" data-toggle="modal" data-target="#evaluasiModal" data-id="{{$respondent->id}}"><i class="fa fa-edit"></i></button>
            @endif
        </td>
        <td>
            @if(isset($respondent->status_callback->keterangan_callback))
            {{$respondent->status_callback->keterangan_callback}}
            @else
            Kosong
            @endisset
        </td>
        <td>
            @if(isset($respondent->callback))
            {{$respondent->callback}}
            @else
            Kosong
            @endisset
        </td>

        <td>
            @if(isset($respondent->ses_final->ses_final))
            {{$respondent->ses_final->ses_final}}
            @else
            Kosong
            @endisset
        </td>

        <td>
            @if(isset($respondent->is_valid->is_valid))
            {{$respondent->is_valid->is_valid}}
            @else
            Kosong
            @endisset
        </td>
        <td>
            @if(isset($respondent->updated_at))
            {{$respondent->updated_at}}
            @else
            Kosong
            @endisset
        </td>
        <td>
            @if(isset($respondent->tanggal_btf))
            {{$respondent->tanggal_btf}}
            @else
            Kosong
            @endisset
        </td>
        <td>
            @if(isset($respondent->tanggal_ok))
            {{$respondent->tanggal_ok}}
            @else
            Kosong
            @endisset
        </td>
        <td>
            <?php if (in_array($respondent->id, $arrRespondentsWithFlag)) :  ?>
                Flagged
            <?php else : ?>
                Clear
            <?php endif; ?>
        </td>
        <td>
            @if(isset($arrStatusFlagging[$respondent->id]))
            {{$arrStatusFlagging[$respondent->id]}}
            @else
            Kosong
            @endif
        </td>
        <td>
            @if(isset($respondent->kategori_honor))
            {{$respondent->kategori_honor}}
            @else
            Kosong
            @endisset
        </td>
        <td>
            @if(isset($respondent->kategori_honor_do))
            {{$respondent->kategori_honor_do}}
            @else
            Kosong
            @endisset
        </td>
        <td>
            @if(isset($respondent->updated_by->user_login))
            {{$respondent->updated_by->user_login}}
            @endif
        </td>
        <td>
            @if($respondent->on_qc == 1)
            Bisa di QC
            @else
            -
            @endif
        </td>
        <td>
            @if(isset($respondent->status_temuan_dp->keterangan_temuan_dp))
            {{$respondent->status_temuan_dp->keterangan_temuan_dp}}
            @else
            Kosong
            @endisset
        </td>
        <td>
            @if(isset($respondent->keterangan_temuan_dp))
            {{$respondent->keterangan_temuan_dp}}
            @else
            Kosong
            @endisset
        </td>
        <td>
            <?php
            if ($respondent->updated_temuan_dp_by_id) {
                $user = DB::table('users')->where('id', $respondent->updated_temuan_dp_by_id)->first();
                if ($user) {
                    echo $user->nama;
                } else {
                    echo "Kosong";
                }
            } else {
                echo "Kosong";
            }
            ?>
        </td>
        <td>
            <?php if (in_array(Session::get('divisi_id'), [1])) : ?>
                <a href="{{ url('/respondents/')}}/{{$respondent->id}}/edit" class='btn btn-primary btn-sm' target="_blank" data-value="<?= url()->full(); ?>"><i class="fa fa-edit"></i></a>
                <a href="{{ url('/respondents/')}}/delete/{{$respondent->id}}" class='btn btn-danger btn-sm'><i class="fa fa-trash-o"></i></a>
            <?php elseif (in_array(Session::get('divisi_id'), [2, 3])) : ?>
                <a href="{{ url('/respondents/')}}/{{$respondent->id}}/edit" class='btn btn-primary btn-sm' target="_blank" data-value="<?= url()->full(); ?>"><i class="fa fa-edit"></i></a>
                <a href="{{ url('/respondents/')}}/delete/{{$respondent->id}}" class='btn btn-danger btn-sm'><i class="fa fa-trash-o"></i></a>
                @if($respondent->on_qc != 1)
                <a href="{{ url('/respondents/')}}/set_respondent/{{$respondent->id}}" class='btn btn-primary btn-sm'><i class="fa fa-unlock-alt"></i></a>
                @endif
            <?php else : ?>
                @if($respondent->on_qc == 1)
                <a href="{{ url('/respondents/')}}/{{$respondent->id}}/edit" class='btn btn-primary btn-sm' target="_blank" data-value="<?= url()->full(); ?>"><i class="fa fa-edit"></i></a>
                <a href="{{ url('/respondents/')}}/delete/{{$respondent->id}}" class='btn btn-danger btn-sm'><i class="fa fa-trash-o"></i></a>
                @endif
            <?php endif; ?>
        </td>
        </tr>
        @endforeach
</tbody>

{{-- Standard Table Bottom --}}
@include('layouts/gentelella/table_bottom')
{{-- End of Standard table Bottom --}}

</div>


</div>

</div>
</div>
</div>
</div>
@endsection('content')

<!-- Modal -->
<div class="modal fade" id="keteranganRekamanModal" tabindex="-1" role="dialog" aria-labelledby="keteranganRekamanModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="keteranganRekamanModalLabel">Keterangan Rekaman</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- <form method="post" action="{{ url('/respondents/store_keterangan_rekaman')}}"> -->
                <!-- <form> -->
                @csrf
                <input type="hidden" class="hidden" name="id">
                <div class="form-group">
                    <label for="keteranganRekaman">Keterangan</label>
                    <textarea class="form-control inputModal" id="keteranganRekaman" name="keteranganRekaman" rows="3"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button class="btn btn-primary submit" id="submitRekaman" name="button">Submit</button>
            </div>
            <!-- </form> -->
        </div>
    </div>
</div>

<div class="modal fade" id="keteranganCallbackModal" tabindex="-1" role="dialog" aria-labelledby="keteranganCallbackModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="keteranganCallbackModalLabel">Keterangan Callback</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- <form method="post" action="{{ url('/respondents/store_keterangan_callback')}}"> -->
                @csrf
                <input type="hidden" class="hidden" name="id">
                <input type="hidden" class="hiddenLink" name="link">
                <div class="form-group">
                    <label for="keteranganCallback">Keterangan</label>
                    <textarea class="form-control inputModal" id="keteranganCallback" name="keteranganCallback" rows="3"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary submit" id="submitCallback" name="button">Submit</button>
            </div>
            <!-- </form> -->
        </div>
    </div>
</div>
<div class="modal fade" id="keteranganQCModal" tabindex="-1" role="dialog" aria-labelledby="keteranganQCModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="keteranganQCModalLabel">Keterangan QC</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- <form method="post" action="{{ url('/respondents/store_keterangan_QC')}}"> -->
                @csrf
                <input type="hidden" class="hidden" name="id">
                <input type="hidden" class="hiddenLink" name="link">
                <div class="form-group">
                    <label for="keteranganQC">Keterangan</label>
                    <textarea class="form-control inputModal" id="keteranganQC" name="keteranganQC" rows="3"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary submit" id="submitQC" name="button">Submit</button>
            </div>
            <!-- </form> -->
        </div>
    </div>
</div>

<div class="modal fade" id="evaluasiModal" tabindex="-1" role="dialog" aria-labelledby="evaluasiModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="evaluasiModalLabel">Point Evaluasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body body-evaluasiModal">
                <!-- <form method="post" action="{{ url('/respondents/store_keterangan_QC')}}"> -->
                @csrf
                <input type="hidden" class="hidden" name="id">
                <input type="hidden" class="hiddenLink" name="link">
                <div class="form-group">
                    <label for="evaluasi1">Proses interview secara keseluruhan(pengusaan materi dalam kuesioner)</label>
                    <input type="hidden" name="evaluasiPert[]" value="Proses interview secara keseluruhan(pengusaan materi dalam kuesioner)">
                    <textarea class="form-control evaluasiJaw" id="evaluasi1" name="evaluasiJaw[]" rows="3" required></textarea>
                </div>
                <div class="form-group">
                    <label for="evaluasi2">Proses pemberian showcard dan dropcard</label>
                    <input type="hidden" name="evaluasiPert[]" value="Proses pemberian showcard dan dropcard">
                    <textarea class="form-control evaluasiJaw" id="evaluasi2" name="evaluasiJaw[]" rows="3" required></textarea>
                </div>
                <div class="form-group">
                    <label for="evaluasi3">Gestur/mimik interviewer</label>
                    <input type="hidden" name="evaluasiPert[]" value="Gestur/mimik interviewer">
                    <textarea class="form-control evaluasiJaw" id="evaluasi3" name="evaluasiJaw[]" rows="3" required></textarea>
                </div>
                <div class="form-group">
                    <label for="evaluasi4">Kemampuan menggali jawaban untuk pertanyaan terbuka (open end)</label>
                    <input type="hidden" name="evaluasiPert[]" value="Kemampuan menggali jawaban untuk pertanyaan terbuka (open end)">
                    <textarea class="form-control evaluasiJaw" id="evaluasi4" name="evaluasiJaw[]" rows="3" required></textarea>
                </div>
                <div class="form-group">
                    <label for="evaluasi5">Kemampuan interviewer dalam membuat responden nyaman dalam tanya jawab</label>
                    <input type="hidden" name="evaluasiPert[]" value="Kemampuan interviewer dalam membuat responden nyaman dalam tanya jawab">
                    <textarea class="form-control evaluasiJaw" id="evaluasi5" name="evaluasiJaw[]" rows="3" required></textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <button class="btn btn-sm btn-success float-right" id="addPoint"><i class="fa fa-plus"></i> Tambah</button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary evaluasiModalButton" id="evaluasiModalButton" name="">Submit</button>
            </div>
            <!-- </form> -->
        </div>
    </div>
</div>

@section('javascript')
<script>
    $(document).ready(function() {
        // class = "btn btn-default buttons-copy buttons-html5 btn-sm"
        // $('a.btn.btn-default.buttons-copy.buttons-html5.btn-sm').addClass('border');
        // $('a.btn.btn-default.buttons-csv.buttons-html5.btn-sm').addClass('border');
        // $('a.btn.btn-default.buttons-excel.buttons-html5.btn-sm').addClass('border');
        // $('a.btn.btn-default.buttons-pdf.buttons-html5.btn-sm').addClass('border');
        // $('a.btn.btn-default.buttons-print.btn-sm').addClass('border');
        // $('div.dt-buttons.btn-group').prepend(`
        // <button type="button" class="btn btn-primary btn-sm">Export to </button>
        // `);

        // $(document).on('change', '#project_imported_id', function() {
        if (($('#project_imported_id').val() && $('#project_imported_id').val() != 'all') && ($('#interviewer').val() && $('#interviewer').val() != 'all')) {
            $('#btn-pick-respondent').show();
        } else {
            $('#btn-pick-respondent').hide();
        }
        // });

        $(document).on('click', '.btn-modal', function() {
            const id = $(this).data('id');
            const val = $(this).data('value');
            let _token = $('input[name="_token"]').val();
            $('.hidden').val(id);
            $('.hiddenLink').val(document.URL);
            $('.inputModal').val(val);

            if ($(this).val() == 'rekaman') {
                $(document).on('click', '#submitRekaman', function() {
                    const newVal = $('#keteranganRekaman').val();
                    $.ajax({
                        url: "{{url('/respondents/store_keterangan_rekaman')}}",
                        type: "post",
                        data: {
                            'id': id,
                            'value': newVal,
                            '_token': _token
                        },
                        success: function(result) {
                            location.reload();
                            sessionStorage.removeItem('status');
                        }
                    })
                })
            } else if ($(this).val() == 'callback') {
                $(document).on('click', '#submitCallback', function() {
                    const newVal = $('#keteranganCallback').val();
                    $.ajax({
                        url: "{{url('/respondents/store_keterangan_callback')}}",
                        type: "post",
                        data: {
                            'id': id,
                            'value': newVal,
                            '_token': _token
                        },
                        success: function(result) {
                            location.reload();;
                        }
                    })
                })
            } else if ($(this).val() == 'qc') {
                $(document).on('click', '#submitQC', function() {
                    const newVal = $('#keteranganQC').val();
                    $.ajax({
                        url: "{{url('/respondents/store_keterangan_qc')}}",
                        type: "post",
                        data: {
                            'id': id,
                            'value': newVal,
                            '_token': _token
                        },
                        success: function(result) {
                            location.reload();
                        }
                    })
                })
            }

        });

        $(document).on('click', '#evaluasiButton', function() {
            $('.evaluasiJaw').val('');
            const id = $(this).data('id');
            let _token = $('input[name="_token"]').val();

            $.ajax({
                url: "{{url('/respondents/get_evaluasi')}}",
                type: "get",
                data: {
                    'id': id
                },
                success: function(result) {
                    const elementJawaban = $('.evaluasiJaw');
                    if (result.evaluasi_jawaban) {
                        for (let i = 0; i < result.evaluasi_jawaban.length; i++) {
                            if (i < 5) {
                                $(elementJawaban[i]).val(result.evaluasi_jawaban[i]);
                            } else {
                                const html = `
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                            <label for="">${result.evaluasi_pertanyaan[i]} <span style="position: absolute; top: 0; right: 12px;"><a type="button" class="fa fa-minus" style="color: red; text-decoration: none;"></a></span></label>
                                            <textarea class="form-control" id="" name="evaluasiJaw[]" rows="3" required>${result.evaluasi_jawaban[i]}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    `

                                $('.body-evaluasiModal').append(html);
                            }
                        }
                    }
                }
            });

            $(document).on('click', '#evaluasiModalButton', function() {
                let valuesJaw = $("[name='evaluasiJaw[]']")
                    .map(function() {
                        return $(this).val();
                    }).get();

                let valuesPert = $("[name='evaluasiPert[]']")
                    .map(function() {
                        return $(this).val();
                    }).get();

                // if (values.length % 2 == 0) {

                $.ajax({
                    url: "{{url('/respondents/store_evaluasi')}}",
                    type: "post",
                    data: {
                        'id': id,
                        'valuesJaw': valuesJaw,
                        'valuesPert': valuesPert,
                        '_token': _token
                    },
                    success: function(result) {
                        location.reload();
                    }
                })
                // }
            })
        })


        $(document).on('click', '#addPoint', function() {
            const html = `
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                    <label for="">Parameter Tambahan <span style="position: absolute; top: 0; right: 12px;"><a type="button" class="fa fa-minus" style="color: red; text-decoration: none;"></a></span></label>
                    <input type="email" class="form-control" name="evaluasiPert[]" placeholder="" required>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                    <label for="">Evaluasi Tambahan</label>
                    <textarea class="form-control" id="" name="evaluasiJaw[]" rows="3" required></textarea>
                    </div>
                </div>
            </div>
            `

            $('.body-evaluasiModal').append(html);
        })

        setInterval(function() {
            buttonDelete = document.querySelectorAll(".fa-minus");
            buttonDelete.forEach(function(e, i) {
                e.addEventListener('click', function() {
                    e.parentElement.parentElement.parentElement.parentElement.parentElement.remove();
                });
            });

        }, 1000);

    });
</script>
@endsection
