
<!-- Absensiku -->
<!-- <div class="col-md-3 col-sm-3 col-xs-12"> -->
<div class="x_panel tile fixed_height_400">
	<div class="x_title">
		<h2>
			<a><i class="fas fa-check-square"></i> Daftar Kehadiran Anda</a>
		</h2>
		<div class="clearfix"></div>
	</div>
	<div class="x_content">
    <?php
    $nama_bulan = [
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

    foreach ($absensiku as $absensiku_item) :
        ?>
        <!-- one row -->
		<article class="media event">
			<a class="pull-left date"  style="background-color:
            <?php
            switch ($absensiku_item['sthadir']) {
                case 0:
                    echo 'DarkRed';
                    break;
                case - 1:
                    echo 'DodgerBlue';
                    break;
                default:
                    echo 'Green';
            }
            echo ';"  ';
            echo ' title="Show Event" href="' . base_url() . 'index.php/Kegiatan/view_detil_kegiatan/' . $absensiku_item['kegiatanid'] . '">';
            ?>
            
				<p class="month">
                                        <?php echo $nama_bulan[$absensiku_item['bln']]  ;?> </p>
				<p class="day">
                                        <?php echo $absensiku_item['tgl'] ;?> </p>
			</a>
			<div class="media-body">
				<a class="title"><?php echo '<i class="fas fa-church"></i> '. date_format(date_create($absensiku_item['jam']),'H:i' ) .' - '. $absensiku_item['acara_singkat'] . ' [' . $absensiku_item['lokasi_singkat'] .']'  ;?></a>
				<p><?php echo '<i class="far fa-hand-point-right"></i> <strong> ' . $absensiku_item['tema'] . '</strong>';?>
                                    </p>
                                    <?php

switch ($absensiku_item['sthadir']) {
                                    case 0:
                                        echo '<p style="color:red"><span class="glyphicon glyphicon-remove-sign" style="color:red"></span>Tidak hadir &#128542 </p>';
                                        break;
                                    case - 1:
                                        echo '<p style="color:blue"><span class="glyphicon glyphicon-info-sign" style="color:blue" ></span> Ditunggu kehadirannya <span>&#128072;</span></p>';
                                        break;
                                    default:
                                        echo '<p style="color:green"><span class="glyphicon glyphicon-ok-sign" style="color:green"></span>  Hadir <span>&#128077; &#128077; &#128077;</span></p>';
                                }
                                ?>

                                </div>
		</article>
		<!-- end - one row -->
                            <?php endforeach; ?>
                        </div>
</div>

<!-- End Absensiku -->
