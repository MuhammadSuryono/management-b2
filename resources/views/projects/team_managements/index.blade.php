@extends('maingentelellatable')
@section('title', 'Project : ' . $project->nama)
@section('title2', 'Setting Team per kota')
@section('content')
@include('layouts.gentelella.table_top')
<style>
    .popover__wrapper {
        position: relative;
        margin-top: 1.5rem;
        display: inline-block;
    }
    .popover__content {
        opacity: 0;
        visibility: hidden;
        position: absolute;
        left: -150px;
        transform: translate(0, 10px);
        background-color: #e3e2e2;
        padding: 1.5rem;
        box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26);
        width: auto;
    }
    .popover__content:before {
        position: absolute;
        z-index: -1;
        content: "";
        right: calc(50% - 10px);
        top: -8px;
        border-style: solid;
        border-width: 0 10px 10px 10px;
        border-color: transparent transparent #bfbfbf transparent;
        transition-duration: 0.3s;
        transition-property: transform;
    }
    .popover__wrapper:hover .popover__content {
        z-index: 10;
        opacity: 1;
        visibility: visible;
        transform: translate(0, -20px);
        transition: all 0.5s cubic-bezier(0.75, -0.02, 0.2, 0.97);
    }
    .popover__message {
        text-align: center;
    }
</style>
<button title="tambah kota di proyek {{$project->nama}}" type="button" data-toggle="modal" data-target=".bs-example-modal-lg" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah Kota</button>
<thead>
    <tr class="text-center">
        <th>Kota</th>
        <th>Team Dibutuhkan</th>
        <th>Nama Personel</th>
    </tr>
