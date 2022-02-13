@extends('maingentelellaform')
@section('title','Tambah Lokasi')
@section('content')
@section('action_url',  url('/lokasis'))
    @csrf
    <?php $for_create_edit='create'; ?>
    @include('project_resources.lokasis.form_lokasi')
@endsection('content')
.