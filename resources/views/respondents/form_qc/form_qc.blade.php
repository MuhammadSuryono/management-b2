<input type="hidden" id="id" name="id" value="{{$data_qc->id}}">

{{-- tanggal qc --}}
@component('components.common_input', ['for_create_edit'=> $for_create_edit, 'detail_table'=>$data_qc,'data_type'=>'date', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'6', 'input_width2'=>'6','input_label'=>'Tanggal QC', 'input_id'=>'tanggal_qc'])
@endcomponent
{{-- Jam QC --}}
@component('components.common_input', ['for_create_edit'=> $for_create_edit, 'detail_table'=>$data_qc,'data_type'=>'time', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'6', 'input_width2'=>'6','input_label'=>'Jam QC', 'input_id'=>'jam_qc'])
@endcomponent
{{-- QC ke --}}
@component('components.common_input', ['for_create_edit'=> $for_create_edit, 'detail_table'=>$data_qc,'data_type'=>'number', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'6', 'input_width2'=>'6','input_label'=>'QC ke', 'input_id'=>'callback'])
@endcomponent
{{-- Screenshoot --}}
<div class="item form-group">
    <label class="col-form-label col-md-3 col-sm-3 col-xs-6 label-align" for="inputGroupFile01">Screenshoot</label>
    <div class="col-md-3 col-sm-3 col-xs-6">
        <div class="custom-file">
            <input type="file" accept="image/x-png,image/jpeg,image/jpg" class="custom-file-input" name="fileSs" id="fileSs">
            <label class="custom-file-label" for="fileSs" id="filSsText">Choose file</label>
            @if($data_qc->screenshoot)
            <a target="_blank" style="color: blue;" href="{{url('/form_qc/view')}}/{{$data_qc->screenshoot}}">view</a>
            @endif
            @error('fileSs')
            <small style="color: red;">
                {{$message}}
            </small>
            @enderror
        </div>
    </div>
</div>