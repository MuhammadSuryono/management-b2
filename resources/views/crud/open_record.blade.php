@extends('maingentelellaform')
@section('title',$title)
@section('content')
@section('action_url', $action_url)
@if($create_edit=='edit')
@method('patch')
@endif
@csrf
<?php $for_create_edit = $create_edit; ?>
@include($include_form)
@endsection('content')