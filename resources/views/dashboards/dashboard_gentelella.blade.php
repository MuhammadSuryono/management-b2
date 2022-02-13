@extends('maingentelella')
@section('title', 'Vendors')
@section('content')
@include('layouts.gentelella.top_tiles')

<!-- page content -->
{{--
    <div class="row">
        <div class="col-md-4 col-sm-4 col-xs-12">
            @include('dashboards/w_ses')
        </div>
        <div class="col-md-4 col-sm-4 col-xs-12">
            @include('dashboards/w_gender')
        </div>
    </div> --}}

<?php function findKey($array, $keySearch)
{
    foreach ($array as $key => $item) {
        if ($key == $keySearch) {
            return true;
        } elseif (is_array($item) && findKey($item, $keySearch)) {
            return true;
        }
    }
    return false;
} ?>

<h6 class="text-primary"><strong>Data Summary Respondent</strong></h6>
<table class="table table-hover">
    <thead>
        <tr>
            <th scope="col">Project</th>
            <th scope="col" class="text-center">Total Responden</th>
            <th scope="col" class="text-center">Responden Status OK</th>
            <th scope="col" class="text-center">Responden Status Back To Field</th>
            <th scope="col" class="text-center">Responden Status Drop Out</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($projects as $item) : ?>
            <tr>
                <?php
                $countRespondent = DB::table('respondents')->where('project_id', '=', $item['id'])->count();
                $countOk = DB::table('respondents')->whereIn('status_qc_id',  array(5, 1, 10))->where('project_id', '=', $item['id'])->count();
                $countBtf = DB::table('respondents')->where('status_qc_id', '=', '4')->where('project_id', '=', $item['id'])->count();
                $countDo = DB::table('respondents')->whereIn('status_qc_id',  array(2, 3, 6, 9))->where('project_id', '=', $item['id'])->count();
                ?>
                <td><?= isset($item->nama) ? $item->nama : '-' ?></td>
                <!-- <td><?= $item['id'] ?></td> -->
                <td class="text-center"><?= $countRespondent ?></td>
                <td class="text-center"><?= $countOk ?></td>
                <td class="text-center"><?= $countBtf ?></td>
                <td class="text-center"><?= $countDo ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="border-top border-primary my-3"></div>
<br>

<h6 class="text-primary"><strong>Data Void Respondent Gift</strong></h6>
<table class="table table-hover">
    <thead>
        <tr>
            <th class="col-9">Project</th>
            <th class="text-center col-2">Total</th>
            <th class="col-1">Detail</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($respondents_fail_paid_grouped as $item) : ?>
            <tr>
                <td><?= isset($item->nama) ? $item->nama : '-' ?></td>
                <td class="text-center"><?= isset($item->total) ? $item->total : '0' ?></td>
                <td>
                    <button class="btn btn-sm btn-primary btn-detail-gift" data-toggle="modal" data-target="#detailDataVoidModal" data-project="<?= $item['id'] ?>"> <i class="fa fa-eye"></i></button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<br>

<h6 class="text-primary"><strong>Data Pengecekan Rekaman</strong></h6>
<table class="table table-hover">
    <thead>
        <tr>
            <th class="col-9">Project</th>
            <th class="text-center col-2">Total</th>
            <th class="col-1">Detail</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data_pengecekan_grouped as $item) : ?>
            <tr>
                <td><?= isset($item->nama) ? $item->nama : '-' ?></td>
                <td class="text-center"><?= isset($item->total) ? $item->total : '0' ?></td>
                <td>
                    <button class="btn btn-sm btn-primary btn-detail-pengecekan" data-toggle="modal" data-target="#detailDataPengecekanModal" data-project="<?= $item['id'] ?>"> <i class="fa fa-eye"></i></button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<h6 class="text-primary"><strong>Data Update Tanggal QC Respondent</strong></h6>
