<!-- Show text input 
parameters:
- for_create_edit: 'create', 'edit'
- data_type : 'text', 'date', 'email'
- label_width1
- label_width2
- input_width1
- input_width2
- btn_class
- btn_id
- btn_Label

@return \Illuminate\Http\Response -->

{{-- input_text --}}
<div class="item form-group @if(isset($div_class)){{$div_class}} @else{{''}}@endif">
    <label class="col-form-label col-md-{{$label_width1}} col-sm-{{$label_width1}} 
    col-xs-{{$label_width2}} label-align"> </label>
    <div class="col-md-{{$input_width1}} col-sm-{{$input_width1}} col-xs-{{$input_width2}}">
        <button type="button" class="{{$btn_class}}" id="{{$btn_id}}" data-toggle="@if(isset($btn_toggle)){{$btn_toggle}} @else{{''}}@endif" data-target="@if(isset($btn_target)){{$btn_target}} @else{{''}}@endif">{{$btn_label}}</button>
    </div>
</div>