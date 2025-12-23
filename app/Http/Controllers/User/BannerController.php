<?php

namespace App\Http\Controllers\User;

use App\DataTables\BannerDataTable;
use App\DataTables\SliderDataTable;
use App\Helpers\FileManager;
use App\Helpers\Traits\DeleteLogTrait;
use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class BannerController extends Controller
{
    use DeleteLogTrait;
    public function index(BannerDataTable $dataTable)
    {
        $pageTitle = __('messages.banner');
        return $dataTable->render('user.banner.index', compact('pageTitle'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'image'     => ['required', 'mimes:jpg,png,jpeg,svg'],
        ]);

        $banner = new Banner();
        $file = new FileManager();

        // Store main image
        if ($request->image) {
            $photo = $request->image;
            $file->folder('banner')->prefix('banner')->upload($photo) ? $image = $file->getName() : null;
        } else {
            $image = null;
        }

        $banner->image = $image;
        $banner->save();

        toast('Banner Successfully Created!', 'success');
        return redirect()->route('user.slider.index');
    }



    public function edit(string $id)
    {
        $data = Banner::findOrFail($id);
        return response()->json($data);
    }

    public function update(Request $request, string $id)
    {
        try {
            DB::beginTransaction();

            $this->validate($request, [
                'image' => ['mimes:jpg,png,jpeg,svg'],
            ]);

            $data = Banner::findOrFail($id);
            $file = new FileManager();

            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($data->image && Storage::disk('banner')->exists($data->image)) {
                    Storage::disk('banner')->delete($data->image);
                }

                // Upload new image
                $photo = $request->file('image');
                $file->folder('banner')->prefix('banner')->upload($photo) ? $data->image = $file->getName() : null;
            }

            $data->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Banner updated successfully!',
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
        $this->deleteLog(Banner::class, $id);

        toast('Banner Deleted Successfully!', 'error', 'top-right');
        return redirect()->back();
    }
}
