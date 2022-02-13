{{-- role_menu_login --}}

<?php $other_option=''; if($for_create_edit == 'edit') 
    $other_option='readonly';
?>

@component('components.common_input', ['for_create_edit'=> $for_create_edit, 'detail_table'=>$role_menu,'data_type'=>'text', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'6', 'input_width2'=>'6','input_label'=>'Role', 'input_id'=>'role_menu_login','other_option'=>$other_option])
@endcomponent

{{-- email --}}
@component('components.common_input', ['for_create_edit'=> $for_create_edit, 'detail_table'=>$role_menu,'data_type'=>'email', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'6', 'input_width2'=>'6','input_label'=>'Email', 'input_id'=>'email'])
@endcomponent

{{-- level --}}
@component('components.common_input', ['for_create_edit'=> $for_create_edit, 'detail_table'=>$role_menu,'data_type'=>'number', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'6', 'input_width2'=>'6','input_label'=>'Level', 'input_id'=>'level'])
@endcomponent

@if($for_create_edit == 'create' or ($for_create_edit == 'edit' and $role_menu->role_menu_login==session('role_menu_login') ))
@component('components.common_input', ['for_create_edit'=> $for_create_edit, 'detail_table'=>$role_menu,'data_type'=>'password', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'6', 'input_width2'=>'6','input_label'=>'Password', 'input_id'=>'password'])
@endcomponent

{{-- conf_password --}}
<div class="item form-group">
    <label class="col-form-label col-md-3 col-sm-6 col-xs-6 label-align" for="conf_password">Reenter Password </label>
    <div class="col-md-3 col-sm-3 col-xs-6">
        <input type="password" id="conf_password" name="conf_password" 
            class="form-control @error('conf_password') is-invalid @enderror" 
            value="@if($for_create_edit=='create'){{old('conf_password')}}@else{{$role_menu->password}}@endif">
        @error('conf_password')
        <div class="invalid-feedback">
            {{$message}}
        </div>
        @enderror
    </div>
</div>
@endif
