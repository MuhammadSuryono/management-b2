@extends('maingentelellatable')
@section('title', 'Daftar Role Asing : ' . $roles->count())
@section('content')
@include('layouts.gentelella.table_top')
<thead>
    <tr>
        <th>No</th>
        <th>Role</th>
        <th>Action</th>
    </tr>
</thead>
<tbody>
    @foreach ($roles as $item)
    <tr>
        <th scope='row'>{{$loop->iteration}}</th>
        <td>{{$item->role}}</td>
        <td>
            <a href="{{ url('/roles/')}}/{{$item->id}}/edit" class='btn btn-primary btn-sm'><i class="fa fa-edit"></i></a>
            <a href="{{ url('/roles/')}}/delete/{{$item->id}}" onclick="return confirm('Are you sure?')" class='btn btn-danger btn-sm'><i class="fa fa-trash-o"></i></a>
        </td>
    </tr>
    @endforeach
</tbody>
@include('layouts.gentelella.table_bottom')
@endsection('content')
