@extends('maingentelellaform')
@section('title', 'Edit Keahlian ' )
@section('title2', $keahlian -> keahlian)
@section('content')
@section('action_url', url('/keahlian_teams').'/'.$keahlian_team->id)
@method('patch')
@csrf
<?php $for_create_edit = 'edit'; ?>
@include('teams.keahlian_teams.form_keahlian_team')
@endsection('content')