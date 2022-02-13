<!DOCTYPE html>
<html>

<head>
	<!-- Bootstrap -->
	<link href="/assets/gentelella-master/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<!-- Font Awesome -->
	<link href="/assets/gentelella-master/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">

	<style>
		table,
		th,
		td {
			border: 1px solid black;
			border-collapse: collapse;
			padding: 5px;
		}
	</style>
</head>

<body style="font-family:Helvetica,sans-serif">
	<h4 align="center">Absensi <strong>{{ $project_plan->nama_kegiatan . '  (' . $project_kegiatan->tema . ')'}} </strong> </h4>
	<h4 align="center">Project <strong>{{ session('current_project_nama') }} </strong> </h4>
	<h4 align="center">{{ $project_kegiatan->tanggal .'  ' . $project_kegiatan->jam }} </strong> </h4>
	<table align="center" style="width:100%">
		<?php
		for ($baris = 1; $baris <= 4; $baris++) {
			echo '<tr align="center">';
			for ($kolom = 1; $kolom <= 3; $kolom++) {
				// Isi 1 barcode
				echo '<td>';
				echo QrCode::size(300)->generate("$project_kegiatan->id");

				echo '</td>';
				// End - Isi 1 barcode
			}
			echo '</tr>';
		}
		?>
	</table>

</body>

</html>