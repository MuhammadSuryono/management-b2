@extends('maingentelellaform')
@section('title', 'Edit bahasa asing  ' ) 
@section('title2', $team -> nama)
@section('content')
@section('action_url',  url('/team_bahasas').'/'.$team_bahasa->id)
    @method('patch')
    @csrf
    <?php $for_create_edit='edit'; ?>
    @include('teams.team_bahasas.form_team_bahasa')
@endsection('content')
