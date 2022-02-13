@extends('maingentelellatable')
@section('title', 'Menu Untuk Role : ' . session('current_menu_role'))
@section('content')
@include('layouts.gentelella.table_top')
<thead>
    <tr>
        <th>No </th>
        <th>Menu</th>
        <th>Action</th>
    </tr>
</thead>
<tbody>
    @foreach ($role_menus as $item)
    <tr>
        <th scope='row'>{{$loop->iteration}}</th>
        <td>{{$item->menu->menu}}</td>
        <td>
            <a href="{{ url('/role_menus/')}}/delete/{{$item->id}}" onclick="return confirm('Are you sure?')" class='btn btn-danger btn-sm'><i class="fa fa-trash-o"></i></a>
        </td>
    </tr>
    @endforeach
</tbody>
@include('layouts.gentelella.table_bottom')
@endsection('content')
