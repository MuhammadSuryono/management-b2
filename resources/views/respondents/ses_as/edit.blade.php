@extends('maingentelellaform')
@section('title','Edit SesA')
@section('content')
@section('action_url',  url('/ses_as').'/'.$ses_a->id)
    @method('patch')
    @csrf
    <?php $for_create_edit='edit'; ?>
    @include('respondents.ses_as.form_ses_a')
@endsection('content')
