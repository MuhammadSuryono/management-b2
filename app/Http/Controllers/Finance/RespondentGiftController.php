<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Project\ProjectsController;
use App\Kota;
use App\Log_insert_bpu;
use App\Project_imported;
use App\Respondent;
use App\Respondent_gift;
use App\Status_pembayaran;
use App\Project;
use App\Project_budget_integration;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

class RespondentGiftController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tanggalPengajuan = [];
        $tanggalPembayaran = [];
        if ($request->project_imported_id != 'all' && $request->project_imported_id) {
            $project_importeds_name = Project_imported::where('id', $request->project_imported_id)->first();
            $projects = Project::where('nama', $project_importeds_name->project_imported)->first();

            $project_importeds = Project_imported::all()->sortBy('project_imported');
            $kotas = Respondent::join('kotas', 'respondents.kota_id', '=', 'kotas.id')->select('kotas.*')->where('project_imported_id', '=', $request->project_imported_id)->orderBy('kotas.kota', 'ASC')->distinct()->get();
            // $statusPembayaran = Respondent::join('respondent_gifts', 'respondent_gifts.respondent_id', '=', 'respondents.id')
            //     ->join('status_pembayarans', 'respondent_gifts.status_pembayaran_id', '=', 'status_pembayarans.id')
            //     ->select('status_pembayarans.*')
            //     ->where('project_imported_id', '=', $request->project_imported_id)
            //     ->orderBy('status_pembayarans.keterangan_pembayaran', 'ASC')
            //     ->distinct()->get();

            // $arrTanggal = [];
            // if (isset($projects->id)) {
            //     $checkTanggal = Log_insert_bpu::where('project_id', $projects->id)->get();
            //     foreach ($checkTanggal as $item) {
            //         array_push($arrTanggal, $item->tanggal_pengajuan);
            //     }
            // }

            $tanggalPengajuan = Respondent_gift::select('respondent_gifts.tanggal_pengajuan')
                ->join('respondents', 'respondents.id', '=', 'respondent_gifts.respondent_id')
                ->when(isset($projects->id), function ($query) use ($projects) {
                    return $query->where('respondents.project_id', $projects->id);
                })
                ->whereNotNull('respondent_gifts.tanggal_pengajuan')
                // ->whereNotIn('respondent_gifts.tanggal_pengajuan', $arrTanggal)
                ->groupBy('respondent_gifts.tanggal_pengajuan')
                ->get();

            $tanggalPembayaran = Log_insert_bpu::where('status_pembayaran_id', 2)->get();
        } else {
            $project_importeds = Project_imported::all()->sortBy('project_imported');
            $kotas = Kota::all()->sortBy('kota');
            // $statusPembayaran = Status_pembayaran::all()->sortBy('id');
        }

        if (session('link_from') == 'saving') {
            $params = session('last_resp_param');
        } else {
            $params = $request->except('_token');
            Session::put('last_resp_param', $params);
        }

        if (isset($params['status_pembayaran_id'])) {
            $statusPembayaran = Status_pembayaran::where('id', $params['status_pembayaran_id'])->first();
        } else {
            $statusPembayaran = '';
        }

        $respondents = Respondent::filter($params)
            ->select('respondent_gifts.*', 'respondents.respname', 'respondents.kota_id', 'respondents.email', 'respondents.project_id', 'respondents.kategori_gift')
            ->join('respondent_gifts', 'respondent_gifts.respondent_id', '=', 'respondents.id')
            ->leftJoin('status_pembayarans', 'status_pembayarans.id', '=', 'respondent_gifts.status_pembayaran_id')
            ->where(function ($query) use ($params) {
                $query->when(isset($params['status_pembayaran_id']) && trim($params['status_pembayaran_id']) !== 'all', function ($query2) use ($params) {
                    $query2->where('respondent_gifts.status_pembayaran_id', '=', trim($params['status_pembayaran_id']));
                });
                $query->when(isset($params['tanggal_mulai_pengajuan']) && isset($params['tanggal_selesai_pengajuan']), function ($query2) use ($params) {
                    $query2->whereBetween('respondent_gifts.tanggal_pengajuan', [$params['tanggal_mulai_pengajuan'],  $params['tanggal_selesai_pengajuan']]);
                });
                $query->when(isset($params['tanggal_mulai_pembayaran']) && isset($params['tanggal_selesai_pembayaran']), function ($query2) use ($params) {
                    $query2->whereBetween('respondent_gifts.tanggal_pembayaran', [$params['tanggal_mulai_pembayaran'],  $params['tanggal_selesai_pembayaran']]);
                });
            })
            // ->whereIn('status_qc_id', [5, 10])
            ->orderBy('respondents.respname', 'ASC')->get();
        // dd($project_importeds);
        return view('finances.respondent_gift.index', compact('project_importeds', 'respondents', 'kotas', 'statusPembayaran', 'tanggalPengajuan', 'tanggalPembayaran'));
    }

    public function rtpGift(Request $request)
    {

        if ($request->project_imported_id != 'all' && $request->project_imported_id) {
            $project_importeds = Project_imported::all()->sortBy('project_imported');
            $kotas = Respondent::join('kotas', 'respondents.kota_id', '=', 'kotas.id')->select('kotas.*')->where('project_imported_id', '=', $request->project_imported_id)->orderBy('kotas.kota', 'ASC')->distinct()->get();
        } else {
            $project_importeds = Project_imported::all()->sortBy('project_imported');
            $kotas = Kota::all()->sortBy('kota');
        }

        if (session('link_from') == 'saving') {
            $params = session('last_resp_param');
        } else {
            $params = $request->except('_token');
            Session::put('last_resp_param', $params);
        }

        $respondents = Respondent_gift::filter($params)->where('status', 0)->orderBy('respname', 'ASC')->get();
        // $add_url = url('/menus/create');
        return view('finances.respondent_gift.pengajuan_gift', compact('project_importeds', 'respondents', 'kotas'));
    }

    public function changeStatus(Request $request)
    {
        if ($request->nextStatus == 2) {
            $insert = Respondent_gift::where('id', $request->id)->update([
                'status_pembayaran_id' => $request->nextStatus,
                // 'success_or_fail_paid' => $request->status_bayar,
                'tanggal_pengajuan' => date('Y-m-d'),
                'pembayaran_via' => $request->pembayaran_via,
                'tanggal_update_pembayaran' =>  Carbon::now()
            ]);
        } else if ($request->nextStatus == 3) {
            $insert = Respondent_gift::where('id', $request->id)->update([
                'status_pembayaran_id' => $request->nextStatus,
                // 'success_or_fail_paid' => $request->status_bayar,
                'total_aktual' => $request->total_aktual,
                'tanggal_pembayaran' => date('Y-m-d'),
                'keterangan_pembayaran' => $request->ket_pembayaran,
                'tanggal_update_pembayaran' =>  Carbon::now()
            ]);
        } else {
            $insert = Respondent_gift::where('id', $request->id)->update([
                'status_pembayaran_id' => $request->nextStatus,
                // 'success_or_fail_paid' => $request->status_bayar,
                'keterangan_pembayaran' => $request->ket_pembayaran,
                'tanggal_update_pembayaran' =>  Carbon::now()
            ]);
        }

        $params = explode("?", $request->link);
        // dd($params);
        if ($insert) {
            return redirect('/respondent_gift?' . $params[1])->with('status', 'Status Berhasil Diubah');
        } else {
            return redirect('/respondent_gift?' . $params[1])->with('status-fail', 'Status Gagal Diubah');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $menu = Menu::first();
        $title = 'Tambah Menu';
        $create_edit = 'create';
        $action_url = url('/menus');
        $include_form = 'otentikasis.menus.form_menu';
        return view('crud.open_record', compact('menu', 'title', 'create_edit', 'action_url', 'include_form'));
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
            'menu' =>  'required|unique:menus|max:60',
        ]);

        Menu::create($request->all());
        return redirect('/menus')->with('status', 'Data sudah disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function show(Menu $menu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(Menu $menu)
    {
        $title = 'Edit Menu';
        $create_edit = 'edit';
        $action_url = url('/menus') . '/' . $menu->id;
        $include_form = 'otentikasis.menus.form_menu';
        return view('crud.open_record', compact('menu', 'title', 'create_edit', 'action_url', 'include_form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Menu $menu)
    {
        $validatedData = $request->validate([
            'menu' => 'required|unique:menus,menu,' . $menu->id . ',id|max:60',
        ]);
        Menu::where('id', $menu->id)->update([
            'menu' => $request->menu,
        ]);
        return redirect('/menus')->with('status', 'Data sudah diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu)
    {
        //
    }

    public function delete($id)
    {
        Menu::destroy($id);
        return redirect('/menus')->with('status', 'Data sudah dihapus');
    }

    public function getDataVoid(Request $request)
    {
        $respondents_fail_paid = Respondent::select('respondent_gifts.*', 'respondents.respname', 'respondents.kota_id', 'respondents.project_id', 'respondents.kategori_gift')
            ->join('respondent_gifts', 'respondent_gifts.respondent_id', '=', 'respondents.id')
            ->where('respondent_gifts.status_pembayaran_id', 4)
            ->where('respondents.project_id', $request->id)
            ->get();

        $data = "";
        foreach ($respondents_fail_paid as $rfp) :
            $data .= "
                <tr>
                    <td> " . (isset($rfp->respname) ? $rfp->respname : '-') . "</td>
                    <td> " . (isset($rfp->project->nama) ? $rfp->project->nama : '-') . "</td>
                    <td> " . (isset($rfp->kota->kota) ? $rfp->kota->kota : '-') . "</td>
                    <td> " . (isset($rfp->keterangan_pembayaran) ? $rfp->keterangan_pembayaran : '-') . "</td>
                    <td> " . (($rfp->status_perbaikan_id == 1) ? 'Sudah di perbaiki' : 'Belum di perbaiki') . " </td>
                    <td>
                    ";
            if ($rfp->status_perbaikan_id != 1) :
                $data .= "
                            <span data-toggle='modal' data-target='#konfirmasiModal'>
                                <button class='btn btn-sm btn-primary btn-konfirmasi' data-toggle='tooltip' data-placement='bottom' title='Ubah status perbaikan' data-id='$rfp->id' data-mobilephone='$rfp->mobilephone' data-norek='$rfp->nomor_rekening' data-pemilik_rekening='$rfp->pemilik_rekening' data-wallet='$rfp->e_wallet_kode' data-bank='$rfp->kode_bank' data-kepemilikan='$rfp->status_kepemilikan_id' data-pemilik_mobilephone='$rfp->pemilik_mobilephone'> <i class='fa fa-chevron-right'></i></button>
                            </span>";
            endif;

            $data .= "</td></tr>";
        endforeach;
        echo $data;
    }

    public function insertBpu(Request $request)
    {
        $total = 0;

        $project_importeds_name = Project_imported::where('id', $request->project_imported_id)->first();
        $project = Project::where('nama', $project_importeds_name->project_imported)->first();

        $budget =  DB::connection('mysql2')->table('pengajuan')->select('*')->where('nama', $project->nama)->first();

        if (!$budget) {
            $budget =  DB::connection('mysql2')->table('pengajuan')->select('*')->where('nama', $project->nama . ' - ' . $project->methodology)->first();
        }

        $respondent = Respondent::select('*')
            ->join('respondent_gifts', 'respondent_gifts.respondent_id', '=', 'respondents.id')
            ->where('respondent_gifts.tanggal_pengajuan', $request->tanggal_pengajuan)
            ->where('respondent_gifts.pembayaran_via', '!=', 'Transfer')
            ->get();

        // dd($respondent);

        foreach ($respondent as $item) {
            $gift = DB::table('project_kotas')->where('project_kotas.kota_id', $item->kota_id)->where('project_kotas.project_id', $item->project_id)->join('project_honor_gifts', 'project_honor_gifts.project_kota_id', '=', 'project_kotas.id')->where(DB::raw('lower(nama_honor_gift)'), '=', strtolower($item->kategori_gift))->first();

            if (isset($gift->honor_gift)) {
                $total += $gift->honor_gift;
            }
        }

        $itemBpu = Project_budget_integration::select('item_budget_id_pembayaran_gift')->where('project_id', $project->id)->first();

        $term = DB::connection('mysql2')->table('bpu')->where('no', $itemBpu->item_budget_id_pembayaran_gift)->where('waktu', $budget->waktu)->max('term');

        $term += 1;

        // $insertBpu = DB::connection('mysql2')->table('bpu')->insert([
        //     'no' => $itemBpu->item_budget_id_pembayaran_gift,
        //     'jumlah' => $total,
        //     'namapenerima' => "Responden",
        //     'status' => 'Belum Di Bayar',
        //     'persetujuan' => 'Belum Disetujui',
        //     'term' => $term + 1,
        //     'status_pengajuan_bpu' => 0,
        //     'waktu' => $budget->waktu,
        //     'tanggal_pengajuan' => $request->tanggal_pengajuan,
        //     'created_at' => date('Y-m-d')
        // ]);

        $respondent_transfer = Respondent::select('*')
            ->join('respondent_gifts', 'respondent_gifts.respondent_id', '=', 'respondents.id')
            ->where('respondent_gifts.tanggal_pengajuan', $request->tanggal_pengajuan)
            ->where('respondent_gifts.pembayaran_via', 'Transfer')
            ->get();

        foreach ($respondent_transfer as $item) {
            $gift = DB::table('project_kotas')->where('project_kotas.kota_id', $item->kota_id)->where('project_kotas.project_id', $item->project_id)->join('project_honor_gifts', 'project_honor_gifts.project_kota_id', '=', 'project_kotas.id')->where(DB::raw('lower(nama_honor_gift)'), '=', strtolower($item->kategori_gift))->first();

            if (isset($gift->honor_gift)) {
                $term += 1;
                $bank = DB::connection('mysql3')->table('bank')->select('*')->where('kode', $item->kode_bank)->first();

                // $insertBpu = DB::connection('mysql2')->table('bpu')->insert([
                //     'no' => $itemBpu->item_budget_id_pembayaran_gift,
                //     'jumlah' => $gift->honor_gift,
                //     'namapenerima' => $item->pemilik_rekening,
                //     'norek' => $item->nomor_rekening,
                //     'namabank' => $bank->nama,
                //     'status' => 'Belum Di Bayar',
                //     'persetujuan' => 'Belum Disetujui',
                //     'term' => $term + 1,
                //     'status_pengajuan_bpu' => 0,
                //     'waktu' => $budget->waktu,
                //     'tanggal_pengajuan' => $request->tanggal_pengajuan,
                //     'created_at' => date('Y-m-d H:i:s')
                // ]);
            }
        }

        $insert = Log_insert_bpu::insert([
            'project_id' => $project->id,
            'tanggal_pengajuan' => $request->tanggal_pengajuan,
            'status_pembayaran_id' => 2,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        return redirect(url()->previous())->with('status', 'Data BPU berhasil dibuat');
    }

    public function updateBpu(Request $request)
    {
        $total = 0;

        $checkData = Respondent_gift::where('tanggal_pengajuan', $request->tanggal_pengajuan)->where('status_pembayaran_id', '!=', 3)->count();

        if ($checkData > 0) {
            return redirect(url()->previous())->with('status-fail', 'Ada data pada tanggal pengajuan yang belum dibayar');
        }
        // dd($checkData);

        $project_importeds_name = Project_imported::where('id', $request->project_imported_id)->first();
        $project = Project::where('nama', $project_importeds_name->project_imported)->first();

        $dataInsert = Log_insert_bpu::where('project_id', $project->id)->where('tanggal_pengajuan', $request->tanggal_pengajuan)->first();

        $budget =  DB::connection('mysql2')->table('pengajuan')->select('*')->where('nama', $project->nama)->first();

        if (!$budget) {
            $budget =  DB::connection('mysql2')->table('pengajuan')->select('*')->where('nama', $project->nama . ' - ' . $project->methodology)->first();
        }

        $itemBpu = Project_budget_integration::select('item_budget_id_pembayaran_gift')->where('project_id', $project->id)->first();

        $insertBpu = DB::connection('mysql2')->table('bpu')->where('waktu', $budget->waktu)->where('no', $itemBpu->item_budget_id_pembayaran_gift)->whereDate('tanggal_pengajuan', $request->tanggal_pengajuan)->update([
            'status' => 'Telah Di Bayar'
        ]);

        $insert = Log_insert_bpu::where('id', $dataInsert->id)->update([
            'status_pembayaran_id' => 3
        ]);

        return redirect(url()->previous())->with('status', 'Data BPU berhasil diperbarui');
    }
}
