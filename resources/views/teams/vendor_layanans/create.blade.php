@extends('maingentelellaform')
@section('title', 'Tambah Kategori Layanan untuk ')
@section('title2', $vendor->nama_perusahaan)
@section('content')
@section('action_url', url('/vendor_layanan'))
@csrf
<?php $for_create_edit = 'create'; ?>
@include('teams.vendor_layanans.form_vendor_layanan')
@endsection('content')