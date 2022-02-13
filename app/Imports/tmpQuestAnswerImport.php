<?php

namespace App\Imports;

use App\Http\Controllers\Controller;
use App\Project;
use DB;
use App\Tmp_quest_answer_import;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class tmpQuestAnswerImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // $con = mysqli_connect("180.211.92.131", "adam", "Ad@mMR1db", "mri_b2");
        // $insert = mysqli_query($con, "INSERT INTO tmp_quest_answer_imports (respondent_id, answer, answer_code)
        // VALUES ('1', 'test', 'test2')");


        // $insert = DB::table('quest_answers')->insert([
        //     'respondent_id' => '1',
        //     'quest_question_id' => '123',
        //     'answer' => 'test',
        //     'answer_code' => 'test2'
        // ]);
        $ser = serialize($row);
        return new Tmp_quest_answer_import([
            'answer' => $ser
        ]);

        // $idProject = DB::table('projects')->where('nama', '=', $row['project'])->first();
        // $idRespondent = DB::table('respondents')->where('project_id', '=', $idProject->id)->where('sbjnum', '=', $row['sbjnum'])->first();
        // // dd($idRespondent->id);
        // $key = array_keys($row);
        // for ($i = 0; $i < count($key); $i++) {
        //     if ($key[$i] != 'project' && $key[$i] != 'sbjnum') {
        //         // dd($row[$key[$i]]);
        //         new Tmp_quest_answer_import([
        //             'respondent_id' => $idRespondent->id,
        //             'answer' => ($row[$key[$i]]) ? $row[$key[$i]] : '',
        //             'answer_code' => $key[$i]
        //         ]);
        //     }
        // }
        // dd($key);



        // $tgl = date('Y-m-d', ($row['intvdate'] - 25569) * 86400);
        // $vstart = gmdate('Y-m-d H:i:s', ($row['vstart'] - 25569) * 86400);
        // $vend = gmdate('Y-m-d H:i:s', ($row['vend'] - 25569) * 86400);
        // $upload = gmdate('Y-m-d H:i:s', ($row['upload'] - 25569) * 86400);
        // $duration = gmdate('H:i:s', ($row['duration'] - 25569) * 86400);

        // return new Tmp_quest_answer_import([
        // 'project' => $row['project'],
        // 'intvdate' => $tgl,
        // 'ses_a' => $row['ses_a'],
        // 'ses_b' => $row['ses_b'],
        // 'finalses' => $row['finalses'],
        // 'respname' => $row['respname'],
        // 'address' => $row['address'],
        // 'cityresp' => $row['cityresp'],
        // 'mobilephone' => preg_replace("/[^0-9]/", "", $row['mobilephone']),
        // 'email' => $row['email'],
        // 'gender' => $row['gender'],
        // 'usia' => $row['usia'],
        // 'education' => $row['education'],
        // 'occupation' => $row['occupation'],
        // 'vstart' => $vstart,
        // 'vend' => $vend,
        // 'pewitness' => $row['pewitness'],
        // 'srvyr' => $row['srvyr'],
        // 'kelurahan' => $row['kelurahan'],
        // 'pilot' => $row['pilot'],
        // 'rekaman' => $row['rekaman'],
        // 'duration' => $duration,
        // 'latitude' => $row['latitude'],
        // 'longitude' => $row['longitude'],
        // 'sbjnum' => $row['sbjnum'],
        // 'upload' => $upload,
        // ]);
    }
}
