@extends('maingentelellatable')
@section('title', 'Daftar Bahasa : ' . $bahasas->count())
@section('content')
@include('layouts.gentelella.table_top')
<thead>
    <tr>
        <th>No</th>
        <th>Bahasa</th>
        <th>Action</th>
    </tr>
</thead>
<tbody>
    @foreach ($bahasas as $item)
    <tr>
        <th scope='row'>{{$loop->iteration}}</th>
        <td>{{$item->bahasa}}</td>
        <td>
            <a title="teamnya" href="{{ url('/bahasa_teams/')}}/{{$item->id}}" class='btn btn-secondary btn-sm'><i class="fa fa-users"></i></a>
            -
            <a href="{{ url('/bahasas/')}}/{{$item->id}}/edit" class='btn btn-primary btn-sm'><i class="fa fa-edit"></i></a>
            <a href="{{ url('/bahasas/')}}/delete/{{$item->id}}" onclick="return confirm('Are you sure?')" class='btn btn-danger btn-sm'><i class="fa fa-trash-o"></i></a>
        </td>
    </tr>
    @endforeach
</tbody>
@include('layouts.gentelella.table_bottom')
@endsection('content')