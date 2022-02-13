@extends('maingentelellatable')
@section('title', 'Daftar Keahlian ' )
@section('title2', $team -> nama)
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
    @foreach ($team_keahlian as $tk)
    <tr>
        <th scope='row'>{{$loop->iteration}}</th>
        <td>
            @if(isset($tk->keahlian->keahlian))
            {{$tk->keahlian->keahlian}}
            @endif
        </td>
        <td>
            {{-- <a href="{{ url('/team_keahlian/')}}/{{$tk->id}}/edit" class='btn btn-primary btn-sm'><i class="fa fa-edit"></i></a> --}}
            <a href="{{ url('/team_keahlian/')}}/delete/{{$tk->id}}" onclick="return confirm('Are you sure?')" class='btn btn-danger btn-sm'><i class="fa fa-trash-o"></i></a>
        </td>
    </tr>
    @endforeach
</tbody>
@include('layouts.gentelella.table_bottom')
@endsection('content')