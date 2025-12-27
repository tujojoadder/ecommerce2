<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogCategories = BlogCategory::orderBy('id', 'desc')
            ->whereNull('deleted_at')->paginate(10);

        $pageTitle = __('Manage Blog Categories');
        
        return view('admin.blog-categories.index', compact('blogCategories', 'pageTitle'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pageTitle = __('Create Blog Category');
        return view('admin.blog-categories.create', compact('pageTitle'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:blog_categories,name',
            'status' => 'required|in:1,0'
        ]);

        try {
            $blogCategory = new BlogCategory();
            $blogCategory->name = strip_tags($request->name);
            $blogCategory->created_by = 'admin';
            $blogCategory->status = strip_tags($request->status) ?? 1;
            $blogCategory->save();

            return redirect()->route('admin.blog-categories.index')->with('success', __('Blog category created successfully.'));

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error creating blog category: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BlogCategory $blogCategory)
    {
        $pageTitle = __('Edit Blog Category');
        return view('admin.blog-categories.edit', compact('blogCategory', 'pageTitle'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BlogCategory $blogCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:blog_categories,name,' . $blogCategory->id,
            'status' => 'required|in:1,0'
        ]);

        try {
            $blogCategory->name = strip_tags($request->name);
            $blogCategory->created_by = 'admin';
            $blogCategory->status = strip_tags($request->status) ?? 1;
            $blogCategory->save();

            return redirect()->route('admin.blog-categories.index')
                ->with('success', __('Blog category updated successfully'));

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BlogCategory $blogCategory)
    {
        try {

            $blogCategory->delete();

            return redirect()->route('admin.blog-categories.index')
                ->with('success', __('Blog category deleted successfully'));

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Update status of category
     */
    public function updateStatus(Request $request, BlogCategory $blogCategory)
    {
        $request->validate([
            'status' => 'required|in:1,0'
        ]);

        try {
            $blogCategory->status = strip_tags($request->status);
            $blogCategory->save();

            return response()->json([
                'success' => true,
                'message' => __('Status updated successfully'),
                'status' => $blogCategory->status
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('Error updating status')
            ], 500);
        }
    }
}