@extends('main')
@section('content')<div class="row">
    <div class="col-md-12 col-sm-12 ">
        <div class="x_panel">
            <div class="x_title">
                <h2>Tambah Variable</h2>
                <div class="clearfix"></div>
            </div>
            @if (isset($status))
            <div class="alert alert-{{$status == true ? 'success':'danger'}}" role="alert">
                {{$message}}
            </div>
            @endif
            <div class="x_content">
                <button class="btn btn-primary" onclick="showModalAddVariable(this)"> <i class="fa fa-plus"></i> Tambah Variable</button>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center" width="3%">No</th>
                                <th class="text-center">Nama Variable</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($projectVariables as $variable)
                            <tr>
                                <td>1</td>
                                <td>{{$variable->variable_name}}</td>
                                <td>
                                    <button data-id="{{$variable->id}}" data-variable="{{$variable->variable_name}}" onclick="showModalEditVariable(this)" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></button>
                                    <button data-id="{{$variable->id}}" data-variable="{{$variable->variable_name}}" onclick="showModalDeleteVariable(this)" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                {{-- <div class="item form-group">
                    <div class="col-md-12 col-sm-12 offset-md-12">
                        <a style="float: right" href="{{ url()->previous() }}" class="btn btn-primary" type="button">Cancel</a>
                        <button  style="float: right" type="submit" class="btn btn-success">Save</button>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="formVariable">
            <div class="modal-body">
                @csrf
                <div class="form-group">
                    <label for="variable_name">Nama Variable Denda</label>
                    <input type="text" class="form-control" id="variable_name" name="variable_name" placeholder="Nama Variable denda">
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
      </div>
    </div>
  </div>


  <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteModalLabel">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="formDeleteVariable">
            <div class="modal-body">
                @csrf
                Apakah anda yakin menghapus data ini?
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-danger">Delete</button>
            </div>
        </form>
      </div>
    </div>
  </div>
@endsection


@section('script')
<script>
    function showModalAddVariable(e) {
        $('#exampleModal').modal('show');
        let form = $('#formVariable')
        form[0].reset();
        form.attr('action', '{{ url('project/'.$projectId.'/variable') }}')
        form.attr('method', 'POST')
    }
    function showModalEditVariable(e) {
        $('#exampleModal').modal('show');
        let form = $('#formVariable')
        let id = e.dataset.id
        form[0].reset();
        $('#variable_name').val(e.dataset.variable)
        form.attr('action', '{{ url('project/'.$projectId.'/variable') }}/'+id)
        form.attr('method', 'POST')
    }

    function showModalDeleteVariable(e) {
        $('#deleteModal').modal('show');
        let form = $('#formDeleteVariable')
        let id = e.dataset.id
        form[0].reset();
        form.attr('action', '{{ url('project/'.$projectId.'/variable') }}/'+id+'/delete')
        form.attr('method', 'POST')
    }
</script>
@endsection
