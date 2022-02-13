view<input type="hidden" id="project_jabatan_id" name="project_jabatan_id" value="@if(isset($project_jabatan->id)) {{$project_jabatan->id}} @endif">
<input type="hidden" id="user_id" name="user_id" value="{{session('user_id')}}">

{{-- team_id --}}
@component('components.list_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$project_team,'label_width1'=>'3','label_width2'=>'6','input_width1'=>'3', 'input_width2'=>'6','input_label'=>'Team', 'input_id'=>'team_id', 'list_field'=>'nama','master'=>$teams, 'master_id'=>'id'])
@endcomponent