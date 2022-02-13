<?php

namespace App\Http\Controllers\Otentikasi;
use App\Http\Controllers\Controller;
use App\Role;
use App\Role_menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleMenusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $role_menus=Role_menu::where('role_id',session('current_menu_role_id'))->get();
        $add_url=url('/role_menus/create/');
        return view('otentikasis.role_menus.index', compact('role_menus','add_url'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $role=Role::firstWhere('id', session('current_menu_role_id'));
        $menus = DB::select('SELECT distinct menus.id, menus.menu FROM menus 
        left join role_menus on menus.id = role_menus.menu_id
        where menus.id not in
            (select menu_id from role_menus where role_menus.role_id = ?)', [session('current_menu_role_id')] );
        return view('otentikasis.role_menus.add_menu_list', compact('menus','role'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (count($request->available_menu_id)>0)
        {
            foreach ( $request->available_menu_id as $new_menu_id)
            {
                Role_menu::create([
                    'role_id' => $request->role_id,
                    'menu_id' => $new_menu_id,
                    'updated_by' => session('role_id'),
                ]);
            }
        }
        return redirect('/role_menus/') ->with('status','Saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Role_menu  $role_menu
     * @return \Illuminate\Http\Response
     */
    public function show(Role_menu $role_menu)
    {
        //
    }

    public function delete($id)
    {
        Role_menu::destroy($id);
        return redirect('/role_menus') ->with('status','Saved');
    }
}
