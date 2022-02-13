@extends('maingentelellaform')
@section('title', 'Tambah menu utk role '.  session('current_menu_role')) 
@section('content')
@section('action_url',  url('/role_menus'))
    @csrf
    {{-- role_updated (=role login) --}}
    <input type="hidden" id="updated_by" name="updated_by" 
    value="{{session('role_id')}}">

    {{-- Role owns the menus --}}
    <input type="hidden" id="role_id" name="role_id" 
        value="{{ session('current_menu_role_id') }}">
        
    @include('otentikasis.role_menus.list_available_menu')
    {{-- end of available menu List     --}}
    <p>Pilih semua menu yang ingin dilibatkan, lalu klik Save</p>
@endsection('content')
