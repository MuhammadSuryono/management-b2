<!-- Show common input 
parameters:
- for_create_edit: 'create', 'edit'
- data_type : 'text', 'date', 'email'
- label_width1
- label_width2
- input_width1
- input_width2
- master
- input_id
- input_label
@return \Illuminate\Http\Response -->

<input type="hidden" id="{{$input_id}}" name="{{$input_id}}" 
value="@if($for_create_edit=='create'){{old($input_id)}}@else{{$detail_table->$input_id}}@endif"
>
