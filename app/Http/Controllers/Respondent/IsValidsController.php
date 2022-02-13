<?php

namespace App\Http\Controllers\Respondent;

use App\Http\Controllers\Controller;
use App\IsValid;
use Illuminate\Http\Request;

class IsValidsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $is_valids = IsValid::all();
        $add_url = url('/is_valids/create');
        return view('respondents.is_valids.index', compact('is_valids', 'add_url'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $is_valid = IsValid::first();
        $title = 'Tambah Status Validasi';
        $create_edit = 'create';
        $action_url = url('/is_valids');
        $include_form = 'respondents.is_valids.form_is_valid';
        return view('crud.open_record', compact('is_valid', 'title', 'create_edit', 'action_url', 'include_form'));
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
            'is_valid' => 'required|unique:is_valids|max:25',
        ]);
        IsValid::create([
            'is_valid' => $request->is_valid,
        ]);
        return redirect('/is_valids')->with('status', 'Data sudah disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\IsValid  $is_valid
     * @return \Illuminate\Http\Response
     */
    public function show(IsValid $is_valid)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\IsValid  $is_valid
     * @return \Illuminate\Http\Response
     */
    public function edit(IsValid $is_valid)
    {
        $title = 'Edit Status Validasi';
        $create_edit = 'edit';
        $action_url = url('/is_valids') . '/' . $is_valid->id;
        $include_form = 'respondents.is_valids.form_is_valid';
        return view('crud.open_record', compact('is_valid', 'title', 'create_edit', 'action_url', 'include_form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\IsValid  $is_valid
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, IsValid $is_valid)
    {
        $validatedData = $request->validate([
            'is_valid' => 'required|unique:is_valids,is_valid,' . $is_valid->id . ',id|max:25',
        ]);
        IsValid::where('id', $is_valid->id)->update([
            'is_valid' => $request->is_valid,
        ]);
        return redirect('/is_valids')->with('status', 'Data sudah diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\IsValid  $is_valid
     * @return \Illuminate\Http\Response
     */
    public function destroy(IsValid $is_valid)
    {
        //
    }

    public function delete($id)
    {
        IsValid::destroy($id);
        return redirect('/is_valids')->with('status', 'Data sudah dihapus');
    }
}
