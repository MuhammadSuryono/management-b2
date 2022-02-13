<?php

namespace App\Http\Controllers;

use App\Budget;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class BudgetsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $data = DB::connection('mysql2')->table('pengajuan')->selectRaw(DB::raw("SELECT * FROM pengajuan WHERE is_laravel = '1'"));
        // dd($data);

        $budget = Budget::where('jenis','B2')
                        ->where('is_laravel', '1')
                        ->where('status', 'Belum Di Ajukan')
                        ->orderBy('waktu', 'desc')
                        ->get();

        $ajukan = Budget::where('is_laravel', '1')
                        ->where('jenis','B2')
                        ->where('status', '!=', 'Belum Di Ajukan')
                        ->orderBy('waktu', 'desc')
                        ->get();

        return view('budgets.indexku', compact('budget', 'ajukan'));
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
     * @param  \App\Budget  $budget
     * @return \Illuminate\Http\Response
     */
    public function show(Budget $budget)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Budget  $budget
     * @return \Illuminate\Http\Response
     */
    public function edit(Budget $budget)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Budget  $budget
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Budget $budget)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Budget  $budget
     * @return \Illuminate\Http\Response
     */
    public function destroy(Budget $budget)
    {
        //
    }

    public function simpanLimit(Request $request)
    {
        Budget::find($request->idPengajuan)
                ->update([
                    'totalbudgetnow' => $request->limit
                ]);

        return redirect('/budgets')->with('sukses', 'Limit Pengajuan Berhasil Di Simpan');
    }

    public function divisi()
    {
        $budget = Budget::where('jenis','B2')
                        ->where('is_laravel', '1')
                        ->where('status', 'Belum Di Ajukan')
                        ->orderBy('waktu', 'desc')
                        ->get();

        $ajukan = Budget::where('is_laravel', '1')
                        ->where('jenis','B2')
                        ->where('status', '!=', 'Belum Di Ajukan')
                        ->orderBy('waktu', 'desc')
                        ->get();

        return view('budgets.divisi', compact('budget', 'ajukan'));
    }

    public function inputBudget(Budget $budget)
    {
        // GET DIVISI
        $divisi = new Budget();
        $divisi = $divisi->getDivisi();
        // AKHIR GET DIVISI

        // DATA TB SELESAI
        $selesai = new Budget();
        $budgetByDivisi = $selesai->getDataBudgetSelesai($budget->waktu);
        // AKHIR TB SELESAI

        $project = DB::table('projects')
                        ->where('kode_project', '=', $budget->kodeproject)
                        ->where('created_at', '=', $budget->waktu)
                        ->first();

        $kota = DB::select("select a.*, b.kota from project_kotas a left join kotas b on a.kota_id = b.id where a.project_id = '$project->id' and a.kode_project = '$project->kode_project'");

        return view('budgets.inputBudget', compact('project', 'kota', 'budget', 'divisi', 'budgetByDivisi'));
    }

    public function simpanBudgetByDivisi(Request $request)
    {
        // UPDATE TBL PENGAJUAN
        $budget = Budget::find($request->id);
        $totalbudget = (float)$budget->totalbudget + $request->total;

        if($totalbudget <= $budget->totalbudgetnow){
            $budget->totalbudget = $totalbudget;
            $budget->save();
            
            // GET NAMA PENGAJU
            $divisi = new Budget();
            $nama = $divisi->getDivisi();
            // AKHIR NAMA PENGAJU

            // CARI NO BERAPA PADA TABEL SELESAI
            $banyak = DB::connection('mysql2')->table('selesai')->select(DB::raw('max(no) as max'))
                            ->where('waktu', '=', $request->waktu)
                            ->first();
            $banyak = $banyak->max + 1;
            // AKHIR

            // INSERT DB SELESAI
            DB::connection('mysql2')->table('selesai')->insert([
                'no' => $banyak,
                'rincian' => $request->rincian,
                'kota' => $request->kota,
                'status' => $request->status,
                'penerima' => $request->penerima,
                'harga' => $request->harga,
                'quantity' => $request->quantity,
                'total' => $request->total,
                'pembayaran' => 'Belum Dibayar',
                'pengaju' => $nama->nama_user,
                'divisi' => $nama->divisi,
                'waktu' => $request->waktu,
                'divisi_budget' => $request->divisibudget,
                ]);
            // AKHIR

            return redirect("/budgets/inputBudget/$request->id")->with('sukses', 'Budget Berhasil Di Simpan');
        } else {
            return redirect("/budgets/inputBudget/$request->id")->with('gagal', 'Grand Total Budget Melebihi Limit Project');
        }
        
    }

    public function hapusBudgetDivisi($id, $waktu)
    {
        $return = Budget::where('waktu', $waktu)->first();
        $totalHapus = DB::connection('mysql2')->table('selesai')
                                                ->where('no', '=', $id)
                                                ->where('waktu', '=', $waktu)
                                                ->first();

        if((float)$return->totalbudget>0){
            $total = (float)$return->totalbudget - (float)$totalHapus->total;
            $return->totalbudget = $total;
            $return->save();
        }

        DB::connection('mysql2')->table('selesai')
                                ->where('no', '=', $id)
                                ->where('waktu', '=', $waktu)
                                ->delete();
        return redirect("/budgets/inputBudget/$return->noid")->with('hapus', 'Data Budget Telah Di Hapus');
    }

    public function editBudgetByDivisi(Request $request)
    {

        // UPDATE TBL PENGAJUAN
        $budget = Budget::find($request->idBudget);
        $totalbudget = (float)$budget->totalbudget - $request->totalSebelum;
        $totalbudget = $totalbudget + $request->totalEdit;

        if($totalbudget <= $budget->totalbudgetnow){
            $budget->totalbudget = $totalbudget;
            $budget->save();

            // UPDATE DB SELESAI
            DB::connection('mysql2')->table('selesai')
                                    ->where('no', $request->id)
                                    ->where('waktu', $request->waktu)
                                    ->update([
                                        'rincian' => $request->rincian,
                                        'kota' => $request->kota,
                                        'status' => $request->status,
                                        'penerima' => $request->penerima,
                                        'harga' => $request->hargaEdit,
                                        'quantity' => $request->quantityEdit,
                                        'total' => $request->totalEdit,
                                        ]);
            // AKHIR

            return redirect("/budgets/inputBudget/$request->idBudget")->with('edit', 'Budget Berhasil Di Ubah');
        } else {
            return redirect("/budgets/inputBudget/$request->idBudget")->with('gagal', 'Grand Total Budget Melebihi Limit Project');
        }
    }

    public function pengajuan()
    {
        // GET NAMA PENGAJU
        $divisi = new Budget();
        $nama = $divisi->getDivisi();
        // AKHIR NAMA PENGAJU

        $budget = Budget::where('jenis','B2')
                        ->where('is_laravel', '1')
                        ->where('pengaju', $nama->nama_user)
                        ->where('status', 'Belum Di Ajukan')
                        ->orderBy('waktu', 'desc')
                        ->get();
       
        $ajukan = Budget::where('is_laravel', '1')
                        ->where('jenis','B2')
                        ->where('pengaju', $nama->nama_user)
                        ->where('status', '!=', 'Belum Di Ajukan')
                        ->orderBy('waktu', 'desc')
                        ->get();
        return view('budgets.pengajuan', compact('budget', 'ajukan'));
    }

    public function pengajuanBudget($waktu)
    {
        $budget = new Budget();
        $limit = Budget::where('waktu', $waktu)->first();
        $selesai = $budget->getAllDataBudgetSelesai($waktu);
        $divisi = $budget->getAllDataBudgetSelesaiDiv($waktu);
        
        return view('budgets.pengajuanBudget', compact('selesai', 'divisi', 'limit'));
    }

    public function simpanPengajuan(Request $request)
    {
        $flight = Budget::find($request->noid);
        $flight->status = 'Pending';
        $flight->save();

        return redirect('budgets/pengajuan')->with('sukses', 'Budget Berhasil Di Ajukan');
    }

    public function persetujuan($noid)
    {
        $budget = new Budget();
        $limit = Budget::find($noid);
        $selesai = $budget->getAllDataBudgetSelesai($limit->waktu);
        $divisi = $budget->getAllDataBudgetSelesaiDiv($limit->waktu);
        
        return view('budgets.persetujuan', compact('selesai', 'divisi', 'limit'));
    }

    public function simpanPersetujuan(Request $request)
    {
        $flight = Budget::find($request->noid);
        $flight->status = 'Disetujui';
        $flight->save();

        return redirect('budgets')->with('sukses', 'Budget Berhasil Di Setujui');
    }

    public function print($waktu)
    {
        $budget = new Budget();
        $limit = Budget::where('waktu', $waktu)->first();
        $selesai = $budget->getAllDataBudgetSelesai($waktu);
        $divisi = $budget->getAllDataBudgetSelesaiDiv($waktu);
        
        return view('budgets.print', compact('selesai', 'divisi', 'limit'));
    }
}
