<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Client;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;

class CheckoutController extends Controller
{
    public function index()
    {
        $pageTitle = 'Checkout';
        $division = DB::table('divisions')->get();
        return view('frontend.checkout', compact('pageTitle', 'division'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'first_name'   => 'required|string|min:1|max:30',
            'last_name'    => 'required|string|min:1|max:30',
            'phone'        => 'required|string|min:1|max:20',
            'email'        => 'nullable|email|max:50',
            'division_id'  => 'required|integer',
            'district_id'  => 'required|integer',
            'upazila_id'   => 'required|integer',
            'postal_code'  => 'required|string|max:20',
            'address'      => 'required|string|max:255',
        ]);

        DB::beginTransaction(); // Start transaction

        try {
            $phone = $request->phone;
            $checkClient = Client::where('phone', $phone)->first();

            if ($checkClient) {
                $client_id = $checkClient->id;
            } else {
                $client = Client::create([
                    'client_name'  => $request->first_name . ' ' . $request->last_name,
                    'phone'        => $request->phone,
                    'email'        => $request->email,
                    'previous_due' => 0,
                    'type'         => 0,
                    'type'         => 1,
                    'address'      => $request->address,
                    'created_by'   => 'admin',
                ]);
                $client_id = $client->id;
            }

            // Create Order
            $order = Order::create([
                'client_id'             => $client_id,
                'name'                  => $request->first_name . ' ' . $request->last_name,
                'phone'                 => $request->phone,
                'email'                 => $request->email,
                'address'               => $request->address,
                'division_id'           => $request->division_id,
                'district_id'           => $request->district_id,
                'upazila_id'            => $request->upazila_id,
                'postal_code'           => $request->postal_code,
                'sub_total'             => $request->sub_total,
                'total_discount'        => $request->total_discount,
                'total_shipping_charge' => $request->total_shipping_charge,
                'grand_total'           => $request->grand_total,
                'payment_type'          => 1,
                'payment_status'        => 0,
                'order_status'          => 0,
            ]);

            // Create Order Items
            foreach ($request->product_id as $index => $productId) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $productId,
                    'qty'        => $request->qty[$index],
                    'price'      => $request->price[$index],
                ]);
            }

            // Delete Cart
            $cookie_id = $request->cookie('cookie_id');
            Cart::where('cookie_id', $cookie_id)->delete();

            DB::commit(); // Commit transaction

            return redirect()->route('frontend.checkout.success', ['order' => $order->id]);
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback transaction on error
            toast('Something went wrong: ' . $e->getMessage(), 'error');
            return redirect()->back()->withInput();
        }
    }

    public function success($order_id){
        $pageTitle = 'Order Placed Succesfully';
        $order = Order::with('orderItems', 'client')->findOrFail($order_id);
        $division = DB::table('divisions')->where('id', $order->division_id)->first();
        $district = DB::table('districts')->where('id', $order->district_id)->first();
        $upazilas = DB::table('upazilas')->where('id', $order->upazila_id)->first();
        return view('frontend.checkout-succss', compact('pageTitle', 'order', 'division', 'district', 'upazilas'));
    }
}
