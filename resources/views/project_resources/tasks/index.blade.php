@extends('maingentelellatable')
@section('title', 'Task : ' . $tasks->count())
@section('content')
@include('layouts.gentelella.table_top')
<thead>
    <tr>
        <th>Urutan</th>
        <th>Task</th>
        <th>Absensi?</th>
        <th>Action</th>
    </tr>
</thead>
<tbody>
    @foreach ($tasks as $item)
    <tr>
        <th scope='row'>{{$loop->iteration}}</th>
        <td>{{$item->nama_kegiatan}}</td>
        <td>{{ $item->has_presence ? "Ya" : "Tidak" }} </td>
        <td>
            <a title="edit" href="{{ url('/tasks/')}}/{{$item->id_pp_master}}/edit" class='btn btn-primary btn-sm'><i class="fa fa-edit"></i></a>
            <a title="delete" href="{{ url('/tasks/')}}/delete/{{$item->id_pp_master}}" onclick="return confirm('Hapus?')" class='btn btn-danger btn-sm'><i class="fa fa-trash-o"></i></a>
        </td>
    </tr>
    @endforeach
</tbody>
@include('layouts.gentelella.table_bottom')
@endsection('content')