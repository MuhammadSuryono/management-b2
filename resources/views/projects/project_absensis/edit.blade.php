@extends('maingentelellaform')
@section('title', 'Persiapkan Absensi')
{{-- @section('title2', 'Proyek ' . $project_kegiatan->project_plan->project->nama  . ' - ' . $project_kegiatan->project_plan->task->task) --}}
@section('content')
@section('action_url',  url('/project_absensis').'/'.$project_absensi->id)
    @method('patch')
    @csrf
    <?php $for_create_edit='edit'; ?>
    @include('projects.project_absensis.form_project_absensi')
@endsection('content')
