@extends('maingentelellatable')
@section('title', 'Daftar Jenis Jabatan')
@section('title2', 'Proyek ' . $project_kota->project->nama  . ' - ' . $project_kota->kota->kota)
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
    @foreach ($project_jabatans as $project_jabatan)
    <tr>
        <th scope='row'>{{$loop->iteration}}</th>
        <td>
            @if(isset($project_jabatan->jabatan->jabatan))
                {{$project_jabatan->jabatan->jabatan}}
            @endif
        </td>
        <td>
            <a title="Atur anggota team" href="{{ url('/project_teams/')}}/{{$project_jabatan->id}}" class='btn btn-secondary btn-sm'><i class="fa fa-gavel"></i></a>
            -
            <a href="{{ url('/project_jabatans/')}}/{{$project_jabatan->id}}/edit" class='btn btn-primary btn-sm'><i class="fa fa-edit"></i></a>
            <a href="{{ url('/project_jabatans/')}}/delete/{{$project_jabatan->id}}" onclick="return confirm('Are you sure?')" class='btn btn-danger btn-sm'><i class="fa fa-trash-o"></i></a>
        </td>
    </tr>
    @endforeach
</tbody>
@include('layouts.gentelella.table_bottom')
@endsection('content')
