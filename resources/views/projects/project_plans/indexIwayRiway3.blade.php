@extends('maingentelellatable')
@section('title', 'Plan Project '.session('current_project_nama')  ) 
@section('content')
@include('layouts.gentelella.table_top')
<thead>
    <tr>
        <th>No</th>
        <th>Tasks</th>
        <th>N</th>
        <th>Tgl Mulai</th>
        <th>Tgl Selesai</th>
        <th>Info</th>
        <th>Action</th>
    </tr>
</thead>
<tbody>
    @foreach ($project_plans as $item)
    <tr>
        {{-- <th scope='row'>{{$item->urutan}}</th> --}}
        <th scope='row'>{{$loop->iteration}}</th>
        <td>
            @if(isset($item->task->task))
                {{$item->task->task}}
            @endif
        </td>
        <td>{{$item->n_target}}</td>
        <td>{{ $item->date_start_target }} </td>
        <td>{{ $item->date_finish_target }} </td>
        <td>{{ $item->ket }} </td>
        <td>
            <a title="edit" href="{{ url('/project_plans/')}}/{{$item->id}}/edit2" class='btn btn-primary btn-sm'><i class="fa fa-edit"></i></a>
            <a title="delete" href="{{ url('/project_plans/')}}/delete2/{{$item->id}}" onclick="return confirm('Hapus?')" class='btn btn-danger btn-sm'><i class="fa fa-trash-o"></i></a>
            @if($item->task->has_absensi_id == 1)
                <a title="Prepare Absensi" href="{{ url('/project_plans/prepare_absensi')}}/{{$item->id}}" target="_blank" class='btn btn-info btn-sm'><i class="fa fa-qrcode"></i></a>
            @endif
        </td>
    </tr>
    @endforeach
</tbody>
@include('layouts.gentelella.table_bottom')
@endsection('content')
