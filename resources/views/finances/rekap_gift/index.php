@extends('maingentelellatable')
@section('title', 'Daftar Responden : '. count($respondents) )
@section('content')

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

                        <form class="form-horizontal form-label-left" method="get" action="{{url('/respondent_gift')}}">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div align="left" class="col-md-4 col-sm-12 col-xs-12">
                                            <!-- Project -->
                                            <div class="form-group row">
                                                <label class="col-form-label col-md-3 col-sm-3" for="project_imported_id">Project</label>
                                                <div class="col-md-9 col-sm-9">
                                                    <select id="project_imported_id" name="project_imported_id" class="form-control pull-right">
                                                        <option value="all">All</option>
                                                        @foreach($project_importeds as $db)
                                                        @if(isset($_GET['project_imported_id']) and $_GET['project_imported_id'] == $db['id'])
                                                        <option value="{{$db['id']}}" selected>{{$db['project_imported']}}</option>
                                                        @else
                                                        <option value="{{$db['id']}}"> {{$db['project_imported']}}</option>
                                                        @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Valid Data  -->
                                            <div class="form-group row">
                                                <label class="col-form-label col-md-3 col-sm-3" for="status_pembayaran_id">Status Pembayaran</label>
                                                <div class="col-md-9 col-sm-9">
                                                    <select id="status_pembayaran_id" name="status_pembayaran_id" class="form-control">
                                                        <option value="all">All</option>
                                                        @foreach($statusPembayaran as $db)
                                                        @if(isset($_GET['status_pembayaran_id']) && $_GET['status_pembayaran_id'] == $db['id'])
                                                        <option value="{{$db['id']}}" selected>{{$db['keterangan_pembayaran']}}</option>
                                                        @else
                                                        <option value="{{$db['id']}}"> {{$db['keterangan_pembayaran']}}</option>
                                                        @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div align="left" class="col-md-3 col-sm-12 col-xs-12">
                                            <!-- Kota -->
                                            <div class="form-group row">
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
                                        </div>

                                        <div align="left" class="col-md-5 col-sm-12 col-xs-12">
                                            <div class="form-group row">
                                                <label class="col-form-label col-md-2 col-sm-2" for="status_pembayaran_id">Tanggal Pengajuan</label>
                                                <div class="col-md-4 col-sm-5">
                                                    <input type="date" class="form-control" name="tanggal_mulai_pengajuan" value="<?= (isset($_GET['tanggal_mulai_pengajuan']) ? $_GET['tanggal_mulai_pengajuan'] : '') ?>">
                                                </div>
                                                <p>s/d</p>
                                                <div class="col-md-4 col-sm-5">
                                                    <input type="date" class="form-control" name="tanggal_selesai_pengajuan" value="<?= (isset($_GET['tanggal_selesai_pengajuan']) ? $_GET['tanggal_selesai_pengajuan'] : '') ?>">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-form-label col-md-2 col-sm-2" for="status_pembayaran_id">Tanggal Pembayaran</label>
                                                <div class="col-md-4 col-sm-5">
                                                    <input type="date" class="form-control" name="tanggal_mulai_pembayaran" value="<?= (isset($_GET['tanggal_mulai_pembayaran']) ? $_GET['tanggal_mulai_pembayaran'] : '') ?>">
                                                </div>
                                                <p>s/d</p>
                                                <div class="col-md-4 col-sm-5">
                                                    <input type="date" class="form-control" name="tanggal_selesai_pembayaran" value="<?= (isset($_GET['tanggal_selesai_pembayaran']) ? $_GET['tanggal_selesai_pembayaran'] : '') ?>">
                                                </div>
                                            </div>


                                        </div>

                                        <input type="hidden" id="link_from" name="link_from" value="{{session('link_from')}}">
                                    </div>

                                </div>
                                <div align="center" class="form-group">
                                    <a href="{{url()->current()}}" type="button" class="btn btn-info text-white"> Reset </a>
                                    <button type="submit" class="btn btn-info"> Show </button>
                                    <?php
                                    $request = isset($_SERVER['QUERY_STRING']) ? ltrim($_SERVER['QUERY_STRING'], !empty($_SERVER['QUERY_STRING']))ltrim($_SERVER['QUERY_STRING'], !empty($_SERVER['QUERY_STRING'])) ;
                                    ?>
                                    <!-- <a href="{{url('respondents/pick_respondent?')}}{{$request}}" type="button" class="btn btn-info" id="btn-pick-respondent">Pick Respondent </a> -->
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$totalKeseluruhan = 0;
$totalDiajukan = 0;
$totalDibayar = 0;
foreach ($respondents as $item) {
    $gift = DB::table('project_kotas')->where('project_kotas.kota_id', $item->kota_id)->where('project_kotas.project_id', $item->project_id)->join('project_honor_gifts', 'project_honor_gifts.project_kota_id', '=', 'project_kotas.id')->where(DB::raw('lower(nama_honor_gift)'), '=', strtolower($item->kategori_gift))->first();
    if (isset($gift->honor_gift)) {
        $totalKeseluruhan += $gift->honor_gift;
        if (isset($item->status_pembayaran_id) && $item->status_pembayaran_id == 2) {
            $totalDiajukan += $gift->honor_gift;
        }
        if (isset($item->status_pembayaran_id) && $item->status_pembayaran_id == 3) {
            $totalDibayar += $gift->honor_gift;
        }
    }
}
?>

