@extends('maingentelellaform')
@section('title', 'Tambah Plan '  ) 
@section('title2', 'Proyek ' . session('current_project_nama'))
@section('content')
@section('action_url',  url('/project_plans/store2'))
    @csrf
    <?php $for_create_edit='create'; ?>
    @include('projects.project_plans.form_project_plan2')
@endsection('content')
