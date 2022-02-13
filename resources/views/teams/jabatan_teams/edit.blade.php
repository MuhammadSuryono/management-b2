@extends('maingentelellaform')
@section('title', 'Edit pemegang jabatan' )
@section('title2', $jabatan -> jabatan)
@section('content')
@section('action_url', url('/jabatan_teams').'/'.$jabatan_team->id)
@method('patch')
@csrf
<?php $for_create_edit = 'edit'; ?>
@include('teams.jabatan_teams.form_jabatan_team')
@endsection('content')