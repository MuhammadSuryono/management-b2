@extends('maingentelellatable')
@section('title', 'Daftar Responden' )
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
                            <input type="hidden" name="status_pembayaran_id" value="<?= $_GET['status_pembayaran_id'] ?>">
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
                                                <label class="col-form-label col-md-2 col-sm-2" for="tanggal_mulai_pengajuan">Tanggal Pengajuan</label>
                                                <div class="col-md-4 col-sm-5">
                                                    <input type="date" class="form-control" name="tanggal_mulai_pengajuan" value="<?= (isset($_GET['tanggal_mulai_pengajuan']) ? $_GET['tanggal_mulai_pengajuan'] : '') ?>">
                                                </div>
                                                <p>s/d</p>
                                                <div class="col-md-4 col-sm-5">
                                                    <input type="date" class="form-control" name="tanggal_selesai_pengajuan" value="<?= (isset($_GET['tanggal_selesai_pengajuan']) ? $_GET['tanggal_selesai_pengajuan'] : '') ?>">
                                                </div>
                                                <button type="button" class="fa fa-times btn btn-sm btn-reset-tanggal-pengajuan text-danger"></button>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-form-label col-md-2 col-sm-2" for="tanggal_mulai_pembayaran">Tanggal Pembayaran</label>
                                                <div class="col-md-4 col-sm-5">
                                                    <input type="date" class="form-control" name="tanggal_mulai_pembayaran" value="<?= (isset($_GET['tanggal_mulai_pembayaran']) ? $_GET['tanggal_mulai_pembayaran'] : '') ?>">
                                                </div>
                                                <p>s/d</p>
                                                <div class="col-md-4 col-sm-5">
                                                    <input type="date" class="form-control" name="tanggal_selesai_pembayaran" value="<?= (isset($_GET['tanggal_selesai_pembayaran']) ? $_GET['tanggal_selesai_pembayaran'] : '') ?>">
                                                </div>
                                                <button type="button" class="fa fa-times btn btn-sm btn-reset-tanggal-pembayaran text-danger"></button>
                                            </div>
                                        </div>
                                        <input type="hidden" id="link_from" name="link_from" value="{{session('link_from')}}">
                                    </div>

                                </div>
                                <div align="center" class="form-group">
                                    <!-- <a href="{{url()->current()}}" type="button" class="btn btn-info text-white"> Reset </a> -->
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
$totalAktual = 0;
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
    $totalAktual += $item['total_aktual'];
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
                            @if($_GET['status_pembayaran_id'] != 3)
                            <div align="center" class="col-md-6 col-sm-12 col-xs-12 tile_stats_count">
                                <a href=""> <span class="count_top "><b> Total Keseluruhan </b></span>
                                    <div class="count" style="color: green">Rp. <?= number_format($totalKeseluruhan) ?></div>
                                </a>
                            </div>
                            <div align="center" class="col-md-6 col-sm-12 col-xs-12 tile_stats_count">
                                <a href=""> <span class="count_top "><b> Total Data </b></span>
                                    <div class="count" style="color: green"><?= count($respondents) ?></div>
                                </a>
                            </div>
                            @else
                            <div align="center" class="col-md-4 col-sm-12 col-xs-12 tile_stats_count">
                                <a href=""> <span class="count_top "><b> Total Keseluruhan </b></span>
                                    <div class="count" style="color: green">Rp. <?= number_format($totalKeseluruhan) ?></div>
                                </a>
                            </div>
                            <div align="center" class="col-md-4 col-sm-12 col-xs-12 tile_stats_count">
                                <a href=""> <span class="count_top "><b> Total Aktual </b></span>
                                    <div class="count" style="color: green">Rp. <?= number_format($totalAktual) ?></div>
                                </a>
                            </div>
                            <div align="center" class="col-md-4 col-sm-12 col-xs-12 tile_stats_count">
                                <a href=""> <span class="count_top "><b> Total Data </b></span>
                                    <div class="count" style="color: green"><?= count($respondents) ?></div>
                                </a>
                            </div>
                            @endif
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
        @if($_GET['status_pembayaran_id'] == 3)
        <th>Total Aktual</th>
        @endif
        <th>Status</th>
        <th>Keterangan</th>
        <th>Pembayaran Via</th>
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

        @if($_GET['status_pembayaran_id'] == 3)
        <td>
            @if(isset($item->total_aktual))
            Rp. {{number_format($item->total_aktual)}}
            @else
            Kosong
            @endif
        </td>
        @endif
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
            @if(isset($item->pembayaran_via))
            {{$item->pembayaran_via}}
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
<?php if (isset($_GET['project_imported_id'])) : ?>
    <!-- <button href="" class="btn btn-primary ml-3 insert-bpu" data-project_id="<?= $_GET['project_imported_id'] ?>" data-toggle="modal" data-target="#insertBpuModal">Insert BPU</button>
    <button href="" class="btn btn-primary ml-3 update-bpu" data-project_id="<?= $_GET['project_imported_id'] ?>" data-toggle="modal" data-target="#updateBpuModal">Update Status BPU</button> -->
    <!-- <button></button> -->
