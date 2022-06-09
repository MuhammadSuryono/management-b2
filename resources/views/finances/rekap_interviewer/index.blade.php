@extends('maingentelellatable')
@section('title', 'Daftar Interviewer : ' . count($teams))


@section('content')

<h3 class="d-block text-center text-primary">Rekap Interviewer: Pengajuan</h3>
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
                        <p>1. Pilih Filter project dan kota terlebih dahulu untuk melihat detail honor dan melakukan pembayaran</p>
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

                        <form class="form-horizontal form-label-left" method="get" action="{{url('/rekap_interviewer')}}">
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

                                            @if(isset($_GET['project_id']))
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
                                            @endif
                                            <input type="hidden" id="link_from" name="link_from" value="{{session('link_from')}}">

                                        </div>

                                    </div>
                                    <div align="center" class="form-group">
                                        <!-- <a href="{{url()->current()}}" type="button" class="btn btn-info text-white"> Reset </a> -->
                                        <button type="submit" class="btn btn-info"> Show </button>
                                        <?php
                                        $request = isset($_SERVER['QUERY_STRING']) ? ltrim($_SERVER['QUERY_STRING'], !empty($_SERVER['QUERY_STRING']))  : '';
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
                                    <div class="count total-keseluruhan" style="color: green">Rp. <?= number_format($totalKeseluruhan) ?></div>
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

