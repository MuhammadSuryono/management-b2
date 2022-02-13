@extends('maingentelellaform')
@section('title', 'Edit Plan ' )
@section('title2', 'Proyek ' . session('current_project_nama'))
@section('content')
@section('action_url', url('/project_plans/store'))

@csrf

<input type="hidden" id="project_id" name="project_id" value="{{ session('current_project_id') }} ">
<input type="hidden" id="detail_pp" name="detail_pp" value="">
<input type="hidden" id="user_id" name="user_id" value="{{session('user_id')}}">


<div class="item form-group">
    <label class="col-form-label col-md-3 col-sm-3 col-xs-6 label-align" for="task_id">Task </label>
    <div class="col-md-3 col-sm-3 col-xs-6">
        <select id="task_id" name="task_id" class="form-control pull-right">
            <option value="" selected disabled>Pilih Tugas</option>
            @foreach($template as $t)
            <?php if ((old('task_id'))) : ?>
                <?php if (old('task_id') == $t->id_pp_master) : ?>
                    <option value="{{$t->id_pp_master}}" selected>{{$t->nama_kegiatan}}</option>
                <?php endif; ?>
            <?php else : ?>
                <option value="{{$t->id_pp_master}}">{{$t->nama_kegiatan}}</option>
            <?php endif; ?>
            @endforeach
        </select>
        @error('task_id')
        <small style="color: red;">
            {{$message}}
        </small>
        @enderror
    </div>
    <div class="col-md-3">
        <button type="button" class="btn btn-sm btn-primary mt-1" data-toggle="modal" data-target="#addTaskModal"><i class="fa fa-plus"></i> Task</button>
    </div>
</div>

<div class="item form-group" id="row-honor" style="display: none;">
    <label class="col-form-label col-md-3 col-sm-3 col-xs-6 label-align" for="honor_briefing">Honor Briefing </label>
    <div class="col-md-3 col-sm-3 col-xs-6">
        <input type="int" id="honor_briefing" name="honor_briefing" class="form-control" value="{{ (old('honor_briefing')) ?  old('honor_briefing') : ''}}">
        @error('honor_briefing')
        <small style="color: red;">
            {{$message}}
        </small>
        @enderror
    </div>
</div>

<div class="row-peserta-internal">
</div>

<div class="row-peserta-external">
</div>

<div class="item form-group">
    <label class="col-form-label col-md-3 col-sm-3 col-xs-6 label-align" for="date_start_target">Tanggal Mulai </label>
    <div class="col-md-3 col-sm-3 col-xs-6">
        <input type="date" id="date_start_target" name="date_start_target" class="form-control" value="{{ (old('date_start_target')) ?  old('date_start_target') : ''}}">
        @error('date_start_target')
        <small style="color: red;">
            {{$message}}
        </small>
        @enderror
    </div>
</div>

<div class="item form-group">
    <label class="col-form-label col-md-3 col-sm-3 col-xs-6 label-align" for="hour_start_target">Jam Mulai </label>
    <div class="col-md-3 col-sm-3 col-xs-6">
        <input type="time" id="hour_start_target" name="hour_start_target" class="form-control" value="{{ (old('hour_start_target')) ?  old('hour_start_target') : ''}}">
        @error('hour_start_target')
        <small style="color: red;">
            {{$message}}
        </small>
        @enderror
    </div>
</div>

<div class="item form-group">
    <label class="col-form-label col-md-3 col-sm-3 col-xs-6 label-align" for="date_finish_target">Tanggal Selesai </label>
    <div class="col-md-3 col-sm-3 col-xs-6">
        <input type="date" id="date_finish_target" name="date_finish_target" class="form-control" value="{{ (old('date_finish_target')) ?  old('date_finish_target') : ''}}">
        @error('date_finish_target')
        <small style="color: red;">
            {{$message}}
        </small>
        @enderror
    </div>
</div>

<div class="item form-group">
    <label class="col-form-label col-md-3 col-sm-3 col-xs-6 label-align" for="hour_finish_target">Jam Selesai </label>
    <div class="col-md-3 col-sm-3 col-xs-6">
        <input type="time" id="hour_finish_target" name="hour_finish_target" class="form-control" value="{{ (old('hour_finish_target')) ?  old('hour_finish_target') : ''}}">
        @error('hour_finish_target')
        <small style="color: red;">
            {{$message}}
        </small>
        @enderror
    </div>
</div>

