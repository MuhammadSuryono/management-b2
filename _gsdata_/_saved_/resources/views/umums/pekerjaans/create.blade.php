@extends('maingentelellaform')
@section('title','Tambah Pekerjaan')
@section('content')
@section('action_url',  url('/pekerjaans'))
    @csrf
    <?php $for_create_edit='create'; ?>
    @include('umums.pekerjaans.form_pekerjaan')
@endsection('content')
.