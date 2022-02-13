<?php

namespace App\Http\Controllers\ProjectResource;

use App\Http\Controllers\Controller;
use App\Task;
use App\Yes_no;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;


class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $tasks = Task::all();
        $tasks = DB::connection('mysql3')->table('project_plan_master')
            ->select('*')
            ->orderBy('nama_kegiatan', 'asc')
            ->get();
        $yes_nos = Yes_no::all();
        $add_url = url('/tasks/create');
        return view('project_resources.tasks.index', compact('tasks', 'yes_nos', 'add_url'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $task = DB::connection('mysql3')->table('project_plan_master')
            ->select('*')
            ->orderBy('nama_kegiatan', 'asc')
            ->first();
        $yes_nos = Yes_no::all();
        $title = 'Tambah Task';
        $create_edit = 'create';
        $action_url = url('/tasks');
        $include_form = 'project_resources.tasks.form_task';
        return view('crud.open_record', compact('task', 'yes_nos', 'title', 'create_edit', 'action_url', 'include_form'));
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
            'nama_kegiatan' => 'required|max:100'
        ]);
        DB::connection('mysql3')->table('project_plan_master')->insert([
            'nama_kegiatan' => $request->nama_kegiatan,
            'has_presence' => $request->has_presence
        ]);
        return redirect('/tasks')->with('status', 'Data sudah disimpan');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task, Request $request)
    {
        $id = explode('/', $request->path())[1];
        $task = DB::connection('mysql3')->table('project_plan_master')
            ->select('*')
            ->where('id_pp_master', $id)
            ->first();
        $yes_nos = Yes_no::all();
        $title = 'Edit Task';
        $create_edit = 'edit';
        $action_url = url('/tasks') . '/' . $task->id_pp_master;
        $include_form = 'project_resources.tasks.form_task';
        return view('crud.open_record', compact('task', 'yes_nos', 'title', 'create_edit', 'action_url', 'include_form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        $validatedData = $request->validate([
            'nama_kegiatan' => 'required|max:100',
        ]);
        $id = explode('/', $request->path())[1];
        $task = DB::connection('mysql3')->table('project_plan_master')
            ->where('id_pp_master', $id)->update([
                'nama_kegiatan' => $request->nama_kegiatan,
                'has_presence' => $request->has_presence
            ]);
        return redirect('/tasks')->with('status', 'Data sudah diubah');
    }

    public function delete($id)
    {
        $task = DB::connection('mysql3')->table('project_plan_master')->where('id_pp_master', $id)->delete();
        return redirect('/tasks')->with('status', 'Data sudah dihapus');
    }
}
