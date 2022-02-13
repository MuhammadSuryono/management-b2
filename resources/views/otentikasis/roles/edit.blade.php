@extends('maingentelellaform')
@section('title','Edit Role')
@section('top_menu_content')
<div class="well">Manage:
    <a title="Menu " href="{{ url('/role_menus')}}" class='btn btn-round btn-warning'>Role Menus </a>
</div>
@endsection('top_menu_content')

@section('content')
    @section('action_url',  url('/roles').'/'.$role->id)
    @method('patch')
    @csrf
    <?php $for_create_edit='edit'; ?>
    @include('otentikasis.roles.form_role')
@endsection('content')
