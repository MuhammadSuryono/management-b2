@extends('maingentelellaform')
@section('title', 'Edit Plan ' )
@section('title2', 'Proyek ' . session('current_project_nama'))
@section('content')
@section('action_url', url('/project_plans').'/'.$project_plans->id)

@method('patch')
@csrf

<input type="hidden" id="project_id" name="project_id" value="{{ session('current_project_id') }} ">
<input type="hidden" id="detail_pp" name="detail_pp" value="{{ $project_plans->id }} ">
<input type="hidden" id="user_id" name="user_id" value="{{session('user_id')}}">

<div class="item form-group">
    <label class="col-form-label col-md-3 col-sm-3 col-xs-6 label-align" for="task_id">Task </label>
    <div class="col-md-3 col-sm-3 col-xs-6">
        <select id="task_id" name="task_id" class="form-control pull-right">
            @foreach($template as $t)
            @if($t->id_pp_master == $project_plans->task_id)
            <option value="{{$t->id_pp_master}}" selected>{{$t->nama_kegiatan}}</option>
            @endif
            <option value="{{$t->id_pp_master}}">{{$t->nama_kegiatan}}</option>
            @endforeach
        </select>
        @error('task_id')
        <small style="color: red;">
            {{$message}}
        </small>
        @enderror
    </div>
</div>

<div class="item form-group" id="row-honor">
    <label class="col-form-label col-md-3 col-sm-3 col-xs-6 label-align" for="honor_briefing">Honor Briefing </label>
    <div class="col-md-3 col-sm-3 col-xs-6">
        <input type="int" id="honor_briefing" name="honor_briefing" class="form-control" value="{{$project_plans->honor_briefing}}">
        @error('honor_briefing')
        <small style="color: red;">
            {{$message}}
        </small>
        @enderror
    </div>
</div>

<div class="row-peserta-internal">
    <?php if (@unserialize($project_plans->peserta_internal_id)) :  ?>
        <?php $arrPesertaInternal = unserialize($project_plans->peserta_internal_id) ?>
        <?php for ($i = 0; $i < count($arrPesertaInternal); $i++) : ?>
            <div class="item form-group item-peserta-external">
                <label class="col-form-label col-md-3 col-sm-3 col-xs-6 label-align" for="peserta_internal">Peserta Internal</label>
                <div class="col-md-3 col-sm-3 col-xs-6">
                    <select id="peserta_internal" name="peserta_internal[]" class="form-control pull-right">
                        <option value="" selected disabled>Pilih Peserta Internal</option>
                        <?php foreach ($divisi as $d) : ?>
                            <?php if ($d->id == $arrPesertaInternal[$i]) : ?>
                                <option value="<?= $d->id ?>" selected><?= $d->nama_divisi ?></option>
                            <?php else : ?>
                                <option value="<?= $d->id ?>"><?= $d->nama_divisi ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                    @error('peserta_internal')
                    <small style="color: red;">
                        {{$message}}
                    </small>
                    @enderror
                </div>
                <div class="col"><button class="btn btn-sm btn-danger delete-peserta"><i class="fa fa-minus"></i></button></div>
            </div>
        <?php endfor; ?>
    <?php endif; ?>
</div>

<div class="row-peserta-external">
    <?php if (@unserialize($project_plans->peserta_external_id)) :  ?>
        <?php $arrPesertaExternal = unserialize($project_plans->peserta_external_id) ?>
        <?php for ($i = 0; $i < count($arrPesertaExternal); $i++) : ?>
            <div class="item form-group item-peserta-external">
                <label class="col-form-label col-md-3 col-sm-3 col-xs-6 label-align" for="peserta_external">Peserta External</label>
                <div class="col-md-3 col-sm-3 col-xs-6">
                    <select id="peserta_external" name="peserta_external[]" class="form-control pull-right">
                        <option value="" selected disabled>Pilih Peserta External</option>
                        <?php foreach ($team as $d) : ?>
                            <?php if ($d->id == $arrPesertaExternal[$i]) : ?>
                                <option value="<?= $d->id ?>" selected><?= $d->nama ?></option>
                            <?php else : ?>
                                <option value="<?= $d->id ?>"><?= $d->nama ?></option>
                            <?php endif; ?>
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
        <?php endfor; ?>
    <?php endif; ?>
</div>

<div class="item form-group">
    <label class="col-form-label col-md-3 col-sm-3 col-xs-6 label-align" for="date_start_target">Tanggal Mulai </label>
    <div class="col-md-3 col-sm-3 col-xs-6">
        <input type="date" id="date_start_target" name="date_start_target" class="form-control  " value="{{$project_plans->date_start_real}}">
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
        <input type="time" id="hour_start_target" name="hour_start_target" class="form-control" value="{{$project_plans->hour_start_real}}">
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
        <input type="date" id="date_finish_target" name="date_finish_target" class="form-control" value="{{$project_plans->date_finish_real}}">
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
        <input type="time" id="hour_finish_target" name="hour_finish_target" class="form-control" value="{{$project_plans->hour_finish_real}}">
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
        <input type="text" id="ket" name="ket" class="form-control" value="{{$project_plans->ket}}">
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
        <input type="checkbox" class="kategori" name="presensi_respondent" id="presensi_respondent" value="1" <?= ($project_plans->has_respondent_presence == 1) ? 'checked' : '' ?>>
        @error('kategori')
        <small style="color: red;">
            {{$message}}
        </small>
        @enderror
    </div>
</div>

<div class="item form-group">
    <div class="col-md-6 col-sm-6 offset-md-3">
        <button class="btn btn-primary" type="button" id="tambah-peserta-external">Tambah Personel External</button>
        <button class="btn btn-primary" type="button" id="tambah-peserta-internal">Tambah Personel Internal</button>
    </div>
</div>
@endsection('content')


@section('javascript')
<script>
    $(document).ready(function() {
        const idTask = $('#task_id').val();
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
                if (hasil.has_presence == 1)
                    $('#row-honor').show();
                else
                    $('#row-honor').hide();
            }
        })

        $('#task_id').change(function() {
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