<?php endif; ?>
@endsection('content')

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
            <form action="{{url('/respondent_gift/change_status')}}" method="POST" id="form-change-status">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id">
                    <input type="hidden" name="nextStatus">
                    <input type="hidden" name="link" value="<?= $_SERVER['REQUEST_URI'] ?>">
                    <div id="ajukan-bayar" style="display: none;">
                        <div class="form-group">
                            <label>Pembayaran Via</label>
                            <div>
                                <input type="radio" name="pembayaran_via" id="pembayaran_via_pulsa" value="Pulsa" checked> <label for="pembayaran_via_pulsa"> Pulsa</label>
                                <br>
                                <input type="radio" name="pembayaran_via" id="pembayaran_via_ewallet" value="E-wallet"> <label for="pembayaran_via_ewallet"> E-wallet</label>
                                <br>
                                <input type="radio" name="pembayaran_via" id="pembayaran_via_transfer" value="Transfer"> <label for="pembayaran_via_transfer"> Transfer</label>
                            </div>
                        </div>
                    </div>
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

                        <div class="form-group row-total-aktual" style="display: none;">
                            <label for="total_aktual">Total Aktual</label>
                            <input type="int" class="form-control" id="total_aktual" name="total_aktual">
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


<div class="modal fade" id="insertBpuModal" tabindex="-1" role="dialog" aria-labelledby="insertBpuModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="insertBpuModalLabel">Buat BPU</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{url('/respondent_gift/insert_bpu')}}" method="POST" id="form-insert-bpu">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="project_imported_id" value="<?= isset($_GET['project_imported_id']) ? $_GET['project_imported_id'] : '' ?>">
                    <div class="form-group">
                        <label>Pilih Tanggal Pengajuan</label>
                        <select name="tanggal_pengajuan" class="form-control" id="">
                            <?php foreach ($tanggalPengajuan as $item) : ?>
                                <option value="<?= $item->tanggal_pengajuan ?>"><?= $item->tanggal_pengajuan ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="btn-submit-insert-bpu">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="updateBpuModal" tabindex="-1" role="dialog" aria-labelledby="updateBpuModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateBpuModalLabel">Update Status Bayar BPU</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{url('/respondent_gift/update_bpu')}}" method="POST" id="form-update-bpu">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="project_imported_id" value="<?= isset($_GET['project_imported_id']) ? $_GET['project_imported_id'] : '' ?>">
                    <div class="form-group">
                        <label>Pilih Tanggal Pengajuan</label>
                        <select name="tanggal_pengajuan" class="form-control" id="">
                            <?php foreach ($tanggalPembayaran as $item) : ?>
                                <option value="<?= $item->tanggal_pengajuan ?>"><?= $item->tanggal_pengajuan ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="btn-submit-update-bpu">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>


@section('javascript')
<script>
    if ($('input[name=status_bayar]').val() == 3) {
        $('.row-total-aktual').show();
    } else {
        $('.row-total-aktual').hide();
    }

    $(document).on('ready', function() {
        $('.btn-reset-tanggal-pengajuan').click(function() {
            $('input[name=tanggal_mulai_pengajuan]').val('');
            $('input[name=tanggal_selesai_pengajuan]').val('');
        })
        $('.btn-reset-tanggal-pembayaran').click(function() {
            $('input[name=tanggal_mulai_pembayaran]').val('');
            $('input[name=tanggal_selesai_pembayaran]').val('');
        })

        $('input[name=status_bayar]').change(function() {
            if ($(this).val() == 3) {
                $('.row-total-aktual').show();
            } else {
                $('.row-total-aktual').hide();
            }
        })

        // $('.insert-bpu').click(function() {
        //     const project_id = $(this).data('project_id');
        //     $.ajax({
        //         url: "{{url('respondent_gift/insert_bpu')}}",
        //         type: "POST",
        //         dataType: "json",
        //         data: {
        //             _token: "{{ csrf_token() }}",
        //             project_id: project_id
        //         },
        //         success: function(hasil) {

        //         }
        //     });
        // })
    })

    $('body').on('click', '.btn-ajukan', function() {
        const nextStatus = $(this).data('nextstatus');
        $('input[name=id]').val($(this).data('id'));

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

    $('body').on('click', '#btn-submit-ajukan-modal', function() {
        let getChecked = $('input[name="status_bayar"]:checked').val();
        $('#form-change-status').submit();
        // if (getChecked == 4) {
        //     if ($('#ket_pembayaran').val() == '') {
        //         alert('Harap isi keterangan');
        //     } else {
        //         $('#form-change-status').submit();
        //     }
        // } else if (getChecked == 3) {
        //     if ($('#total_aktual').val() == '') {
        //         alert('Harap isi Total Aktual');
        //     } else {
        //         $('#form-change-status').submit();
        //     }
        // } else {
        //     $('#form-change-status').submit();
        // }
    })

    $(document).ready(function() {
        $('.card-box.table-responsive a').hide();
    });
</script>
@endsection
