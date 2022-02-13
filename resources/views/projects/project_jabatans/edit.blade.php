@extends('maingentelellaform')
@section('title', 'Edit Jenis Jabatan')
@section('title2', 'Proyek ' . $project_kota->project->nama  . ' - ' . $project_kota->kota->kota)
@section('content')
@section('action_url',  url('/project_jabatans').'/'.$project_jabatan->id)
    @method('patch')
    @csrf
    <?php $for_create_edit='edit'; ?>
    @include('projects.project_jabatans.form_project_jabatan')
@endsection('content')
