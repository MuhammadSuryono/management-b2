@extends('maingentelellaform')
@section('title','Tambah Bahasa Asing')
@section('content')
@section('action_url',  url('/bahasas'))
    @csrf
    <?php $for_create_edit='create'; ?>
    @include('teams.bahasas.form_bahasa')
@endsection('content')
.