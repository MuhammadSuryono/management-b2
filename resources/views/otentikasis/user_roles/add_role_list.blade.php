@extends('maingentelellaform')
@section('title', 'Tambah role utk user '. $user->user_login) 
@section('content')
@section('action_url',  url('/user_roles'))
    @csrf
    {{-- user_updated (=user login) --}}
    <input type="hidden" id="updated_by" name="updated_by" 
    value="{{session('user_id')}}">

    {{-- User owns the roles --}}
    <input type="hidden" id="user_id" name="user_id" 
        value="{{ session('current_role_user_id') }}">
        
    @include('otentikasis.user_roles.list_available_role')
    {{-- end of available role List     --}}
    <p>Pilih semua role yang ingin dilibatkan, lalu klik Save</p>
@endsection('content')
