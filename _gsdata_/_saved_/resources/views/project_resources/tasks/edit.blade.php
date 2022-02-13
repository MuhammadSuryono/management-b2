@extends('maingentelellaform')
@section('title','Edit Task')
@section('content')
@section('action_url',  url('/tasks').'/'.$task->id)
    @method('patch')
    @csrf
    <?php $for_create_edit='edit'; ?>
    @include('project_resources.tasks.form_task')
@endsection('content')
