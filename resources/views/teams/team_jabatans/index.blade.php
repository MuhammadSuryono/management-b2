@extends('maingentelellatable')
@section('title', 'Daftar Peranan untuk ')
@section('title2', $team -> nama)
@section('content')
@include('layouts.gentelella.table_top')
<thead>
    <tr>
        <th>No</th>
        <th>Jabatan</th>
        <th>Action</th>
    </tr>
</thead>
<tbody>
    @foreach ($team_jabatans as $team_jabatan)
    <tr>
        <th scope='row'>{{$loop->iteration}}</th>
        <td>
            @if(isset($team_jabatan->jabatan->jabatan))
            {{$team_jabatan->jabatan->jabatan}}
            @endif
        </td>
        <td>
            <a href="{{ url('/team_jabatans/')}}/delete/{{$team_jabatan->id}}" onclick="return confirm('Are you sure?')" class='btn btn-danger btn-sm'><i class="fa fa-trash-o"></i></a>
        </td>
    </tr>
    @endforeach
</tbody>
@include('layouts.gentelella.table_bottom')
@endsection('content')