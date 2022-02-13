@extends('maingentelellaform')
@section('title', 'Tambah bahasa' )
@section('title2', $team -> nama)
@section('content')
@section('action_url', url('/team_bahasas'))
@csrf
<?php $for_create_edit = 'create'; ?>
@include('teams.team_bahasas.form_team_bahasa')
@endsection('content')