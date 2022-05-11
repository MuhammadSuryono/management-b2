@extends('maingentelellatable')
@section('title', 'Daftar Tim : ' . count($teams))
@section('content')


<h3 class="d-block text-center text-primary">Rekap TL: Pengajuan</h3>
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
                        <p>1. Pilih Filter project terlebih dahulu untuk melihat detail honor dan melakukan pembayaran</p>
                        <p>2. Apabila pembayaran internal maka filter kota akan menyesuaikan data kota team yang di marking, tetapi apabila pembayaran external filter kota akan menyesuaikan data kota respondent </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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

                        <form class="form-horizontal form-label-left" method="get" action="{{url('/rekap_tl')}}">
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

                                        {{-- <div align="left" class="col-md-4 col-sm-4 col-xs-12">
                                            <div class="form-group row row-filter-jabatan">
                                                <label class="col-form-label col-md-3 col-sm-3" for="jabatan_id">Jabatan</label>
                                                <div class="col-md-9 col-sm-9">
                                                    <select id="jabatan_id" name="jabatan_id" class="form-control">
                                                        <option value="all">All</option>
                                                        @foreach($jabatans as $db)
                                                        @if(isset($_GET['jabatan_id']) and $_GET['jabatan_id'] == $db->id)
                                                        <option value="{{$db->id}}" selected>{{$db->jabatan}}</option>
                                                        @else
                                                        <option value="{{$db->id}}"> {{$db->jabatan}}</option>
                                                        @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div> --}}

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
                                        <?php
                                        $request = isset($_SERVER['QUERY_STRING']) ? ltrim($_SERVER['QUERY_STRING'], !empty($_SERVER['QUERY_STRING'])) : '';
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

<form action="{{url('/rekap_tl/change_status')}}" method="POST" id="form-change-status">
    @csrf
    @include('layouts/gentelella/table_top')
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Status</th>
            <th>Kota</th>
            <th>No. Telp</th>
            <th>Email</th>
            <th>Bank</th>
            <th>Nomor Rekening</th>
            <th>Total Honor</th>
            @if ($nominalDenda != null)
                @foreach ($nominalDenda as $denda)
                    <th>{{$denda->variable->variable_name}} <br/>{{$denda->variable->default ? "":"Rp."}} {{$denda->variable->default ? $denda->nominal : number_format($denda->nominal)}}{{$denda->variable->default ? "%":""}} ({{isset($denda->projectKota) ? $denda->projectKota->kota->kota : ''}})</th>
                @endforeach
            @endif
            <th>Total Keterlambatan</th>
            <th>Respondent DO</th>
            <th>Respondent Non DO</th>
            <th>Total Denda</th>
            <th>Total</th>
            @if(isset($_GET['project_id']))
            <th>Action</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @foreach ($teams as $item)
        <?php $total = 0; $totalDenda = 0;?>
        <tr>
            <th scope='row'>{{$loop->iteration}}</th>
            <td>{{$item->team->nama}}</td>
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
                $bank = DB::connection('mysql3')->table('bank')->where('kode', '=', $item->team->kode_bank)->first();
                if ($bank) {
                    echo $bank->nama;
                }
                ?>
                @endif
            </td>
            <td>
                @if(isset($item->team->nomor_rekening))
                {{$item->team->nomor_rekening}}
                @endif
            </td>
            <td>
                <?php
                if (isset($item->gaji)) {
                    echo  "Rp. " . number_format($item->default_honor);
                } else {
                    echo  "Rp. 0";
                }
                ?>

            </td>

                <?php
                $totalDendaNominal = 0;
                if (isset($nominalDenda)) {
                    foreach ($nominalDenda as $denda){
                        if($item->denda_static != null){
                            if(isset($item->denda_static[$denda->id])){
                                $denda = $item->denda_static[$denda->id];
                                $totalDendaNominal += $denda;
                                echo "<td>Rp. ".number_format($denda)."</td>";
                            }else {
                                $totalDendaNominal += 0;
                                echo "<td>Rp. ".number_format(0)."</td>";
                            }
                        } else {
                            $totalDendaNominal += 0;
                            echo "<td>Rp. ".number_format(0)."</td>";
                        }
                    }
                } else {
                    echo "<td>Rp. ".number_format(0)."</td>";
                }
                $totalDenda += $totalDendaNominal;
                $item->default_honor = $item->default_honor - $totalDendaNominal;

                ?>
            <td>{{$item->total_keterlambatan}}</td>
            <td>
                {{$item->count_respondent_dos}}
            </td>
            <td>
                {{$item->count_respondent_non_dos}}
            </td>
            <td>
                <?php
                $item->default_honor = $item->default_honor - $item->default_honor_do;
                echo "Rp. " . number_format($item->default_honor_do + $totalDenda);
                ?>
            </td>
            <td>
                <?php
                if ($item->type == "borongan") {
                    $total = $item->default_honor - $item->default_honor_do;
                } else {
                    $total = $item->default_honor - $item->denda * 0;
                }

                echo "Rp. " . number_format($total);
                ?>
            </td>

            @if(isset($_GET['project_id']))
            <td>

                <input class="ajukanCheck" type="checkbox" onchange="markPayment({{$item->project_team_id}})" value="<?= $item->project_team_id ?>" name="id[]" style="width: 1.5rem;height: 1.5rem;">
                <input type="hidden" name="total-<?= $item->id ?>" value="<?= $total ?>">
                <input type="hidden" name="nextStatus" value="2">
                <input type="hidden" name="project_id" value="<?= isset($_GET['project_id']) ? $_GET['project_id'] : '' ?>">
                <input type="hidden" name="jabatan_id" value="<?= isset($_GET['jabatan_id']) ? $_GET['jabatan_id'] : '' ?>">
                <input type="hidden" name="link" value="<?= $_SERVER['REQUEST_URI'] ?>">
            </td>
            @endif
        </tr>
        @endforeach
    </tbody>
    @include('layouts.gentelella.table_bottom')
