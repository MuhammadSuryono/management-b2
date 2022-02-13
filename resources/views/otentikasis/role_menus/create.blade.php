@extends('maingentelellaform')
@section('title','Tambah Menu untuk Role')
@section('content')
@section('action_url',  url('/role_menus'))
    @csrf
    <?php $for_create_edit='create'; ?>
    @include('otentikasis.role_menus.form_role_menu')
@endsection('content')
.