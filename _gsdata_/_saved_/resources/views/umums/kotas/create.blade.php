@extends('maingentelellaform')
@section('title','Tambah Kota')
@section('content')
@section('action_url',  url('/kotas'))
    @csrf
    <?php $for_create_edit='create'; ?>
    @include('umums.kotas.form_kota')
@endsection('content')
.