</thead>
<tbody>
    <?php

    use App\Respondent;

    $checkKota = '';
    $rowSpan = 1;
    $i = 0;
    $pid = 0;
    $kid = 0;
    $jid = 0;
    $tid = 0;
    $pn = 0;
    $kn = 0;
    $jn = 0;
    $tn = 0;
    ?>
    @foreach ($project_full_teams as $item)
    <?php
    if ($pid <> $project->id) {
        $pid = $project->id;
        $pn = 1;
    } else {
        $pn = 0;
    }
    if ($kid <> $item->project_kota_id) {
        $kid = $item->project_kota_id;
        $kn = 1;
        if (isset($item->project_jabatan_id)) {
            $kota_del_button = 0;
        } else {
            $kota_del_button = 1;
        }
    } else {
        $kn = 0;
    }
    if ($jid <> $item->project_jabatan_id) {
        $jid = $item->project_jabatan_id;
        $jn = 1;
        if (isset($item->project_team_id)) {
            $jabatan_del_button = 0;
        } else {
            $jabatan_del_button = 1;
        }
    } else {
        $jn = 0;
    }
    ?>
    <tr>
        @if($checkKota != $item->kota)
        <td rowspan="{{$num_rows[$i]}}" style="vertical-align: middle;">
            <div class="dropdown">
                <strong>{{$item->kota}}</strong> ({{$item->jumlah}})
                <br/>
                <div class="btn-group">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownHonorButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-size: 10px; padding: 1px; margin: 0;"> Honor
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownHonorButton">
                        <?php $listHonor = DB::table('project_honors')->where('project_kota_id', $item->project_kota_id)->get(); ?>
                        @foreach($listHonor as $lh)
                        <p class="dropdown-item">{{$lh->nama_honor}} (Rp.{{number_format($lh->honor)}}) <a href="hapus_honor/{{$lh->id}}" style="color: red;"><i class="fa fa-trash"></i></a></p>
                        @endforeach
                        <button type="button" class="dropdown-item btn-add-honor" data-toggle="modal" data-target="#honorModal" style="background-color: lightblue;" data-id="{{$item->project_kota_id}}"><i class="fa fa-plus"></i> Honor Category</button>
                    </div>
                </div>
                <div class="btn-group">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownDoButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-size: 10px; padding: 1px; margin: 0;"> DO
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownDoButton">
                        <?php $listHonor = DB::table('project_honor_dos')->where('project_kota_id', $item->project_kota_id)->get(); ?>
                        @foreach($listHonor as $lh)
                        <p class="dropdown-item">{{$lh->nama_honor_do}} (Rp.{{number_format($lh->honor_do)}}) <a href="hapus_honor_do/{{$lh->id}}" style="color: red;"><i class="fa fa-trash"></i></a></p>
                        @endforeach
                        <button type="button" class="dropdown-item btn-add-honor-do" data-toggle="modal" data-target="#honorDoModal" style="background-color: lightblue;" data-id="{{$item->project_kota_id}}"><i class="fa fa-plus"></i> DO Category</button>
                    </div>
                </div>
                <div class="btn-group">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownGiftButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-size: 10px; padding: 1px; margin: 0;"> Gift
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownGiftButton">
                        <?php $listHonor = DB::table('project_honor_gifts')->where('project_kota_id', $item->project_kota_id)->get(); ?>
                        @foreach($listHonor as $lh)
                        <p class="dropdown-item">{{$lh->nama_honor_gift}} (Rp.{{number_format($lh->honor_gift)}}) <a href="hapus_honor_gift/{{$lh->id}}" style="color: red;"><i class="fa fa-trash"></i></a></p>
                        @endforeach
                        <button type="button" class="dropdown-item btn-add-honor-gift" data-toggle="modal" data-target="#honorGiftModal" style="background-color: lightblue;" data-id="{{$item->project_kota_id}}"><i class="fa fa-plus"></i> Gift Category</button>
                    </div>
                </div>

                <div class="btn-group">
                    <button class="btn btn-danger" type="button" id="dropdownGiftButton" data-selection_id="{{$item->project_kota_id}}" data-type="project_kota" onclick="showDenda(this)" style="font-size: 10px; padding: 1px; margin: 0;"> Denda Kota </button>
                </div>
            </div>


            <!-- <div class="dropdown">
                <strong>{{$item->kota}}</strong> ({{$item->jumlah}})
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownDoButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-size: 10px; padding: 1px; margin: 0;">
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownDoButton">
                    <?php $listHonor = DB::table('project_honors')->where('project_kota_id', $item->project_kota_id)->get(); ?>
                    @foreach($listHonor as $lh)
                    <p class="dropdown-item">{{$lh->nama_honor}} (Rp.{{number_format($lh->honor)}}) <a href="hapus_honor/{{$lh->id}}" style="color: red;"><i class="fa fa-trash"></i></a></p>
                    @endforeach
                    <button type="button" class="dropdown-item btn-add-honor" data-toggle="modal" data-target="#honorModal" style="background-color: lightblue;" data-id="{{$item->project_kota_id}}"><i class="fa fa-plus"></i> Honor Category</button>
                </div>
            </div> -->
            <?php $i++; ?>
            @if($kn==0)
            @if($kota_del_button)
            {{-- <span type="button" class="close" href="{{ url('/project_kotas/delete')}}/{{$item->project_kota_id}}" onclick="return confirm('Are you sure?')"><span aria-hidden="true"><i class="fa fa-trash"></i></span></span> --}}
            {{-- PAK BUDI --}}
            {{-- AKHIR --}}

            <a class="tombol-hapus text-danger float-right" href="{{ url('/project_kotas/delete')}}/{{$item->project_kota_id}}"><i class="fa fa-trash fa-lg"></i></a>
            @endif
            {{-- PAK BUDI --}}
            {{-- <a type="button" class="close" href="{{ url('/project_kotas')}}/{{$item->project_kota_id}}/edit"><span aria-hidden="true"><i class="fa fa-edit"></i></span></a> --}}
            {{-- AKHIR PAK BUDI --}}

            {{-- IWAYRIWAY --}}
            <a href="javascript:void(0)" class="text-success float-right mr-2" data-toggle="modal" data-target=".modal-edit" data-kota_id="{{$item->id_kota}}" data-kota="{{$item->kota}}" data-provinsi="{{$item->nama_prov}}" data-jumlah="{{$item->jumlah}}"><i class="fa fa-edit fa-lg"></i></a>
            {{-- AKHIR --}}

            @endif
        </td>
        @else
        <!-- <td></td> -->

        @endif

        <td style="color:DarkOrchid">
            @if($kn==1 and isset($item->kota))
            <a title="tambah jabatan untuk {{$item->kota}}" type="button" href="{{url('/project_jabatans/create')}}/{{$item->project_kota_id}}" class="btn btn-block btn-danger btn-sm"><i class="fa fa-plus"></i></a>
            @endif
            @if($jn==1 and isset($item->project_jabatan_id))
            @if($jabatan_del_button)
            <a title="Bisa hapus bila anggota tim {{$item->jabatan}} kosong" type="button" class="close" href="{{ url('/project_jabatans/delete')}}/{{$item->project_jabatan_id}}" onclick="return confirm('Hapus {{$item->jabatan}}?')"><span aria-hidden="true"><i class="fa fa-trash"></i></span></a>
            @endif
            <b>{{$item->jabatan}}</b>
            @endif
        </td>
        <td>
            @if($jn==1 and isset($item->jabatan) )
            {{-- <a title="tambah team {{$item->jabatan}}" type="button" href="{{ url('/project_teams/create')}}/{{$jid}}" class="btn btn-block btn-info btn-sm"><i class="fa fa-plus"></i></a> --}}
            <a title="tambah team {{$item->jabatan}} " type="button" href="{{ url('/project_teams/create')}}/{{$jid}}" class="btn btn-block btn-info btn-sm"><i class="fa fa-plus"></i></a>
            @endif
            @if (isset($item->project_team_id))
            <a type="button" class="close" href="{{ url('/project_teams/delete')}}/{{$item->project_team_id}}"><span aria-hidden="true"><i class="fa fa-trash"></i></span></a>
            <span data-toggle="modal" data-target="#honorDoTlModal">
                <button type="button" class="close mr-2" data-toggle="tooltip" data-placement="bottom" title="Tambah Denda DO" data-id="<?= $item->project_team_id ?>" data-denda="<?= ($item->denda) ? $item->denda : 0 ?>" id="btn-denda"><span aria-hidden="true"><i class="fa fa-money"></i></span></button>
            </span>
                    @if($item->jabatan == "Team Leader (TL)")
            <span data-toggle="modal" data-target="#anggota-leader">
                <button type="button" class="close mr-2" data-toggle="tooltip" data-placement="bottom" title="Show Anggota" onclick="getMemberLeader({{$item->project_kota_id}},{{$item->team_id}})"><span aria-hidden="true"><i class="fa fa-users"></i></span></button>
            </span>
            <span data-toggle="modal" data-target="#editLeader">
                <button type="button" class="close mr-2" data-toggle="tooltip" data-placement="bottom" title="Edit TL" onclick="editTl('{{$item->type_tl}}',{{$item->gaji}},{{$item->target_tl}},{{$item->project_team_id}})"><span aria-hidden="true"><i class="fa fa-edit"></i></span></button>
            </span>
                    @endif
                    @if($item->jabatan != "Team Leader (TL)")
            <span>
                <button type="button" class="close mr-2" data-toggle="tooltip" data-placement="bottom" title="Show Leader" onclick="setupLeader({{$item->team_id}}, {{$item->project_kota_id}}, {{$item->project_team_id}})"><span aria-hidden="true"><i class="fa fa-user"></i></span></button>
            </span>
                    @endif
            {{$item->team}} <br>
                    @if($item->jabatan != "Interviewer")
                        - Honor Rp.{{number_format($item->gaji)}} <br/>
                        - Jenis TL {{ ucwords($item->type_tl) }} <br/>
                    @endif

                    @if($item->jabatan == "Team Leader (TL)")
                        - Target TL {{ ucwords($item->target_tl) }} respondent <br/>
                    @endif
            <?php
            if ($item->denda) {
                $team = DB::table('teams')->where('id', $item->team_id)->first();
                $teamCode = sprintf('%04d', $team->no_team);
                $cityCode = sprintf('%03d', $team->kota_id);
                $count = DB::table('respondents')->where('srvyr', '=', $cityCode . $teamCode)->whereIn('status_qc_id', array(2, 3, 6, 9))->count();
                // var_dump($count);
                echo "- (Rp." . number_format($item->denda) . " x $count) = Rp." . number_format(($item->gaji - ($item->denda * $count)));
            }
            ?>
            @endif
        </td>
    </tr>
    <?php $checkKota = $item->kota; ?>
    @endforeach
