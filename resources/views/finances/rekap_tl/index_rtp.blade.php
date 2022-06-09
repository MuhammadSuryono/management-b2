@extends('maingentelellatable')
@section('title', 'Daftar Tim : ' . count($teams))
@section('content')

<?php $status = DB::table('status_pembayarans')->where('id', $_GET['status_pembayaran_id'])->first(); ?>

<h3 class="d-block text-center text-primary">Rekap TL: <?= $status->keterangan_pembayaran ?></h3>
{{-- Filter --}}
<div class="col-md-12 col-sm-12 ">
    <div class="x_panel">
        <div class="x_title">
            <h2>Filter:</h2>
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
                        <p class="text-muted font-13 m-b-30">
                            Filter kriteria yang anda pilih:
                        </p>

                        <form class="form-horizontal form-label-left" method="get" action="{{url('/rekap_tl/index_rtp')}}">
                            <input type="hidden" name="status_pembayaran_id" value="<?= isset($_GET['status_pembayaran_id']) ?  $_GET['status_pembayaran_id'] : '' ?>">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div align="left" class="col-md-4 col-sm-4 col-xs-12">
                                            <!-- Project -->
                                            <div class="form-group row">
                                                <label class="col-form-label col-md-3 col-sm-3" for="project_id">Project</label>
                                                <div class="col-md-9 col-sm-9">
                                                    <select id="project_id" name="project_id" class="form-control pull-right">
                                                        <option value="all">All</option>
                                                        @foreach($projects as $db)
                                                        @if(isset($_GET['project_id']) and $_GET['project_id'] == $db['id'])
                                                        <option value="{{$db['id']}}" selected>{{$db['nama']}}</option>
                                                        @else
                                                        <option value="{{$db['id']}}"> {{$db['nama']}}</option>
                                                        @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div align="left" class="col-md-4 col-sm-4 col-xs-12">
                                            <div class="form-group row row-filter-kota">
                                                <label class="col-form-label col-md-3 col-sm-3" for="kota_id">Kota</label>
                                                <div class="col-md-9 col-sm-9">
                                                    <select id="kota_id" name="kota_id" class="form-control">
                                                        <option value="all">All</option>
                                                        @foreach($kotas as $db)
                                                        @if(isset($_GET['kota_id']) and $_GET['kota_id'] == $db['id'])
                                                        <option value="{{$db['id']}}" selected>{{$db['kota']}}</option>
                                                        @else
                                                        <option value="{{$db['id']}}"> {{$db['kota']}}</option>
                                                        @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <input type="hidden" id="link_from" name="link_from" value="{{session('link_from')}}">

                                        </div>

                                    </div>
                                    <div align="center" class="form-group">
                                        <a href="{{url()->current()}}" type="button" class="btn btn-info text-white"> Reset </a>
                                        <button type="submit" class="btn btn-info"> Show </button>
                                    </div>
                                </div>
                        </form>
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
        <th>Type TL</th>
        <th>Kota</th>
        <th>No. Telp</th>
        <th>Email</th>
        <th>Bank</th>
        <th>Nomor Rekening</th>
        <th>Metode Pembayaran</th>
        <th>Jadwal Pembayaran</th>
        <th>Keterangan Pembayaran</th>
        <th>Total</th>
        @if ($_GET["status_pembayaran_id"])

        <th>Total Pembayaran</th>
        @endif
    </tr>
</thead>
<tbody>
    @foreach ($teams as $item)
    <?php $total = 0; ?>
    <tr>
        <th scope='row'>{{$loop->iteration}}</th>
        <td><a href="{{route('detail_payment', ['projectTeamId' => $item->project_team_id])}}" target="_blank">{{$item->team->nama}}</a></td>
        <td>{{ucwords($item->type_tl)}}</td></td>
        <td>
            @if(isset($item->projectKota->kota))
                {{$item->projectKota->kota->kota}}
            @endif
        </td>
        <td>
            @if(isset($item->team->hp))
                {{$item->team->hp}}
            @endif
        </td>
        <td>
            @if(isset($item->team->email))
                {{$item->team->email}}
            @endif
        </td>
        <td>
            @if(isset($item->team->kode_bank))
                <?php
                $client->request('GET', 'api/bank?action=filter&kodebank=' . $item->team->kode_bank);
                $bank = $client->getBody()->data;
                if ($bank) {
                    echo $bank[0]->namabank;
                }
                ?>
            @endif
        </td>
        <td>
            @if(isset($item->team->nomor_rekening))
            {{$item->team->nomor_rekening}}
            @endif
        </td>
        <td>{{$item->metode_pembayaran}}</td>
        <td>{{$item->tanggal_pembayaran}}</td>
        <td>{{$item->keterangan_pembayaran}}</td>
        <td>
            {{"Rp. " . number_format($item->total)}}

        </td>
        @if ($_GET["status_pembayaran_id"])

        <td>
            {{"Rp. " . number_format($item->total_dibayarkan)}}

        </td>
        @endif

    </tr>
    @endforeach
