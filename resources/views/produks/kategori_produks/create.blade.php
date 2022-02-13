@extends('maingentelellaform')
@section('title','Tambah Kategori Produk')
@section('content')
@section('action_url',  url('/kategori_produks'))
    @csrf
    <?php $for_create_edit='create'; ?>
    @include('produks.kategori_produks.form_kategori_produk')
@endsection('content')