</tbody>
@include('layouts.gentelella.table_bottom')

<div class="col-md-12 col-sm-12 ">
    <div class="x_panel">
        <div class="x_title">
            <h2>Note</h2>
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
                        <div class="card">
                            <div class="card-body">
                                <p>1. Honor TL = Honor - (Denda x Jumlah DO)</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- <a href="{{url('projects/' . Session::get('current_project_id')) . '/edit'}}" class="btn btn-primary float-right mr-3 text-white">Back</a> -->


{{-- MODAL TAMBAH KOTA --}}
<div class="modal fade bs-example-modal-lg" id="tambahKota" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="myModalLabel"><strong>Tambah Kota</strong></h6>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{url('/project_kotas')}}" method="POST">
                @csrf
                <input type="hidden" name="kode_project" value="{{$project->kode_project}}">
                <input type="hidden" name="project_id" value="{{$project->id}}">
                <div class="form-group row">
                    <label class="control-label col-md-3 col-sm-3 ">Pilih Kota</label>
                    <div class="col-md-9 col-sm-9 ">
                        <select class="selectpicker" name="kota" id="kota" data-live-search="true" data-width="100%" required>
                            <option value="">Kota / Kab</option>
                            @foreach ($kota as $db)
                            <option value="{{$db->id}}-{{$db->id_provinsi}}" data-tokens="{{$db->kota}}">{{$db->kota}}</option>
                            @endforeach
                            <option value="lain" data-tokens="lain">Lainnya</option>
                        </select>
                    </div>
                </div>
        </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
    </form>
