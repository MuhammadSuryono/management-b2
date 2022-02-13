<input type="hidden" id="user_id" name="user_id" value="{{session('user_id')}}">
{{-- task --}}
@component('components.common_input', ['for_create_edit'=> $for_create_edit, 'detail_table'=>$task,'data_type'=>'text', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'6', 'input_width2'=>'6','input_label'=>'Task', 'input_id'=>'nama_kegiatan'])
@endcomponent

{{-- has_absensi_id --}}
@component('components.list_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$task,'label_width1'=>'3','label_width2'=>'6','input_width1'=>'2', 'input_width2'=>'6','input_label'=>'Has Absensi ?', 'input_id'=>'has_presence', 'list_field'=>'yes_no','master'=>$yes_nos, 'master_id'=>'id'])
@endcomponent