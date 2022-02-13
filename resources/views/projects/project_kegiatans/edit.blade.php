@extends('maingentelellaform')
@section('title', 'Persiapkan Absensi')
@section('title2', 'Proyek ' . $project_plan->nama . ' - ' . $project_plan->nama_kegiatan)
@section('content')
@section('action_url', url('/project_kegiatans').'/'.$project_kegiatan->id)
@method('patch')
@csrf
<?php $for_create_edit = 'edit'; ?>
@include('projects.project_kegiatans.form_project_kegiatan')
@endsection('content')
<?php $script_include = 'projects.project_kegiatans.script'; ?>
r