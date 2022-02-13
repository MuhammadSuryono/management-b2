@extends('maingentelellaform')
@section('title','Edit Menu')






@section('content')
    @section('action_url' ,  url('/menus').'/'.$menu->id)
    @method('patch')
    @csrf
    <?php $for_create_edit='edit';?>
    @include('otentikasis.menus.form_menu')
@endsection('content')
