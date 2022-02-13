@extends('maingentelellatable')

@section('title', 'Buat Project')

@section('content')
<div class="sukses" data-flashdata="{{session('sukses')}}"></div>
<div class="gagal" data-flashdata="{{session('gagal')}}"></div>
<div class="hapus" data-flashdata="{{session('hapus')}}"></div>

{{-- AWAL ROW --}}
<div class="row justify-content-center">

    <div class="col-md-8">
        <div class="x_panel">
            <div class="x_title">
                <h2>Integrasi Budget</h2>
                <ul class="nav navbar-right panel_toolbox pull-right">
                    <li><a class="collapse-link ml-5">
                            <di class="fa fa-chevron-up"></di>
                        </a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <h4>Project terintegrasi otomatis ke budget "{{$budget->nama}}"</h4>
                <br>

                <form class="form-horizontal form-label-left" action="{{url('projects/set_budget_integration')}}" method="post">
                    @csrf
                    @method('patch')
                    <input type="hidden" name="id" value="{{$id}}">

                    <!-- <div class="form-group row">
                        <label class="col-md-2 col-sm-2 ">Pembayaran Gift</label>

                        <div class="col-md-10 col-sm-10">
                            <div class="row">
                                <div style="width: 15%;">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="pembayaran_gift" id="pembayaran_gift1" value="internal" <?= (isset($integration_settings) && $integration_settings->pembayaran_gift == 'internal') ? 'checked' : '-' ?>>
                                        <label class="form-check-label" for="pembayaran_gift1">
                                            Internal
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="pembayaran_gift" id="pembayaran_gift2" value="external" <?= (isset($integration_settings) && $integration_settings->pembayaran_gift == 'external') ? 'checked' : '-' ?>>
                                        <label class="form-check-label" for="pembayaran_gift2">
                                            External
                                        </label>
                                    </div>
                                </div>
                                <label for="" class="mr-3">Item Budget</label>
                                <div style="width: 30%;" class="">
                                    <select name="item_budget_id_pembayaran_gift" class="form-control">
                                        <?php foreach ($itemBudget as $item) : ?>
                                            <?php if (isset($integration_settings) && $integration_settings->item_budget_id_pembayaran_gift == $item->no) : ?>
                                                <option value="<?= $item->no ?>" selected><?= $item->rincian ?></option>
                                            <?php else : ?>
                                                <option value="<?= $item->no ?>"><?= $item->rincian ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div> -->

                    <div class="form-group row">
                        <label class="col-md-2 col-sm-2 ">Pembayaran Interviewer</label>

                        <div class="col-md-10 col-sm-10">
                            <div class="row">
                                <div style="width: 15%;">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="pembayaran_interviewer[]" id="pembayaran_interviewer1" value="internal" <?= (in_array('internal', $pembayaran_interviewer)) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="pembayaran_interviewer1">
                                            Internal
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="pembayaran_interviewer[]" id="pembayaran_interviewer2" value="external" <?= (in_array('external', $pembayaran_interviewer)) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="pembayaran_interviewer2">
                                            External
                                        </label>
                                    </div>
                                </div>
                                <label for="" class="mr-3">Item Budget</label>
                                <div style="width: 30%;" class="">
                                    <select name="item_budget_id_pembayaran_interviewer" class="form-control">
                                        <?php foreach ($itemBudget as $item) : ?>
                                            <?php if (isset($integration_settings) && $integration_settings->item_budget_id_pembayaran_interviewer == $item->no) : ?>
                                                <option value="<?= $item->no ?>" selected><?= $item->rincian ?></option>
                                            <?php else : ?>
                                                <option value="<?= $item->no ?>" <?= ($item->no == '2') ? 'selected' : '' ?>><?= $item->rincian ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="ml-3 div-marking-interviewer">
                                    <a target="_blank" href="{{url('rekap_interviewer/marking') . '/' .session('current_project_id')}}" class="btn btn-primary">Marking Interviewer</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php foreach ($jabatan as $item) : ?>
                        <?php
                        $data = DB::table('project_budget_integration_tls')->where('project_id', session('current_project_id'))->where('jabatan_id', $item->jabatan_id)->first();

                        if (@unserialize($data->pembayaran))
                            $pembayaran = unserialize($data->pembayaran);
                        else
                            $pembayaran = [];

                        ?>
                        <div class="form-group row">
                            <label class="col-md-2 col-sm-2 ">Pembayaran <?= $item->jabatan ?></label>

                            <div class="col-md-10 col-sm-10">
                                <div class="row">
                                    <div style="width: 15%;">
                                        <div class="form-check">
                                            <input class="form-check-input pembayaran-tl1 pembayaran-tl" type="checkbox" name="pembayaran_<?= $item->jabatan_id ?>[]" id="pembayaran_<?= $item->jabatan_id ?>1" value="internal" <?= in_array('internal', $pembayaran) ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="pembayaran_<?= $item->jabatan_id ?>1">
                                                Internal
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input pembayaran-tl2 pembayaran-tl" type="checkbox" name="pembayaran_<?= $item->jabatan_id ?>[]" id="pembayaran_<?= $item->jabatan_id ?>2" value="external" <?= in_array('external', $pembayaran) ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="pembayaran_<?= $item->jabatan_id ?>2">
                                                External
                                            </label>
                                        </div>
                                    </div>
                                    <label for="" class="mr-3">Item Budget</label>
                                    <div style="width: 30%;" class="">
                                        <select name="item_budget_id_pembayaran_<?= $item->jabatan_id ?>" class="form-control item_budget_id" <?= in_array('internal', $pembayaran) ? '' : 'disabled' ?>>
                                            <?php foreach ($itemBudget as $item2) : ?>
                                                <?php if (isset($data->item_budget_id) && $data->item_budget_id == $item2->no) : ?>
                                                    <option value="<?= $item2->no ?>" selected><?= $item2->rincian ?></option>
                                                <?php else : ?>
                                                    <option value="<?= $item2->no ?>"><?= $item2->rincian ?></option>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="ml-3 div-marking-tl-<?= $item->jabatan_id ?>" <?= (in_array('internal', $pembayaran) && in_array('external', $pembayaran)) ? '' : 'style="display: none;"' ?>>
                                        <a target="_blank" href="{{url('rekap_tl/marking') . '/' . session('current_project_id') . '/' . $item->jabatan_id}}" class="btn btn-primary">Marking <?= $item->jabatan ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <!-- <div class="form-group row">
                        <label class="col-md-2 col-sm-2 ">Pembayaran TL</label>

                        <div class="col-md-10 col-sm-10">
                            <div class="row">
                                <div style="width: 15%;">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="pembayaran_tl" id="pembayaran_tl1" value="internal" <?= (isset($integration_settings) && $integration_settings->pembayaran_tl == 'internal') ? 'checked' : '-' ?>>
                                        <label class="form-check-label" for="pembayaran_tl1">
                                            Internal
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="pembayaran_tl" id="pembayaran_tl2" value="external" <?= (isset($integration_settings) && $integration_settings->pembayaran_tl == 'external') ? 'checked' : '-' ?>>
                                        <label class="form-check-label" for="pembayaran_tl2">
                                            External
                                        </label>
                                    </div>
                                </div>
                                <label for="" class="mr-3">Item Budget</label>
                                <div style="width: 30%;" class="">
                                    <select name="item_budget_id_pembayaran_tl" class="form-control">
                                        <?php foreach ($itemBudget as $item) : ?>
                                            <?php if (isset($integration_settings) && $integration_settings->item_budget_id_pembayaran_tl == $item->no) : ?>
                                                <option value="<?= $item->no ?>" selected><?= $item->rincian ?></option>
                                            <?php else : ?>
                                                <option value="<?= $item->no ?>"><?= $item->rincian ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div> -->


                    <div class="ln_solid"></div>
                    <div class="item form-group text-center">
                        <div class="col-md-12 col-sm-12">
                            <a class="btn btn-danger text-white" href="{{url('projects/' . session('current_project_id') . '/edit')}}">Cancel</a>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>

