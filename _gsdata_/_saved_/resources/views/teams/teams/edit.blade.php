@extends('maingentelellaform')
@section('title','Edit profile')
@section('content')
@section('action_url',  url('/teams').'/'.$team->id)
    @method('patch')
    @csrf
    <?php $for_create_edit='edit'; ?>
    @include('teams.teams.form_team')
@endsection('content')
