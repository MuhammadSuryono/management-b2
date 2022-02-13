<?php

namespace App\Http\Controllers\Otentikasi;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Mail;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users=User::all(); $add_url=url('/users/create');
        return view('otentikasis.users.index', compact('users','add_url'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user=User::limit(1)->get();;
        return view('otentikasis.users.create', compact('user'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_login' => 'required|unique:users,user_login|max:20',
            'nama'=>'required|max:50',
            'email' => 'required|email|unique:users,email|max:50',
            'level' => 'required|lt:' . session('level'),
            'password' => 'required|min:6|max:20',
            'conf_password' => 'required_with:password|same:password',
            ]);
        
        User::create($request->except('conf_password'));
        return redirect('/users')->with('status','Data sudah disimpan') ;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */

    public function edit(User $user)
    {
        session([
            'current_role_user_id'=>$user->id,
            'current_role_user_login'=>$user->user_login
        ]);
        return view('otentikasis.users.edit',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {   
        if($user->user_login == session('user_login'))
        {
            $validatedData = $request->validate([
            'user_login' => 'required|unique:users,user_login,'. $user->id . ',id|max:20',
            'nama'=>'required|max:50',
            'email' => 'required|email|unique:users,email,'. $user->id . ',id|max:50',
            'level' => 'required|lte:' . session('level'),
            'password' => 'required|min:6|max:20',
            'conf_password' => 'required_with:password|same:password',
            ]); 
        } else {
            $validatedData = $request->validate([
            'user_login' => 'required|unique:users,user_login,'. $user->id . ',id|max:20',
            'nama'=> 'required|max:50',
            'email' => 'required|email|unique:users,email,'. $user->id . ',id|max:50',
            'level' => 'required|lt:' . session('level'),
            ]);
        }


        User::where('id',$user->id)->update([
            'user_login'=>$request->user_login,
            'nama'=>$request->nama,
            'email'=>$request->email,
            'level'=>$request->level,
        ]);
        return redirect('/users')->with('status','Data sudah diubah') ;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }

    public function delete($id)
    {
        User::destroy($id);
        return redirect('/users')->with('status', 'Data sudah dihapus');
    }

    public function my_profile() {
        $user = User::firstWhere('user_login', session('user_login'));
        return view('otentikasis.users.edit',compact('user'));
    }

    public function reset_password()
    {
        $users = User::where('level','<',session('level'))->get()->sortBy('user_login');
        return view('otentikasis.users.user_password_reset', compact('users'));
    }


    public function update_reset_password(Request $request)
    {
        if (count($request->available_user_id)>0)
        {
            foreach ( $request->available_user_id as $user_id)
            {
                User::where('id',$user_id)->update([
                    'password'=>'123456',
                ]);
                $user = User::firstWhere('id', $user_id);
                Mail::to($user->email)->queue(new SendMail($user));
            }
        }
        return redirect('/home')->with('status','Password sudah direset menjadi 123456');
    }

    public function ganti_password()
    {
        $user=User::firstWhere('id',session('user_id'));
        return view('otentikasis.users.ganti_password', compact('user'));
    }

    public function save_ganti_password(Request $request)
    {
        $validatedData = $request->validate([
            'current_password' => 'required|same:old_password',
            'new_password' => 'required|min:6|max:20',
            'conf_password' => 'required_with:password|same:new_password',
            ]); 

        User::where('id',session('user_id'))->update([
            'password'=>$request->new_password,
        ]);
        session(['password' => $request->new_password] );
        return redirect('/home')->with('status','Password sudah diubah');
    }
}
