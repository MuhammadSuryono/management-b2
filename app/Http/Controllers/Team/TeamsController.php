<?php

namespace App\Http\Controllers\Team;

use App\Http\Controllers\Controller;
use App\Team;
use App\Gender;
use App\Helpers\GuzzleRequester;
use App\Kota;
use App\Pendidikan;
use App\Pekerjaan;
use App\User;
use App\Team_jabatan;
use App\Jabatan;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;


class TeamsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $teams = Team::all();
        $jabatan_teams = Team_jabatan::all();
        $jabatan_teams = DB::table('team_jabatans')
            ->join('jabatans', 'team_jabatans.jabatan_id', '=', 'jabatans.id')
            ->select('*')
            ->get();
        $add_url = url('/teams/create');
        return view('teams.teams.index', compact('teams', 'jabatan_teams', 'add_url'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $team = Team::first();
        $genders = Gender::all();
        $kotas = Kota::all();
        $pendidikans = Pendidikan::all();
        $pekerjaans = Pekerjaan::all();
        $users = User::all();
        $client = new GuzzleRequester();
        $client->request('GET', 'api/bank');
        $bank = $client->getBody()->data;
        $tgl_skr = date("Y-m-d");
        $title = 'Tambah Team';
        $create_edit = 'create';
        $action_url = url('/teams');
        $include_form = 'teams.teams.form_team';
        return view('crud.open_record', compact(
            'team',
            'genders',
            'kotas',
            'pendidikans',
            'pekerjaans',
            'users',
            'bank',
            'tgl_skr',
            'title',
            'create_edit',
            'action_url',
            'include_form'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //Validation
        $validatedData = $request->validate([
            'nama' => 'required|unique:teams|max:60',
            'gender_id' => 'required',
            'ktp' => 'required',
            'hp' => 'required|numeric',
            'email' => 'required|email|unique:teams',
            'alamat' => 'required',
            'kota_id' => 'required',
            'tgl_lahir' => 'required',
            'pendidikan_id' => 'required',
            'pekerjaan_id' => 'required',
            'tgl_registrasi' => 'required'
        ]);

        if ($_FILES) {
            if ($_FILES["file"]["name"]) {
                $extension = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
                $nama_gambar = 'br-' . \Carbon\Carbon::now()->format('Y-m-dH:i:s')  . "." . $extension;
                $target_file = $_SERVER['DOCUMENT_ROOT'] . explode('/', $_SERVER['REQUEST_URI'])[1] . '/public/uploads/' . $nama_gambar;
                move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
            }

            if ($_FILES["fileRateCard"]["name"]) {
                $extensionRc = pathinfo($_FILES["fileRateCard"]["name"], PATHINFO_EXTENSION);
                $nama_gambarRc = 'rc-' . \Carbon\Carbon::now()->format('Y-m-dH:i:s')  . "." . $extensionRc;
                $target_fileRc = $_SERVER['DOCUMENT_ROOT'] . explode('/', $_SERVER['REQUEST_URI'])[1] . '/public/uploads/' . $nama_gambarRc;
                move_uploaded_file($_FILES["fileRateCard"]["tmp_name"], $target_fileRc);
            }
        }
        Team::create([
            'user_id' => $request->user_id,
            'no_team' => Team::where('kota_id', $request->kota_id)->max('no_team') + 1,
            'nama' => $request->nama,
            'gender_id' => $request->gender_id,
            'ktp' => $request->ktp,
            'hp' => $request->hp,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'kota_id' => $request->kota_id,
            'tgl_lahir' => $request->tgl_lahir,
            'pekerjaan_id' => $request->pekerjaan_id,
            'pendidikan_id' => $request->pendidikan_id,
            'nomor_rekening' => $request->nomor_rekening,
            'kode_bank' => $request->kode_bank,
            'bukti_rekening' => ($nama_gambar) ? $nama_gambar : '',
            'rate_card' => ($nama_gambarRc)  ? $nama_gambarRc : '',
            'tgl_registrasi' => $request->tgl_registrasi,
            'updated_by_id' => session('user_id')

        ]);
        return redirect('/teams')->with('status', 'Data sudah disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Team  $team
     * @return Response
     */
    public function show(Team $team)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Team  $team
     * @return Response
     */
    public function edit(Team $team)
    {
        $genders = Gender::all();
        $kotas = Kota::all();
        $pendidikans = Pendidikan::all();
        $pekerjaans = Pekerjaan::all();
        $users = User::all();
        $client = new GuzzleRequester();
        $client->request('GET', 'api/bank');
        $bank = $client->getBody()->data;
        $title = 'Edit Team';
        $create_edit = 'edit';
        $action_url = url('/teams') . '/' . $team->id;
        $include_form = 'teams.teams.form_team';
        return view('crud.open_record', compact(
            'team',
            'genders',
            'kotas',
            'pendidikans',
            'pekerjaans',
            'users',
            'bank',
            'title',
            'create_edit',
            'action_url',
            'include_form'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  \App\Team  $team
     * @return Response
     */
    public function update(Request $request, Team $team)
    {
        $validatedData = $request->validate([
            'nama' => 'required|unique:teams,nama,' . $team->id . ',id|max:60',
            'gender_id' => 'required',
            'ktp' => 'required',
            'hp' => 'required|numeric',
            'email' => 'required|email|unique:teams,email,' . $team->id . ',id|max:60',
            'alamat' => 'required',
            'kota_id' => 'required',
            'tgl_lahir' => 'required',
            'pendidikan_id' => 'required',
            'pekerjaan_id' => 'required',
            'tgl_registrasi' => 'required',
        ]);
        $teams = Team::where('id', $team->id)->first();
        // dd($teams);
        $nama_gambar = $teams['bukti_rekening'];
        $nama_gambarRc = $teams['rate_card'];


        if ($_FILES) {
            if ($_FILES["file"]["name"] && $_FILES["file"]["name"] != "") {
                dd($_FILES);
                $extension = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
                $nama_gambar = 'br-' . \Carbon\Carbon::now()->format('Y-m-dH:i:s')  . "." . $extension;
                $target_file = $_SERVER['DOCUMENT_ROOT'] . explode('/', $_SERVER['REQUEST_URI'])[1] . '/public/uploads/' . $nama_gambar;
                move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
            }

            if ($_FILES["fileRateCard"]["name"]) {
                $extensionRc = pathinfo($_FILES["fileRateCard"]["name"], PATHINFO_EXTENSION);
                $nama_gambarRc = 'rc-' . \Carbon\Carbon::now()->format('Y-m-dH:i:s')  . "." . $extensionRc;
                $target_fileRc = $_SERVER['DOCUMENT_ROOT'] . explode('/', $_SERVER['REQUEST_URI'])[1] . '/public/uploads/' . $nama_gambarRc;
                move_uploaded_file($_FILES["fileRateCard"]["tmp_name"], $target_fileRc);
            }
        }

        Team::where('id', $team->id)->update([
            'user_id' => $request->user_id,
            'nama' => $request->nama,
            'gender_id' => $request->gender_id,
            'ktp' => $request->ktp,
            'hp' => $request->hp,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'kota_id' => $request->kota_id,
            'tgl_lahir' => $request->tgl_lahir,
            'pekerjaan_id' => $request->pekerjaan_id,
            'pendidikan_id' => $request->pendidikan_id,
            'nomor_rekening' => $request->nomor_rekening,
            'kode_bank' => $request->kode_bank,
            'bukti_rekening' => $nama_gambar,
            'rate_card' => $nama_gambarRc,
            'tgl_registrasi' => $request->tgl_registrasi,
            'updated_by_id' => session('user_id')

        ]);
        return redirect('/teams')->with('status', 'Data sudah diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Team  $team
     * @return Response
     */
    public function destroy(Team $team)
    {
        //
    }

    public function delete($id)
    {
        Team::destroy($id);
        return redirect('/teams')->with('status', 'Data sudah dihapus');
    }

    public function view(Request $request)
    {
        $file = $request->project;
        // return response()->file(url('uploads/' . $file));
        return response()->file(public_path('uploads/' . $file));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function add_new_vendor_page()
    {
        $team = Team::first();
        $genders = Gender::all();
        $kotas = Kota::all();
        $pendidikans = Pendidikan::all();
        $pekerjaans = Pekerjaan::all();
        $users = User::all();
        $client = new GuzzleRequester();
        $client->request('GET', 'api/bank');
        $bank = $client->getBody()->data;
        $tgl_skr = date("Y-m-d");
        $create_edit = 'create';
        $action_url = url('/vendor/personal/register');
        return view('teams.teams.register_vendor', compact(
            'team',
            'genders',
            'kotas',
            'pendidikans',
            'pekerjaans',
            'users',
            'bank',
            'tgl_skr',
            'create_edit',
            'action_url'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     * @throws ValidationException
     */
    public function store_team(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required|unique:teams|max:60',
            'gender_id' => 'required|integer',
            'ktp' => 'required|min:16|max:16',
            'hp' => 'required|min:9|max:13',
            'email' => 'required|email|unique:teams',
            'alamat' => 'required|min:10',
            'kota_id' => 'required|integer',
            'tgl_lahir' => 'required',
            'pendidikan_id' => 'required|integer',
            'pekerjaan_id' => 'required|integer',
            'tgl_registrasi' => 'required'
        ]);

        $requestAll = $request->all();
        $requestAll['no_team'] = Team::where('kota_id', $request->kota_id)->max('no_team') + 1;

        try {
            Team::create($requestAll);
            return redirect('/vendor/register')->with('success', 'Data registrasi berhasil disimpan');
        } catch (\Exception $e) {
            return redirect('/vendor/register')->with('error', 'Data gagal disimpan, dengan error: ' . $e->getMessage());
        }
    }
}
