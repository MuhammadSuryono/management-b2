@extends('maingentelellaform')
@section('title', 'Tambah penguasa bahasa ' )
@section('title2', $bahasa->bahasa)
@section('content')
@section('action_url', url('/bahasa_teams'))
@csrf
<?php $for_create_edit = 'create'; ?>
@include('teams.bahasa_teams.form_bahasa_team')
@endsection('content')