@extends('maingentelellatable')
@section('title', 'Daftar bahasa asing ' )
@section('title2', $team -> nama)
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
    @foreach ($team_bahasas as $team_bahasa)

    <tr>
        <th scope='row'>{{$loop->iteration}}</th>
        <td>
            @if(isset($team_bahasa->bahasa->bahasa))
            {{$team_bahasa->bahasa->bahasa}}
            @endif
        </td>
        <td>
            {{-- <a href="{{ url('/team_bahasas/')}}/{{$team_bahasa->id}}/edit" class='btn btn-primary btn-sm'><i class="fa fa-edit"></i></a> --}}
            <a href="{{ url('/team_bahasas/')}}/delete/{{$team_bahasa->id}}" onclick="return confirm('Are you sure?')" class='btn btn-danger btn-sm'><i class="fa fa-trash-o"></i></a>
        </td>
    </tr>
    @endforeach
</tbody>
@include('layouts.gentelella.table_bottom')
@endsection('content')