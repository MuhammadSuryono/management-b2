@extends('maingentelellatable')
@section('title', 'Tipe Produk (Level 2): ' . $tipe_produks->count())
@section('title2', $kategori_produk->kategori_produk)
@section('content')
@include('layouts.gentelella.table_top')
<thead>
    <tr>
        <th>No</th>
        <th>Tipe Produk </th>
        <th>Action</th>
    </tr>
</thead>
<tbody>
    @foreach ($tipe_produks as $tipe_produk)
    <tr>
        <th scope='row'>{{$loop->iteration}}</th>
        <td>{{$tipe_produk->tipe_produk}}</td>
        <td>
            <a href="{{ url('/tipe_produks/')}}/{{$tipe_produk->id}}/edit" class='btn btn-primary btn-sm'><i class="fa fa-edit"></i></a>
            <a href="{{ url('/tipe_produks/')}}/delete/{{$tipe_produk->id}}" onclick="return confirm('Are you sure?')" class='btn btn-danger btn-sm'><i class="fa fa-trash-o"></i></a>
            <a href="{{ url('/nama_produks/')}}/{{$tipe_produk->id}}" class='btn btn-info btn-sm'><i class="fa fa-angle-double-right"></i></a>
        </td>
    </tr>
    @endforeach
</tbody>
@include('layouts.gentelella.table_bottom')
@endsection('content')
