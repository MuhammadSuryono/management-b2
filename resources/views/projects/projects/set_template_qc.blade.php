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
                <h2>Set Template QC</h2>
                <ul class="nav navbar-right panel_toolbox pull-right">
                    <li><a class="collapse-link ml-5"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form class="form-horizontal form-label-left" action="{{url('projects/buatProject')}}" method="post">
                    @csrf
                    <div class="form-group row ">
                        <label class="control-label col-md-3 col-sm-3 ">Nama Client</label>
                        <div class="col-md-9 col-sm-9 ">
                            <input type="text" class="form-control" name="nama_client" id="nama_client" readonly>
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
        $('#less_than_status').change(function() {
            if ($(this).is(':checked')) {
                $('#less_than_minute').prop('readonly', false);
            } else {
                console.log('here2');
                $('#less_than_minute').prop('readonly', true);
            }
        })
        $('#more_than_status').change(function() {
            if ($(this).is(':checked')) {
                $('#more_than_minute').prop('readonly', false);
            } else {
                console.log('here2');
                $('#more_than_minute').prop('readonly', true);
            }
        })
        $('#before_status').change(function() {
            if ($(this).is(':checked')) {
                $('#before_time').prop('readonly', false);
            } else {
                console.log('here2');
                $('#before_time').prop('readonly', true);
            }
        })
        $('#after_status').change(function() {
            if ($(this).is(':checked')) {
                $('#after_time').prop('readonly', false);
            } else {
                console.log('here2');
                $('#after_time').prop('readonly', true);
            }
        })
    });
</script>
@endsection