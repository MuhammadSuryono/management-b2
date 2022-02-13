@extends('maingentelellaform')
@section('title', 'Edit penguasa bahasa ' ) 
@section('title2', $bahasa -> bahasa)
@section('content')
@section('action_url',  url('/bahasa_teams').'/'.$bahasa_team->id)
    @method('patch')
    @csrf
    <?php $for_create_edit='edit'; ?>
    @include('teams.bahasa_teams.form_bahasa_team')
@endsection('content')
