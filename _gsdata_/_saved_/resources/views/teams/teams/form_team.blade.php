<input type="hidden" id="user_id" name="user_id" 
value="{{session('user_id')}}"
>

{{-- nama --}}
@component('components.common_input', ['for_create_edit'=> $for_create_edit, 'detail_table'=>$team,'data_type'=>'text', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'6', 'input_width2'=>'6','input_label'=>'Nama', 'input_id'=>'nama'])
@endcomponent

{{-- genderid --}}
@component('components.list_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$team,'label_width1'=>'3','label_width2'=>'6','input_width1'=>'3', 'input_width2'=>'6','input_label'=>'Gender', 'input_id'=>'gender_id', 'list_field'=>'gender','master'=>$genders, 'master_id'=>'id',])
@endcomponent

{{-- ktp --}}
@component('components.common_input', ['for_create_edit'=> $for_create_edit, 'detail_table'=>$team,'data_type'=>'text', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'6', 'input_width2'=>'6','input_label'=>'KTP', 'input_id'=>'ktp'])
@endcomponent

{{-- hp --}}
@component('components.common_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$team,'data_type'=>'number', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'3', 'input_width2'=>'6','input_label'=>'HP', 'input_id'=>'hp'])
@endcomponent

{{-- email --}}
@component('components.common_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$team, 'data_type'=>'email', 'label_width1'=>'3','label_width2'=>'12','input_width1'=>'6', 'input_width2'=>'12', 'input_label'=>'Email', 'input_id'=>'email'])
@endcomponent

{{-- alamat --}}
@component('components.textarea_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$team,'label_width1'=>'3','label_width2'=>'6','input_width1'=>'6', 'input_width2'=>'6','input_label'=>'Alamat', 'input_id'=>'alamat'])
@endcomponent

{{-- kotaid --}}
@component('components.list_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$team,'label_width1'=>'3','label_width2'=>'6','input_width1'=>'3', 'input_width2'=>'6', 'input_label'=>'Kota ', 'input_id'=>'kota_id', 'list_field'=>'kota','master'=>$kotas, 'master_id'=>'id',])
@endcomponent

{{-- tgl_lahir --}}
@component('components.common_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$team,'data_type'=>'date', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'3', 'input_width2'=>'6','input_label'=>'Tanggal Lahir', 'input_id'=>'tgl_lahir'])
@endcomponent

{{-- pekerjaanid --}}
@Component('components.list_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$team,'label_width1'=>'3','label_width2'=>'6','input_width1'=>'3', 'input_width2'=>'6', 'input_label'=>'Pekerjaan ', 'input_id'=>'pekerjaan_id', 'list_field'=>'pekerjaan','master'=>$pekerjaans, 'master_id'=>'id',])
@Endcomponent

{{-- pendidikanid --}}
@Component('components.list_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$team,'label_width1'=>'3','label_width2'=>'6','input_width1'=>'3', 'input_width2'=>'6', 'input_label'=>'Pendidikan ', 'input_id'=>'pendidikan_id', 'list_field'=>'pendidikan','master'=>$pendidikans, 'master_id'=>'id',])
@Endcomponent

{{-- tgl_registrasi --}}
@component('components.date_input_dev_today', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$team,'data_type'=>'date', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'3', 'input_width2'=>'6','input_label'=>'Tanggal Registrasi', 'input_id'=>'tgl_registrasi'])
@endcomponent
