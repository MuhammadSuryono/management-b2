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
	<h4 align="center">Absensi <strong>{{ $project_plan->nama_kegiatan}} </strong> </h4>
	<h4 align="center">Project <strong>{{ session('current_project_nama') }} </strong> </h4>
	<h4 align="center"><strong> {{$project_plan->date_start_real}} {{$project_plan->hour_start_real}} s/d {{$project_plan->date_finish_real}} {{$project_plan->hour_finish_real}}</strong> </h4>
	<table align="center" style="width:100%">
		<?php
		for ($baris = 1; $baris <= 4; $baris++) {
			echo '<tr align="center">';
			for ($kolom = 1; $kolom <= 3; $kolom++) {
				// Isi 1 barcode
				echo '<td>';
				// echo url("project_plans/fill_presence/$project_plan->id");
				echo url("project_plans/fill_presence" . (($is_respondent) ? "_respondent" : '') . "/$project_plan->id");
				if ($is_respondent)
					echo QrCode::size(300)->generate(url("project_plans/fill_presence_respondent/$project_plan->id"));
				else
					echo QrCode::size(300)->generate(url("project_plans/fill_presence/$project_plan->id"));

				echo '</td>';
				// End - Isi 1 barcode
			}
			echo '</tr>';
		}
		?>
	</table>

</body>

</html>