@extends('maingentelellatable')
@section('title', 'Lokasi : ' . $lokasis->count())
@section('content')
@include('layouts.gentelella.table_top')
<thead>
    <tr>
        <th>No</th>
        <th>Lokasi</th>
        <th>Action</th>
    </tr>
</thead>
<tbody>
    @foreach ($lokasis as $item)
    <tr>
        <th scope='row'>{{$loop->iteration}}</th>
        <td>{{$item->lokasi}}</td>
        <td>
            <a href="{{ url('/lokasis/')}}/{{$item->id}}/edit" class='btn btn-primary btn-sm'><i class="fa fa-edit"></i></a>
            <a href="{{ url('/lokasis/')}}/delete/{{$item->id}}" onclick="return confirm('Are you sure?')" class='btn btn-danger btn-sm'><i class="fa fa-trash-o"></i></a>
        </td>
    </tr>
    @endforeach
</tbody>
@include('layouts.gentelella.table_bottom')
@endsection('content')
