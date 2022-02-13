{{-- respname --}}
@component('components.common_input', ['for_create_edit'=> $for_create_edit, 'detail_table'=>$respondent,'data_type'=>'text', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'6', 'input_width2'=>'6','input_label'=>'Nama', 'input_id'=>'respname', 'other_option'=>'readonly'])
@endcomponent

@if(in_array(Session::get('divisi_id'), [1, 2, 3]))

{{-- gender_id --}}
@component('components.list_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$respondent,'label_width1'=>'3','label_width2'=>'6','input_width1'=>'2', 'input_width2'=>'6','input_label'=>'Gender', 'input_id'=>'gender_id', 'list_field'=>'gender','master'=>$genders, 'master_id'=>'id'])
@endcomponent

{{-- ses_final_id --}}
@component('components.list_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$respondent,'label_width1'=>'3','label_width2'=>'6','input_width1'=>'2', 'input_width2'=>'6','input_label'=>'Final SES', 'input_id'=>'ses_final_id', 'list_field'=>'ses_final','master'=>$ses_finals, 'master_id'=>'id'])
@endcomponent

{{-- age --}}
@component('components.common_input', ['for_create_edit'=> $for_create_edit, 'detail_table'=>$respondent,'data_type'=>'number', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'2', 'input_width2'=>'6','input_label'=>'Age', 'input_id'=>'usia'])
@endcomponent

{{-- pekerjaan_id --}}
@component('components.list_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$respondent,'label_width1'=>'3','label_width2'=>'6','input_width1'=>'3', 'input_width2'=>'6','input_label'=>'Occupation', 'input_id'=>'pekerjaan_id', 'list_field'=>'pekerjaan','master'=>$pekerjaans, 'master_id'=>'id'])
@endcomponent

{{-- pendidikan_id --}}
@component('components.list_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$respondent,'label_width1'=>'3','label_width2'=>'6','input_width1'=>'3', 'input_width2'=>'6','input_label'=>'Education', 'input_id'=>'pendidikan_id', 'list_field'=>'pendidikan','master'=>$pendidikans, 'master_id'=>'id'])
@endcomponent

{{-- kota_id --}}
@component('components.list_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$respondent,'label_width1'=>'3','label_width2'=>'6','input_width1'=>'2', 'input_width2'=>'6','input_label'=>'City', 'input_id'=>'kota_id', 'list_field'=>'kota','master'=>$kotas, 'master_id'=>'id'])
@endcomponent

{{-- mobilephone --}}
@component('components.common_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$respondent,'data_type'=>'text', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'2', 'input_width2'=>'6','input_label'=>'HP', 'input_id'=>'mobilephone'])
@endcomponent

@else

{{-- gender_id --}}
@component('components.list_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$respondent,'label_width1'=>'3','label_width2'=>'6','input_width1'=>'2', 'input_width2'=>'6','input_label'=>'Gender', 'input_id'=>'gender_id', 'list_field'=>'gender','master'=>$genders, 'master_id'=>'id', 'other_option'=>'disabled'])
@endcomponent

@if(in_array(Session::get('divisi_id'), [6]))
{{-- ses_final_id --}}
@component('components.list_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$respondent,'label_width1'=>'3','label_width2'=>'6','input_width1'=>'2', 'input_width2'=>'6','input_label'=>'Final SES', 'input_id'=>'ses_final_id', 'list_field'=>'ses_final','master'=>$ses_finals, 'master_id'=>'id'])
@endcomponent

{{-- age --}}
@component('components.common_input', ['for_create_edit'=> $for_create_edit, 'detail_table'=>$respondent,'data_type'=>'number', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'2', 'input_width2'=>'6','input_label'=>'Age', 'input_id'=>'usia'])
@endcomponent
@else
@component('components.list_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$respondent,'label_width1'=>'3','label_width2'=>'6','input_width1'=>'2', 'input_width2'=>'6','input_label'=>'Final SES', 'input_id'=>'ses_final_id', 'list_field'=>'ses_final','master'=>$ses_finals, 'master_id'=>'id', 'other_option'=>'disabled'])
@endcomponent
{{-- age --}}
@component('components.common_input', ['for_create_edit'=> $for_create_edit, 'detail_table'=>$respondent,'data_type'=>'number', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'2', 'input_width2'=>'6','input_label'=>'Age', 'input_id'=>'usia', 'other_option'=>'readonly'])
@endcomponent
@endif

{{-- age --}}
@component('components.common_input', ['for_create_edit'=> $for_create_edit, 'detail_table'=>$respondent,'data_type'=>'number', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'2', 'input_width2'=>'6','input_label'=>'Age', 'input_id'=>'usia', 'other_option'=>'readonly'])
@endcomponent

{{-- pekerjaan_id --}}
@component('components.list_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$respondent,'label_width1'=>'3','label_width2'=>'6','input_width1'=>'3', 'input_width2'=>'6','input_label'=>'Occupation', 'input_id'=>'pekerjaan_id', 'list_field'=>'pekerjaan','master'=>$pekerjaans, 'master_id'=>'id', 'other_option'=>'disabled'])
@endcomponent

{{-- pendidikan_id --}}
@component('components.list_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$respondent,'label_width1'=>'3','label_width2'=>'6','input_width1'=>'3', 'input_width2'=>'6','input_label'=>'Education', 'input_id'=>'pendidikan_id', 'list_field'=>'pendidikan','master'=>$pendidikans, 'master_id'=>'id', 'other_option'=>'disabled'])
@endcomponent

{{-- kota_id --}}
@component('components.list_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$respondent,'label_width1'=>'3','label_width2'=>'6','input_width1'=>'2', 'input_width2'=>'6','input_label'=>'City', 'input_id'=>'kota_id', 'list_field'=>'kota','master'=>$kotas, 'master_id'=>'id', 'other_option'=>'disabled'])
@endcomponent

{{-- mobilephone --}}
@component('components.common_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$respondent,'data_type'=>'text', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'2', 'input_width2'=>'6','input_label'=>'HP', 'input_id'=>'mobilephone', 'other_option'=>'readonly'])
@endcomponent
@endif

{{-- address --}}
@component('components.textarea_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$respondent,'label_width1'=>'3','label_width2'=>'6','input_width1'=>'6', 'input_width2'=>'6','input_label'=>'Address', 'input_id'=>'address', 'other_option'=>'readonly'])
@endcomponent

{{-- email --}}
@component('components.common_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$respondent, 'data_type'=>'email', 'label_width1'=>'3','label_width2'=>'12','input_width1'=>'6', 'input_width2'=>'12', 'input_label'=>'Email', 'input_id'=>'email', 'other_option'=>'readonly'])
@endcomponent

@if(is_null($respondent->worksheet) && in_array(Session::get('divisi_id'), [1, 2, 3]))
{{-- worksheet --}}
@component('components.list_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$respondent,'label_width1'=>'3','label_width2'=>'6','input_width1'=>'2', 'input_width2'=>'6','input_label'=>'Worksheet', 'input_id'=>'worksheet', 'list_field'=>'nama','master'=>$worksheet, 'master_id'=>'nama'])
@endcomponent
@else
@component('components.common_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$respondent,'data_type'=>'text', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'2', 'input_width2'=>'6','input_label'=>'Worksheet', 'input_id'=>'worksheet', 'other_option'=>'readonly'])
@endcomponent
@endif

@if(is_null($respondent->worksheet))
<div class="item form-group">
    <div class="col-md-6 col-sm-6 offset-md-3">
        <button class="btn btn-primary text-white" id="btn-form-qc" target="_blank" href="{{ url('/form_qc/qc_respondent')}}/{{$respondent->id}}" disabled>Worksheet Callback</button>
    </div>
</div>
@else
@if($checkWorksheet>0)
<div class="item form-group">
    <div class="col-md-6 col-sm-6 offset-md-3">
        <a class="btn btn-primary text-white" id="btn-form-qc" target="_blank" href="{{ url('/form_qc/qc_respondent')}}/{{$respondent->id}}">Worksheet Callback</a>
    </div>
</div>
@else
<div class="item form-group">
    <div class="col-md-6 col-sm-6 offset-md-3">
        <button type="button" class="btn btn-primary text-white" data-toggle="modal" data-target="#warningModal">Worksheet Callback</button>
    </div>
</div>
@endif
@endif

{{-- status_callback --}}
@component('components.list_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$respondent,'label_width1'=>'3','label_width2'=>'6','input_width1'=>'2', 'input_width2'=>'6','input_label'=>'Status Callback', 'input_id'=>'status_callback_id', 'list_field'=>'keterangan_callback','master'=>$status_callback, 'master_id'=>'id', 'other_option'=>'disabled'])
@endcomponent

{{-- keterangan_callback --}}
@component('components.textarea_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$respondent,'label_width1'=>'3','label_width2'=>'6','input_width1'=>'6', 'input_width2'=>'6','input_label'=>'Ket. Callback', 'input_id'=>'callback'])
@endcomponent

@if(Session::get('role_id') == 6)
@if($respondent->status_callback_id != 0 && $respondent->status_callback_id != 2)

{{-- link --}}
@component('components.common_input', ['for_create_edit'=> $for_create_edit, 'detail_table'=>$respondent,'data_type'=>'text', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'6', 'input_width2'=>'6','input_label'=>'Link Rekaman', 'input_id'=>'rekaman'])
@endcomponent

{{-- keterangan rekaman --}}
@component('components.textarea_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$respondent,'label_width1'=>'3','label_width2'=>'6','input_width1'=>'6', 'input_width2'=>'6','input_label'=>'Ket. Rekaman', 'input_id'=>'cek_rekaman'])
@endcomponent
@endif
@else

{{-- link --}}
@component('components.common_input', ['for_create_edit'=> $for_create_edit, 'detail_table'=>$respondent,'data_type'=>'text', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'6', 'input_width2'=>'6','input_label'=>'Link Rekaman', 'input_id'=>'rekaman'])
@endcomponent

{{-- keterangan rekaman --}}
@component('components.textarea_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$respondent,'label_width1'=>'3','label_width2'=>'6','input_width1'=>'6', 'input_width2'=>'6','input_label'=>'Ket. Rekaman', 'input_id'=>'cek_rekaman'])
@endcomponent
@endif

@if($dataRekaman)
<div class="item form-group">
    <div class="col-md-6 col-sm-6 offset-md-3">
        <a href="<?= url('form_pengecekan/') . "/" . $dataRekaman->id . "/edit" ?>" target="_blank" class="btn btn-primary text-white" id="btn-form-pengecekan">Form Pengecekan Rekaman</a>
    </div>
</div>
@else
<div class="item form-group">
    <div class="col-md-6 col-sm-6 offset-md-3">
        <button class="btn btn-primary" type="button" data-target="#formPengecekanModal" data-toggle="modal" id="btn-form-pengecekan">Form Pengecekan Rekaman</button>
    </div>
</div>
@endif

<div class="item form-group">
    <label class="col-form-label col-md-3 col-sm-3 col-xs-6 label-align" for="status_qc_id">Status QC </label>
    <div class="col-md-3 col-sm-3 col-xs-6">
        <select id="status_qc_id" name="status_qc_id" class="form-control pull-right">
            <option value="0">-</option>
            @foreach($status_qc as $db)
            @if($for_create_edit=='create')
            <option value="{{$db->id}}" {{ $db->id == old($input_id) ? "selected" : ""}}> {{$db->keterangan_qc}} </option>
            @else
            <option value="{{$db->id}}" {{ $db->id == $respondent->status_qc_id ? "selected" : ""}}> {{$db->keterangan_qc}} </option>
            @endif
            @endforeach
        </select>
        <button class="btn btn-sm btn-primary-outline" type="button" data-target="#logQcModal" data-toggle="modal" style="color: blue;">Status Sebelumnya</button>
    </div>
</div>

{{-- keterangan_qc --}}
@component('components.textarea_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$respondent,'label_width1'=>'3','label_width2'=>'6','input_width1'=>'6', 'input_width2'=>'6','input_label'=>'Ket. QC', 'input_id'=>'keterangan_qc'])
@endcomponent

@if(in_array($respondent->status_qc_id, array(2, 3, 6, 9)))
{{-- honor do --}}
@component('components.list_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$respondent,'label_width1'=>'3','label_width2'=>'6','input_width1'=>'3', 'input_width2'=>'6','input_label'=>'Honor DO', 'input_id'=>'kategori_honor_do', 'list_field'=>'nama_honor_do','master'=>$honorDo, 'master_id'=>'nama_honor_do'])
@endcomponent
@endif

{{-- is_valid_id --}}
@component('components.list_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$respondent,'label_width1'=>'3','label_width2'=>'6','input_width1'=>'2', 'input_width2'=>'6','input_label'=>'Ketersediaan Panel', 'input_id'=>'is_valid_id', 'list_field'=>'is_valid','master'=>$is_valids, 'master_id'=>'id',])
@endcomponent

{{-- Evidence --}}
<div class="item form-group mb-3">
    <label class="col-form-label col-md-3 col-sm-3} col-xs-6 label-align" for="inputGroupFile01">Evidence <a type="button" style="color: lightblue; text-decoration: none; cursor: help;" data-toggle="tooltip" data-placement="top" title="Maks. size 5MB"> <i class="fa fa-fw fa-question-circle"></i></a></label>
    <div class="col-md-3 col-sm-3 col-xs-6">
        <div class="custom-file">
            <input type="file" accept="image/x-png,image/jpeg,image/jpg,.mp3,audio/*" class="custom-file-input" name="evidence" id="inputGroupFile01">
            <label class="custom-file-label" for="inputGroupFile01" id="inputGroupFileText01">Choose file</label>
            @if($respondent->evidence)
            <a target="_blank" style="color: blue;" href="{{url('/teams/view')}}/{{$respondent->evidence}}">view</a>
            @endif
            @error('evidence')
            <small style="color: red;">
                {{$message}}
            </small>
            @enderror
        </div>
    </div>
</div>

@if (in_array(Session::get('divisi_id'), [1, 2]))
{{-- status_temuan_dp --}}
<div class="item form-group">
    <label class="col-form-label col-md-3 col-sm-3 col-xs-6 label-align" for="status_temuan_dp_id">Temuan DP
        <a type="button" style="color: lightblue; text-decoration: none; cursor: help;" data-toggle="tooltip" data-placement="left" data-html="true" title="<?php
                                                                                                                                                            foreach ($statusTemuanDp as $db) {
                                                                                                                                                                if ($db->detail_temuan_dp) {
                                                                                                                                                                    echo "<div style='display: inline-block; text-align: left;'><b>$db->keterangan_temuan_dp</b><br> $db->detail_temuan_dp</div><br> ";
                                                                                                                                                                }
                                                                                                                                                            }
                                                                                                                                                            ?>"> <i class="fa fa-fw fa-question-circle"></i></a></label>
    <div class="col-md-2 col-sm-2 col-xs-6">
        <select id="status_temuan_dp_id" name="status_temuan_dp_id" class="form-control pull-right">
            <option value="">-</option>
            @foreach($statusTemuanDp as $db)
            @if($for_create_edit=='create')
            <option value="{{$db->id}}" {{ $db->id == old($status_temuan_dp_id) ? "selected" : ""}}> {{$db->keterangan_temuan_dp}} </option>
            @else
            <option value="{{$db->id}}" {{ $db->id == $respondent->status_temuan_dp_id ? "selected" : ""}}> {{$db->keterangan_temuan_dp}} </option>
            @endif
            @endforeach
        </select>
        @error('status_temuan_dp_id')
        <div class="invalid-feedback">
            {{$message}}
        </div>
        @enderror
    </div>
</div>
{{-- temuan_dp --}}
@component('components.textarea_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$respondent,'label_width1'=>'3','label_width2'=>'6','input_width1'=>'6', 'input_width2'=>'6','input_label'=>'Ket Temuan DP', 'input_id'=>'keterangan_temuan_dp'])
@endcomponent
@endif

<!-- <div class="row"> -->

<!-- </div> -->