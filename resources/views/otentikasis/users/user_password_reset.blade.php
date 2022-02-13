@extends('maingentelellaform')
@section('title', 'Pilih User utk reset password') 
@section('content')
@section('action_url',  url('/users/update_reset_password'))
    @csrf
    @include('otentikasis.users.list_available_user')
    <p>Pilih semua user yang ingin direset passwordnya, lalu klik Save</p>
@endsection('content')