<form action="{{url('/rekap_interviewer/change_status')}}" method="POST" id="form-change-status">
    @csrf
    @include('layouts.gentelella.table_top')

    <thead>
        <tr class="text-center">
            <th>No</th>
            <th>Nama</th>
            <th>Kota Asal</th>
            <th>Bank</th>
            <th>Nomor Rekening</th>
            @if(isset($_GET['project_id']))
            <!-- <th>Target Perolehan</th> -->
            @endif
            <th>Total Respondent</th>
            <th>Respondent OK</th>
            <!-- <th>Respondent BTF</th> -->
            @if(isset($honor_category))
            @foreach($honor_category as $hc)
            <th>{{ucwords($hc->nama_honor)}} @<?= number_format($hc->honor) ?></th>
            @endforeach
            @endif
            <th>Responden DO</th>
            @if(isset($honor_do_category))
            @foreach($honor_do_category as $hc)
            <th>DO {{ucwords($hc->nama_honor_do)}} @<?= number_format($hc->honor_do) ?></th>
            @endforeach
            @endif
            @if(isset($_GET['project_id']))
            <th>Honor Briefing</th>
            <th>Total</th>
            <th>Action</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @foreach ($teams as $item)
        <?php $total = 0; ?>
        <tr class="{{$item->bg_color ?? ''}}" title="{{$item->is_can_marking ? '':'Lengkapi data rekening'}}">
            <th scope='row'>{{$loop->iteration}}</th>
            <td>{{$item->nama ?? ''}}</td>
            <td>{{$item->kota->kota ?? ''}}</td>
            <td>{{$item->bank ?? ''}}</td>
            <td>{{$item->nomor_rekening ?? ''}}</td>
            <td class="text-center">
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
            <td class="text-center">
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
            @if(isset($honor_category))
            @foreach($honor_category as $hc)
            <td class="text-center">
                <?php $count = DB::table('respondents')->where('srvyr', '=', $cityCode . $teamCode)->where('project_id', $_GET['project_id'])->whereIn('status_qc_id',  array(5, 1, 0, 10))->where(DB::raw('lower(kategori_honor)'), '=', strtolower($hc->nama_honor))->where('kota_id', '=', $hc->kota_id)->count(); ?>
                {{$count}}
            </td>
            <?php $total += $hc->honor * $count; ?>
            @endforeach
            @endif
            <td class="text-center">
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

            @if(isset($honor_do_category))
            @foreach($honor_do_category as $hc)
            <td class="text-center">
                <?php $count = DB::table('respondents')->where('srvyr', '=', $cityCode . $teamCode)->where('project_id', $_GET['project_id'])->whereIn('status_qc_id', array(2, 3, 6, 9))->where(DB::raw('lower(kategori_honor_do)'), '=', strtolower($hc->nama_honor_do))->where('kota_id', '=', $hc->kota_id)->count(); ?>
                {{$count}}
            </td>

            <?php $total -= $hc->honor_do * $count; ?>
            @endforeach
            @endif
            <?php
            if (isset($_GET['project_id'])) :
                $queryProjectKota = DB::table('project_kotas')->where('project_id', '=', $_GET['project_id'])->where('kota_id', '=', $item->kota_id)->first();
                if ($queryProjectKota) {
                    $n = (($queryProjectKota->jumlah / count($teams)) / 2);
                    $whole = floor($n);
                    $fraction = $n - $whole;

                    if ($fraction <= 0.5) {
                        $countMinBrief = floor(($queryProjectKota->jumlah / count($teams)) / 2);
                    } else {
                        $countMinBrief = ceil(($queryProjectKota->jumlah / count($teams)) / 2);
                    }
                } else {
                    $countMinBrief = 0;
                }

                $honorBrief = 0;
                if ($countOk >= $countMinBrief) {
                    $projectPlans = DB::table('project_plans')->where('project_id', $_GET['project_id'])->get();
                    foreach ($projectPlans as $pp) {
                        $projectAbsensi = DB::table('project_absensis')->join('project_plans', 'project_plans.id', '=', 'project_absensis.project_plan_id')->where('project_id', $_GET['project_id'])->where('team_id', '=', $item->no_team)->where('project_absensis.project_plan_id', '=', $pp->id)->count();
                        if ($pp->honor_briefing)
                            $honorBrief += ($pp->honor_briefing * $projectAbsensi);
                    }
                }
            ?>
                <td class="text-center"><?= number_format($honorBrief) ?></td>
                <?php $total += $honorBrief; ?>
                <?php $totalKeseluruhan += $total; ?>
            <?php $item->total_fee = $total ?>
                <td>
                    Rp.{{number_format($total)}}
                </td>

                <td>
                    <!-- <div class="form-check"> -->
                    <input class="ajukanCheck" type="checkbox" onchange="markPayment({{$item->project_team_id}})" style="width: 1.5rem;height: 1.5rem;" {{$item->is_can_marking ? "":"disabled"}}>
                    <input type="hidden" name="total-<?= $item->id ?>" value="<?= $total ?>">
                    <input type="hidden" name="nextStatus" value="2">
                    <input type="hidden" name="project_id" value="<?= isset($_GET['project_id']) ? $_GET['project_id'] : '' ?>">
                    <input type="hidden" name="link" value="<?= $_SERVER['REQUEST_URI'] ?>">
                    <!-- </div> -->
                </td>
            <?php endif; ?>
        </tr>
        @endforeach
    </tbody>

    @include('layouts.gentelella.table_bottom')
</form>
<div class="row">
    <?php
    if (isset($_GET['project_id']) && isset($_GET['kota_id']) && $_GET['kota_id'] != 'all') : ?>
        <h3 style="margin-left:20px;" class="text-primary">Perolehan Minimal: <?= isset($countMinBrief) ? $countMinBrief : '0' ?></h3>
    <?php endif; ?>
    <button class='btn btn-primary btn-lg btn-ajukan ml-auto mr-5' type="button" id="buttonAjukan">
        Ajukan
    </button>
</div>

