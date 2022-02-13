@extends('maingentelellatable')
@section('title', 'Status Validasi : ' . $is_valids->count())
@section('content')
@include('layouts.gentelella.table_top')
<thead>
    <tr>
        <th>No</th>
        <th>Status Validasi</th>
    </tr>
</thead>
<tbody>
    @foreach ($is_valids as $item)
    <tr>
        <th scope='row'>{{$loop->iteration}}</th>
        <td>{{$item->is_valid}}</td>
    </tr>
    @endforeach
</tbody>
@include('layouts.gentelella.table_bottom')
@endsection('content')
