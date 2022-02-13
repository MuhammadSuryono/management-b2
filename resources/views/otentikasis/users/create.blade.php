@extends('maingentelellaform')
@section('title','Tambah User')
@section('content')
@section('action_url', url('/users'))
@csrf
<?php $for_create_edit = 'create'; ?>
@include('otentikasis.users.form_user')
@endsection('content')