<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Project;
use App\Kota;
use App\Pembayaran_interviewer;
use App\Pembayaran_tl;
use App\Project_imported;
use App\Project_team;
use App\Respondent;
use App\Respondent_gift;
use App\Status_pembayaran;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

class RekapBudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $projectstest = Respondent::select("respondent_gifts.*", 'project_honor_gifts.honor_gift', 'respondents.project_id')
            ->join('respondent_gifts', 'respondent_gifts.respondent_id', '=', 'respondents.id')
            ->join('project_kotas', 'project_kotas.kota_id', '=', 'respondents.kota_id')
            ->join('project_honor_gifts', 'project_honor_gifts.project_kota_id', '=', 'project_kotas.id')
            // ->groupBy('respondents.project_id')
            // ->distinct()
            ->get();


        $arr_project = [];
        $projects = Project::all();
        foreach ($projects as $p) {
            $total_gift = Respondent::select(DB::raw('SUM(project_honor_gifts.honor_gift)'))
                ->join('project_kotas', function ($join) use ($p) {
                    $join->on('respondents.kota_id', '=', 'project_kotas.kota_id')
                        ->where('project_kotas.project_id', '=', $p->id);
                })
                ->join('project_honor_gifts', 'project_honor_gifts.project_kota_id', '=', 'project_kotas.id')
                ->where('respondents.project_id', $p->id)->sum('project_honor_gifts.honor_gift');

            $total_honor_interviewer = DB::table('respondents')->select(DB::raw('SUM(project_honors.honor)'))
                ->join('project_kotas', function ($join) use ($p) {
                    $join->on('respondents.kota_id', '=', 'project_kotas.kota_id')
                        ->where('project_kotas.project_id', '=', $p->id);
                })
                ->join('project_honors', function ($join) use ($p) {
                    $join->on('project_kotas.id', '=', 'project_honors.project_kota_id')
                        ->where(DB::raw('lower(respondents.kategori_honor)'), '=', DB::raw('lower(project_honors.nama_honor)'));
                })
                ->where('respondents.project_id', '=', $p->id)
                ->sum('project_honors.honor');

            $total_honor_tl = Project_team::select('*')
                ->join('teams', 'teams.id', '=', 'project_teams.team_id')
                ->join('project_jabatans', 'project_jabatans.id', '=', 'project_teams.project_jabatan_id')
                ->join('jabatans', 'jabatans.id', '=', 'project_jabatans.jabatan_id')
                ->join('kotas', 'kotas.id', '=', 'teams.kota_id')
                ->join('project_kotas', 'project_kotas.id', '=', 'project_jabatans.project_kota_id')
                ->where('project_kotas.project_id', '=', $p->id)
                ->sum('project_teams.gaji');

            // if ($p->id == 33) {
            //     $total_gift = Respondent::select('respondents.id', 'project_honor_gifts.honor_gift')
            //         ->join('project_kotas', function ($join) use ($p) {
            //             $join->on('respondents.kota_id', '=', 'project_kotas.kota_id')
            //                 ->where('project_kotas.project_id', '=', $p->id);
            //         })
            //         ->join('project_honor_gifts', 'project_honor_gifts.project_kota_id', '=', 'project_kotas.id')
            //         ->where('respondents.project_id', $p->id)->groupBy('respondents.id')->get();
            //     dd($total_gift);
            //     var_dump($total_gift);
            //     var_dump($total_honor_interviewer);
            //     var_dump($total_honor_tl);
            // }

            $total = $total_gift + $total_honor_interviewer + $total_honor_tl;

            // -------------------------

            $total_gift_dipakai = Respondent::select(DB::raw('SUM(project_honor_gifts.honor_gift)'))
                ->join('respondent_gifts', 'respondent_gifts.respondent_id', '=', 'respondents.id')
                ->join('project_kotas', function ($join) use ($p) {
                    $join->on('respondents.kota_id', '=', 'project_kotas.kota_id')
                        ->where('project_kotas.project_id', '=', $p->id);
                })
                ->join('project_honor_gifts', 'project_honor_gifts.project_kota_id', '=', 'project_kotas.id')
                ->where('respondents.project_id', $p->id)
                ->where('respondent_gifts.status_pembayaran_id', 3)
                ->sum('project_honor_gifts.honor_gift');

            $total_honor_interviewer_dipakai = Pembayaran_interviewer::select('*')->where('project_id', '=', $p->id)->where('status_pembayaran_id', 3)->sum('total');

            $total_honor_tl_dipakai = Pembayaran_tl::select('*')->where('project_id', '=', $p->id)->where('status_pembayaran_id', 3)->sum('total');

            $total_dipakai = $total_gift_dipakai + $total_honor_interviewer_dipakai + $total_honor_tl_dipakai;

            $temp = [
                'nama_project' => $p->nama,
                'total' => $total,
                'total_dipakai' => $total_dipakai,
                'total_belum_dipakai' => $total - $total_dipakai
            ];
            $arr_project[$p->id] = $temp;
        }
        // $projects = Project::select(DB::raw('SUM(project_honor_gifts.honor_gift)'), DB::raw('COUNT(respondents.id)'), 'projects.nama', 'projects.id')
        //     ->join('respondents', 'respondents.project_id', '=', 'projects.id')
        //     ->join('project_kotas as a', 'a.kota_id', '=', 'respondents.kota_id')
        //     ->join('project_kotas as b', 'b.project_id', '=', 'projects.id')
        //     ->join('project_honor_gifts', 'project_honor_gifts.project_kota_id', '=', 'a.id')
        //     ->groupBy('projects.id')
        //     ->get();
        // dd($projects);

        // $projects = Respondent::select(DB::raw("SUM(project_honor_gifts.honor_gift) as total"), 'projects.nama', 'status_pembayarans.id as status_id')
        //     ->join('respondent_gifts', 'respondent_gifts.respondent_id', '=', 'respondents.id')
        //     ->join('project_kotas', 'project_kotas.kota_id', '=', 'respondents.kota_id')
        //     ->join('project_honor_gifts', 'project_honor_gifts.project_kota_id', '=', 'project_kotas.id')
        //     ->join('projects', 'projects.id', '=', 'respondents.project_id')
        //     ->join('status_pembayarans', 'status_pembayarans.id', '=', 'respondent_gifts.status_pembayaran_id')
        //     ->groupBy('respondents.project_id')
        //     ->groupBy('respondent_gifts.status_pembayaran_id')
        //     ->get();

        // $arr = [];
        // $namaProject = '';
        // $totalBelumDibayar = 0;
        // $totalSudahDiajukan = 0;
        // $totalSudahDibayar = 0;
        // $totalGagalDibayar = 0;

        // foreach ($projects as $item) {
        //     if ($namaProject != $item->nama) {
        //         if ($namaProject) {
        //             $data[$namaProject] = [
        //                 'nama_project' => $namaProject,
        //                 'total_belum_dibayar' => $totalBelumDibayar,
        //                 'total_sudah_diajukan' => $totalSudahDiajukan,
        //                 'total_sudah_dibayar' => $totalSudahDibayar,
        //                 'total_gagal_dibayar' => $totalGagalDibayar,
        //                 'total' => $totalBelumDibayar + $totalSudahDiajukan + $totalSudahDibayar + $totalGagalDibayar,
        //             ];
        //         }
        //         $namaProject = $item->nama;
        //         $totalBelumDibayar = 0;
        //         $totalSudahDiajukan = 0;
        //         $totalSudahDibayar = 0;
        //         $totalGagalDibayar = 0;
        //     }
        //     if ($item->status_id == 1) {
        //         $totalBelumDibayar = $item->total;
        //     }
        //     if ($item->status_id == 2) {
        //         $totalSudahDiajukan = $item->total;
        //     }
        //     if ($item->status_id == 3) {
        //         $totalSudahDibayar = $item->total;
        //     }
        //     if ($item->status_id == 4) {
        //         $totalGagalDibayar = $item->total;
        //     }
        // }

        // $data[$namaProject] = [
        //     'nama_project' => $namaProject,
        //     'total_belum_dibayar' => $totalBelumDibayar,
        //     'total_sudah_diajukan' => $totalSudahDiajukan,
        //     'total_sudah_dibayar' => $totalSudahDibayar,
        //     'total_gagal_dibayar' => $totalGagalDibayar,
        //     'total' => $totalBelumDibayar + $totalSudahDiajukan + $totalSudahDibayar + $totalGagalDibayar,
        // ];

        return view('finances.rekap_gift.index', compact('arr_project', 'projects'));
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
                'keterangan_pembayaran' => $request->ket_pembayaran,
                'tanggal_update_pembayaran' =>  Carbon::now()
            ]);
        } else if ($request->nextStatus == 3) {
            $insert = Respondent_gift::where('id', $request->id)->update([
                'status_pembayaran_id' => $request->nextStatus,
                // 'success_or_fail_paid' => $request->status_bayar,
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

    private function in_array_r($needle, $haystack, $strict = false)
    {
        foreach ($haystack as $key => $item) {
            if (($strict ? $key === $needle : $key == $needle) || (is_array($key) && in_array_r($needle, $key, $strict))) {
                return true;
            }
        }

        return false;
    }
}
