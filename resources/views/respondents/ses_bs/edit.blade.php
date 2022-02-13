@extends('maingentelellaform')
@section('title','Edit SesA')
@section('content')
@section('action_url',  url('/ses_bs').'/'.$ses_b->id)
    @method('patch')
    @csrf
    <?php $for_create_edit='edit'; ?>
    @include('respondents.ses_bs.form_ses_b')
@endsection('content')
