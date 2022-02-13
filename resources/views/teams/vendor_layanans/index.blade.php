@extends('maingentelellatable')
@section('title', 'Daftar Kategori Layanan untuk ')
@section('title2', $vendor->nama_perusahaan)
@section('content')
@include('layouts.gentelella.table_top')
<thead>
    <tr>
        <th>No</th>
        <th>Layanan</th>
        <th>Action</th>
    </tr>
</thead>
<tbody>
    @foreach ($vendor_layanan as $vl)
    <tr>
        <th scope='row'>{{$loop->iteration}}</th>
        <td>
            @if(isset($vl->layanan->layanan))
            {{$vl->layanan->layanan}}
            @endif
        </td>
        <td>
            <a href="{{ url('/vendor_layanan/')}}/delete/{{$vl->id}}" onclick="return confirm('Are you sure?')" class='btn btn-danger btn-sm'><i class="fa fa-trash-o"></i></a>
        </td>
    </tr>
    @endforeach
</tbody>
@include('layouts.gentelella.table_bottom')
@endsection('content')