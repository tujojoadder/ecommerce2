<?php

namespace App\Http\Controllers\User;

use App\DataTables\CategoryDataTable;
use App\Helpers\FileManager;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(CategoryDataTable $dataTable)
    {
        $pageTitle = __('messages.category');
        return $dataTable->render('user.category.index', compact('pageTitle'));
    }


    public function create()
    {
        $pageTitle = __('messages.add') . ' ' . __('messages.category');
        return view('user.category.create', compact('pageTitle'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:1|max:255',
            'icon' => 'mimes:png,jpg,jpeg,gif|max:5120',
            'banner' => 'mimes:png,jpg,jpeg,gif|max:5120',
            'banner2' => 'mimes:png,jpg,jpeg,gif|max:5120',
        ]);

        $file = new FileManager();
        $slug = Str::slug($request->name) . '-' . time();


        // Icon ===============
        if ($request->icon) {
            $icon = $request->icon;
            $file->folder('category')->prefix('category')->upload($icon) ? $icon = $file->getName() : null;
        } else {
            $icon = null;
        }

        // Banner ===============
        if ($request->banner) {
            $banner = $request->banner;
            $file->folder('category')->prefix('category')->upload($banner) ? $banner = $file->getName() : null;
        } else {
            $banner = null;
        }

        // Banner2 ===============
        if ($request->banner2) {
            $banner2 = $request->banner2;
            $file->folder('category')->prefix('category')->upload($banner2) ? $banner2 = $file->getName() : null;
        } else {
            $banner2 = null;
        }

        $data = new Category();
        $data->name = $request->name;
        $data->slug = $slug;
        $data->icon = $icon;
        $data->banner = $banner;
        $data->banner2 = $banner2;
        $data->save();

        toast('Category Added Successfully!', 'success');
        return response()->json($data);
    }


    public function edit(string $id)
    {
        $category = Category::findOrFail($id);
        return response()->json($category);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|min:1|max:255',
            'icon' => 'mimes:png,jpg,jpeg,gif|max:5120',
            'banner' => 'mimes:png,jpg,jpeg,gif|max:5120',
            'banner2' => 'mimes:png,jpg,jpeg,gif|max:5120',
        ]);

        $file = new FileManager();
        $data = Category::findOrFail($id);

        // update slug only if name changes
        if ($data->name !== $request->name) {
            $data->slug = Str::slug($request->name) . '-' . time();
        }

        // Icon ===============
        if ($request->hasFile('icon')) {
            if ($data->icon != null) {
                Storage::disk('category')->delete($data->icon);
            }
            $icon = $request->icon;
            $file->folder('category')->prefix('category')->upload($icon) ? $data->icon = $file->getName() : null;
        }

        // Banner ===============
        if ($request->hasFile('banner')) {
            if ($data->banner != null) {
                Storage::disk('category')->delete($data->banner);
            }
            $banner = $request->banner;
            $file->folder('category')->prefix('category')->upload($banner) ? $data->banner = $file->getName() : null;
        }

        // Banner2 ===============
        if ($request->hasFile('banner2')) {
            if ($data->banner2 != null) {
                Storage::disk('category')->delete($data->banner2);
            }
            $banner2 = $request->banner2;
            $file->folder('category')->prefix('category')->upload($banner2) ? $data->banner2 = $file->getName() : null;
        }

        // update name
        $data->name = $request->name;

        $data->save();

        toast('Category Updated Successfully!', 'success');
        return redirect()->route('user.category.index');
    }


    public function destroy(string $id)
    {
        $data = Category::findOrFail($id)->update(['is_deleted' => 1]);
        return response()->json($data);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:1,0'
        ]);

        try {
            $category = Category::findOrFail($id);
            $category->is_frontend = $request->status;
            $category->save();

            return response()->json([
                'success' => true,
                'message' => __('Status updated successfully'),
                'status' => $category->is_frontend
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('Error updating status')
            ], 500);
        }
    }

}
