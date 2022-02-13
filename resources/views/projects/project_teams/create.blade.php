@extends('maingentelellaform')
@section('title', 'Tambah '. $project_jabatan->jabatan->jabatan) 
@section('title2','Proyek ' .  $project_jabatan->project_kota->project->nama . ' - ' . $project_jabatan->project_kota->kota->kota)

@section('content')
@section('action_url',  url('/project_teams'))
    @csrf
    <?php $for_create_edit='create';?>
    @include('projects.project_teams.form_project_team')
@endsection('content')
