@extends('layouts.user.app')
@section('content')
    @php
        $route = Request::is('user/supplier/cheque/schedule/edit/*');
    @endphp
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"></div>
                <div class="card-body">
                    <form action="{{ $route ? route('user.cheque.schudule.update', $data->id) : route('user.cheque.schudule.store') }}" method="POST">
                        @csrf
                        @if ($route)
                            @method('PUT')
                        @endif
                        <div class="row">
                            <div class="col-xl-4 col-lg-6 col-md-6">
                                <div class="form-group">
                                    <input id="date" type="text" class="form-control fc-datepicker @error('date') is-invalid @enderror" placeholder="MM/DD/YYYY" name="date" value="{{ $route ? enTobnDate($data->date) : old('date') }}">
                                    <label class="animated-label {{ $route ? 'active-label' : '' }}" for=""><i class="fas fa-user"></i> {{ __('messages.date') }}</label>
                                    @error('date')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-6 col-md-6">
                                <div class="d-flex form-group mb-0" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.supplier') }}">
                                    <div class="input-group">
                                        <select name="supplier_id" id="supplier_id" class="form-control select2">
                                        </select>
                                    </div>
                                    <a id="supplierAddModalBtn" class="add-btn btn btn-success" href="javascript:;"><i class="fas fa-plus"></i></a>
                                </div>
                                <span class="text-danger small" id="supplier_id_Error"></span>
                                @error('supplier_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-xl-4 col-lg-6 col-md-6">
                                <div class="form-group">
                                    <input id="bank" type="text" class="form-control @error('bank_name') is-invalid @enderror" name="bank_name" value="{{ $route ? $data->bank_name : old('bank_name') }}">
                                    <label class="animated-label {{ $route ? 'active-label' : '' }}" for="bank_name"><i class="fas fa-user"></i> {{ __('messages.bank') }} {{ __('messages.name') }}</label>
                                    @error('bank_name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-6 col-md-6 mt-4">
                                <div class="form-group">
                                    <input id="" type="text" class="form-control @error('cheque_no') is-invalid @enderror" name="cheque_no" value="{{ $route ? $data->cheque_no : old('cheque_no') }}">
                                    <label class="animated-label {{ $route ? 'active-label' : '' }}" for="cheque"><i class="fas fa-user"></i> {{ __('messages.cheque') }} {{ __('messages.number') }}</label>
                                    @error('cheque_no')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-6 col-md-6 mt-4">
                                <div class="form-group">
                                    <input id="" type="text" class="form-control @error('amount') is-invalid @enderror" name="amount" value="{{ $route ? $data->amount : old('amount') }}">
                                    <label class="animated-label {{ $route ? 'active-label' : '' }}" for=""><i class="fas fa-user"></i> {{ __('messages.amount') }}</label>
                                    @error('amount')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4 justify-content-center">
                            <div class="col-md-6">
                                @if ($route)
                                    <button class="btn mx-1 btn-success btn-block" type="submit">{{ __('messages.update') }}</button>
                                @else
                                    <button class="btn mx-1 btn-success btn-block" type="submit">{{ __('messages.add') }}</button>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('user.supplier.supplier-add-modal')
@endsection
@push('scripts')
    @php
        $supplier_id = $_GET['supplier_id'] ?? 0;
    @endphp
    <script src="{{ asset('dashboard/js/select2-fetch.js') }}"></script>
    <script src="{{ asset('dashboard/js/append.js') }}"></script>
    @include('user.purchase.purchase-js')
    <script>
        $(document).ready(function() {
            $("#date").datepicker();

            getSupplierInfo('/get-supplier-info', "{{ $route ? $data->supplier_id : $supplier_id }}");
        });
    </script>
@endpush
