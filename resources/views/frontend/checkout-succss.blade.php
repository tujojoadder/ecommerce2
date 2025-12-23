@extends('layouts.frontend.app')
@section('content')
<style>
    .order-success-card {
        border-radius: 15px;
        padding: 2rem;
        background: #f9f9f9;
        max-width: 700px;
        margin: 0 auto;
    }

    .order-success-card h1 {
        font-size: 2rem;
    }

    .order-summary th {
        width: 35%;
        background-color: #f1f1f1;
    }

    .order-summary td {
        font-weight: 500;
    }

    .products-table th, .products-table td {
        vertical-align: middle;
    }

    .products-table th {
        background-color: #007bff;
        color: white;
    }

    .products-table tr:nth-child(even) {
        background-color: #f8f9fa;
    }

    .totals p {
        font-size: 1.1rem;
    }

    .grand-total {
        font-size: 1.5rem;
        font-weight: bold;
        color: #28a745;
    }

    .btn-primary {
        border-radius: 50px;
        padding: 0.6rem 1.5rem;
        font-weight: bold;
    }

    @media (max-width: 768px) {
        .order-success-card {
            padding: 1.5rem;
        }

        .products-table th, .products-table td {
            font-size: 0.9rem;
        }
    }
</style>

<div class="container my-5">
    <div class="d-flex justify-content-center">
        <div class="order-success-card shadow-sm text-center">
            <h1 class="mb-3" style="font-size: 30px;color:green;font-weight: 900"><i class="bi bi-check-circle"></i> Order Placed!</h1>
            <p class="lead mb-4">Thank you, <strong>{{ $order->client->name }}</strong>, for your purchase.</p>

            <h3 class="mb-3 text-primary">Order Summary</h3>
            <table class="table table-bordered order-summary text-start">
                <tbody>
                    <tr>
                        <th>Order ID</th>
                        <td>#{{ $order->id }}</td>
                    </tr>
                    <tr>
                        <th>Order Date</th>
                        <td>{{ $order->created_at->format('d M Y, h:i A') }}</td>
                    </tr>
                    <tr>
                        <th>Shipping Address</th>
                        <td>{{ $order->address }}, {{ $upazilas->name ?? '' }}, {{ $district->name ?? '' }}, {{ $division->name ?? '' }}, {{ $order->postal_code }}</td>
                    </tr>
                    <tr>
                        <th>Payment Type</th>
                        <td>{{ $order->payment_type == 1 ? 'Cash on Delivery' : 'Online Payment' }}</td>
                    </tr>
                    <tr>
                        <th>Order Status</th>
                        <td>
                            @if($order->order_status == 0)
                                <span class="badge bg-warning text-dark">Pending</span>
                            @elseif($order->order_status == 1)
                                <span class="badge bg-info text-dark">Processing</span>
                            @elseif($order->order_status == 2)
                                <span class="badge bg-success">Completed</span>
                            @else
                                <span class="badge bg-danger">Cancelled</span>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>

            <h5 class="mt-4 text-primary" style="font-weight: 900">Products Ordered</h5>
            <table class="table table-striped products-table text-center">
                <thead>
                    <tr>
                        <th style="border: 1px solid #222">Product</th>
                        <th style="border: 1px solid #222">Qty</th>
                        <th style="border: 1px solid #222">Price</th>
                        <th style="border: 1px solid #222">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->orderItems as $item)
                    <tr>
                        <td style="border: 1px solid #222">{{ $item->product->name ?? 'N/A' }}</td>
                        <td style="border: 1px solid #222">{{ $item->qty }}</td>
                        <td style="border: 1px solid #222">{{ config('company.currency_symbol') }}{{ number_format($item->price, 2) }}</td>
                        <td style="border: 1px solid #222">{{ config('company.currency_symbol') }}{{ number_format($item->qty * $item->price, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="totals mt-4 text-end">
                <h5>Subtotal: {{ config('company.currency_symbol') }}{{ number_format($order->sub_total, 2) }}</h5>
                <h5>Discount: {{ config('company.currency_symbol') }}{{ number_format($order->total_discount, 2) }}</h5>
                <h5>Shipping Charge: {{ config('company.currency_symbol') }}{{ number_format($order->total_shipping_charge, 2) }}</h5>
                <h5 class="grand-total">Grand Total: {{ config('company.currency_symbol') }}{{ number_format($order->grand_total, 2) }}</h5>
            </div>

            <a href="{{ route('frontend.home') }}" class="btn btn-primary mt-4"><i class="bi bi-arrow-left-circle"></i> Continue Shopping</a>
        </div>
    </div>
</div>
@endsection
