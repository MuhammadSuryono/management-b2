@extends('maingentelellatable')
@section('title', 'Role Untuk User : ' . session('current_role_user_login'))
@section('content')
@include('layouts.gentelella.table_top')
<thead>
    <tr>
        <th>No </th>
        <th>Role</th>
        <th>Action</th>
    </tr>
</thead>
<tbody>
    @foreach ($user_roles as $item)
    <tr>
        <th scope='row'>{{$loop->iteration}}</th>
        <td>{{$item->role->role}}</td>
        <td>
            <a href="{{ url('/user_roles/')}}/delete/{{$item->id}}" onclick="return confirm('Are you sure?')" class='btn btn-danger btn-sm'><i class="fa fa-trash-o"></i></a>
        </td>
    </tr>
    @endforeach
</tbody>
@include('layouts.gentelella.table_bottom')
@endsection('content')
