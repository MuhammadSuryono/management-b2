@extends('maingentelellascanqr')
@section('title', 'Scan QR untuk absen')
{{-- @section('title2', 'Proyek ' . $project_kegiatan->project_plan->project->nama  . ' - ' . $project_kegiatan->project_plan->task->task) --}}
@section('content')
    @section('action_url',  url('/project_absensis/saveqr'))
    @csrf
    <?php $for_create_edit='create'; ?>
    @include('projects.project_absensis.form_scanqr')
@endsection('content')
