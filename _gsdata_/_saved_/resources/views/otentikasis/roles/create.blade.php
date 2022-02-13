@extends('maingentelellaform')
@section('title','Tambah Role')
@section('content')
@section('action_url',  url('/roles'))
    @csrf
    <?php $for_create_edit='create'; ?>
    @include('otentikasis.roles.form_role')
@endsection('content')
.