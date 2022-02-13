@extends('maingentelellaform')
@section('title','Edit Kategori Produk')
@section('content')
@section('action_url',  url('/kategori_produks').'/'.$kategori_produk->id)
    @method('patch')
    @csrf
    <?php $for_create_edit='edit'; ?>
    @include('produks.kategori_produks.form_kategori_produk')
@endsection('content')
