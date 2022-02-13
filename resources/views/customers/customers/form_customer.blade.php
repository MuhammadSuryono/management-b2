{{-- customer --}}
@component('components.common_input', ['for_create_edit'=> $for_create_edit, 'detail_table'=>$customer,'data_type'=>'text', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'6', 'input_width2'=>'6','input_label'=>'Nama Perusahaan', 'input_id'=>'nama'])
@endcomponent

{{-- alamat --}}
@component('components.textarea_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$customer,'label_width1'=>'3','label_width2'=>'6','input_width1'=>'6', 'input_width2'=>'6','input_label'=>'Alamat', 'input_id'=>'alamat'])
@endcomponent

{{-- kota_id --}}
@component('components.list_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$customer,'label_width1'=>'3','label_width2'=>'6','input_width1'=>'2', 'input_width2'=>'6','input_label'=>'Kota', 'input_id'=>'kota_id', 'list_field'=>'kota','master'=>$kotas, 'master_id'=>'id'])
@endcomponent

