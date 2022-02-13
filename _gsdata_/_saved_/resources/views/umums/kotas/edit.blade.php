@extends('maingentelellaform')
@section('title','Edit Kota')
@section('content')
@section('action_url',  url('/kotas').'/'.$kota->id)
    @method('patch')
    @csrf
    <?php $for_create_edit='edit'; ?>
    @include('umums.kotas.form_kota')
@endsection('content')
