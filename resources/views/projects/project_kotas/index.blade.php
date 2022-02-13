@extends('maingentelellatable')
@section('title', 'Daftar Kota '  ) 
@section('title2', 'Proyek ' .$project -> nama)
@section('content')
@include('layouts.gentelella.table_top')
<thead>
    <tr>
        <th>No</th>
        <th>Kota</th>
        <th>Jumlah</th>
        <th>Action</th>
    </tr>
</thead>
<tbody>
    @foreach ($project_kotas as $project_kota)
    <tr>
        <th scope='row'>{{$loop->iteration}}</th>
        <td>
            @if(isset($project_kota->kota->kota))
                {{$project_kota->kota->kota}}
            @endif
        </td>
        <td>{{$project_kota->jumlah}}</td>
        <td>
            <a title="Atur team" href="{{ url('/project_jabatans/')}}/{{$project_kota->id}}" class='btn btn-secondary btn-sm'><i class="fa fa-gavel"></i></a>
            -
            <a title="edit" href="{{ url('/project_kotas/')}}/{{$project_kota->id}}/edit" class='btn btn-primary btn-sm'><i class="fa fa-edit"></i></a>
            <a title="delete" href="{{ url('/project_kotas/')}}/delete/{{$project_kota->id}}" onclick="return confirm('Hapus kota {{$project_kota->kota->kota}} beserta seluruh teamnya?')" class='btn btn-danger btn-sm'><i class="fa fa-trash-o"></i></a>
        </td>
    </tr>
    @endforeach
</tbody>
@include('layouts.gentelella.table_bottom')
@endsection('content')
