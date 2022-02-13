@extends('maingentelellaform')
@section('title','Edit Pendidikan')
@section('content')
@section('action_url',  url('/pendidikans').'/'.$pendidikan->id)
    @method('patch')
    @csrf
    <?php $for_create_edit='edit'; ?>
    @include('umums.pendidikans.form_pendidikan')
@endsection('content')
