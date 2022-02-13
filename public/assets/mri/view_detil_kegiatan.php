<!-- page content -->
<div class="right_col" role="main">
	<div class="">
		<div class="clearfix"></div>
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">				
					<div class="x_title">
                    	<?php $nama_hari=array('Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu');
                            echo '<h2>'.$title. '</h2>'
                        ?>
                        </h2>
						<div class="clearfix"></div>
					</div>
					<h2>
					<div class="x_content">
						<div class="row">
						    <?php
                	        $photo = '/photos/kegiatan/' . $content_kegiatan_acara['kegiatanid'] . '.jpg';
                            if (file_exists($_SERVER['DOCUMENT_ROOT'] . $photo) == 1) {
                                echo '<div class="col-md-6 col-sm-6 col-xs-12">';
                                echo '<img src="' . $photo . '?=' .time() .'" alt="img" style="width: 100%; display: block;"/>';
                                echo '</div>';
                            }
                            ?>
							<div class="col-md-6 col-sm-6 col-xs-12">
							<h4>					
        						<div class="form-group">
        							<label class="control-label col-md-4 col-sm-4 col-xs-5">Acara</label>
        							<span><?php echo $content_kegiatan_acara['acara'] ?><br></span>
        						</div>
        						<div class="form-group">
        							<label class="control-label col-md-4 col-sm-4 col-xs-5">Tempat</label>
        							<span><?php echo $content_kegiatan_acara['lokasi'] ?><br></span>
        						</div>
        						<div class="form-group">
        							<label class="control-label col-md-4 col-sm-4 col-xs-5">Waktu</label>
        							<span><?php echo $nama_hari[$content_kegiatan_acara['hari']] . ', ' . date("d-m-Y", strtotime($content_kegiatan_acara['tanggal'])) . ', pukul ' .date_format(date_create($content_kegiatan_acara['jam']),'H:i') . ' WIB' ?><br></span>
        						</div>
        
        						<div class="form-group">
        							<label class="control-label col-md-4 col-sm-4 col-xs-5">Tema</label>
        							<span><?php echo $content_kegiatan_acara['tema']  ?><br></span>
        						</div>
        						<div class="form-group">
        							<label class="control-label col-md-4 col-sm-4 col-xs-5">Pembicara</label>
        							<span><?php echo $content_kegiatan_acara['pembicara'] ?><br></span>
        						</div>
    							</h4>
    						</div>
						</div>
					</div>
				</div>
			</div>
	</div>

<!-- /page content -->
