@extends('maingentelellatable')

@section('title', 'Buat Project')

@section('content')
<div class="sukses" data-flashdata="{{session('sukses')}}"></div>
<div class="gagal" data-flashdata="{{session('gagal')}}"></div>
<div class="hapus" data-flashdata="{{session('hapus')}}"></div>

{{-- AWAL ROW --}}
<div class="row justify-content-center">

    <div class="col-md-8">
        <div class="x_panel">
            <div class="x_title">
                <h2>Pembuatan Project</h2>
                <ul class="nav navbar-right panel_toolbox pull-right">
                    <li><a class="collapse-link ml-5"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <form class="form-horizontal form-label-left" action="{{url('projects/buatProject')}}" method="post">
                    @csrf
                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 ">Nomor Request</label>
                        <div class="col-md-9 col-sm-9 ">
                            <select class="selectpicker" name="nomor_rfq" id="nomor_rfq" data-live-search="true" data-width="100%" required>
                                <option>Pilih Nomor Request</option>
                                @foreach ($projectCommVoucher as $db)
                                <option value="{{$db->nomor_project}}" data-tokens="{{$db->nomor_project}}" data-table="comm_voucher">{{$db->nomor_project}} - {{$db->nama_project_internal}}</option>
                                @endforeach
                                @foreach ($projectSindikasi as $db)
                                <option value="{{$db->nama_project}}" data-tokens="{{$db->nama_project}}" data-table="data_sindikasi">{{$db->nama_project}}</option>
                                @endforeach
                            </select>
                            @error('nomor_rfq')
                            <small style="color: red;">
                                {{$message}}
                            </small>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row ">
                        <label class="control-label col-md-3 col-sm-3 ">Nama Client</label>
                        <div class="col-md-9 col-sm-9 ">
                            <input type="text" class="form-control" name="nama_client" id="nama_client" readonly>
                        </div>
                    </div>

                    <div class="form-group row ">
                        <label class="control-label col-md-3 col-sm-3 ">Tanggal Deal</label>
                        <div class="col-md-9 col-sm-9 ">
                            <input type="text" class="form-control" name="tgl_deal" id="tgl_deal" readonly>
                        </div>
                    </div>

                    <div class="form-group row ">
                        <label class="control-label col-md-3 col-sm-3 ">Nama Project</label>
                        <div class="col-md-9 col-sm-9 ">
                            <input type="text" class="form-control" name="nama_project" id="nama_project" readonly>
                        </div>
                    </div>

                    <div class="form-group row ">
                        <label class="control-label col-md-3 col-sm-3 ">Kode Project</label>
                        <div class="col-md-9 col-sm-9 ">
                            <input type="text" class="form-control" name="kode_project" id="kode_project" readonly>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-md-3 col-sm-3 ">Methodology</label>

                        <div class="col-md-9 col-sm-9">
                            <section id="method">
                            </section>
                            @error('method')
                            <small style="color: red;">
                                {{$message}}
                            </small>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row ">
                        <label class="control-label col-md-3 col-sm-3 ">Tanggal Kick Off</label>
                        <div class="col-md-9 col-sm-9 ">
                            <input type="date" class="form-control" name="tgl_kickoff" id="tgl_kickoff">
                            @error('tgl_kickoff')
                            <small style="color: red;">
                                {{$message}}
                            </small>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row ">
                        <label class="control-label col-md-3 col-sm-3 ">Tanggal Akhir Kontak</label>
                        <div class="col-md-9 col-sm-9 ">
                            <input type="date" class="form-control" name="tgl_akhir_kontrak" id="tgl_akhir_kontrak" min="{{date('Y-m-d')}}" required>
                            @error('tgl_akhir_kontrak')
                            <small style="color: red;">
                                {{$message}}
                            </small>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row ">
                        <label class="control-label col-md-3 col-sm-3 ">Tanggal Approve Kuesioner</label>
                        <div class="col-md-9 col-sm-9 ">
                            <input type="date" class="form-control" name="tgl_approve_kuesioner" id="tgl_approve_kuesioner">
                            @error('tgl_approve_kuesioner')
                            <small style="color: red;">
                                {{$message}}
                            </small>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-sm-3 ">Kategori Resources Fieldwork</label>
                        <div class="col-md-9 col-sm-9">
                            <section id="jenis">
                                @foreach($fieldworks as $f)
                                <?php if ($f->kategori_fieldwork == 'Vendor Korporasi') $idVendorKorp = $f->id ?>
                                <label class="radio-inline">
                                    <input type="checkbox" class="kategori" name="kategori[]" id="inlineRadio{{$f->id}}" value="{{$f->id}}"> {{$f->kategori_fieldwork}}
                                </label>
                                @endforeach
                            </section>
                            @error('kategori')
                            <small style="color: red;">
                                {{$message}}
                            </small>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row" id="vendor-row" style="display: none;">
                        <label class="control-label col-md-3 col-sm-3 ">Vendor Korporasi</label>
                        <div class="col-md-9 col-sm-9 ">
                            <select class="selectpicker" name="vendor_korporasi" id="vendor_korporasi" data-live-search="true" data-width="100%" required>
                                <option>Pilih Vendor</option>
                                @foreach ($vendors as $db)
                                <option value="{{$db->id}}">{{$db->nama_perusahaan}}</option>
                                @endforeach
                            </select>
                            @error('vendor_korporasi')
                            <small style=" color: red;">
                                {{$message}}
                            </small>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row ">
                        <label class="control-label col-md-3 col-sm-3 ">Keterangan</label>
                        <div class="col-md-9 col-sm-9 ">
                            <textarea type="text" class="form-control" name="ket" id="ket" required></textarea>
                            @error('ket')
                            <small style="color: red;">
                                {{$message}}
                            </small>
                            @enderror
                        </div>
                    </div>

                    <div class="ln_solid"></div>
                    <div class="item form-group text-center">
                        <div class="col-md-12 col-sm-12">
                            <a class="btn btn-danger text-white" href="{{url('projects')}}">Cancel</a>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>

