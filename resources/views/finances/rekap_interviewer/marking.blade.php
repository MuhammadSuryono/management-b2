@extends('maingentelellatable')
@section('title', 'Daftar Interviewer : ' . count($teams))
@section('content')


<div class="col-md-12 col-sm-12 ">
    <div class="x_panel">
        <div class="x_title">
            <h2>Note</h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card-box">
                        <p>1. Flag interviewer yang dilakukan pembayaran oleh pihak internal</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('layouts/gentelella/table_top')
<thead>
    <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Kota</th>
        <th>Bank</th>
        <th>Nomor Rekening</th>
        <th>Total Respondent</th>
        <th>Respondent OK</th>
        <th>Respondent BTF</th>
        <th>Responden DO</th>
        <th>Action</th>
    </tr>
</thead>
<tbody>
    @foreach ($teams as $item)
    <?php $total = 0; ?>
    <tr>
        <th scope='row'>{{$loop->iteration}}</th>
        <td>{{$item->nama}}</td>
        <td>
            <?php $kota = DB::table('kotas')->where('id', '=', $item->kota_id)->first(); ?>
            {{$kota->kota}}
        </td>
        <td> @if(isset($item->nama_bank))
            {{$item->nama_bank}}
            @else
            Kosong
            @endisset
        </td>
        <td> @if($item->nomor_rekening!='')
            {{$item->nomor_rekening}}
            @else
            Kosong
            @endif
        </td>
        <td>
            <!-- total respondent -->
            <?php $teamCode = sprintf('%04d', $item->no_team); ?>
            <?php $cityCode = sprintf('%03d', $item->kota_id); ?>
            <?php
            if (session('current_project_id') !== null) {
                $count = DB::table('respondents')->where('srvyr', '=', $cityCode . $teamCode)->where('project_id', '=', session('current_project_id'))->count();
            } else {
                $count = DB::table('respondents')->where('srvyr', '=', $cityCode . $teamCode)->count();
            } ?>
            <?php $code = $cityCode . $teamCode ?>
            {{$count}}
        </td>
        <td>
            <!-- respondent OK -->
            <?php
            if (session('current_project_id') !== null) {
                $countOk = DB::table('respondents')->where('srvyr', '=', $cityCode . $teamCode)->whereIn('status_qc_id',  array(5, 1, 0, 10))->where('project_id', '=', session('current_project_id'))->count();
            } else {
                $countOk = DB::table('respondents')->where('srvyr', '=', $cityCode . $teamCode)->whereIn('status_qc_id',  array(5, 1, 0, 10))->count();
            } ?>
            <?php $code = $cityCode . $teamCode ?>
            {{$countOk}}
        </td>
        <td>
            <!-- respondent BTF -->
            <?php
            if (session('current_project_id') !== null) {
                $count = DB::table('respondents')->where('srvyr', '=', $cityCode . $teamCode)->where('status_qc_id', '=', '4')->where('project_id', '=', session('current_project_id'))->count();
            } else {
                $count = DB::table('respondents')->where('srvyr', '=', $cityCode . $teamCode)->where('status_qc_id', '=', '4')->count();
            } ?>
            <?php $code = $cityCode . $teamCode ?>
            {{$count}}
        </td>
        <td>
            <!-- respondent DO -->
            <?php
            if (session('current_project_id') !== null) {
                $count = DB::table('respondents')->where('srvyr', '=', $cityCode . $teamCode)->whereIn('status_qc_id', array(2, 3, 6, 9))->where('project_id', '=', session('current_project_id'))->count();
            } else {
                $count = DB::table('respondents')->where('srvyr', '=', $cityCode . $teamCode)->whereIn('status_qc_id', array(2, 3, 6, 9))->count();
            } ?>
            <?php $code = $cityCode . $teamCode ?>
            {{$count}}
        </td>

        <td>
            <?php $check = DB::table('team_payment_markings')->where('project_id', session('current_project_id'))->where('team_id', $item->id)->where('posisi', 'Interviewer')->count();
            ?>
            <button class='btn btn-sm <?= (!$check) ? 'btn-primary btn-mark' : 'btn-danger btn-unmark' ?>' type="button" data-id="<?= $item->id ?>" data-project_id="<?= session('current_project_id') ?>">
                <?= (!$check) ? '<i class="fa fa-flag"></i>' : '<i class="fa fa-times"></i>' ?>
            </button>
        </td>
    </tr>
    @endforeach
</tbody>
@include('layouts.gentelella.table_bottom')
@endsection('content')

@section('javascript')
<script>
    let _token = $('input[name="_token"]').val();
    $(document).on('click', '.btn-mark', function() {
        const id = $(this).data('id');
        const project_id = $(this).data('project_id');
        const status = 'mark';

        $.ajax({
            url: "{{url('/rekap_interviewer/update_marking')}}",
            type: "post",
            data: {
                'id': id,
                'project_id': project_id,
                'status': status,
                '_token': _token
            },
            success: function(result) {

                console.log(result);
            }
        })
        $(this).html('<i class="fa fa-times"></i>');
        $(this).removeClass('btn-primary btn-mark');
        $(this).addClass('btn-danger btn-unmark');
    })

    $(document).on('click', '.btn-unmark', function() {
        const id = $(this).data('id');
        const project_id = $(this).data('project_id');
        const status = 'unmark';

        $.ajax({
            url: "{{url('/rekap_interviewer/update_marking')}}",
            type: "post",
            data: {
                'id': id,
                'project_id': project_id,
                'status': status,
                '_token': _token
            },
            success: function(result) {
                // location.reload();
                console.log(result);
            }
        })
        $(this).html('<i class="fa fa-flag"></i>');
        $(this).addClass('btn-primary btn-mark');
        $(this).removeClass('btn-danger btn-unmark');
    })
</script>
@endsection