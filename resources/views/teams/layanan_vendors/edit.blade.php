@extends('maingentelellaform')
@section('title', 'Edit pemegang jabatan' )
@section('title2', $layanan->layanan)
@section('content')
@section('action_url', url('/layanan_vendors').'/'.$layanan_vendor->id)
@method('patch')
@csrf
<?php $for_create_edit = 'edit'; ?>
@include('teams.layanan_vendors.form_layanan_vendor')
@endsection('content')