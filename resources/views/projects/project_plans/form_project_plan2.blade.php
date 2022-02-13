<input type="hidden" id="project_id" name="project_id" 
value="{{ session('current_project_id') }} "
>
<input type="hidden" id="user_id" name="user_id" 
value="{{session('user_id')}}"
>
{{-- urutan --}}
{{-- @component('components.common_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$project_plan,'data_type'=>'number', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'3', 'input_width2'=>'6','input_label'=>'No', 'input_id'=>'urutan'])
@endcomponent --}}

{{-- task_id --}}
@component('components.list_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$project_plan,'label_width1'=>'3','label_width2'=>'6','input_width1'=>'3', 'input_width2'=>'6','input_label'=>'Task', 'input_id'=>'task_id', 'list_field'=>'task','master'=>$tasks, 'master_id'=>'id'])
@endcomponent

{{-- N --}}
@component('components.common_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$project_plan,'data_type'=>'number', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'3', 'input_width2'=>'6','input_label'=>'N responden', 'input_id'=>'n_target'])
@endcomponent

{{-- date_start_target --}}
@component('components.common_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$project_plan,'data_type'=>'date', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'3', 'input_width2'=>'6','input_label'=>'Tanggal Mulai', 'input_id'=>'date_start_target'])
@endcomponent

{{-- date_finish_target --}}
@component('components.common_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$project_plan,'data_type'=>'date', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'3', 'input_width2'=>'6','input_label'=>'Tanggal Selesai', 'input_id'=>'date_finish_target'])
@endcomponent

{{-- ket --}}
@component('components.common_input', ['for_create_edit'=> $for_create_edit, 'detail_table'=>$project_plan,'data_type'=>'text', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'6', 'input_width2'=>'6','input_label'=>'Ket', 'input_id'=>'ket'])
@endcomponent
