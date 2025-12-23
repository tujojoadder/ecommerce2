<?php

namespace App\Http\Controllers\User;

use App\DataTables\OrderDataTable;
use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(OrderDataTable $dataTable){
        $pageTitle = __('messages.product') . ' ' . __('messages.order') . ' '  . __('messages.list');
        return $dataTable->render('user.order.index', compact('pageTitle'));
    }

    public function changeStatus($order_id, $status)
    {
        try {
            if($status == 3){
                $order = Order::findOrFail($order_id);
                $order->order_status = $status;
                $order->save();

                $account = Account::first();

                $invoice = new Invoice();
                $invoice->client_id = $order->client_id;
                $invoice->order_id = $order->id;
                $invoice->issued_date = $order->created_at ?? now();
                $invoice->issued_time = now();
                $invoice->discount_type = 'flat';
                $invoice->discount = $order->total_discount ?? 0;
                $invoice->total_return = null;
                $invoice->transport_fare = 0;
                $invoice->labour_cost = 0;
                $invoice->account_id = $account->id;
                $invoice->bank_id = null;
                $invoice->cheque_number = null;
                $invoice->cheque_issued_date = null;

                $invoice->category_id = null;
                $invoice->receive_amount = $order->grand_total ?? 0;
                $invoice->cash_receive = 0;
                $invoice->change_amount = 0;
                $invoice->total_shipping_charge = $order->total_shipping_charge;

                // ⚠ এখানে একটা টাইপো আছে -> $$order (ডাবল ডলার sign)
                $invoice->bill_amount = $order->grand_total ?? 0;

                $invoice->due_amount = 0;
                $invoice->highest_due = 0;
                $invoice->vat_type = 'flat';
                $invoice->vat = 0;
                $invoice->description = 'Product Order Delivered';

                $invoice->total_discount = $order->total_discount ?? 0;
                $invoice->invoice_bill = $order->grand_total ?? 0;
                $invoice->previous_due = 0;
                $invoice->due_before_return = 0;
                $invoice->total_vat = 0;
                $invoice->grand_total = $order->grand_total ?? 0;
                $invoice->total_due = 0;
                $invoice->adjusting_amount = 0;
                $invoice->send_sms = null;
                $invoice->send_email = null;
                $invoice->created_by = Auth::user()->username;
                $invoice->prepared_by = Auth::user()->username;
                $invoice->status = 0;
                $invoice->save();

                $invoice_items = OrderItem::with('product')->where('order_id', $order_id)->get();
                foreach ($invoice_items as $item) {
                    InvoiceItem::create([
                        'invoice_id'      => $invoice->id,
                        'issued_date'     => $invoice->issued_date,
                        'purchased_id'    => null,
                        'row_id'          => null,
                        'product_id'      => $item->product_id,
                        'description'     => 'Product Order',
                        'stock'           => $item->product->in_stock ?? 0,
                        'buying_price'    => $item->product->buying_price ?? 0,
                        'selling_price'   => $item->price,
                        'selling_type'    => 'regular',
                        'wholesale_price' => 0,
                        'quantity'        => $item->qty,
                        'return_type'     => null,
                        'unit_id'         => $item->product->unit_id ?? null,
                        'total'           => $item->qty * $item->price,
                        'status'          => 0,
                        'created_by'      => Auth::user()->username,
                        'prepared_by'     => Auth::user()->username,
                    ]);
                }
            } else {
                $order = Order::findOrFail($order_id);
                $order->order_status = $status;
                $order->save();
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Order status updated successfully!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(), // আসল error দেখাবে
                'line'    => $e->getLine(),    // কোন লাইনে error হয়েছে দেখাবে
                'file'    => $e->getFile(),    // কোন ফাইলে error হয়েছে
            ], 500);
        }
    }

    public function view($id){
        $pageTitle = 'Order Details';
        $order = Order::with('orderItems.product', 'client')->findOrFail($id);
        $division = DB::table('divisions')->where('id', $order->division_id)->first();
        $district = DB::table('districts')->where('id', $order->district_id)->first();
        $upazilas = DB::table('upazilas')->where('id', $order->upazila_id)->first();
        return view('user.order.view', compact('order', 'pageTitle', 'division', 'district', 'upazilas'));
    }


}
