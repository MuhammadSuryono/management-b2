<input type="hidden" id="layanan_id" name="layanan_id" value="@if(isset($layanan->id)) {{$layanan->id}} @endif">
{{-- team_id --}}
@component('components.list_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$layanan_vendor,'label_width1'=>'3','label_width2'=>'6','input_width1'=>'2', 'input_width2'=>'6','input_label'=>'Nama Perusahaan', 'input_id'=>'vendor_id', 'list_field'=>'nama_perusahaan','master'=>$vendor, 'master_id'=>'id'])
@endcomponent