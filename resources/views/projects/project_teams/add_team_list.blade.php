@extends('maingentelellaform')
@section('title', 'Tambah Team'. $project_jabatan->jabatan->jabatan)
@section('title2','Proyek ' . $project_jabatan->project_kota->project->nama . ' - ' . $project_jabatan->project_kota->kota->kota)
@section('content')
@section('action_url', url('/project_teams'))
@csrf
{{-- Available team List --}}
<input type="hidden" id="project_jabatan_id" name="project_jabatan_id" value="{{$project_jabatan->id}}">
@include('projects.project_teams.list_available_team')
{{-- end of available team List     --}}
<p>.</p>
@endsection('content')