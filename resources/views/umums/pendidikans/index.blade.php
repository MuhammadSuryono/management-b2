@extends('maingentelellatable')
@section('title', 'Daftar pendidikan : ' . $pendidikans->count())
@section('content')
@include('layouts.gentelella.table_top')
<thead>
    <tr>
        <th>No</th>
        <th>Pendidikan</th>
        <th>Action</th>
    </tr>
</thead>
<tbody>
    @foreach ($pendidikans as $item)
    <tr>
        <th scope='row'>{{$loop->iteration}}</th>
        <td>{{$item->pendidikan}}</td>
        <td>
            @if($item->id > $tot_pendidikan_responden)
                <a href="{{ url('/pendidikans/')}}/{{$item->id}}/edit" class='btn btn-primary btn-sm'><i class="fa fa-edit"></i></a>
                <a href="{{ url('/pendidikans/')}}/delete/{{$item->id}}" onclick="return confirm('Are you sure?')" class='btn btn-danger btn-sm'><i class="fa fa-trash-o"></i></a>
            @endif
        </td>
    </tr>
    @endforeach
</tbody>
@include('layouts.gentelella.table_bottom')
@endsection('content')
