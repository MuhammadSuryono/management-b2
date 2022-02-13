<input type="hidden" id="user_id" name="user_id" 
value="{{session('user_id')}}">


{{-- sebutan --}}
@component('components.common_input', ['for_create_edit'=> $for_create_edit, 'detail_table'=>$customer_pic,'data_type'=>'text', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'6', 'input_width2'=>'6','input_label'=>'Sebutan/Panggilan', 'input_id'=>'sebutan'])
@endcomponent

{{-- nama --}}
@component('components.common_input', ['for_create_edit'=> $for_create_edit, 'detail_table'=>$customer_pic,'data_type'=>'text', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'6', 'input_width2'=>'6','input_label'=>'Nama', 'input_id'=>'nama'])
@endcomponent

{{-- customer_id --}}
@component('components.list_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$customer_pic,'label_width1'=>'3','label_width2'=>'6','input_width1'=>'2', 'input_width2'=>'6','input_label'=>'Perusahaan Customer', 'input_id'=>'customer_id', 'list_field'=>'nama','master'=>$customers, 'master_id'=>'id'])
@endcomponent

{{-- hp --}}
@component('components.common_input', ['for_create_edit'=> $for_create_edit, 'detail_table'=>$customer_pic,'data_type'=>'text', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'6', 'input_width2'=>'6','input_label'=>'HP', 'input_id'=>'hp'])
@endcomponent

{{-- email --}}
@component('components.common_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$customer_pic, 'data_type'=>'email', 'label_width1'=>'3','label_width2'=>'12','input_width1'=>'6', 'input_width2'=>'12', 'input_label'=>'Email', 'input_id'=>'email'])
@endcomponent

{{-- gender_id --}}
@component('components.list_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$customer_pic,'label_width1'=>'3','label_width2'=>'6','input_width1'=>'2', 'input_width2'=>'6','input_label'=>'Gender', 'input_id'=>'gender_id', 'list_field'=>'gender','master'=>$genders, 'master_id'=>'id'])
@endcomponent