<div class="col-md-12 col-sm-12 ">
    <div class="x_panel">
        <div class="x_title">
            <h2>Data Persentase</h2>
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
                        <div class="row tile_count justify-content-center">
                            <div align="center" class="col-md-4 col-sm-12 col-xs-12 tile_stats_count">
                                <a href=""> <span class="count_top "><b> Total Keseluruhan </b></span>
                                    <div class="count" style="color: green">Rp. <?= number_format($totalKeseluruhan) ?></div>
                                </a>
                            </div>
                            <div align="center" class="col-md-4 col-sm-12 col-xs-12 tile_stats_count">
                                <a href=""> <span class="count_top "><b> Total Pengajuan </b></span>
                                    <div class="count" style="color: green">Rp. <?= number_format($totalDiajukan) ?></div>
                                </a>
                            </div>
                            <div align="center" class="col-md-4 col-sm-12 col-xs-12 tile_stats_count">
                                <a href=""> <span class="count_top "><b> Total Diajukan </b></span>
                                    <div class="count" style="color: green">Rp. <?= number_format($totalKeseluruhan) ?></div>
                                </a>
                            </div>
                        </div>
                        <!-- </form> -->
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
        <th>Nama Responden</th>
        <th>Kota</th>
        <th>No. Telp</th>
        <th>E-wallet</th>
        <th>Email</th>
        <th>Bank</th>
        <th>Nomor Rekening</th>
        <th>Nominal Gift</th>
        <th>Status</th>
        <th>Keterangan</th>
        <th>Terakhir Diubah</th>
        <th>Action</th>
    </tr>
</thead>
<tbody>
    <?php $total = 0; ?>
    @foreach($respondents as $item)
    <tr>
        <th scope='row'>{{$loop->iteration}}</th>
        <td>{{$item->respname}}</td>
        <td>
            @if(isset($item->kota->kota))
            {{$item->kota->kota}}
            @endif
        </td>
        <td>{{$item->mobilephone}}</td>

        <td>
            @if(isset($item->e_wallet_kode))
            <?php
            $e_wallet = DB::table('e_wallets')->where('kode', '=', $item->e_wallet_kode)->first();
            if ($e_wallet) {
                echo $e_wallet->nama;
            }
            ?>
            @endif
        </td>
        <td>
            @if(isset($item->email))
            {{$item->email}}
            @endif
        </td>
        <td>
            @if(isset($item->kode_bank))
            <?php
            $bank = DB::connection('mysql3')->table('bank')->where('kode', '=', $item->kode_bank)->first();
            if ($bank) {
                echo $bank->nama;
            }
            ?>
            @endif
        </td>
        <td>
            @if(isset($item->nomor_rekening))
            {{$item->nomor_rekening}}
            @endif
        </td>
        <td>
            <?php
            $gift = DB::table('project_kotas')->where('project_kotas.kota_id', $item->kota_id)->where('project_kotas.project_id', $item->project_id)->join('project_honor_gifts', 'project_honor_gifts.project_kota_id', '=', 'project_kotas.id')->where(DB::raw('lower(nama_honor_gift)'), '=', strtolower($item->kategori_gift))->first();
            ?>
            @if(isset($gift->honor_gift))
            Rp. {{number_format($gift->honor_gift)}}
            @else
            Kosong
            @endif
        </td>
        <td>
            @if(isset($item->status_pembayaran->keterangan_pembayaran))
            {{$item->status_pembayaran->keterangan_pembayaran}}
            @endif
        </td>
        <td>
            @if(isset($item->keterangan_pembayaran))
            {{$item->keterangan_pembayaran}}
            @else
            Kosong
            @endif
        </td>
        <td>
            @if(isset($item->tanggal_update_pembayaran))
            {{$item->tanggal_update_pembayaran}}
            @else
            Kosong
            @endif
        </td>
        <td>
            @if($item->status_pembayaran_id != 3)
            <button class='btn btn-primary btn-sm btn-ajukan' type="button" data-toggle="modal" data-target="#ajukanModal" data-id="<?= $item->id ?>" data-nextstatus="<?= $item->status_pembayaran_id + 1 ?>">
                @if($item->status_pembayaran_id == 1)
                Ajukan
                @elseif($item->status_pembayaran_id == 2)
                Bayar
                @elseif($item->status_pembayaran_id == 4)
                Bayar Ulang
                @endif
            </button>
            @endif
        </td>
    </tr>
    @endforeach
</tbody>
@include('layouts.gentelella.table_bottom')
@endsection('content')

@section('javascript')
<script>
    $('body').on('click', '.btn-ajukan', function() {
        const nextStatus = $(this).data('nextstatus');
        $('input[name=id]').val($(this).data('id'));

        if (nextStatus - 1 == 2 || nextStatus - 1 == 4) {
            let firstChecked = $('input[name="status_bayar"]:checked').val();
            $('input[name=nextStatus]').val(firstChecked);

            console.log(firstChecked);

            let getChecked = $('input[name="status_bayar"]:checked').val();
            $('input[name=nextStatus]').val(getChecked);
            $('#input-bayar').show();
            $('input[name="status_bayar"]').change(function() {
                let getChecked = $('input[name="status_bayar"]:checked').val();
                $('input[name=nextStatus]').val(getChecked);
            })
        } else {
            $('#input-bayar').hide();
            $('input[name=nextStatus]').val(nextStatus);
        }
    })

    $('body').on('click', '#btn-submit-ajukan-modal', function() {
        let getChecked = $('input[name="status_bayar"]:checked').val();
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

    $(document).ready(function() {
        $('.card-box.table-responsive a').hide();
    });
</script>
@endsection
