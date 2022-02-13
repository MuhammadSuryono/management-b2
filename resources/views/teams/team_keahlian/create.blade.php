@extends('maingentelellaform')
@section('title', 'Tambah Keahlian ' )
@section('title2', $team -> nama)
@section('content')
@section('action_url', url('/team_keahlian'))
@csrf
<?php $for_create_edit = 'create'; ?>
@include('teams.team_keahlian.form_team_keahlian')
@endsection('content')