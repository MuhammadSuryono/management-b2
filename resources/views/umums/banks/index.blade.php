@extends('maingentelellatable')
<?php $total = $bank->count() + $e_wallet->count() ?>
@section('title', 'Daftar Layanan : '. $total )
@section('content')
@include('layouts.gentelella.table_top')
<thead>
    <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Kode</th>
    </tr>
</thead>
<tbody>
    <?php $i = 1; ?>
    @foreach ($e_wallet as $item)
    <tr>
        <th scope='row'>{{$i++}}</th>
        <td>{{$item->nama}}</td>
        <td>{{$item->kode}}</td>
    </tr>
    @endforeach
    @foreach ($bank as $item)
    <tr>
        <th scope='row'>{{$i++}}</th>
        <td>{{$item->nama}}</td>
        <td>{{$item->kode}}</td>
    </tr>
    @endforeach
</tbody>
@include('layouts.gentelella.table_bottom')
@endsection('content')