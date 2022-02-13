<input type="hidden" id="team_id" name="team_id" value="@if(isset($team->id)) {{$team->id}} @endif">
{{-- keahlian_id --}}
@component('components.list_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$team_keahlian,'label_width1'=>'3','label_width2'=>'6','input_width1'=>'2', 'input_width2'=>'6','input_label'=>'keahlian', 'input_id'=>'keahlian_id', 'list_field'=>'keahlian','master'=>$keahlian, 'master_id'=>'id'])
@endcomponent