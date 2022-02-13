{{-- user_login --}}

<?php $other_option = '';
if ($for_create_edit == 'edit')
    $other_option = 'readonly';
?>
{{-- user_login --}}
@component('components.common_input', ['for_create_edit'=> $for_create_edit, 'detail_table'=>$user,'data_type'=>'text', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'6', 'input_width2'=>'6','input_label'=>'User-Login', 'input_id'=>'user_login','other_option'=>$other_option])
@endcomponent

{{-- nama --}}
@component('components.common_input', ['for_create_edit'=> $for_create_edit, 'detail_table'=>$user,'data_type'=>'text', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'6', 'input_width2'=>'6','input_label'=>'Nama', 'input_id'=>'nama'])
@endcomponent

{{-- status_callback --}}
@component('components.list_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$user,'label_width1'=>'3','label_width2'=>'6','input_width1'=>'2', 'input_width2'=>'6','input_label'=>'Divisi', 'input_id'=>'divisi_id', 'list_field'=>'nama_divisi','master'=>$divisi, 'master_id'=>'id'])
@endcomponent

{{-- email --}}
@component('components.common_input', ['for_create_edit'=> $for_create_edit, 'detail_table'=>$user,'data_type'=>'email', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'6', 'input_width2'=>'6','input_label'=>'Email', 'input_id'=>'email'])
@endcomponent

{{-- level --}}
@component('components.common_input', ['for_create_edit'=> $for_create_edit, 'detail_table'=>$user,'data_type'=>'number', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'6', 'input_width2'=>'6','input_label'=>'Level', 'input_id'=>'level'])
@endcomponent

{{-- id_user_budget --}}
@component('components.common_input', ['for_create_edit'=> $for_create_edit, 'detail_table'=>$user,'data_type'=>'text', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'6', 'input_width2'=>'6','input_label'=>'User ID Budget', 'input_id'=>'id_user_budget'])
@endcomponent

<?php if (session('role_id') == 1) : ?>
    <div class="form-group row">
        <label class="col-form-label col-md-3 col-sm-3 col-xs-6} label-align">Status</label>

        <div class="col-md-9 col-sm-9">
            <section id="status">
                <input type="radio" id="enable" name="is_disabled" value="0" <?= ($user->is_disabled == 0) ? 'checked' : '' ?>>
                <label for="enable">Enable</label><br>
                <input type="radio" id="disable" name="is_disabled" value="1" <?= ($user->is_disabled == 1) ? 'checked' : '' ?>>
                <label for="disable">Disable</label><br>
            </section>
            @error('status')
            <small style="color: red;">
                {{$message}}
            </small>
            @enderror
        </div>
    </div>
<?php endif; ?>

@if($for_create_edit == 'create')

{{-- conf_password --}}
<div class="item form-group">
    <label class="col-form-label col-md-3 col-sm-6 col-xs-6 label-align" for="password">Password </label>
    <div class="col-md-3 col-sm-3 col-xs-6">
        <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" value="@if($for_create_edit=='create'){{old('password')}}@else{{$user->password}}@endif">
        @error('password')
        <div class="invalid-feedback">
            {{$message}}
        </div>
        @enderror
    </div>
</div>

{{-- conf_password --}}
<div class="item form-group">
    <label class="col-form-label col-md-3 col-sm-6 col-xs-6 label-align" for="conf_password">Reenter Password </label>
    <div class="col-md-3 col-sm-3 col-xs-6">
        <input type="password" id="conf_password" name="conf_password" class="form-control @error('conf_password') is-invalid @enderror" value="@if($for_create_edit=='create'){{old('conf_password')}}@else{{$user->password}}@endif">
        @error('conf_password')
        <div class="invalid-feedback">
            {{$message}}
        </div>
        @enderror
    </div>
</div>
@endif