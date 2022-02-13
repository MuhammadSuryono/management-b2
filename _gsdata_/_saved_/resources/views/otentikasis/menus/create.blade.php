@extends('maingentelellaform')
@section('title','Tambah Menu')
@section('content')
@section('action_url',  url('/menus'))
    @csrf
    <?php $for_create_edit='create'; ?>
    @include('otentikasis.menus.form_menu')
@endsection('content')
.