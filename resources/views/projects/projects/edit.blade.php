@extends('maingentelellaform')
@section('title','Edit Project')

@section('top_menu_content')

@if(session('status'))
<div class="alert alert-success">
    {{session('status')}}
</div>
@endif

@if(session('status-fail'))
<div class="alert alert-danger">
    {{session('status-fail')}}
</div>
@endif

<div class="well">Manage:<br/>
    <a href="{{ url('/project_team_managements')}}/{{$project->id}}">
        <button title="Menu untuk RA dan Finance" class='btn btn-primary' target="_blank" <?= (!in_array(Session::get('divisi_id'), [1, 3, 5])) ? 'disabled' : '' ?>><i class="fa fa-group"></i> Kota Survey </button>
    </a>
    <a class="btn btn-primary" href="{{ url('/project')}}/{{$project->id}}/variable-denda">
        <i class="fa fa-list-alt"></i> Variable Denda
    </a>
    <?php if ($unlock_budget) : ?>
        <a href="{{ url('/projects/budget_integration')}}/{{$project->id}}">
            <button class='btn btn-primary' target="_blank" <?= (!in_array(Session::get('divisi_id'), [1, 5])) ? 'disabled' : '' ?>><i class="fa fa-group"></i> Integrasi Budget </button>
        </a>
    <?php else : ?>
        <a>
            <button class='btn btn-primary' target="_blank" <?= (!in_array(Session::get('divisi_id'), [1, 5])) ? 'disabled' : '' ?> data-toggle="tooltip" data-placement="top" title="Budget online belum dibuat"><i class="fa fa-group"></i> Integrasi Budget </button>
        </a>
    <?php endif; ?>


    {{-- PAK BUDI --}}
    <a href="{{ url('/project_plans')}}">
        <button title="Menu untuk RA" href="" class='btn btn-primary' target="_blank" <?= (!in_array(Session::get('divisi_id'), [1, 3])) ? 'disabled' : '' ?>><i class="fa fa-tags"></i> My Plan</button>
    </a>
    {{-- AKHIR --}}

    <div class="dropdown d-inline">
        <button title="Menu untuk RA" class="btn btn-primary" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" <?= (!in_array(Session::get('divisi_id'), [1, 3])) ? 'disabled' : '' ?>>
            <i class="fa fa-file"></i>File Team Leader
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            @if($project->file_team_leader)
            <?php

            $fileTl = unserialize($project->file_team_leader); ?>
            @foreach($fileTl as $f)
            <a class="dropdown-item" href="{{url('/projects/view')}}/{{$f}}" target="_blank">View {{$f}}</a>
            @endforeach
            @endif
            <button class="dropdown-item" type="button" data-toggle="modal" data-target="#tlModal"><b>Upload</b></button>
        </div>
    </div>
    <div class="dropdown d-inline">
        <button title="Menu untuk RA" class="btn btn-primary" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" <?= (!in_array(Session::get('divisi_id'), [1, 3])) ? 'disabled' : '' ?>>
            <i class="fa fa-file"></i>File Kuesioner
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            @if($project->file_kuesioner)
            <?php $fileKuesioner = unserialize($project->file_kuesioner); ?>
            @foreach($fileKuesioner as $f)
            <a class="dropdown-item" href="{{url('/projects/view')}}/{{$f}}" target="_blank">View {{$f}}</a>
            @endforeach
            @endif
            <button class="dropdown-item" type="button" data-toggle="modal" data-target="#kuesionerModal"><b>Upload</b></button>
        </div>
    </div>

    <a href="{{ url('projects/set_flag_rules')}}/{{$project->id}}">
        <button title="Menu untuk RA" class='btn btn-primary' <?= (!in_array(Session::get('divisi_id'), [1, 3])) ? 'disabled' : '' ?>><i class="fa fa-group"></i> Set Flag Rules </button>
    </a>

    <div class="dropdown d-inline">
        <button title="Menu untuk DP" class="btn btn-primary" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspop up="true" aria-expanded="false" <?= (!in_array(Session::get('divisi_id'), [1, 2])) ? 'disabled' : '' ?>>
            <i class="fa fa-file"></i>Upload Raw Responden
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            @if($project->file_respondent)
            <?php $fileRespondent = unserialize($project->file_respondent); ?>
            @foreach($fileRespondent as $f)
            <div class="dropdown-item" aria-labelledby="dropdownMenuButton"><b>{{$loop->iteration}}. {{$f}}</b>
                <a class="dropdown-item" href="{{url('/projects/view_respondents')}}/{{$f}}">View</a>
                <a class="dropdown-item" href="{{url('/projects/view')}}/{{$f}}" download>Download</a>
            </div>
            @endforeach
            @endif
            <button class="dropdown-item" type="button" data-toggle="modal" data-target="#vendorModal"><b>Upload</b></i></button>
            <a class="dropdown-item" href="{{ url('files/contoh_format_upload_respondent.xlsx') }}" download> <b>Download Sample</b></a>
            @if($tmp_respondent->count())
            <button class="dropdown-item" type="button" data-backdrop="static" data-toggle="modal" data-target="#dataErrorModal"><b>Check History Upload</b></i></button>
            @endif

        </div>
    </div>

    <div class="dropdown d-inline">
        <button title="Menu untuk DP" class="btn btn-primary" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" <?= (!in_array(Session::get('divisi_id'), [1, 2])) ? 'disabled' : '' ?>>
            <i class="fa fa-file"></i>Create Worksheet Callback
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="text-align: center;">
            <a title="Set Worksheet QC" href="{{ url('form_qc/set_template_qc')}}/{{$project->id}}" class='btn btn-success'><i class="fa fa-group"></i>Add Worksheet Callback</a>
            @foreach($worksheet as $w)
            <a href="{{ url('form_qc/load_template_qc')}}/{{$w->id}}" class='btn btn-success'><i class="fa fa-group"></i>{{$w->nama}}</a>
            @endforeach
        </div>
    </div>

    <div class="dropdown d-inline" data-toggle="tooltip" data-placement="top" title="Pastikan data responden nya telah di upload terlebih dahulu">
        <button class="btn btn-primary" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" <?= (!in_array(Session::get('divisi_id'), [1, 2])) ? 'disabled' : '' ?>>
            <i class="fa fa-file"></i>Upload Data Callback
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="text-align: center;">
            <button title="Upload Form QC" type="button" data-toggle="modal" data-target="#templateQcModal" class='btn btn-primary'><i class="fa fa-file"></i> Upload Jawaban QC</button>
            <a href="{{ url('files/contoh_format_upload_jawaban.xlsx') }}" class='btn btn-primary'><i class="fa fa-file"></i>Download Sample Format</a>
            <a href="{{ url('form_qc/view_uploaded_file/') }}/{{$project->id}}" class='btn btn-primary'><i class="fa fa-file"></i>Download Show Uploaded Data</a>
        </div>
    </div>


    <!-- <a title="My Plan " href="{{ url('/project_plans')}}" class='btn btn-primary'><i class="fa fa-file"></i>Upload TL</a>
    <a title="My Plan " href="{{ url('/project_plans')}}" class='btn btn-primary'><i class="fa fa-file"></i>Upload Kuesioner</a> -->
    {{-- IwayRiway 1--}}
    {{-- <a title="My Plan " href="{{ url('/project_plans/schedule')}}/{{$project->id}}" class='btn btn-primary'><i class="fa fa-tags"></i> My Plan </a> --}}
    {{-- Akhir 1--}}

    {{-- IwayRiway 2--}}
    {{-- <a title="My Plan " href="{{ url('/project_plans/schedule2')}}/{{$project->id}}" class='btn btn-primary'><i class="fa fa-tags"></i> My Plan IwayRiway</a> --}}
    {{-- Akhir 2--}}

    {{-- IwayRiway 3 --}}
    <!-- <a title="My Plan " href="{{ url('/project_plans/index2')}}" class='btn btn-primary'><i class="fa fa-tags"></i> My Plan IwayRiway</a> -->
    {{-- AKHIR IwayRiway 3 --}}
