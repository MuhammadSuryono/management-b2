@extends('maingentelellatable')
@section('title', 'Daftar Keahlian : ' . $keahlian->count())
@section('content')
@include('layouts.gentelella.table_top')
<thead>
    <tr>
        <th>No</th>
        <th>Keahlian</th>
        <th>Action</th>
    </tr>
</thead>
<tbody>
    @foreach ($keahlian as $item)
    <tr>
        <th scope='row'>{{$loop->iteration}}</th>
        <td>{{$item->keahlian}}</td>
        <td>
            <a title="teamnya" href="{{ url('/keahlian_teams/')}}/{{$item->id}}" class='btn btn-secondary btn-sm'><i class="fa fa-users"></i></a>
            -
            <a href="{{ url('/keahlian/')}}/{{$item->id}}/edit" class='btn btn-primary btn-sm'><i class="fa fa-edit"></i></a>
            <a href="{{ url('/keahlian/')}}/delete/{{$item->id}}" onclick="return confirm('Are you sure?')" class='btn btn-danger btn-sm'><i class="fa fa-trash-o"></i></a>
        </td>
    </tr>
    @endforeach
</tbody>
@include('layouts.gentelella.table_bottom')
@endsection('content')