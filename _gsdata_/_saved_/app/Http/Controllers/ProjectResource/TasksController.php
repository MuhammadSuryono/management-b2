<?php

namespace App\Http\Controllers\ProjectResource;
use App\Http\Controllers\Controller;
use App\Task;
use App\Yes_no;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks=Task::all();
        $yes_nos=Yes_no::all();
        $add_url=url('/tasks/create');
        return view('project_resources.tasks.index', compact('tasks','yes_nos','add_url'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $task=Task::limit(1)->get();;
        $yes_nos=Yes_no::all();
        return view('project_resources.tasks.create', compact('task','yes_nos'));
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
            'task' => 'required|unique:tasks|max:100',
        ]);
        Task::create([
            'task'=>$request->task,
            'has_n_id'=>$request->has_n_id,
            'has_blast_email_id'=>$request->has_blast_email_id,
            'has_absensi_id'=>$request->has_absensi_id,
            'updated_by_id'=>session('user_id')
        ]);
        return redirect('/tasks')->with('status','Data sudah disimpan') ;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        $yes_nos=Yes_no::all();
        return view('project_resources.tasks.edit',compact('task','yes_nos'));
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
            'task' => 'required|unique:tasks,task,'. $task->id . ',id|max:100',
        ]);
        Task::where('id',$task->id)->update([
            'user_id'=>$request->user_id,
            'task'=>$request->task,
            'has_n_id'=>$request->has_n_id,
            'has_blast_email_id'=>$request->has_blast_email_id,
            'has_absensi_id'=>$request->has_absensi_id,
            
        ]);
        return redirect('/tasks')->with('status','Data sudah diubah') ;
    }

    public function delete($id)
    {
        Task::destroy($id);
        return redirect('/tasks')->with('status', 'Data sudah dihapus');
    }
}
