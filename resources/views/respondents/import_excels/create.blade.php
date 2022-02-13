@extends('maingentelellaformupload')
@section('title','Import Excel')
@section('content')
@section('action_url',  url('/import_excels'))
    @csrf
    <?php $for_create_edit='create'; ?>
    @include('respondents.import_excels.form_import_excel')
@endsection('content')
