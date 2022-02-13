<input type="hidden" id="project_kota_id" name="project_kota_id" 
value="@if(isset($project_kota->id)) {{$project_kota->id}} @endif"
>
<input type="hidden" id="user_id" name="user_id" 
value="{{session('user_id')}}"
>
{{-- jabatan_id --}}
@component('components.list_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$project_jabatan,'label_width1'=>'3','label_width2'=>'6','input_width1'=>'3', 'input_width2'=>'6','input_label'=>'Jabatan', 'input_id'=>'jabatan_id', 'list_field'=>'jabatan','master'=>$jabatans, 'master_id'=>'id'])
@endcomponent

