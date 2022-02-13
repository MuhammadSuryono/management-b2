@extends('maingentelellaform')
@section('title','Tambah Project')
@section('content')
@section('action_url', url('/projects'))
@csrf
<?php $for_create_edit = 'create'; ?>
@include('projects.projects.form_project')
@endsection('content')