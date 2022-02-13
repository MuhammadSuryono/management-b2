@extends('maingentelellatable')
@section('title', 'User : ' . $users->count())
@section('content')
@include('layouts.gentelella.table_top')
<thead>
    <tr>
        <th>No</th>
        <th>User</th>
        <th>Email</th>
        <th>Level</th>
        <th>Action</th>
    </tr>
</thead>
<tbody>
    @foreach ($users as $item)
    <tr>
        <th scope='row'>{{$loop->iteration}}</th>
        <td>{{$item->user_login}}</td>
        <td>{{$item->email}}</td>
        <td>{{$item->level}}</td>
        <td>
                <a href="{{ url('/users/')}}/{{$item->id}}/edit" class='btn btn-primary btn-sm'><i class="fa fa-edit"></i></a>
                <a href="{{ url('/users/')}}/delete/{{$item->id}}" onclick="return confirm('Are you sure?')" class='btn btn-danger btn-sm'><i class="fa fa-trash-o"></i></a>
        </td>
    </tr>
    @endforeach
</tbody>
@include('layouts.gentelella.table_bottom')
@endsection('content')