<table class="table table-hover">
    <thead>
        <tr>
            <th class="col-9">Project</th>
            <th class="text-center col-2">Total</th>
            <th class="col-1">Detail</th>
        </tr>
    </thead>
    <tbody>
        <?php $array = [] ?>
        <?php foreach ($respondents as $r) : ?>
            <?php
            if (isset($r->tanggal_update_qc)) :
                $date1 = strtotime(date('Y-m-d h:i:s', time()));
                $date2 = strtotime($r->tanggal_update_qc);
                $diff = abs($date1 - $date2);
                $years = floor($diff / (365 * 60 * 60 * 24));
                $months = floor(($diff - $years * 365 * 60 * 60 * 24)
                    / (30 * 60 * 60 * 24));
                $days = floor(($diff - $years * 365 * 60 * 60 * 24 -
                    $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
                $hours = floor(($diff - $years * 365 * 60 * 60 * 24
                    - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24)
                    / (60 * 60));
                $now = new DateTime();

                $date = new DateTime($r->tanggal_update_qc);
                $status = $date->diff($now)->format("%R");
                $day = $date->diff($now)->format("%d");
                $hour = $date->diff($now)->format("%h");

                $batas_waktu = isset($r->batas_waktu_do) ? $r->batas_waktu_do : 5;

                if ($status == '+') {
                    if ($days >= floor($batas_waktu / 2) + 2) {
                        $statusColor = 'danger';
                    } else if ($days == floor($batas_waktu / 2) + 1) {
                        $statusColor = 'warning';
                    } else {
                        $statusColor = 'success';
                    }
                } else {
                    $statusColor  = 'danger';
                }
            ?>
                <?php if ($years == 0 && $months == 0 && $days <= $batas_waktu) {
                    if (findKey($array, $r->project->nama)) {
                        $array[$r->project->nama] += 1;
                    } else {
                        $array[$r->project->nama] = 1;
                    }
                } ?>
            <?php endif; ?>
        <?php endforeach; ?>
        <?php foreach ($array as $key => $value) : ?>
            <tr>
                <td><?= $key ?></td>
                <td class="text-center"><?= $value ?></td>
                <td>
                    <button class="btn btn-sm btn-primary btn-detail-qc" data-toggle="modal" data-target="#detailDataUpdateQcModal" data-project="<?= $key ?>"> <i class="fa fa-eye"></i></button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<!-- /page content -->

<!-- Modal -->
<div class="modal fade" id="detailDataVoidModal" tabindex="-1" role="dialog" aria-labelledby="detailDataVoidModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailDataVoidModalLabel">Data Void Respondent Gift</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Nama</th>
                            <th scope="col">Project</th>
                            <th scope="col">Kota</th>
                            <th scope="col">Keterangan Gagal</th>
                            <th scope="col">Status Perbaikan</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="detailDataPengecekanModal" tabindex="-1" role="dialog" aria-labelledby="detailDataPengecekanModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailDataPengecekanModalLabel"><a href="{{url('/form_pengecekan')}}" class="text-primary"><strong>Data Pengecekan Rekaman</strong></a><i data-toggle="tooltip" data-placement="top" title="Export to CSV pada halaman utama pengecekan rekaman untuk menghilangkan data pada dashboard" class="fa fa-fw fa-question-circle"></i></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Respondent</th>
                            <th>Project</th>
                            <th>Interviewer</th>
                            <th>Kota</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="detailDataUpdateQcModal" tabindex="-1" role="dialog" aria-labelledby="detailDataUpdateQcModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailDataUpdateQcModalLabel">Data Update QC</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Respondent</th>
                            <th>Project</th>
                            <th>Interviewer</th>
                            <th>Kota</th>
                            <th>Status QC</th>
                            <th class="text-center">Hari Diubah</th>
                            <th>Batas Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="konfirmasiModal" tabindex="-1" role="dialog" aria-labelledby="konfirmasiModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="konfirmasiModalLabel">Konfirmasi Perubahan Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{url('/respondents/change_status_perbaikan')}}" method="POST" id="form-konfirmasi">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="respondent_id">
                    <input type="hidden" name="mobilephone_temp">

                    <div class="form-group">
                        <label for="mobilephone">Nomor HP
                            <button type="button" class="btn btn-sm bg-transparent" data-toggle="tooltip" data-placement="top" title="Harap memasukkan nomor telfon yang berbeda dan bukan nomor prabayar" style="cursor: help;"> <i class="fa fa-question-circle"></i></button>
                        </label>
                        <input type="text" class="form-control" id="mobilephone" name="mobilephone"></input>
                    </div>
                    <div class="form-group" id="row-e-walet">
                        <label for="">E-Wallet</label>
                        <select name="e_wallet_kode" id="" class="form-control">
                            <option value="">Pilih E-Wallet</option>
                            <?php foreach ($e_wallet as $e) : ?>
                                <option value="<?= $e->kode ?>"><?= $e->nama ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group" id="row-status-kepemilikan">
                        <label for="">Status Kepemilikan</label>
                        <select name="status_kepemilikan_id" id="status_kepemilikan_id" class="form-control">
                            <option value="">Pilih Status Kepemilikan</option>
                            <?php foreach ($status_kepemilikan as $sk) : ?>
                                <option value="<?= $sk->id ?>"><?= $sk->keterangan_kepemilikan ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group" id="row-pemilik-ewallet">
                        <label for="pemilik_mobilephone">Nama Pemilik E-Wallet</label>
                        <input type="text" class="form-control" id="pemilik_mobilephone" name="pemilik_mobilephone"></input>
                    </div>

                    <div class="border-top border-primary my-3"></div>

                    <div class="form-group">
                        <label for="norek">Nomor Rekening</label>
                        <input type="text" class="form-control" id="norek" name="norek"></input>
                    </div>
                    <div class="form-group" id="row-bank">
                        <label for="">Bank</label>
                        <select name="kode_bank" id="" class="form-control">
                            <option value="">Pilih Bank</option>
                            <?php foreach ($bank as $b) : ?>
                                <option value="<?= $b->kode ?>"><?= $b->nama ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="pemilik_rekening">Nama Pemilik Rekening</label>
                        <input type="text" class="form-control" id="pemilik_rekening" name="pemilik_rekening"></input>
                    </div>
                    Klik Submit untuk melakukan perubahan status
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btn-submit-konfirmasi">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection('content')



@section('javascript')
<script>
    $(document).on('click', '.btn-konfirmasi', function() {
        $('input[name=respondent_id]').val($(this).data('id'));
        $('input[name=mobilephone]').val($(this).data('mobilephone'));
        $('input[name=mobilephone_temp]').val($(this).data('mobilephone'));
        $('input[name=norek]').val($(this).data('norek'));
        $('input[name=pemilik_rekening]').val($(this).data('pemilik_rekening'));
        $(`#row-bank option[value=${$(this).data('bank')}]`).attr('selected', 'selected');
        $(`#row-e-walet option[value=${$(this).data('wallet')}]`).attr('selected', 'selected');
        $(`#row-status-kepemilikan option[value=${$(this).data('kepemilikan')}]`).attr('selected', 'selected');
        if ($(this).data('kepemilikan') == 1) {
            $('#row-pemilik-ewallet').hide()
            $('#row-pemilik-ewallet').val('')
        } else {
            $('#row-pemilik-ewallet').show()
            $('input[name=pemilik_mobilephone]').val($(this).data('pemilik_mobilephone'))
        }
    })

    $(document).on('click', '#btn-submit-konfirmasi', function() {
        if ($('input[name=mobilephone_temp]').val() == $('input[name=mobilephone]').val()) {
            alert('Nomor telfon yang dimasukkan tidak boleh sama dengan sebelumnya');
        } else {
            if (($('input[name=mobilephone]').val()).charAt(0) != '0') {
                alert('Pastikan yang anda masukkan nomor telfon');
            } else {
                $('#form-konfirmasi').submit();
            }
        }
    })
    $(document).ready(function() {
        $('#status_kepemilikan_id').change(function() {
            if ($(this).val() == 1) {
                $('#row-pemilik-ewallet').hide()
                $('#row-pemilik-ewallet').val('')
            } else {
                $('#row-pemilik-ewallet').show()
                $('input[name=pemilik_mobilephone]').val($(this).data('pemilik_mobilephone'))
            }
        })

        $('.btn-detail-gift').click(function() {
            const id = $(this).data('project');
            $.ajax({
                url: "{{url('respondent_gift/get_data_void')}}",
                type: "GET",
                data: {
                    'id': id,
                },
                success: function(result) {
                    console.log(result);
                    $('#detailDataVoidModal tbody').html(result)
                }
            })
        })

        $('.btn-detail-pengecekan').click(function() {
            const id = $(this).data('project');
            $.ajax({
                url: "{{url('form_pengecekan/get_data_pengecekan')}}",
                type: "GET",
                data: {
                    'id': id,
                },
                success: function(result) {
                    // console.log(JSON.parse(result));
                    $('#detailDataPengecekanModal tbody').html(result)
                }
            })
        })

        $('.btn-detail-qc').click(function() {
            const project = $(this).data('project');
            $.ajax({
                url: "{{url('form_qc/get_data_update_qc')}}",
                type: "GET",
                data: {
                    'project': project,
                },
                success: function(result) {
                    // console.log(result);
                    $('#detailDataUpdateQcModal tbody').html(result)
                }
            })
        })

        $('.card-box.table-responsive a').hide();
    });
</script>
@endsection