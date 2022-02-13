<input type="hidden" id="user_id" name="user_id" 
value="{{session('user_id')}}">

    {{-- project_kegiatan_id --}}
    @component('components.list_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$project_absensi,'label_width1'=>'3','label_width2'=>'6','input_width1'=>'2', 'input_width2'=>'6','input_label'=>'Kegiatan', 'input_id'=>'project_kegiatan_id', 'list_field'=>'id','master'=>$project_kegiatans, 'master_id'=>'id',])
    @endcomponent