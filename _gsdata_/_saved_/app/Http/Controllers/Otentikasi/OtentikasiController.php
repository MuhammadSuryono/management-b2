<?php

namespace App\Http\Controllers\Otentikasi;
use App\Http\Controllers\Controller;
use App\Otentikasi;
use App\User_role;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\DB;
class OtentikasiController extends Controller
{
    public function login()
    {
        return view('otentikasis.login');
    }

    
    public function cek_login(Request $request) 
    {
        Session::put('logged_in',false);
        if (isset($request->user_login))
        {
            $logged_in = Otentikasi::where('user_login',$request->user_login)
            ->where('password',$request->password)
            ->first();
            if ($logged_in<> null)
            {
                session(['LAST_ACTIVITY'=>time(), 'logged_in'=>true,'user_id'=>$logged_in->id, 'nama'=>$logged_in->nama, 'user_login' => $logged_in->user_login, 
                'email' => $logged_in->email, 'level' => $logged_in->level,'password' => $request->password]);
                $acc_menus = User_role::selectRaw('distinct menus.id, menu')
                ->join('role_menus','user_roles.role_id','=', 'role_menus.role_id')
                ->join('menus','role_menus.menu_id','=', 'menus.id')
                ->where('user_roles.user_id',[session('user_id')])->get()->toArray() ;
                $ar_menus = array_column($acc_menus, 'menu', 'id');
                session(['accessible_menus'=> $ar_menus, 'link_from'=>'menu' ]);
                return redirect(url('/'));
            }
        } 
        return redirect('/login')->with('status','Login Failed');
        
    }

    public function logout() 
    {
        session(['logged_in'=>false]);
        return redirect(url('/login'));
    }

    public function email_reset_password()
    {
        return view('otentikasis.email_reset_password');
    }
    public function send_reset_password(Request $request)
    {
        if(isset($request->email))
        {
            $valid_user=Otentikasi::where('email',$request->email)->get();
            if (count($valid_user) > 0)
            {
                $token=$this->insertToken($valid_user->id);
                $xtoken = $this->base64url_encode($token);
                $url_str = url('/otentikasis/reset_password') .'/' . $xtoken;
                $link = '<a href="' . $url . '" class="w3-button w3-purple">Buat Password Baru</a>'; 
            }
        }
    }
    public function insertToken($userid)  {
		$token = substr(sha1(rand()), 0, 30);
		$date = date('Y-m-d');  
		
		$string = array(
			'token'=> $token,
			'userid'=>$userid,
		);
		$this->db->insert('tokens',$string);
		return $token . $userid;
	}
	public function base64url_encode($data) {   
	return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');   
	}   

	public function base64url_decode($data) {   
	return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));   
	}
}
