<input type="hidden" id="user_id" name="user_id" value="{{session('user_id')}}">

{{-- project --}}
@component('components.common_input', ['for_create_edit'=> $for_create_edit, 'detail_table'=>$project,'data_type'=>'text', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'6', 'input_width2'=>'6','input_label'=>'Nama Project', 'input_id'=>'nama'])
@endcomponent

{{-- customer_id --}}
@component('components.list_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$project,'label_width1'=>'3','label_width2'=>'6','input_width1'=>'3', 'input_width2'=>'6','input_label'=>'Customer', 'input_id'=>'customer_id', 'list_field'=>'nama','master'=>$customers, 'master_id'=>'id_perusahaan'])
@endcomponent

{{-- project_date --}}
@component('components.common_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$project,'data_type'=>'date', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'3', 'input_width2'=>'6','input_label'=>'Tanggal Project', 'input_id'=>'project_date'])
@endcomponent

{{-- project_start_target --}}
@component('components.common_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$project,'data_type'=>'date', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'3', 'input_width2'=>'6','input_label'=>'Tanggal Start Target', 'input_id'=>'date_start_target'])
@endcomponent

{{-- project_finish_target --}}
@component('components.common_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$project,'data_type'=>'date', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'3', 'input_width2'=>'6','input_label'=>'Tanggal Finish Target', 'input_id'=>'date_finish_target'])
@endcomponent

{{-- project_start_real --}}
@component('components.common_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$project,'data_type'=>'date', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'3', 'input_width2'=>'6','input_label'=>'Tanggal Start Real', 'input_id'=>'date_start_real'])
@endcomponent

{{-- project_finish_real --}}
@component('components.common_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$project,'data_type'=>'date', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'3', 'input_width2'=>'6','input_label'=>'Tanggal Finish Real', 'input_id'=>'date_finish_real'])
@endcomponent

{{-- ket --}}
@component('components.common_input', ['for_create_edit'=> $for_create_edit, 'detail_table'=>$project,'data_type'=>'text', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'6', 'input_width2'=>'6','input_label'=>'Ket Project', 'input_id'=>'ket'])
@endcomponent