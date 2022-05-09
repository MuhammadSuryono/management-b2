@extends('maingentelellatable')
@section('title', 'Daftar Setting Route : ' . $settings->count() ?? '0')
@section('content')
    @include('layouts.gentelella.table_top')
    <button class="btn btn-primary btn-lg" style="float: right" onclick="tambah('Tambah Data')"><i class="fa fa-plus-circle"></i> Tambah Route Access Public</button>
    <thead>
    <tr class="text-center">
        <th width="5%">No</th>
        <th>Route Name</th>
        <th>Path</th>
        <th>Status</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($settings as $setting)
        <tr>
            <th scope='row'>{{$loop->iteration}}</th>
            <td>{{$setting->route_name}}</td>
            <td>{{$setting->route_path}}</td>
            <td class="text-center">@if ($setting->route_status)  <span class="badge badge-success">Active</span> @else <span class="badge badge-secondary">Inactive</span> @endif</td>
            <td>
                <a href="javascript:void(0)" onclick="editModal('Edit Setting', '{{json_encode($setting)}}')" class='btn btn-primary btn-sm'><i class="fa fa-edit"></i></a>
                <a href="{{ url('/setting/route/')}}/{{$setting->id}}/delete" onclick="return confirm('Are you sure?')" class='btn btn-danger btn-sm'><i class="fa fa-trash-o"></i></a>
            </td>
        </tr>
    @endforeach
    </tbody>
    @include('layouts.gentelella.table_bottom')
@endsection('content')

<div class="modal fade" id="modal-tambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-md">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-tambahTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-route" method="POST">
                    @csrf
                    <div class="form-group">
                        <input type="hidden" class="form-control" id="id" name="id" placeholder="Route Name" >
                    </div>
                    <div class="form-group">
                        <label for="route_name">Route Name</label>
                        <input type="text" class="form-control" id="route_name" name="route_name" placeholder="Route Name" required>
                    </div>
                    <div class="form-group">
                        <label for="route_path">Route Path</label>
                        <input type="text" class="form-control" id="route_path" name="route_path" placeholder="Route Path" required>
                    </div>
                    <div class="form-group">
                        <label for="route_status">Route Status</label>
                        <select class="form-control" id="route_status" name="route_status" required>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
            </form>
        </div>
    </div>
</div>

@section('javascript')
    <script>
        function tambah(title, data) {
            $('#modal-tambah').modal('show');
            $('#modal-tambahTitle').html(title);
            $('#form-route')[0].reset();
            $('#form-route').attr('action', '{{ url('/setting/route/create')}}');
        }

        function editModal(title, data) {
            $('#modal-tambah').modal('show');
            $('#modal-tambahTitle').html(title);
            const js = JSON.parse(data);
            const form = $('#form-route');
            form.attr('action', '{{ url('/setting/route/update')}}');
            form.find('#id').val(js.id);
            form.find('#route_name').val(js.route_name);
            form.find('#route_path').val(js.route_path);
            form.find('#route_status').val(js.route_status);
            {{--$('#form-route')[0].reset();--}}
            {{--$('#form-route').attr('action', '{{ url('/setting/route/create')}}');--}}
        }
    </script>
@endsection()
