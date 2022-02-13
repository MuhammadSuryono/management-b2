{{-- kota --}}
@component('components.list_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$kelurahan,'label_width1'=>'3','label_width2'=>'6','input_width1'=>'3', 'input_width2'=>'6', 'input_label'=>'Kota', 'input_id'=>'kota_id', 'list_field'=>'kota','master'=>$kotas, 'master_id'=>'id'])
@endcomponent

{{-- kelurahan --}}
@component('components.common_input', ['for_create_edit'=> $for_create_edit, 'detail_table'=>$kelurahan,'data_type'=>'text', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'6', 'input_width2'=>'6','input_label'=>'Kelurahan', 'input_id'=>'kelurahan'])
@endcomponent