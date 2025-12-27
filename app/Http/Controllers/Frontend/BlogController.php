<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Helpers\FileManager;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Blog::with('category')->whereNull('deleted_at');

        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        if ($request->filled('status')) {
            $query->where('is_published', $request->status);
        }

        if ($request->filled('published_date')) {
            $query->whereDate('published_at', $request->published_date);
        }

        $blogs = $query->latest()->paginate(10)->appends($request->all());

        $pageTitle = __('Blog Management');

        return view('frontend.myuser.blog.index', compact('blogs', 'pageTitle'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = BlogCategory::whereNull('deleted_at')->where('status', 1)->get();
        $pageTitle = __('Create new blog');
        return view('frontend.myuser.blog.create', compact('categories', 'pageTitle'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|integer|exists:blog_categories,id',
            'tags' => 'nullable|json',
            'is_published' => 'nullable|boolean'
        ]);

        // Secure tag processing
        $tags = null;

        if (!empty($validated['tags'])) {
            $decodedTags = json_decode($validated['tags'], true);

            $tags = collect($decodedTags)
                ->pluck('value')
                ->map(fn($tag) => strip_tags(trim($tag)))
                ->filter()
                ->unique()
                ->values()
                ->toArray();
        }

        // Generate clean title and unique slug
        $title = trim($validated['title']);
        $slug = Str::slug($title) . '-' . time();

        $blog = new Blog();
        $blog->title = $title;
        $blog->slug = $slug;
        $blog->description = $validated['description']; //sanitize_editor($validated['description']);
        $blog->category_id = strip_tags($validated['category_id']);
        $blog->post_author = 'admin';
        $blog->posted_by = auth()->user()->id; //auth()->guard('admin')->user()->id;
        $blog->is_published = $request->boolean('is_published');
        $blog->tags = $tags;

        if ($blog->is_published) {
            $blog->published_at = Carbon::now();
        }

        $file = new FileManager();
        if ($request->hasFile('image')) {
            if ($request->image != null) {
                Storage::disk('blog')->delete($request->image);
            }
            $photo = $request->image;
            $file->folder('blog')->prefix('blog')->upload($photo) ? $image = $file->getName() : null;
        } else {
            $image = null;
        }
        $blog->image = $image;
        $blog->save();

        return redirect()
            ->route('user.blog.index')
            ->with('success', __('Blog created successfully'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $categories = BlogCategory::whereNull('deleted_at')->where('status', 1)->get();
        $blog = Blog::findOrFail($id);
        $pageTitle = __('Edit Blog');
        return view('frontend.myuser.blog.edit', compact('blog', 'categories', 'pageTitle'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|integer|exists:blog_categories,id',
            'tags' => 'nullable|json',
            'is_published' => 'nullable|boolean'
        ]);

        // Secure tag processing
        $tags = null;

        if (!empty($validated['tags'])) {
            $decodedTags = json_decode($validated['tags'], true);

            $tags = collect($decodedTags)
                ->pluck('value')
                ->map(fn($tag) => strip_tags(trim($tag)))
                ->filter()
                ->unique()
                ->values()
                ->toArray();
        }

        // Generate clean title and unique slug
        $title = trim($validated['title']);
        $slug = Str::slug($title) . '-' . time();

        $blog = Blog::findOrFail($id);
        $blog->title = $title;
        $blog->slug = $slug;
        $blog->description = $validated['description'];
        $blog->category_id = strip_tags($validated['category_id']);
        $blog->post_author = 'admin';
        $blog->posted_by = auth()->user()->id;
        $blog->is_published = $request->boolean('is_published');
        $blog->tags = $tags;

        if ($blog->is_published) {
            $blog->published_at = Carbon::now();
        }

        // Image Upload
        $file = new FileManager();
        if ($request->hasFile('image')) {
            if ($request->image != null) {
                Storage::disk('blog')->delete($request->image);
            }
            $photo = $request->image;
            $file->folder('blog')->prefix('blog')->upload($photo) ? $image = $file->getName() : null;
        } else {
            $image = $blog->image;
        }
        $blog->image = $image;

        $blog->save();

        return redirect()->route('user.blog.index')
            ->with('success', __('Blog updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        try {

            $blog->delete();

            return redirect()->route('user.blog.index')
                ->with('success', __('Blog deleted successfully'));
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Update status of category
     */
    public function updateStatus(Request $request, Blog $blog)
    {
        $request->validate([
            'is_published' => 'required|in:1,0'
        ]);

        try {
            $blog->is_published = strip_tags($request->is_published);
            if ($request->is_published) {
                $blog->published_at = Carbon::now();
            }
            $blog->save();

            return response()->json([
                'success' => true,
                'message' => __('Status updated successfully'),
                'status' => $blog->status
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('Error updating status')
            ], 500);
        }
    }

    /* fontend */

    public function frontendIndex()
    {
        $blogs =  Blog::with('category')->whereNull('deleted_at')->get();

        return view('frontend.blog', compact('blogs'));
    }
    public function frontendShow($id)
    {

        $blog =  Blog::whereNull('deleted_at')
            ->where('id', $id)->firstOrFail();

        return view('frontend.single-blog', compact('blog'));
    }
}
