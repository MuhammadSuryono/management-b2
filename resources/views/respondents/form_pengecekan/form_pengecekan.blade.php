<input type="hidden" id="id" name="id" value="{{$data_pengecekan->id}}">

<p><b>Rekaman </b></p>
<?php
$ext = pathinfo($respondent->rekaman, PATHINFO_EXTENSION);
$audioExt = ['mp3', 'wav', 'ogg', 'flac'];
if (in_array($ext, $audioExt)) :
?>
    <div class="">
        <audio controls>
            <source src="{{$respondent->rekaman}}" type="audio/ogg">
            <source src="{{$respondent->rekaman}}" type="audio/mpeg">
            Your browser does not support the audio element.
        </audio>
    </div>
<?php endif; ?>
<p>Klik <a target="_blank" href="{{$respondent->rekaman}}" class="text-primary">disini</a> untuk mendownload</p>
<hr>
<br>

<div class="row">
    <?php $i = 1; ?>
    <?php foreach ($status_pengecekan as $sp) : ?>
        <?php if ($i == 1 || $i == 7) : ?>
            <div class="col-lg-6">
            <?php endif; ?>
            <div class="form-group">
                <p><?= $i . '. ' . $sp['keterangan_gagal_pengecekan'] ?></p>
                <?php $code = $sp->code ?>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="s<?= $i ?>y" value="1" name="s<?= $i ?>" <?= ($data_pengecekan->$code != 0) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="s<?= $i ?>y">Ya</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="s<?= $i ?>n" value="0" name="s<?= $i ?>" <?= ($data_pengecekan->$code == 0) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="s<?= $i ?>n">Tidak</label>
                </div>
            </div>
            <?php $i++; ?>
            <?php if ($i == 1 || $i == 7) : ?>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
</div>
</div>
{{-- temuan --}}
@component('components.textarea_input', ['for_create_edit'=>$for_create_edit, 'detail_table'=>$data_pengecekan,'label_width1'=>'0','label_width2'=>'6','input_width1'=>'5', 'input_width2'=>'6','input_label'=>'Temuan', 'input_id'=>'temuan', 'rows' => '5'])
@endcomponent