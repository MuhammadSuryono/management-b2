@extends('maingentelellaform')
@section('title','Edit Pekerjaan')
@section('content')
@section('action_url',  url('/pekerjaans').'/'.$pekerjaan->id)
    @method('patch')
    @csrf
    <?php $for_create_edit='edit'; ?>
    @include('umums.pekerjaans.form_pekerjaan')
@endsection('content')
