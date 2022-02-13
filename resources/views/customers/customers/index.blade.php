@extends('maingentelellatable')
@section('title', 'Daftar Perusahaan : ' . $customers->count())
@section('content')
@include('layouts.gentelella.table_top')
<thead>
    <tr>
        <th>No</th>
        <th>Perusahaan</th>
        <th>Kota</th>
        <th>Action</th>
    </tr>
</thead>
<tbody>
    @foreach ($customers as $customer)
    <tr>
        <th scope='row'>{{$loop->iteration}}</th>
        <td>{{$customer->nama}}</td>
        <td>
            @if(isset($customer->kota->kota))
                {{$customer->kota->kota}}
            @endif
            </td>
        <td>
            <a href="{{ url('/customers/')}}/{{$customer->id}}/edit" class='btn btn-primary btn-sm'><i class="fa fa-edit"></i></a>
            <a href="{{ url('/customers/')}}/delete/{{$customer->id}}" onclick="return confirm('Are you sure?')" class='btn btn-danger btn-sm'><i class="fa fa-trash-o"></i></a>
        </td>
    </tr>
    @endforeach
</tbody>
@include('layouts.gentelella.table_bottom')
@endsection('content')
