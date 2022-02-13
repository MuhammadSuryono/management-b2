@extends('maingentelellatable')
@section('title', 'Ses B : ' . $ses_bs->count())
@section('content')
@include('layouts.gentelella.table_top')
<thead>
    <tr>
        <th>No</th>
        <th>Ses B</th>
    </tr>
</thead>
<tbody>
    @foreach ($ses_bs as $item)
    <tr>
        <th scope='row'>{{$loop->iteration}}</th>
        <td>{{$item->ses_b}}</td>
    </tr>
    @endforeach
</tbody>
@include('layouts.gentelella.table_bottom')
@endsection('content')
