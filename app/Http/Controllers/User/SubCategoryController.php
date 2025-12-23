<?php

namespace App\Http\Controllers\User;

use App\DataTables\SubCategoryDataTable;
use App\Http\Controllers\Controller;
use App\Models\SubCategory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    public function index(SubCategoryDataTable $dataTable)
    {
        $pageTitle = __('messages.subcategory');
        return $dataTable->render('user.subcategory.index', compact('pageTitle'));
    }


    public function store(Request $request)
    {
        // Validation
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|min:1',
        ]);

        $slug = Str::slug($request->name) . '-' . time() . uniqid();
        $subcat = SubCategory::create([
             'name'        => $request->name,
             'slug'        => $slug,
             'category_id' => $request->category_id,
             'created_by'  => Auth::id(),
             'updated_by'  => Auth::id(),
             'is_deleted'  => 0,
         ]);

        return response()->json($subcat);
    }

    public function edit(string $id)
    {
        $subcategory = SubCategory::findOrFail($id);
        return response()->json($subcategory);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'category_id' => 'required',
            'name' => 'required|min:1',
        ]);

        $slug = Str::slug($request->name) . '-' . time() . uniqid();

        $subcategory = SubCategory::findOrFail($id);
        $subcategory->category_id = $request->category_id;
        $subcategory->name = $request->name;
        $subcategory->slug = $slug;
        $subcategory->updated_by = Auth::id();
        $subcategory->save();

        return response()->json($subcategory);
    }

    public function destroy(string $id)
    {
        $data = SubCategory::findOrFail($id)->update(['is_deleted' => 1]);
        return response()->json($data);
    }
}
