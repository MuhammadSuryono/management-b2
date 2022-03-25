@extends('maingentelellatable')
@section('title', 'Daftar Interviewer : ' . count($teams))
@section('content')

<?php $status = DB::table('status_pembayarans')->where('id', $_GET['status_pembayaran_id'])->first(); ?>

<h3 class="d-block text-center text-primary">Rekap Interviewer: <?= $status->keterangan_pembayaran ?></h3>
{{-- Filter --}}
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
                        <p>1. Pilih Filter project dan kota terlebih dahulu untuk melihat detail honor</p>
                        <p>2. Apabila pembayaran internal maka filter kota akan menyesuaikan data kota team yang di marking, tetapi apabila pembayaran external filter kota akan menyesuaikan data kota respondent </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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

                        <form class="form-horizontal form-label-left" method="get" action="{{url('/rekap_interviewer/index_rtp')}}">
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

                                            <div class="form-group row row-filter-kota" style="display: none;">
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
                                        <?php
                                        $request = ltrim($_SERVER['QUERY_STRING'], !empty($_SERVER['QUERY_STRING']));
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
if (isset($_GET['project_id'])) {
    foreach ($teams as $item) {
        // $gift = DB::table('project_kotas')->where('project_kotas.kota_id', $item->kota_id)->where('project_kotas.project_id', $item->project_id)->join('project_honor_gifts', 'project_honor_gifts.project_kota_id', '=', 'project_kotas.id')->where(DB::raw('lower(nama_honor_gift)'), '=', strtolower($item->kategori_gift))->first();
        if (isset($item->total)) {
            $totalKeseluruhan += $item->total;
            if (isset($item->status_pembayaran_id) && $item->status_pembayaran_id == 2) {
                $totalDiajukan += $item->total;
            }
            if (isset($item->status_pembayaran_id) && $item->status_pembayaran_id == 3) {
                $totalDibayar += $item->total;
            }
        }
    }
}
?>

<div class="col-md-12 col-sm-12 ">
    <div class="x_panel">
        <div class="x_title">
            <h2>Total</h2>
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
                            <div align="center" class="col-md-6 col-sm-12 col-xs-12 tile_stats_count">
                                <a href=""> <span class="count_top "><b> Total Keseluruhan </b></span>
                                    <div class="count" style="color: green">Rp. <?= number_format($totalKeseluruhan) ?></div>
                                </a>
                            </div>
                            <div align="center" class="col-md-6 col-sm-12 col-xs-12 tile_stats_count">
                                <a href=""> <span class="count_top "><b> Total Data </b></span>
                                    <div class="count" style="color: green"><?= count($teams) ?></div>
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
        <th>Nama</th>
        <th>Kota</th>
        <th>Bank</th>
        <th>Nomor Rekening</th>
        @if(isset($_GET['project_id']))
        <!-- <th>Target Perolehan</th> -->
        @endif
        <th>Total Respondent</th>
        <th>Respondent OK</th>
        <!-- <th>Respondent BTF</th> -->
        <th>Responden DO</th>
        @if(isset($_GET['project_id']))
        <th>Term BPU</th>
        <th>Total Diajukan</th>
        <th>Metode Pembayaran</th>
        <th>Action</th>
        @endif
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
        <td> @if($item->nomor_rekening!='')
            {{$item->nomor_rekening}}
            @else
            Kosong
            @endif
        </td>
        <?php if (isset($_GET['project_id'])) :
            // $queryProjectKota = DB::table('project_kotas')->where('project_id', '=', $_GET['project_id'])->where('kota_id', '=', $item->kota_id)->first();
        ?>
            <!-- <td>
                @if(isset($queryProjectKota->jumlah))
                {{$queryProjectKota->jumlah}}
                @else
                Kosong
                @endif
            </td> -->
        <?php endif; ?>
        <td>
            <!-- total respondent -->
            <?php $teamCode = sprintf('%04d', $item->no_team); ?>
            <?php $cityCode = sprintf('%03d', $item->kota_id); ?>
            <?php
            if (isset($_GET['project_id'])) {
                $count = DB::table('respondents')->where('srvyr', '=', $cityCode . $teamCode)->where('project_id', '=', $_GET['project_id'])->count();
            } else {
                $count = DB::table('respondents')->where('srvyr', '=', $cityCode . $teamCode)->count();
            } ?>
            <?php $code = $cityCode . $teamCode ?>
            {{$count}}
        </td>
        <td>
            <!-- respondent OK -->
            <?php
            if (isset($_GET['project_id'])) {
                $countOk = DB::table('respondents')->where('srvyr', '=', $cityCode . $teamCode)->whereIn('status_qc_id',  array(5, 1, 0, 10))->where('project_id', '=', $_GET['project_id'])->count();
            } else {
                $countOk = DB::table('respondents')->where('srvyr', '=', $cityCode . $teamCode)->whereIn('status_qc_id',  array(5, 1, 0, 10))->count();
            } ?>
            <?php $code = $cityCode . $teamCode ?>
            {{$countOk}}
        </td>
        <td>
            <!-- respondent DO -->
            <?php
            if (isset($_GET['project_id'])) {
                $count = DB::table('respondents')->where('srvyr', '=', $cityCode . $teamCode)->whereIn('status_qc_id', array(2, 3, 6, 9))->where('project_id', '=', $_GET['project_id'])->count();
            } else {
                $count = DB::table('respondents')->where('srvyr', '=', $cityCode . $teamCode)->whereIn('status_qc_id', array(2, 3, 6, 9))->count();
            } ?>
            <?php $code = $cityCode . $teamCode ?>
            {{$count}}
        </td>


        @if(isset($_GET['project_id']))
        <td>
            {{$item->bpu_term}}
        </td>
        <td>
            Rp.{{number_format($item->total)}}
        </td>
        <td>
            {{$item->metode_pembayaran}}
        </td>

        <td>
            <?php if ($item->status_pembayaran_id != 3 && $item->metode_pembayaran != 'MRI PAL') : ?>

                <input class="ajukanCheck" type="checkbox" value="<?= $item->id ?>" name="id" style="width: 1.5rem;height: 1.5rem;">
                <input type="hidden" name="total-<?= $item->id ?>" value="<?= $item->total ?>">
                <!-- <button class='btn btn-primary btn-sm btn-ajukan' type="button" data-toggle="modal" data-target="#ajukanModal" data-id="<?= $item->id ?>" data-nextstatus="<?= $item->status_pembayaran_id + 1 ?>" data-total="<?= $total ?>">
                    @if($item->status_pembayaran_id == 1)
                    Ajukan
                    @elseif($item->status_pembayaran_id == 2)
                    Bayar
                    @elseif($item->status_pembayaran_id == 4)
                    Bayar Ulang
                    @endif
                </button> -->
            <?php endif; ?>
        </td>
        @endif
    </tr>
    @endforeach
