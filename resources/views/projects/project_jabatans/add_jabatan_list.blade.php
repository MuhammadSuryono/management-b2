@extends('maingentelellaform')
@section('title', 'Tambah Jabatan utk area '. $project_kota->kota->kota)
@section('title2','Proyek ' . $project_kota->project->nama)
@section('content')
@section('action_url', url('/project_jabatans'))
@csrf
{{-- Available jabatan List --}}
<input type="hidden" id="project_kota_id" name="project_kota_id" value="{{$project_kota->id}}">
@include('projects.project_jabatans.list_available_jabatan')
{{-- end of available jabatan List     --}}
<p>Pilih semua jabatan yang ingin dilibatkan, lalu klik Save</p>
@endsection('content')