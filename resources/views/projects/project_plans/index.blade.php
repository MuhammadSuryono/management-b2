@extends('maingentelellatable')
@section('title', 'Project Plan '.session('current_project_nama') )
@section('content')
@include('layouts.gentelella.table_top')
<thead>
    <tr>
        <th>No</th>
        <th>Nama Kegiatan</th>
        <!-- <th>N</th> -->
        <th>Tgl Mulai</th>
        <th>Jam Mulai</th>
        <th>Tgl Selesai</th>
        <th>Jam Selesai</th>
        <th>Keterangan</th>
        <th>Action</th>
    </tr>
</thead>
<tbody>

    <?php $i = 1; ?>
    @foreach ($project_plans as $item)

    <tr>
        <th scope='row'><?= $i++ ?></th>
        <td>{{$item->nama_kegiatan}}</td>
        <!-- <td> </td> -->
        <td> {{$item->date_start_real}}</td>
        <td> {{$item->hour_start_real}}</td>
        <td> {{$item->date_finish_real}}</td>
        <td> {{$item->hour_finish_real}}</td>
        <td>{{$item->ket}} </td>
        <td>
            <a title="edit" href="{{ url('/project_plans/')}}/{{$item->id}}/edit" class='btn btn-primary btn-sm'><i class="fa fa-edit"></i></a>
            <a title="delete" href="{{ url('/project_plans/')}}/delete/{{$item->id}}" onclick="return confirm('Hapus?')" class='btn btn-danger btn-sm'><i class="fa fa-trash-o"></i></a>
            @if($item->has_presence == 1)
            <a title="Prepare Presensi Team" href="{{ url('/project_plans/print_qr')}}/{{$item->id}}" target="_blank" class='btn btn-info btn-sm '><i class="fa fa-qrcode"></i></a>
            <a title="Show Presensi Team" href="{{ url('project_plans/')}}/show_presence_audience/{{$item->id}}" class='btn btn-info btn-sm'><i class="fa fa-list-alt"></i></a>
            @endif
            @if($item->has_respondent_presence == 1)
            <a title="Prepare Presensi Respondent" href="{{ url('/project_plans/print_qr_respondent')}}/{{$item->id}}" target="_blank" class='btn btn-success btn-sm '><i class="fa fa-qrcode"></i></a>
            <a title="Show Presensi Respondent" href="{{ url('project_plans/')}}/show_presence_audience_respondent/{{$item->id}}" class='btn btn-success btn-sm'><i class="fa fa-list-alt"></i></a>
            @endif
            <!-- <a title="Prepare Absensi" href="{{ url('/project_plans/prepare_absensi')}}/{{$item->id}}" class='btn btn-info btn-sm'><i class="fa fa-qrcode"></i></a> -->

        </td>
    </tr>
    @endforeach
</tbody>
@include('layouts.gentelella.table_bottom')
@endsection('content')