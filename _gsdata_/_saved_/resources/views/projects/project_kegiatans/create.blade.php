@extends('maingentelellaform')
@section('title', 'Persiapkan Absensi')
@section('title2', 'Proyek ' . $project_plan->project->nama  . ' - ' . $project_plan->task->task)
@section('content')
    @section('action_url',  url('/project_kegiatans'))
    @csrf
    <?php $for_create_edit='create'; ?>
    @include('projects.project_kegiatans.form_project_kegiatan')
@endsection('content')
