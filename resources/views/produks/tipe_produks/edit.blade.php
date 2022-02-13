@extends('maingentelellaform')
@section('title','Edit Tipe Produk')
@section('title2', $kategori_produk->kategori_produk)
@section('content')
    @section('action_url',  url('/tipe_produks').'/'. $tipe_produk->id)
    @method('patch')
    @csrf
    <?php $for_create_edit='edit'; ?>
    @include('produks.tipe_produks.form_tipe_produk')
@endsection('content')
