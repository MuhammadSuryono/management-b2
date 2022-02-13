<input type="hidden" id="vendor_id" name="vendor_id" value="@if(isset($vendor->id)) {{$vendor->id}} @endif">
{{-- jabatan_id --}}
@component('components.list_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$vendor_layanan,'label_width1'=>'3','label_width2'=>'6','input_width1'=>'2', 'input_width2'=>'6','input_label'=>'Kategori Layanan', 'input_id'=>'layanan_id', 'list_field'=>'layanan','master'=>$layanan, 'master_id'=>'id'])
@endcomponent