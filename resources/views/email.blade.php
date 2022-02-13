<?php
function indoDate($date)
{
    $BulanIndo = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");

    $tahun = substr($date, 0, 4);
    $bulan = substr($date, 5, 2);
    $tgl   = substr($date, 8, 2);

    $result = $tgl . " " . $BulanIndo[(int)$bulan - 1] . " " . $tahun;
    return ($result);
}
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        @media only screen and (min-width: 600px) {

            /* For tablets: */
            .card {
                box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
                width: 80%;
                margin: auto;
                text-align: center;
                font-family: arial;
            }
        }

        @media only screen and (min-width: 768px) {

            /* For desktop: */
            .card {
                box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
                width: 40%;
                margin: auto;
                text-align: center;
                font-family: arial;
            }
        }

        .title {
            color: grey;
            font-size: 18px;
        }

        button {
            border: none;
            outline: 0;
            display: inline-block;
            padding: 8px;
            color: white;
            background-color: #000;
            text-align: center;
            cursor: pointer;
            width: 100%;
            font-size: 18px;
        }

        a {
            text-decoration: none;
            font-size: 22px;
            color: black;
        }

        button:hover,
        a:hover {
            opacity: 0.7;
        }
    </style>
</head>

<body>

    <h2 style="text-align:center;">
        <?php if ($status == 'create') : ?>
            Undangan/Pemberitahuan Kegiatan
        <?php elseif ($status == 'edit') : ?>
            Perubahan Undangan/Pemberitahuan Kegiatan
        <?php else : ?>
            Pembatalan Undangan/Pemberitahuan Kegiatan
        <?php endif; ?>
    </h2>

    <div class="card">
        <h1>{{$task}}</h1>
        <p class="" style="text-align: justify; margin-left: 15px;">Waktu/Tanggal Mulai : {{$hour_start}}, <?= indoDate($date_start) ?> </p>
        <p class="" style="text-align: justify; margin-left: 15px;">Waktu/Tanggal Selesai : {{$hour_finish}}, <?= indoDate($date_finish) ?></p>
        <p class="" style="text-align: justify; margin-left: 15px;">Keterangan : {{$ket}}</p>
        <p><button style="background-color: blue;"><small>&copy; Aplikasi Management B2</small></button></p>
    </div>

</body>

</html>