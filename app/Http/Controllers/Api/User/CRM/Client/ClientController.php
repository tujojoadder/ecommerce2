<?php

namespace App\Http\Controllers\Api\User\CRM\Client;

use App\DataTables\ClientDataTable;
use App\Helpers\FileManager;
use App\Helpers\Traits\DeleteLogTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\ClientRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Client;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

class ClientController extends Controller
{
    use DeleteLogTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = Client::where('deleted_at', null)->latest()->get();
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 404);
        }
    }

    public function getClientByUser($id)
    {
        try {
            $user = User::findOrFail($id);
            $data = Client::where('created_by', $user->username)->where('deleted_at', null)->latest()->get();
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Upload client image
            $file = new FileManager();
            if ($request->image) {
                if ($request->image != null) {
                    Storage::disk('profile')->delete($request->image);
                }
                $photo = $request->image;
                $file->folder('profile')->prefix('client-profile')->upload($photo) ? $image = $file->getName() : null;
            } else {
                $image = null;
            }
            // Upload client image

            $data = new Client($request->all());
            $data->image = $image; // set image name into staff image field
            $data->created_by = $request->created_by;
            $data->save();
            return response()->json(['message' => 'Client added successfully!', 'data' => $data], 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $data = Client::with('group')->findOrFail($id);
            $data['group_name'] = $data->group->name ?? '--';
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    /**
     * Display the client statements.
     */
    public function statements()
    {
        try {
            if (request()->client_id) {
                $data = Transaction::where('client_id', request()->client_id)->where('deleted_at', null)->latest()->get();
            } else {
                $data = Transaction::where('deleted_at', null)->latest()->get();
            }
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $data = Client::findOrFail($id);

            // Upload client image
            if ($request->hasFile('image')) {
                // Delete old image
                Storage::disk('profile')->delete($data->image);

                // Upload new image
                $file = new FileManager();
                $photo = $request->file('image');
                $image = $file->folder('profile')->prefix('client-profile')->upload($photo) ? $file->getName() : null;

                // Update image in the model
                $data->image = $image;
            }

            // Update other fields
            $data->update($request->all());
            $data->updated_by = $request->updated_by;
            $data->save();

            return response()->json(['message' => 'Client updated successfully!', 'data' => $data], 201);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            /**
             * For the delete log
             * 1. Model Name
             * 2. Row ID
             */
            $this->deleteLog(Client::class, $id);
            return response()->json(['message' => 'Client deleted Successfully!'], 202);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 404);
        }
    }

    public function updateImage(Request $request, $id)
    {
        try {
            $this->validate($request, [
                'image' => 'required'
            ], [
                'image.required' => 'Please select an image first.'
            ]);
            $data = Client::findOrFail($id);
            $file = new FileManager();
            if ($request->image) {
                if ($data->image != null) {
                    Storage::disk('profile')->delete($data->image);
                }
                $photo = $request->image;
                $file->folder('profile')->prefix('client-profile')->upload($photo) ? $data->image = $file->getName() : null;
            }
            $data->save();
            return response()->json(['message' => 'Client\'s profile updated successfully!', $data], 201);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }
}
