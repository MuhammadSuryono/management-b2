@extends('maingentelellaform')
@section('title','Tambah Project')
@section('content')
@section('action_url', url('/project_importeds'))
@csrf
<?php $for_create_edit = 'create'; ?>
@include('respondents.project_importeds.form_project')
@endsection('content')
.