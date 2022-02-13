@extends('maingentelellatable')
@section('title', 'Ses A : ' . $ses_as->count())
@section('content')
@include('layouts.gentelella.table_top')
<thead>
    <tr>
        <th>No</th>
        <th>Ses A</th>
    </tr>
</thead>
<tbody>
    @foreach ($ses_as as $item)
    <tr>
        <th scope='row'>{{$loop->iteration}}</th>
        <td>{{$item->ses_a}}</td>
    </tr>
    @endforeach
</tbody>
@include('layouts.gentelella.table_bottom')
@endsection('content')
