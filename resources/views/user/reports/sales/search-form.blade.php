    <div class="row my-3">
        <div class="col-md-12">
            <div class="row justify-content-center">
                @if (!Route::is('user.report.sales.product.wise'))
                    <div class="col-md-3 mb-1" id="clients">
                        <label for="client_id">{{ __('messages.search_by_client') }}</label>
                        <select name="client_id" id="client_id" class="select2 form-control" style="width: 100% !important;">
                        </select>
                    </div>
                    <div class="col-md-3 mb-1" id="invoices">
                        <label for="invoice_id">{{ __('messages.search_by') }} {{ __('messages.invoice') }}</label>
                        <select name="invoice_id" id="invoice_id" class="select2 form-control" style="width: 100% !important;">
                        </select>
                    </div>
                @endif
                @if (Route::is('user.report.sales.product.wise'))
                    <div class="col-md-3 mb-1" id="invoices">
                        <label for="product_search">{{ __('messages.product') }} {{ __('messages.search_by') }}</label>
                        <select name="product_search" id="product_search" class="select2 form-control" style="width: 100% !important;">
                        </select>
                    </div>
                @endif
                <div class="col-md-3 mb-1" id="staffs">
                    <label for="staff_id">{{ __('messages.search_by_user') }}</label>
                    <select name="staff_id" id="staff_id" class="staff_id form-control" style="width: 100% !important;">
                    </select>
                </div>
                @if ($queryString !== 'daily-search')
                    <div id="dateSearch" class="col-md-3">
                        <label for="">{{ __('messages.search_by_date') }}</label>
                        <div class="input-group">
                            <input type="text" id="starting_date" class="fc-datepicker starting_date form-control" placeholder="DD/MM/YYYY">
                            <input type="text" id="ending_date" class="fc-datepicker ending_date form-control" placeholder="DD/MM/YYYY">
                        </div>
                    </div>
                @endif
                <div class="col-md-3 mb-lg-2 mb-5">
                    <label for="button">&nbsp;</label>
                    <button class="btn btn-block btn-lg btn-secondary" id="clearFilter">{{ __('messages.clear') }} {{ __('messages.filter') }}</button>
                </div>
            </div>
        </div>
    </div>
