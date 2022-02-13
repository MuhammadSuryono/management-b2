@extends('maingentelellaform')
@section('title', 'Tambah Kategori Layanan Korporasi ' )
@section('title2', $layanan->layanan)
@section('content')
@section('action_url', url('/layanan_vendors'))
@csrf
<?php $for_create_edit = 'create'; ?>
@include('teams.layanan_vendors.form_layanan_vendor')
@endsection('content')