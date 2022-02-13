@extends('maingentelellatable')
@section('title', 'Daftar Peranan ')
@section('content')
@include('layouts.gentelella.table_top')
<thead>
    <tr>
        <th>No</th>
        <th>Jabatan</th>
        <th>Action</th>
    </tr>
</thead>
<tbody>
    @foreach ($jabatans as $item)
    <tr>
        <th scope='row'>{{$loop->iteration}}</th>
        <td>{{$item->jabatan}}</td>
        <td>
            <a title="teamnya" href="{{ url('/jabatan_teams/')}}/{{$item->id}}" class='btn btn-secondary btn-sm'><i class="fa fa-users"></i></a>
            -
            <a href="{{ url('/jabatans/')}}/{{$item->id}}/edit" class='btn btn-primary btn-sm'><i class="fa fa-edit"></i></a>
            <a href="{{ url('/jabatans/')}}/delete/{{$item->id}}" onclick="return confirm('Are you sure?')" class='btn btn-danger btn-sm'><i class="fa fa-trash-o"></i></a>
        </td>
    </tr>
    @endforeach
</tbody>
@include('layouts.gentelella.table_bottom')
@endsection('content')