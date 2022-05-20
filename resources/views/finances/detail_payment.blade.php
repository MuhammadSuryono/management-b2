@extends('main')
@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 ">
        <div class="x_panel mt-5">
            <div class="x_title">
                <h2><b><i class="fa fa-user"></i> {{strtoupper($projectTeam->team->nama)}}</b></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <h6 class="font-weight-bold"><i class="fa fa-building"></i> Data Project</h6>
                <table class="table table-striped table-hover">
                    <thead style="background-color: #294348; color: white">
                        <tr class="text-center">
                            <th>Project</th>
                            <th>Customer</th>
                            <th>Methodology</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="font-weight-bold text-center">
                            <td>{{strtoupper($projectTeam->projectKota->project->nama)}} - {{$projectTeam->projectKota->project->kode_project}}</td>
                            <td>{{strtoupper($projectTeam->projectKota->project->nama_customer)}}</td>
                            <td>{{strtoupper($projectTeam->projectKota->project->methodology)}}</td>
                            <td>{{strtoupper($projectTeam->projectKota->project->ket)}}</td>
                        </tr>
                    </tbody>
                </table>
                <hr/>
                <h6 class="font-weight-bold"><i class="fa fa-user"></i> Data Penerima</h6>
                <table class="table table-striped table-hover">
                    <thead style="background-color: #294348; color: white">
                    <tr class="text-center">
                        <th>Nama</th>
                        <th>Type TL</th>
                        <th>Kota</th>
                        <th>Data Rekening</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="font-weight-bold text-center">
                        <td>{{strtoupper($projectTeam->team->nama)}}</td>
                        <td>{{strtoupper($projectTeam->type_tl)}}</td>
                        <td class="text-left">
                            <li>Asal : {{strtoupper($projectTeam->team->kota->kota)}}</li>
                            <li>Project : {{strtoupper($projectTeam->projectKota->kota->kota)}}</li>
                        </td>
                        <td class="text-left">
                            <?php $bank = DB::connection('mysql3')->table('bank')->where('kode', '=', $projectTeam->team->kode_bank)->first(); ?>
                            <li>Bank : {{$bank !== null ? strtoupper($bank->nama):"-"}}</li>
                            <li>No. Rekening : {{strtoupper($projectTeam->team->nomor_rekening)}}</li>
                            <li>Atas Nama : {{strtoupper($projectTeam->team->nama)}}</li>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <hr/>

                <h6 class="font-weight-bold"><i class="fa fa-list"></i> Data Item Pembayaran</h6>
                <table class="table table-striped table-hover">
                    <thead style="background-color: #3c6168; color: white">
                    <tr class="text-center">
                        <th>Nama Item</th>
                        <th>Qty</th>
                        <th width="20%">Nominal</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="font-weight-bold">Target Perolehan</td>
                            <td class="text-center">{{$projectTeam->count_respondent_do_stg + $projectTeam->respondent_non_do}}</td>
                            <td>Rp. 0</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-center font-weight-bold" style="background-color: #7fd7ea">PEROLEHAN KATEGORI HONOR</td>
                        </tr>
                        @foreach($projectTeam->data_honor as $key => $itemHonor)
                        <tr>
                            <td class="font-weight-bold">{{$itemHonor->nama_honor}} <br/><span class="text-secondary">(Rp. {{number_format($itemHonor->jumlah)}}/{{$itemHonor->satuan}})</span></td>
                            <td class="text-center">{{$itemHonor->total_respondent}} <a href="javascript:void(0)" onclick="showDetail('non_do', '{{base64_encode(json_encode($itemHonor))}}', '{{$projectTeam->id}}')"><i class="fa fa-search"></i> </a></td>
                            <td>Rp. {{number_format($itemHonor->total_honor)}}</td>
                        </tr>
                        @endforeach
                        <tr>
                            <td colspan="3" class="text-center font-weight-bold" style="background-color: #f18d8d">POTONGAN</td>
                        </tr>
                        @foreach($projectTeam->honor_do as $type => $itemDo)
                            <tr>
                                <td colspan="3" class="text-center font-weight-bold" style="background-color: #a2a0a0">{{strtoupper($type)}}</td>
                            </tr>
                            @foreach($itemDo as $key => $item)
                                <tr>
                                    <td class="font-weight-bold"><span class="{{$item->nama_honor_denda == 'Undefined' ? 'text-danger': ''}}">{{$item->nama_honor_denda}}</span> <br/><span class="text-secondary">(Rp. {{number_format($item->nominal)}}/{{$item->satuan}}) - {{$item->kategori}}</span></td>
                                    <td class="text-center">{{$item->quantity_data}} <a href="javascript:void(0)" onclick="showDetail('{{$type}}', '{{base64_encode(json_encode($item))}}', '{{$projectTeam->id}}')"><i class="fa fa-search"></i> </a></td>
                                    <td class="text-right text-danger">Rp. {{number_format($item->total)}}</td>
                                </tr>
                            @endforeach
                        @endforeach
                        <tr style="background-color: #b0f89d">
                            <td colspan="2" class="text-center font-weight-bold">TOTAL FEE</td>
                            <td class="{{$projectTeam->total_fee < 0 ? 'text-right':'text-left'}}">Rp. {{number_format($projectTeam->total_fee)}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bs-example-modal-lg" id="detailDataQuantity" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel"><i class="fa fa-table"></i> Detail Data</h4>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-scroll">
                    <table id="datatable-checkbox" class="table table-striped table-bordered bulk_action table-hover tableFixHead" style="width:100%">
                        <thead>
                            <tr class="warning">
                                <th width="4%">No</th>
                                <th>Interview Date</th>
                                <th>Nama</th>
                                <th>Kota</th>
                                <th>Status QC</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody id="body-detail">

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script>
        function showDetail(type, data, projectTeamId) {
            $('#detailDataQuantity').modal('show')
            $('#body-detail').html("")
            $.ajax({
                url: "{{route('detail_quantity')}}",
                type: "POST",
                data: {
                    type: type,
                    data: data,
                    projectTeamId: projectTeamId,
                    "_token": "{{ csrf_token() }}"
                },
                success: function(res) {
                    var html = ""
                    res.data.forEach((item, index) => {
                        html += `<tr>
                                    <td>${index+1}</td>
                                    <td>${item.intvdate}</td>
                                    <td>${item.respname}</td>
                                    <td>${item.kota.kota}</td>
                                    <td>${item.status_qc_id}</td>`
                        if (item.value !== undefined) {
                            html += `<td>${item.value}</td>`
                        } else {
                            html             += `<td>
                                        ${item.keterangan_qc === null ? "":item.keterangan_qc}<br/>
                                        ${item.keterangan_temuan_dp === null ? "":item.keterangan_temuan_dp}<br/>
                                    </td>`
                        }

                                html +=`</tr>`
                    })
                    $('#body-detail').html(html)
                }
            })
        }
    </script>
@endsection
