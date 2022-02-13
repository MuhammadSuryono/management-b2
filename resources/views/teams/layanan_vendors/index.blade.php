@extends('maingentelellatable')
@section('title', 'Daftar pemegang jabatan' )
@section('title2', $layanan -> layanan)
@section('content')
@include('layouts.gentelella.table_top')
<thead>
    <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Action</th>
    </tr>
</thead>
<tbody>
    @foreach ($layanan_vendors as $layanan_vendor)
    <tr>
        <th scope='row'>{{$loop->iteration}}</th>
        <td>
            @if(isset($layanan_vendor->vendor->nama_perusahaan))
            {{$layanan_vendor->vendor->nama_perusahaan}}
            @endif
        </td>
        <td>
            <a href="{{ url('/layanan_vendors/')}}/{{$layanan_vendor->id}}/edit" class='btn btn-primary btn-sm'><i class="fa fa-edit"></i></a>
            <a href="{{ url('/layanan_vendors')}}/delete/{{$layanan_vendor->id}}" onclick="return confirm('Are you sure?')" class='btn btn-danger btn-sm'><i class="fa fa-trash-o"></i></a>
        </td>
    </tr>
    @endforeach
</tbody>
@include('layouts.gentelella.table_bottom')
@endsection('content')