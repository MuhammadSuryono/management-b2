@extends('maingentelellatable')

@section('title', 'Buat Project')

@section('content')
<div class="sukses" data-flashdata="{{session('sukses')}}"></div>
<div class="gagal" data-flashdata="{{session('gagal')}}"></div>
<div class="hapus" data-flashdata="{{session('hapus')}}"></div>

<style>
    .clearfix::after {
        content: "";
        clear: both;
        display: table;
    }

    .note {
        line-height: 1;
    }
</style>

{{-- AWAL ROW --}}
<div class="row justify-content-center">

    <div class="col-md-8">
        <div class="x_panel">
            <div class="x_title">
                <h2>Set Template QC</h2>
                <ul class="nav navbar-right panel_toolbox pull-right">
                    <li><a class="collapse-link ml-5"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="note">
                    <p><b>Note:</b></p>
                    <p>1. Harap simpan terlebih dahulu setelah menambah pertanyaan dan sebelum merubah jenis pertanyaan</p>
                    <p>2. Harap mengisi semua data, yaitu:</p>
                    <p style="padding-left: 10px;">(a). Pertanyaan</p>
                    <p style="padding-left: 10px;">(b). Urutan -> Digunakan untuk mengatur tata letak pertanyaan</p>
                    <p style="padding-left: 10px;">(c). Kode Pertanyaan -> Digunakan oleh sistem untuk membandingkan jawaban</p>
                    <p style="padding-left: 40px;">Example:</p>
                    <p style="padding-left: 40px;">(c.1) s1, s2 (Format: "KodeUrutan")-> Free Answer dan Single Answer</p>
                    <p style="padding-left: 40px;">(c.2) a_s3, a_s4 (Format: "Kode1_Kode2Urutan") -> Multiple Answer</p>
                    <p style="padding-left: 10px;">(d). Value Option -> Digunakan untuk mendifinisikan nilai dari option yang dipilih</p>
                    <p>3.Untuk Menghapus pertanyaan, user hanya perlu mengosongkan field input pertanyaan lalu klik save</p>
                </div>

                <form class="form-horizontal form-label-left" id="form-store-qc" action="{{url('form_qc/store_template_qc')}}" method="post">
                    @csrf
                    <input type="hidden" name="id" value="<?= isset($id) ? $id : '' ?>">
                    <input type="hidden" name="project_id" value="<?= $project_id ?>">
                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 ">Nama Worksheet</label>
                        <div class="col-md-9 col-sm-9 ">
                            <input type="text" class="form-control" name="nama" id="nama" value="<?= isset($code['nama']) ? $code['nama'] : '' ?>">
                        </div>
                    </div>

                    <?php
                    // $question = '';
                    if (isset($code['id'])) {
                        $question = DB::table('quest_questions')->where('quest_code_id', $code['id'])->orderBy('urutan')->get();
                    }
                    if (isset($question)) :
                        $i = 1;
                        foreach ($question as $q) :
                    ?>
                            <div class="div-question div-question-<?= $i ?>">
                                <div class="form-group row">
                                    <label class="control-label col-md-3 col-sm-3">Question <?= $i ?></label>
                                    <div class="col-md-5 col-sm-5 ">
                                        <input type="text" class="form-control question-text" name="question[]" id="question-text-<?= $i ?>" value="<?= $q->pertanyaan ?>">
                                        <input type="hidden" name="idQuestion[]" value="<?= $q->id ?>">
                                    </div>
                                    <div class="col-md-2 col-sm-2 ">
                                        <input type="number" class="form-control question-urutan" name="urutan[]" id="question-urutan-<?= $i ?>" value="<?= ($q->urutan) ? $q->urutan : '' ?>" placeholder="Urutan">
                                    </div>
                                    <div class="col-md-2 col-sm-2 ">
                                        <input type="text" class="form-control question-code" name="questCode[]" id="question-code-<?= $i ?>" value="<?= isset($q->quest_code) ? $q->quest_code : '' ?>" placeholder="Code">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label offset-md-3 col-md-1 col-sm-1">Type</label>
                                    <div class="col-md-8 col-sm-8">
                                        <select class="form-control mt-1 type-question" name="type[]" id="type-question-<?= $i ?>" data-width="100%">
                                            <option value="fa" <?= ($q->jenis == 'fa') ? 'selected' : '' ?>>Free Answer</option>
                                            <option value="sa" <?= ($q->jenis == 'sa') ? 'selected' : '' ?>>Single Answer</option>
                                            <option value="ma" <?= ($q->jenis == 'ma') ? 'selected' : '' ?>>Multiple Answer</option>
                                        </select>
                                    </div>
                                </div>

                                <?php
                                if ($q->jenis != 'fa') :
                                    $j = 1;
                                    $option = DB::table('quest_options')->where('quest_question_id', $q->id)->get();
                                    $optionCount = DB::table('quest_options')->where('quest_question_id', $q->id)->count();
                                    if ($optionCount) :
                                ?>
                                        <div class="form-group row question-<?= $i ?>-div-option">
                                            <?php
                                            foreach ($option as $o) :
                                            ?>
                                                <label class="control-label offset-md-3 col- md-1 col-sm-1 label-option-<?= $i ?>" id="question-<?= $i ?>-label-option-<?= $j ?>">Option</label>
                                                <div class="col-md-4 col-sm-4 mt-1" id="question-<?= $i ?>-div-option-text-<?= $j ?>">
                                                    <input type="text" class="form-control" name='option[]' id='question-<?= $i ?>-option-text-<?= $j ?>' value="<?= $o->option ?>">
                                                    <input type="hidden" name='optionIdentity[]' value='<?= $q->pertanyaan ?>'>
                                                </div>
                                                <div class="col-md-2 col-sm-2 mt-1" id="question-<?= $i ?>-div-option-value-<?= $j ?>">
                                                    <input type="number" class="form-control co" name='value[]' id='question-<?= $i ?>-option-value-<?= $j ?>' value="<?= ($o->value) ? $o->value : '' ?>" placeholder="Value">
                                                </div>
                                                <div class="col-md-2 col-sm-2 mt-1" id="question-<?= $i ?>-div-btn-dlt-<?= $j ?>">
                                                    <?php if ($j == 1) : ?>
                                                        <button type='button' class='btn btn-primary btn-sm btn-sm btn-add-option' id='btn-add-option-<?= $i ?>'><i class="fa fa-plus"></i></button>
                                                    <?php else : ?>
                                                        <button type='button' class='btn btn-sm btn-danger btn-dlt' id='question-<?= $i ?>-btn-dlt-<?= $j ?>'><i class="fa fa-trash-o"></i></button>
                                                    <?php endif; ?>
                                                </div>
                                            <?php
                                                $j++;
                                            endforeach; ?>
                                        </div>
                                <?php
                                    endif;
                                endif;
                                ?>

                            </div>
                    <?php
                            $i++;
                        endforeach;
                    endif;
                    ?>
                </form>
                <button type="button" class="btn btn-sm btn-success float-right clearfix mt-2" id="btn-add">Add Question</button>

                <div class="ln_solid"></div>
                <div class="item form-group text-center">
                    <div class="col-md-12 col-sm-12">
                        <a class="btn btn-primary text-white" href='{{url("projects/" . session("current_project_id") . "/edit")}}'>Back</a>
                        <button type="submit" class="btn btn-primary" id="btn-save">Save</button>
                        <?php if (isset($id)) : ?>
                            <a class="btn btn-danger text-white" data-toggle="modal" data-target="#confirm-delete" style="cursor: pointer;">Delete</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if (isset($id)) : ?>
    <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="tlModalLabel">Delete Worksheet</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{url('form_qc/delete_template_qc')}}/{{$id}}">
                    <div class="modal-body">
                        <p>You are about to delete one track, this procedure is irreversible.</p>
                        <p>Do you want to proceed?</p>
                        <p class="debug-url"></p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger text-white">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endif; ?>

