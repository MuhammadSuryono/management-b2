@extends('maingentelellatable')
@section('title', 'Daftar Nama Produk (Level 3) : ' . $nama_produks->count())
@section('title2', $tipe_produk->kategori_produk->kategori_produk .
' - '. $tipe_produk->tipe_produk)
@section('title_group',$tipe_produk)
@section('content')
@include('layouts.gentelella.table_top')
<thead>
    <tr>
        <th>No</th>
        <th>Nama Produk </th>
        <th>Action</th>
    </tr>
</thead>
<tbody>
    @foreach ($nama_produks as $nama_produk)
    <tr>
        <th scope='row'>{{$loop->iteration}}</th>
        <td>{{$nama_produk->nama_produk}}</td>
        <td>
            <a href="{{ url('/nama_produks/')}}/{{$nama_produk->id}}/edit" class='btn btn-primary btn-sm'><i class="fa fa-edit"></i></a>
            <a href="{{ url('/nama_produks/')}}/delete/{{$nama_produk->id}}" onclick="return confirm('Are you sure?')" class='btn btn-danger btn-sm'><i class="fa fa-trash-o"></i></a>
        </td>
    </tr>
    @endforeach
</tbody>
@include('layouts.gentelella.table_bottom')
@endsection('content')
