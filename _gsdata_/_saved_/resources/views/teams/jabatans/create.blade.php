@extends('maingentelellaform')
@section('title','Tambah Jabatan Tim')
@section('content')
@section('action_url',  url('/jabatans'))
    @csrf
    <?php $for_create_edit='create'; ?>
    @include('teams.jabatans.form_jabatan')
@endsection('content')
.