{{-- profile company --}}
@component('components.common_input', ['for_create_edit'=> $for_create_edit, 'detail_table'=>$vendor,'data_type'=>'text', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'6', 'input_width2'=>'6','input_label'=>'Nama Perusahaan', 'input_id'=>'nama_perusahaan'])
@endcomponent

{{-- address --}}
@component('components.textarea_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$vendor,'label_width1'=>'3','label_width2'=>'6','input_width1'=>'6', 'input_width2'=>'6','input_label'=>'Alamat', 'input_id'=>'alamat'])
@endcomponent

{{-- contact person --}}
@component('components.common_input', ['for_create_edit'=> $for_create_edit, 'detail_table'=>$vendor,'data_type'=>'text', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'6', 'input_width2'=>'6','input_label'=>'Contact Person', 'input_id'=>'contact_person'])
@endcomponent

{{-- cp kantor --}}
@component('components.common_input', ['for_create_edit'=> $for_create_edit, 'detail_table'=>$vendor,'data_type'=>'text', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'6', 'input_width2'=>'6','input_label'=>'No. Telp Kantor', 'input_id'=>'no_telp_kantor'])
@endcomponent

{{-- cp personal --}}
@component('components.common_input', ['for_create_edit'=> $for_create_edit, 'detail_table'=>$vendor,'data_type'=>'text', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'6', 'input_width2'=>'6','input_label'=>'No. Telp Personal', 'input_id'=>'no_telp_personal'])
@endcomponent

{{-- email --}}
@component('components.common_input', ['for_create_edit'=> $for_create_edit, 'detail_table'=>$vendor,'data_type'=>'email', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'6', 'input_width2'=>'6','input_label'=>'Email', 'input_id'=>'email'])
@endcomponent

{{-- website --}}
@component('components.common_input', ['for_create_edit'=> $for_create_edit, 'detail_table'=>$vendor,'data_type'=>'text', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'6', 'input_width2'=>'6','input_label'=>'Website', 'input_id'=>'website'])
@endcomponent

{{-- npwp --}}
@component('components.common_input', ['for_create_edit'=> $for_create_edit, 'detail_table'=>$vendor,'data_type'=>'text', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'6', 'input_width2'=>'6','input_label'=>'NPWP', 'input_id'=>'npwp'])
@endcomponent


<div class="item form-group">
    <label class="col-form-label col-md-3 col-sm-3} col-xs-6 label-align" for="inputGroupFile01">Bukti NPWP </label>
    <div class="col-md-3 col-sm-3 col-xs-6">
        <div class="custom-file">
            <input type="file" accept="image/x-png,image/jpeg,image/jpg" class="custom-file-input" name="file" id="inputGroupFile01" value="@if($for_create_edit!='create')<?= ($vendor->bukti_npwp) ? $vendor->bukti_npwp : '' ?> @endif">
            <label class="custom-file-label" for="inputGroupFile01" id="inputGroupFileText01">@if($for_create_edit!='create')<?= ($vendor->bukti_npwp) ? $vendor->bukti_npwp : 'Choose File' ?> @else Choose File @endif</label>
            @error('bukti_rekening')
            <small style="color: red;">
                {{$message}}
            </small>
            @enderror
        </div>
    </div>
</div>

@section('javascript')
<script>
    $('#qrscan_form').prop('enctype', 'multipart/form-data')
    const inputFile1 = $('#inputGroupFile01');
    inputFile1.change(function() {
        let string = $(this).val().split('\\');
        $('#inputGroupFileText01').text(string[string.length - 1]);
    })
</script>
@endsection