{{-- AKHIR ROW --}}

@endsection('content')

@section('javascript')
<script>
    $(document).ready(function() {
        $('#btn-save').click(function(e) {
            if ($('#code').val() != '') {
                $("#form-store-qc").submit();
            } else {
                alert('Harap Mengisi data dengan benar.')
                // e.preventDefault();
            }
        })
        $('#btn-add').click(function() {
            count = ($('.div-question').length) + 1;
            console.log($('.div-question'));
            const html = `
                    <div class="div-question div-question-${count}">
                        <div class="form-group row">
                            <label class="control-label col-md-3 col-sm-3">Question ${count}</label>
                            <div class="col-md-5 col-sm-5 ">
                                <input type="text" class="form-control question-text" name="question[]" id="question-text-${count}">
                                <input type="hidden" name="idQuestion[]" value="">
                            </div>
                            <div class="col-md-2 col-sm-2 ">
                                <input type="number" class="form-control question-urutan" name="urutan[]" id="question-urutan-${count}" value="" placeholder="Urutan">
                            </div>
                            <div class="col-md-2 col-sm-2 ">
                                <input type="text" class="form-control question-code" name="questCode[]" id="question-code-${count}" placeholder="Code">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label offset-md-3 col-md-1 col-sm-1">Type</label>
                            <div class="col-md-8 col-sm-8">
                                <select class="form-control mt-1 type-question" name="type[]" id="type-question-${count}" data-width="100%">
                                    <option value="fa">Free Answer</option>
                                    <option value="sa">Single Answer</option>
                                    <option value="ma">Multiple Answer</option>
                                </select>
                            </div>
                        </div>
                        
                    </div>
            `;

            $('form#form-store-qc').append(html);
        });

        $(document).on('change', '.type-question', function() {
            let id = $(this).attr('id');
            let arrId = id.split('-');
            let index = arrId[arrId.length - 1];
            let value = $(this).find(":selected").val();

            let countOption = document.querySelectorAll(`.label-option-${index}`).length;

            let optionIdentity = document.getElementById(`question-text-${index}`).value;
            if (value == 'sa' || value == 'ma') {
                if (countOption == 0) {
                    const html = `
                            <div class="form-group row question-${index}-div-option">
                                <label class="control-label offset-md-3 col- md-1 col-sm-1 label-option-${index}" id="question-${index}-label-option-${countOption+1}">Option</label>
                                <div class="col-md-4 col-sm-4 mt-1" id="question-${index}-div-option-text-${countOption+1}">
                                    <input type="text" class="form-control" name='option[]' id='question-${index}-option-text-${countOption+1}'>
                        <input type="hidden" name='optionIdentity[]' value='${optionIdentity}'>
                                </div>
                                <div class="col-md-2 col-sm-2 mt-1" id="question-${index}-div-option-value-${countOption+1}">
                                    <input type="number" class="form-control" name='value[]' id='question-${index}-option-value-${countOption+1}' value="" placeholder="Value">
                                </div>
                                <div class="col-md-2 col-sm-2 mt-1" id="question-${index}-div-btn-dlt-${countOption+1}">
                                    <button type='button' class='btn btn-primary btn-sm btn-sm btn-add-option' id='btn-add-option-${index}'><i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                    `;

                    $(`.div-question-${index}`).append(html);
                };
            } else {
                if (countOption != 0) {
                    $(`.question-${index}-div-option`).remove();
                };
            }
        });

        $(document).on('click', '.btn-add-option', function() {
            let id = $(this).attr('id');
            let arrId = id.split('-');
            let index = arrId[arrId.length - 1];
            let countOption = document.querySelectorAll(`.label-option-${index}`).length;

            // console.log(index);

            let optionIdentity = $(`#question-text-${index}`).val();
            const html = `
                    <label class="control-label offset-md-3 col-md-1 col-sm-1 label-option-${index} mt-1" id="question-${index}-label-option-${countOption+1}">Option</label>
                    <div class="col-md-4 col-sm-4 mt-1" id="question-${index}-div-option-text-${countOption+1}">
                        <input type="text" class="form-control" name='option[]' id='question-${index}-option-text-${countOption+1}'>
                        <input type="hidden" name='optionIdentity[]' value='${optionIdentity}'>
                    </div>
                    <div class="col-md-2 col-sm-2 mt-1" id="question-${index}-div-option-value-${countOption+1}">
                        <input type="number" class="form-control co" name='value[]' id='question-${index}-option-value-${countOption+1}' value="" placeholder="Value">
                    </div>
                    <div class="col-md-2 col-sm-2 mt-1" id="question-${index}-div-btn-dlt-${countOption+1}">
                        <button type='button' class='btn btn-sm btn-danger btn-dlt' id='question-${index}-btn-dlt-${countOption+1}'><i class="fa fa-trash-o"></i></button>
                    </div>
            `;

            $(`.question-${index}-div-option`).append(html);
        });

        $(document).on('click', '.btn-dlt', function() {
            let id = $(this).attr('id');
            // let countOption = id.charAt(id.length - 1);

            let arrId = id.split('-');
            let countOption = arrId[arrId.length - 1];

            // let index = id.charAt(9);
            let index = arrId[1];

            console.log(id);

            $(`#question-${index}-label-option-${countOption}, #question-${index}-div-btn-dlt-${countOption}, #question-${index}-div-option-text-${countOption}, #question-${index}-div-option-value-${countOption}`).remove();
            // $(``).parent().remove();
            // $(``).parent().remove();
        });


    });
</script>
@endsection