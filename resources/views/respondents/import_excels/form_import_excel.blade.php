<!-- excel_file
jumlah_record
userid
created_at -->

{{-- excel_file --}}
    @component('components.common_input', ['for_create_edit'=> $for_create_edit, 'detail_table'=>$import_excel,'data_type'=>'file', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'6', 'input_width2'=>'6','input_label'=>'Excel File', 'input_id'=>'excel_file'])
    @endcomponent

@if($for_create_edit=='edit')
{{-- jumlah_record --}}
    @component('components.common_input', ['for_create_edit'=> $for_create_edit, 'detail_table'=>$import_excel,'data_type'=>'number', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'2', 'input_width2'=>'6','input_label'=>'Jumlah', 'input_id'=>'jumlah_record'])
    @endcomponent

{{-- userid --}}
    @component('components.common_input', ['for_create_edit'=> $for_create_edit, 'detail_table'=>$import_excel,'data_type'=>'number', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'3', 'input_width2'=>'6','input_label'=>'User', 'input_id'=>'userid'])
    @endcomponent

{{-- created_at --}}
    @component('components.common_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$import_excel,'data_type'=>'datetime', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'3','input_width2'=>'6','input_label'=>'Waktu input', 'input_id'=>'created_at'])
    @endcomponent
@endif