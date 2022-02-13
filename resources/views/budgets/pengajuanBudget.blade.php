@extends('maingentelellatable')

@section('title', 'Daftar Project')

@section('content')
<div class="sukses" data-flashdata="{{session('sukses')}}"></div>
<div class="gagal" data-flashdata="{{session('gagal')}}"></div>
<div class="hapus" data-flashdata="{{session('hapus')}}"></div>

{{-- ARRAY SELESAI --}}
<?php $dbSelesai = []; $jumlah=0;?>
@foreach ($selesai as $db)
    <?php
        $nama = $db->divisi_budget;

        if(array_key_exists($nama, $dbSelesai)==true){
            array_push($dbSelesai[$nama],$db);
        } else {
            $dbSelesai[$nama] = array($db);
        }
    ?>
@endforeach
{{-- {{dd($dbSelesai)}} --}}
{{-- AKHIR ARRAY SELESAI --}}

{{-- AWAL ROW --}}
<div class="row">


  @foreach ($divisi as $db)
  <?php $jumlah = $jumlah + (float)$db->jumlah;?>
  {{-- AWAL KOLOM --}}
  <div class="col-md-12">
    <div class="x_panel" style="height: auto;">
      <div class="x_title">
      <h2>{{$db->divisi_budget}} - IDR {{number_format($db->jumlah, 0, '', '.')}}</h2>
        <ul class="nav navbar-right panel_toolbox pull-right">
          <li><a class="collapse-link ml-5"><i class="fa fa-chevron-up"></i></a>
          </li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content" style="display: none;">
        <div class="dashboard-widget-content">
            <ul class="list-unstyled timeline widget">
            @for ($i = 0; $i < count($dbSelesai[$db->divisi_budget]); $i++)
            <li>
                <div class="block">
                <div class="block_content">
                    <h2 class="title">
                        <a>{{$dbSelesai[$db->divisi_budget][$i]->rincian}}</a>
                    </h2>
                    <div class="byline">
                    <span>IDR {{number_format($dbSelesai[$db->divisi_budget][$i]->harga,0,'','.')}} @ {{$dbSelesai[$db->divisi_budget][$i]->quantity}}</span><strong class="text-success"> <i class="fa fa-angle-double-right fa-lg"></i> IDR {{number_format($dbSelesai[$db->divisi_budget][$i]->total,0,'','.')}}</strong>
                    </div>
                </div>
                </div>
            </li>
            @endfor
            </ul>
          </div>


      </div>
    </div>
  </div>
  {{-- AKHIR KOLOM --}}
  @endforeach

  {{-- AWAL KOLOM --}}
  <div class="col-md-12">
    <div class="x_panel">
      <div class="x_title">
      <h2>Persetujuan Project {{$limit->nama}}</h2>
        <ul class="nav navbar-right panel_toolbox pull-right">
          <li><a class="collapse-link ml-5"><i class="fa fa-chevron-up"></i></a>
          </li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-form-label col-md-3 col-sm-3 ">Grand Total</label>
                    <div class="col-md-9 col-sm-9 ">
                    <input type="text" class="form-control" readonly="readonly" value="IDR {{number_format($jumlah,0,'','.')}}">
                    </div>
                  </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-form-label col-md-3 col-sm-3 ">Limit Project</label>
                    <div class="col-md-9 col-sm-9 ">
                      <input type="text" class="form-control" readonly="readonly" value="IDR {{number_format($limit->totalbudgetnow,0,'','.')}}">
                    </div>
                  </div>
            </div>
        </div>

        <div class="ln_solid"></div>
            <div class="form-group row">
                <div class="col-md-12 col-sm-12 text-center">
                <form action="{{url('budgets/simpanPengajuan')}}" method="post">
                    @csrf
                <input type="hidden" name="noid" id="noid" value="{{$limit->noid}}">
                  <a href="{{url('budgets/pengajuan')}}" class="btn btn-danger btn-sm">Cancel</a>
                <a href="{{url('budgets/print')}}/{{$limit->waktu}}" class="btn btn-primary btn-sm" target="_blank">Print</a>
                  @if ($limit->status == 'Belum Di Ajukan')
                    <button type="submit" class="btn btn-success btn-sm">Ajukan</button>
                  @endif
                  </form>
                </div>
              </div>

      </div>
    </div>
  </div>
  {{-- AKHIR KOLOM --}}

</div>
{{-- AKHIR ROW --}}

@endsection('content')

@section('javascript')
<script>
$(document).ready(function(){
});  
</script> 
@endsection
