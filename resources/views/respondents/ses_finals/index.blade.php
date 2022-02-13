@extends('maingentelellatable')
@section('title', 'Ses Final : ' . $ses_finals->count())
@section('content')
@include('layouts.gentelella.table_top')
<thead>
    <tr>
        <th>No</th>
        <th>Ses Final</th>
    </tr>
</thead>
<tbody>
    @foreach ($ses_finals as $item)
    <tr>
        <th scope='row'>{{$loop->iteration}}</th>
        <td>{{$item->ses_final}}</td>
    </tr>
    @endforeach
</tbody>
@include('layouts.gentelella.table_bottom')
@endsection('content')
