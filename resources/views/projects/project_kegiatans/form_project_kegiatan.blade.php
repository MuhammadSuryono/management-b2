<input type="hidden" id="project_plan_id" name="project_plan_id" value="@if(isset($project_plan->id)) {{$project_plan->id}} @endif">

{{-- lokasi_id --}}
@component('components.list_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$project_kegiatan,'label_width1'=>'3','label_width2'=>'6','input_width1'=>'3', 'input_width2'=>'6','input_label'=>'Lokasi', 'input_id'=>'lokasi_id', 'list_field'=>'lokasi','master'=>$lokasis, 'master_id'=>'id',])
@endcomponent

{{-- tanggal --}}
@component('components.common_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$project_kegiatan,'data_type'=>'date', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'2','input_width2'=>'6','input_label'=>'Tanggal', 'input_id'=>'tanggal'])
@endcomponent

{{-- jam --}}
@component('components.common_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$project_kegiatan,'data_type'=>'time', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'2','input_width2'=>'6','input_label'=>'Jam', 'input_id'=>'jam'])
@endcomponent

{{-- absen_tutup --}}
@component('components.common_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$project_kegiatan,'data_type'=>'time', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'2','input_width2'=>'6','input_label'=>'Absen ditutup jam', 'input_id'=>'absen_tutup'])
@endcomponent

{{-- tema --}}
@component('components.common_input', ['for_create_edit'=> $for_create_edit, 'detail_table'=>$project_kegiatan,'data_type'=>'text', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'6', 'input_width2'=>'6','input_label'=>'Tema', 'input_id'=>'tema'])
@endcomponent

{{-- link --}}
@component('components.common_input', ['for_create_edit'=> $for_create_edit, 'detail_table'=>$project_kegiatan,'data_type'=>'text', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'6', 'input_width2'=>'6','input_label'=>'Link', 'input_id'=>'link'])
@endcomponent

@if($for_create_edit=='edit' and $project_kegiatan->tanggal == date('Y-m-d')
and $project_kegiatan->absen_tutup >= date('H:i:s') )
{{-- button Close QR --}}
@component('components.button', ['for_create_edit'=> $for_create_edit, 'data_type'=>'text', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'6', 'input_width2'=>'6',
'btn_class'=>'btn btn-success', 'btn_id'=>'btn_Close_kegiatan', 'btn_label'=>'Tutup kegiatan QR'])
@endcomponent
@endif