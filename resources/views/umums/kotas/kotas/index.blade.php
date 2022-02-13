@extends('maingentelellatable')
@section('title', 'Kota : ' . $kotas->count())
@section('content')
@include('layouts.gentelella.table_top')
<thead>
    <tr>
        <th>No</th>
        <th>ID Kota</th>
        <th>Kota</th>
        <th>Action</th>
    </tr>
</thead>
<tbody>
    @foreach ($kotas as $item)
    <tr>
        <th scope='row'>{{$loop->iteration}}</th>
        <td>{{ $item->id }}</td>
        <td>{{$item->kota}}</td>
        <td>
            @if($item->id > $tot_kota_responden)
                <a href="{{ url('/kotas/')}}/{{$item->id}}/edit" class='btn btn-primary btn-sm'><i class="fa fa-edit"></i></a>
                <a href="{{ url('/kotas/')}}/delete/{{$item->id}}" onclick="return confirm('Are you sure?')" class='btn btn-danger btn-sm'><i class="fa fa-trash-o"></i></a>
            @endif
        </td>
    </tr>
    @endforeach
</tbody>
@include('layouts.gentelella.table_bottom')
@endsection('content')
