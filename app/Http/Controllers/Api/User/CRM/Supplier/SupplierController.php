<?php

namespace App\Http\Controllers\Api\User\CRM\Supplier;

use App\DataTables\PurchaseStatementsDataTable;
use App\DataTables\SupplierDataTable;
use App\Helpers\FileManager;
use App\Helpers\Traits\DeleteLogTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\SupplierRequest;
use App\Models\Supplier;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SupplierController extends Controller
{
    use DeleteLogTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = Supplier::where('deleted_at', null)->latest()->get();
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 404);
        }
    }

    public function getSupplierByUser($id)
    {
        try {
            $user = User::findOrFail($id);
            $data = Supplier::where('created_by', $user->username)->where('deleted_at', null)->latest()->get();
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
            $file = new FileManager();
            if ($request->image) {
                if ($request->image != null) {
                    Storage::disk('profile')->delete($request->image);
                }
                $photo = $request->image;
                $file->folder('profile')->prefix('supplier-profile')->upload($photo) ? $image = $file->getName() : null;
            } else {
                $image = null;
            }
            // Upload supplier image

            $data = new Supplier($request->all());
            $data->image = $image; // set image name into staff image field
            $data->created_by = $request->created_by;
            $data->save();
            return response()->json(['message' => 'Supplier added successfully!', 'data' => $data], 200);
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
            $data = Supplier::with('group')->findOrFail($id);
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
            if (request()->supplier_id) {
                $data = Transaction::where('supplier_id', request()->supplier_id)->where('deleted_at', null)->latest()->get();
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
            $data = Supplier::findOrFail($id);
            // Upload supplier image
            $file = new FileManager();
            if ($request->image) {
                if ($request->image != null) {
                    Storage::disk('profile')->delete($request->image);
                }
                $photo = $request->image;
                $file->folder('profile')->prefix('supplier-profile')->upload($photo) ? $image = $file->getName() : null;
            } else {
                $image = null;
            }
            // Upload supplier image

            $data->update($request->except('_token', '_method'));
            $data->image = $image; // set image name into staff image field
            $data->updated_by = $request->updated_by;
            $data->save();

            return response()->json(['message' => 'Supplier updated successfully!', 'data' => $data], 201);
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
            $this->deleteLog(Supplier::class, $id);
            return response()->json(['message' => 'Supplier deleted Successfully!'], 202);
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
            $data = Supplier::findOrFail($id);
            $file = new FileManager();
            if ($request->image) {
                if ($data->image != null) {
                    Storage::disk('profile')->delete($data->image);
                }
                $photo = $request->image;
                $file->folder('profile')->prefix('supplier-profile')->upload($photo) ? $data->image = $file->getName() : null;
            }
            $data->save();
            return response()->json(['message' => 'Supplier\'s profile updated successfully!', $data], 201);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }
}