</div>
@endsection('top_menu_content')

@section('content')
{{-- PAK BUDI --}}
{{-- @section('action_url',  url('/projects').'/'.$project->id)
    @method('patch')
    @csrf
    <? //php $for_create_edit='edit';
    ?>
    @include('projects.projects.form_project') --}}
{{-- AKHIR PAK BUDI --}}

{{-- IWAYRIWAY --}}
@section('action_url', url('/projects').'/'.$project->id)
@method('patch')
@csrf

<div class="form-group row ">
    <label class="control-label col-md-3 col-sm-3 ">Nama Project</label>
    <div class="col-md-9 col-sm-9 ">
        <input type="text" class="form-control" name="nama_project" id="nama_project" required value="{{$project->nama}}" readonly>
    </div>
</div>

<div class="form-group row ">
    <label class="control-label col-md-3 col-sm-3 ">Kode Project</label>
    <div class="col-md-9 col-sm-9 ">
        <input type="text" class="form-control" name="kode_project" id="kode_project" required value="{{$project->kode_project}}" readonly>
    </div>
</div>

<div class="form-group row ">
    <label class="control-label col-md-3 col-sm-3 ">Nama Client</label>
    <div class="col-md-9 col-sm-9 ">
        <input type="text" class="form-control" name="nama_customer" id="nama_customer" disabled value="{{$project->nama_customer}}" readonly>
    </div>
