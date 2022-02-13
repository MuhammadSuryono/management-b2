@extends('maingentelellaform')
@section('title','Edit Responden')
@section('content')
@section('action_url', url('/respondents').'/'. $respondent->id)
@method('patch')
@csrf
<?php $for_create_edit = 'edit'; ?>
@if (session('status'))
<div class="bs-example-popovers">
    <div align="center" class="alert alert-info alert-dismissible " role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
        <strong>Status Proses! </strong> {{ session('status') }}
    </div>
</div>
@elseif (session('status-fail'))
<div class="bs-example-popovers">
    <div align="center" class="alert alert-info alert-dismissible" role="alert" style="background-color: red;">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
        <strong>Status Proses! </strong> {{ session('status-fail') }}
    </div>
</div>
@endif
@include('respondents.respondents.form_respondent')
@endsection('form_content')
<!-- Modal -->
<!-- <div class="modal fade" id="formQcModal" tabindex="-1" role="dialog" aria-labelledby="formQcModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formQcModalLabel">Form QC</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ url('/respondents/store_form_qc')}}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{$respondent->id}}">

                    <div class="form-group">
                        <label for="tanggal_qc">Tanggal QC</label>
                        <input type="date" class="form-control" id="tanggal_qc" name="tanggal_qc" placeholder="" required>
                    </div>
                    <div class="form-group">
                        <label for="jam_qc">Jam QC</label>
                        <input type="time" class="form-control" id="jam_qc" name="jam_qc" placeholder="" required>
                    </div>
                    <div class="form-group">
                        <label for="jumlah_qc">Callback Ke Berapa</label>
                        <input type="number" class="form-control" id="jumlah_qc" name="jumlah_qc" placeholder="" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="jumlah_qc">Bukti Rekaman</label>
                        <div class="custom-file">
                            <input type="file" accept="audio/mp3,audio/*;capture=microphone" class="custom-file-input" name="file" id="file" required>
                            <label class="custom-file-label" for="inputGroupFile01" id="fileText">Choose file</label>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" name="button" value="tl">Submit</button>
            </div>
            </form>
        </div>
    </div>
</div> -->

<div class="modal fade" id="formPengecekanModal" tabindex="-1" role="dialog" aria-labelledby="formPengecekanModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formPengecekanModalLabel">Form Pengecekan Rekaman</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><b>Rekaman </b></p>
                <?php
                $ext = pathinfo($respondent->rekaman, PATHINFO_EXTENSION);
                $audioExt = ['mp3', 'wav', 'ogg', 'flac'];
                if (in_array($ext, $audioExt)) :
                ?>
                    <div class="text-center">
                        <audio controls>
                            <source src="{{$respondent->rekaman}}" type="audio/ogg">
                            <source src="{{$respondent->rekaman}}" type="audio/mpeg">
                            Your browser does not support the audio element.
                        </audio>
                    </div>
                <?php endif; ?>
                <p>Klik <a target="_blank" href="{{$respondent->rekaman}}" class="text-primary">disini</a> untuk mendownload</p>
                <hr>
                <br>
                <form method="post" action="{{ url('/form_pengecekan/')}}" id="form-pengecekan-rekaman">
                    @csrf
                    <input type="hidden" name="id" value="{{$respondent->id}}">
                    <?php $i = 1; ?>
                    <?php foreach ($status_pengecekan as $sp) : ?>
                        <div class="form-group">
                            <div>
                                <p><?= $i . '. ' . $sp['keterangan_gagal_pengecekan'] ?></p>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="s<?= $i ?>y" value="1" name="s<?= $i ?>">
                                    <label class="form-check-label" for="s<?= $i ?>y">Ya</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="s<?= $i ?>n" value="0" name="s<?= $i ?>">
                                    <label class="form-check-label" for="s<?= $i ?>n">Tidak</label>
                                </div>
                            </div>
                        </div>
                        <?php $i++; ?>
                    <?php endforeach; ?>
                    <div class="form-group">
                        <label for="temuan">Temuan (isi secara mendetail)</label>
                        <textarea class="form-control" id="temuan" name="temuan" rows="3"></textarea>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btn-submit-form-pengecekan" name="button" value="tl">Submit</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="warningModal" tabindex="-1" role="dialog" aria-labelledby="warningModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="warningModalLabel">Warning</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img src="{{ url('images/danger.jpg') }}" style="width: 200px; margin-left: auto; margin-right: auto;display: block;" alt="">
                <h4 style="text-align: center;">Worksheet Tidak Ditemukan</h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="logQcModal" tabindex="-1" role="dialog" aria-labelledby="logQcModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logQcModalLabel">Log Perubahan Status QC</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-1">
                            <div>
                                <b>#</b>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="text-center">
                                <b>Status QC</b>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="text-center">
                                <b>Timestamp</b>
                            </div>
                        </div>
                    </div>
                    @foreach($logQc as $lq)
                    <div class="row">
                        <div class="col-lg-1">
                            <div>
                                {{$loop->iteration}}
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div>
                                {{isset($lq->status_qc->keterangan_qc)?$lq->status_qc->keterangan_qc:'-'}}
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="text-center">
                                {{$lq->created_at}}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@section('javascript')
<script>
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
        $('#qrscan_form').prop('enctype', 'multipart/form-data');
        let dataRekaman = '<?= $dataRekaman ?>';

        $('#btn-submit-form-pengecekan').click(function() {
            const i = parseInt('<?= $i ?>') - 1;
            let globalStatus = 0;
            for (let x = 1; x <= i; x++) {
                const getInput = document.querySelectorAll(`input[name=s${x}]`);
                let status = 0;
                getInput.forEach(function(e) {
                    if (e.checked) status = 1;
                })
                if (status != 0) {
                    globalStatus++;
                }
            }
            if (globalStatus == i && $('#temuan').val()) {
                document.getElementById("form-pengecekan-rekaman").submit();
            } else {
                $('#form-pengecekan-rekaman').submit(function(e) {
                    e.preventDefault();
                })
                alert('Seluruh pertanyaan harus dijawab.');
            }
        })

        if ($('#status-pengecekan').val() != 1) {
            $('.group-status-gagal').show();
        } else {
            $('.group-status-gagal').hide();
        }

        if (!($('#btn-form-pengecekan').val() == 1 || $('#btn-form-pengecekan').val() == 2)) {
            $('#btn-form-pengecekan').prop('disabled', false);
        } else {
            $('#btn-form-pengecekan').prop('disabled', true);
        }

        $('#status_callback_id').change(function() {
            if (!($(this).val() == 1 || $(this).val() == 2)) {
                $('#btn-form-pengecekan').prop('disabled', false);
            } else {
                $('#btn-form-pengecekan').prop('disabled', true);
            }
        })

        $('button[type=submit]').click(function() {
            if ($('#status_qc_id').val() == 5 && !dataRekaman && $('#status_callback_id').val() != 1) {
                $('#qrscan_form').submit(function(e) {
                    e.preventDefault();
                })
                alert('Data Pengecekan Rekaman belum ada.');
            } else {
                $('#qrscan_form').submit(function(e) {
                    e.currentTarget.submit();
                })
            }
        });

        // const inputFile1 = $('#file');
        // inputFile1.change(function() {
        //     let string = $(this).val().split('\\');
        //     $('#fileText').text(string[string.length - 1]);
        // })

        const inputFile1 = $('#inputGroupFile01');
        inputFile1.change(function() {
            let string = $(this).val().split('\\');
            $('#inputGroupFileText01').text(string[string.length - 1]);
        })
    })
</script>
@endsection