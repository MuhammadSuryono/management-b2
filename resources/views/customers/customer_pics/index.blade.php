@extends('maingentelellatable')
@section('title', 'Daftar Contact Perusahaan : ' . $customer_pics->count())
@section('content')
@include('layouts.gentelella.table_top')
<thead>
    <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Perusahaan</th>
        <th>Action</th>
    </tr>
</thead>
<tbody>
    @foreach ($customer_pics as $customer_pic)
    <tr>
        <th scope='row'>{{$loop->iteration}}</th>
        <td>{{$customer_pic->nama}}</td>
        <td>
            @if(isset($customer_pic->customer->nama))
                {{$customer_pic->customer->nama}}
            @endif
        </td>
        <td>
            <a href="{{ url('/customer_pics/')}}/{{$customer_pic->id}}/edit" class='btn btn-primary btn-sm'><i class="fa fa-edit"></i></a>
            <a href="{{ url('/customer_pics/')}}/delete/{{$customer_pic->id}}" onclick="return confirm('Are you sure?')" class='btn btn-danger btn-sm'><i class="fa fa-trash-o"></i></a>
        </td>
    </tr>
    @endforeach
</tbody>
@include('layouts.gentelella.table_bottom')
@endsection('content')
