{{-- profile company --}}
@component('components.common_input', ['for_create_edit'=> $for_create_edit, 'detail_table'=>$vendor,'data_type'=>'text', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'6', 'input_width2'=>'6','input_label'=>'Profil Perusahaan', 'input_id'=>'profile_company'])
@endcomponent

{{-- address --}}
@component('components.textarea_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$vendor,'label_width1'=>'3','label_width2'=>'6','input_width1'=>'6', 'input_width2'=>'6','input_label'=>'Alamat', 'input_id'=>'alamat'])
@endcomponent

{{-- contact person --}}
@component('components.common_input', ['for_create_edit'=> $for_create_edit, 'detail_table'=>$vendor,'data_type'=>'text', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'6', 'input_width2'=>'6','input_label'=>'Contact Person', 'input_id'=>'contact_person'])
@endcomponent

{{-- cp kantor --}}
@component('components.common_input', ['for_create_edit'=> $for_create_edit, 'detail_table'=>$vendor,'data_type'=>'text', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'6', 'input_width2'=>'6','input_label'=>'No. Telp Kantor', 'input_id'=>'no_telp_kantor'])
@endcomponent

{{-- cp personal --}}
@component('components.common_input', ['for_create_edit'=> $for_create_edit, 'detail_table'=>$vendor,'data_type'=>'text', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'6', 'input_width2'=>'6','input_label'=>'No. Telp Personal', 'input_id'=>'no_telp_personal'])
@endcomponent

{{-- email --}}
@component('components.common_input', ['for_create_edit'=> $for_create_edit, 'detail_table'=>$vendor,'data_type'=>'email', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'6', 'input_width2'=>'6','input_label'=>'Email', 'input_id'=>'email'])
@endcomponent

{{-- website --}}
@component('components.common_input', ['for_create_edit'=> $for_create_edit, 'detail_table'=>$vendor,'data_type'=>'text', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'6', 'input_width2'=>'6','input_label'=>'Website', 'input_id'=>'website'])
@endcomponent

{{-- npwp --}}
@component('components.common_input', ['for_create_edit'=> $for_create_edit, 'detail_table'=>$vendor,'data_type'=>'text', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'6', 'input_width2'=>'6','input_label'=>'NPWP', 'input_id'=>'npwp'])
@endcomponen