</div>

<div class="form-group row ">
    <label class="control-label col-md-3 col-sm-3 ">Methodology</label>
    <div class="col-md-9 col-sm-9 ">
        <input type="text" class="form-control" name="method" id="method" disabled value="{{$project->methodology}}" readonly>
    </div>
</div>

<?php if ($project->vendor_korporasi) : ?>
    <div class="form-group row ">
        <label class="control-label col-md-3 col-sm-3 ">Vendor Korporasi</label>
        <div class="col-md-9 col-sm-9 ">
            <input type="text" class="form-control" disabled value="{{$project->vendor->nama_perusahaan}}" readonly>
        </div>
    </div>
<?php endif; ?>

<div class="form-group row ">
    <label class="control-label col-md-3 col-sm-3 ">Tanggal Deal</label>
    <div class="col-md-9 col-sm-9 ">
        <input type="text" class="form-control" name="tgl_deal" id="tgl_deal" disabled value="{{$project->tgl_deal}}" readonly>
    </div>
</div>

<div class="form-group row ">
    <label class="control-label col-md-3 col-sm-3 ">Tanggal Kick Off</label>
    <div class="col-md-9 col-sm-9 ">
        <input type="date" class="form-control" name="tgl_kickoff" id="tgl_kickoff" required value="{{$project->tgl_kickoff}}">
    </div>
</div>

<div class="form-group row ">
    <label class="control-label col-md-3 col-sm-3 ">Tanggal Akhir Kontrak</label>
    <div class="col-md-9 col-sm-9 ">
        <input type="date" class="form-control" name="tgl_akhir_kontrak" id="tgl_akhir_kontrak" required value="{{$project->tgl_akhir_kontrak}}" min="{{$project->tgl_kickoff}}" readonly>
    </div>
</div>

<div class="form-group row">
    <label class="control-label col-md-3 col-sm-3 ">Tanggal Approve Kuesioner</label>
    <div class="col-md-9 col-sm-9 ">
        <input type="date" class="form-control" name="tgl_approve_kuesioner" id="tgl_approve_kuesioner" required value="{{$project->tgl_approve_kuesioner}}">
    </div>
</div>

<div class="form-group row ">
    <label class="control-label col-md-3 col-sm-3 ">Keterangan</label>
    <div class="col-md-9 col-sm-9 ">
        <textarea type="text" class="form-control" name="ket" id="ket" required readonly>{{$project->ket}}</textarea>
    </div>
</div>

<div class="form-group row ">
    <label class="control-label col-md-3 col-sm-3 ">Batas Waktu DO (hari)</label>
    <div class="col-md-9 col-sm-9 ">
        <input type="int" class="form-control" name="batas_waktu" id="batas_waktu" required value="{{($project->batas_waktu_do)?$project->batas_waktu_do:0}}">
    </div>
</div>

{{-- </form> --}}
{{-- AKHIR IWAYRIWAY --}}

@endsection('content')

<!-- Modal -->
<div class="modal fade" id="tlModal" tabindex="-1" role="dialog" aria-labelledby="tlModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tlModalLabel">Upload File Team Leader</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ url('/projects/upload')}}" enctype="multipart/form-data">
                    @method('patch')
                    @csrf
                    <input type="hidden" name="id" value="{{$project->id}}">
                    <div class="input-group mb-3">
                        <div class="custom-file">
                            <input type="file" accept="application/pdf" class="custom-file-input" name="file[]" id="inputGroupFile01" multiple>
                            <label class="custom-file-label" for="inputGroupFile01" id="inputGroupFileText01">Choose file</label>
                        </div>
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

