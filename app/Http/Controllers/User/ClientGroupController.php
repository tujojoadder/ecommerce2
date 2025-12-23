<?php

namespace App\Http\Controllers\User;

use App\DataTables\ClientGroupDataTable;
use App\Helpers\Traits\DeleteLogTrait;
use App\Http\Controllers\Controller;
use App\Models\ClientGroup;
use Dotenv\Repository\RepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Psr\Http\Message\ResponseInterface;

use function Termwind\render;

class ClientGroupController extends Controller
{
    use DeleteLogTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(ClientGroupDataTable $dataTable)
    {
        $pageTitle = __('messages.client') . ' ' . __('messages.group');
        return $dataTable->render('user.client.group.index', compact('pageTitle'));
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
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $this->validate($request, [
                'name' => ['required', 'string'],
            ]);
            $data = new ClientGroup($request->all());
            $data->created_by = Auth::user()->username;
            $data->save();

            DB::commit();

            toast('Client Group Added Successfully!', 'success');
            return response()->json($data);
        } catch (\Throwable $th) {
            DB::rollBack();
            toastr()->error($th->getMessage());
            return redirect()->back();
        }
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
        $data = ClientGroup::findOrFail($id);
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            DB::beginTransaction();

            $this->validate($request, [
                'name' => ['required', 'string'],
            ]);
            $data = ClientGroup::findOrFail($id);
            $data->name = $request->name;
            $data->updated_by = Auth::user()->username;
            $data->save();

            DB::commit();

            return response()->json($data);
        } catch (\Throwable $th) {
            DB::rollBack();
            toastr()->error($th->getMessage());
            return redirect()->back();
        }
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
        $this->deleteLog(ClientGroup::class, $id);

        toast('Client Group Deleted Successfully!', 'error', 'top-right');
        return redirect()->back();
    }
}
