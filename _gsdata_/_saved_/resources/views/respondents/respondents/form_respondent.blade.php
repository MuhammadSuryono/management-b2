
    {{-- respname --}}
    @component('components.common_input', ['for_create_edit'=> $for_create_edit, 'detail_table'=>$respondent,'data_type'=>'text', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'6', 'input_width2'=>'6','input_label'=>'Nama', 'input_id'=>'respname'])
    @endcomponent

    {{-- gender_id --}}
    @component('components.list_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$respondent,'label_width1'=>'3','label_width2'=>'6','input_width1'=>'2', 'input_width2'=>'6','input_label'=>'Gender', 'input_id'=>'gender_id', 'list_field'=>'gender','master'=>$genders, 'master_id'=>'id',])
    @endcomponent

    {{-- ses_final_id --}}
    @component('components.list_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$respondent,'label_width1'=>'3','label_width2'=>'6','input_width1'=>'2', 'input_width2'=>'6','input_label'=>'Final SES', 'input_id'=>'ses_final_id', 'list_field'=>'ses_final','master'=>$ses_finals, 'master_id'=>'id',])
    @endcomponent

    {{-- address --}}
    @component('components.textarea_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$respondent,'label_width1'=>'3','label_width2'=>'6','input_width1'=>'6', 'input_width2'=>'6','input_label'=>'address', 'input_id'=>'address'])
    @endcomponent

    {{-- kota_id --}}
    @component('components.list_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$respondent,'label_width1'=>'3','label_width2'=>'6','input_width1'=>'2', 'input_width2'=>'6','input_label'=>'City', 'input_id'=>'kota_id', 'list_field'=>'kota','master'=>$kotas, 'master_id'=>'id',])
    @endcomponent

    {{-- email --}}
    @component('components.common_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$respondent, 'data_type'=>'email', 'label_width1'=>'3','label_width2'=>'12','input_width1'=>'6', 'input_width2'=>'12', 'input_label'=>'Email', 'input_id'=>'email'])
    @endcomponent

    {{-- pekerjaan_id --}}
    @component('components.list_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$respondent,'label_width1'=>'3','label_width2'=>'6','input_width1'=>'3', 'input_width2'=>'6','input_label'=>'Occupation', 'input_id'=>'pekerjaan_id', 'list_field'=>'pekerjaan','master'=>$pekerjaans, 'master_id'=>'id',])
    @endcomponent

    {{-- pendidikan_id --}}
    @component('components.list_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$respondent,'label_width1'=>'3','label_width2'=>'6','input_width1'=>'3', 'input_width2'=>'6','input_label'=>'Education', 'input_id'=>'pendidikan_id', 'list_field'=>'pendidikan','master'=>$pendidikans, 'master_id'=>'id',])
    @endcomponent

    {{-- mobilephone --}}
    @component('components.common_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$respondent,'data_type'=>'text', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'2', 'input_width2'=>'6','input_label'=>'HP', 'input_id'=>'mobilephone'])
    @endcomponent

    {{-- isvalid_id --}}
    @component('components.list_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$respondent,'label_width1'=>'3','label_width2'=>'6','input_width1'=>'2', 'input_width2'=>'6','input_label'=>'Valid', 'input_id'=>'isvalid_id', 'list_field'=>'isvalid','master'=>$isvalids, 'master_id'=>'id',])
    @endcomponent

