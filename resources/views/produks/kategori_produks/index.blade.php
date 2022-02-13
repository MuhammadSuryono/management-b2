@extends('maingentelellatable')
@section('title', 'Daftar Kategori Produk (Level 1) : ' . $kategori_produks->count())
@section('content')
@include('layouts.gentelella.table_top')
<thead>
    <tr>
        <th>No</th>
        <th>Kategori</th>
        <th>Action</th>
    </tr>
</thead>
<tbody>
    @foreach ($kategori_produks as $kategori_produk)
    <tr>
        <th scope='row'>{{$loop->iteration}}</th>
        <td>{{$kategori_produk->kategori_produk}}</td>
        <td>
            <a href="{{ url('/kategori_produks/')}}/{{$kategori_produk->id}}/edit" class='btn btn-primary btn-sm'><i class="fa fa-edit"></i></a>
            <a href="{{ url('/kategori_produks/')}}/delete/{{$kategori_produk->id}}" onclick="return confirm('Are you sure?')" class='btn btn-danger btn-sm'><i class="fa fa-trash-o"></i></a>
            <a href="{{ url('/tipe_produks/')}}/{{$kategori_produk->id}}" class='btn btn-info btn-sm'><i class="fa fa-angle-double-right"></i></a>
        </td>
    </tr>
    @endforeach
</tbody>
@include('layouts.gentelella.table_bottom')
@endsection('content')
