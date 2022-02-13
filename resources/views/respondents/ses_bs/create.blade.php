@extends('maingentelellaform')
@section('title','Tambah SesA')
@section('content')
@section('action_url',  url('/ses_bs'))
    @csrf
    <?php $for_create_edit='create'; ?>
    @include('respondents.ses_bs.form_ses_b')
@endsection('content')
.