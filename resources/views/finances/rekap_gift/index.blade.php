@extends('maingentelellatable')
@section('title', 'Daftar Project : '. count($projects) )
@section('content')

@include('layouts/gentelella/table_top')
<thead>
    <tr>
        <th>No</th>
        <th>Nama Project</th>
        <th>Total</th>
        <th>Total Sudah Digunakan</th>
        <th>Total Belum Digunakan</th>
    </tr>
</thead>
<tbody>
    @foreach($arr_project as $key => $item)

    <tr>
        <th scope='row'>{{$loop->iteration}}</th>
        <td>{{$item['nama_project']}}</td>
        <td>Rp. <?= number_format($item['total']) ?></td>
        <td>Rp. <?= number_format($item['total_dipakai']) ?></td>
        <td>Rp. <?= number_format($item['total_belum_dipakai']) ?></td>
    </tr>
    @endforeach
</tbody>
@include('layouts.gentelella.table_bottom')
@endsection('content')