@extends('maingentelellaform')
@section('title', 'Tambah Kota '  ) 
@section('title2', 'Proyek ' . $project -> nama)
@section('content')
@section('action_url',  url('/project_kotas'))
    @csrf
    <?php $for_create_edit='create'; ?>
    @include('projects.project_kotas.form_project_kota')
@endsection('content')
