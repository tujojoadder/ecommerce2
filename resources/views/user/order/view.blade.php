@extends('layouts.user.app', ['pageTitle' => $pageTitle])
@section('content')
    <link rel="stylesheet" href="{{ asset('dashboard/css/invoice.css') }}">
    <div class="card p-2">
        <div class="card-body">
            <div class="d-flex">
                <a href="javascript:;" onclick="printDiv('printableArea')" class="btn btn-info rounded-0 me-1 printBtn">
                    <i class="fas fa-print"></i> {{ __('messages.print') }}
                </a>
                <a href="javascript:;" onclick="printWithoutHeader('printableAreaWithoutHeader')" class="btn btn-info rounded-0 me-1 printBtn">
                    <i class="fas fa-print"></i> {{ __('messages.print_without_header') }}
                </a>

            </div>
        </div>
        <div class="rounded-0 summery_copy p-2">
            <div class="card-body rounded-0 p-2" id="printableArea" style="background-color: #e7e5f559;">
                @include('user.invoice.invoice-header')
            {{-- Order Info --}}
        <h6 class="mb-2">🧾 Order Information</h6>
        <table class="table table-sm table-bordered">
            <tr>
                <th>Order ID</th>
                <td>#{{ $order->id }}</td>
                <th>Date</th>
                <td>{{ $order->created_at->format('d M Y h:i A') }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>
                    @if($order->order_status == 0)
                        <span class="badge bg-dark">Requested</span>
                    @elseif($order->order_status == 1)
                        <span class="badge bg-danger">Placed</span>
                    @elseif($order->order_status == 2)
                        <span class="badge bg-info">Processing</span>
                    @elseif($order->order_status == 3)
                        <span class="badge bg-success">Delivered</span>
                    @elseif($order->order_status == 4)
                        <span class="badge bg-danger">Rejected</span>
                    @endif
                </td>
                <th>Payment</th>
                <td>{{ ucfirst($order->payment_status) }}</td>
            </tr>
            <tr>
                <th>Subtotal</th>
                <td>{{ number_format($order->sub_total, 2) }}</td>
                <th>Grand Total</th>
                <td><strong>{{ number_format($order->grand_total, 2) }}</strong></td>
            </tr>
        </table>

        {{-- Client Info --}}
        <h6 class="mt-4 mb-2">👤 Customer Information</h6>
        <table class="table table-sm table-bordered">
            <tr>
                <th>Name</th>
                <td>{{ $order->client->client_name ?? $order->name }}</td>
                <th>Phone</th>
                <td>{{ $order->client->phone ?? $order->phone }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $order->email ?? 'N/A' }}</td>
                <th>Shipping Address</th>
                <td>{{ $order->address }}, {{ $upazilas->name ?? '' }}, {{ $district->name ?? '' }}, {{ $division->name ?? '' }}, {{ $order->postal_code }}</td>
            </tr>
        </table>

        {{-- Order Items --}}
        <h6 class="mt-4 mb-2">📦 Order Items</h6>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product</th>
                    <th width="100">Price</th>
                    <th width="80">Qty</th>
                    <th width="120">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->orderItems as $key => $item)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $item->product->product_name ?? 'N/A' }}</td>
                    <td>{{ number_format($item->price, 2) }}</td>
                    <td>{{ $item->qty }}</td>
                    <td>{{ number_format($item->price * $item->qty, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="4" class="text-end">Subtotal:</th>
                    <th>{{ number_format($order->sub_total, 2) }}</th>
                </tr>
                <tr>
                    <th colspan="4" class="text-end">Discount:</th>
                    <th>- {{ number_format($order->total_discount, 2) }}</th>
                </tr>
                <tr>
                    <th colspan="4" class="text-end">Shipping:</th>
                    <th>{{ number_format($order->total_shipping_charge, 2) }}</th>
                </tr>
                <tr>
                    <th colspan="4" class="text-end">Grand Total:</th>
                    <th><strong>{{ number_format($order->grand_total, 2) }}</strong></th>
                </tr>
            </tfoot>
        </table>
            </div>
        </div>
    </div>

@endsection
@push('scripts')
    @if (request()->query('print') == 1)
        <script>
            $(document).ready(function() {
                setTimeout(() => {
                    printDiv('printableArea');
                }, 1000);
            });
        </script>
    @endif
    <script>
        function printDiv(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;

            var styleTag = document.createElement('style');
            styleTag.innerHTML = `
                @media print {
                    .overlay-img{
                        position: absolute !important;
                        top: 20% !important;
                        width: 70% !important;
                        filter: opacity(1) !important;
                        left: 15% !important;
                        z-index: 9999999 !important;
                    }
                    table.table{
                        width: 100% !important;
                        background-color: transparent !important;
                    }
                    table.table td{
                        background-color: transparent !important;
                    }
                }
            `;
            document.head.appendChild(styleTag);

            window.print();
            document.body.innerHTML = originalContents;
            // Reload the page after the print dialog is closed
            var mediaQueryList = window.matchMedia('print');
            @if (request()->query('print') == 1)
                if (!mediaQueryList.matches) {
                    location.href = "{{ route('user.invoice.index') }}";
                } else {
                    // Use the change event to detect when the print media query is no longer matching
                    mediaQueryList.addEventListener('change', function(mql) {
                        if (!mql.matches) {
                            location.href = "{{ route('user.invoice.index') }}";
                        }
                    });
                }
            @else
                if (!mediaQueryList.matches) {
                    location.reload();
                } else {
                    // Use the change event to detect when the print media query is no longer matching
                    mediaQueryList.addEventListener('change', function(mql) {
                        if (!mql.matches) {
                            location.reload();
                        }
                    });
                }
            @endif
        }
    </script>
    <script>
        function printWithoutHeader(divIdName) {
            var printContents = document.getElementById(divIdName).innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;

            var styleTag = document.createElement('style');
            styleTag.innerHTML = `
                @media print {
                    .overlay-img{
                        display: none !important;
                    }
                    table.table{
                        width: 100% !important;
                        background-color: transparent !important;
                    }
                    table.table td{
                        background-color: transparent !important;
                    }
                }
            `;
            document.head.appendChild(styleTag);

            window.print();
            document.body.innerHTML = originalContents;
            // Reload the page after the print dialog is closed
            var mediaQueryList = window.matchMedia('print');
            @if (request()->query('print') == 1)
                if (!mediaQueryList.matches) {
                    location.href = "{{ route('user.invoice.index') }}";
                } else {
                    // Use the change event to detect when the print media query is no longer matching
                    mediaQueryList.addEventListener('change', function(mql) {
                        if (!mql.matches) {
                            location.href = "{{ route('user.invoice.index') }}";
                        }
                    });
                }
            @else
                if (!mediaQueryList.matches) {
                    location.reload();
                } else {
                    // Use the change event to detect when the print media query is no longer matching
                    mediaQueryList.addEventListener('change', function(mql) {
                        if (!mql.matches) {
                            location.reload();
                        }
                    });
                }
            @endif
        }
    </script>
@endpush
