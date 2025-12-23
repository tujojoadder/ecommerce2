@extends('layouts.user.app', ['pageTitle' => $pageTitle])
@section('content')
    @php
        $queryString = $_SERVER['QUERY_STRING'];
    @endphp
    <div class="main-content-body">
        <div class="card mb-5 pb-5">
            <div class="card-header border-bottom d-flex justify-content-between">
                <div>
                    <h6 class="card-title my-0" id="addInvoiceText">{{ __('messages.purchase') }} {{ __('messages.create') }}</h6>
                    <h6 class="card-title d-none" id="updateInvoiceText">{{ __('messages.update') }} {{ __('messages.purchase') }} | {{ __('messages.id_no') }}: <span id="voucher_no"></span></h6>
                </div>
                <div>
                    <a data-bs-target="#formSettingModal" data-bs-toggle="modal" class="btn btn-secondary text-white me-2 d-flex align-items-center">
                        <i class="fas fa-cog d-inline"></i>
                    </a>
                </div>
            </div>
            <div class="card-body">
                {{-- form field start --}}
                <div class="row justify-content-between" id="invoice-form">
                    <div class="{{ config('purchases_invoice_id') == 1 ? '' : 'd-none' }} mb-1 col-md-4">
                        <div class="form-group">
                            <input id="invoice_id" type="number" name="invoice_id" readonly class="form-control" value="{{ $purchase->invoice_id }}" placeholder="Invoice Id">
                            <label for="invoice_id" class="animated-label active-label"><i class="fas fa-list-ol"></i> {{ __('messages.invoice') }} {{ __('messages.id_no') }}</label>
                        </div>
                    </div>
                    <div class="{{ config('purchases_issued_date') == 1 ? '' : 'd-none' }} col-md-4">
                        <div class="form-group">
                            <input name="issued_date" id="issued_date" class="form-control fc-datepicker" placeholder="MM/DD/YYYY" value="{{ date('d/m/Y') }}" type="text" autocomplete="off">
                            <label class="animated-label active-label" for="issued_date"><i class="fas fa-balance-scale"></i> {{ __('messages.date') }}</label>
                        </div>
                        <span class="text-danger small" id="issued_date_Error"></span>
                    </div>
                    @if (config('sidebar.warehouse') == 1)
                        <div class="{{ config('purchases_warehouse_id') == 1 ? '' : 'd-none' }} form-group mb-1 col-md-4">
                            <div class="d-flex" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.ware_house') }}">
                                <div class="input-group">
                                    <select name="warehouse_id" id="warehouse_id" class="form-control select2"></select>
                                </div>
                                <a id="warehouseAddModalBtn" class="add-btn btn btn-success" href="javascript:;"><i class="fas fa-plus"></i></a>
                            </div>
                            <span class="text-danger small" id="warehouse_id_Error"></span>
                        </div>
                    @endif
                    <div class="form-group mb-4 col-md-4">
                        <div class="d-flex" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.product') }} {{ __('messages.name') }}">
                            <div class="input-group">
                                <select id="product_search" class="form-control select2">
                                </select>
                            </div>
                            <a id="productAddModalBtn" class="add-btn btn border disabled" href="javascript:;">{{-- <iclass="fasfa-plus"></i> --}}</a>
                        </div>
                    </div>
                    <div class="{{ config('purchases_supplier_id') == 1 ? '' : 'd-none' }} form-group mb-3 col-md-4">
                        <div class="d-flex" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.supplier') }}">
                            <div class="input-group">
                                <select name="supplier_id" id="supplier_id" class="supplier_id form-control select2">
                                </select>
                            </div>
                            <a id="supplierAddModalBtn" class="add-btn btn btn-success" href="javascript:;"><i class="fas fa-plus"></i></a>
                        </div>
                        <span class="text-danger small" id="supplier_id_Error"></span>
                    </div>

                    <div class="col-12 mb-4 table-responsive">
                        <table class="table table-secondary" id="order_table">
                            <thead>
                                <th class="py-2 text-center">{{ __('messages.sl') }}</th>
                                <th class="py-2 text-center">{{ __('messages.product') }}</th>
                                <th class="py-2 text-center">{{ __('messages.quantity') }}</th>
                                @if ($purchase->status == 4)
                                    <th class="py-2 text-center">{{ __('messages.return') }} {{ __('messages.type') }}</th>
                                @endif
                                <th class="py-2 text-center">{{ __('messages.buying') }} {{ __('messages.price') }}</th>
                                <th class="py-2 text-center">{{ __('messages.total') }} {{ __('messages.buying') }} {{ __('messages.price') }}</th>
                                <th class="py-2 text-center">{{ __('messages.sale') }} {{ __('messages.price') }}</th>
                                <th class="py-2 text-center">{{ __('messages.total') }} {{ __('messages.sale') }} {{ __('messages.price') }}</th>
                                <th class="py-2 text-center">{{ __('messages.wholesale_price') }}</th>
                                <th class="py-2 text-center">{{ __('messages.unit') }}</th>
                                <th class="py-2 text-center">{{ __('messages.description') }}</th>
                                <th class="py-2 text-center">{{ __('messages.barcode') }}</th>
                                <th class="py-2 text-center">{{ __('messages.action') }}</th>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6 ps-0">
                        <div class="{{ config('purchases_discount') == 1 ? '' : 'd-none' }} form-group mb-0 col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input name="discount" id="discount" class="form-control clear-input" placeholder="{{ __('messages.discount') }}" value="0" type="number" min="0" max="100" autocomplete="off">
                                        <label class="animated-label active-label" for="discount"><i class="fas fa-balance-scale"></i> {{ __('messages.discount') }}</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select name="discount_type" id="discount_type" class="form-control SelectBox" required>
                                            <option label="Flat"></option>
                                            <option value="percentage" selected>{{ __('messages.percentage') }} (%)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <span class="text-danger small" id="discount_Error"></span>
                        </div>

                        <div class="{{ config('purchases_transport_fare') == 1 ? '' : 'd-none' }} col-md-12">
                            <div class="form-group">
                                <input name="transport_fare" id="transport_fare" class="form-control clear-input" placeholder="{{ __('messages.transport_fare') }}" value="0" min="0" type="number">
                                <label class="animated-label active-label" for="transport_fare"><i class="fas fa-balance-scale"></i> {{ __('messages.transport_fare') }}</label>
                            </div>
                            <span class="text-danger small" id="transport_fare_Error"></span>
                        </div>

                        <div class="{{ config('purchases_vat') == 1 ? '' : 'd-none' }} form-group mb-0 col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input name="vat" id="vat" class="form-control clear-input" placeholder="{{ __('messages.vat') }}" value="0" type="text" autocomplete="off">
                                        <label class="animated-label active-label" for="vat"><i class="fas fa-balance-scale"></i> {{ __('messages.vat') }}</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select name="vat_type" id="vat_type" class="form-control SelectBox" required>
                                            <option label="Flat"></option>
                                            <option value="percentage" selected>{{ __('messages.percentage') }} (%)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <span class="text-danger small" id="vat_Error"></span>
                        </div>

                        <div class="{{ config('purchases_account_id') == 1 ? '' : 'd-none' }} form-group mb-4 col-md-12">
                            <div class="d-flex" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.account') }}">
                                <div class="input-group">
                                    <select name="account_id" id="account_id" class="form-control select2 account_id"></select>
                                </div>
                                <a id="accountAddModalBtn" class="add-btn btn btn-success" type="button" href="javascript:;"><i class="fas fa-plus"></i></a>
                            </div>
                            <span class="text-danger small" id="account_id_Error"></span>
                        </div>

                        <div class="{{ config('purchases_category_id') == 1 ? '' : 'd-none' }} form-group mb-4 col-md-12">
                            <div class="d-flex" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.expense') . ' ' . __('messages.category') }}">
                                <div class="input-group">
                                    <select name="category_id" id="expense_category_id" class="form-control select2"></select>
                                </div>
                                <a id="expenseCategoryAddModalBtn" class="add-btn btn btn-success" type="button" href="javascript:;"><i class="fas fa-plus"></i></a>
                            </div>
                            <span class="text-danger small" id="expense_category_id_Error"></span>
                        </div>

                        <div class="{{ config('purchases_receive_amount') == 1 ? '' : 'd-none' }} col-md-12">
                            <div class="form-group">
                                <input name="receive_amount" id="receive_amount" class="form-control clear-input" value="0" min="0" type="number" step="any" autocomplete="off" placeholder="{{ __('messages.payment') }} {{ __('messages.amount') }}">
                                <label class="animated-label active-label" for="receive_amount"><i class="fas fa-balance-scale"></i> {{ __('messages.payment') }} {{ __('messages.amount') }}</label>
                            </div>
                            <span class="text-danger small" id="receive_amount_Error"></span>
                        </div>

                        <input type="hidden" id="pucrhased_row_id">
                    </div>
                    <div class="col-md-4">
                        <table class="table table-borderless">
                            <tr class="border">
                                <td width="50%">{{ __('messages.total') }}</td>
                                <td width="1%">:</td>
                                <td width="50"><input class="form-control from-control-sm bg-white border-0 purchase_bill" id="purchase_bill" name="purchase_bill" readonly value="0"></td>
                            </tr>
                            <tr class="border">
                                <td width="50%">{{ __('messages.vat') }}</td>
                                <td width="1%">:</td>
                                <td width="50"><input class="form-control from-control-sm bg-white border-0 total_vat" id="total_vat" name="total_vat" readonly value="0"></td>
                            </tr>
                            <tr class="border">
                                <td width="50%">{{ __('messages.transport_fare') }}</td>
                                <td width="1%">:</td>
                                <td width="50"><input class="form-control from-control-sm bg-white border-0 transport_fare" readonly value="0"></td>
                            </tr>
                            <tr class="border">
                                <td width="50%">{{ __('messages.discount') }}</td>
                                <td width="1%">:</td>
                                <td width="50"><input class="form-control from-control-sm bg-white border-0 total_discount" id="total_discount" name="total_discount" readonly value="0"></td>
                            </tr>

                            <tr class="border">
                                <td width="50%">{{ __('messages.grand_total') }}</td>
                                <td width="1%">:</td>
                                <td width="50"><input class="form-control from-control-sm bg-white border-0 grand_total" id="grand_total" name="grand_total" readonly value="0"></td>
                            </tr>
                            <tr class="border">
                                <td width="50%">{{ __('messages.payment') }}</td>
                                <td width="1%">:</td>
                                <td width="50"><input class="form-control from-control-sm bg-white border-0 total_payment" readonly value="0"></td>
                            </tr>
                            <tr class="border">
                                <td width="50%">{{ __('messages.total') }} {{ __('messages.due') }}</td>
                                <td width="1%">:</td>
                                <td width="50"><input class="form-control from-control-sm bg-white border-0 total_due" id="total_due" name="total_due" readonly value="0"></td>
                            </tr>
                        </table>
                    </div>
                </div>
                {{-- form field end --}}
            </div>
            <div class="card-body d-flex justify-content-between fixed-bottom bg-white border rounded-0" id="button-group">
                <button class="btn me-1 btn-danger" data-bs-toggle="collapse" data-bs-target="#invoiceCollapse" aria-expanded="false" aria-controls="invoiceCollapse" type="button"><i class="fas fa-ban"></i> {{ __('messages.cancel') }}</button>
                <button class="btn mx-1 btn-success" type="button" id="addInvoice" onclick="addInvoice();"><i class="fas fa-plus"></i> {{ __('messages.add') }}</button>
                <button class="btn ms-1 btn-info d-none" type="button" id="updateInvoice" onclick="updateInvoice();"><i class="fas fa-plus"></i> {{ __('messages.update') }}</button>
            </div>
        </div>
    </div>
    @include('user.accounts.account.account-modal')
    @include('user.accounts.expense.expense-category-modal')
    @include('user.supplier.supplier-add-modal')
    @include('user.purchase.form-setting-modal')
