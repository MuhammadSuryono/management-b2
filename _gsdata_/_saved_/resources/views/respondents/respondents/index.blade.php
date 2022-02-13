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
                                        <label class="col-form-label col-md-3 col-sm-3" for="project_imported_id">Project</label>
                                        <div class="col-md-9 col-sm-9">
                                            <select id="project_imported_id" name="project_imported_id" class="form-control pull-right">
                                                <option value="all">All</option>
                                                @foreach($project_importeds as $db)
                                                    @if(isset($_GET['project_imported_id']) and  $_GET['project_imported_id'] == $db['id'])
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
                                            <select id="kota_id" name="kota_id" class="form-control">
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
                                                    @if(isset($_GET['gender_id']) and  $_GET['gender_id'] == $db['id'])
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
z                                                    @endif
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
                                                    @if(isset($_GET['pendidikan_id']) and $_GET['pendidikan_id'] == $db['id'])
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
                                                    @if(isset($_GET['pekerjaan_id']) and $_GET['pekerjaan_id'] == $db['id'])
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
                                        <label class="col-form-label col-md-3 col-sm-3" for="isvalid_id">Responden Valid</label>
                                        <div class="col-md-9 col-sm-9">
                                            <select id="isvalid_id" name="isvalid_id" class="form-control">
                                                <option value="all">All</option>
                                                @foreach($isvalids as $db)
                                                    @if(isset($_GET['isvalid_id']) and $_GET['isvalid_id'] == $db['id'])
                                                        <option value="{{$db['id']}}" selected>{{$db['isvalid']}}</option>
                                                    @else
                                                        <option value="{{$db['id']}}"> {{$db['isvalid']}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" id="link_from" name="link_from" 
value="{{session('link_from')}}">

                            </div>

                            <div align="center" class="form-group">
                                <button type="submit" class="btn btn-info"> Show </button>
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


{{-- Standard Table TOP --}}
@include('layouts/gentelella/table_top')
{{-- End of Standard table TOP --}}
    <thead>
        <tr>
            <th>No.</th>
            <th>Nama</th>
            <th>Gender</th>
            <th>City</th>

            @if(count($user_role)>0)
            <th>Email</th>
            <th>HP</th>
            @endif
            
            <th>Usia</th>
            <th>Pendidikan</th>
            <th>Pekerjaan</th>
            <th>SES</th>
            <th>Valid</th>
            <th>Last Update</th>
            <th>Update oleh</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($respondents as $respondent)
        <tr>
            <th scope='row'>{{$loop->iteration}}</th>
            <td>{{$respondent->respname}}</td>
            <td>{{$respondent->gender->gender}}</td>
            <td>
                @if(isset($respondent->kota->kota))
                    {{$respondent->kota->kota}}
                @endif
            </td>
            @if(count($user_role)>0)
            <td>
                @if(isset($respondent->email))
                    {{$respondent->email}}
                @endif
            </td>
            <td>{{$respondent->mobilephone}}</td>
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

            <td>{{$respondent->ses_final->ses_final}}</td>
            
            <td>
                @if(isset($respondent->isvalid->isvalid))
                    {{$respondent->isvalid->isvalid}}
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
                @if(isset($respondent->updated_by->user_login))
                    {{$respondent->updated_by->user_login}}
                @endif
            </td>
            <td>
                    <a href="{{ url('/respondents/')}}/{{$respondent->id}}/edit" class='btn btn-primary btn-sm' target="_blank"><i class="fa fa-edit"></i></a>
                    <a href="{{ url('/respondents/')}}/delete/{{$respondent->respondenid}}" class='btn btn-danger btn-sm'><i class="fa fa-trash-o"></i></a>
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
@endsection('content')
