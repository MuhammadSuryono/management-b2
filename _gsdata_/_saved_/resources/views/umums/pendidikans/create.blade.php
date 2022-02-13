@extends('maingentelellaform')
@section('title','Tambah Pendidikan')
@section('content')
@section('action_url',  url('/pendidikans'))
    @csrf
    <?php $for_create_edit='create'; ?>
    @include('umums.pendidikans.form_pendidikan')
@endsection('content')
.