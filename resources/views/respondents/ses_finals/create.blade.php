@extends('maingentelellaform')
@section('title','Tambah SesA')
@section('content')
@section('action_url',  url('/ses_finals'))
    @csrf
    <?php $for_create_edit='create'; ?>
    @include('respondents.ses_finals.form_ses_final')
@endsection('content')
.