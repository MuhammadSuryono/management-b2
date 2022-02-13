@extends('maingentelellatable')
@section('title', 'Daftar '. $project_jabatan->jabatan->jabatan)
@section('title2','Proyek ' . $project_jabatan->project_kota->project->nama . ' - ' . $project_jabatan->project_kota->kota->kota)
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
    @foreach ($project_teams as $project_team)
    <tr>
        <th scope='row'>{{$loop->iteration}}</th>
        <td>
            @if(isset($project_team->team->nama))
            {{$project_team->team->nama}}
            @endif
        </td>
        <td>
            <a href="{{ url('/project_teams/')}}/{{$project_team->id}}/edit" class='btn btn-primary btn-sm'><i class="fa fa-edit"></i></a>
            <a href="{{ url('/project_teams/')}}/delete/{{$project_team->id}}" onclick="return confirm('Are you sure?')" class='btn btn-danger btn-sm'><i class="fa fa-trash-o"></i></a>
        </td>
    </tr>
    @endforeach
</tbody>
@include('layouts.gentelella.table_bottom')
@endsection('content')