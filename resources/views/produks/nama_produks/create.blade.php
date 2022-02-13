@extends('maingentelellaform')
@section('title','Tambah Nama Produk  ')
@section('title2', $tipe_produk->kategori_produk->kategori_produk .
' - '. $tipe_produk->tipe_produk)
@section('content')
@section('action_url',  url('/nama_produks'))
    @csrf
    <?php $for_create_edit='create'; ?>
    @include('produks.nama_produks.form_nama_produk')
@endsection('content')
