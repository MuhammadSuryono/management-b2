@extends('maingentelellaform')
@section('title','Tambah Task')
@section('content')
@section('action_url',  url('/tasks'))
    @csrf
    <?php $for_create_edit='create'; ?>
    @include('project_resources.tasks.form_task')
@endsection('content')
.