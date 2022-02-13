@extends('maingentelellaform')
@section('title','Ganti Password')

@section('content')
    @section('action_url',  url('/users/save_ganti_password'))
    @csrf
    <?php $for_create_edit='create';?>
    @include('otentikasis.users.form_ganti_password')
@endsection('content')
