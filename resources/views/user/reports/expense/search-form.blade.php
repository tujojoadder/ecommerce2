    <div class="row mx-2 mb-3 mt-4 justify-content-center">
        <div class="col-md-12">
            <div class="row justify-content-center">
                @if (Route::is('user.report.expense.all'))
                    <div class="col-md-3 mb-1" id="clients">
                        <label for="client_id">{{ __('messages.search_by_client') }}</label>
                        <select id="client_id" class="select2 form-control" style="width: 100% !important;">
                        </select>
                    </div>
                @endif
                @if (Route::is('user.report.expense.category.wise') || Route::is('user.report.expense.subcategory.wise'))
                    <div class="col-md-3 mb-1" id="expenses">
                        <label for="expense_category_id">{{ __('messages.search_by') }} {{ __('messages.category') }}</label>
                        <select id="expense_category_id" class="select2 form-control" style="width: 100% !important;">
                        </select>
                    </div>
                    <div class="col-md-3 mb-1" id="expenses">
                        <label for="expense_subcategory_id">{{ __('messages.search_by') }} {{ __('messages.subcategory') }}</label>
                        <select id="expense_subcategory_id" class="select2 form-control" style="width: 100% !important;">
                        </select>
                    </div>
                @endif
                @if (Route::is('user.report.expense.supplier.payment.report') || Route::is('user.report.expense.all'))
                    <div class="col-md-3 mb-1" id="suppliers">
                        <label for="supplier_id">{{ __('messages.search_by') }} {{ __('messages.supplier') }}</label>
                        <select id="supplier_id" class="supplier_id select2 form-control" style="width: 100% !important;">
                        </select>
                    </div>
                @endif
                <div id="dateSearch" class="col-md-3">
                    <label for="">{{ __('messages.search_by_date') }}</label>
                    <div class="input-group">
                        <input type="text" id="starting_date" class="fc-datepicker starting_date form-control" placeholder="DD/MM/YYYY">
                        <input type="text" id="ending_date" class="fc-datepicker ending_date form-control" placeholder="DD/MM/YYYY">
                    </div>
                </div>
                <div class="col-md-3 mb-lg-2 mb-5">
                    <label for="button">&nbsp;</label>
                    <button class="btn btn-block btn-lg btn-secondary" id="clearFilter">{{ __('messages.clear') }} {{ __('messages.filter') }}</button>
                </div>
            </div>
        </div>
    </div>
