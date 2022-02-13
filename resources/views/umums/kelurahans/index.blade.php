@extends('maingentelellatable')
@section('title', 'Kota : ' . $kelurahans->count())
@section('content')
@include('layouts.gentelella.table_top')
<thead>
    <tr>
        <th>No</th>
        <th>ID Kelurahan</th>
        <th>Kota</th>
        <th>Kelurahan</th>
        <th>Action</th>
    </tr>
</thead>
<tbody>
    @foreach ($kelurahans as $item)
    <tr>
        <th scope='row'>{{$loop->iteration}}</th>
        <td>{{ $item->id }}</td>
        <td>{{ $item->kota->kota }}</td>
        <td>{{$item->kelurahan}}</td>
        <td>
            <a href="{{ url('/kelurahans/')}}/{{$item->id}}/edit" class='btn btn-primary btn-sm'><i class="fa fa-edit"></i></a>
            <a href="{{ url('/kelurahans/')}}/delete/{{$item->id}}" onclick="return confirm('Are you sure?')" class='btn btn-danger btn-sm'><i class="fa fa-trash-o"></i></a>
        </td>
    </tr>
    @endforeach
</tbody>
@include('layouts.gentelella.table_bottom')
@endsection('content')