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
                        <p>1. Flag user yang dilakukan pembayaran oleh pihak internal</p>
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
        <th>Action</th>
    </tr>
</thead>
<tbody>
    @foreach ($teams as $item)
    <?php $total = 0; ?>
    <tr>
        <th scope='row'>{{$loop->iteration}}</th>
        <td>{{$item->team}}</td>
        <td>
            {{$item->kota}}
        </td>

        <td>
            <?php $check = DB::table('team_payment_markings')->where('project_id', session('current_project_id'))->where('team_id', $item->team_id)->where('posisi', $item->jabatan)->count();
            ?>
            <button class='btn btn-sm <?= (!$check) ? 'btn-primary btn-mark' : 'btn-danger btn-unmark' ?>' type="button" data-id="<?= $item->team_id ?>" data-project_id="<?= session('current_project_id') ?>" data-jabatan="<?= $item->jabatan ?>">
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
        const jabatan = $(this).data('jabatan');
        const status = 'mark';

        $.ajax({
            url: "{{url('/rekap_tl/update_marking')}}",
            type: "post",
            data: {
                'id': id,
                'project_id': project_id,
                'status': status,
                'jabatan': jabatan,
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
        const jabatan = $(this).data('jabatan');
        const status = 'unmark';

        $.ajax({
            url: "{{url('/rekap_tl/update_marking')}}",
            type: "post",
            data: {
                'id': id,
                'project_id': project_id,
                'status': status,
                'jabatan': jabatan,
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