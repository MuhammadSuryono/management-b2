@extends('maingentelellaform')
@section('title', 'Tambah pemegang jabatan ' ) 
@section('title2', $jabatan->jabatan)
@section('content')
@section('action_url',  url('/jabatan_teams'))
    @csrf
    <?php $for_create_edit='create'; ?>
    @include('teams.jabatan_teams.form_jabatan_team')
@endsection('content')
