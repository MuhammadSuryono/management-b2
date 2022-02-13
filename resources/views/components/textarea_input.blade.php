<!-- Show text input 
parameters:
- label_width1
- label_width2
- input_width1
- input_width2
- input_id
- input_label

@return \Illuminate\Http\Response -->
{{-- text area --}}
<div class="item form-group">
    <label class="col-form-label col-md-{{$label_width1}} col-sm-{{$label_width1}} col-xs-{{$label_width2}} label-align" for="{{$input_id}}">{{$input_label}} </label>
    <div class="col-md-{{$input_width1}} col-sm-{{$input_width1}} col-xs-{{$input_width2}}">
        <textarea id="{{$input_id}}" class="form-control" name="{{$input_id}}" data-parsley-trigger="keyup" data-parsley-minlength="20" data-parsley-maxlength="100" data-parsley-minlength-message="Max 100 huruf" data-parsley-validation-threshold="10" rows="<?= isset($rows) ? $rows : '2' ?>" @isset($other_option) {{$other_option }} @endisset>{{ $for_create_edit=='create' ? old($input_id)  : $detail_table->$input_id}}</textarea>
        @error($input_id)
        <div class="invalid-feedback">
            {{$message}}
        </div>
        @enderror
    </div>
</div>