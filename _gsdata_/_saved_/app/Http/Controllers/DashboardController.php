<?php

namespace App\Http\Controllers;
use App\Respondent;
use App\Project;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   $total_respondent=Respondent::count();
        $total_project=Project::count();
        return view('dashboards/dashboard_gentelella',compact('total_respondent', 'total_project'));
    }
}
