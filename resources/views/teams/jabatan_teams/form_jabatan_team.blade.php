<input type="hidden" id="jabatan_id" name="jabatan_id" 
value="@if(isset($jabatan->id)) {{$jabatan->id}} @endif"
>
{{-- team_id --}}
@component('components.list_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$jabatan_team,'label_width1'=>'3','label_width2'=>'6','input_width1'=>'2', 'input_width2'=>'6','input_label'=>'Nama', 'input_id'=>'team_id', 'list_field'=>'nama','master'=>$teams, 'master_id'=>'id'])
@endcomponent


