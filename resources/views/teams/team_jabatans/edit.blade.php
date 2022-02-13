@extends('maingentelellaform')
@section('title', 'Edit Peranan untuk ')
@section('title2', $team -> nama)
@section('content')
@section('action_url', url('/team_jabatans').'/'.$team_jabatan->id)
@method('patch')
@csrf
<?php $for_create_edit = 'edit'; ?>
@include('teams.team_jabatans.form_team_jabatan')
@endsection('content')