</form>

<div class="row">
    <button class='btn btn-primary btn-lg btn-ajukan ml-auto mr-5' type="button" id="buttonAjukan">
        Ajukan
    </button>
</div>
@endsection('content')


<div class="modal fade" id="ajukanModal" tabindex="-1" role="dialog" aria-labelledby="ajukanModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ajukanModalLabel">Konfirmasi Perubahan Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- <form action="{{url('/rekap_tl/change_status')}}" method="POST" id="form-change-status"> -->
            @csrf
            <div class="modal-body">
                <input type="hidden" name="project_id" value="<?= isset($_GET['project_id']) ? $_GET['project_id'] : '' ?>">
                <input type="hidden" name="jabatan_id" value="<?= isset($_GET['jabatan_id']) ? $_GET['jabatan_id'] : '' ?>">
                <input type="hidden" name="id">
                <input type="hidden" name="nextStatus">
                <input type="hidden" name="total">
                <input type="hidden" name="link" value="<?= $_SERVER['REQUEST_URI'] ?>">
                Klik Submit untuk melakukan perubahan status
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            <!-- </form> -->
        </div>
    </div>
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
                <h5 id="message_status">Data Anda Telah Berhasil Di Ajukan</h5><br/>
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

@php
    function dataFunc($data) {
        return $data;
    }
@endphp


@section('javascript')
<script>
    let stateMark = []

    function markPayment(id) {
        if (!stateMark.includes(id)) {
            stateMark.push(id)
        } else {
            stateMark.splice(stateMark.indexOf(id), 1)
        }
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
        $('#buttonAjukan').click(function() {
            const form = $('#form-change-status')
            let teams = localStorage.getItem('teams')
            teams = JSON.parse(teams)
            let data = []
            stateMark.forEach(function(id) {
              teams.forEach(function(team) {
                if (team.project_team_id == id) {
                  data.push(team)
                }
              })
            })

            if (data.length > 0) {
                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    dataType: "json",
                    data: {
                        data: data,
                        _token: '{{csrf_token()}}'
                    },
                }).done(function(res) {
                    console.log(res)
                }).fail(function(res) {
                    console.log("Error")
                    console.log(res)
                })
            }else {
                alert('Tidak ada data yang dipilih')
            }
            // $('#form-change-status').submit();
        })
        $('.card-box.table-responsive a').hide();

        $('body').on('click', '.btn-ajukan', function() {
            const nextStatus = $(this).data('nextstatus');
            $('input[name=id]').val($(this).data('id'));
            $('input[name=total]').val($(this).data('total'));
            $('input[name=nextStatus]').val(nextStatus);
        })

        iniJs("MASUK")
    });

    function iniJs(data) {
        const show= `@php echo dataFunc("`+ data +`") @endphp`;
        console.log(show);
    }
</script>
@endsection
