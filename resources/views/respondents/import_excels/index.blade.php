@extends('maingentelellatable')
@section('title', 'Daftar file Import Excel : ' . $import_excels->count())
@section('content')
@include('layouts/gentelella/table_top')

    <thead>
        <tr>
            <th>No</th>
            <th>Excel</th>
            <th>Jumlah Record</th>
            <th>Tgl import</th>
            <th>By</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($import_excels as $item)
        <tr>
            <th scope='row'>{{$loop->iteration}}</th>
            <td>{{$item->excel_file}}</th>
            <td>{{$item->jumlah_record}}</td>
            <td>{{$item->created_at}}</td>
            <td>{{$item->user->user_login}}</td>
            <td>
                    <a href="{{ url('/import_excels/')}}/{{$item->id}}/edit" class='btn btn-primary btn-sm'> <i class="fa fa-edit"></i></a>
                    <a href="{{ url('/import_excels/delete')}}/{{$item->id}}" onclick="return confirm('Are you sure?')" class='btn btn-danger btn-sm'><i class="fa fa-trash-o"></i></a>
            </td>
        </tr>
        @endforeach
    </tbody>
{{-- Standard Table Bottom --}}
@include('layouts/gentelella/table_bottom')
{{-- End of Standard table Bottom --}}
@endsection('content')
