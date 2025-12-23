<?php

namespace App\Http\Controllers\User;

use App\DataTables\SubSubCategoryDataTable;
use App\Http\Controllers\Controller;
use App\Models\SubSubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Mpdf\Tag\Sub;

class SubSubCategoryController extends Controller
{
    public function index(SubSubCategoryDataTable $dataTable)
    {
        $pageTitle = __('messages.subsubcategory');
        return $dataTable->render('user.subsubcategory.index', compact('pageTitle'));
    }

    public function store(Request $request)
    {
        // Validation
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required',
            'name' => 'required|min:1',
        ]);
        $slug = Str::slug($request->name) . '-' . time() . uniqid();
        $subsub = SubSubCategory::create([
            'name'        => $request->name,
            'slug'        => $slug,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'created_by'  => Auth::id(),
            'updated_by'  => Auth::id(),
            'is_deleted'  => 0,
        ]);

        return response()->json($subsub);
    }

    public function edit(string $id)
    {
        $subsubcategory = SubSubCategory::findOrFail($id);
        return response()->json($subsubcategory);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'category_id' => 'required',
            'subcategory_id' => 'required',
            'name' => 'required|min:1',
        ]);

        $slug = Str::slug($request->name) . '-' . time() . uniqid();

        $subcategory = SubSubCategory::findOrFail($id);
        $subcategory->category_id = $request->category_id;
        $subcategory->subcategory_id = $request->subcategory_id;
        $subcategory->name = $request->name;
        $subcategory->slug = $slug;
        $subcategory->updated_by = Auth::id();
        $subcategory->save();

        return response()->json($subcategory);
    }

    public function destroy(string $id)
    {
        $data = SubSubCategory::findOrFail($id)->update(['is_deleted' => 1]);
        return response()->json($data);
    }
}
