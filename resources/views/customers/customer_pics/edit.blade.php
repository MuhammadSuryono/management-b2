@extends('maingentelellaform')
@section('title','Edit Contact')
@section('content')
{{-- @section('action_url',  url('/customer_pics').'/'.$customer_pic->kodecustomer_pic) --}}
@section('action_url',  url('/customer_pics').'/'.$customer_pic->id)
    @method('patch')
    @csrf
    <?php $for_create_edit='edit'; ?>
    @include('customers.customer_pics.form_customer_pic')
@endsection('content')