</div>
</div>
</div>
{{-- AKHIR MODAL TAMBAH KOTA --}}

<!-- Honor Modal -->
<div class="modal fade" id="honorModal" tabindex="-1" role="dialog" aria-labelledby="honorModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="honorModalLabel">Tambah Kategori Honor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ url('project_team_managements/tambah_honor')}}">
                    @csrf
                    <input type="hidden" name="id" id="honor_kota_id" value="">
                    <input type="hidden" name="project_id" value="{{$project->id}}">
                    <div class=" form-group">
                        <label for="kategori">Nama kategori</label>
                        <input type="text" class="form-control" id="kategori" name="kategori" placeholder="" required>
                    </div>
                    <div class=" form-group">
                        <label for="honor">Honor</label>
                        <input type="text" class="form-control" id="honor" name="honor" placeholder="" required>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" name="button" value="tl">Submit</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- Honor DO Modal -->
<div class="modal fade" id="honorDoModal" tabindex="-1" role="dialog" aria-labelledby="honorDoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="honorDoModalLabel">Tambah Kategori Denda DO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ url('project_team_managements/tambah_honor_do')}}">
                    @csrf
                    <input type="hidden" name="id" id="honor_do_kota_id" value="">
                    <input type="hidden" name="project_id" value="{{$project->id}}">
                    <div class=" form-group">
                        <label for="kategori">Nama kategori</label>
                        <input type="text" class="form-control" id="kategori" name="kategori" placeholder="" required>
                    </div>
                    <div class="form-group">
                        <label for="honor">Denda DO</label>
                        <input type="text" class="form-control" id="honor" name="honor" placeholder="" required>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" name="button" value="tl">Submit</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- Honor Gift -->
<div class="modal fade" id="honorGiftModal" tabindex="-1" role="dialog" aria-labelledby="honorGiftModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="honorGiftModalLabel">Tambah Kategori Gift</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ url('project_team_managements/tambah_honor_gift')}}">
                    @csrf
                    <input type="hidden" name="id" id="honor_gift_kota_id" value="">
                    <input type="hidden" name="project_id" value="{{$project->id}}">
                    <div class=" form-group">
                        <label for="kategori">Nama Gift</label>
                        <input type="text" class="form-control" id="kategori" name="kategori" placeholder="" required>
                    </div>
                    <div class="form-group">
                        <label for="honor">Nominal</label>
                        <input type="text" class="form-control" id="honor" name="honor" placeholder="" required>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" name="button" value="tl">Submit</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- Denda TL -->
