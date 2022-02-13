@extends('maingentelellaform')
@section('title','Tambah Tipe Produk')
@section('title2', $kategori_produk->kategori_produk)
@section('content')
@section('action_url',  url('/tipe_produks'))
    @csrf
    <?php $for_create_edit='create'; ?>
    @include('produks.tipe_produks.form_tipe_produk')
@endsection('content')
