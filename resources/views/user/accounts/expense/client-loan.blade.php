@extends('layouts.user.app', ['pageTitle' => $pageTitle])
<style>
    #file-export-datatable_wrapper .dt-buttons {
        position: relative !important;
    }
</style>
@section('content')
    <div class="main-content-body">
        <div class="card">
            <div class="card-body">
                <div class="collapse mg-t-5" id="addReceiveCollapse">
                    <p class="display-6 text-center">{{ __('Client Loan') }}</p>
                    <form action="{{ route('user.account.store') }}" method="post">
                        @csrf
                        <div class="card">
                            <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                                <p class="card-title my-0">{{ $pageTitle }}</p>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-xl-6 col-lg-6 col-md-6">
                                        <div class="d-flex">
                                            <span class="input-group-text" title="customer" id="basic-addon1"><i class="fas fa-user-tie"></i></span>
                                            <div class="input-group">
                                                <select name="customer" class="form-control select2">
                                                    <option value="customer"> Customer</option>
                                                    <option value="no_result_found">No results Found</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-xl-6 col-lg-6 col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-text" title="Date"><i class="typcn typcn-calendar-outline tx-24 lh--9 op-6"></i></span>
                                            <input class="form-control fc-datepicker" name="date" placeholder="MM/DD/YYYY" type="text" autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="form-group col-xl-6 col-lg-6 col-md-6">
                                        <div class="d-flex">
                                            <span class="input-group-text" title="Account" id="basic-addon1"><i class="fas fa-university" title="Account"></i></span>
                                            <div class="input-group">
                                                <select name="account_id" class="form-control select2">
                                                    <option label="Choose Account">Select Account</option>
                                                    <option value="islam">Islami Bank</option>
                                                    <option value="islam">Mostafizur Rahman</option>
                                                    <option value="islam">Mostafizur Rahman</option>
                                                </select>
                                            </div>
                                            <a data-bs-target="#accountModal" data-bs-toggle="modal" class="add-to-cart btn btn-success d-flex text-aligns-center" type="button" href="javascript:;"><i class="fas fa-plus"></i></a>
                                        </div>
                                    </div>
                                    <div class="form-group col-xl-6 col-lg-6 col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-text" title="Amount" id="basic-addon1"><i class="fas fa-coins" title="Amount"></i></span>
                                            <input type="number" class="form-control" name="amount" placeholder="Amount">
                                        </div>
                                    </div>
                                    <div class="form-group col-xl-6 col-lg-6 col-md-6">
                                        <div class="d-flex">
                                            <span class="input-group-text" title="Supplier" id="basic-addon1"><i class="fas fa-user-tie"></i></span>
                                            <div class="input-group">
                                                <select name="status" class="form-control select2">
                                                    <option label="Choose Expense Category">Select Supplier</option>
                                                    <option value="1">Jahid</option>
                                                    <option value="1">Ashik</option>
                                                    <option value="1">Ms internation : Shemul</option>
                                                    <option value="0">Deactive</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group col-xl-6 col-lg-6 col-md-6">
                                        <div class="d-flex">
                                            <span class="input-group-text" title="chart_of_account" id="basic-addon1"><i class="fas fa-th-list" title="chart_of_account"></i></span>
                                            <div class="input-group">
                                                <select name="chart_of_account" class="form-control select2">
                                                    <option value="islam">Chart Of Account</option>
                                                    <option value="islam">No results Found</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group col-xl-6 col-lg-6 col-md-6">
                                        <div class="d-flex">
                                            <span class="input-group-text" title="chart_of_account_group" id="basic-addon1"><i class="fas fa-th-list" title="chart_of_account_group"></i></span>
                                            <div class="input-group">
                                                <select name="chart_of_account_group" class="form-control select2">
                                                    <option value="chart_of_account_group">Chart Of Account Group</option>
                                                    <option value="no_result_fount">No results Found</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-xl-6 col-lg-6 col-md-6">
                                        <div class="d-flex">
                                            <span class="input-group-text" title="Expense Category" id="basic-addon1"><i class="fas fa-certificate" title="Expense Category"></i></span>
                                            <div class="input-group">
                                                <select name="category_id" class="form-control select2">
                                                    <option label="Choose Expense Category">Select Expense Category</option>
                                                    <option value="islam">abc</option>
                                                    <option value="hinduism">abc1</option>
                                                    <option value="buddhism">abc2</option>
                                                    <option value="christianity">abc3</option>
                                                </select>
                                            </div>
                                            <a data-bs-target="#expense_category_Modal" data-bs-toggle="modal" class="add-to-cart btn btn-success d-flex text-aligns-center" type="button" href="javascript:;"><i class="fas fa-plus"></i></a>
                                        </div>
                                    </div>
                                    <div class="form-group col-xl-6 col-lg-6 col-md-6">
                                        <div class="d-flex">
                                            <span class="input-group-text" title="Expense Sub Category" id="basic-addon1"><i class="fas fa-caret-square-up" title="Expense Category"></i></span>
                                            <div class="input-group">
                                                <select name="subcategory_id" class="form-control select2">
                                                    <option label="Choose Expense Subcategory">Select Subcategory</option>
                                                    <option value="islam">sucategory 1</option>
                                                    <option value="hinduism">subcategory 2</option>
                                                    <option value="buddhism">subcategory 3</option>
                                                    <option value="christianity">subcategory 4</option>
                                                </select>
                                            </div>
                                            <a data-bs-target="#expense_sub_Modal" data-bs-toggle="modal" class="add-to-cart btn btn-success d-flex text-aligns-center" type="button" href="javascript:;"><i class="fas fa-plus"></i></a>
                                        </div>
                                    </div>
                                    <div class="form-group col-xl-6 col-lg-6 col-md-6">
                                        <div class="d-flex">
                                            <span class="input-group-text" title="Payment" id="basic-addon1"><i class="fas fa-money-check" title="Payment"></i></span>
                                            <div class="input-group">
                                                <select name="payment" class="form-control select2">
                                                    <option label="Choose Payment">Select Payment</option>
                                                    <option value="islam">cash</option>
                                                    <option value="hinduism">bkash</option>
                                                    <option value="buddhism">nagad</option>
                                                    <option value="christianity">amarpay</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-xl-6 col-lg-6 col-md-6">
                                        <div class="d-flex">
                                            <span class="input-group-text" title="Bank" id="basic-addon1"><i class="fas fa-money-check" title="Bank"></i></span>
                                            <div class="input-group">
                                                <select name="bank" class="form-control select2">
                                                    <option label="Choose Bank">Select Bank</option>
                                                    <option value="islam">Islami Bank</option>
                                                    <option value="hinduism">Bank Asia</option>
                                                    <option value="buddhism">DBBL</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-xl-6 col-lg-6 col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-text" title="Checkout No" id="basic-addon1"><i class="fas fa-bars" title="Checkout No"></i></span>
                                            <input type="text" class="form-control" name="checkout_no" placeholder="Checkout No">
                                        </div>
                                    </div>

                                    <div class="form-group col-xl-6 col-lg-6 col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-text" title="Description"><i class="typcn typcn-calendar-outline tx-24 lh--9 op-6"></i></span>
                                            <textarea name="description" class="form-control" id="" cols="5" rows="1" placeholder="Description"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group col-xl-6 col-lg-6 col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-text" title="Name"><i class="fas fa-user-tie" title="Name"></i></span>
                                            <input type="file" accept="image/*" name="image" class="form-control image" placeholder="" id="image">
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-lg-6 col-md-6 col-sm-12 mt-3 d-flex justify-content-center">
                                        <a aria-controls="addReceiveCollapse" aria-expanded="false" class="btn ripple btn-dark me-2" data-bs-toggle="collapse" href="#addReceiveCollapse" role="button">Close</a>
                                        <button type="submit" class="add-to-cart btn btn-primary">Add Client Loan</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="row row-sm">
                    <div class="card">
                        <div class="card-body bg-white table-responsive">
                            <div class="text-end">
                                <div class="d-flex justify-content-between align-items-center">
                                    <p class="text-center h3 font-weight-light">{{ $pageTitle }}</p>
                                    <a aria-controls="addReceiveCollapse" aria-expanded="false" class="btn ripple btn-success mb-2" data-bs-toggle="collapse" href="#addReceiveCollapse" role="button"><i class="fas fa-plus"></i> Client Loan</a>
                                </div>
                            </div>
                            {!! $dataTable->table() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- @include('user.accounts.receive.client-add-modal')
    @include('user.accounts.account.account-modal')
    @include('user.accounts.receive.income-category-modal') --}}
@endsection

@push('scripts')
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
    <script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
    <script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
    {!! $dataTable->scripts() !!}

    <script>
        function destroy(id) {
            console.log(id);
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    var data_id = id;
                    var url = '{{ route('user.staff.destroy', ':id') }}';
                    url = url.replace(':id', data_id);
                    $.ajax({
                        type: "GET",
                        dataType: "json",
                        url: url,
                        success: function(data) {
                            $('#file-export-datatable').DataTable().ajax.reload();
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'error',
                                title: 'Payment deleted successfully!',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    });
                }
            })
        }
    </script>
@endpush
