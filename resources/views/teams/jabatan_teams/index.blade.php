@extends('maingentelellatable')
@section('title', 'Daftar pemegang jabatan' ) 
@section('title2', $jabatan -> jabatan)
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
    @foreach ($jabatan_teams as $jabatan_team)
    <tr>
        <th scope='row'>{{$loop->iteration}}</th>
        <td>
            @if(isset($jabatan_team->team->nama))
                {{$jabatan_team->team->nama}}
            @endif
        </td>
        <td>
            <a href="{{ url('/jabatan_teams/')}}/delete/{{$jabatan_team->id}}" onclick="return confirm('Are you sure?')" class='btn btn-danger btn-sm'><i class="fa fa-trash-o"></i></a>
        </td>
    </tr>
    @endforeach
</tbody>
@include('layouts.gentelella.table_bottom')
@endsection('content')