</div>
{{-- AKHIR ROW --}}

@endsection('content')

@section('javascript')
<script>
    $(document).ready(function() {
        const idVendorKorp = "<?= isset($idVendorKorp) ? $idVendorKorp : 0 ?>"
        if (idVendorKorp != 0) {
            $('#inlineRadio' + idVendorKorp).change(function() {
                if ($(this).is(':checked')) {
                    $('#vendor-row').show();
                } else {
                    $('#vendor-row').hide();
                }
            })
        }

        $('#nomor_rfq').change(function() {
            var nomor_rfq = $('#nomor_rfq').val();
            var table = $(this).find(':selected').data('table')
            console.log(table);

            $('#method').empty();
            $.ajax({
                url: "{{url('projects/ambilData')}}",
                type: "POST",
                dataType: "json",
                data: {
                    _token: "{{ csrf_token() }}",
                    nomor_rfq: nomor_rfq,
                    table: table
                },
                success: function(hasil) {
                    const data = hasil.data;
                    const customer = hasil.customer;
                    const methodology = hasil.methodology;
                    const Ketmethodology = hasil.ket_methodology;

                    const nama = (customer[0]) ? customer[0] : 'Data Tidak Ada';
                    const tanggalDeal = (data.tgl_deal) ? data.tgl_deal : 'Data Tidak Ada';
                    const namaProject = (hasil.nama_internal) ? hasil.nama_internal : (data.nama_project) ? data.nama_project : 'Data Tidak Ada';
                    const kodeProject = (data.kode_project) ? data.kode_project : 'Data Tidak Ada';

                    $('#nama_client').val(nama);
                    $('#tgl_deal').val(tanggalDeal);
                    $('#nama_project').val(namaProject);
                    $('#kode_project').val(kodeProject);

                    var html = ``;
                    // for (var i = 0; i < methodology.length; i++) {
                    //     html += `<div class="pretty p-default p-round p-smooth p-fill">
                    //             <input type="radio" name="method" id="` + hasil[i] + `" value="` + hasil[i].id + `" required/>
                    //             <div class="state p-success">
                    //                 <label for="` + hasil[i] + `">` + hasil[i].methodology + `</label>
                    //             </div>
                    //         </div>`;
                    // }
                    if (methodology.length == 0) html += 'Tidak ada Methodology yang tersedia';
                    else {
                        for (var i = 0; i < methodology.length; i++) {
                            html += `<input type="radio" id="${methodology[i]}" name="method" value="${methodology[i]}">
                            <label for="${methodology[i]}">${methodology[i]} - ${Ketmethodology[i]}</label><br>`;
                        }
                    }
                    console.log(html);
                    $('#method').append(html);

                    // $("#method").empty();
                    // $("#method").append(html);
                    // $("#nama_client").val(hasil[0].nama_client);
                    // $("#tgl_deal").val(hasil[0].tgl_deal);
                }
            });
        });
    });
</script>
@endsection
