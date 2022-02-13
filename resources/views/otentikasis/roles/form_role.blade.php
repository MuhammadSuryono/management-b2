{{-- user_updated --}}
<input type="hidden" id="user_id" name="user_id" 
value="{{session('user_id')}}">

{{-- role --}}
@component('components.common_input', ['for_create_edit'=> $for_create_edit, 'detail_table'=>$role,'data_type'=>'text', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'6', 'input_width2'=>'6','input_label'=>'Role', 'input_id'=>'role'])
@endcomponent
