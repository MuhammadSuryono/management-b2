<?php

namespace App\Http\Controllers\Respondent;

use App\Data_pengecekan;
use App\Http\Controllers\Controller;
use App\Data_qc;
use App\Project;
use App\Quest_answer;
use App\Quest_code;
use App\Quest_option;
use App\Quest_question;
use App\Respondent;
use App\Log_status_qc;
use Illuminate\Http\Request;
use DB;
use App\Import_excel;
use App\Imports\tmpQuestAnswerImport;
use App\Tmp_quest_answer_import;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\tmpRespondentsImport;
use App\Log_status_callback;
use App\Tmp_Respondent;
use App\Project_imported;
use App\Quest_answer_upload;
use App\Status_callback;
use App\Status_pengecekan;
use App\Status_qc;
use DateTime;
use Intervention\Image\Facades\Image;
use Requestby;

class DataQcsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $formQc = Data_qc::all();
        $add_url = url('/form_qc/create');
        return view('respondents.form_qc.index', compact('formQc', 'add_url'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data_qc = Data_qc::first();
        $title = 'Tambah Form QC';
        $create_edit = 'create';
        $action_url = url('/form_qc');
        $include_form = 'respondents.form_qc.form_qc';
        return view('crud.open_record', compact('data_qc', 'title', 'create_edit', 'action_url', 'include_form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validation
        $validatedData = $request->validate([
            'kota' => 'required|unique:kotas|max:60',
        ]);
        $id = $request->id;

        if ($_FILES["file"]["name"]) {
            $extension = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
            $nama_gambar = 'ssqc-' . \Carbon\Carbon::now()->format('Y-m-dH:i:s')  . "." . $extension;
            $target_file = $_SERVER['DOCUMENT_ROOT'] . explode('/', $_SERVER['REQUEST_URI'])[1] . '/public/uploads/' . $nama_gambar;
            $moved = move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);

            $link = "/respondents/$id/edit";
        }

        if (($request->id && $request->tanggal_qc && $request->jam_qc && $request->jumlah_qc && $nama_gambar)) {
            $data_qc = Data_qc::create([
                'respondent_id' => $request->id,
                'tanggal_qc' => $request->tanggal_qc,
                'jam_qc' => $request->jam_qc,
                'callback' => $request->jumlah_qc,
                'screenshoot' => $nama_gambar,
                'created_at' => time()
            ]);
        }
        if (isset($data_qc))
            return redirect($link)->with('status', 'Form QC berhasil disimpan');
        else
            return redirect($link)->with('status-fail', 'Form QC gagal disimpan');
        return redirect('/kotas')->with('status', 'Data sudah disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Kota  $kota
     * @return \Illuminate\Http\Response
     */
    public function show(Kota $kota)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Kota  $kota
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Data_qc $data_qc, $id)
    {
        $data_qc = Data_qc::find($id);
        $title = 'Edit Form Qc';
        $create_edit = 'edit';
        $action_url = url('/form_qc') . '/' . $data_qc->id;
        $include_form = 'respondents.form_qc.form_qc';
        return view('crud.open_record', compact('data_qc', 'title', 'create_edit', 'action_url', 'include_form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Kota  $kota
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Data_qc $data_qc)
    {
        $validatedData = $request->validate([
            'tanggal_qc' =>  'required',
            'jam_qc' => 'required',
            'callback' => 'required'
        ]);
        Data_qc::where('id', $request->id)->update([
            'tanggal_qc' => $request->tanggal_qc,
            'jam_qc' => $request->jam_qc,
            'callback' => $request->callback,
        ]);
        return redirect('/form_qc')->with('status', 'Data sudah diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Kota  $kota
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kota $kota)
    {
        //
    }

    public function delete($id)
    {
        Data_qc::destroy($id);
        return redirect('/form_qc')->with('status', 'Data sudah dihapus');
    }

    public function view(Request $request)
    {
        $file = $request->file;
        return response()->file($_SERVER['DOCUMENT_ROOT'] . '/uploads/' . $file);
    }

    public function setTemplateQc(Request $request)
    {
        $project_id = session('current_project_id');
        return view('respondents.form_qc.set_template_qc', compact('project_id'));
    }

    public function loadTemplateQc(Request $request)
    {
        $id = $request->id;
        $project_id = session('current_project_id');
        $code = Quest_code::where('id', $id)->first();
        return view('respondents.form_qc.set_template_qc', compact('id', 'code', 'project_id'));
    }

    public function storeTemplateQc(Request $request)
    {
        // var_dump($request->id);
        // var_dump($request->project_id);
        // dd($request->nama);
        date_default_timezone_set('Asia/Jakarta');
        $time = date('Y-m-d H:i:s');
        if (is_null($request->id)) {
            $code = Quest_code::insert([
                'project_id' => $request->project_id,
                'nama' => $request->nama,
                'created_at' => $time
            ]);
            $checkCode = Quest_code::where('project_id', $request->project_id)->orderBy('id', 'desc')->first();
        } else {
            Quest_code::where('id', $request->id)->update(['nama' => $request->nama]);
            $checkCode['id'] = $request->id;
        }


        if ($request->question) {
            for ($i = 0; $i < count($request->question); $i++) {
                if (is_null($request->idQuestion[$i])) {
                    if (!is_null($request->question[$i])) {
                        Quest_question::insert([
                            'quest_code_id' => $checkCode['id'],
                            'pertanyaan' => $request->question[$i],
                            'jenis' => $request->type[$i],
                            'urutan' => ($request->urutan[$i]) ? $request->urutan[$i] : 0,
                            'quest_code' => isset($request->questCode[$i]) ? $request->questCode[$i] : 0,
                            'created_at' => $time
                        ]);
                    } else {
                        Quest_question::where('id', $request->idQuestion[$i])->delete();
                        Quest_option::where('quest_question_id', $request->idQuestion[$i])->delete();
                        Quest_answer::where('quest_question_id', $request->idQuestion[$i])->delete();
                    }
                } else {
                    if (!is_null($request->question[$i])) {
                        Quest_question::where('id', $request->idQuestion[$i])->update([
                            'quest_code_id' => $checkCode['id'],
                            'pertanyaan' => $request->question[$i],
                            'jenis' => $request->type[$i],
                            'urutan' => ($request->urutan[$i]) ? $request->urutan[$i] : 0,
                            'quest_code' => isset($request->questCode[$i]) ? $request->questCode[$i] : 0,
                            'created_at' => $time
                        ]);
                    } else {
                        Quest_question::where('id', $request->idQuestion[$i])->delete();
                        Quest_option::where('quest_question_id', $request->idQuestion[$i])->delete();
                        Quest_answer::where('quest_question_id', $request->idQuestion[$i])->delete();
                    }
                }
            }
        }

        if ($request->option) {

            $checkIdentity = [];
            for ($i = 0; $i < count($request->option); $i++) {
                $optionIndentity = $request->optionIdentity[$i];
                $question = Quest_question::where('pertanyaan', $optionIndentity)->orderBy('id', 'DESC')->first();
                if (isset($question['id'])) {
                    if (!in_array($optionIndentity, $checkIdentity)) {
                        array_push($checkIdentity, $optionIndentity);
                        DB::table('quest_options')->where('quest_question_id', $question['id'])->delete();
                    }
                    if (!is_null($request->option[$i])) {
                        Quest_option::insert([
                            'quest_question_id' => $question['id'],
                            'option' => $request->option[$i],
                            'value' => ($request->value[$i]) ? $request->value[$i] : 0,
                            'created_at' => $time
                        ]);
                    }
                }


            }
        }
        return redirect('form_qc/load_template_qc/' . $checkCode['id'])->with('status', 'Berhasil disimpan');
    }

    public function deleteTemplateQc(Request $request)
    {
        $id = $request->id;
        Quest_code::where('id', $id)->delete();
        Quest_question::where('quest_code_id', $id)->delete();
        return redirect("projects/" . session('current_project_id') . "/edit");
    }

    public function qcRespondent(Request $request)
    {
        $respondent = Respondent::where('id', $request->id)->first();
        $project = Project::where('id', $respondent['project_id'])->first();
        $questCode = Quest_code::where('nama', $respondent->worksheet)->where('project_id', $respondent->project_id)->first();
        $questQuestion = Quest_question::where('quest_code_id', $questCode['id'])->orderBy('urutan')->get();
        $getQuestAnswer = DB::table('quest_answers')->where('respondent_id', $request->id)->join('quest_questions', 'quest_questions.id', '=', 'quest_answers.quest_question_id')->get();
        $status_callback = Status_callback::all();
        $checkFilled = Quest_answer::where('respondent_id', $request->id)->count();
        $logCallback = Log_status_callback::where('respondent_id', $request->id)->get();
        $status_pengecekan = Status_pengecekan::all();
        $checkPengecekanRekaman = Data_pengecekan::where('respondent_id', $request->id)->first();
        if (count($logCallback) >= 3 && !$checkPengecekanRekaman) {
            $showPengecekanRekaman = true;
            foreach ($logCallback as $lc) {
                if ($lc->status_callback_id == 1)
                    $showPengecekanRekaman = false;
            }
        } else {
            $showPengecekanRekaman = false;
        }
        // dd(count($logCallback));

        return view('respondents.form_qc.set_qc', compact('respondent', 'project', 'questCode', 'questQuestion', 'getQuestAnswer', 'status_callback', 'checkFilled', 'logCallback', 'status_pengecekan', 'showPengecekanRekaman', 'checkPengecekanRekaman'));
    }

    public function storeRespondentQc(Request $request)
    {
        $respondents = Respondent::where('id', $request->respondent_id)->first();
        $date = date("Y-m-d H:i:s");

        $data = [];
        foreach ($request->all() as $key => $value) {
            if (strpos($key, "answer") !== false) {
                $data[] = [
                    $key => $value
                ];
            }
        }

        $questCode = Quest_code::where('project_id', $request->project_id)->first();

        $i = 1;

        DB::table('quest_answers')->where('respondent_id', $request->respondent_id)->delete();
        foreach ($data as $d) {
            $key = key($d);
            $explodeString = explode('_', $key);
            $questionId = $explodeString[count($explodeString) - 1];

            $question = Quest_question::where('id', $questionId)->first();
            if (is_array($d[$key])) {
                if ($question['jenis'] == 'ma') {
                    $questOption = Quest_option::where('quest_question_id', '=', $question['id'])->get();
                    foreach ($questOption as $qo) {
                        Quest_answer::insert([
                            'quest_question_id' => $questionId,
                            'respondent_id' => $request->respondent_id,
                            'answer' => (in_array($qo->value, $d[$key])) ? 1 : 0,
                            'answer_code' => $qo->value,
                            'created_at' => $date
                        ]);
                    }
                } else {
                    for ($j = 0; $j < count($d[$key]); $j++) {
                        if (!is_null($d[$key][$j])) {
                            $last = $j + 1;
                            Quest_answer::insert([
                                'quest_question_id' => $questionId,
                                'respondent_id' => $request->respondent_id,
                                'answer' => $d[$key][$j],
                                'created_at' => $date
                            ]);
                        }
                    }
                }
            } else {
                if (!is_null($d[$key])) {
                    Quest_answer::insert([
                        'quest_question_id' => $questionId,
                        'respondent_id' => $request->respondent_id,
                        'answer' => $d[$key],
                        'created_at' => $date
                    ]);
                }
            }
        }

        $getQuestAnswer = DB::table('quest_answers')->join('quest_questions', 'quest_questions.id', '=', 'quest_answers.quest_question_id')->where('respondent_id', $request->respondent_id)->where('quest_questions.jenis', '!=', 'fa')->get();
        // dd($getQuestAnswer);
        foreach ($getQuestAnswer as $g) {
            $check = DB::table('quest_answer_uploads')->where('respondent_id', $request->respondent_id)->where('answer_code', strtolower($g->quest_code))->first();
            if (is_null($check)) {
                $check = DB::table('quest_answer_uploads')->where('respondent_id', $request->respondent_id)->where('answer_code', 'like', strtolower($g->quest_code) . '%')->get();
                foreach ($check as $c) {

                    $explode = explode('_', $c->answer_code);
                    $result = '';
                    for ($i = 0; $i < count($explode) - 1; $i++) {
                        $result .= $explode[$i];
                        if ($i < count($explode) - 2)
                            $result .= '_';
                    }

                    $questAnswer = DB::table('quest_questions')->join('quest_answers', 'quest_answers.quest_question_id', '=', 'quest_questions.id')->where('quest_code_id', '=', $g->quest_code_id)->where('quest_code', '=', $result)->where('answer_code', '=', $explode[count($explode) - 1])->where('quest_answers.respondent_id', '=', $request->respondent_id)->first();

                    if (!is_null($questAnswer)) {
                        if ($questAnswer->answer == $c->answer) {
                            if ($respondents->status_qc_id != 5) {
                                Respondent::where('id', $request->respondent_id)->update([
                                    'status_qc_id' => 5,
                                    'tanggal_update_qc' => $date
                                ]);

                                Log_status_qc::insert([
                                    'respondent_id' => $respondents->id,
                                    'status_qc_id' => 5,
                                    'created_at' => $date
                                ]);
                            } else {
                                Respondent::where('id', $request->respondent_id)->update([
                                    'status_qc_id' => 5
                                ]);
                            }
                        } else {
                            if ($respondents->status_qc_id != 7) {
                                Respondent::where('id', $request->respondent_id)->update([
                                    'status_qc_id' => 7,
                                    'tanggal_update_qc' => $date
                                ]);

                                Log_status_qc::insert([
                                    'respondent_id' => $respondents->id,
                                    'status_qc_id' => 7,
                                    'created_at' => $date
                                ]);
                            } else {
                                Respondent::where('id', $request->respondent_id)->update([
                                    'status_qc_id' => 7
                                ]);
                            }
                            break;
                        }
                    }
                }
            } else {
                if ($g->answer == $check->answer) {
                    if ($respondents->status_qc_id != 5) {
                        Respondent::where('id', $request->respondent_id)->update([
                            'status_qc_id' => 5,
                            'tanggal_update_qc' => $date
                        ]);

                        Log_status_qc::insert([
                            'respondent_id' => $respondents->id,
                            'status_qc_id' => 5,
                            'created_at' => $date
                        ]);
                    } else {
                        Respondent::where('id', $request->respondent_id)->update([
                            'status_qc_id' => 5
                        ]);
                    }
                } else {
                    if ($respondents->status_qc_id != 7) {
                        Respondent::where('id', $request->respondent_id)->update([
                            'status_qc_id' => 7,
                            'tanggal_update_qc' => $date
                        ]);

                        Log_status_qc::insert([
                            'respondent_id' => $respondents->id,
                            'status_qc_id' => 7,
                            'created_at' => $date
                        ]);
                    } else {
                        Respondent::where('id', $request->respondent_id)->update([
                            'status_qc_id' => 7
                        ]);
                    }
                    break;
                }
            }
        }
        return redirect(url()->previous())->with('status', 'Berhasil disimpan');
    }

    public function upload(Request $request)
    {
        $id = $request->id;
        $link = "/projects/$id/edit";

        DB::table('tmp_quest_answer_imports')->truncate();
        Excel::import(new tmpQuestAnswerImport, $request->file);
        $tmpQuestAnswer = Tmp_quest_answer_import::all();
        foreach ($tmpQuestAnswer as $tqa) {
            $data = unserialize($tqa->answer);
            $key = array_keys($data);
            for ($i = 0; $i < count($key); $i++) {
                $idProject = DB::table('projects')->where('nama', '=', $data['project'])->first();
                $idRespondent = DB::table('respondents')->where('project_id', '=', $idProject->id)->where('sbjnum', '=', $data['sbjnum'])->first();
                if (!$idRespondent) {
                    return redirect($link)->with('status-fail', 'Upload gagal, Data sbjnum belum ada di database.');
                }
            }
        }

        foreach ($tmpQuestAnswer as $tqa) {
            $data = unserialize($tqa->answer);
            $key = array_keys($data);
            for ($i = 0; $i < count($key); $i++) {
                $idProject = DB::table('projects')->where('nama', '=', $data['project'])->first();
                $idRespondent = DB::table('respondents')->where('project_id', '=', $idProject->id)->where('sbjnum', '=', $data['sbjnum'])->first();
                $checkData = Quest_answer_upload::where('respondent_id', '=', $idRespondent->id)->where('answer', '=', $data[$key[$i]])->where('answer_code', '=', $key[$i])->first();
                if ($idRespondent && !is_null($data[$key[$i]]) && $key[$i] && !$checkData) {
                    if ($key[$i] != 'project' && $key[$i] != 'sbjnum') {
                        Quest_answer_upload::insert([
                            'respondent_id' => $idRespondent->id,
                            'answer' => ($data[$key[$i]]) ? $data[$key[$i]] : '0',
                            'answer_code' => $key[$i]
                        ]);
                    }
                }
            }
        }

        date_default_timezone_set('Asia/Jakarta');
        $time = date('Y-m-d H:i:s');
        if ($_FILES) {
            if ($_FILES["file"]["name"]) {
                $extension = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
                $nama_gambar = $_FILES["file"]["name"];
                $target_file = $_SERVER['DOCUMENT_ROOT'] . explode('/', $_SERVER['REQUEST_URI'])[1] . '/public/uploads/' . $nama_gambar;
                $moved = move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);


                if ($moved) {
                    DB::table('quest_uploaded_files')->insert([
                        'file' => $nama_gambar,
                        'project_id' => $id,
                        'created_at' => $time
                    ]);
                }
            }
        }

        return redirect($link)->with('status', 'Jawaban QC Responden berhasil disimpan');
    }

    public function storeCallback(Request $request)
    {
        $link = "/form_qc/qc_respondent/$request->id";
        $time = date('Y-m-d H:i:s');
        Log_status_callback::insert([
            'respondent_id' => $request->id,
            'status_callback_id' => $request->value,
            'created_at' => $time
        ]);

        $data_qc = Respondent::where('id', $request->id)->update([
            'status_callback_id' => $request->value
        ]);

        if (isset($data_qc))
            return redirect($link)->with('status', 'Status Callback berhasil diubah');
        else
            return redirect($link)->with('status-fail', 'Status Callback gagal diubah');
    }

    public function storeFormQc(Request $request)
    {
        $id = $request->id;
        $link = "/form_qc/qc_respondent/$id";

        if ($_FILES["file"]["name"]) {

            $extension = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
            $nama_gambar = 'audioqc-' . \Carbon\Carbon::now()->format('Y-m-dH:i:s')  . "." . $extension;
            $target_file = $_SERVER['DOCUMENT_ROOT'] . explode('/', $_SERVER['REQUEST_URI'])[1] . '/public/uploads/' . $nama_gambar;

            $filesize = filesize($_FILES["file"]["tmp_name"]);
            if ($filesize > 5000000) {
                return redirect($link)->with('status-fail', 'File yang di upload melebihi 5MB');
            } else {
                $moved = move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
            }
        }

        if (($request->id && $request->tanggal_qc && $request->jam_qc && $request->jumlah_qc && $nama_gambar)) {
            $data_qc = Data_qc::create([
                'respondent_id' => $request->id,
                'tanggal_qc' => $request->tanggal_qc,
                'jam_qc' => $request->jam_qc,
                'callback' => $request->jumlah_qc,
                'screenshoot' => $nama_gambar,
                'created_at' => time()
            ]);
        }
        if (isset($data_qc))
            return redirect($link)->with('status', 'Form Laporan Callback berhasil disimpan');
        else
            return redirect($link)->with('status-fail', 'Form Laporan Callback gagal disimpan');
    }

    public function viewUploadedFile(Request $request)
    {
        // $formQc = Data_qc::all();
        // dd($request->id);
        $respondent = Quest_answer_upload::select('respondents.respname', 'quest_answer_uploads.*')
            ->leftJoin('respondents', 'quest_answer_uploads.respondent_id', '=', 'respondents.id')
            ->where('respondents.project_id', $request->id)
            ->get();
        // $add_url = url('/form_qc/create');
        return view('respondents.form_qc.show_uploaded_answer', compact('respondent'));
    }

    public function getDataPengecekan(Request $request)
    {
        $data_pengecekan = Data_pengecekan::join('respondents', 'respondents.id', '=', 'data_pengecekans.respondent_id')
            ->where('respondents.project_id', $request->id)
            ->where('data_pengecekans.on_notif', 1)->get();

        // echo json_encode($data_pengecekan);
        // die;
        $data = '';
        foreach ($data_pengecekan as $dp) :
            $result = '';
            $status = 0;
            if ($dp->s1 != 0) {
                $status = DB::table('status_pengecekans')->where('code', 's1')->first();
                $result .= "&#9900;  $status->keterangan_gagal_pengecekan <br>";
                $status = 1;
            }
            if ($dp->s2 != 0) {
                $status = DB::table('status_pengecekans')->where('code', 's2')->first();
                $result .= "&#9900;  $status->keterangan_gagal_pengecekan <br>";
                $status = 1;
            }
            if ($dp->s3 != 0) {
                $status = DB::table('status_pengecekans')->where('code', 's3')->first();
                $result .= "&#9900;  $status->keterangan_gagal_pengecekan <br>";
                $status = 1;
            }

            if ($dp->s4 != 0) {
                $status = DB::table('status_pengecekans')->where('code', 's4')->first();
                $result .= "&#9900;  $status->keterangan_gagal_pengecekan <br>";
                $status = 1;
            }

            if ($dp->s5 != 0) {
                $status = DB::table('status_pengecekans')->where('code', 's5')->first();
                $result .= "&#9900;  $status->keterangan_gagal_pengecekan <br>";
                $status = 1;
            }

            if ($dp->s6 != 0) {
                $status = DB::table('status_pengecekans')->where('code', 's6')->first();
                $result .= "&#9900;  $status->keterangan_gagal_pengecekan <br>";
                $status = 1;
            }

            if ($dp->s7 != 0) {
                $status = DB::table('status_pengecekans')->where('code', 's7')->first();
                $result .= "&#9900;  $status->keterangan_gagal_pengecekan <br>";
                $status = 1;
            }

            if ($dp->s8 != 0) {
                $status = DB::table('status_pengecekans')->where('code', 's8')->first();
                $result .= "&#9900;  $status->keterangan_gagal_pengecekan <br>";
                $status = 1;
            }

            if ($dp->s9 != 0) {
                $status = DB::table('status_pengecekans')->where('code', 's9')->first();
                $result .= "&#9900;  $status->keterangan_gagal_pengecekan <br>";
                $status = 1;
            }

            if ($dp->s10 != 0) {
                $status = DB::table('status_pengecekans')->where('code', 's10')->first();
                $result .= "&#9900;  $status->keterangan_gagal_pengecekan <br>";
                $status = 1;
            }

            if ($dp->s11 != 0) {
                $status = DB::table('status_pengecekans')->where('code', 's11')->first();
                $result .= "&#9900;  $status->keterangan_gagal_pengecekan <br>";
                $status = 1;
            }

            if ($dp->s12 != 0) {
                $status = DB::table('status_pengecekans')->where('code', 's12')->first();
                $result .= "&#9900;  $status->keterangan_gagal_pengecekan <br>";
                $status = 1;
            }

            if ($status == 1) {
                $data .= "
                <tr>
                <td class='text-dark'><a href='{{ url('/form_pengecekan/')}}/{{$dp->id}}/edit' class='text-dark'>" . (isset($dp->respondent->respname) ? $dp->respondent->respname : '-') . " </a></td>
                <td class='text-dark'>" . (isset($dp->respondent->project->nama) ? $dp->respondent->project->nama : '-') . "</td>
                <td class='text-dark'>";

                if (isset($dp->respondent->srvyr)) {
                    $pwtCode = substr($dp->respondent->srvyr, 3, 6);
                    $pwtCode = (int)$pwtCode;

                    $cityCode = substr($dp->respondent->srvyr, 0, 3);
                    $cityCode = (int)$cityCode;

                    $pwt = DB::table('teams')
                        ->where('no_team', $pwtCode)
                        ->where('kota_id', $cityCode)
                        ->first();

                    if ($pwt) {
                        $data .= $pwt->nama;
                    } else {
                        $data .= '-';
                    }
                } else {
                    $data .= '-';
                }

                $data .= "
                    </td>
                <td class='text-dark'> " . (isset($dp->respondent->kota->kota) ? $dp->respondent->kota->kota : '-') . " </td>
                <td class='text-dark border-bottom border-primary' style='text-align: justify; padding: 5px 0px;'>
                     " . $result . "
                </td>
            </tr>";
            }

        endforeach;
        echo $data;
    }

    public function getDataUpdateQc(Request $request)
    {
        $respondents = Respondent::join('projects', 'projects.id', '=', 'respondents.project_id')
            ->whereNotNull('tanggal_update_qc')
            ->where('tanggal_update_qc', '!=', '0000-00-00 00:00:00')
            ->where('projects.nama', $request->project)
            ->orderBy('tanggal_update_qc')->get();

        echo json_encode($respondents);
        $data = "";
        foreach ($respondents as $r) {
            $data .= "
            <tr>";

            if (!is_null($r['tanggal_update_qc'])) :
                $date1 = strtotime(date('Y-m-d h:i:s', time()));
                $date2 = strtotime($r['tanggal_update_qc']);
                $diff = abs($date1 - $date2);
                $years = floor($diff / (365 * 60 * 60 * 24));
                $months = floor(($diff - $years * 365 * 60 * 60 * 24)
                    / (30 * 60 * 60 * 24));
                $days = floor(($diff - $years * 365 * 60 * 60 * 24 -
                    $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
                $hours = floor(($diff - $years * 365 * 60 * 60 * 24
                    - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24)
                    / (60 * 60));
                $now = new DateTime();

                $date = new DateTime($r['tanggal_update_qc']);
                $status = $date->diff($now)->format("%R");
                $day = $date->diff($now)->format("%d");
                $hour = $date->diff($now)->format("%h");

                $batas_waktu = ($r->batas_waktu_do) ? $r->batas_waktu_do : 5;
                if ($status == '+') {
                    if ($days >= floor($batas_waktu / 2) + 2) {
                        $statusColor = 'danger';
                    } else if ($days == floor($batas_waktu / 2) + 1) {
                        $statusColor = 'warning';
                    } else {
                        $statusColor = 'success';
                    }
                } else {
                    $statusColor  = 'danger';
                }

                if ($years == 0 && $months == 0 && $days <= $batas_waktu) {
                    $data .= "
                        <td class='text-dark'> " . $r['respname']  .    "</td>
                        <td class='text-dark'> " . (isset($r->project->nama) ? $r->project->nama : '-') . "</td>
                        <td class='text-dark'>";

                    if ($r->srvyr) {
                        $pwtCode = substr($r->srvyr, 3, 6);
                        $pwtCode = (int)$pwtCode;

                        $cityCode = substr($r->srvyr, 0, 3);
                        $cityCode = (int)$cityCode;

                        $pwt = DB::table('teams')
                            ->where('no_team', $pwtCode)
                            ->where('kota_id', $cityCode)
                            ->first();

                        if ($pwt) {
                            $data .= $pwt->nama;
                        } else {
                            $data .= '-';
                        }
                    } else {
                        $data .= '-';
                    }
                    $data .= "
                        </td>
                        <td class='text-dark'>" . (isset($r->kota->kota) ? $r->kota->kota : '-') . " </td>
                        <td class='text-dark'> " . (isset($r->status_qc->keterangan_qc) ? $r->status_qc->keterangan_qc : '-') . " </td>
                        <td class='text-center'>
                            <span class='badge bg-" . $statusColor . "  text-white'>
                                 " . (($status == '+') ? '-' : '+') .   $days . " Hari
                            </span>
                        </td>
                        <td class='text-dark'> " . $r->batas_waktu_do  . "hari</td>";
                }
                $data .= "</tr>";
            endif;
        }
        echo $data;
    }
}
