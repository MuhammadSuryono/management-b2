<input type="hidden" id="project_id" name="project_id" 
value="@if(isset($project->id)) {{$project->id}} @endif"
>
<input type="hidden" id="user_id" name="user_id" 
value="{{session('user_id')}}"
>
{{-- kota_id --}}
@component('components.list_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$project_kota,'label_width1'=>'3','label_width2'=>'6','input_width1'=>'3', 'input_width2'=>'6','input_label'=>'Kota', 'input_id'=>'kota_id', 'list_field'=>'kota','master'=>$kotas, 'master_id'=>'id'])
@endcomponent

{{-- jumlah --}}
@component('components.common_input', ['for_create_edit'=> $for_create_edit, 'detail_table'=>$project_kota,'data_type'=>'number', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'2', 'input_width2'=>'6','input_label'=>'Jumlah', 'input_id'=>'jumlah'])
@endcomponent

