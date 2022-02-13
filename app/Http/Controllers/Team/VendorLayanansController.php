<?php

namespace App\Http\Controllers\Team;

use App\Http\Controllers\Controller;
use App\Team_bahasa;
use App\Team;
use App\Vendor;
use App\Vendor_layanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VendorLayanansController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($vendor_id)
    {
        // return $team_id;

        $vendor = Vendor::firstWhere('id', $vendor_id);

        $vendor_layanan = Vendor_layanan::where('vendor_id', $vendor_id)->get();
        $add_url = url('/vendor_layanan/create/' . $vendor_id);
        return view('teams.vendor_layanans.index', compact('vendor_layanan', 'vendor', 'add_url'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($vendor_id)
    {
        $vendor = Vendor::firstWhere('id', $vendor_id);
        $layanan = DB::select('SELECT distinct layanans.id, layanans.layanan FROM layanans 
        left join vendor_layanans on layanans.id = vendor_layanans.layanan_id
        where layanans.id not in
            (select layanan_id from vendor_layanans where vendor_layanans.vendor_id = ?)', [$vendor_id]);
        $vendor_layanan = Vendor_layanan::first();
        return view('teams.vendor_layanans.create', compact('vendor_layanan', 'vendor', 'layanan'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request;
        // dd('jere');
        $request->validate([
            'layanan_id' => 'required',
            'vendor_id' => 'required',
        ]);

        if (!$request->layanan_id) {
            return redirect('/vendor_layanan/' . $request->vendor_id)->with('status-fail', 'Gagal');
        }

        Vendor_layanan::create([
            'vendor_id' => $request->vendor_id,
            'layanan_id' => $request->layanan_id,
        ]);
        return redirect('/vendor_layanan/' . $request->vendor_id)->with('status', 'Saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Team_bahasa  $teamBahasa
     * @return \Illuminate\Http\Response
     */
    public function show(Team_bahasa $teamBahasa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Team_bahasa  $teamBahasa
     * @return \Illuminate\Http\Response
     */
    public function edit(Team_bahasa $team_bahasa)
    {
        // $team = Team::firstWhere('id', $team_bahasa->team_id);
        // $bahasas = Bahasa::all()->sortBy('bahasa');
        // return view('teams.team_bahasas.edit', compact('team_bahasa', 'team', 'bahasas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Team_bahasa  $teamBahasa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Team_bahasa $team_bahasa)
    {
        // Team_keahlian::where('id', $team_keahlian->id)->update([
        //     'team_id' => $request->team_id,
        //     'keahlian_id' => $request->bahasa_id,
        // ]);
        // return redirect('/team_keahlian/' . $request->team_id)->with('status', 'Saved');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Team_bahasa  $teamBahasa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Team_bahasa $teamBahasa)
    {
        //
    }

    public function delete(Vendor_layanan $vendorLayanan)
    {
        // return $vendorLayanan;
        Vendor_layanan::destroy($vendorLayanan->id);
        return redirect('/vendor_layanan/' . $vendorLayanan->vendor_id)->with('status', 'Deleted');
    }
}