<div class="modal fade" id="honorDoTlModal" tabindex="-1" role="dialog" aria-labelledby="honorDoTlModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="honorDoTlModalLabel">Denda TL</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ url('project_team_managements/denda_tl')}}">
                    @csrf
                    <input type="hidden" name="project_id" value="{{$project->id}}">
                    <input type="hidden" name="project_team_id" value="">
                    <div class="form-group">
                        <label for="honor">Nominal</label>
                        <input type="text" class="form-control" id="dendaTl" name="dendaTl" placeholder="" required>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" name="button" value="tl">Submit</button>
            </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL EDIT JUMLAH --}}
<div class="modal fade bs-example-modal-lg modal-edit" id="modalEdit" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="myModalLabel"><strong>Edit Jumlah</strong></h6>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ url('/project_kotas/editJumlah')}}" method="POST">
                    @csrf
                    <input type="hidden" name="kode_project" value="{{$project->kode_project}}">
                    <input type="hidden" name="project_id" value="{{$project->id}}">
                    <input type="hidden" name="kota_id" id="kota_id" value="">

                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 ">Kota</label>
                        <div class="col-md-9 col-sm-9 ">
                            <input type="text" class="form-control" name="kota" id="kota" readonly placeholder="kota">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 ">Provinsi</label>
                        <div class="col-md-9 col-sm-9 ">
                            <input type="text" class="form-control" name="provinsi" id="provinsi" readonly placeholder="Provinsi">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 ">Jumlah</label>
                        <div class="col-md-9 col-sm-9 ">
                            <input type="number" class="form-control" name="jumlah" id="jumlah" placeholder="Jumlah" required>
                        </div>
                    </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="anggota-leader" tabindex="-1" role="dialog" aria-labelledby="anggota-leaderLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="anggota-leaderLabel">Anggota Team Leader</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h6>Nama Leader : <span id="leader-name"></span></h6>
                <div class="table-scroll">
                    <table class="table table-striped tableFixHead">
                        <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Jabatan</th>
                            <th>Honor</th>
                        </tr>
                        </thead>
                        <tbody id="data-member">

                        </tbody>
                    </table>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="setup-leader" tabindex="-1" role="dialog" aria-labelledby="setup-leaderLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="setup-leaderLabel">Anggota Team Leader</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ url('/project_teams/edit/leader/')}}" id="form-setup-leader" method="POST">
            <div class="modal-body">
                @csrf
                <div class="form-group">
                    <select name="leader" id="leaders" class="form-control" required>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editLeader" tabindex="-1" role="dialog" aria-labelledby="editLeaderLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editLeaderLabel">Edit Data Leader</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ url('/project_teams/leader/update')}}" id="form-edit-leader" method="POST">
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label>Project Team ID</label>
                        <input type="text" class="form-control" name="project_team_id" id="project_team_id" readonly>
                    </div>
                    <div class="form-group">
                        <label>Type TL</label>
                        <select name="type_tl" id="type_tl" class="form-control" required>
                            <option value="">Pilih Type TL</option>
                            <option value="reguler">Reguler</option>
                            <option value="borongan">Borongan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Honor</label>
                        <input type="text" class="form-control" name="honor_tl" id="honor_tl">
                    </div>
                    <div class="form-group">
                        <label>Target</label>
                        <input type="text" class="form-control" name="target" id="target">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- AKHIR MODAL TAMBAH KOTA --}}

