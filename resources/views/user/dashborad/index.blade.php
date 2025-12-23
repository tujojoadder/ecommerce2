@extends('layouts.user.app', ['pageTitle' => $pageTitle])
@section('content')
    <style>
        .short-card {
            padding-top: 12px;
            padding-bottom: 12px;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('dashboard/css/dashboard.css') }}">
    @canany(['access-all', 'dashboard-visibility'])
        <div class="main-content-body">
            <div class="row">
                <!-- Invoice Card -->
                <div class="col-xl-2 col-lg-2 col-md-2 col-4">
                    <div class="card square-card overflow-hidden short-card">
                        <div class="card-body pb-2">
                            <a href="{{ route('user.invoice.create') }}" class="card-overlay"><i class="fas fa-plus mx-0"></i></a>
                            <div>
                                <div class="d-flex align-items-center justify-content-center">
                                    <img src="{{ asset('dashboard/img/icon/invoice.png') }}" alt="" class="ht-70 wd-70 my-auto rounded-lg">
                                </div>
                                <div class="project-content d-grid align-items-center text-center">
                                    <h5 class="mb-0">{{ __('messages.invoice') }}: {{ $data['totalInvoice'] }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Customer Card -->
                <div class="col-xl-2 col-lg-2 col-md-2 col-4">
                    <div class="card square-card overflow-hidden short-card">
                        <div class="card-body pb-2">
                            <a href="{{ route('user.client.create') }}" class="card-overlay"><i class="fas fa-plus mx-0"></i></a>
                            <div>
                                <div class="d-flex align-items-center justify-content-center">
                                    <img src="{{ asset('dashboard/img/icon/customer.png') }}" alt="" class="ht-70 wd-70 my-auto rounded-lg">
                                </div>
                                <div class="project-content d-grid align-items-center text-center">
                                    <h5 class="mb-0">{{ __('messages.customer') }}: {{ $data['totalClient'] }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Purchase Card -->
                <div class="col-xl-2 col-lg-2 col-md-2 col-4">
                    <div class="card square-card overflow-hidden short-card">
                        <div class="card-body pb-2">
                            <a href="{{ route('user.purchase.create') }}" class="card-overlay"><i class="fas fa-plus mx-0"></i></a>
                            <div>
                                <div class="d-flex align-items-center justify-content-center">
                                    <img src="{{ asset('dashboard/img/icon/invoice.png') }}" alt="" class="ht-70 wd-70 my-auto rounded-lg">
                                </div>
                                <div class="project-content d-grid align-items-center text-center">
                                    <h5 class="mb-0">{{ __('messages.purchase') }}: {{ $data['totalPurchase'] }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Supplier Card -->
                <div class="col-xl-2 col-lg-2 col-md-2 col-4">
                    <div class="card square-card overflow-hidden short-card">
                        <div class="card-body pb-2">
                            <a href="{{ route('user.supplier.create') }}" class="card-overlay"><i class="fas fa-plus mx-0"></i></a>
                            <div>
                                <div class="d-flex align-items-center justify-content-center">
                                    <img src="{{ asset('dashboard/img/icon/customer.png') }}" alt="" class="ht-70 wd-70 my-auto rounded-lg">
                                </div>
                                <div class="project-content d-grid align-items-center text-center">
                                    <h5 class="mb-0">{{ __('messages.supplier') }}: {{ $data['totalSupplier'] }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Receive Card -->
                <div class="col-xl-2 col-lg-2 col-md-2 col-4">
                    <div class="card square-card overflow-hidden short-card">
                        <div class="card-body pb-2">
                            <a href="{{ route('user.receive.index') }}?create" class="card-overlay"><i class="fas fa-plus mx-0"></i></a>
                            <div>
                                <div class="d-flex align-items-center justify-content-center">
                                    <img src="{{ asset('dashboard/img/icon/receive.png') }}" alt="" class="ht-70 wd-70 my-auto rounded-lg">
                                </div>
                                <div class="project-content d-grid align-items-center text-center">
                                    <h5 class="mb-0">{{ __('messages.receive') }}: {{ $data['totalReceive'] }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Expense Card -->
                <div class="col-xl-2 col-lg-2 col-md-2 col-4">
                    <div class="card square-card overflow-hidden short-card">
                        <div class="card-body pb-2">
                            <a href="{{ route('user.expense.index') }}?create-expense" class="card-overlay"><i class="fas fa-plus mx-0"></i></a>
                            <div>
                                <div class="d-flex align-items-center justify-content-center">
                                    <img src="{{ asset('dashboard/img/icon/expense.png') }}" alt="" class="ht-70 wd-70 my-auto rounded-lg">
                                </div>
                                <div class="project-content d-grid align-items-center text-center">
                                    <h5 class="mb-0">{{ __('messages.expense') }}: {{ $data['totalExpense'] }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- User Card -->
                <div class="col-xl-2 col-lg-2 col-md-2 col-4">
                    <div class="card square-card overflow-hidden short-card">
                        <div class="card-body pb-2">
                            <a href="{{ route('user.staff.create') }}?user" class="card-overlay"><i class="fas fa-plus mx-0"></i></a>
                            <div>
                                <div class="d-flex align-items-center justify-content-center">
                                    <img src="{{ asset('dashboard/img/icon/user.png') }}" alt="" class="ht-70 wd-70 my-auto rounded-lg">
                                </div>
                                <div class="project-content d-grid align-items-center text-center">
                                    <h5 class="mb-0">{{ __('messages.user') }}: {{ $data['totalUser'] }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Staff Card -->
                <div class="col-xl-2 col-lg-2 col-md-2 col-4">
                    <div class="card square-card overflow-hidden short-card">
                        <div class="card-body pb-2">
                            <a href="{{ route('user.staff.create') }}" class="card-overlay"><i class="fas fa-plus mx-0"></i></a>
                            <div>
                                <div class="d-flex align-items-center justify-content-center">
                                    <img src="{{ asset('dashboard/img/icon/staff.png') }}" alt="" class="ht-70 wd-70 my-auto rounded-lg">
                                </div>
                                <div class="project-content d-grid align-items-center text-center">
                                    <h5 class="mb-0">{{ __('messages.staff') }}: {{ $data['totalStaff'] ?? 0 }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Staff Card -->
                <div class="col-xl-2 col-lg-2 col-md-2 col-4">
                    <div class="card square-card overflow-hidden short-card">
                        <div class="card-body pb-2">
                            <a href="{{ route('user.order.index') }}?requested" class="card-overlay"><i class="fas fa-plus mx-0"></i></a>
                            <div>
                                <div class="d-flex align-items-center justify-content-center">
                                    <img src="{{ asset('dashboard/img/order22.png') }}" alt="" class="ht-70 wd-70 my-auto rounded-lg">
                                </div>
                                <div class="project-content d-grid align-items-center text-center">
                                    <h5 class="mb-0">{{ __('messages.requested') }} {{ __('messages.order') }}: {{ $data['totalOrder']->where('order_status', 0)->count() ?? 0 }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-2 col-md-2 col-4">
                    <div class="card square-card overflow-hidden short-card">
                        <div class="card-body pb-2">
                            <a href="{{ route('user.order.index') }}?placed" class="card-overlay"><i class="fas fa-plus mx-0"></i></a>
                            <div>
                                <div class="d-flex align-items-center justify-content-center">
                                    <img src="{{ asset('dashboard/img/order22.png') }}" alt="" class="ht-70 wd-70 my-auto rounded-lg">
                                </div>
                                <div class="project-content d-grid align-items-center text-center">
                                    <h5 class="mb-0">{{ __('messages.placed') }} {{ __('messages.order') }}: {{ $data['totalOrder']->where('order_status', 1)->count() ?? 0 }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-2 col-md-2 col-4">
                    <div class="card square-card overflow-hidden short-card">
                        <div class="card-body pb-2">
                            <a href="{{ route('user.order.index') }}?process" class="card-overlay"><i class="fas fa-plus mx-0"></i></a>
                            <div>
                                <div class="d-flex align-items-center justify-content-center">
                                    <img src="{{ asset('dashboard/img/order22.png') }}" alt="" class="ht-70 wd-70 my-auto rounded-lg">
                                </div>
                                <div class="project-content d-grid align-items-center text-center">
                                    <h5 class="mb-0">{{ __('messages.process') }} {{ __('messages.order') }}: {{ $data['totalOrder']->where('order_status', 2)->count() ?? 0 }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-2 col-md-2 col-4">
                    <div class="card square-card overflow-hidden short-card">
                        <div class="card-body pb-2">
                            <a href="{{ route('user.order.index') }}?delivered" class="card-overlay"><i class="fas fa-plus mx-0"></i></a>
                            <div>
                                <div class="d-flex align-items-center justify-content-center">
                                    <img src="{{ asset('dashboard/img/order22.png') }}" alt="" class="ht-70 wd-70 my-auto rounded-lg">
                                </div>
                                <div class="project-content d-grid align-items-center text-center">
                                    <h5 class="mb-0">{{ __('messages.delivered') }} {{ __('messages.order') }}: {{ $data['totalOrder']->where('order_status', 3)->count() ?? 0 }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-2 col-md-2 col-4">
                    <div class="card square-card overflow-hidden short-card">
                        <div class="card-body pb-2">
                            <a href="{{ route('user.order.index') }}?rejected" class="card-overlay"><i class="fas fa-plus mx-0"></i></a>
                            <div>
                                <div class="d-flex align-items-center justify-content-center">
                                    <img src="{{ asset('dashboard/img/order22.png') }}" alt="" class="ht-70 wd-70 my-auto rounded-lg">
                                </div>
                                <div class="project-content d-grid align-items-center text-center">
                                    <h5 class="mb-0">{{ __('messages.rejected') }} {{ __('messages.order') }}: {{ $data['totalOrder']->where('order_status', 4)->count() ?? 0 }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if (config('products_show_stock_warning') == 1 || config('client.remaining_due_date') == 1)
            @include('layouts.user.stock-modal')
        @endif
    @endcan
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $("#stockModal").modal("show");
        });
    </script>
@endpush
