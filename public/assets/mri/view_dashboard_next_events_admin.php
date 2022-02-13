<!-- Kegiatan -->
<!-- <div class="col-md-3 col-sm-3 col-xs-12"> -->
<div class="x_panel tile fixed_height_400">
	<div class="x_title">
		<h2>
			<a title="List Events"
				href="<?php echo base_url();?>index.php/Kegiatan/list_kegiatan_berikutnya"><i
				class="far fa-calendar-alt"></i> Events</a>
		</h2>
		<div class="clearfix"></div>
	</div>
	<div class="x_content">
	<?php $nama_bulan = [
                '',
                'Januari',
                'Februari',
                'Maret',
                'April',
                'Mei',
                'Juni',
                'Juli',
                'Agustus',
                'September',
                'Oktober',
                'November',
                'Desember'
            ];
            $nama_hari = [
                'Minggu',
                'Senin',
                'Selasa',
                'Rabu',
                'Kamis',
                'Jumat',
                'Sabtu'
            ];
            if ($kegiatan['total_next_event']) {
                foreach ($content_kegiatan_berikutnya as $content_kegiatan_berikutnya_item) :
        ?>
	<!-- one row -->
		<article class="media event">
			<a class="pull-left date" style="background-color: blueviolet"
				<?php
				$show_absensi_kegiatan=' title="Absensi Kegiatan" href="' . base_url() . 'index.php/Absensi_kegiatan/list_absensi_kegiatan/' . $content_kegiatan_berikutnya_item['kegiatanid'] . '"';
				$show_detil_kegiatan=' title="Show Event" href="' . base_url() . 'index.php/Kegiatan/view_detil_kegiatan/' . $content_kegiatan_berikutnya_item['kegiatanid'] . '"';
                    if ($content_kegiatan_berikutnya_item['tanggal'] <= date('Y-m-d')) {
                        echo $show_absensi_kegiatan;
                    }
                    ?>>
				<p class="month"><?php echo $nama_bulan[$content_kegiatan_berikutnya_item['bln']]  ;?> </p>
				<p class="day"><?php echo $content_kegiatan_berikutnya_item['tgl'] ;?> </p>
			</a>
			<div class="media-body">
				<a class="title" <?= $show_detil_kegiatan?>><?php echo '<i class="fas fa-church"></i> '. date_format(date_create($content_kegiatan_berikutnya_item['jam']),'H:i' ) .' - '. $content_kegiatan_berikutnya_item['acara_singkat'].' ['. $content_kegiatan_berikutnya_item['lokasi_singkat'] . ']' ;?> </a><br>
				<a <?= $show_detil_kegiatan?>><?php echo '<i class="far fa-hand-point-right"></i>  <strong>' . $content_kegiatan_berikutnya_item['tema'] .'</strong>' ;?></a><br>
				<a <?= $show_detil_kegiatan?>><?php echo '<i class="fas fa-user"></i> <strong>' . $content_kegiatan_berikutnya_item['pembicara'] .'</strong>';?></a>
			</div>
		</article>
		<!-- end - one row -->
            <?php
                endforeach ;
                } else {
                    echo '<p><font size="3" color="red"><marquee> *** Jadwal kegiatan berikutnya kosong. ***</marquee></font> </p>';
                }
            ?>
        				</div>
</div>

<!-- End Kegiatan -->