<?php

namespace App\Http\Controllers\User;

use App\DataTables\BrandDataTable;
use App\Helpers\FileManager;
use App\Helpers\Traits\DeleteLogTrait;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class BrandController extends Controller
{
    use DeleteLogTrait;
    public function index(BrandDataTable $dataTable)
    {
        $pageTitle = __('messages.brand');
        return $dataTable->render('user.brand.index', compact('pageTitle'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'image'     => ['required', 'mimes:jpg,png,jpeg,svg'],
        ]);

        $brand = new Brand();
        $file = new FileManager();

        // Store main image
        if ($request->hasFile('image')) {
            $photo = $request->file('image'); // <-- Correct way
            $file->folder('brand')->prefix('brand')->upload($photo) ? $image = $file->getName() : null;
        } else {
            $image = null;
        }

        $brand->image = $image;
        $brand->brand_name = $request->brand_name;
        $brand->save();

        return response()->json($brand);
    }



    public function edit(string $id)
    {
        $data = Brand::findOrFail($id);
        return response()->json($data);
    }

    public function update(Request $request, string $id)
    {
        try {
            DB::beginTransaction();

            $this->validate($request, [
                'image' => ['mimes:jpg,png,jpeg,svg'],
            ]);

            $data = Brand::findOrFail($id);
            $file = new FileManager();

            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($data->image && Storage::disk('brand')->exists($data->image)) {
                    Storage::disk('brand')->delete($data->image);
                }

                // Upload new image
                $photo = $request->file('image');
                $file->folder('brand')->prefix('brand')->upload($photo) ? $data->image = $file->getName() : null;
            }

            $data->brand_name = $request->brand_name;

            $data->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Brand updated successfully!',
                'data' => $data
            ]);

        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
                'errors' => ['image' => [$th->getMessage()]]
            ], 422);
        }
    }

    public function destroy(string $id)
    {
        /**
         * For the delete log
         * 1. Model Name
         * 2. Row ID
         */
        $this->deleteLog(Brand::class, $id);

        toast('Brand Deleted Successfully!', 'error', 'top-right');
        return redirect()->back();
    }
}