<div class="modal fade" id="loadingProsessAjukan"  data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="ajukanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered"  role="document">
        <div class="modal-content">
            <div class="modal-body text-center">
                <img src="https://icons8.com/preloaders/dist/media/hero-preloaders.svg">
                <div class="spinner-border text-primary" role="status"></div><br/>
                <h5>Pengajuan anda sedang dalam proses...</h5>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="statusPengajuanSuccess"  data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="ajukanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered"  role="document">
        <div class="modal-content">
            <div class="modal-body text-center">
                <img id="image_status" src="https://cdn.dribbble.com/users/39201/screenshots/3694057/nutmeg.gif" width="70%"><br/>
                <h5 id="message_status_success">Data Anda Telah Berhasil Di Ajukan</h5><br/>
                <button type="button" class="btn btn-outline-success" data-dismiss="modal" aria-label="Close">
                    Keluar
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="statusPengajuanFailed"  data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="ajukanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered"  role="document">
        <div class="modal-content">
            <div class="modal-body text-center">
                <img id="image_status" src="https://png.pngtree.com/element_our/20190531/ourlarge/pngtree-exclamation-mark-png-image_1273780.jpg" width="70%"><br/>
                <h5 id="message_error">Error: </h5>
                <h5 id="message_status">Data Anda Gagal Diajukan. Klik button dibawah untuk keluar dan ajukan kembali</h5><br/>
                <button type="button" class="btn btn-outline-danger" data-dismiss="modal" aria-label="Close">
                    Keluar
                </button>
            </div>
        </div>
    </div>
</div>
@endsection('content')



@section('javascript')
<script>
    let stateMark = []

    function markPayment(id) {
        if (!stateMark.includes(id)) {
            stateMark.push(id)
        } else {
            stateMark.splice(stateMark.indexOf(id), 1)
        }

        console.log(stateMark)
    }

    function escapeHtml(text) {
        var map = {
            '&amp;': '&',
            '&#038;': "&",
            '&lt;': '<',
            '&gt;': '>',
            '&quot;': '"',
            '&#039;': "'",
            '&#8217;': "’",
            '&#8216;': "‘",
            '&#8211;': "–",
            '&#8212;': "—",
            '&#8230;': "…",
            '&#8221;': '”'
        };

        return text.replace(/\&[\w\d\#]{2,5}\;/g, function(m) { return map[m]; });
    }

    $(document).ready(function() {
        let teams = {!! json_encode($teams) !!} //data teams
        localStorage.setItem('teams', JSON.stringify(teams))
        $('#buttonAjukan').click(function () {
            const form = $('#form-change-status')
            let teams = localStorage.getItem('teams')
            teams = JSON.parse(teams)
            let data = []
            stateMark.forEach(function (id) {
                teams.forEach(function (team) {
                    if (team.project_team_id == id) {
                        // team.project_id = params.project_id
                        data.push(team)
                    }
                })
            })

            if (data.length > 0) {
                $('#loadingProsessAjukan').modal('show')
                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    dataType: "json",
                    data: {
                        data: data,
                        _token: '{{csrf_token()}}'
                    },
                }).done(function (res) {
                    $('#loadingProsessAjukan').modal('hide')
                    alert(res.message)
                    setTimeout(() => {
                        window.location.reload();
                    }, 5000)
                }).fail(function (res) {
                    let message = res.statusText
                    console.log(res)
                    $('#loadingProsessAjukan').modal('hide')
                    alert(message)
                })
            } else {
                alert('Tidak ada data yang dipilih')
            }
            // $('#form-change-status').submit();
        })
    })
    $(document).ready(function() {
        const formatRupiah = (money) => {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(money);
        }

        $('.total-keseluruhan').text(formatRupiah('<?= $totalKeseluruhan ?>'));
        console.log($('#project_id').val())
        if ($('#project_id').val() != 'all') {
            $('.row-filter-kota').show();
        } else {
            $('.row-filter-kota').hide();
        }

        $('.card-box.table-responsive a').hide();

        $('body').on('click', '.btn-ajukan', function() {
            const nextStatus = $(this).data('nextstatus');
            $('input[name=id]').val($(this).data('id'));
            $('input[name=total]').val($(this).data('total'));
            $('input[name=nextStatus]').val(nextStatus);
        })
    });
</script>
@endsection
