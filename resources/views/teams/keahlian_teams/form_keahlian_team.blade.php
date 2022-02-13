<input type="hidden" id="keahlian_id" name="keahlian_id" value="@if(isset($keahlian->id)) {{$keahlian->id}} @endif">
{{-- team_id --}}
@component('components.list_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$keahlian_team,'label_width1'=>'3','label_width2'=>'6','input_width1'=>'2', 'input_width2'=>'6','input_label'=>'Nama', 'input_id'=>'team_id', 'list_field'=>'nama','master'=>$teams, 'master_id'=>'id'])
@endcomponent