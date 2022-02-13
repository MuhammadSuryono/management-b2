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
                width: 60%;
                margin: auto;
                text-align: center;
                font-family: arial;
            }
        }

        @media only screen and (min-width: 768px) {

            /* For desktop: */
            .card {
                box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
                width: 30%;
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

        .center-img {
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        table.center {
            margin-left: auto;
            margin-right: auto;
        }

        th {
            text-align: left;
            padding-bottom: 15px;
        }

        td {
            text-align: right;
            padding-bottom: 15px;
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

        <div style="width: 100%; height: 80px; background-color: #2e86c1;">
            <img src="logomri2.png" style="width: 100px;" alt="" class="center-img">
        </div>
        <div class="content-dir-item" class="center-img">
            <img src="check3.png" style="width: 40px; text-align: center;vertical-align: middle;line-height: 45px;" />
            <h3 style="color:#00db02; display: inline; text-align: center;vertical-align: middle;line-height: 45px;">Berhasil</h3>
        </div>

        <table class="center" style="margin-top: 15px;">
            <tr>
                <th>Tanggal Transaksi</th>
                <td>1000-01-01 00:00:00</td>
            </tr>
            <tr>
                <th>Nama Penerima</th>
                <td>Firman</td>
            </tr>
            <tr>
                <th>Bank Tujuan</th>
                <td>Mandiri</td>
            </tr>
            <tr>
                <th>No. Rekening Tujuan</th>
                <td>123456</td>
            </tr>
            <tr>
                <th>Dari Rekening</th>
                <td>987654</td>
            </tr>
            <tr>
                <th>Nominal</th>
                <td>Rp. 100,000</td>
            </tr>
            <tr>
                <th>No. Referensi</th>
                <td>123131</td>
            </tr>
        </table>
        <div style="width: 100%; height: 40px; background-color: #2e86c1; margin-top: 15px;">
            <p style="text-align: center;vertical-align: middle;line-height: 45px;">&copy; MRI Transfer</p>
        </div>
    </div>

</body>

</html>