<!-- Modal -->
<div class="modal fade" id="kuesionerModal" tabindex="-1" role="dialog" aria-labelledby="kuesionerModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="kuesionerModalLabel">Upload Kuesioner</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ url('/projects/upload')}}" enctype="multipart/form-data">
                    @method('patch')
                    @csrf
                    <input type="hidden" name="id" value="{{$project->id}}">
                    <div class="input-group mb-3">
                        <div class="custom-file">
                            <input type="file" accept="application/pdf" class="custom-file-input" name="file[]" id="inputGroupFile02" multiple>
                            <label class="custom-file-label" for="inputGroupFile02" id="inputGroupFileText02">Choose file</label>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" name="button" value="kuesioner">Submit</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="vendorModal" tabindex="-1" role="dialog" aria-labelledby="vendorModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="vendorModalLabel">Upload File Respondent</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ url('/projects/upload')}}" enctype="multipart/form-data">
                    @method('patch')
                    @csrf
                    <input type="hidden" name="id" value="{{$project->id}}">
                    <div class="input-group mb-3">
                        <div class="custom-file">
                            <input type="file" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" class="custom-file-input" name="file[]" id="inputGroupFile03" multiple>
                            <label class="custom-file-label" for="inputGroupFile03" id="inputGroupFileText03">Choose file</label>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" name="button" value="respondent">Submit</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="templateQcModal" tabindex="-1" role="dialog" aria-labelledby="templateQcModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="templateQcModalLabel">Upload File QC</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ url('/form_qc/upload')}}" enctype="multipart/form-data">
                    @method('patch')
                    @csrf
                    <input type="hidden" name="id" value="{{$project->id}}">
                    <div class="input-group mb-3">
                        <div class="custom-file">
                            <input type="file" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" class="custom-file-input" name="file" id="inputGroupFile04">
                            <label class="custom-file-label" for="inputGroupFile03" id="inputGroupFileText04">Choose file</label>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" name="button" value="respondent">Submit</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="dataErrorModal" tabindex="-1" role="dialog" aria-labelledby="dataErrorModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dataErrorModalLabel">List Data</h5>
            </div>
            <div class="modal-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Nama</th>
                            <th scope="col">Row</th>
                            <th scope="col">Data</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tmp_respondent as $item) : ?>
                            <tr>
                                <td><?= $item->respname ?></td>
                                <td><?= $item->id ?></td>
                                <td>
                                    <?php
                                    if (!$item->intvdate) {
                                        echo "&#9900;  Data intvdate salah <br>";
                                    }
                                    if (!$item->vstart) {
                                        echo "&#9900;  Data vstart salah <br>";
                                    }
                                    if (!$item->vend) {
                                        echo "&#9900;  Data vend salah <br>";
                                    }
                                    if (!$item->duration) {
                                        echo "&#9900;  Data duration salah <br>";
                                    }
                                    if (!$item->upload) {
                                        echo "&#9900;  Data upload salah <br>";
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="btn-close-data-error" data-toggle="tooltip" data-placement="bottom" title="Pastikan data responden nya telah di perbaiki, setelah menekan close data history akan terhapus" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@section('javascript')
<script>
    $(document).ready(function() {
        const inputFile1 = $('#inputGroupFile01');
        inputFile1.change(function() {
            let string = $(this).val().split('\\');
            $('#inputGroupFileText01').text(string[string.length - 1]);
        })
        const inputFile2 = $('#inputGroupFile02');
        inputFile2.change(function() {
            let string = $(this).val().split('\\');
            $('#inputGroupFileText02').text(string[string.length - 1]);
        })
        const inputFile3 = $('#inputGroupFile03');
        inputFile3.change(function() {
            let string = $(this).val().split('\\');
            $('#inputGroupFileText03').text(string[string.length - 1]);
        })
        const inputFile4 = $('#inputGroupFile04');
        inputFile4.change(function() {
            let string = $(this).val().split('\\');
            $('#inputGroupFileText04').text(string[string.length - 1]);
        })

        $('#btn-close-data-error').click(() => {
            $.ajax({
                url: "{{url('/respondents/delete_tmp_respondent')}}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                },
                success: function(hasil) {
                    console.log(hasil);

                    location.reload();
                }
            })
        })

        $('#budget_id').change(() => {
            const id = $(this).find(":selected").val();
            $.ajax({
                url: "{{url('/projects/get_item_budget')}}",
                type: "get",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id
                },
                success: function(hasil) {
                    $('#item_budget_id').empty();
                    result = JSON.parse(hasil)
                    let html = `<option value="">Pilih Item Budget</option>`;
                    // console.log(result);
                    // console.log(result.length);
                    for (let i = 0; i < result.length; i++) {
                        console.log(result[i].rincian);
                        html += `
                        <option value="${result[i].no}">${result[i].rincian}</option>
                        `;
                    }
                    $('#item_budget_id').append(html);
                }
            })
        })
    })
</script>
@endsection
