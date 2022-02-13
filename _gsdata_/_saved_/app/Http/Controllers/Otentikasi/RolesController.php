<?php

namespace App\Http\Controllers\Otentikasi;
use App\Http\Controllers\Controller;
use App\Role;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles=Role::all();
        $add_url=url('/roles/create');
        return view('otentikasis.roles.index', compact('roles','add_url'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $role=Role::limit(1)->get();;
        return view('otentikasis.roles.create', compact('role'));

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
            'role' =>  'required|unique:roles|max:60',
        ]);
        
        Role::create($request->all());
        return redirect('/roles')->with('status','Data sudah disimpan') ;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        session([
            'current_menu_role_id'=>$role->id,
            'current_menu_role'=>$role->role
        ]);
        return view('otentikasis.roles.edit',compact('role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $validatedData = $request->validate([
            'role' => 'required|unique:roles,role,'. $role->id . ',id|max:60',
        ]);
        Role::where('id',$role->id)->update([
            'user_id'=>$request->user_id,
            'role'=>$request->role,
        ]);
        return redirect('/roles')->with('status','Data sudah diubah') ;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        //
    }

    public function delete($id)
    {
        Role::destroy($id);
        return redirect('/roles')->with('status', 'Data sudah dihapus');
    }
}
