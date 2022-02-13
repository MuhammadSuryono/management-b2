@extends('maingentelellatable')

@section('title', 'Daftar Project')

@section('content')
<div class="sukses" data-flashdata="{{session('sukses')}}"></div>
<div class="gagal" data-flashdata="{{session('gagal')}}"></div>
<div class="hapus" data-flashdata="{{session('hapus')}}"></div>
<div class="edit" data-flashdata="{{session('edit')}}"></div>
{{-- AWAL ROW --}}
<div class="row">

  {{-- AWAL KOLOM --}}
  <div class="col-sm-12">
    <div class="x_panel">
      <div class="x_title">
      <h2>{{$budget->nama}}</h2>
        <ul class="nav navbar-right panel_toolbox pull-right">
          <li><a class="collapse-link ml-5"><i class="fa fa-chevron-up"></i></a>
          </li>
          <li><a class="ml-2" data-toggle="modal" data-target=".info"><i class="fa fa-info-circle"></i></a></li>
          <li><a class="ml-2" data-toggle="modal" data-target=".tambah"><i class="fa fa-plus"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        
            <div class="table-responsive">
              {{-- <table id="datatable-buttons" class="table table-striped table-bordered jambo_table test" style="width:100%"> --}}
              <table id="datatable-buttons1" class="table table-striped table-bordered jambo_table" style="width:100%">
                <thead>
                  <tr class="headings">
                    <th class="column-title">No</th>
                    <th class="column-title">Rincian </th>
                    <th class="column-title">Kota </th>
                    <th class="column-title">Jenis </th>
                    <th class="column-title">Penerima </th>
                    <th class="column-title">Harga </th>
                    <th class="column-title">Quantity </th>
                    <th class="column-title">Total Harga </th>
                    <th class="column-title">Status </th>
                    <th class="column-title no-link last"><span class="nobr">Action</span>
                    </th>
                    <th class="bulk-actions" colspan="7">
                      <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                    </th>
                  </tr>
                </thead>

                <tbody>
                  @foreach ($budgetByDivisi as $db)
                    <tr class="even pointer">
                      <td class="a-center ">{{$loop->iteration}}</td>
                      <td class=" ">{{$db->rincian}}</td>
                      <td class=" ">{{$db->kota}}</td>
                      <td class=" ">{{$db->status}}</td>
                      <td class=" ">{{$db->penerima}}</td>
                      <td class="a-right a-right">IDR {{number_format($db->harga,0,'','.')}}</td>
                      <td class="">{{$db->quantity}}</td>
                      <td class="a-right a-right ">IDR {{number_format($db->total,0,'','.')}}</td>
                      <td class="">{{$db->pembayaran}}</td>
                      <td class="last">
                      <a title="Edit" href="javascript:void();;" data-waktu="{{$db->waktu}}" data-nomor="{{$db->no}}" data-harga="{{$db->harga}}" data-quantity="{{$db->quantity}}" data-total="{{$db->total}}" data-penerima="{{$db->penerima}}" data-rincian="{{$db->rincian}}" data-kota="{{$db->kota}}" data-status="{{$db->status}}" data-idBudget="{{$budget->noid}}" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modalEdit"><i class="fa fa-edit"></i></a>
                      <a title="Hapus" class="btn btn-sm btn-danger tombol-hapus" href="{{url('budgets/hapusBudgetDivisi')}}/{{$db->no}}/{{$db->waktu}}"><i class="fa fa-trash"></i></a>
                      </td>
                    </tr>
                    @endforeach
                </tbody>
              </table>
            </div>
                    
                

      </div>
    </div>
  </div>
  {{-- AKHIR KOLOM --}}

</div>
{{-- AKHIR ROW --}}

