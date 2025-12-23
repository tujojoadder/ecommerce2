<?php

namespace App\Http\Controllers\User;

use App\DataTables\SliderDataTable;
use App\Helpers\FileManager;
use App\Helpers\Traits\DeleteLogTrait;
use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class SliderController extends Controller
{
    use DeleteLogTrait;

    public function index(SliderDataTable $dataTable)
    {
        $pageTitle = __('messages.slider');
        return $dataTable->render('user.slider.index', compact('pageTitle'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'image'     => ['required', 'mimes:jpg,png,jpeg,svg'],
            // 'subimage'  => ['nullable', 'mimes:jpg,png,jpeg,svg'],
        ]);

        $slider = new Slider();
        $file = new FileManager();

        // Store main image
        if ($request->image) {
            $photo = $request->image;
            $file->folder('slider')->prefix('slider')->upload($photo) ? $image = $file->getName() : null;
        } else {
            $image = null;
        }

        // if ($request->subimage) {
        //     $photo2 = $request->subimage;
        //     $file->folder('slider')->prefix('slider')->upload($photo2) ? $subimage = $file->getName() : null;
        // } else {
        //     $subimage = null;
        // }

        // Save other fields
        $slider->status      = 1;
        // $slider->subtitle    = $request->subtitle ?? null;
        $slider->title       = $request->title ?? null;
        // $slider->des         = $request->des ?? null;
        // $slider->link        = $request->link ?? null;
        $slider->created_by  = Auth::user()->username ?? null;
        $slider->image       = $image;
        // $slider->subimage       = $subimage;

        $slider->save();

        toast('Slider Successfully Created!', 'success');
        return redirect()->route('user.slider.index');
    }



    public function edit(string $id)
    {
        $data = Slider::findOrFail($id);
        return response()->json($data);
    }

    public function update(Request $request, string $id)
    {
        try {
            DB::beginTransaction();

            $this->validate($request, [
                'image' => ['mimes:jpg,png,jpeg,svg'],
                'subimage' => ['mimes:jpg,png,jpeg,svg'],
            ]);

            $data = Slider::findOrFail($id);
            $file = new FileManager();

            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($data->image && Storage::disk('slider')->exists($data->image)) {
                    Storage::disk('slider')->delete($data->image);
                }

                // Upload new image
                $photo = $request->file('image');
                $file->folder('slider')->prefix('slider')->upload($photo) ? $data->image = $file->getName() : null;
            }

            if ($request->hasFile('subimage')) {
                // Delete old image if exists
                if ($data->subimage && Storage::disk('slider')->exists($data->subimage)) {
                    Storage::disk('slider')->delete($data->subimage);
                }

                // Upload new image
                $photo2 = $request->file('subimage');
                $file->folder('slider')->prefix('slider')->upload($photo2) ? $data->subimage = $file->getName() : null;
            }

            $data->status = 1;
            $data->subtitle = $request->subtitle;
            $data->title = $request->title;
            $data->des = $request->des;
            $data->link = $request->link;
            $data->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Slider updated successfully!',
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
        $this->deleteLog(Slider::class, $id);

        toast('Slider Deleted Successfully!', 'error', 'top-right');
        return redirect()->back();
    }
}