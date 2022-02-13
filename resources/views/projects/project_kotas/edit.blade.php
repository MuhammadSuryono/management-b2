@extends('maingentelellaform')
@section('title', 'Edit Kota '  ) 
@section('title2', 'Proyek ' . $project -> nama)
@section('content')
@section('action_url',  url('/project_kotas').'/'.$project_kota->id)
    @method('patch')
    @csrf
    <?php $for_create_edit='edit'; ?>
    @include('projects.project_kotas.form_project_kota')
@endsection('content')
