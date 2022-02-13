@extends('maingentelellaform')
@section('title','Edit Nama Produk')
@section('title2', $tipe_produk->kategori_produk->kategori_produk .
' - '. $tipe_produk->tipe_produk)@section('content')
    @section('action_url',  url('/nama_produks').'/'.$nama_produk->id)
    @method('put')
    @csrf
    <?php $for_create_edit='edit'; ?>
    @include('produks.nama_produks.form_nama_produk')
@endsection('content')
