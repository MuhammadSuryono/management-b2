@extends('maingentelellatable')

@section('title', 'Daftar Project')

@section('content')
<div class="sukses" data-flashdata="{{session('sukses')}}"></div>
<div class="gagal" data-flashdata="{{session('gagal')}}"></div>
<div class="hapus" data-flashdata="{{session('hapus')}}"></div>

{{-- AWAL ROW --}}
<div class="row">

  {{-- AWAL KOLOM --}}
  <div class="col-md-6">
    <div class="x_panel">
      <div class="x_title">
        <h2>Belum Di Ajukan</h2>
        <ul class="nav navbar-right panel_toolbox pull-right">
          <li><a class="collapse-link ml-5"><i class="fa fa-chevron-up"></i></a>
          </li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">

        @foreach ($budget as $db)
        <a href="{{url('budgets/pengajuanBudget')}}/{{$db->waktu}}">
        <article class="media event mb-2">
          @if ($db->totalbudgetnow == 0 and $db->totalbudget == 0)
              <span class="pull-left date bg-warning">
          @elseif($db->totalbudgetnow == 0 and $db->totalbudget != 0)
              <span class="pull-left date bg-info">
          @else 
              <span class="pull-left date bg-success">  
          @endif

          <p class="month">{{date('M', strtotime($db->waktu))}}</p>
            <p class="day">{{date('d', strtotime($db->waktu))}}</p>
          </span>
          <div class="media-body">
            <h6 class="title mb-0"> <strong>{{$db->nama}}</strong></h6>
            <p>IDR <strong>{{number_format($db->totalbudgetnow,0,'','.')}}</strong></p>
            <p>{{$db->pengaju}}</p>
          </div>
        </article>
        </a>
        @endforeach

      </div>
    </div>
  </div>
  {{-- AKHIR KOLOM --}}

  {{-- AWAL KOLOM --}}
  <div class="col-md-6">
    <div class="x_panel">
      <div class="x_title">
        <h2>Telah Di Ajukan</h2>
        <ul class="nav navbar-right panel_toolbox pull-right">
          <li><a class="collapse-link ml-5"><i class="fa fa-chevron-up"></i></a>
          </li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">

        @foreach ($ajukan as $db)
        <a href="{{url('budgets/pengajuanBudget')}}/{{$db->waktu}}">
        <article class="media event mb-2">
            @if ($db->status=='Pending')
                <span class="pull-left date bg-info">
            @else
                <span class="pull-left date bg-success">
            @endif

          <p class="month">{{date('M', strtotime($db->waktu))}}</p>
            <p class="day">{{date('d', strtotime($db->waktu))}}</p>
          </span>
          <div class="media-body">
            <h6 class="title mb-0"> <strong>{{$db->nama}}</strong></h6>
            <p>IDR <strong>{{number_format($db->totalbudgetnow,0,'','.')}}</strong></p>
            <p>{{$db->pengaju}}</p>
          </div>
        </article>
        </a>
        @endforeach

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
