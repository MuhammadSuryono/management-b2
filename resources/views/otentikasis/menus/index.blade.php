@extends('maingentelellatable')
@section('title', 'Daftar Menu : ' . $menus->count())
@section('content')
@include('layouts.gentelella.table_top')
<thead>
    <tr>
        <th>No</th>
        <th>Menu</th>
        <th>Action</th>
    </tr>
</thead>
<tbody>
    @foreach ($menus as $item)
    <tr>
        <th scope='row'>{{$loop->iteration}}</th>
        <td>{{$item->menu}}</td>
        <td>
            <a href="{{ url('/menus/')}}/{{$item->id}}/edit" class='btn btn-primary btn-sm'><i class="fa fa-edit"></i></a>
            <a href="{{ url('/menus/')}}/delete/{{$item->id}}" onclick="return confirm('Are you sure?')" class='btn btn-danger btn-sm'><i class="fa fa-trash-o"></i></a>
        </td>
    </tr>
    @endforeach
</tbody>
@include('layouts.gentelella.table_bottom')
@endsection('content')
