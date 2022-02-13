<input type="hidden" id="old_password" name="old_password" value="{{session('password')}}">
<div class="item form-group">
    <label class="col-form-label col-md-3 col-sm-6 col-xs-6 label-align" for="current_password">Password Sekarang</label>
    <div class="col-md-3 col-sm-3 col-xs-6">
        <input type="password" id="current_password" name="current_password" 
            class="form-control @error('current_password') is-invalid @enderror" 
            value="">
        @error('current_password')
        <div class="invalid-feedback">
            {{$message}}
        </div>
        @enderror
    </div>
</div>
@component('components.common_input', ['for_create_edit'=> 'create', 'detail_table'=>$user,'data_type'=>'password', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'3', 'input_width2'=>'6','input_label'=>'Password Baru', 'input_id'=>'new_password'])
@endcomponent
{{-- conf_password --}}
<div class="item form-group">
    <label class="col-form-label col-md-3 col-sm-6 col-xs-6 label-align" for="conf_password">Masukkan Ulang Password Baru</label>
    <div class="col-md-3 col-sm-3 col-xs-6">
        <input type="password" id="conf_password" name="conf_password" 
            class="form-control @error('conf_password') is-invalid @enderror" 
            value="@if($for_create_edit=='create'){{old('conf_password')}}@else{{$user->password}}@endif">
        @error('conf_password')
        <div class="invalid-feedback">
            {{$message}}
        </div>
        @enderror
    </div>
</div>
