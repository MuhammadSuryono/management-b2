@extends('maingentelellatable')
@section('title', 'Daftar Responden : ' . $respondents->count())
@section('content')

{{-- Standard Table TOP --}}
@include('layouts/gentelella/table_top')
{{-- End of Standard table TOP --}}


<?php
$totalData = ($respondents) ? count($respondents) : 0;

$targetQc = ceil($totalData * 0.3);
$persentaseTargetQc = ($totalData) ? number_format((float)($targetQc / $totalData), 2, '.', '') : 0;


$witness = 0;
$aktualStatusQc1 = 0;
$aktualStatusQc2 = 0;
$aktualStatusQc3 = 0;
foreach ($respondents as $r) {
    if ($r['pewitness']) $witness++;
    if ($r['status_qc_id'] == 2) $aktualStatusQc2++;
    else if ($r['status_qc_id'] == 4) $aktualStatusQc3++;
}
if (($aktualStatusQc2 + $aktualStatusQc1 + $aktualStatusQc3) == 0) {
    $persentaseStatusQc2 = 0;
    $persentaseStatusQc3 = 0;
} else {
    $persentaseStatusQc2 = ($totalData) ? number_format((float)($aktualStatusQc2 / $totalData), 2, '.', '') : 0;
    $persentaseStatusQc3 = ($totalData) ? number_format((float)($aktualStatusQc3 / $totalData), 2, '.', '') : 0;
}
$persentaseWitness = ($totalData) ? number_format((float)($witness / $totalData), 2, '.', '') : 0;
$belumQc = (($targetQc - $witness - $aktualStatusQc3) > 0) ? ($targetQc - $witness - $aktualStatusQc3) : 0;
$persentaseBelumQc = ($totalData) ? number_format((float)($belumQc / $totalData), 2, '.', '') : 0;
?>

{{-- Filter --}}
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
                            <div align="center" class="col-md-2 col-sm-3 col-xs-3 tile_stats_count">
                                <a href=""> <span class="count_top "><b> Total Data </b></span>
                                    <div class="count " style="color: green"><?= ($totalData) ?></div>
                                </a>
                                <hr>
                                <a href=""> <span class="count_top "><b> </b></span>
                                    <div class="count " style="color: green"><?= ($totalData) ? "100" : "0" ?>%</div>
                                </a>
                            </div>
                            <div align="center" class="col-md-2 col-sm-3 col-xs-3 tile_stats_count">
                                <a href=""> <span class="count_top "><b> Target QC </b></span>
                                    <div class="count " style="color: green"><?= $targetQc ?></div>
                                </a>
                                <hr>
                                <a href=""> <span class="count_top "><b> </b></span>
                                    <div class="count " style="color: green"><?= $persentaseTargetQc * 100 ?>%</div>
                                </a>
                            </div>
                            <div align="center" class="col-md-2 col-sm-3 col-xs-3 tile_stats_count">
                                <a href=""> <span class="count_top "><b> Witness </b></span>
                                    <div class="count " style="color: green"><?= $witness ?></div>
                                </a>
                                <hr>
                                <a href=""> <span class="count_top "><b> </b></span>
                                    <div class="count " style="color: green"><?= $persentaseWitness * 100 ?>%</div>
                                </a>
                            </div>
                            <div align="center" class="col-md-2 col-sm-3 col-xs-3 tile_stats_count">
                                <a href=""> <span class="count_top "><b> Lolos QC </b></span>
                                    <div class="count " style="color: green"><?= $aktualStatusQc3 ?></div>
                                </a>
                                <hr>
                                <a href=""> <span class="count_top "><b> </b></span>
                                    <div class="count " style="color: green"><?= $persentaseStatusQc3 * 100 ?>%</div>
                                </a>
                            </div>
                            <div align="center" class="col-md-2 col-sm-3 col-xs-3 tile_stats_count">
                                <a href="projects"> <span class="count_top "> <b>Drop Out </b></span>
                                    <div class="count " style="color: green"><?= $aktualStatusQc2 ?></div>
                                </a>
                                <hr>
                                <a href=""> <span class="count_top "><b> </b></span>
                                    <div class="count " style="color: green"><?= $persentaseStatusQc2 * 100 ?>%</div>
                                </a>
                            </div>
                            <div align="center" class="col-md-2 col-sm-3 col-xs-3 tile_stats_count">
                                <a href="teams"> <span class="count_top "> <b>Belum di QC </b></span>
                                    <div class="count " style="color: green"><?= $belumQc ?></div>
                                </a>
                                <hr>
                                <a href=""> <span class="count_top "><b> </b></span>
                                    <div class="count " style="color: green"><?= $persentaseBelumQc * 100 ?>%</div>
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

