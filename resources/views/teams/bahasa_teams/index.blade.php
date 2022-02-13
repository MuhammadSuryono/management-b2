@extends('maingentelellatable')
@section('title', 'Daftar yang menguasai ' ) 
@section('title2', $bahasa -> bahasa)
@section('content')
@include('layouts.gentelella.table_top')
<thead>
    <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Action</th>
    </tr>
</thead>
<tbody>
    @foreach ($bahasa_teams as $bahasa_team)
    <tr>
        <th scope='row'>{{$loop->iteration}}</th>
        <td>
            @if(isset($bahasa_team->team->nama))
                {{$bahasa_team->team->nama}}
            @endif
        </td>
        <td>
            <a href="{{ url('/bahasa_teams/')}}/{{$bahasa_team->id}}/edit" class='btn btn-primary btn-sm'><i class="fa fa-edit"></i></a>
            <a href="{{ url('/bahasa_teams/')}}/delete/{{$bahasa_team->id}}" onclick="return confirm('Are you sure?')" class='btn btn-danger btn-sm'><i class="fa fa-trash-o"></i></a>
        </td>
    </tr>
    @endforeach
</tbody>
@include('layouts.gentelella.table_bottom')
@endsection('content')