{{-- MODAL INFO --}}
<div class="modal fade bs-example-modal-lg info" tabindex="-1" role="dialog" aria-hidden="true" id="modalku">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
  
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">Detail Project</h4>
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="form-group row">
                <label class="col-form-label col-md-3 col-sm-3 ">Nama Project : </label>
                <div class="col-md-9 col-sm-9 ">
                <input type="text" class="form-control" disabled="disabled" value="{{$budget->nama}}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-md-3 col-sm-3 ">Kode Project : </label>
                <div class="col-md-9 col-sm-9 ">
                <input type="text" class="form-control" disabled="disabled" value="{{$budget->kodeproject}}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-md-3 col-sm-3 ">Limit Project : </label>
                <div class="col-md-9 col-sm-9 ">
                    <input type="text" class="form-control" disabled="disabled" value="IDR. {{number_format($budget->totalbudgetnow,0,'','.')}}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-md-3 col-sm-3 ">Jenis Project : </label>
                <div class="col-md-9 col-sm-9 ">
                <input type="text" class="form-control" disabled="disabled" value="{{$budget->jenis}}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-md-3 col-sm-3 ">Tanggal Input Project : </label>
                <div class="col-md-9 col-sm-9 ">
                <input type="text" class="form-control" disabled="disabled" value="{{$budget->waktu}}">
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        </div>
  
      </div>
    </div>
  </div>
{{-- AKHIR MODAL INFO --}}

{{-- MODAL TAMBAH --}}
<div class="modal fade bs-example-modal-lg tambah" tabindex="-1" role="dialog" aria-hidden="true" id="modalku">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
  
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">Input Budget</h4>
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
        <form action="{{url('budgets/simpanBudgetByDivisi')}}" method="post">
        @csrf
        <input type="hidden" name="pengaju" id="pengaju" value="{{$divisi->nama_user}}">
        <input type="hidden" name="divisi" id="divisi" value="{{$divisi->divisi}}">
        <input type="hidden" name="waktu" id="waktu" value="{{$budget->waktu}}">
        <input type="hidden" name="id" id="id" value="{{$budget->noid}}">
            <div class="form-group row">
                <label class="col-form-label col-md-3 col-sm-3 ">Rincian : </label>
                <div class="col-md-9 col-sm-9 ">
                <input type="text" class="form-control" name="rincian" id="rincian" placeholder="Rincian.." required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-md-3 col-sm-3 ">Kota : </label>
                <div class="col-md-9 col-sm-9 ">
                <input type="text" class="form-control" name="kota" id="kota" placeholder="Kota.." required>
                </div>
            </div>
            <div class="form-group row">
                <label class="control-label col-md-3 col-sm-3 ">Status</label>
                <div class="col-md-9 col-sm-9 ">
                  <select class="form-control" name="status" id="status" required>
                    <option>Pilih Status..</option>
                    <option value="UM">UM</option>
                    <option value="Vendor/Supplier">Vendor/Supplier</option>
                    <option value="Honor Eksternal">Honor Eksternal</option>
                    <option value="Biaya Lumpsum">Biaya Lumpsum</option>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-form-label col-md-3 col-sm-3 ">Penerima : </label>
                <div class="col-md-9 col-sm-9 ">
                <input type="text" class="form-control" name="penerima" id="penerima" placeholder="Nama Penerima..">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-md-3 col-sm-3 ">Harga : </label>
                <div class="col-md-9 col-sm-9 ">
                <input type="number" class="form-control" name="harga" id="harga" placeholder="Harga.." required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-md-3 col-sm-3 ">Quantity : </label>
                <div class="col-md-9 col-sm-9 ">
                <input type="number" class="form-control" name="quantity" id="quantity" placeholder="Quantity.." required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-md-3 col-sm-3 ">Total : </label>
                <div class="col-md-9 col-sm-9 ">
                <input type="number" class="form-control" name="total" id="total" placeholder="Total Harga.." readonly>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save</button>
        </form>
        </div>
  
      </div>
    </div>
  </div>
{{-- AKHIR MODAL TAMBAH --}}

