<div class="col-md-6">
    <div class="form-group">
        <label class="ps-3">{{ __('messages.preset') }} {{ __('messages.client') }}</label>
        <div class="d-flex">
            <div class="input-group" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.client') }}">
                <select id="client_id" class="form-control @error('client_id') is-invalid border-danger @enderror select2">
                </select>
            </div>
            <a class="add-btn btn border disabled" type="button" href="javascript:;"></a>
        </div>
    </div>
</div>

<div class="col-md-6">
    <div class="form-group">
        <label class="ps-3">{{ __('messages.preset') }} {{ __('messages.supplier') }}</label>
        <div class="d-flex">
            <div class="input-group" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.supplier') }}">
                <select id="supplier_id" class="form-control @error('supplier_id') is-invalid border-danger @enderror select2">
                </select>
            </div>
            <a class="add-btn btn border disabled" type="button" href="javascript:;"></a>
        </div>
    </div>
</div>

<div class="col-md-6">
    <div class="form-group">
        <label class="ps-3">{{ __('messages.preset') }} {{ __('messages.client_group') }}</label>
        <div class="d-flex">
            <div class="input-group" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.client_group') }}">
                <select id="client_group_id" class="form-control @error('group_id') is-invalid border-danger @enderror select2">
                </select>
            </div>
            <a class="add-btn btn border disabled" type="button" href="javascript:;"></a>
        </div>
    </div>
</div>

<div class="col-md-6">
    <div class="form-group">
        <label class="ps-3">{{ __('messages.preset') }} {{ __('messages.supplier_group') }}</label>
        <div class="d-flex">
            <div class="input-group" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.supplier_group') }}">
                <select id="supplier_group_id" class="form-control @error('group_id') is-invalid border-danger @enderror select2">
                </select>
            </div>
            <a class="add-btn btn border disabled" type="button" href="javascript:;"></a>
        </div>
    </div>
</div>

<div class="col-md-6">
    <div class="form-group">
        <label class="ps-3">{{ __('messages.preset') }} {{ __('messages.expense_category') }}</label>
        <div class="d-flex">
            <div class="input-group" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.expense_category') }}">
                <select id="expense_category_id" class="form-control @error('group_id') is-invalid border-danger @enderror select2">
                </select>
            </div>
            <a class="add-btn btn border disabled" type="button" href="javascript:;"></a>
        </div>
    </div>
</div>

<div class="col-md-6">
    <div class="form-group">
        <label class="ps-3">{{ __('messages.preset') }} {{ __('messages.receive') }} {{ __('messages.category') }}</label>
        <div class="d-flex">
            <div class="input-group" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.receive') }} {{ __('messages.category') }}">
                <select id="receive_category_id" class="form-control @error('receive_category_id') is-invalid border-danger @enderror select2">
                </select>
            </div>
            <a class="add-btn btn border disabled" type="button" href="javascript:;"></a>
        </div>
    </div>
</div>

<div class="col-md-6">
    <div class="form-group">
        <label class="ps-3">{{ __('messages.preset') }} {{ __('messages.account') }}</label>
        <div class="d-flex">
            <div class="input-group" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.account') }}">
                <select id="account_id" class="form-control @error('account_id') is-invalid border-danger @enderror select2">
                </select>
            </div>
            <a class="add-btn btn border disabled" type="button" href="javascript:;"></a>
        </div>
    </div>
</div>


@push('scripts')
    <script src="{{ asset('dashboard/js/select2-fetch.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="carf-token"]').attr('content')
            }
        });
        $(function() {
            fetchClients();
            fetchSuppliers();
            fetchClientGroups();
            fetchSupplierGroups();
            fetchExpenseCategories();
            fetchReceiveCategories();
            fetchAccounts();

            $('select').on('change', function() {
                var type = $(this).attr('id');
                var value = $(this).val();

                var url = '{{ route('set.site.preset', [':type', ':value']) }}';
                url = url.replace(':type', type).replace(':value', value);
                $.ajax({
                    url: url,
                    dataType: 'json',
                    type: 'POST',
                    data: {
                        type: type,
                        value: value,
                        _token: $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function(data) {
                        toastr.success("Preset Set Successfully!");
                    }
                });
            });
        });
    </script>
@endpush
