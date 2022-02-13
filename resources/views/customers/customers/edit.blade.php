@extends('maingentelellaform')
@section('title','Edit Perusahaan')
@section('content')
{{-- @section('action_url',  url('/customers').'/'.$customer->kodecustomer) --}}
@section('action_url',  url('/customers').'/'.$customer->id)
    @method('patch')
    @csrf
    <?php $for_create_edit='edit'; ?>
    @include('customers.customers.form_customer')
@endsection('content')
