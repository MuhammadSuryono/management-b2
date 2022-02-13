@extends('maingentelellaform')
@section('title', 'Tambah Peranan untuk ')
@section('title2', $team -> nama)
@section('content')
@section('action_url', url('/team_jabatans'))
@csrf
<?php $for_create_edit = 'create'; ?>
@include('teams.team_jabatans.form_team_jabatan')
@endsection('content')