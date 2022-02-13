@extends('maingentelellaform')
@section('title','Edit SesA')
@section('content')
@section('action_url',  url('/ses_finals').'/'.$ses_final->id)
    @method('patch')
    @csrf
    <?php $for_create_edit='edit'; ?>
    @include('respondents.ses_finals.form_ses_final')
@endsection('content')
