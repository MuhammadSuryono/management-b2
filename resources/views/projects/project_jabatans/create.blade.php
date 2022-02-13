@extends('maingentelellaform')
@section('title', 'Tambah Jenis Jabatan')
@section('title2', 'Proyek ' . $project_kota->project->nama  . ' - ' . $project_kota->kota->kota)
@section('content')
@section('action_url',  url('/project_jabatans'))
    @csrf
    <?php $for_create_edit='create'; ?>
    @include('projects.project_jabatans.form_project_jabatan')
@endsection('content')
