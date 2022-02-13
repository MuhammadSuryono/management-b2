<?php

namespace App\Http\Controllers\Respondent;

use App\Data_pengecekan;
use Session;
use App\Http\Controllers\Controller;
use App\User_role;
use App\Respondent;
use App\Kota;
use App\Pendidikan;
use App\SesFinal;
use App\Gender;
use App\Pekerjaan;
use App\Project_imported;
use App\IsValid;
use App\Project;
use App\Status_qc;
use App\Status_callback;
use App\Team;
use App\Team_jabatan;
use App\Flag_rule;
use App\Data_qc;
use App\Log_status_qc;
use App\Project_honor_do;
use App\Quest_code;
use App\Respondent_btf;
use App\Respondent_gift;
use App\Status_pengecekan;
use App\Status_temuan_dp;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mpdf\Tag\Q;
use Requestby;

class RespondentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $cropNotif = true;
        $date = date("Y-m-d H:i:s");

        $allProject = Project::all();
        $segment = [];
        foreach ($allProject as $ap) {
            if ($ap->batas_waktu_do) {
                $dataRespondent = Respondent::where('project_id', '=', $ap->id)->where('status_qc_id', '=', 4)->whereNotNull('tanggal_update_qc')->where('tanggal_update_qc', '!=', '0000-00-00 00:00:00')->where('tanggal_update_qc', '<=', Carbon::now()->subDays($ap->batas_waktu_do)->toDateTimeString())->get();
                foreach ($dataRespondent as $r) {
                    Log_status_qc::insert([
                        'respondent_id' => $r->id,
                        'status_qc_id' => 9,
                        'created_at' => $date
                    ]);
                }
                $data = Respondent::where('project_id', '=', $ap->id)->where('status_qc_id', '=', 4)->whereNotNull('tanggal_update_qc')->where('tanggal_update_qc', '!=', '0000-00-00 00:00:00')->where('tanggal_update_qc', '<=', Carbon::now()->subDays($ap->batas_waktu_do)->toDateTimeString())->update(['status_qc_id' => 6]);
            }
        }

        if ($request->project_imported_id != 'all' && $request->project_imported_id) {
            $project_importeds = Project_imported::all()->sortBy('project_imported');
            $kotas = Respondent::join('kotas', 'respondents.kota_id', '=', 'kotas.id')->select('kotas.*')->where('project_imported_id', '=', $request->project_imported_id)->orderBy('kotas.kota', 'ASC')->distinct()->get();
            $pendidikans = Respondent::join('pendidikans', 'respondents.pendidikan_id', '=', 'pendidikans.id')->select('pendidikans.*')->where('project_imported_id', '=', $request->project_imported_id)->distinct()->get();
            $ses_finals = Respondent::join('ses_finals', 'respondents.ses_final_id', '=', 'ses_finals.id')->select('ses_finals.*')->where('project_imported_id', '=', $request->project_imported_id)->distinct()->get();
            $genders = Respondent::join('genders', 'respondents.gender_id', '=', 'genders.id')->select('genders.*')->where('project_imported_id', '=', $request->project_imported_id)->distinct()->get();
            $pekerjaans = Respondent::join('pekerjaans', 'respondents.pekerjaan_id', '=', 'pekerjaans.id')->select('pekerjaans.*')->where('project_imported_id', '=', $request->project_imported_id)->distinct()->get();
            $is_valids = Isvalid::join('respondents', 'is_valids.id', '=', 'respondents.is_valid_id')->select('is_valids.*')->where('project_imported_id', '=', $request->project_imported_id)->distinct()->get();
            $interviewersId = Respondent::select(\DB::raw('(RIGHT(srvyr, 4)) as interviewer_id'), \DB::raw('(LEFT(srvyr, 3)) as kota_id'))
                ->where('project_imported_id', '=', $request->project_imported_id)
                ->distinct()
                ->orderBy('respname')
                ->get();

            $interviewers = [];

            foreach ($interviewersId as $i) {
                $query = Team::select('id', 'nama')->where('no_team', $i['interviewer_id'])->where('kota_id', $i['kota_id'])->orderBy('nama')->first();
                array_push($interviewers, $query);
            }

            $segment = Respondent::select('worksheet')->where('project_imported_id', '=', $request->project_imported_id)->whereNotNull('worksheet')->distinct()->get();
            // dd($segment);
            // $segments = [];

            // foreach($segment as $s){
            //     arra
            // }

            $user_role = User_role::selectRaw('distinct roles.role')
                ->join('roles', 'roles.id', '=', 'user_roles.role_id')
                ->where('user_roles.user_id', [session('user_id')])
                ->where('roles.role', 'Administrators')
                ->get();

            $teams = Team::all();

            $namaProject = Project_imported::where('id', $request->project_imported_id)->first();

            $project = Project::where('nama', $namaProject->project_imported)->first();

            if (isset($project->id))
                $rules = Flag_rule::where('project_id', $project->id)->first();
        } else {
            $project_importeds = Project_imported::all()->sortBy('project_imported');
            $kotas = Kota::all()->sortBy('kota');
            $pendidikans = Pendidikan::all()->sortBy('pendidikan');
            $ses_finals = SesFinal::all();
            $genders = Gender::all();
            $teams = Team::all();
            $pekerjaans = Pekerjaan::all()->sortBy('pekerjaan');
            $is_valids = Isvalid::all();

            $interviewers = Team_jabatan::select('teams.id', 'teams.nama')
                ->join('teams', 'team_jabatans.team_id', '=', 'teams.id')
                ->where('team_jabatans.jabatan_id', 1)
                ->orderBy('teams.nama')
                ->get();

            $user_role = User_role::selectRaw('distinct roles.role')
                ->join('roles', 'roles.id', '=', 'user_roles.role_id')
                ->where('user_roles.user_id', [session('user_id')])
                ->where('roles.role', 'Administrators')
                ->get();
        }


        if (session('link_from') == 'saving') {
            $params = session('last_resp_param');
        } else {
            $params = $request->except('_token');
            Session::put('last_resp_param', $params);
        }

        session(['link_from' => 'menu']);
        $respondents = Respondent::filter($params)->orderBy('on_qc', 'DESC')->orderBy('respname', 'ASC')->get();
        // dd($respondents);
        $respondentsWithoutFlag = Respondent::select('id')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->whereNotNull('rekaman')
            ->where('upload', '>', Carbon::parse('-24 hours')); //kurang dari 24 jam

        $arrRespondentsWithoutFlag = [];
        $arrStatusFlagging = [];
        $arrRespondentsWithFlag = [];
        if (isset($rules) && ($rules->less_than_status || $rules->more_than_status || $rules->after_status || $rules->before_status || $rules->longlat_status || $rules->rekaman_status || $rules->upload_status)) {

            $respondentsWithFlag = Respondent::select('*')
                ->where('status_qc_id', '!=', 5)
                ->where(function ($query) use ($rules) {
                    $query->when($rules->less_than_status == 1, function ($query2) use ($rules) {
                        $time = round($rules->less_than_minute);
                        $output = sprintf('%02d:%02d:00', ($time / 60 % 60), ($time % 60));
                        return $query2->where('duration', '<', $output);
                    })
                        ->when(($rules->more_than_status == 1), function ($query2) use ($rules) {
                            $time = round($rules->more_than_minute);
                            $output = sprintf('%02d:%02d:00', ($time / 60 % 60), ($time % 60));
                            return $query2->orWhere('duration', '>', $output);
                        })
                        ->when(($rules->after_status == 1), function ($query2) use ($rules) {
                            $date = $rules->after_time;
                            return $query2->orWhereTime('vstart', '>', $date);
                        })
                        ->when(($rules->before_status == 1), function ($query2) use ($rules) {
                            $date = $rules->before_time;
                            return $query2->orWhereTime('vstart', '<', $date);
                        })
                        ->when(($rules->longlat_status == 1), function ($query2) use ($rules) {
                            $query2->orWhereNull('latitude');
                            return $query2->orWhereNull('longitude');
                        })
                        ->when(($rules->rekaman_status == 1), function ($query2) use ($rules) {
                            return $query2->orWhereNull('rekaman');
                        })
                        ->when(($rules->upload_status == 1), function ($query2) use ($rules) {

                            return  $query2->orWhereRaw('upload >= DATE_ADD(intvdate, INTERVAL 1 DAY)'); //lebih dari 24 jam
                        });
                })
                ->filter($params)->get();

            foreach ($respondentsWithoutFlag as $rwf) {
                array_push($arrRespondentsWithoutFlag, $rwf->id);
            }
            foreach ($respondentsWithFlag as $rwf) {
                array_push($arrRespondentsWithFlag, $rwf->id);

                $result = '';
                if ($rules->less_than_status == 1) {
                    $time = round($rules->less_than_minute);
                    $output = sprintf('%02d:%02d:00', ($time / 60 % 60), ($time % 60));
                    if ($rwf->duration < $output) {
                        $result .= "Durasi interview kurang dari $rules->less_than_minute menit";
                    }
                }

                if ($rules->more_than_status == 1) {
                    $time = round($rules->more_than_minute);
                    $output = sprintf('%02d:%02d:00', ($time / 60 % 60), ($time % 60));
                    if ($rwf->duration > $output) {
                        if ($result) {
                            $result .= ", Durasi interview lebih dari $rules->more_than_minute menit";
                        } else {
                            $result .= "Durasi interview lebih dari $rules->more_than_minute menit";
                        }
                    }
                }

                if ($rules->after_status == 1) {
                    $date = date('H:i:s', strtotime($rules->after_time));
                    $date2 = date('H:i:s', strtotime($rwf->vstart));
                    if ($date2 > $date) {
                        if ($result) {
                            $result .= ", Waktu mulai interview diatas $date";
                        } else {
                            $result .= "Waktu mulai interview diatas $date";
                        }
                    }
                }

                if ($rules->before_status == 1) {
                    $date = date('H:i:s', strtotime($rules->before_time));
                    $date2 = date('H:i:s', strtotime($rwf->vstart));

                    if ($date2 < $date) {
                        if ($result) {
                            $result .= ", Waktu mulai interview dibawah $date";
                        } else {
                            $result .= "Waktu mulai interview dibawah $date";
                        }
                    }
                }

                if ($rules->longlat_status == 1) {
                    if (is_null($rwf->latitude) || is_null($rwf->longitude)) {
                        if ($result) {
                            $result .= ", Data Latitude/Longitude tidak ada";
                        } else {
                            $result .= "Data Latitude/Longitude tidak ada";
                        }
                    }
                }

                if ($rules->rekaman_status == 1) {
                    if (is_null($rwf->rekaman)) {
                        if ($result) {
                            $result .= ", Data link rekaman tidak ada";
                        } else {
                            $result .= "Data link rekaman tidak ada";
                        }
                    }
                }

                if ($rules->upload_status == 1) {
                    // $date = date()
                    if (date('d-m-Y', strtotime($rwf->upload)) >= date('d-m-Y', strtotime("+1 day", strtotime($rwf->intvdate)))) {
                        if ($result) {
                            $result .= ", Data di upload h+1 dari waktu wawancara";
                        } else {
                            $result .= "Data di upload h+1 dari waktu wawancara";
                        }
                    }
                }
                $result .= '.';

                $arrStatusFlagging[$rwf->id] = $result;
            }
        }

        $arrRespondentBtf = [];
        $respondentBtf = Respondent_btf::select('respondent_id')->get();
        foreach ($respondentBtf as $r) {
            array_push($arrRespondentBtf, $r->respondent_id);
        }

        $dataInterviewers = [];
        foreach ($interviewers as $value) {
            if ($value != null) {
                array_push($dataInterviewers, $value);
            }
        }

        usort($dataInterviewers, array($this, "cmp"));
        $interviewers = $dataInterviewers;

        return view('respondents.respondents.index', compact(
            'respondents',
            'kotas',
            'pendidikans',
            'ses_finals',
            'genders',
            'pekerjaans',
            'project_importeds',
            'teams',
            'is_valids',
            'user_role',
            'interviewers',
            'arrRespondentsWithFlag',
            'arrRespondentsWithoutFlag',
            'arrRespondentBtf',
            'arrStatusFlagging',
            'cropNotif',
            'segment'
        ));
    }

    function cmp($a, $b) {
        return strcmp($a->nama, $b->nama);
    }


    public function storeKeteranganRekaman(Request $request)
    {
        $request->session()->forget('status');
        $request->session()->forget('status-fail');

        $status = DB::table('respondents')->where('id', $request->id)->update(['cek_rekaman' => $request->value]);
    }

    public function storeKeteranganCallback(Request $request)
    {
        $request->session()->forget('status');
        $request->session()->forget('status-fail');

        $status = DB::table('respondents')->where('id', $request->id)->update(['callback' => $request->value]);
    }

    public function storeKeteranganQc(Request $request)
    {
        $request->session()->forget('status');
        $request->session()->forget('status-fail');

        $status = DB::table('respondents')->where('id', $request->id)->update(['keterangan_qc' => $request->value]);
    }

    public function storeEvaluasi(Request $request)
    {
        $request->session()->forget('status');
        $request->session()->forget('status-fail');

        $valuePert = serialize($request->valuesPert);
        $valueJaw = serialize($request->valuesJaw);

        $status = DB::table('respondents')->where('id', $request->id)->update(['evaluasi_pertanyaan' => $valuePert]);
        $status = DB::table('respondents')->where('id', $request->id)->update(['evaluasi_jawaban' => $valueJaw]);
    }

    public function storeFormQc(Request $request)
    {
        $id = $request->id;

        if ($_FILES["file"]["name"]) {

            $extension = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
            $nama_gambar = 'audioqc-' . \Carbon\Carbon::now()->format('Y-m-dH:i:s')  . "." . $extension;
            $target_file = $_SERVER['DOCUMENT_ROOT'] . explode('/', $_SERVER['REQUEST_URI'])[1] . '/public/uploads/' . $nama_gambar;
            $moved = move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);

            $link = "/form_qc/qc_respondent/$id";
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
    }

    public function getEvaluasi(Request $request)
    {
        $evaluasi = DB::table('respondents')->select('evaluasi_jawaban', 'evaluasi_pertanyaan')->where('id', '=', $request->id)->first();

        $pertanyaan = unserialize($evaluasi->evaluasi_pertanyaan);
        $jawaban = unserialize($evaluasi->evaluasi_jawaban);

        return response()->json(['evaluasi_jawaban' => $jawaban, 'evaluasi_pertanyaan' => $pertanyaan]);
    }

    public function pickRespondent(Request $request)
    {
        $idProject = $request->project_imported_id;


        $interviewer = Team::where('id', $request->interviewer_id)->first();
        $kotaId = str_pad($interviewer['kota_id'], 3, '0', STR_PAD_LEFT);
        $interviewerId = str_pad($interviewer['no_team'], 4, '0', STR_PAD_LEFT);
        $code = $kotaId . $interviewerId;

        $respondents = Respondent::where('project_imported_id', $idProject)->where('srvyr', $code)->get();
        $onQc = Respondent::where('project_imported_id', $idProject)
            ->where('srvyr', $code)
            ->where(function ($query) {
                $query->where('on_qc', 1)
                    ->orWhere('pewitness', '!=', null);
            })
            ->count();

        $dropOut = 0;
        foreach ($respondents as $r) {
            if ($r['status_qc_id'] == 2 || $r['status_qc_id'] == 3 || $r['status_qc_id'] == 6 || $r['status_qc_id'] == 9) $dropOut++;
        }

        $totalDataBersih = ($respondents) ? count($respondents) - $dropOut : 0;
        $targetQc = ceil($totalDataBersih * 0.3) - $onQc;

        $setQc = Respondent::inRandomOrder()->where('project_imported_id', $idProject)
            ->where('srvyr', $code)
            ->where(function ($query) {
                $query->where('on_qc', 0)
                    ->orWhere('pewitness', '!=', null);
            })
            ->limit($targetQc)->update(['on_qc' => '1']);

        $params = explode("?", $_SERVER['REQUEST_URI']);

        if ($setQc) {
            return redirect('/respondents?' . $params[1])->with('status', 'Respondent berhasil diambil');
        } else {
            return redirect('/respondents?' . $params[1])->with('status-fail', 'Respondent sudah sesuai jumlah QC');
        }
    }

    public function setRespondent(Request $request)
    {
        $getRespondent = Respondent::where('id', '=', $request->id)->first();
        $idProject = $getRespondent->project_imported_id;
        $code = $getRespondent->srvyr;

        $respondents = Respondent::where('project_imported_id', $idProject)->where('srvyr', $code)->get();
        $onQc = Respondent::where('project_imported_id', $idProject)
            ->where('srvyr', $code)
            ->where(function ($query) {
                $query->where('on_qc', 1)
                    ->orWhere('pewitness', '!=', null);
            })
            ->count();

        $totalData = ($respondents) ? count($respondents) : 0;

        $targetQc = ceil($totalData * 0.3) - $onQc;
        // if ($targetQc > 0) {
        $setQc = Respondent::where('id', $request->id)->update(['on_qc' => '1']);
        // }

        if (isset($setQc)) {
            if ($setQc)
                return redirect(url()->previous())->with('status', 'Respondent berhasil diambil');
            else
                return redirect(url()->previous())->with('status-fail', 'Respondent gagal di set');
        } else {
            return redirect(url()->previous())->with('status-fail', 'Respondent sudah sesuai jumlah QC');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Respondent  $respondent
     * @return \Illuminate\Http\Response
     */
    public function show(Respondent $respondent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Respondent  $respondent
     * @return \Illuminate\Http\Response
     */
    public function edit(Respondent $respondent)
    {
        $kotas = Kota::all();
        $pendidikans = Pendidikan::all();
        $ses_finals = SesFinal::all();
        $genders = Gender::all();
        $pekerjaans = Pekerjaan::all();
        $project_importeds = Project_imported::all();
        $is_valids = Isvalid::all();
        $status_qc = Status_qc::orderBy('keterangan_qc')->get();
        $status_callback = Status_callback::all();
        $status_pengecekan = Status_pengecekan::all();
        $worksheet = Quest_code::where('project_id', $respondent->project_id)->get();
        $checkWorksheet = Quest_code::where('nama', '=', $respondent->worksheet)->where('project_id', '=', $respondent->project_id)->count();
        $dataRekaman = Data_pengecekan::where('respondent_id', '=', $respondent->id)->first();
        $honorDo = Project_honor_do::join('project_kotas', 'project_kotas.id', '=', 'project_honor_dos.project_kota_id')->where('project_kotas.project_id', '=', $respondent->project_id)->where('project_kotas.kota_id', '=', $respondent->kota_id)->get();
        $logQc = Log_status_qc::where('respondent_id', $respondent->id)->get();
        $statusTemuanDp = Status_temuan_dp::all();
        // dd($logQc);

        return view('respondents.respondents.edit', compact(
            'respondent',
            'kotas',
            'pendidikans',
            'ses_finals',
            'genders',
            'pekerjaans',
            'project_importeds',
            'is_valids',
            'status_qc',
            'status_callback',
            'status_pengecekan',
            'worksheet',
            'checkWorksheet',
            'dataRekaman',
            'honorDo',
            'logQc',
            'statusTemuanDp'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Respondent  $respondent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Respondent $respondent)
    {
        ini_set('post_max_size', '5M');
        ini_set('upload_max_filesize', '5M');
        $checkBtf = Respondent_btf::where('respondent_id', '=', $respondent->id)->count();

        if ($request->status_qc_id == 4) {
            Respondent::where('id', $respondent->id)->update([
                'tanggal_btf' => Carbon::now()
            ]);
            // if ($checkBtf == 0) {
            //     Respondent_btf::insert([
            //         'respondent_id' => $respondent->id,
            //         'created_at' => Carbon::now()
            //     ]);
            // }
        } else if ($request->status_qc_id == 5) {
            Respondent::where('id', $respondent->id)->update([
                'tanggal_ok' => Carbon::now()
            ]);
        }

        $nama_gambar = $respondent['evidence'];

        if ($_FILES) {
            if ($_FILES["evidence"]["name"]) {
                $extension = pathinfo($_FILES["evidence"]["name"], PATHINFO_EXTENSION);
                $nama_gambar = 'evidence-' . \Carbon\Carbon::now()->format('Y-m-dH:i:s')  . "." . $extension;
                $target_file = $_SERVER['DOCUMENT_ROOT'] . 'dev-b2/public/uploads/' . $nama_gambar;
                $filesize = filesize($_FILES["evidence"]["tmp_name"]);
                if ($filesize > 5000000) {
                    return redirect('/respondents/' . $respondent->id . '/edit')->with('status-fail', 'File yang di upload melebihi 5MB');
                } else {
                    move_uploaded_file($_FILES["evidence"]["tmp_name"], $target_file);
                }
            }
        }

        $respondents = Respondent::where('id', $respondent->id)->first();
        if ($respondents->temuan_dp != $request->keterangan_temuan_dp || $respondents->temuan_dp != $request->status_temuan_dp_id) {
            $updateUserDp = session('user_id');
            if ($respondents->status_qc_id != 5)
                $keteranganTambahanDp = "Diisi saat status QC belum OK";
            else {
                $waktuUpdateQc = strtotime($respondents->tanggal_ok);
                $now = time();
                $datediff = $now - $waktuUpdateQc;
                if ($datediff > 2)
                    $keteranganTambahanDp = "Diisi lebih dari H+2 dari tanggal perubahan status QC OK";
                else
                    $keteranganTambahanDp = "Diisi kurang dari H+2 dari tanggal perubahan status QC OK";
            }
        } else {
            $updateUserDp = $respondents->updated_temuan_dp_by_id;
        }

        if ($respondents->status_qc_id != $request->status_qc_id) {
            $date = date("Y-m-d H:i:s");
            Log_status_qc::insert([
                'respondent_id' => $respondent->id,
                'status_qc_id' => $request->status_qc_id,
                'created_at' => $date
            ]);

            Respondent::where('id', $respondent->id)->update([
                'ses_final_id' => $request->ses_final_id,
                'respname' => $request->respname,
                'usia' => $request->usia,
                'address' => $request->address,
                'kota_id' => $respondents->kota_id,
                'mobilephone' => $request->mobilephone,
                'email' => $request->email,
                'gender_id' => $respondents->gender_id,
                'pendidikan_id' => $respondents->pendidikan_id,
                'pekerjaan_id' => $respondents->pekerjaan_id,
                'is_valid_id' => $request->is_valid_id,
                'status_qc_id' => $request->status_qc_id,
                'keterangan_qc' => $request->keterangan_qc,
                'tanggal_update_qc' => $date,
                'id_user_qc' => session('user_id'),
                'callback' => $request->callback,
                'rekaman' => $request->rekaman,
                'cek_rekaman' => $request->cek_rekaman,
                'worksheet' => $request->worksheet,
                'updated_by_id' => session('user_id'),
                'evidence' => $nama_gambar,
                'kategori_honor_do' => ($request->kategori_honor_do) ? $request->kategori_honor_do : $respondent->kategori_honor_do,
                'keterangan_temuan_dp' => $request->keterangan_temuan_dp,
                'updated_temuan_dp_by_id' => $updateUserDp,
                'status_temuan_dp_id' => $request->status_temuan_dp_id,
                'keterangan_tambahan_temuan_dp' => isset($keteranganTambahanDp) ? $keteranganTambahanDp : $respondents->keterangan_tambahan_temuan_dp
            ]);
        } else {
            Respondent::where('id', $respondent->id)->update([
                'ses_final_id' => $request->ses_final_id,
                'respname' => $request->respname,
                'usia' => $request->usia,
                'address' => $request->address,
                'kota_id' => $respondents->kota_id,
                'mobilephone' => $request->mobilephone,
                'email' => $request->email,
                'gender_id' => $respondents->gender_id,
                'pendidikan_id' => $respondents->pendidikan_id,
                'pekerjaan_id' => $respondents->pekerjaan_id,
                'is_valid_id' => $request->is_valid_id,
                'status_qc_id' => $request->status_qc_id,
                'keterangan_qc' => $request->keterangan_qc,
                'callback' => $request->callback,
                'rekaman' => $request->rekaman,
                'cek_rekaman' => $request->cek_rekaman,
                'worksheet' => $request->worksheet,
                'updated_by_id' => session('user_id'),
                'evidence' => $nama_gambar,
                'kategori_honor_do' => ($request->kategori_honor_do) ? $request->kategori_honor_do : $respondent->kategori_honor_do,
                'keterangan_temuan_dp' => $request->keterangan_temuan_dp,
                'updated_temuan_dp_by_id' => $updateUserDp,
                'status_temuan_dp_id' => $request->status_temuan_dp_id,
                'keterangan_tambahan_temuan_dp' => isset($keteranganTambahanDp) ? $keteranganTambahanDp : $respondents->keterangan_tambahan_temuan_dp
            ]);
        }

        session(['link_from' => 'saving']);

        $url = explode("/", array_keys($request->session()->get('last_resp_param'))[0]);
        if (count($url) > 2) {
            $key = $url[count($url) - 1];
            $ext = explode("_", $key);

            $key = substr_replace($key, ".", strrpos($key, '_'));
            $key .= $ext[count($ext) - 1];

            return redirect('/projects/view_respondents/' . $key)->with('status', 'Data sudah diubah');
        } else {
            return redirect('/respondents/' . $respondent->id . '/edit')->with('status', 'Data sudah diubah');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Respondent  $respondent
     * @return \Illuminate\Http\Response
     */
    public function destroy(Respondent $respondent)
    {
        //
    }

    public function changeStatusPerbaikan(Request $request)
    {
        Respondent_gift::where('id', $request->respondent_id)->update([
            'status_perbaikan_id' => 1,
            'mobilephone' => $request->mobilephone,
            'e_wallet_kode' => $request->e_wallet_kode,
            'status_kepemilikan_id' => $request->status_kepemilikan_id,
            'pemilik_mobilephone' => $request->pemilik_mobilephone,
            'nomor_rekening' => $request->norek,
            'pemilik_rekening' => $request->pemilik_rekening,
            'kode_bank' => $request->kode_bank,
        ]);

        return redirect('/home');
    }

    public function deleteTmpRespondent()
    {
        // echo 'here';
        DB::table('tmp_respondents')->truncate();
    }
}
