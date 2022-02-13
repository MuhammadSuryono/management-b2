@extends('maingentelellatable')
@section('title', 'Pekerjaan : ' . $pekerjaans->count())
@section('content')
@include('layouts.gentelella.table_top')
<thead>
    <tr>
        <th>No</th>
        <th>Pekerjaan</th>
        <th>Action</th>
    </tr>
</thead>
<tbody>
    @foreach ($pekerjaans as $item)
    <tr>
        <th scope='row'>{{$loop->iteration}}</th>
        <td>{{$item->pekerjaan}}</td>
        <td>
            @if($item->id > $tot_pekerjaan_responden)
                <a href="{{ url('/pekerjaans/')}}/{{$item->id}}/edit" class='btn btn-primary btn-sm'><i class="fa fa-edit"></i></a>
                <a href="{{ url('/pekerjaans/')}}/delete/{{$item->id}}" onclick="return confirm('Are you sure?')" class='btn btn-danger btn-sm'><i class="fa fa-trash-o"></i></a>
            @endif
        </td>
    </tr>
    @endforeach
</tbody>
@include('layouts.gentelella.table_bottom')
@endsection('content')