</div>
{{-- AKHIR ROW --}}

@endsection('content')

@section('javascript')
<script>
    $(document).ready(function() {
        // if ($('input[name=pembayaran_gift]:checked').val() == 'internal') {
        //     $('select[name=item_budget_id_pembayaran_gift]').attr('disabled', false);
        // } else {
        //     $('select[name=item_budget_id_pembayaran_gift]').attr('disabled', true);
        // }

        // $('input[name=pembayaran_gift]').change(function() {
        //     if ($(this).val() == 'internal') {
        //         $('select[name=item_budget_id_pembayaran_gift]').attr('disabled', false);
        //     } else {
        //         $('select[name=item_budget_id_pembayaran_gift]').attr('disabled', true);
        //     }
        // })

        // var checked = [];
        // console.log($("input[name='pembayaran_interviewer[]']"));
        // $("input[name='pembayaran_interviewer[]']").each(function() {
        //     checked.push(parseInt($(this).val()));
        //     console.log(checked);
        // });

        if ($('#pembayaran_interviewer2').is(":checked") && $('#pembayaran_interviewer1').is(":checked")) {
            $('.div-marking-interviewer').show();
        } else {
            $('.div-marking-interviewer').hide();
        }

        if ($('#pembayaran_interviewer1').is(":checked")) {
            $('select[name=item_budget_id_pembayaran_interviewer]').attr('disabled', false);
        } else {
            $('select[name=item_budget_id_pembayaran_interviewer]').attr('disabled', true);
        }

        $('input[name="pembayaran_interviewer[]"]').change(function() {

            if ($('#pembayaran_interviewer2').is(":checked") && $('#pembayaran_interviewer1').is(":checked")) {
                $('.div-marking-interviewer').show();
            } else {
                $('.div-marking-interviewer').hide();
            }

            if ($('#pembayaran_interviewer1').is(":checked")) {
                $('select[name=item_budget_id_pembayaran_interviewer]').attr('disabled', false);
            } else {
                $('select[name=item_budget_id_pembayaran_interviewer]').attr('disabled', true);
            }
        })

        $('.pembayaran-tl').change(function() {
            console.log($(this).attr('id'))
            const elementId = $(this).attr('id');
            let jabatanId = elementId.split('_');
            jabatanId = jabatanId[jabatanId.length - 1].slice(0, -1);
            if ($(`#pembayaran_${jabatanId}2`).is(":checked") && $(`#pembayaran_${jabatanId}1`).is(":checked")) {
                $(`.div-marking-tl-${jabatanId}`).show();
            } else {
                console.log('here');
                $(`.div-marking-tl-${jabatanId}`).hide();
            }

            if ($(`#pembayaran_${jabatanId}1`).is(":checked")) {
                $(`select[name=item_budget_id_pembayaran_${jabatanId}]`).attr('disabled', false);
            } else {
                // $(this).closest('.item_budget_id').attr('disabled', true);
                $(`select[name=item_budget_id_pembayaran_${jabatanId}]`).attr('disabled', true);
            }
        })
    });
</script>
@endsection