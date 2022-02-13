<?php

namespace App\Http\Controllers\Respondent;

use App\Http\Controllers\Controller;
use App\Data_pengecekan;
use App\Log_status_qc;
use App\Respondent;
use App\Respondent_btf;
use App\Status_pengecekan;
use App\Project;
use Illuminate\Http\Request;

class DataPengecekansController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->project_id != 'all' && $request->project_id) {
            $dataPengecekan = Data_pengecekan::select('*')->join('respondents', 'respondents.id', '=', 'data_pengecekans.respondent_id')->where('respondents.project_id', $request->project_id)->get();
        } else {
            $dataPengecekan = Data_pengecekan::limit(0)->get();
        }
        $statusPengecekan = Status_pengecekan::all();

        $projects = Project::all()->sortBy('nama');
        // dd($statusPengecekan);
        $add_url = url('/form_pengecekan/create');
        return view('respondents.form_pengecekan.index', compact('dataPengecekan', 'add_url', 'statusPengecekan', 'projects'));
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
        // $data_pengecekan = Data_pengecekan::where('id', $request->id)->first();
        $respondents = Respondent::where('id', $request->id)->first();

        $date = date("Y-m-d H:i:s");
        if ($request->s4 == 1  || $request->s5 == 1  || $request->s7 == 1  || $request->s10 == 1  || $request->s11 == 1) {

            if ($respondents->status_qc_id != 9) {
                Respondent::where('id', $request->id)->update([
                    'status_qc_id' => 9,
                    'keterangan_qc' => null,
                    'tanggal_update_qc' => $date
                ]);

                Log_status_qc::insert([
                    'respondent_id' => $respondents->id,
                    'status_qc_id' => 9,
                    'created_at' => $date
                ]);
            } else {
                Respondent::where('id', $request->id)->update([
                    'status_qc_id' => 9,
                    'keterangan_qc' => null
                ]);
            }
        } else if ($request->s1 == 1 || $request->s2 == 1 || $request->s3 == 1 || $request->s6 == 1  || $request->s8 == 1  || $request->s9 == 1) {

            if ($respondents->status_qc_id != 4) {
                Respondent::where('id', $request->id)->update([
                    'status_qc_id' => 4,
                    'keterangan_qc' => 'BTF Karena Pengecekan Rekaman',
                    'tanggal_btf' => time(),
                    'tanggal_update_qc' => $date
                ]);

                Log_status_qc::insert([
                    'respondent_id' => $respondents->id,
                    'status_qc_id' => 4,
                    'created_at' => $date
                ]);
            } else {
                Respondent::where('id', $request->id)->update([
                    'status_qc_id' => 4,
                    'keterangan_qc' => 'BTF Karena Pengecekan Rekaman',
                    'tanggal_btf' => time()
                ]);
            }
        }

        $id = $request->id;
        $link = "/respondents/$id/edit";

        if ($request->id && $request->temuan) {
            $data_pengecekan = Data_pengecekan::create([
                'respondent_id' => $request->id,
                's1' => $request->s1,
                's2' => $request->s2,
                's3' => $request->s3,
                's4' => $request->s4,
                's5' => $request->s5,
                's6' => $request->s6,
                's7' => $request->s7,
                's8' => $request->s8,
                's9' => $request->s9,
                's10' => $request->s10,
                's11' => $request->s11,
                's12' => $request->s12,
                'temuan' => $request->temuan,
                'created_at' => time()
            ]);
        }
        if (isset($data_pengecekan))
            return redirect($link)->with('status', 'Form Pengecekan Rekaman berhasil disimpan');
        else
            return redirect($link)->with('status-fail', 'Form Pengecekan Rekaman gagal disimpan');
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
    public function edit(Request $request, Data_pengecekan $data_pengecekan, $id)
    {
        $data_pengecekan = Data_pengecekan::find($id);
        $status_pengecekan = Status_pengecekan::all();
        $respondent = Respondent::where('id', $data_pengecekan->respondent_id)->first();
        $title = 'Edit Form Pengecekan Rekaman';
        $create_edit = 'edit';
        $action_url = url('/form_pengecekan') . '/' . $data_pengecekan->id;
        $include_form = 'respondents.form_pengecekan.form_pengecekan';
        return view('crud.open_record', compact('respondent', 'data_pengecekan', 'status_pengecekan', 'title', 'create_edit', 'action_url', 'include_form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Kota  $kota
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Data_pengecekan $data_pengecekan)
    {
        // $validatedData = $request->validate([
        //     'status_pengecekan_id' =>  'required',
        //     'temuan' => 'required'
        // ]);

        $date = date("Y-m-d H:i:s");
        $data_pengecekan = Data_pengecekan::where('id', $request->id)->first();
        $respondents = Respondent::where('id', $data_pengecekan->respondent_id)->first();
        // dd($data_pengecekan->respondent_id);
        if ($request->s4 == 1  || $request->s5 == 1  || $request->s7 == 1  || $request->s10 == 1  || $request->s11 == 1) {

            if ($respondents->status_qc_id != 9) {
                Respondent::where('id', $data_pengecekan->respondent_id)->update([
                    'status_qc_id' => 9,
                    'keterangan_qc' => null,
                    'tanggal_update_qc' => $date
                ]);

                Log_status_qc::insert([
                    'respondent_id' => $respondents->id,
                    'status_qc_id' => 9,
                    'created_at' => $date
                ]);
            } else {
                Respondent::where('id', $data_pengecekan->respondent_id)->update([
                    'status_qc_id' => 9,
                    'keterangan_qc' => null
                ]);
            }
        } else if ($request->s1 == 1 || $request->s2 == 1 || $request->s3 == 1 || $request->s6 == 1  || $request->s8 == 1  || $request->s9 == 1) {

            if ($respondents->status_qc_id != 4) {
                Respondent::where('id', $data_pengecekan->respondent_id)->update([
                    'status_qc_id' => 4,
                    'keterangan_qc' => 'BTF Karena Pengecekan Rekaman',
                    'tanggal_btf' => time(),
                    'tanggal_update_qc' => $date
                ]);

                Log_status_qc::insert([
                    'respondent_id' => $respondents->id,
                    'status_qc_id' => 4,
                    'created_at' => $date
                ]);
            } else {
                Respondent::where('id', $data_pengecekan->respondent_id)->update([
                    'status_qc_id' => 4,
                    'keterangan_qc' => 'BTF Karena Pengecekan Rekaman',
                    'tanggal_btf' => time()
                ]);
            }

            $checkBtf = Respondent_btf::where('respondent_id', '=', $data_pengecekan->respondent_id)->count();
            if ($checkBtf == 0) {
                Respondent_btf::insert([
                    'respondent_id' => $data_pengecekan->respondent_id,
                    'created_at' => $date
                ]);
            }
        }

        Data_pengecekan::where('id', $request->id)->update([
            's1' => $request->s1,
            's2' => $request->s2,
            's3' => $request->s3,
            's4' => $request->s4,
            's5' => $request->s5,
            's6' => $request->s6,
            's7' => $request->s7,
            's8' => $request->s8,
            's9' => $request->s9,
            's10' => $request->s10,
            's11' => $request->s11,
            's12' => $request->s12,
            'temuan' => $request->temuan,
        ]);
        return redirect('/form_pengecekan')->with('status', 'Data sudah diubah');
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
        Data_pengecekan::destroy($id);
        return redirect('/form_pengecekan')->with('status', 'Data sudah dihapus');
    }

    public function view(Request $request)
    {
        $file = $request->file;
        return response()->file($_SERVER['DOCUMENT_ROOT'] . '/uploads/' . $file);
    }

    public function setOnNotif(Request $request)
    {
        $update = Data_pengecekan::join('respondents', 'respondents.id', '=', 'data_pengecekans.respondent_id')
            ->where('data_pengecekans.on_notif', '1')
            ->where('respondents.project_id', $request->project_id)
            ->update([
                'data_pengecekans.on_notif' => 0
            ]);

        echo $update;
    }
    public function getDataPengecekan(Request $request)
    {
        $data_pengecekan = Data_pengecekan::join('respondents', 'respondents.id', '=', 'data_pengecekans.respondent_id')
            ->where('respondents.project_id', $request->id)
            ->where('on_notif', 1)->get();

        $data = '';
        foreach ($data_pengecekan as $dp) :
            $result = '';
            $status = 0;
            if ($dp->s1 != 0) {
                $status = DB::table('status_pengecekans')->where('code', 's1')->first();
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
}
