@extends('maingentelellaform')
@section('title','Tambah SesA')
@section('content')
@section('action_url',  url('/ses_as'))
    @csrf
    <?php $for_create_edit='create'; ?>
    @include('respondents.ses_as.form_ses_a')
@endsection('content')
.