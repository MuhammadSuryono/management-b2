<input type="hidden" id="user_id" name="user_id" value="{{session('user_id')}}">

{{-- nama --}}
@component('components.common_input', ['for_create_edit'=> $for_create_edit, 'detail_table'=>$team,'data_type'=>'text', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'6', 'input_width2'=>'6','input_label'=>'Nama', 'input_id'=>'nama'])
@endcomponent

{{-- genderid --}}
@component('components.list_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$team,'label_width1'=>'3','label_width2'=>'6','input_width1'=>'3', 'input_width2'=>'6','input_label'=>'Gender', 'input_id'=>'gender_id', 'list_field'=>'gender','master'=>$genders, 'master_id'=>'id',])
@endcomponent

{{-- ktp --}}
@component('components.common_input', ['for_create_edit'=> $for_create_edit, 'detail_table'=>$team,'data_type'=>'text', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'6', 'input_width2'=>'6','input_label'=>'KTP', 'input_id'=>'ktp'])
@endcomponent

{{-- hp --}}
@component('components.common_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$team,'data_type'=>'number', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'3', 'input_width2'=>'6','input_label'=>'HP', 'input_id'=>'hp'])
@endcomponent

{{-- email --}}
@component('components.common_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$team, 'data_type'=>'email', 'label_width1'=>'3','label_width2'=>'12','input_width1'=>'6', 'input_width2'=>'12', 'input_label'=>'Email', 'input_id'=>'email'])
@endcomponent

{{-- alamat --}}
@component('components.textarea_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$team,'label_width1'=>'3','label_width2'=>'6','input_width1'=>'6', 'input_width2'=>'6','input_label'=>'Alamat', 'input_id'=>'alamat'])
@endcomponent

{{-- kotaid --}}
@component('components.list_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$team,'label_width1'=>'3','label_width2'=>'6','input_width1'=>'3', 'input_width2'=>'6', 'input_label'=>'Kota ', 'input_id'=>'kota_id', 'list_field'=>'kota','master'=>$kotas, 'master_id'=>'id',])
@endcomponent

{{-- tgl_lahir --}}
@component('components.common_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$team,'data_type'=>'date', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'3', 'input_width2'=>'6','input_label'=>'Tanggal Lahir', 'input_id'=>'tgl_lahir'])
@endcomponent

{{-- pekerjaanid --}}
@Component('components.list_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$team,'label_width1'=>'3','label_width2'=>'6','input_width1'=>'3', 'input_width2'=>'6', 'input_label'=>'Pekerjaan ', 'input_id'=>'pekerjaan_id', 'list_field'=>'pekerjaan','master'=>$pekerjaans, 'master_id'=>'id',])
@Endcomponent

{{-- pendidikanid --}}
@Component('components.list_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$team,'label_width1'=>'3','label_width2'=>'6','input_width1'=>'3', 'input_width2'=>'6', 'input_label'=>'Pendidikan ', 'input_id'=>'pendidikan_id', 'list_field'=>'pendidikan','master'=>$pendidikans, 'master_id'=>'id',])
@Endcomponent

{{-- tgl_registrasi --}}
@component('components.date_input_dev_today', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$team,'data_type'=>'date', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'3', 'input_width2'=>'6','input_label'=>'Tanggal Registrasi', 'input_id'=>'tgl_registrasi'])
@endcomponent

{{-- Nomor Rekening --}}
@component('components.common_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$team,'data_type'=>'number', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'3', 'input_width2'=>'6','input_label'=>'Nomor Rekening', 'input_id'=>'nomor_rekening'])
@endcomponent

{{-- Kode Bank --}}
@Component('components.list_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$team,'label_width1'=>'3','label_width2'=>'6','input_width1'=>'3', 'input_width2'=>'6', 'input_label'=>'Bank ', 'input_id'=>'kode_bank', 'list_field'=>'namabank','master'=>$bank, 'master_id'=>'kodebank',])
@Endcomponent

{{-- Bukti Rekening --}}
<div class="item form-group">
    <label class="col-form-label col-md-3 col-sm-3} col-xs-6 label-align" for="inputGroupFile01">Bukti Kepemilikan Rekening </label>
    <div class="col-md-3 col-sm-3 col-xs-6">
        <div class="custom-file">
            <input type="file" accept="image/x-png,image/jpeg,image/jpg" class="custom-file-input" name="file" id="inputGroupFile01">
            <label class="custom-file-label" for="inputGroupFile01" id="inputGroupFileText01">Choose file</label>
            @if($team->bukti_rekening && $for_create_edit != 'create')
            <a target="_blank" style="color: blue;" href="{{url('/teams/view')}}/{{$team->bukti_rekening}}">view</a>
            @endif
            @error('bukti_rekening')
            <small style="color: red;">
                {{$message}}
            </small>
            @enderror
        </div>
    </div>
</div>

{{-- Rate Card --}}
<div class="item form-group">
    <label class="col-form-label col-md-3 col-sm-3} col-xs-6 label-align" for="inputGroupFile01">Rate Card</label>
    <div class="col-md-3 col-sm-3 col-xs-6">
        <div class="custom-file">
            <input type="file" accept="image/x-png,image/jpeg,image/jpg" class="custom-file-input" name="fileRateCard" id="inputGroupFile02">
            <label class="custom-file-label" for="inputGroupFile02" id="inputGroupFileText02">Choose file</label>
            @if($team->rate_card && $for_create_edit != 'create')
            <a target="_blank" style="color: blue;" href="{{url('/teams/view')}}/{{$team->rate_card}}">view</a>
            @endif
            @error('fileRateCard')
            <small style="color: red;">
                {{$message}}
            </small>
            @enderror
        </div>
    </div>
</div>

@section('javascript')
<script>
    $('#qrscan_form').prop('enctype', 'multipart/form-data')
    const inputFile1 = $('#inputGroupFile01');
    inputFile1.change(function() {
        let string = $(this).val().split('\\');
        $('#inputGroupFileText01').text(string[string.length - 1]);
    })
    const inputFile2 = $('#inputGroupFile02');
    inputFile2.change(function() {
        let string = $(this).val().split('\\');
        $('#inputGroupFileText02').text(string[string.length - 1]);
    })
</script>
@endsection
