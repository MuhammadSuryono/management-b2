@extends('maingentelellaform')
@section('title','Tambah Contact')
@section('content')
@section('action_url',  url('/customer_pics'))
    @csrf
    <?php $for_create_edit='create'; ?>
    @include('customers.customer_pics.form_customer_pic')
@endsection('content')
