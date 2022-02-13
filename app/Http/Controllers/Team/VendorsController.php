<?php

namespace App\Http\Controllers\Team;

use App\Http\Controllers\Controller;
use App\Pendidikan;
use App\Vendor;
use Illuminate\Http\Request;

class VendorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vendors = Vendor::all();
        $add_url = url('/vendors/create');
        // $tot_pekerjaan_responden = 15;
        return view('teams.vendors.index', compact('vendors', 'add_url'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vendor = Vendor::first();

        $title = 'Tambah Vendor';
        $create_edit = 'create';
        $action_url = url('/vendors');
        $include_form = 'teams.vendors.form_vendor';
        return view('crud.open_record', compact('vendor', 'title', 'create_edit', 'action_url', 'include_form'));
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
            'nama_perusahaan' => 'required',
            'alamat' => 'required',
            'contact_person' => 'required',
            'no_telp_kantor' => 'required',
            'no_telp_personal' => 'required',
            'email' => 'required',
        ]);

        if ($_FILES) {
            $extension = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
            $nama_gambar = 'bnpwp-' . \Carbon\Carbon::now()->format('Y-m-dH:i:s')  . "." . $extension;
            $target_file = $_SERVER['DOCUMENT_ROOT'] . explode('/', $_SERVER['REQUEST_URI'])[1] . '/public/uploads/' . $nama_gambar;
            move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
        }

        Vendor::create([
            'nama_perusahaan' => $request->nama_perusahaan,
            'alamat' => $request->alamat,
            'contact_person' => $request->contact_person,
            'no_telp_kantor' => $request->no_telp_kantor,
            'no_telp_personal' => $request->no_telp_personal,
            'email' => $request->email,
            'website' => $request->website,
            'npwp' => $request->npwp,
            'bukti_npwp' => $nama_gambar,
            'created_at' => time(),
            'updated_at' => time(),

        ]);
        return redirect('/vendors')->with('status', 'Data sudah disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pendidikan  $pendidikan
     * @return \Illuminate\Http\Response
     */
    public function show(Vendor $vendor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pendidikan  $pendidikan
     * @return \Illuminate\Http\Response
     */
    public function edit(Vendor $vendor)
    {
        $title = 'Edit Vendor';
        $create_edit = 'edit';
        $action_url = url('/vendors') . '/' . $vendor->id;
        $include_form = 'teams.vendors.form_vendor';
        return view('crud.open_record', compact('vendor', 'title', 'create_edit', 'action_url', 'include_form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pendidikan  $pendidikan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vendor $vendor)
    {
        $validatedData = $request->validate([
            'nama_perusahaan' => 'required',
            'alamat' => 'required',
            'contact_person' => 'required',
            'no_telp_kantor' => 'required',
            'no_telp_personal' => 'required',
            'email' => 'required',
        ]);

        if ($_FILES) {
            $extension = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
            $nama_gambar = 'bnpwp-' . \Carbon\Carbon::now()->format('Y-m-dH:i:s')  . "." . $extension;
            $target_file = $_SERVER['DOCUMENT_ROOT'] . explode('/', $_SERVER['REQUEST_URI'])[1] . '/public/uploads/' . $nama_gambar;
            move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
        }

        Vendor::where('id', $vendor->id)->update([
            'nama_perusahaan' => $request->nama_perusahaan,
            'alamat' => $request->alamat,
            'contact_person' => $request->contact_person,
            'no_telp_kantor' => $request->no_telp_kantor,
            'no_telp_personal' => $request->no_telp_personal,
            'email' => $request->email,
            'website' => $request->website,
            'npwp' => $request->npwp,
            'bukti_npwp' => $nama_gambar,
            'updated_at' => time(),

        ]);
        return redirect('/vendors')->with('status', 'Data sudah diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pendidikan  $pendidikan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vendor $vendor)
    {
        //
    }

    public function delete($id)
    {
        Vendor::destroy($id);
        return redirect('/vendors')->with('status', 'Data sudah dihapus');
    }

    public function view(Request $request)
    {
        $file = $request->id;
        return response()->file(public_path('uploads/' . $file));
    }
}
