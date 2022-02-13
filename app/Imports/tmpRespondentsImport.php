<?php

namespace App\Imports;

use App\Tmp_respondent;
use Exception;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class tmpRespondentsImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // var_dump(@(gmdate('H:i:s', ($row['duration'] - 25569) * 86400)));
        // var_dump($row['duration']);
        // var_dump(gmdate('H:i:s', ($row['duration'] - 25569) * 86400));
        // echo '<br>';
        // var_dump($row['respname']);
        try {
            $tgl = date('Y-m-d', ($row['intvdate'] - 25569) * 86400);
        } catch (Exception $e) {
            if (!isset($tgl)) {
                $error = 'intvdate';
            }
            $respname = $row['respname'];
        }
        // try {
        //     $vstart = gmdate('Y-m-d H:i:s', ($row['vstart'] - 25569) * 86400);
        // } catch (Exception $e) {
        //     if (!isset($vstart)) {
        //         $error = 'vstart';
        //     }
        //     $respname = $row['respname'];
        // }
        // try {
        //     $vend = gmdate('Y-m-d H:i:s', ($row['vend'] - 25569) * 86400);
        // } catch (Exception $e) {
        //     if (!isset($vend)) {
        //         $error = 'vend';
        //     }
        //     $respname = $row['respname'];
        // }
        try {
            $upload = gmdate('Y-m-d H:i:s', ($row['upload'] - 25569) * 86400);
        } catch (Exception $e) {
            if (!isset($upload)) {
                $error = 'upload';
            }
            $respname = $row['respname'];
        }
        // try {
        //     $duration = gmdate('H:i:s', ($row['duration'] - 25569) * 86400);
        // } catch (Exception $e) {
        //     if (!isset($duration)) {
        //         $error = 'duration';
        //     }
        //     $respname = $row['respname'];
        // }
        return new Tmp_respondent([
            'project' => $row['project'],
            'intvdate' => isset($tgl) ? $tgl : null,
            'ses_a' => $row['ses_a'],
            'ses_b' => $row['ses_b'],
            'finalses' => $row['finalses'],
            'respname' => $row['respname'],
            'address' => $row['address'],
            'cityresp' => $row['cityresp'],
            'mobilephone' => preg_replace("/[^0-9]/", "", $row['mobilephone']),
            'email' => $row['email'],
            'gender' => $row['gender'],
            'usia' => $row['usia'],
            'education' => $row['education'],
            'occupation' => $row['occupation'],
            'vstart' => $row['vstart'],
            'vend' => $row['vend'],
            'pewitness' => $row['pewitness'],
            'srvyr' => $row['srvyr'],
            'kelurahan' => $row['kelurahan'],
            'pilot' => $row['pilot'],
            'rekaman' => $row['rekaman'],
            'duration' => $row['duration'],
            'latitude' => $row['latitude'],
            'longitude' => $row['longitude'],
            'sbjnum' => $row['sbjnum'],
            'worksheet' => $row['worksheet'],
            'upload' => isset($upload) ? $upload : null,
            'kategori_honor' => $row['honor_intv'],
            'kategori_gift' => $row['gift'],
            'kode_bank' => $row['kode_bank'],
            'nomor_rekening' => $row['nomor_rekening'],
            'pemilik_rekening' => $row['pemilik_rekening'],
            'mobilephone_gift' => $row['mobilephone_gift'],
            'e_wallet_code' => $row['e_wallet_code'],
            'status_kepemilikan_mobilephone' => $row['status_kepemilikan_mobilephone'],
            'nama_pemilik_mobilephone' => $row['nama_pemilik_mobilephone']
        ]);
    }
}
