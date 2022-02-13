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
                <h2>Interview Flagging</h2>
                <ul class="nav navbar-right panel_toolbox pull-right">
                    <li><a class="collapse-link ml-5"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <form class="form-horizontal form-label-left" action="{{url('projects/store_flag_rules')}}" method="post">
                    @csrf
                    @method('patch')
                    <input type="hidden" name="id" value="{{$id}}">

                    <div class="form-group row">
                        <label class="col-md-2 col-sm-2 ">Durasi Interview <br>(In minute)</label>

                        <div class="col-md-10 col-sm-10">
                            <section>
                                <div class="row">
                                    <div style="width: 10%;">
                                        <label class="">
                                            <input type="checkbox" class="kategori form-control d-inline" name="less_than_status" id="less_than_status" value="1" <?= isset($flag_rules->less_than_status) ? 'checked' : '' ?>> <small>Less than</small>
                                        </label>
                                    </div>

                                    <div style="width: 30%;">
                                        <input type="text" class="ml-3 form-control d-inline" name="less_than_minute" id="less_than_minute" value="<?= isset($flag_rules->less_than_minute) ? $flag_rules->less_than_minute : '' ?>" <?= isset($flag_rules->less_than_status) ? '' : 'readonly' ?>>
                                    </div>
                                </div>
                            </section>
                            <section>
                                <div class="row">
                                    <div style="width: 10%;">
                                        <label class="">
                                            <input type="checkbox" class="kategori form-control d-inline" name="more_than_status" id="more_than_status" value="1" <?= isset($flag_rules->more_than_status) ? 'checked' : '' ?>> <small>More than</small>
                                        </label>
                                    </div>

                                    <div style="width: 30%;">
                                        <input type="text" class="ml-3 form-control d-inline" name="more_than_minute" id="more_than_minute" value="<?= isset($flag_rules->more_than_minute) ? $flag_rules->more_than_minute : '' ?>" <?= isset($flag_rules->more_than_status) ? '' : 'readonly' ?>>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-sm-2 ">Start Time</label>

                        <div class="col-md-10 col-sm-10">
                            <section>
                                <div class="row">
                                    <div style="width: 10%;">
                                        <label class="">
                                            <input type="checkbox" class="kategori form-control d-inline" name="before_status" id="before_status" value="1" <?= isset($flag_rules->before_status) ? 'checked' : '' ?>> <small style="font-size: 100%;">Before</small>
                                        </label>
                                    </div>

                                    <div style="width: 30%;">
                                        <input type="time" class="ml-3 form-control d-inline" name="before_time" id="before_time" value="<?= isset($flag_rules->before_time) ? $flag_rules->before_time : '' ?>" <?= isset($flag_rules->before_status) ? '' : 'readonly' ?>>
                                    </div>
                                </div>
                            </section>
                            <section>
                                <div class="row">
                                    <div style="width: 10%;">
                                        <label class="">
                                            <input type="checkbox" class="kategori form-control d-inline" name="after_status" id="after_status" value="1" <?= isset($flag_rules->after_status) ? 'checked' : '' ?>> <small style="font-size: 110%; margin-left: 5px;">After</small>
                                        </label>
                                    </div>

                                    <div style="width: 30%;">
                                        <input type="time" class="ml-3 form-control d-inline" name="after_time" id="after_time" value="<?= isset($flag_rules->after_time) ? $flag_rules->after_time : '' ?>" <?= isset($flag_rules->after_status) ? '' : 'readonly' ?>>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 col-sm-2 ">Longitude & Lattitude</label>

                        <div class="col-md-10 col-sm-10">
                            <section>
                                <div class="row">
                                    <div style="width: 10%;">
                                        <label class="">
                                            <input type="checkbox" class="form-control d-inline" name="longlat_status" id="longlat_status" value="1" <?= isset($flag_rules->longlat_status) ? 'checked' : '' ?>> <small style="font-size: 100%;">Active</small>
                                        </label>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 col-sm-2 ">Link Rekaman</label>

                        <div class="col-md-10 col-sm-10">
                            <section>
                                <div class="row">
                                    <div style="width: 10%;">
                                        <label class="">
                                            <input type="checkbox" class="form-control d-inline" name="rekaman_status" id="rekaman_status" value="1" <?= isset($flag_rules->rekaman_status) ? 'checked' : '' ?>> <small style="font-size: 100%;">Active</small>
                                        </label>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 col-sm-2 ">Upload H+1</label>

                        <div class="col-md-10 col-sm-10">
                            <section>
                                <div class="row">
                                    <div style="width: 10%;">
                                        <label class="">
                                            <input type="checkbox" class="form-control d-inline" name="upload_status" id="upload_status" value="1" <?= isset($flag_rules->upload_status) ? 'checked' : '' ?>> <small style="font-size: 100%;">Active</small>
                                        </label>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>

                    <div class="ln_solid"></div>
                    <div class="item form-group text-center">
                        <div class="col-md-12 col-sm-12">
                            <a class="btn btn-danger text-white" href="{{url('projects/' . session('current_project_id') . '/edit')}}">Cancel</a>
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