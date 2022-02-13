@extends('maingentelellatable')

@section('title', 'Daftar Project')

@section('content')
<div class="sukses" data-flashdata="{{session('sukses')}}"></div>
<div class="gagal" data-flashdata="{{session('gagal')}}"></div>

{{-- AWAL ROW --}}
<div class="row">

  {{-- AWAL KOLOM --}}
  <div class="col-md-6">
    <div class="x_panel">
      <div class="x_title">
        <h2>Data Project <small>Input Limits</small></h2>
        <ul class="nav navbar-right panel_toolbox pull-right">
          <li><a class="collapse-link ml-5"><i class="fa fa-chevron-up"></i></a>
          </li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">

        @foreach ($budget as $db)
        <a href="javascript:void(0);" data-id="{{$db->noid}}" data-budget="{{$db->totalbudgetnow}}" class="show-modal" data-toggle="modal" data-target=".bs-example-modal-lg">
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
        <h2>Telah Diajukan</h2>
        <ul class="nav navbar-right panel_toolbox pull-right">
          <li><a class="collapse-link ml-5"><i class="fa fa-chevron-up"></i></a>
          </li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">

        @foreach ($ajukan as $db)
        <a href="{{url('budgets/persetujuan')}}/{{$db->noid}}">
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

{{-- MODAL --}}
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true" id="modalku">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Input Limit Project</h4>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
      <form action="{{url('budgets/simpanLimit')}}" method="post">
        @csrf
        <input type="hidden" id="idPengajuan" name="idPengajuan">

        <div class="item form-group">
          <label class="col-form-label col-md-2 col-sm-2 label-align" for="first-name">Limits (IDR)<span class="required">*</span>
          </label>
          <div class="col-md-9 col-sm-9 ">
            <input type="number" id="limit" name="limit" required="required" class="form-control ">
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </form>
      </div>

    </div>
  </div>
</div>
{{-- AKHIR MODAL --}}

@endsection('content')

@section('javascript')
<script>
$(document).ready(function(){
    $('#modalku').on('show.bs.modal', function (e) {
        var div = $(e.relatedTarget);
        var modal = $(this);
        modal.find("#idPengajuan").attr('value', div.data('id'));
        modal.find("#limit").attr('value', div.data('budget'));
     });
});  
</script> 
@endsection