<div class="modal fade" id="dendaKota" tabindex="-1" role="dialog" aria-labelledby="dendaKotaLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dendaKotaLabel">Denda Kota</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formDendaKota">
                    <div class="row">
                        <input type="text" id="project_id" name="project_id" value="{{$project->id}}" hidden>
                        <input type="text" id="selection_id" name="selection_id" hidden>
                        <input type="text" id="type" name="type" hidden>
                        <input type="text" id="action" name="action" value="cerate" hidden>
                        <input type="text" id="id" name="id" hidden>
                        <div class="col-sm">
                            <div class="form-group">
                                <label>Variable</label>
                                <select class="form-control" name="variable_id" id="variable_id" required>
                                    <option value="">Pilih Variable Denda</option>
                                    @foreach ($variables as $variable)
                                        <option value="{{ $variable->id }}">{{ $variable->variable_name }} @if ($variable->default)
                                            (Default)
                                        @endif</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm">
                            <div class="form-group">
                                <label>Type Variable</label>
                                <select class="form-control" name="type_variable" id="type_variable" required>
                                    <option value="">Pilih Type Variable</option>
                                    <option value="keterlambatan">Keterlambatan</option>
                                    <option value="gift">Gift</option>
                                    <option value="btf">BTF</option>
                                    <option value="input_manual">Input Manual</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm">
                            <div class="form-group">
                                <div class="popover__wrapper">
                                    <div class="popover__content" style="width: 500px">
                                        <p class="popover__message">
                                            <b>Tata Cara Pengisian Nilai</b>
                                            <ol>
                                                <li>Hanya menerima inputan berupa persentase/decimal atau nominal angka</li>
                                                <li>Jika mengisi nilai dengan value percentase/decimal maka, nilai yang dimasukkan belum di bagi 100. Misalkan untuk 2%, anda cukup input angak dua, dan kemudian pilih parameter <b class="text-danger">Dari</b>
                                                    Artinya menunjukkan nilai yang anda masukkan 2% dari nilai dari variable <b class="text-danger">Dari</b> yang dipilih</li>
                                                <li>Jika anda ingin mengisi nominal angka, misalkan Rp. 2000, maka inputkan saja 2000 dan pilih parameter <b class="text-danger">Diambil Dari/Setiap</b> dan untuk parameter <b class="text-danger">Dari</b> biarkan undefined</li>
                                            </ol>
                                        </p>
                                    </div>
                                    <label>Nilai <span ><i class="fa fa-question-circle"></i> </span></label>
                                </div>
                                <input type="text" class="form-control"  id="nominal" name="nominal" required>
                                <small class="text-danger"><i>Nilai bisa anda masukkan sebagai persentase atau nominal</i></small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm">
                            <div class="form-group">
                                <label>Dari</label>
                                <select class="form-control" id="from" name="from" required>
                                    <option value="undefined">Undefined</option>
                                    <option value="[total]">Total</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm">
                            <div class="form-group">
                                <label>Diambil Dari/Setiap</label>
                                <select class="form-control" id="take_from" name="take_from" required>
                                    <option value="undefined">Undefined</option>
                                    <option value="[respondent]">Respondent</option>
                                    <option value="[respondent_do]">Respondent DO</option>
                                    <option value="[respondent_btf]">Respondent BTF</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm">
                            <button class="btn btn-success" type="submit" style="margin-top: 25px;">Simpan</button>
                        </div>
                    </div>
                </form>
                <hr/>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered tableFixHead">
                        <thead>
                            <tr>
                                <th>Variable</th>
                                <th>Type</th>
                                <th>Nominal Denda</th>
                                <th>Dari</th>
                                <th>Diambil Dari/Setiap</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody id="data-denda">

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection('content')

