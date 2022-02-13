@extends('maingentelellaform')
@section('title','Edit User')
@section('top_menu_content')
<div class="well">Manage:
    <a title="Role " href="{{ url('/user_roles')}}" class='btn btn-round btn-warning'>User Roles </a>
</div>
@endsection('top_menu_content')

@section('content')
@section('action_url', url('/users').'/'.$user->id)
@method('patch')
@csrf
<?php $for_create_edit = 'edit'; ?>
@include('otentikasis.users.form_user')
@endsection('content')