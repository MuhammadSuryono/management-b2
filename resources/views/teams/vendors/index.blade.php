@extends('maingentelellatable')
@section('title', 'Vendor : ' . $vendors->count())
@section('content')
@include('layouts.gentelella.table_top')
<thead>
    <tr>
        <th>No</th>
        <th>Profile Company</th>
        <th>Alamat</th>
        <th>Contact Person</th>
        <th>No. Telp Kantor</th>
        <th>No. Telp Personal</th>
        <th>Email</th>
        <th>Website</th>
        <th>NPWP</th>
        <th>Bukti NPWP</th>
        <th>Action</th>
    </tr>
</thead>
<tbody>
    @foreach ($vendors as $item)
    <tr>
        <th scope='row'>{{$loop->iteration}}</th>
        <td>{{$item->nama_perusahaan}}</td>
        <td>{{$item->alamat}}</td>
        <td>{{$item->contact_person}}</td>
        <td>{{$item->no_telp_kantor}}</td>
        <td>{{$item->no_telp_personal}}</td>
        <td>{{$item->email}}</td>
        <td>{{$item->website}}</td>
        <td>{{$item->npwp}}</td>
        <td>
            @if(($item->bukti_npwp))
            <a href="{{url('/vendors/view')}}/{{$item->bukti_npwp}}" target="_blank"> <i class="fa fa-eye"></i></a>
            @endif
        </td>
        <td>
            <a title="Keahlian dikuasai" href="{{ url('/vendor_layanan/')}}/{{$item->id}}" class='btn btn-secondary btn-sm'><i class="fa fa-gavel"></i></a>
            -
            <a href="{{ url('/vendors/')}}/{{$item->id}}/edit" class='btn btn-primary btn-sm'><i class="fa fa-edit"></i></a>
            <a href="{{ url('/vendors/')}}/delete/{{$item->id}}" onclick="return confirm('Are you sure?')" class='btn btn-danger btn-sm'><i class="fa fa-trash-o"></i></a>
        </td>
    </tr>
    @endforeach
</tbody>
@include('layouts.gentelella.table_bottom')
@endsection('content')