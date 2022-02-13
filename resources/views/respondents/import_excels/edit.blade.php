@extends('maingentelellaform')
@section('title','Edit Import Data')
@section('content')
@section('action_url',  url('/import_excels').'/'.$import_excel->id)
    @method('patch')
    @csrf
    <?php $for_create_edit='edit'; ?>
    @include('respondents.import_excels.form_import_excel')
@endsection('content')
