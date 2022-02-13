@extends('maingentelellaform')
@section('title','Edit Jabatan Tim')
@section('content')
@section('action_url',  url('/jabatans').'/'.$jabatan->id)
    @method('patch')
    @csrf
    <?php $for_create_edit='edit'; ?>
    @include('teams.jabatans.form_jabatan')
@endsection('content')
