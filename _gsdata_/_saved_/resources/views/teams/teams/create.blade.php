@extends('maingentelellaform')
@section('title','Tambah profile ')
@section('content')
@section('action_url',  url('/teams'))
    @csrf
    <?php $for_create_edit='create'; ?>
    @include('teams.teams.form_team')
@endsection('content')
.