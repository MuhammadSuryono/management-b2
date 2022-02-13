@extends('maingentelellatable')
@section('title', 'Absensi')
{{-- @section('title2', 'Proyek ' . $project_kegiatan->project_plan->project->nama  . ' -- ' . $project_kegiatan->project_plan->task->task) --}}
@section('content')
@include('layouts.gentelella.table_top')
<thead>
    <tr>
        <th>No</th>
        <th>User</th>
        <th>Kegiatan</th>
        <th>Waktu Scan </th>
        <th>Action</th>
    </tr>
</thead>
<tbody>
    @foreach ($project_absensis as $item)
    <tr>
        <th scope='row'>{{$loop->iteration}}</th>
        <td>{{ $item->user->user_login }}</td>
        <td>{{ $item->project_kegiatan->project_plan->task->task }} </td>
        <td>{{ $item->created_at }} </td>
        <td>
            <a href="{{ url('/project_absensis/')}}/{{$item->id}}/edit" class='btn btn-primary btn-sm'><i class="fa fa-edit"></i></a>
            <a href="{{ url('/project_absensis/')}}/delete/{{$item->id}}" onclick="return confirm('Are you sure?')" class='btn btn-danger btn-sm'><i class="fa fa-trash-o"></i></a>
        </td>
    </tr>
    @endforeach
</tbody>
@include('layouts.gentelella.table_bottom')
@endsection('content')