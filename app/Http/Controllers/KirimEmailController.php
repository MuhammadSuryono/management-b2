<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Mail\KirimEmail;
use Illuminate\Support\Facades\Mail;

class KirimEmailController extends Controller
{
    public function index(){

        Mail::to("budionob@gmail.com")->send(new KirimEmail());

        return "Email telah dikirim";

    }

    public function email_reset_password(User $user)
    {
        
    }
}