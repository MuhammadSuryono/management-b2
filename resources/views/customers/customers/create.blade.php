@extends('maingentelellaform')
@section('title','Tambah Perusahaan')
@section('content')
@section('action_url',  url('/customers'))
    @csrf
    <?php $for_create_edit='create'; ?>
    @include('customers.customers.form_customer')
@endsection('content')
