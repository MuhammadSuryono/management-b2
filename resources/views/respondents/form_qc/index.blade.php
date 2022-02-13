@extends('maingentelellatable')
@section('title', 'Data Form QC : ' . $formQc->count())
@section('content')
@include('layouts.gentelella.table_top')
<thead>
    <tr>
        <th>No</th>
        <th>Nama Project</th>
        <th>Nama Respondent</th>
        <th>Interviewer</th>
        <th>Tanggal QC</th>
        <th>Jam QC</th>
        <th>Callback Ke</th>
        <th>Rekaman</th>
        <th>Action</th>
    </tr>
</thead>
<tbody>
    @foreach ($formQc as $item)
    <tr>
        <th scope='row'>{{$loop->iteration}}</th>
        <td>{{$item->respondent->project->nama}}</td>
        <td>{{$item->respondent->respname}}</td>
        <td>
            <?php
            if ($item->respondent->srvyr) {
                $pwt = DB::table('teams')->where('id', $item->respondent->srvyr)->first();
                if ($pwt) {
                    echo $pwt->nama;
                } else {
                    echo "Kosong";
                }
            } else {
                echo "Kosong";
            }
            ?>
        </td>
        <td>{{$item->tanggal_qc}}</td>
        <td>{{$item->jam_qc}}</td>
        <td>{{$item->callback}}</td>
        <td style="text-align: center;">
            @if($item->screenshoot)
            <a target="_blank" class='btn btn-primary btn-sm text-center' href="{{url('/teams/view')}}/{{$item->screenshoot}}"><i class="fa fa-play"></i></a>
            @endif
        </td>
        <td>
            <a href="{{ url('/form_qc/')}}/{{$item->id}}/edit" class='btn btn-primary btn-sm'><i class="fa fa-edit"></i></a>
            <a href="{{ url('/form_qc/')}}/delete/{{$item->id}}" onclick="return confirm('Are you sure?')" class='btn btn-danger btn-sm'><i class="fa fa-trash-o"></i></a>
        </td>
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