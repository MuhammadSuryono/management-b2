@extends('maingentelellaform')
@section('title','Edit Bahasa Asing')
@section('content')
@section('action_url',  url('/bahasas').'/'.$bahasa->id)
    @method('patch')
    @csrf
    <?php $for_create_edit='edit'; ?>
    @include('teams.bahasas.form_bahasa')
@endsection('content')
