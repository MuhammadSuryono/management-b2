@extends('maingentelellatable')
@section('title', 'Data Form QC : ' . $respondent->count())
@section('content')
@include('layouts.gentelella.table_top')
<thead>
    <tr>
        <th>No</th>
        <th>Nama Respondent</th>
        <th>Kode</th>
        <th>Jawaban</th>
    </tr>
</thead>
<tbody>
    @foreach ($respondent as $item)
    <tr>
        <th scope='row'>{{$loop->iteration}}</th>
        <td>{{$item->respname}}</td>
        <td>{{$item->answer_code}}</td>
        <td>{{$item->answer}}</td>
    </tr>
    @endforeach
</tbody>
@include('layouts.gentelella.table_bottom')
@endsection('content')

@section('javascript')
<script>
    $(document).ready(function() {
        $('.card-box.table-responsive a.btn-block').hide();
    });
</script>
@endsection