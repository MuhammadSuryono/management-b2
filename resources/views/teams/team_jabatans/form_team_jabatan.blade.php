<input type="hidden" id="team_id" name="team_id" 
value="@if(isset($team->id)) {{$team->id}} @endif"
>
{{-- jabatan_id --}}
@component('components.list_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$team_jabatan,'label_width1'=>'3','label_width2'=>'6','input_width1'=>'2', 'input_width2'=>'6','input_label'=>'Jabatan', 'input_id'=>'jabatan_id', 'list_field'=>'jabatan','master'=>$jabatans, 'master_id'=>'id'])
@endcomponent


