<!-- Show text input 
parameters:
- $label_width1
- $label_width2
- $input_width1
- $input_width2
- $input_id
- $input_label
- $master1111
- $master_id
@return \Illuminate\Http\Response -->

<div class="item form-group">
    <label class="col-form-label col-md-{{$label_width1}} col-sm-{{$label_width1}} col-xs-{{$label_width2}} label-align" for="{{$input_id}}">{{$input_label}} </label>
    <div class="col-md-{{$input_width1}} col-sm-{{$input_width1}} col-xs-{{$input_width2}}">
        <select id="{{$input_id}}" name="{{$input_id}}" class="form-control pull-right" @isset($other_option) {{$other_option }} @endisset>
            <option value="">-</option>
            @foreach($master as $db)
            @if($for_create_edit=='create')
            <option value="{{$db->$master_id}}" {{ $db->$master_id == old($input_id) ? "selected" : ""}}> {{$db->$list_field}} </option>
            @else
            <option value="{{$db->$master_id}}" {{ $db->$master_id == $detail_table->$input_id ? "selected" : ""}}> {{$db->$list_field}} </option>
            @endif
            @endforeach
        </select>
        @error($input_id)
        <div class="invalid-feedback">
            {{$message}}
        </div>
        @enderror
    </div>
</div>