@section('javascript')
<script>
    function showDenda(e) {
        $('#dendaKota').modal('show');
        let form = $('#formDendaKota');
        let selectionId = e.dataset.selection_id
        let type = e.dataset.type

        form[0].reset();
        $('#selection_id').val(selectionId);
        $('#type').val(type);
        $('#action').val('create');
        getDataDenda(selectionId, 'data-denda', editDenda);
    }

    function getDataDenda(selectionId, bodyTable, handleEdit) {
        let path = `/project/{{$project->id}}/nominal-denda/type/project_kota/selection/${selectionId}`;
        var url = "{{ url('')}}" + path;

        $.ajax({
            url: url,
            type: "GET",
            dataType: "json",
            success: function(hasil) {
                html = "";
                hasil.forEach((e) => {
                    html += "<tr>";
                    html += "<td>" + e.variable.variable_name + "</td>";
                    html += "<td>" + e.type_variable + "</td>";
                    html += e.variable.default ? "<td>" + e.nominal + "</td>" : "<td>" + new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(e.nominal) + "</td>";
                    html += e.variable.default ? "<td>" + e.from + "</td>" : "<td></td>";
                    html += "<td>" + e.take_from + "</td>";
                    html += e.variable.default ? `<td><button class="btn btn-sm btn-primary" onclick="editDenda('${e.id}','${e.variable.id}', '${e.nominal}', '${e.type}', '${e.project_id}', '${e.selection_id}', '${e.from}', '${e.type_variable}', '${e.take_from}')">Edit</button></td>` : `<td><button class="btn btn-sm btn-primary" onclick="editDenda('${e.id}','${e.variable.id}', '${e.nominal}', '${e.type}', '${e.project_id}', '${e.selection_id}', '${e.from}',  '${e.type_variable}', '${e.take_from}')">Edit</button> <button class="btn btn-sm btn-danger" onclick="deleteDenda('${e.id}', '${e.selection_id}')">Hapus</button></td>`;
                    html += "</tr>";
                });

                $(`#${bodyTable}`).html(html);
            },
            error: function(error) {
                console.log(error)
            }
        });
    }

    $('#formDendaKota').on('submit', function(e) {
        e.preventDefault();
        let form = $(this);
        let body = form.serializeArray();
        body.push({name: '_token', value: '{{ csrf_token() }}'});
        $.ajax({
            url: "{{ url('project/nominal-denda') }}",
            type: "POST",
            data: body,
            dataType: "json",
            success: function(hasil) {
                console.log(hasil)
                $('#action').val('create');
                getDataDenda(body[1].value, 'data-denda', editDenda);
            },
            error: function(error) {
                console.log(error)
            }
        });
    })

    function editDenda(id, variableId, nominal, type, projectId, selectionId, from, typeVariable, tFrom) {
        $('#selection_id').val(selectionId);
        $('#type').val(type);
        $('#nominal').val(nominal);
        $('#variable_id').val(variableId);
        $('#from').val(from);
        $('#action').val('update');
        console.log(typeVariable, tFrom)
        $('#type_variable').val(typeVariable);
        $('#take_from').val(tFrom);
        $('#id').val(id);
    }

    function deleteDenda(id, selectionId) {
        $.ajax({
            url: "{{ url('project/nominal-denda') }}/" + id,
            type: "DELETE",
            dataType: "json",
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(hasil) {
                getDataDenda(selectionId, 'data-denda', editDenda);
            },
            error: function(error) {
                console.log(error)
            }
        });
    }

    $('#btn-denda').click(function() {
        $('input[name=project_team_id]').val($(this).data("id"));
        $('#dendaTl').val($(this).data("denda"));

    });

    function editTl(typeTl, honor, target, id) {
        $('#editLeader').modal('show');
        $('#type_tl').val(typeTl);
        $('#project_team_id').val(id);
        $('#honor_tl').val(honor);
        $('#target').val(target);
    }

    function getMemberLeader(kotaId, leaderId) {
        let path = `/project_teams/kota/${kotaId}/leader/${leaderId}/member`;
        var url = "{{ url('')}}" + path;
        $("#anggota-leader").modal("show");
        $('#data-member').html("");

        $.ajax({
            url: url,
            type: "GET",
            dataType: "json",
            success: function(hasil) {
                html = "";
                hasil.forEach((e) => {
                    html += "<tr>";
                    html += "<td>" + e.team.nama + "</td>";
                    html += "<td>" + e.project_jabatan.jabatan.jabatan + "</td>";
                    html += "<td>" + new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(e.gaji) + "</td>";
                    html += "</tr>";
                });

                $('#leader-name').html(hasil[0].leader_name);
                $('#data-member').append(html);
            },
            error: function(error) {
                console.log(error)
            }
        });
    }


    function setupLeader(teamId, kotaId, id) {
        var url = "{{ url('project_team_managements/leader')}}" + "/"  + teamId + "/kota/" + kotaId;
        $("#setup-leader").modal("show");
        $('#leaders').html("");

        var urlAction = "{{ url('/project_teams/edit/leader/team')}}" + "/" + id
        document.getElementById("form-setup-leader").setAttribute("action", urlAction);
        $.ajax({
            url: url,
            type: "GET",
            dataType: "json",
            success: function(hasil) {
                html = "<option>Pilih Team Leader</option>";
                hasil.teamLeaders.project_team.forEach((e) => {
                    let selected = ""
                    if (e.team.id === hasil.leader) selected = "selected"
                    html += "<option value='"+e.team.id+"' "+selected+">" + e.team.nama + "</option>";
                });

                $('#leaders').html(html);
            },
            error: function(error) {
                console.log(error)
            }
        });
    }


    $(document).ready(function() {

        $('#kota').change(function() {
            var html = ``;
            $('#kotaProvinsi').empty();
            $('#lainnya').empty();

            if ($('#kota').val() == 'lain') {

                // input kota baru
                html += `<div class="form-group row">
                                <label class="control-label col-md-3 col-sm-3 ">Nama Kota</label>
                                <div class="col-md-9 col-sm-9 ">
                                        <input type="text" class="form-control" name="kotaBaru" id="kotaBaru" placeholder="Nama Kota" required>
                                </div>
                            </div>`;
                // akhir

                // select provinsi
                html += `<div class="form-group row">
                                <label class="control-label col-md-3 col-sm-3 ">Pilih Provinsi nya</label>
                                <div class="col-md-9 col-sm-9 ">
                                    <select class="selectpicker" name="provinsi" id="provinsi" required data-live-search="true" data-width="100%">
                                    <option>Pilih Provinsi</option>`;


                $.ajax({
                    url: "{{url('project_team_managements/ambilData')}}",
                    type: "POST",
                    dataType: "json",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(hasil) {
                        for (var i = 0; i < hasil.length; i++) {
                            html += `<option value="` + hasil[i].id + `" data-tokens="` + hasil[i].nama + `">` + hasil[i].nama + `</option>`;
                        }

                        html += `
                                    </select>
                                </div>
                            </div>`
                        console.log(html);
                        $('#lainnya').append(html);
                        $("#provinsi").selectpicker('refresh');
                    }
                });
                // akhir

            } else {
                $.ajax({
                    url: "{{url('project_team_managements/ambilProvinsi')}}",
                    type: "POST",
                    dataType: "json",
                    data: {
                        _token: "{{ csrf_token() }}",
                        kota: $('#kota').val(),
                    },
                    success: function(hasil) {
                        html += `<div class="form-group row">
                                        <label class="control-label col-md-3 col-sm-3 ">Pilih Provinsi</label>
                                        <div class="col-md-9 col-sm-9 ">
                                                <input type="hidden" class="form-control" name="provinsi" id="provinsi" readonly placeholder="Provinsi" value="` + hasil.id + `">
                                                <input type="text" class="form-control" name="namaProvinsi" id="namaProvinsi" readonly placeholder="Provinsi" value="` + hasil.nama + `">
                                        </div>
                                    </div>`;

                        $('#kotaProvinsi').append(html);
                    }
                });
            }

        });

        $('#modalEdit').on('show.bs.modal', function(e) {
            var div = $(e.relatedTarget);
            var modal = $(this);
            modal.find("#kota_id").val(div.data('kota_id'));
            modal.find("#kota").val(div.data('kota'));
            modal.find("#provinsi").val(div.data('provinsi'));
            modal.find("#jumlah").val(div.data('jumlah'));
        });

        console.log($('.btn-add-honor'));
        $('.btn-add-honor').click(function() {})

    });

    $('.btn-add-honor').click(function() {
        $('#honor_kota_id').val($(this).data("id"));
    });

    $('.btn-add-honor-do').click(function() {
        $('#honor_do_kota_id').val($(this).data("id"));
    });
    $('.btn-add-honor-gift').click(function() {
        $('#honor_gift_kota_id').val($(this).data("id"));
    });
</script>
@endsection
