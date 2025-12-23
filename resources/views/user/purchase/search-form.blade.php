<div class="row justify-content-center">
    <div class="col-md-3 mb-1" id="suppliers">
        <label for="supplier_id">{{ __('messages.supplier') }}</label>
        <select name="supplier_id" id="supplier_id" class="supplier_id select2 form-control" style="width: 100% !important;">
        </select>
    </div>
    @if (!Route::is('user.purchase.invoice') && !Route::is('user.purchase.return.invoice'))
        {{-- <div id="product_name" class="col-md-2">
            <label for="">{{ __('messages.product_name') }}</label>
            <div class="input-group">
                <input type="text" name="product_name" class="product_name form-control" placeholder="{{ __('messages.product_name') }}">
            </div>
        </div> --}}
        <div class="col-md-3 mb-1" id="product">
            <label for="product_id">{{ __('messages.search_by') }} {{ __('messages.product') }}</label>
            <select id="product_id" class="product_id form-control" style="width: 100% !important;">
            </select>
        </div>
    @endif
    @if (!Route::is('user.purchase.index'))
        <div id="invoice_no" class="col-md-2">
            <label for="">{{ __('messages.invoice_no') }}</label>
            <div class="input-group">
                <input type="text" name="invoice_no" class="invoice_no form-control" placeholder="{{ __('messages.invoice_no') }}">
            </div>
        </div>
    @endif
    <div id="dateSearch" class="col-md-3">
        <label for="">{{ __('messages.search_by_date') }}</label>
        <div class="input-group">
            <input type="text" id="starting_date" class="fc-datepicker starting_date form-control" placeholder="DD/MM/YYYY">
            <input type="text" id="ending_date" class="fc-datepicker ending_date form-control" placeholder="DD/MM/YYYY">
        </div>
    </div>
    <div class="col-md-2 mb-lg-2 mb-5">
        <label for="button">&nbsp;</label>
        <button class="btn btn-block btn-lg btn-secondary" id="clearFilter">{{ __('messages.clear') }} {{ __('messages.filter') }}</button>
    </div>
</div>
