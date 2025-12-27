<?php

namespace App\Http\Controllers\User\Products;

use App\DataTables\ProductDataTable;
use App\DataTables\ProductGroupDataTable;
use App\DataTables\ProductUnitDataTable;
use App\Helpers\Traits\DeleteLogTrait;
use App\Helpers\FileManager;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductGroup;
use App\Models\ProductAsset;
use App\Models\ProductImage;
use App\Models\ProductUnit;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    use DeleteLogTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(ProductDataTable $dataTable)
    {
        $pageTitle = __('messages.product') . ' ' . __('messages.list');
        $product_group = ProductGroup::where('deleted_at', null)->get();
        $product_unit = ProductUnit::where('deleted_at', null)->get();
        return $dataTable->render('user.products.product.index', compact('pageTitle', 'product_group', 'product_unit'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pageTitle = __('messages.product') . ' ' . __('messages.create');
        return view('user.products.product.create', compact('pageTitle'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        try {
            DB::beginTransaction();

            // Upload main product image
            $file = new FileManager();
            if ($request->image) {

                if ($request->image != null) {
                    Storage::disk('product')->delete($request->image);
                }
                $photo = $request->image;
                $file->folder('product')->prefix('product')->upload($photo) ? $image = $file->getName() : null;
            } else {
                $image = null;
            }

            // Create product
            $data = new Product();
            $data->name = $request->name;
            $data->slug = Str::slug($request->name) . uniqid() . time();
            $data->subtitle = $request->subtitle;
            $data->item_code = $request->item_code;
            $data->condition = $request->condition;
            $data->main_price = $request->main_price;
            $data->image = $image;
            $data->description = $request->description;
            $data->buying_price = $request->buying_price ?? 0;
            $data->selling_price = $request->selling_price ?? 0;
            $data->wholesale_price = $request->wholesale_price ?? 0;
            $data->unit_id = $request->unit_id ?? null;
            $data->color_id = $request->color_id ?? null;
            $data->size_id = $request->size_id ?? null;
            $data->brand_id = $request->brand_id ?? null;
            $data->custom_barcode_no = $request->custom_barcode_no ?? null;
            $data->imei_no = $request->imei_no ?? null;
            $data->opening_stock = $request->opening_stock ?? 0;
            $data->in_stock = $request->opening_stock ?? 0;
            $data->group_id = $request->group_id;
            $data->warehouse_id = $request->warehouse_id ?? null;
            $data->carton = $request->carton == (null || 0) ? 1 : $request->carton;
            $data->stock_warning = $request->stock_warning == (null || 0) ? 1 : $request->stock_warning;
            $data->category_id = $request->category_id;
            $data->subcategory_id = $request->subcategory_id;
            $data->subsubcategory_id = $request->subsubcategory_id;
            $data->meta_title = $request->meta_title;
            $data->meta_seo = $request->meta_seo;
            $data->meta_description = $request->meta_description;
            $data->meta_tag = $request->meta_tag;
            $data->information = $request->information;
            $data->specification = $request->specification;
            $data->guarantee = $request->guarantee;
            $data->shipping_in_dhaka = $request->shipping_in_dhaka ?? 0;
            $data->shipping_out_dhaka = $request->shipping_out_dhaka ?? 0;
            $data->is_bestsell = $request->is_bestsell;
            $data->is_special = $request->is_special;
            $data->is_newarrival = $request->is_newarrival;
            $data->is_mostreview = $request->is_mostreview;
            $data->created_by = Auth::user()->username;
            $data->meta_tag = is_array($request->meta_tag) ? implode(',', $request->meta_tag) : $request->meta_tag;
            $data->save();

            // Handle custom barcode
            $product = Product::findOrFail($data->id);
            if ($product->custom_barcode_no == null) {
                $product->custom_barcode_no = date('y') . $data->id;
            } else {
                $product->custom_barcode_no = $data->custom_barcode_no;
            }
            $product->save();

            // Upload subimages
            // Upload subimages
            if ($request->hasFile('subimage')) {
                foreach ($request->file('subimage') as $subimage) {
                    $subFile = new FileManager();
                    $subFile->folder('product/subimages')->prefix('product_subimage')->upload($subimage) ? $subimageName = $subFile->getName() : null;

                    // Save to ProductImage model
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image' => $subimageName,
                    ]);
                }
            }

            DB::commit();

            toast('Product Successfully Added!', 'success');
            return response()->json($data);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'message' => 'Error adding product',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pageTitle = 'Edit Product';
        $product = Product::with('images')->findOrFail($id);

        $metaTags = [];
        if (!empty($product->meta_tag)) {
            $metaTags = is_array($product->meta_tag)
                ? $product->meta_tag
                : explode(',', $product->meta_tag);
        }
        return view('user.products.product.edit', compact('product', 'pageTitle', 'metaTags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'image'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'subimage.*'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        DB::beginTransaction();

        try {
            $file = new FileManager();
            $product = Product::findOrFail($id);

            if ($request->hasFile('image')) {
                if ($product->image != null) {
                    Storage::disk('product')->delete($product->image);
                }
                $image = $request->image;
                $file->folder('product')->prefix('product')->upload($image) ? $product->image = $file->getName() : null;
            }



            if ($request->hasFile('subimage')) {
                $oldImages = $product->images;
                $oldImages = $product->images;
                foreach ($oldImages as $img) {
                    if (Storage::disk('public')->exists($img->image)) {
                        Storage::disk('public')->delete($img->image);
                    }
                    $img->delete();
                }

                foreach ($request->file('subimage') as $subimage) {
                    $subFile = new FileManager();
                    $subFile->folder('product/subimages')->prefix('product_subimage')->upload($subimage) ? $subimageName = $subFile->getName() : null;

                    // Save to ProductImage model
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image' => $subimageName,
                    ]);
                }
            }

            // Update other fields
            $product->name              = $request->name;
            $product->slug = Str::slug($request->name) . uniqid() . time();
            $product->subtitle          = $request->subtitle;
            $product->item_code         = $request->item_code;
            $product->condition         = $request->condition;
            $product->main_price        = $request->main_price;
            $product->buying_price      = $request->buying_price;
            $product->selling_price     = $request->selling_price;
            $product->wholesale_price   = $request->wholesale_price;
            $product->unit_id           = $request->unit_id;
            $product->color_id          = $request->color_id;
            $product->size_id           = $request->size_id;
            $product->brand_id          = $request->brand_id;
            $product->carton            = $request->carton;
            $product->opening_stock     = $request->opening_stock;
            $product->stock_warning     = $request->stock_warning;
            $product->shipping_in_dhaka = $request->shipping_in_dhaka;
            $product->shipping_out_dhaka = $request->shipping_out_dhaka;
            $product->custom_barcode_no = $request->custom_barcode_no;
            $product->imei_no           = $request->imei_no;
            $product->group_id          = $request->group_id;
            $product->warehouse_id      = $request->warehouse_id;

            $product->meta_title        = $request->meta_title;
            $product->meta_description  = $request->meta_description;
            $product->meta_tag = is_array($request->meta_tag) ? implode(',', $request->meta_tag) : $request->meta_tag;

            $product->information       = $request->information;
            $product->specification     = $request->specification;
            $product->guarantee         = $request->guarantee;
            $product->category_id = $request->category_id;
            $product->subcategory_id = $request->subcategory_id;
            $product->subsubcategory_id = $request->subsubcategory_id;
            $product->meta_title = $request->meta_title;

            $product->is_bestsell = $request->is_bestsell;
            $product->is_special = $request->is_special;
            $product->is_newarrival = $request->is_newarrival;
            $product->is_mostreview = $request->is_mostreview;

            $product->save();

            DB::commit();
            toast('Product Successfully Update!', 'success');
            return response()->json($product);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        /**
         * For the delete log
         * 1. Model Name
         * 2. Row ID
         */
        $product = Product::findOrFail($id);
        if ($product->hasAnyTransaction() == false) {
            $this->deleteLog(Product::class, $id);
            return response()->json(['success' => 'Product Deleted Successfully!'], 200);
        }
        return response()->json(['warning' => 'Product Has Transactions!'], 201);
    }

    //product barcode
    public function productBarcode(ProductDataTable $dataTable)
    {
        $pageTitle = __('messages.product') . ' ' . __('messages.barcode');
        return $dataTable->render('user.product.barcode', compact('pageTitle'));
    }
}