@endsection
@push('scripts')
    @include('user.purchase.purchase-js')
    <script src="{{ asset('dashboard/js/append.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Initialize the row count based on the existing number of rows
            var rowCount = $("#order_table tbody tr").length + 1;

            // Add Row button click event
            $(document).on("change", "#product_search", function() {
                rowCount++;
                // Update row IDs
                updateRowIds();
            });

            // Delete Row button click event
            $(document).on("click", ".delete-row", function() {
                var row = $(this).closest("tr");
                var rowId = row.find("input[name='row_id']").val();
                row.remove();

                updateRowIds();
            });

            function updateRowIds() {
                $("#order_table tbody tr").each(function(index) {
                    $(this).find("input[name='row_id']").val(index + 1);
                });
            }
        });
        setTimeout(() => {
            edit("{{ $purchase->id }}");
        }, 500);
        // edit client using ajax
        function edit(id) {
            var data_id = id;
            var url = '{{ route('user.purchase.edit', ':id') }}';
            url = url.replace(':id', data_id);
            $.ajax({
                type: "GET",
                dataType: "json",
                url: url,
                success: function(data) {
                    // adding the data to fields
                    getSupplierInfo('/get-supplier-info', data.supplier_id);
                    $('#supplier_id').val(data.supplier_id).trigger('change');
                    getAccountInfo('/get-account', data.account_id);
                    getExpenseCategoryInfo('/get-expense-category', data.category_id);

                    var invoice_id = $('#invoice_id').val(data.invoice_id);
                    var issued_date = $('#issued_date').val(data.issued_date);
                    var warehouse_id = $('#warehouse_id').val(data.warehouse_id).trigger('change');
                    var discount = $('#discount').val(data.discount);
                    var discount_type = $('#discount_type').val(data.discount_type);
                    var transport_fare = $('#transport_fare').val(data.transport_fare);
                    var vat = $('#vat').val(data.vat);
                    var vat_type = $('#vat_type').val(data.vat_type);
                    var account_id = $('#account_id').val(data.account_id).trigger('change');
                    var category_id = $('#expense_category_id').val(data.category_id).trigger('change');
                    var receive_amount = $('#receive_amount').val(data.receive_amount);
                    var purchase_bill = $('#purchase_bill').val(data.purchase_bill);
                    var total_vat = $('#total_vat').val(data.total_vat);
                    var total_discount = $('#total_discount').val(data.total_discount);
                    var grand_total = $('#grand_total').val(data.grand_total);
                    var total_due = $('#total_due').val(data.total_due);

                    var items = data.purchased_items;
                    var html = '';
                    var unit = data.unit ?? 0;
                    $.each(items, function(index, value) {
                        html += "<tr>";
                        html += "<input type='hidden' value='" + value.id + "' name='id[]'>";
                        html += "<td class='py-1' width='3%'><input type='text' class='form-control fcsm bg-white text-center' name='row_id[]' value='" + value.row_id + "' readonly></td>";
                        html += "<td class='py-1'><input type='text' class='form-control fcsm purchase-name' value='" + value.product.name + "' readonly><input type='hidden' value='" + value.product_id + "' name='product_id[]'></td>";
                        html += "<td class='py-1'><input type='number' step='any' class='form-control fcsm quantity' value='" + value.quantity + "' name='quantity[]'></td>";
                        if (value.status == 4) {
                            html += "<td><select class='form-control text-dark rounded form-control-sm select2-tags' name='return_type[]'>";
                            html += "<option value='exchange' " + (value.return_type == 'exchange' ? 'selected' : '') + ">Exchange</option>";
                            html += "<option value='damage' " + (value.return_type == 'damage' ? 'selected' : '') + ">Damage</option>";
                            html += "<option value='expired' " + (value.return_type == 'expired' ? 'selected' : '') + ">Expired</option>";
                            html += "</select></td>";
                        }

                        html += "<td class='py-1'><input type='number' class='form-control fcsm purchase-buying_price' value='" + value.buying_price + "' name='buying_price[]'></td>";
                        html += "<td class='py-1'><input type='number' class='form-control fcsm cal_buying_total' value='" + value.total_buying_price + "' name='total_buying_price[]'></td>";
                        html += "<td class='py-1'><input type='number' class='form-control fcsm purchase-selling_price' value='" + value.selling_price + "' name='selling_price[]'></td>";
                        html += "<td class='d-none'><input type='hidden' step='any' class='form-control fcsm free' value='0' name='free[]'></td>";
                        html += "<td class='py-1'><input type='number' class='form-control fcsm cal_selling_total' readonly value='" + value.total_selling_price + "' name='total_selling_price[]'></td>";
                        html += "<td><input type='text' class='form-control fcsm wholesale_price' value='" + value.wholesale_price + "' name='wholesale_price[]'></td>";
                        html += "<td class='py-1'><input type='text' class='form-control fcsm text-center bg-white purchase-unit' value='" + value.unit_name + "' readonly><input type='hidden' value='" + value.unit_id + "' name='unit_id[]'></td>";
                        html += "<td class='py-1'><input type='text' class='form-control fcsm purchase-description' value='" + value.description + "' name='description[]'></td>";
                        html += "<td class='py-1 text-center'><a target='_blank' href='{{ route('user.product-barcode.index') }}?product_id=" + value.product_id + "&quantity=1' class='btn btn-sm btn-dark py-1'><i class='fas fa-qrcode' style='font-size: 15px !important;'></i></a><input type='hidden' class='form-control fcsm' value='" + data.id + "' name='barcode_id[]'></td>";
                        html += "<td class='py-1 text-center'><a href='javascript:;' class='btn btn-danger btn-sm p-1' id='delete" + value.id + "' onclick='destroyItem(" + value.id + ");'><i class='fas fa-trash'></i></a></td>";
                        html += "</tr>";
                    });
                    $('#order_table tbody').html(html);

                    $('#total_discount').val(data.total_discount)
                    $('#purchase_bill').val(data.purchase_bill)
                    $('#previous_due').val(data.previous_due)
                    $('#total_vat').val(data.total_vat)
                    $('#grand_total').val(data.grand_total)
                    $('#total_due').val(data.total_due)

                    $('#pucrhased_row_id').val(data.id);
                    $('.purchase-buying_price').keyup();
                    $('#receive_amount').keyup();
                    // adding the data to fields

                    // hide show btn
                    $('#addInvoiceText').addClass('d-none');
                    $('#updateInvoiceText').removeClass('d-none');
                    $('#voucher_no').text(data.id);
                    $('#addInvoice').addClass('d-none');
                    $('#updateInvoice').removeClass('d-none');
                    // hide show btn

                    // modal show when edit button is clicked
                    $("#addInvoiceModal").modal("show");
                    // modal show when edit button is clicked

                    $('.select2-tags').select2({
                        tags: true
                    });
                },
                error: function(error) {
                    Swal.fire({
                        position: 'top-center',
                        icon: 'error',
                        title: 'Purchase Not Found!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            })
        }
        // edit client using ajax
        function destroyItem(id) {
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
                    var url = '{{ route('user.purchase.destroy.item', ':id') }}';
                    url = url.replace(':id', data_id);
                    $.ajax({
                        type: "GET",
                        dataType: "json",
                        url: url,
                        success: function(data) {
                            $('.quantity').keyup();
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'error',
                                title: 'Item Deleted successfully!',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    });
                    var deleteButton = $("#delete" + data_id).addClass('delete-row');
                    deleteButton.click();
                }
            })
        }
    </script>
@endpush
