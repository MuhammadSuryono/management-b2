@extends('maingentelellaform')
@section('title', 'Edit Plan ' )
@section('title2', 'Proyek ' . session('current_project_nama'))
@section('content')
@section('action_url', url('/project_plans/update2').'/'.$project_plan->id)

{{-- @method('patch') --}}
@csrf

<input type="hidden" id="project_id" name="project_id" value="{{ session('current_project_id') }} ">
<input type="hidden" id="user_id" name="user_id" value="{{session('user_id')}}">


<div class="item form-group">
    <label class="col-form-label col-md-3 col-sm-3 col-xs-6 label-align" for="task_id">Task </label>
    <div class="col-md-3 col-sm-3 col-xs-6">
        <select id="task_id" name="task_id" class="form-control pull-right" required>
            <option value="{{$tasks->id}}">{{$tasks->task}}</option>
        </select>
    </div>
</div>

<div class="item form-group">
    <label class="col-form-label col-md-3 col-sm-3 col-xs-6 label-align" for="n_target">N responden </label>
    <div class="col-md-3 col-sm-3 col-xs-6">
        <input type="number" id="n_target" name="n_target" class="form-control " value="{{$project_plan->n_target}}" required>
    </div>
</div>

<div class="item form-group">
    <label class="col-form-label col-md-3 col-sm-3 col-xs-6 label-align" for="date_start_target">Tanggal Mulai </label>
    <div class="col-md-3 col-sm-3 col-xs-6">
        <input type="date" id="date_start_target" name="date_start_target" class="form-control  " value="{{$project_plan->date_start_target}}" required>
    </div>
</div>

<div class="item form-group">
    <label class="col-form-label col-md-3 col-sm-3 col-xs-6 label-align" for="date_finish_target">Tanggal Selesai </label>
    <div class="col-md-3 col-sm-3 col-xs-6">
        <input type="date" id="date_finish_target" name="date_finish_target" class="form-control  " value="{{$project_plan->date_finish_target}}" required>
    </div>
</div>

<div class="item form-group">
    <label class="col-form-label col-md-3 col-sm-3 col-xs-6 label-align" for="ket">Ket </label>
    <div class="col-md-6 col-sm-6 col-xs-6">
        <input type="text" id="ket" name="ket" class="form-control  " value="{{$project_plan->ket}}" required>
    </div>
</div>
@endsection('content')