<div class="item form-group">
    <label class="col-form-label col-md-3 col-sm-3 col-xs-6 label-align" for="ket">Ket </label>
    <div class="col-md-6 col-sm-6 col-xs-6">
        <input type="text" id="ket" name="ket" class="form-control" value="{{ (old('ket')) ?  old('ket') : ''}}">
        @error('ket')
        <small style="color: red;">
            {{$message}}
        </small>
        @enderror
    </div>
</div>


<div class="form-group row" id="row-presence">
    <label class="col-form-label col-md-3 col-sm-3 col-xs-6 label-align" for="presensi_respondent">Presensi Respondent </label>
    <div class="col-md-6 col-sm-6 col-xs-6 mt-2">
        <input type="checkbox" class="kategori" name="presensi_respondent" id="presensi_respondent" value="1">
        @error('kategori')
        <small style="color: red;">
            {{$message}}
        </small>
        @enderror
    </div>
</div>

<div class="item form-group">
    <div class="col-md-6 col-sm-6 offset-md-3">
        <button class="btn btn-primary" type="button" id="tambah-peserta-external">Tambah Peserta External</button>
        <button class="btn btn-primary" type="button" id="tambah-peserta-internal">Tambah Peserta Internal</button>
    </div>
</div>
@endsection('content')

<div class="modal fade" id="addTaskModal" tabindex="-1" role="dialog" aria-labelledby="addTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTaskModalLabel">Add New Task</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ url('/project_plans/add_task')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="task">New Task</label>
                        <input type="text" class="form-control" id="task" name="task" placeholder="">
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="has_presence" name="has_presence">
                        <label class="form-check-label" for="has_presence">Perlu daftar kehadiran</label>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" name="button" value="tl">Submit</button>
            </div>
            </form>
        </div>
    </div>
</div>

@section('javascript')
<script>
    $(document).ready(function() {
        $('#task_id').change(function() {
            // console.log($(this).val());
            const idTask = $(this).val();
            $.ajax({
                url: "{{url('project_plans/check_has_presence')}}",
                type: "POST",
                dataType: "json",
                data: {
                    _token: "{{ csrf_token() }}",
                    idTask: idTask,
                },
                success: function(hasil) {
                    console.log(hasil.presence);
                    if (hasil.has_presence == 1) {
                        $('#row-honor').show();
                        $('#row-presence').show();
                    } else {
                        $('#row-honor').hide();
                        $('#row-presence').hide();
                    }
                }
            })
        })

        $('#tambah-peserta-external').click(function() {
            $('.item-peserta-external').show();
            let html = `
            <div class="item form-group item-peserta-external">
                <label class="col-form-label col-md-3 col-sm-3 col-xs-6 label-align" for="peserta_external">Peserta External</label>
                <div class="col-md-3 col-sm-3 col-xs-6">
                    <select id="peserta_external" name="peserta_external[]" class="form-control pull-right">
                        <option value="" selected disabled>Pilih Peserta External</option>
                        <?php foreach ($team as $d) : ?>
                        <option value="<?= $d->id ?>"><?= $d->nama ?></option>
                        <?php endforeach; ?>
                    </select>
                    @error('peserta_external')
                    <small style="color: red;">
                        {{$message}}
                    </small>
                    @enderror
                </div>
                <div class="col"><button class="btn btn-sm btn-danger delete-peserta"><i class="fa fa-minus"></i></button></div>
            </div>
            `
            $(".row-peserta-external").append(html);
        });

        $('#tambah-peserta-internal').click(function() {
            let html = `
            <div class="item form-group item-peserta-internal">
                <label class="col-form-label col-md-3 col-sm-3 col-xs-6 label-align" for="peserta_internal">Peserta Internal</label>
                <div class="col-md-3 col-sm-3 col-xs-6">
                    <select id="peserta_internal" name="peserta_internal[]" class="form-control pull-right">
                        <button>test</button>
                        <option value="" selected disabled>Pilih Divisi</option>
                        <?php foreach ($divisi as $d) : ?>
                        <option value="<?= $d->id ?>"><?= $d->nama_divisi ?></option>
                        <?php endforeach; ?>
                    </select>
                    @error('peserta_internal')
                    <small style="color: red;">
                        {{$message}}
                    </small>
                    @enderror
                </div>
                
                <div class="col"><button type="button" class="btn btn-sm btn-danger delete-peserta"><i class="fa fa-minus"></i></button></div>
            </div>
            `
            $(".row-peserta-internal").append(html);
        });

        setInterval(function() {
            buttonDelete = document.querySelectorAll(".delete-peserta");
            buttonDelete.forEach(function(e, i) {
                e.addEventListener('click', function() {
                    e.parentElement.parentElement.remove();
                });
            });

        }, 1000);
    })
</script>
@endsection