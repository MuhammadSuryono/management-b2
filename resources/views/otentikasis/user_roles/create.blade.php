@extends('maingentelellaform')
@section('title','Tambah Role untuk User')
@section('content')
@section('action_url',  url('/user_roles'))
    @csrf
    <?php $for_create_edit='create'; ?>
    @include('otentikasis.user_roles.form_user_role')
@endsection('content')
.