@extends('maingentelellatable')
@section('title', 'Plan Project '.session('current_project_nama') )
@section('content')
@include('layouts.gentelella.table_top')
<thead>
    <tr>
        <th>No</th>
        <th>Nama</th>
        <?php if ($is_respondent == 1) : ?>
            <th>Nomor Rekening</th>
            <th>Bank</th>
            <th>Pemilik Rekening</th>
            <th>Evidence</th>
        <?php endif; ?>
        <th>Kedatangan</th>
        <th>Action</th>
    </tr>
</thead>
<tbody>

    <?php $i = 1; ?>
    <?php if ($is_respondent == 0) : ?>
        @foreach ($project_absensi as $item)
        <tr>
            <th scope='row'><?= $i++ ?></th>
            <td>{{isset($item->team->nama)? $item->team->nama : '-'}}</td>
            <td> {{$item->created_at}}</td>
            <td>
                <a title="delete" href="{{ url('/project_plans/')}}/delete_audience/{{$item->id}}" onclick="return confirm('Hapus?')" class='btn btn-danger btn-sm'><i class="fa fa-trash-o"></i></a>
                <!-- <a title="Prepare Absensi" href="{{ url('/project_plans/prepare_absensi')}}/{{$item->id}}" class='btn btn-info btn-sm'><i class="fa fa-qrcode"></i></a> -->
            </td>
        </tr>
        @endforeach
    <?php else : ?>
        @foreach ($project_absensi as $item)
        <tr>
            <th scope='row'><?= $i++ ?></th>
            <td>{{isset($item->respondent->respname)? $item->respondent->respname : '-'}}</td>
            <td>{{isset($item->nomor_rekening)? $item->nomor_rekening : '-'}}</td>
            @if(isset($item->kode_bank))
            <td>
                <?php
                $bank = DB::connection('mysql3')->table('bank')->where('kode', '=', $item->kode_bank)->first();
                if ($bank) {
                    echo $bank->nama;
                }
                ?>
                @endif</td>
            <td>{{isset($item->pemilik_rekening)? $item->pemilik_rekening : '-'}}</td>
            <td style="text-align: center;">
                @if($item->evidence)
                <a target="_blank" class='btn btn-primary btn-sm text-center' href="{{url('/teams/view')}}/{{$item->evidence}}"><i class="fa fa-eye"></i></a>
                @endif
            </td>
            <td> {{$item->created_at}}</td>
            <td>
                <a title="delete" href="{{ url('/project_plans/')}}/delete_audience/{{$item->id}}" onclick="return confirm('Hapus?')" class='btn btn-danger btn-sm'><i class="fa fa-trash-o"></i></a>
                <!-- <a title="Prepare Absensi" href="{{ url('/project_plans/prepare_absensi')}}/{{$item->id}}" class='btn btn-info btn-sm'><i class="fa fa-qrcode"></i></a> -->
            </td>
        </tr>
        @endforeach
    <?php endif; ?>
</tbody>
@include('layouts.gentelella.table_bottom')
@endsection('content')