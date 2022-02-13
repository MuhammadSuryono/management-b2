@extends('maingentelellaform')
@section('title', 'Tambah Keahlian ' )
@section('title2', $keahlian->keahlian)
@section('content')
@section('action_url', url('/keahlian_teams'))
@csrf
<?php $for_create_edit = 'create'; ?>
@include('teams.keahlian_teams.form_keahlian_team')
@endsection('content')