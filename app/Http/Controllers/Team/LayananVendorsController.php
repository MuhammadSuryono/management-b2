<?php

namespace App\Http\Controllers\Team;

use App\Http\Controllers\Controller;
use App\Vendor_layanan;
use App\Team;
use App\Jabatan;
use App\Layanan;
use App\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LayananVendorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($layanan_id)
    {
        $layanan = Layanan::firstWhere('id', $layanan_id);
        $layanan_vendors = Vendor_layanan::where('layanan_id', $layanan_id)->get();
        $add_url = url('/layanan_vendors/create/' . $layanan_id);
        return view('teams.layanan_vendors.index', compact('layanan_vendors', 'layanan', 'add_url'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($layanan_id)
    {
        $layanan = Layanan::firstWhere('id', $layanan_id);
        $vendor = DB::select('SELECT distinct vendors.id, vendors.nama_perusahaan FROM vendors
        left join vendor_layanans on vendors.id = vendor_layanans.vendor_id
        where vendors.id not in
            (select vendor_id from vendor_layanans where vendor_layanans.layanan_id = ?) AND deleted_at is null', [$layanan_id]);
        $layanan_vendor = Vendor_layanan::first();
        return view('teams.layanan_vendors.create', compact('layanan_vendor', 'vendor', 'layanan'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Vendor_layanan::create([
            'layanan_id' => $request->layanan_id,
            'vendor_id' => $request->vendor_id,
        ]);
        return redirect('/layanan_vendors/' . $request->layanan_id)->with('status', 'Saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Team_jabatan  $vendorLayanan
     * @return \Illuminate\Http\Response
     */
    public function show(Team_jabatan $vendorLayanan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Team_jabatan  $vendorLayanan
     * @return \Illuminate\Http\Response
     */
    public function edit(Vendor_layanan $layanan_vendor)
    {
        $layanan = Layanan::firstWhere('id', $layanan_vendor->layanan_id);
        $vendor = Vendor::all()->sortBy('nama_perusahaan');
        return view('teams.layanan_vendors.edit', compact('layanan_vendor', 'vendor', 'layanan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Team_jabatan  $vendorLayanan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vendor_layanan $layanan_vendor)
    {
        Vendor_layanan::where('id', $layanan_vendor->id)->update([
            'layanan_id' => $request->layanan_id,
            'vendor_id' => $request->vendor_id,
        ]);
        return redirect('/layanan_vendors/' . $request->layanan_id)->with('status', 'Saved');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Team_jabatan  $vendorLayanan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vendor_layanan $vendorLayanan)
    {
        //
    }

    public function delete(Vendor_layanan $vendorLayanan)
    {
        Vendor_layanan::destroy($vendorLayanan->id);
        return redirect('/layanan_vendors/' . $vendorLayanan->layanan_id)->with('status', 'Deleted');
    }
}
