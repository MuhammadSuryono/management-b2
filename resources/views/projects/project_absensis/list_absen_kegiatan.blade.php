@extends('maingentelellatable')
@section('title', 'Absensi')
@section('title2', 'Proyek ' . $project_plan->nama . ' -- ' . $project_plan->nama_kegiatan)
@section('content')
@include('layouts.gentelella.table_top')
<thead>
    <tr>
        <th>No</th>
        <th>User</th>
        <th>Waktu Scan </th>
    </tr>
</thead>
<tbody>
    @foreach ($project_absensis as $item)
    <tr>
        <th scope='row'>{{$loop->iteration}}</th>
        <td>{{ $item->user->user_login }}</td>
        <td>{{ $item->created_at }} </td>
    </tr>
    @endforeach
</tbody>
@include('layouts.gentelella.table_bottom')
@endsection('content')