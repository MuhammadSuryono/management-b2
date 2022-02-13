@extends('maingentelellaform')
@section('title', 'Edit '. $project_jabatan->jabatan->jabatan) 
@section('title2','Proyek ' .  $project_jabatan->project_kota->project->nama . ' - ' . $project_jabatan->project_kota->kota->kota)
@section('content')
@section('action_url',  url('/project_teams').'/'.$project_team->id)
    @method('patch')
    @csrf
    <?php $for_create_edit='edit'; ?>
    @include('projects.project_teams.form_project_team')
@endsection('content')
