@extends('maingentelellatable')
@section('title', 'Plan Project '.session('current_project_nama') )

@section('style')
<style>
  td:hover {
    cursor: move;
  }
</style>
@endsection

@section('content')
<div class="sukses" data-flashdata="{{session('sukses')}}"></div>

<div class="row">

  {{-- AWAL KOLOM --}}
  <div class="col-md-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Project Schedule - {{$project->nama}} </h2>
        <ul class="nav navbar-right panel_toolbox pull-right">
          <li><a data-toggle="modal" data-target=".tambah"><i class="fa fa-plus"></i></a>
          <li><a class="collapse-link ml-1"><i class="fa fa-chevron-up"></i></a>
          </li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">

        <div class="row">
          <div class="col-lg-12">
            <div class="table-responsive">
              <table class="table table-hover" id="table">
                <thead>
                  <tr>
                    <th data-field="nama_schedule" data-sortable="true">Nama Schedule</th>
                    <th data-field="partisipan" data-sortable="true">Partisipan</th>
                    <th data-field="tgl" data-sortable="true">Tanggal</th>
                    <th data-field="aksi" data-sortable="true">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <section id="urutan">
                    @foreach ($project_schedule as $db)
                    <tr id="{{$loop->iteration}}">
                      <td>{{$db->nama_schedule}}</td>
                      <td>{{$db->partisipan}}</td>
                      <td>{{$db->tgl_schedule}}</td>
                      <td><button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target=".edit" data-id="{{$db->id}}" data-schedule="{{$db->nama_schedule}}" data-partisipan="{{$db->partisipan}}" data-tgl="{{$db->tgl_schedule}}"><i class="fa fa-edit"></i></button></td>
                    </tr>

                    @endforeach
                  </section>
                </tbody>
              </table>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
  {{-- AKHIR KOLOM --}}
</div>

{{-- MODAL TAMBAH --}}
<div class="modal fade bs-example-modal-lg tambah" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Tambah Schedule</h4>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
      </div>
      <form action="{{route('project_plans.tambah')}}" method="POST">
        <div class="modal-body">
          @csrf
          <input type="hidden" id="id_project" name="id_project" value="{{$project->id}}">
          <input type="hidden" id="kode_project" name="kode_project" value="{{$project->kode_project}}">
          <input type="hidden" id="methodology" name="methodology" value="{{$project->methodology}}">
          <div class="form-group row">
            <label class="col-form-label col-md-3 col-sm-3 ">Nama Schedule : </label>
            <div class="col-md-9 col-sm-9 ">
              <input type="text" class="form-control" name="nama" id="nama" value="" required>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-form-label col-md-3 col-sm-3 ">Partisipan : </label>
            <div class="col-md-9 col-sm-9 ">
              <input type="number" class="form-control" required name="partisipan" id="partisipan">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-form-label col-md-3 col-sm-3 ">Tanggal : </label>
            <div class="col-md-9 col-sm-9 ">
              <input type="date" class="form-control" name="tgl_schedule" id="tgl_schedule" required>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>
{{-- MODAL TAMBAH --}}

{{-- Modal --}}
<div class="modal fade bs-example-modal-lg edit" tabindex="-1" role="dialog" aria-hidden="true" id="modalku">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Edit Schedule</h4>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
        </button>
      </div>
      <form action="{{url('project_plans/simpanSchedule')}}" method="POST">
        <div class="modal-body">
          @csrf
          <input type="hidden" id="id" name="id" value="">
          <input type="hidden" id="id_project" name="id_project" value="{{$project->id}}">
          <div class="form-group row">
            <label class="col-form-label col-md-3 col-sm-3 ">Nama Schedule : </label>
            <div class="col-md-9 col-sm-9 ">
              <input type="text" class="form-control" name="schedule" id="schedule" disabled="disabled" value="">
            </div>
          </div>

          <div class="form-group row">
            <label class="col-form-label col-md-3 col-sm-3 ">Partisipan : </label>
            <div class="col-md-9 col-sm-9 ">
              <input type="number" class="form-control" required name="partisipan" id="partisipan">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-form-label col-md-3 col-sm-3 ">Tanggal : </label>
            <div class="col-md-9 col-sm-9 ">
              <input type="date" class="form-control" name="tgl" id="tgl" required>
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
{{-- AKHIR Modal --}}

@endsection('content')

@section('js')
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script>
@endsection

@section('javascript')
<script>
  $(document).ready(function() {
    $('tbody').sortable();

    $('#modalku').on('show.bs.modal', function(e) {
      var div = $(e.relatedTarget);
      var modal = $(this);
      modal.find("#id").val(div.data('id'));
      modal.find("#schedule").val(div.data('schedule'));
      modal.find("#partisipan").val(div.data('partisipan'));
      modal.find("#tgl").val(div.data('tgl'));
    });
  });

  $('#table').on("click", 'tr', function() {
    // alert($(this).attr("id"));
  });
</script>
@endsection