<thead>
    <tr>
        <th>No.</th>
        <th>Nama</th>
        <th>Gender</th>
        <th>Kota</th>
        <th>Kelurahan</th>
        @if(count($user_role)>0)
        <th>HP</th>
        @endif
        <th>Interviewer</th>
        <th>Pewitness</th>
        <th>Status QC</th>
        <th>Keterangan QC</th>

        <!-- Primary -->
        <th>Last Update QC</th>
        <th>Last Update QC By</th>
        @if(count($user_role)>0)
        <th>Email</th>
        @endif
        <th>Usia</th>
        <th>Pendidikan</th>
        <th>Pekerjaan</th>
        <th>Jam Mulai</th>
        <th>Jam Selesai</th>
        <th>Tanggal Interview</th>
        <th>Link Rekaman</th>
        <th>Keterangan Rekaman</th>
        <th>Evaluasi Witness</th>
        <th>Status Callback</th>
        <th>Keterangan Callback</th>
        <th>SES</th>
        <th>Valid</th>
        <th>Last Update</th>
        <th>Update oleh</th>
        <th>Action</th>
    </tr>
</thead>
<tbody>
    @foreach ($respondents as $respondent)
    <tr>
        <th scope='row'>{{$loop->iteration}}</th>
        <td>{{$respondent->respname}}</td>
        <td>{{$respondent->gender->gender}}</td>
        <td>
            @if(isset($respondent->kota->kota))
            {{$respondent->kota->kota}}
            @endif
        </td>
        <td>
            @if(isset($respondent->kelurahan->kelurahan))
            {{$respondent->kelurahan->kelurahan}}
            @endif
        </td>
        @if(count($user_role)>0)
        <td>{{$respondent->mobilephone}}</td>
        @endif
        <td>
            <?php
            if ($respondent->srvyr) {
                $pwt = DB::table('teams')->where('id', $respondent->srvyr)->first();
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
        <td>
            <?php
            if ($respondent->pewitness) {
                $pwt = DB::table('teams')->where('id', $respondent->pewitness)->first();
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
        <td>
            @if(isset($respondent->status_qc->keterangan_qc))
            {{$respondent->status_qc->keterangan_qc}}
            @else
            Kosong
            @endisset
        </td>
        <td>
            @if(isset($respondent->keterangan_qc))
            {{$respondent->keterangan_qc}}
            @else
            Kosong
            @endisset
            <!-- <button class='btn btn-primary btn-sm btn-modal' id="qcButton" type="button" data-toggle="modal" data-target="#keteranganQCModal" data-id="{{$respondent->id}}" data-value="{{$respondent->keterangan_qc}}" value="qc"><i class="fa fa-edit"></i></button> -->
        </td>
        <td>
            @if(isset($respondent->tanggal_update_qc))
            {{$respondent->tanggal_update_qc}}
            @else
            Kosong
            @endisset
        </td>
        <td>
            <?php
            if ($respondent->id_user_qc) {
                $user = DB::table('teams')->where('id', $respondent->id_user_qc)->first();
                if ($user) {
                    echo $user->nama;
                } else {
                    echo "Kosong";
                }
            } else {
                echo "Kosong";
            }
            ?>
        </td>
        @if(count($user_role)>0)
        <td>
            @if(isset($respondent->email))
            {{$respondent->email}}
            @endif
        </td>
        @endif
        <td>{{$respondent->usia + date('Y') - date_format(date_create($respondent->intvdate),'Y' )   }}</td>
        <td>
            @if(isset($respondent->pendidikan->pendidikan))
            {{$respondent->pendidikan->pendidikan}}
            @else
            Kosong
            @endisset
        </td>
        <td>
            @if(isset($respondent->pekerjaan->pekerjaan))
            {{$respondent->pekerjaan->pekerjaan}}
            @else
            Kosong
            @endisset
        </td>
        <td>{{$respondent->vstart}}</td>
        <td>{{$respondent->vend}}</td>
        <td>{{$respondent->intvdate}}</td>
        <td>
            @if(($respondent->rekaman))
            <a href="{{$respondent->rekaman}}" target="_blank" rel="noopener noreferrer">{{$respondent->rekaman}}</a>
            @else
            Kosong
            @endif
        </td>
        <td>
            @if(isset($respondent->cek_rekaman))
            {{$respondent->cek_rekaman}}
            @else
            Kosong
            @endisset
            <!-- <button class='btn btn-primary btn-sm btn-modal' id="keteranganButton" type="button" data-toggle="modal" data-target="#keteranganRekamanModal" data-id="{{$respondent->id}}" data-value="{{$respondent->cek_rekaman}}" value="rekaman"><i class="fa fa-edit"></i></button> -->
        </td>
        <td>
            @if($respondent->pewitness)
            <button class='btn btn-primary btn-sm btn-modal' id="evaluasiButton" type="button" data-toggle="modal" data-target="#evaluasiModal" data-id="{{$respondent->id}}"><i class="fa fa-edit"></i></button>
            @endif
        </td>
        <td>
            @if(isset($respondent->status_callback->keterangan_callback))
            {{$respondent->status_callback->keterangan_callback}}
            @else
            Kosong
            @endisset
        </td>
        <td>
            @if(isset($respondent->callback))
            {{$respondent->callback}}
            @else
            Kosong
            @endisset
            <!-- <button class='btn btn-primary btn-sm btn-modal' id="callbackButton" type="button" data-toggle="modal" data-target="#keteranganCallbackModal" data-id="{{$respondent->id}}" data-value="{{$respondent->callback}}" value="callback"><i class="fa fa-edit"></i></button> -->
        </td>

        <td>

            @if(isset($respondent->ses_final->ses_final))
            {{$respondent->ses_final->ses_final}}
            @else
            Kosong
            @endisset
        </td>

        <td>
            @if(isset($respondent->is_valid->is_valid))
            {{$respondent->is_valid->is_valid}}
            @else
            Kosong
            @endisset
        </td>
        <td>
            @if(isset($respondent->updated_at))
            {{$respondent->updated_at}}
            @else
            Kosong
            @endisset
        </td>
        <td>
            @if(isset($respondent->updated_by->user_login))
            {{$respondent->updated_by->user_login}}
            @endif
        </td>
        <td>
            <a href="{{ url('/respondents/')}}/{{$respondent->id}}/edit" class='btn btn-primary btn-sm' target="_blank" data-value="<?= url()->full(); ?>"><i class="fa fa-edit"></i></a>
            <a href="{{ url('/respondents/')}}/delete/{{$respondent->id}}" class='btn btn-danger btn-sm'><i class="fa fa-trash-o"></i></a>
        </td>
    </tr>
    @endforeach
</tbody>

{{-- Standard Table Bottom --}}
@include('layouts/gentelella/table_bottom')
{{-- End of Standard table Bottom --}}

</div>

</div>
</div>
</div>
</div>
@endsection('content')

<!-- Modal -->
<div class="modal fade" id="keteranganRekamanModal" tabindex="-1" role="dialog" aria-labelledby="keteranganRekamanModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="keteranganRekamanModalLabel">Keterangan Rekaman</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- <form method="post" action="{{ url('/respondents/store_keterangan_rekaman')}}"> -->
                <!-- <form> -->
                @csrf
                <input type="hidden" class="hidden" name="id">
                <div class="form-group">
                    <label for="keteranganRekaman">Keterangan</label>
                    <textarea class="form-control inputModal" id="keteranganRekaman" name="keteranganRekaman" rows="3"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button class="btn btn-primary submit" id="submitRekaman" name="button">Submit</button>
            </div>
            <!-- </form> -->
        </div>
    </div>
</div>

<div class="modal fade" id="keteranganCallbackModal" tabindex="-1" role="dialog" aria-labelledby="keteranganCallbackModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="keteranganCallbackModalLabel">Keterangan Callback</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- <form method="post" action="{{ url('/respondents/store_keterangan_callback')}}"> -->
                @csrf
                <input type="hidden" class="hidden" name="id">
                <input type="hidden" class="hiddenLink" name="link">
                <div class="form-group">
                    <label for="keteranganCallback">Keterangan</label>
                    <textarea class="form-control inputModal" id="keteranganCallback" name="keteranganCallback" rows="3"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary submit" id="submitCallback" name="button">Submit</button>
            </div>
            <!-- </form> -->
        </div>
    </div>
</div>
<div class="modal fade" id="keteranganQCModal" tabindex="-1" role="dialog" aria-labelledby="keteranganQCModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="keteranganQCModalLabel">Keterangan QC</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- <form method="post" action="{{ url('/respondents/store_keterangan_QC')}}"> -->
                @csrf
                <input type="hidden" class="hidden" name="id">
                <input type="hidden" class="hiddenLink" name="link">
                <div class="form-group">
                    <label for="keteranganQC">Keterangan</label>
                    <textarea class="form-control inputModal" id="keteranganQC" name="keteranganQC" rows="3"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary submit" id="submitQC" name="button">Submit</button>
            </div>
            <!-- </form> -->
        </div>
    </div>
</div>

<div class="modal fade" id="evaluasiModal" tabindex="-1" role="dialog" aria-labelledby="evaluasiModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="evaluasiModalLabel">Point Evaluasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body body-evaluasiModal">
                <!-- <form method="post" action="{{ url('/respondents/store_keterangan_QC')}}"> -->
                @csrf
                <input type="hidden" class="hidden" name="id">
                <input type="hidden" class="hiddenLink" name="link">
                <div class="form-group">
                    <label for="evaluasi1">Proses interview secara keseluruhan(pengusaan materi dalam kuesioner)</label>
                    <input type="hidden" name="evaluasiPert[]" value="Proses interview secara keseluruhan(pengusaan materi dalam kuesioner)">
                    <textarea class="form-control evaluasiJaw" id="evaluasi1" name="evaluasiJaw[]" rows="3" required></textarea>
                </div>
                <div class="form-group">
                    <label for="evaluasi2">Proses pemberian showcard dan dropcard</label>
                    <input type="hidden" name="evaluasiPert[]" value="Proses pemberian showcard dan dropcard">
                    <textarea class="form-control evaluasiJaw" id="evaluasi2" name="evaluasiJaw[]" rows="3" required></textarea>
                </div>
                <div class="form-group">
                    <label for="evaluasi3">Gestur/mimik interviewer</label>
                    <input type="hidden" name="evaluasiPert[]" value="Gestur/mimik interviewer">
                    <textarea class="form-control evaluasiJaw" id="evaluasi3" name="evaluasiJaw[]" rows="3" required></textarea>
                </div>
                <div class="form-group">
                    <label for="evaluasi4">Kemampuan menggali jawaban untuk pertanyaan terbuka (open end)</label>
                    <input type="hidden" name="evaluasiPert[]" value="Kemampuan menggali jawaban untuk pertanyaan terbuka (open end)">
                    <textarea class="form-control evaluasiJaw" id="evaluasi4" name="evaluasiJaw[]" rows="3" required></textarea>
                </div>
                <div class="form-group">
                    <label for="evaluasi5">Kemampuan interviewer dalam membuat responden nyaman dalam tanya jawab</label>
                    <input type="hidden" name="evaluasiPert[]" value="Kemampuan interviewer dalam membuat responden nyaman dalam tanya jawab">
                    <textarea class="form-control evaluasiJaw" id="evaluasi5" name="evaluasiJaw[]" rows="3" required></textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <button class="btn btn-sm btn-success float-right" id="addPoint"><i class="fa fa-plus"></i> Tambah</button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary evaluasiModalButton" id="evaluasiModalButton" name="">Submit</button>
            </div>
            <!-- </form> -->
        </div>
    </div>
</div>

@section('javascript')
<script>
    $(document).ready(function() {
        $(document).on('click', '.btn-modal', function() {
            const id = $(this).data('id');
            const val = $(this).data('value');
            let _token = $('input[name="_token"]').val();
            $('.hidden').val(id);
            $('.hiddenLink').val(document.URL);
            $('.inputModal').val(val);

            if ($(this).val() == 'rekaman') {
                $(document).on('click', '#submitRekaman', function() {
                    const newVal = $('#keteranganRekaman').val();
                    $.ajax({
                        url: "{{url('/respondents/store_keterangan_rekaman')}}",
                        type: "post",
                        data: {
                            'id': id,
                            'value': newVal,
                            '_token': _token
                        },
                        success: function(result) {
                            console.log(result);
                            location.reload();
                            sessionStorage.removeItem('status');
                        }
                    })
                })
            } else if ($(this).val() == 'callback') {
                $(document).on('click', '#submitCallback', function() {
                    const newVal = $('#keteranganCallback').val();
                    $.ajax({
                        url: "{{url('/respondents/store_keterangan_callback')}}",
                        type: "post",
                        data: {
                            'id': id,
                            'value': newVal,
                            '_token': _token
                        },
                        success: function(result) {
                            console.log(result);
                            location.reload();
                        }
                    })
                })
            } else if ($(this).val() == 'qc') {
                $(document).on('click', '#submitQC', function() {
                    const newVal = $('#keteranganQC').val();
                    $.ajax({
                        url: "{{url('/respondents/store_keterangan_qc')}}",
                        type: "post",
                        data: {
                            'id': id,
                            'value': newVal,
                            '_token': _token
                        },
                        success: function(result) {
                            console.log(result);
                            location.reload();;
                        }
                    })
                })
            }

        });

        $(document).on('click', '#evaluasiButton', function() {
            $('.evaluasiJaw').val('');
            const id = $(this).data('id');
            let _token = $('input[name="_token"]').val();

            $.ajax({
                url: "{{url('/respondents/get_evaluasi')}}",
                type: "get",
                data: {
                    'id': id
                },
                success: function(result) {
                    const elementJawaban = $('.evaluasiJaw');
                    console.log(result);
                    if (result.evaluasi_jawaban) {
                        for (let i = 0; i < result.evaluasi_jawaban.length; i++) {
                            if (i < 5) {
                                $(elementJawaban[i]).val(result.evaluasi_jawaban[i]);
                            } else {
                                const html = `
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                            <label for="">${result.evaluasi_pertanyaan[i]} <span style="position: absolute; top: 0; right: 12px;"><a type="button" class="fa fa-minus" style="color: red; text-decoration: none;"></a></span></label>
                                            <textarea class="form-control" id="" name="evaluasiJaw[]" rows="3" required>${result.evaluasi_jawaban[i]}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    `

                                $('.body-evaluasiModal').append(html);
                            }
                        }
                    }
                }
            });

            $(document).on('click', '#evaluasiModalButton', function() {
                let valuesJaw = $("[name='evaluasiJaw[]']")
                    .map(function() {
                        return $(this).val();
                    }).get();

                let valuesPert = $("[name='evaluasiPert[]']")
                    .map(function() {
                        return $(this).val();
                    }).get();

                // if (values.length % 2 == 0) {

                $.ajax({
                    url: "{{url('/respondents/store_evaluasi')}}",
                    type: "post",
                    data: {
                        'id': id,
                        'valuesJaw': valuesJaw,
                        'valuesPert': valuesPert,
                        '_token': _token
                    },
                    success: function(result) {
                        console.log(result);
                        location.reload();
                    }
                })
                // } 
            })
        })


        $(document).on('click', '#addPoint', function() {
            const html = `
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                    <label for="">Parameter Tambahan <span style="position: absolute; top: 0; right: 12px;"><a type="button" class="fa fa-minus" style="color: red; text-decoration: none;"></a></span></label>
                    <input type="email" class="form-control" name="evaluasiPert[]" placeholder="" required>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                    <label for="">Evaluasi Tambahan</label>
                    <textarea class="form-control" id="" name="evaluasiJaw[]" rows="3" required></textarea>
                    </div>
                </div>
            </div>
            `

            $('.body-evaluasiModal').append(html);
        })

        setInterval(function() {
            buttonDelete = document.querySelectorAll(".fa-minus");
            buttonDelete.forEach(function(e, i) {
                e.addEventListener('click', function() {
                    e.parentElement.parentElement.parentElement.parentElement.parentElement.remove();
                });
            });

        }, 1000);

    });
</script>
@endsection