</tbody>
@include('layouts.gentelella.table_bottom')
<div class="row">
    @if($_GET['status_pembayaran_id'] == 1)
    <button class='btn btn-primary btn-lg ml-auto mr-5' id="btn-ajukan" type="button" data-toggle="modal" data-target="#ajukanModal" data-id="" data-nextstatus="<?= $_GET['status_pembayaran_id'] + 1 ?>">
        Ajukan
    </button>
    @elseif($_GET['status_pembayaran_id'] == 2)
    <button class='btn btn-primary btn-lg ml-auto mr-5' id="btn-ajukan" type="button" data-toggle="modal" data-target="#ajukanModal" data-id="" data-nextstatus="<?= $_GET['status_pembayaran_id'] + 1 ?>">
        Bayar
    </button>
    @elseif($_GET['status_pembayaran_id'] == 4)
    <button class='btn btn-primary btn-lg ml-auto mr-5' id="btn-ajukan" type="button" data-toggle="modal" data-target="#ajukanModal" data-id="" data-nextstatus="<?= $_GET['status_pembayaran_id'] + 1 ?>">
        Bayar Ulang
    </button>
    @endif
</div>
@endsection('content')


<!-- <div class="modal fade" id="" tabindex="-1" role="dialog" aria-labelledby="Label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="Label">Konfirmasi Perubahan Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{url('/rekap_interviewer/change_status')}}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id">
                    <input type="hidden" name="nextStatus">
                    <input type="hidden" name="total">
                    <input type="hidden" name="project_id" value="<?= isset($_GET['project_id']) ? $_GET['project_id'] : '' ?>">
                    <input type="hidden" name="link" value="<?= $_SERVER['REQUEST_URI'] ?>">
                    Klik Submit untuk melakukan perubahan status
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div> -->

<!-- Modal -->
<div class="modal fade" id="ajukanModal" tabindex="-1" role="dialog" aria-labelledby="ajukanModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ajukanModalLabel">Konfirmasi Perubahan Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{url('/rekap_interviewer/change_status')}}" method="POST" id="form-change-status">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id">
                    <input type="hidden" name="total">
                    <input type="hidden" name="nextStatus">
                    <input type="hidden" name="project_id" value="<?= isset($_GET['project_id']) ? $_GET['project_id'] : '' ?>">
                    <input type="hidden" name="link" value="<?= $_SERVER['REQUEST_URI'] ?>">

                    <div id="input-bayar" style="display: none;">
                        <div class="form-group">
                            <label>Status Pembayaran</label>
                            <div>
                                <section id="jenis">
                                    <input type="radio" name="status_bayar" id="success_paid" value="3" checked> <label for="success_paid"> Berhasil di Bayar</label>
                                    <br>
                                    <input type="radio" name="status_bayar" id="fail_paid" value="4"> <label for="fail_paid"> Gagal di Bayar</label>
                                </section>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ket_pembayaran">Keterangan</label>
                            <textarea class="form-control" id="ket_pembayaran" name="ket_pembayaran" rows="3"></textarea>
                        </div>
                    </div>
                    Klik Submit untuk melakukan perubahan status
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btn-submit-ajukan-modal">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>



@section('javascript')
<script>
    $(document).ready(function() {
        if ($('#project_id').val() != 'all') {
            $('.row-filter-kota').show();
        } else {
            $('.row-filter-kota').hide();
        }

        $('.card-box.table-responsive a').hide();

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
