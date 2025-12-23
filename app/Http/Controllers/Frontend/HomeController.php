<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $sliders = Slider::all();
        $categories = Category::with('products')->where('is_deleted', 0)->get();
        $products = Product::all();
        $banners=Banner::all();
        $pageTitle = 'Home' . ' | ' . config('company.name');
        return view('frontend.index', compact('sliders', 'categories','products','banners', 'pageTitle'));
    }

    public function getdistrict($division_id){
        $data = DB::table('districts')->where('division_id', $division_id)->get();
        return response()->json($data);
    }

    public function getUpazila($district_id){
        $data = DB::table('upazilas')->where('district_id', $district_id)->get();
        return response()->json($data);
    }

    public function shop(Request $request)
    {
        $pageTitle = 'Shop Now ' . config('company.name');
        $allCat = Category::with('subcategories.subsubcategory', 'products')
            ->where('is_deleted', 0)
            ->oldest()
            ->get();

        $brand = Brand::with('products')->whereNull('deleted_at')->get();

        $categorySlug = $request->get('category');
        $searchTerm = $request->get('query');
        $subcategorySlug = $request->get('subcategory');
        $subsubcategorySlug = $request->get('subsubcategory');

        $query = Product::query();

        // Category filter
        if ($categorySlug) {
            $cat = Category::where('slug', $categorySlug)->first();
            if ($cat) {
                $query->where('category_id', $cat->id);
            }
        }
        if ($searchTerm) {
            $query->where('name', 'like', '%' . $searchTerm . '%');
        }
        // Extra filters (AJAX থেকে আসবে)
        if ($request->ajax()) {
            // Multiple category filter
            if ($request->has('categories') && is_array($request->categories)) {
                $query->whereIn('category_id', $request->categories);
            }

            // Brand filter
            if ($request->has('brands') && is_array($request->brands)) {
                $query->whereIn('brand_id', $request->brands);
            }

            // Price range filter
            if ($request->has('price_min') && $request->has('price_max')) {
                $min = $request->price_min ?? 0;
                $max = $request->price_max ?? 1000000;
                $query->whereBetween('selling_price', [$min, $max]);
            }

            // Paginate & return only product view
            $products = $query->latest()->paginate(12);
            return view('frontend.partials.product_list', compact('products'))->render();
        }


        // Initial load
        $products = $query->latest()->paginate(12);

        return view('frontend.shop', compact('pageTitle', 'allCat', 'brand', 'products'));
    }
}