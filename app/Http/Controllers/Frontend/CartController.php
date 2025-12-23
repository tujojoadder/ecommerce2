<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;

class CartController extends Controller
{
    public function store(Request $request)
    {
        $product = Product::findOrFail($request->product_id);

        if ($request->hasCookie('cookie_id')) {
            $cookie_id = $request->cookie('cookie_id');
        } else {
            $cookie_id = time() . Str::random(10);
            Cookie::queue('cookie_id', $cookie_id, 1440);
        }

        if (Cart::where(['cookie_id' => $cookie_id, 'product_id' => $request->product_id])->exists()) {
            if (Cart::where(['cookie_id' => $cookie_id, 'product_id' => $request->product_id])->exists()) {
                Cart::where(['cookie_id' => $cookie_id, 'product_id' => $request->product_id])->increment('quantity', $request->qty);
                return response()->json(['increase', $product->title]);
            } else {
                $cart = new Cart;
                $cart->cookie_id = $cookie_id;
                $cart->product_id = $request->product_id;
                $cart->quantity = $request->qty;
                $cart->price = $product->selling_price;
                $cart->save();
                return response()->json(['success', $product->name]);
            }
        } else {
            $cart = new Cart;
            $cart->cookie_id = $cookie_id;
            $cart->product_id = $request->product_id;
            $cart->quantity = $request->qty;
            $cart->price = $product->selling_price;
            $cart->save();
            return response()->json(['success', $product->name]);
        }

        return response()->json('error');
    }

    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'quantity' => 'required|integer|min:1|max:15'
        ]);

        if (request()->cookie('cookie_id')) {
            $cookie_id = request()->cookie('cookie_id');

            $cart = Cart::where('cookie_id', $cookie_id)->where('product_id', $request->product_id)->first();
            if ($cart == true) {
                $cart->quantity = $request->quantity;
                $cart->save();
                if ($request->row_id == null) {
                    return response()->json('success');
                } else {
                    return redirect()->back();
                }
            } else {
                return response()->json('error');
            }
        } else {
            return response()->json('error');
        }
    }

    public function fetchData()
    {
        $cookie_id = request()->cookie('cookie_id');
        $data = Cart::with('product')->where('cookie_id', $cookie_id)->get();
        return response()->json($data);
    }

    public function destroy($product_id)
    {
        if (request()->cookie('cookie_id')) {
            $cookie_id = request()->cookie('cookie_id');

            $cart = Cart::where('cookie_id', $cookie_id)->where('product_id', $product_id)->first();
            if ($cart == true) {
                $cart->forceDelete();
                toast('Cart Successfully Destroy!', 'success');
                return redirect()->back();
            } else {
                return response()->json('error');
            }
        } else {
            return response()->json('error');
        }
    }
}
