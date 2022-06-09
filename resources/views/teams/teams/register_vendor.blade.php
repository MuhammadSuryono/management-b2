@extends('auth_gentelella')
<?php $for_create_edit = $create_edit; ?>
@section('content')
    <style>
        .center-block {
            display: block;
            margin-left: auto;
            margin-right: auto;
            width: 70%;
        }

    </style>
    <div class="row center-block mt-5">
        <div class="col-md-12 col-sm-12">
            @if(session()->has('success'))
                <div class="alert alert-success" role="alert">
                    <h4 class="alert-heading">{{ __('Register Vendor') }}</h4>
                    <p>{{ session('success')}}</p>
                </div>
            @endif

            @if(session()->has('error'))
                <div class="alert alert-danger" role="alert">
                    <h4 class="alert-heading">{{ __('Register Vendor') }}</h4>
                    <p>{{ session('error')}}</p>
                </div>
            @endif
            <div class="x_panel tile" style="box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;">
                <div class="x_title" style="font-size: 20pt"><i class="fa fa-user-plus"></i> Register Interviewer</div>
                <div class="x_content">
                    <form action="{{$action_url}}" method="POST">
                        @csrf
                    <div class="row">
                        <div class="col">
                            {{-- nama --}}
                            @component('components.common_input', ['placeholder' => 'Nama Vendor', 'for_create_edit'=> $for_create_edit, 'detail_table'=>$team,'data_type'=>'text', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'8', 'input_width2'=>'8','input_label'=>'Nama', 'input_id'=>'nama'])
                            @endcomponent

                            {{-- genderid --}}
                            @component('components.list_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$team,'label_width1'=>'3','label_width2'=>'6','input_width1'=>'8', 'input_width2'=>'8','input_label'=>'Gender', 'input_id'=>'gender_id', 'list_field'=>'gender','master'=>$genders, 'master_id'=>'id',])
                            @endcomponent

                            {{-- ktp --}}
                            @component('components.common_input', ['for_create_edit'=> $for_create_edit, 'detail_table'=>$team,'data_type'=>'text', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'8', 'input_width2'=>'8','input_label'=>'KTP', 'input_id'=>'ktp'])
                            @endcomponent

                            {{-- hp --}}
                            @component('components.common_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$team,'data_type'=>'text', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'8', 'input_width2'=>'8','input_label'=>'HP', 'input_id'=>'hp'])
                            @endcomponent

                            {{-- email --}}
                            @component('components.common_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$team, 'data_type'=>'email', 'label_width1'=>'3','label_width2'=>'12','input_width1'=>'8', 'input_width2'=>'8', 'input_label'=>'Email', 'input_id'=>'email'])
                            @endcomponent

                            {{-- alamat --}}
                            @component('components.textarea_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$team,'label_width1'=>'3','label_width2'=>'6','input_width1'=>'8', 'input_width2'=>'8','input_label'=>'Alamat', 'input_id'=>'alamat'])
                            @endcomponent
                        </div>
                        <div class="col">
                            {{-- kotaid --}}
                            @component('components.list_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$team,'label_width1'=>'3','label_width2'=>'6','input_width1'=>'8', 'input_width2'=>'8', 'input_label'=>'Kota ', 'input_id'=>'kota_id', 'list_field'=>'kota','master'=>$kotas, 'master_id'=>'id',])
                            @endcomponent

                            {{-- tgl_lahir --}}
                            @component('components.common_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$team,'data_type'=>'date', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'8', 'input_width2'=>'8','input_label'=>'Tanggal Lahir', 'input_id'=>'tgl_lahir'])
                            @endcomponent

                            {{-- pekerjaanid --}}
                            @Component('components.list_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$team,'label_width1'=>'3','label_width2'=>'6','input_width1'=>'8', 'input_width2'=>'8', 'input_label'=>'Pekerjaan ', 'input_id'=>'pekerjaan_id', 'list_field'=>'pekerjaan','master'=>$pekerjaans, 'master_id'=>'id',])
                            @Endcomponent

                            {{-- pendidikanid --}}
                            @Component('components.list_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$team,'label_width1'=>'3','label_width2'=>'6','input_width1'=>'8', 'input_width2'=>'8', 'input_label'=>'Pendidikan ', 'input_id'=>'pendidikan_id', 'list_field'=>'pendidikan','master'=>$pendidikans, 'master_id'=>'id',])
                            @Endcomponent

                            {{-- tgl_registrasi --}}
                            @component('components.date_input_dev_today', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$team,'data_type'=>'date', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'8', 'input_width2'=>'8','input_label'=>'Tanggal Registrasi', 'input_id'=>'tgl_registrasi'])
                            @endcomponent

                            {{-- Nomor Rekening --}}
                            @component('components.common_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$team,'data_type'=>'text', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'8', 'input_width2'=>'8','input_label'=>'Nomor Rekening', 'input_id'=>'nomor_rekening'])
                            @endcomponent

                            {{-- Kode Bank --}}
                            @Component('components.list_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$team,'label_width1'=>'3','label_width2'=>'6','input_width1'=>'8', 'input_width2'=>'8', 'input_label'=>'Bank ', 'input_id'=>'kode_bank', 'list_field'=>'namabank','master'=>$bank, 'master_id'=>'kodebank',])
                            @Endcomponent
                        </div>
                    </div>
                        <div class="row">
                            <div class="col">
                                <button type="submit" class="btn btn-primary mr-5" style="float: right"><i class="fa fa-check-circle"></i> Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

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