</tbody>
@include('layouts.gentelella.table_bottom')

<div class="row">
</div>
@endsection('content')


@section('javascript')
<script>
    $(document).ready(function() {
        $('.card-box.table-responsive a').hide();

        $('body').on('click', '.btn-ajukan', function() {
            const nextStatus = $(this).data('nextstatus');
            $('input[name=id]').val($(this).data('id'));
            $('input[name=total]').val($(this).data('total'));
            $('input[name=nextStatus]').val(nextStatus);
        })

        $('body').on('click', '#btn-ajukan', function() {
            const nextStatus = $(this).data('nextstatus');

            let strId = '';
            let strTotal = '';
            $('input[name="id"]:checked').each(function() {
                strId += `${this.value},`
                strTotal += $(`input[name=total-${this.value}]`).val() + ","
            });
            strId = strId.slice(0, -1);
            strTotal = strTotal.slice(0, -1);

            $('input[name=id]').val(strId);
            $('input[name=total]').val(strTotal);
            console.log(strTotal);

            if (nextStatus - 1 == 2 || nextStatus - 1 == 4) {
                let firstChecked = $('input[name="status_bayar"]:checked').val();
                $('input[name=nextStatus]').val(firstChecked);

                let getChecked = $('input[name="status_bayar"]:checked').val();
                $('input[name=nextStatus]').val(getChecked);
                $('#input-bayar').show();
                $('input[name="status_bayar"]').change(function() {
                    let getChecked = $('input[name="status_bayar"]:checked').val();
                    $('input[name=nextStatus]').val(getChecked);
                })
            } else if (nextStatus - 1 == 1) {
                $('#ajukan-bayar').show();
                $('input[name=nextStatus]').val(nextStatus);
            } else {
                $('#input-bayar').hide();
                $('#ajukan-bayar').hide();
                $('input[name=nextStatus]').val(nextStatus);
            }

        })

        // $('body').on('click', '.btn-ajukan', function() {
        //     const nextStatus = $(this).data('nextstatus');
        //     $('input[name=id]').val($(this).data('id'));
        //     $('input[name=total]').val($(this).data('total'));

        //     if (nextStatus - 1 == 2 || nextStatus - 1 == 4) {
        //         let firstChecked = $('input[name="status_bayar"]:checked').val();
        //         $('input[name=nextStatus]').val(firstChecked);

        //         let getChecked = $('input[name="status_bayar"]:checked').val();
        //         $('input[name=nextStatus]').val(getChecked);
        //         $('#input-bayar').show();
        //         $('input[name="status_bayar"]').change(function() {
        //             let getChecked = $('input[name="status_bayar"]:checked').val();
        //             $('input[name=nextStatus]').val(getChecked);
        //         })
        //     } else if (nextStatus - 1 == 1) {
        //         $('#ajukan-bayar').show();
        //         $('input[name=nextStatus]').val(nextStatus);
        //     } else {
        //         $('#input-bayar').hide();
        //         $('#ajukan-bayar').hide();
        //         $('input[name=nextStatus]').val(nextStatus);
        //     }
        // })

        $('body').on('click', '#btn-submit-ajukan-modal', function() {
            let getChecked = $('input[name="status_bayar"]:checked').val();
            console.log($('#ket_pembayaran').val());
            if (getChecked == 4) {
                if ($('#ket_pembayaran').val() == '') {
                    alert('Harap isi keterangan');
                } else {
                    $('#form-change-status').submit();
                }
            } else {
                $('#form-change-status').submit();
            }
        })
    });
</script>
@endsection
