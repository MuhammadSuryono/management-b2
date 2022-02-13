
<!-- Show text input 
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
- disabled

@return \Illuminate\Http\Response -->

{{-- input_text --}}
<div class="item form-group">
    <label class="col-form-label col-md-{{$label_width1}} col-sm-{{$label_width1}} col-xs-{{$label_width2}} label-align" for="{{$input_id}}">{{$input_label}} </label>
    <div class="col-md-{{$input_width1}} col-sm-{{$input_width1}} col-xs-{{$input_width2}}">
        <input type="{{$data_type}}" id="{{$input_id}}" name="{{$input_id}}" 
            class="form-control @error($input_id) is-invalid @enderror " 
            value="@if($for_create_edit=='create'){{ date_format(date_create(date('Y-m-d')), 'Y-m-d')  }}@else{{$detail_table->$input_id}}@endif"
            @isset($other_option) {{$other_option }} @endisset
            >
        @error($input_id)
        <div class="invalid-feedback">
            {{$message}}
        </div>
        @enderror
    </div>
</div>