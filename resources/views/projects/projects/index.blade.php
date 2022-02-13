@extends('maingentelellatable')
@section('title', 'Daftar Project : ' . $projects->count())
@section('content')
@include('layouts.gentelella.table_top')

{{-- IWAYRIWAY --}}
<thead>
    <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Kode</th>
        <th>Nomor</th>
        <th>Customer</th>
        <th>Methodology</th>
        <th>Deal</th>
        <th>Kick Off</th>
        <th>Akhir Kontrak</th>
        <th>Approve Kuesioner</th>
        <th>Action</th>
    </tr>
</thead>
<tbody>
    @foreach ($projects as $project)
    <tr>
        <th scope='row'>{{$loop->iteration}}</th>
        <td>{{$project->nama}}</td>
        <td>{{$project->kode_project}}</td>
        <td>{{$project->nomor_rfq}}</td>
        <td>{{$project->nama_customer}}</td>
        <td>{{$project->methodology}}</td>
        <td>{{$project->tgl_deal}}</td>
        <td>{{$project->tgl_kickoff}}</td>
        <td>{{$project->tgl_akhir_kontrak}}</td>
        <td>{{$project->tgl_approve_kuesioner}}</td>
        <td>
            <a title="edit" href="{{ url('/projects/')}}/{{$project->id}}/edit" class='btn btn-primary btn-sm'><i class="fa fa-edit"></i></a>
            {{-- <a title="delete" href="{{ url('/projects/')}}/delete/{{$project->id}}" onclick="return confirm('Are you sure?')" class='btn btn-danger btn-sm'><i class="fa fa-trash-o"></i></a> --}}
            <button title="delete" href="{{ url('/projects/')}}/delete/{{$project->id}}" class='btn btn-danger btn-sm tombol-hapus' disabled><i class="fa fa-trash-o"></i></button>
        </td>
    </tr>
    @endforeach
</tbody>
{{-- AKHIR IWAYRIWAY --}}

{{-- PAK BUDI --}}
{{-- <thead>
    <tr>
        <th>No</th>
        <th>Project</th>
        <th>Customer</th>
        <th>Tgl</th>
        <th>Plan Start</th>
        <th>Plan Finish</th>
        <th>Action</th>
    </tr>
</thead>
<tbody>
    @foreach ($projects as $project)
    <tr>
        <th scope='row'>{{$loop->iteration}}</th>
<td>{{$project->nama}}</td>
<td>
    @if(isset($project->customer2->nama))
    {{$project->customer2->nama}}
    @endif
</td>
<td>{{$project->project_date}}</td>
<td>{{$project->date_start_target}}</td>
<td>{{$project->date_finish_target}}</td>
<td>
    <a title="edit" href="{{ url('/projects/')}}/{{$project->id}}/edit" class='btn btn-primary btn-sm'><i class="fa fa-edit"></i></a>
    <a title="delete" href="{{ url('/projects/')}}/delete/{{$project->id}}" onclick="return confirm('Are you sure?')" class='btn btn-danger btn-sm'><i class="fa fa-trash-o"></i></a>
</td>
</tr>
@endforeach
</tbody> --}}
{{-- AKHIR PAK BUDI --}}

@include('layouts.gentelella.table_bottom')
@endsection('content')