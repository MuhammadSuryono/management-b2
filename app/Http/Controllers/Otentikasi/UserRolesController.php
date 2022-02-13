<?php

namespace App\Http\Controllers\Otentikasi;
use App\Http\Controllers\Controller;
use App\User;
use App\User_role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserRolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_roles=User_role::where('user_id',session('current_role_user_id'))->get();
        $add_url=url('/user_roles/create/');
        return view('otentikasis.user_roles.index', compact('user_roles','add_url'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $user=User::firstWhere('id', session('current_role_user_id'));
        $roles = DB::select('SELECT distinct roles.id, roles.role FROM roles 
        left join user_roles on roles.id = user_roles.role_id
        where roles.id not in
            (select role_id from user_roles where user_roles.user_id = ?)', [session('current_role_user_id')] );
        return view('otentikasis.user_roles.add_role_list', compact('roles','user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (count($request->available_role_id)>0)
        {
            foreach ( $request->available_role_id as $new_role_id)
            {
                User_role::create([
                    'user_id' => $request->user_id,
                    'role_id' => $new_role_id,
                    'updated_by' => session('user_id'),
                ]);
            }
        }
        return redirect('/user_roles/') ->with('status','Saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User_role  $user_role
     * @return \Illuminate\Http\Response
     */
    public function show(User_role $user_role)
    {
        //
    }

    public function delete($id)
    {
        User_role::destroy($id);
        return redirect('/user_roles') ->with('status','Saved');
    }
}
