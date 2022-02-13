@extends('maingentelellaform')
@section('title','Tambah Respondent')
@section('content')
{{-- @section('action_url',  url('/respondents').'/'.$pekerjaan->pekerjaan_id) --}}
@section('action_url',  url('/respondents'))
    @csrf
    <?php $for_create_edit='create'; ?>
    @include('respondents.respondents.form_respondent')
@endsection('form_content')
