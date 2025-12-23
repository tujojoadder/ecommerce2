<?php

namespace App\Http\Controllers\User\Project;

use App\DataTables\ProjectDataTable;
use App\DataTables\StaffsDataTable;
use App\Helpers\Traits\DeleteLogTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectRequest;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    use DeleteLogTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(ProjectDataTable $dataTable)
    {
        $pageTitle = __('messages.project').' '.__('messages.list');
        return $dataTable->render('user.project.index', compact('pageTitle'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProjectRequest $request)
    {
        $data = new Project($request->all());
        $data->created_by = Auth::user()->username;
        $data->save();
        return response()->json();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Project::findOrFail($id);
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProjectRequest $request, string $id)
    {
        $data = Project::findOrFail($id);
        $data->client_id = $request->client_id;
        $data->project_name = $request->project_name;
        $data->updated_by = Auth::user()->username;
        $data->save();
        return response()->json();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        /**
         * For the delete log
         * 1. Model Name
         * 2. Row ID
         */
        $this->deleteLog(Project::class, $id);

        toast('Project Deleted Successfully!', 'error', 'top-right');
        return redirect()->back();
    }
}
