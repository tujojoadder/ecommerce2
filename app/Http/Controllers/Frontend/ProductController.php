<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show($id)
    {
        $cookie_id = request()->cookie('cookie_id');
        $item = Product::with('images')->findOrFail($id);
        $cartData = Cart::with('product')->where('product_id', $id)->where('cookie_id', $cookie_id)->first();
        $pageTitle = $item->name;

        $products = Product::all();
        return view('frontend.myuser.product.single', compact('item', 'products', 'pageTitle', 'cartData'));
    }
}