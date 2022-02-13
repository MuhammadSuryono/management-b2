@extends('maingentelellaform')
@section('title','Edit Project')
@section('content')
@section('action_url',  url('/project_importeds').'/'.$project_imported->id)
    @method('patch')
    @csrf
    <?php $for_create_edit='edit'; ?>
    @include('respondents.project_importeds.form_project_imported')
@endsection('content')
