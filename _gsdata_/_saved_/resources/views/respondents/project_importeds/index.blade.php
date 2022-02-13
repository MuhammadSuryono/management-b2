@extends('maingentelellatable')
@section('title', 'Project : ' . $project_importeds->count())
@section('content')
@include('layouts.gentelella.table_top')
<thead>
    <tr>
        <th>No</th>
        <th>Project</th>
    </tr>
</thead>
<tbody>
    @foreach ($project_importeds as $item)
        <th scope='row'>{{$loop->iteration}}</th>
        <td>{{$item->project_imported}}</td>
    @endforeach
</tbody>
@include('layouts.gentelella.table_bottom')
@endsection('content')
