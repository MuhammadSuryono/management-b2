@extends('maingentelellaform')
@section('title','Edit Lokasi')
@section('content')
@section('action_url',  url('/lokasis').'/'.$lokasi->id)
    @method('patch')
    @csrf
    <?php $for_create_edit='edit'; ?>
    @include('project_resources.lokasis.form_lokasi')
@endsection('content')
