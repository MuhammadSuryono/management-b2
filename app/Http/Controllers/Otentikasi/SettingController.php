<?php

namespace App\Http\Controllers\Otentikasi;

use App\Http\Controllers\Controller;
use App\SettingRoute;

class SettingController extends Controller
{
    protected $request;

    public function __construct()
    {
        $this->request = request();
    }

    public function index_route()
    {
        $settings = SettingRoute::all();
        return view('otentikasis.setting.route', compact('settings'));
    }

    public function create_route()
    {
        SettingRoute::create($this->request->all());
        return redirect()->back()->with('status', 'Data berhasil ditambahkan');
    }

    public function update_route()
    {
        $setting = SettingRoute::find($this->request->id);
        $setting->update($this->request->all());
        return redirect()->back()->with('status', 'Data berhasil diubah');
    }

    public function delete_route($id)
    {
        $setting = SettingRoute::find($id);
        $setting->delete();
        return redirect()->back()->with('status', 'Data berhasil dihapus');
    }
}