{{-- MODAL EDIT --}}
<div class="modal fade bs-example-modal-lg edit" tabindex="-1" role="dialog" aria-hidden="true" id="modalEdit">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Input Budget</h4>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
      <form action="{{url('budgets/editBudgetByDivisi')}}" method="post">
      @csrf
      <input type="hidden" name="waktu" id="waktu">
      <input type="hidden" name="id" id="id">
      <input type="hidden" name="idBudget" id="idBudget">
      <input type="hidden" name="totalSebelum" id="totalSebelum">
          <div class="form-group row">
              <label class="col-form-label col-md-3 col-sm-3 ">Rincian : </label>
              <div class="col-md-9 col-sm-9 ">
              <input type="text" class="form-control" name="rincian" id="rincian" placeholder="Rincian.." required>
              </div>
          </div>
          <div class="form-group row">
              <label class="col-form-label col-md-3 col-sm-3 ">Kota : </label>
              <div class="col-md-9 col-sm-9 ">
              <input type="text" class="form-control" name="kota" id="kota" placeholder="Kota.." required>
              </div>
          </div>
          <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 ">Status</label>
              <div class="col-md-9 col-sm-9 ">
                <select class="form-control" name="status" id="status" required>
                  <option>Pilih Status..</option>
                  <option value="UM">UM</option>
                  <option value="Vendor/Supplier">Vendor/Supplier</option>
                  <option value="Honor Eksternal">Honor Eksternal</option>
                  <option value="Biaya Lumpsum">Biaya Lumpsum</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-form-label col-md-3 col-sm-3 ">Penerima : </label>
              <div class="col-md-9 col-sm-9 ">
              <input type="text" class="form-control" name="penerima" id="penerima" placeholder="Nama Penerima..">
              </div>
          </div>
          <div class="form-group row">
              <label class="col-form-label col-md-3 col-sm-3 ">Harga : </label>
              <div class="col-md-9 col-sm-9 ">
              <input type="number" class="form-control" name="hargaEdit" id="hargaEdit" placeholder="Harga.." required>
              </div>
          </div>
          <div class="form-group row">
              <label class="col-form-label col-md-3 col-sm-3 ">Quantity : </label>
              <div class="col-md-9 col-sm-9 ">
              <input type="number" class="form-control" name="quantityEdit" id="quantityEdit" placeholder="Quantity.." required>
              </div>
          </div>
          <div class="form-group row">
              <label class="col-form-label col-md-3 col-sm-3 ">Total : </label>
              <div class="col-md-9 col-sm-9 ">
              <input type="number" class="form-control" name="totalEdit" id="totalEdit" placeholder="Total Harga.." readonly>
              </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save</button>
      </form>
      </div>

    </div>
  </div>
</div>
{{-- AKHIR MODAL EDIT --}}


@endsection('content')

@section('javascript')
<script>
$(document).ready(function(){
    $('#datatable-buttons1').dataTable( {
        "lengthChange": false,
        "paging" : false,
        "responsive": true
    });

    $('#harga').on('change keypress keyup keydown', function(){
        if($('#harga').val()!=0 && $('#quantity').val()!=0){
            $('#total').val($('#harga').val()*$('#quantity').val());
        }
    });

    $('#quantity').on('change keypress keyup keydown', function(){
        if($('#harga').val()!=0 && $('#quantity').val()!=0){
            $('#total').val($('#harga').val()*$('#quantity').val());
        }
    });

    $('#hargaEdit').on('change keypress keyup keydown', function(){
          if($('#hargaEdit').val()!=0 && $('#quantityEdit').val()!=0){
              $('#totalEdit').val($('#hargaEdit').val()*$('#quantityEdit').val());
          }
        });

    $('#quantityEdit').on('change keypress keyup keydown', function(){
        if($('#hargaEdit').val()!=0 && $('#quantityEdit').val()!=0){
            $('#totalEdit').val($('#hargaEdit').val()*$('#quantityEdit').val());
        }
    });


    $('#modalEdit').on('show.bs.modal', function (e) {
        var div = $(e.relatedTarget);
        var modal = $(this);
        modal.find("#id").val(div.data('nomor'));
        modal.find("#idBudget").val(div.data('idbudget'));
        modal.find("#waktu").val(div.data('waktu'));
        modal.find("#rincian").val(div.data('rincian'));
        modal.find("#kota").val(div.data('kota'));
        modal.find("#status").val(div.data('status'));
        modal.find("#penerima").val(div.data('penerima'));
        modal.find("#hargaEdit").val(div.data('harga'));
        modal.find("#quantityEdit").val(div.data('quantity'));
        modal.find("#totalEdit").val(div.data('total'));
        modal.find("#totalSebelum").val(div.data('total'));
     });
});  
</script> 
@endsection
