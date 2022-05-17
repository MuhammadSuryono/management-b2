@extends('maingentelellatable')
@section('title', 'Daftar profile : ' . $teams->count())
@section('content')
@include('layouts.gentelella.table_top')
<thead>
    <tr>
        <th>No</th>
        <th>ID</th>
        <th>Nama</th>
        <th>Gender</th>
        <th>Usia</th>
        <th>Kota</th>
        <th>Peranan</th>
        <th>Tanggal Register</th>
        <th>Action</th>
    </tr>
</thead>
<tbody>
    @foreach ($teams as $item)
    <tr>
        <th scope='row'>{{$loop->iteration}}</th>
        <td>{{ str_pad($item->kota_id, 3, '0', STR_PAD_LEFT) . '.' .  str_pad($item->no_team, 4, '0', STR_PAD_LEFT) }} </td>
        <td>{{$item->nama}}</td>
        <td>@if(isset($item->gender->gender))
            {{$item->gender->gender}}
            @endif
        </td>
        <td>{{ date_diff(date_create($item->tgl_lahir), date_create(date("Y-m-d")))->format('%y') }}</td>
        <td>@if(isset($item->kota->kota))
            {{$item->kota->kota}}
            @endif
        </td>
        <td>
            <?php
            $i = 0;
            $result = '';
            ?>
            @foreach($jabatan_teams as $jt)
            @if($jt->team_id == $item->id)
            <?php $result .= ($jt->jabatan . ', ') ?>
            @endif
            @endforeach
            <?php
            if (substr($result, -2) == ', ') $result = substr($result, 0, -2);
            ?>
            {{$result}}
        </td>
        <td>{{$item->created_at}}</td>
        <td>
            <a title="Bahasa dikuasai" href="{{ url('/team_bahasas/')}}/{{$item->id}}" class='btn btn-secondary btn-sm'><i class="fa fa-language"></i></a>
            <a title="Peranan dikuasai" href="{{ url('/team_jabatans/')}}/{{$item->id}}" class='btn btn-secondary btn-sm'><i class="fa fa-child"></i></a>
            <a title="Keahlian dikuasai" href="{{ url('/team_keahlian/')}}/{{$item->id}}" class='btn btn-secondary btn-sm'><i class="fa fa-gavel"></i></a>
            -
            <a title="edit" href="{{ url('/teams/')}}/{{$item->id}}/edit" class='btn btn-primary btn-sm'><i class="fa fa-edit"></i></a>
            <a title="delete" href="{{ url('/teams/')}}/delete/{{$item->id}}" onclick="return confirm('Are you sure?')" class='btn btn-danger btn-sm'><i class="fa fa-trash-o"></i></a>
        </td>
    </tr>
    @endforeach
</tbody>
@include('layouts.gentelella.table_bottom')
@endsection('content')
