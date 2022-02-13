@extends('maingentelellatable')
@section('title', 'Daftar Absensi')
@section('title2', 'Proyek ' . $project_plan->nama . ' -- ' . $project_plan->nama_kegiatan)
@section('content')
@include('layouts.gentelella.table_top')
<thead>
    <tr>
        <th>No</th>
        <th>Tanggal</th>
        <th>Jam</th>
        <th>Lokasi</th>
        <th>Tema</th>
        <th>Absen tutup</th>
        <th>Action</th>
    </tr>
</thead>
<tbody>
    <?php $i = 1; ?>
    @foreach ($project_kegiatan as $item)
    <tr>
        <th scope='row'>{{$i++}}</th>
        <td>{{ $item->tanggal }}</td>
        <td>{{ $item->jam }} </td>
        <td>
            @if(isset($item->lokasi->lokasi)) {{ $item->lokasi->lokasi }} @endif
        </td>
        <td>{{ $item->tema }} </td>
        <td>{{ $item->absen_tutup }} </td>
        <td>
            <a href="{{ url('/project_kegiatans/')}}/{{$item->id}}/edit" class='btn btn-primary btn-sm'><i class="fa fa-edit"></i></a>
            <a href="{{ url('/project_kegiatans/')}}/delete/{{$item->id}}" onclick="return confirm('Are you sure?')" class='btn btn-danger btn-sm'><i class="fa fa-trash-o"></i></a>
            <a href="{{ url('/project_kegiatans/')}}/print_qr/{{$item->id}}" class='btn btn-info btn-sm'><i class="fa fa-qrcode"></i></a>
            <a href="{{ url('/project_absensis/')}}/list_absen_kegiatan/{{$item->id}}" class='btn btn-info btn-sm'><i class="fa fa-list-alt"></i></a>
        </td>
    </tr>
    @endforeach
</tbody>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                @section('action_url', url('/project_kegiatans'))

                <form id="qrscan_form" data-parsley-validate class="form-horizontal form-label-left" method="POST" action="@yield('action_url')">
                    @csrf
                    <input type="hidden" id="project_plan_id" name="project_plan_id" value="@if(isset($project_plan->id)) {{$project_plan->id}} @endif">

                    <?php $for_create_edit = 'create'; ?>
                    {{-- lokasi_id --}}
                    @component('components.list_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$project_kegiatan,'label_width1'=>'3','label_width2'=>'6','input_width1'=>'5', 'input_width2'=>'6','input_label'=>'Lokasi', 'input_id'=>'lokasi_id', 'list_field'=>'lokasi','master'=>$lokasis, 'master_id'=>'id',])
                    @endcomponent

                    {{-- tanggal --}}
                    @component('components.common_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$project_kegiatan,'data_type'=>'date', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'5','input_width2'=>'6','input_label'=>'Tanggal', 'input_id'=>'tanggal'])
                    @endcomponent

                    {{-- jam --}}
                    @component('components.common_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$project_kegiatan,'data_type'=>'time', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'5','input_width2'=>'6','input_label'=>'Jam', 'input_id'=>'jam'])
                    @endcomponent

                    {{-- absen_tutup --}}
                    @component('components.common_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$project_kegiatan,'data_type'=>'time', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'5','input_width2'=>'6','input_label'=>'Absen ditutup jam', 'input_id'=>'absen_tutup'])
                    @endcomponent

                    {{-- tema --}}
                    @component('components.common_input', ['for_create_edit'=> $for_create_edit, 'detail_table'=>$project_kegiatan,'data_type'=>'text', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'6', 'input_width2'=>'6','input_label'=>'Tema', 'input_id'=>'tema'])
                    @endcomponent

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
            </form>
        </div>
    </div>
</div>


@include('layouts.gentelella.table_bottom')
@endsection('content')
@section('javascript')

<script>
    $(document).ready(function() {
        const i = '<?= $i ?>';
        console.log(i);
        if (i == 1) {
            $('#myModal').modal('toggle');
            // $('#myModal').modal('toggle');
        }
    })
</script>

@endsection