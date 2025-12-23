    <div class="modal fade" id="formSettingModal" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">Product Form Settings</h6><button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">

                        {{-- <div class="form-group col-md-6">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">{{ __('messages.name') }}</span>
                                <input type="checkbox" name="name" class="form-switch-input" {{ config('products_name') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div> --}}

                        <div class="form-group col-md-6">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">{{ __('messages.image') }}</span>
                                <input type="checkbox" name="image" class="form-switch-input" {{ config('products_image') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>

                        <div class="form-group col-md-6">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">{{ __('messages.description') }}</span>
                                <input type="checkbox" name="description" class="form-switch-input" {{ config('products_description') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>

                        {{-- <div class="form-group col-md-6">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">{{ __('messages.buying_price') }}</span>
                                <input type="checkbox" name="buying_price" class="form-switch-input" {{ config('products_buying_price') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div> --}}

                        {{-- <div class="form-group col-md-6">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">{{ __('messages.selling_price') }}</span>
                                <input type="checkbox" name="selling_price" class="form-switch-input" {{ config('products_selling_price') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div> --}}

                        {{-- <div class="form-group col-md-6">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">{{ __('messages.wholesale_price') }}</span>
                                <input type="checkbox" name="wholesale_price" class="form-switch-input" {{ config('products_wholesale_price') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div> --}}

                        {{-- <div class="form-group col-md-6">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">{{ __('messages.unit_id') }}</span>
                                <input type="checkbox" name="unit_id" class="form-switch-input" {{ config('products_unit_id') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div> --}}
                        @if (config('sidebar.product_color') == 1)
                            <div class="form-group col-md-6">
                                <label class="input-group form-control d-flex justify-content-between">
                                    <span class="form-switch-description tx-15 me-2">{{ __('messages.color') }}</span>
                                    <input type="checkbox" name="color_id" class="form-switch-input" {{ config('products_color_id') == 1 ? 'checked' : '' }}>
                                    <span class="form-switch-indicator form-switch-indicator-lg"></span>
                                </label>
                            </div>
                        @endif
                        @if (config('sidebar.product_size') == 1)
                            <div class="form-group col-md-6">
                                <label class="input-group form-control d-flex justify-content-between">
                                    <span class="form-switch-description tx-15 me-2">{{ __('messages.size') }}</span>
                                    <input type="checkbox" name="size_id" class="form-switch-input" {{ config('products_size_id') == 1 ? 'checked' : '' }}>
                                    <span class="form-switch-indicator form-switch-indicator-lg"></span>
                                </label>
                            </div>
                        @endif
                        @if (config('sidebar.product_brand') == 1)
                            <div class="form-group col-md-6">
                                <label class="input-group form-control d-flex justify-content-between">
                                    <span class="form-switch-description tx-15 me-2">{{ __('messages.brand') }}</span>
                                    <input type="checkbox" name="brand_id" class="form-switch-input" {{ config('products_brand_id') == 1 ? 'checked' : '' }}>
                                    <span class="form-switch-indicator form-switch-indicator-lg"></span>
                                </label>
                            </div>
                        @endif

                        <div class="form-group col-md-6">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">{{ __('messages.opening_stock') }}</span>
                                <input type="checkbox" name="opening_stock" class="form-switch-input" {{ config('products_opening_stock') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>

                        {{-- <div class="form-group col-md-6">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">{{ __('messages.barcode_number') }}</span>
                                <input type="checkbox" name="custom_barcode_no" class="form-switch-input" {{ config('products_custom_barcode_no') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div> --}}

                        {{-- <div class="form-group col-md-6">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">{{ __('messages.imei_no') }}</span>
                                <input type="checkbox" name="imei_no" class="form-switch-input" {{ config('products_imei_no') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div> --}}

                        @canany(['access-all', 'warehouse-visibility'])
                            @if (config('sidebar.warehouse') == 1)
                                <div class="form-group col-md-6">
                                    <label class="input-group form-control d-flex justify-content-between">
                                        <span class="form-switch-description tx-15 me-2">{{ __('messages.warehouse') }}</span>
                                        <input type="checkbox" name="warehouse_id" class="form-switch-input" {{ config('products_warehouse_id') == 1 ? 'checked' : '' }}>
                                        <span class="form-switch-indicator form-switch-indicator-lg"></span>
                                    </label>
                                </div>
                            @endif
                        @endcanany

                        <div class="form-group col-md-6">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">{{ __('messages.carton') }}</span>
                                <input type="checkbox" name="carton" class="form-switch-input" {{ config('products_carton') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>

                        {{-- <div class="form-group col-md-6">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">{{ __('messages.group') }}</span>
                                <input type="checkbox" name="group_id" class="form-switch-input" {{ config('products_group_id') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div> --}}

                        <div class="form-group col-md-6">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">{{ __('messages.stock_warning') }}</span>
                                <input type="checkbox" name="stock_warning" class="form-switch-input" {{ config('products_stock_warning') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn ripple btn-info" data-bs-dismiss="modal" type="button">{{ __('messages.save') }}</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="carf-token"]').attr('content')
                }
            });

            function capitalizeWords(str) {
                return str.replace(/\b\w/g, function(match) {
                    return match.toUpperCase();
                });
            }
            $("#formSettingModal input").on('click', function() {
                var table_name = 'products';
                var field_name = $(this).prop("name");
                var status = $(this).prop("checked");

                var url = '{{ route('enable.disable.field', [':table', ':field']) }}';
                url = url.replace(':table', table_name).replace(':field', field_name);

                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: url,
                    success: function(data) {
                        var name = field_name.replace(/_/g, ' ');
                        toastr.success(capitalizeWords(name) + " Successfully Updated!");
                    },
                    error: function(error) {
                        Swal.fire({
                            position: 'top-center',
                            icon: 'error',
                            title: 'Not Found!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                })
            });

            $('#formSettingModal').on('hidden.bs.modal', function() {
                location.reload(); // Reload the page when the modal is closed
            });
        </script>
    @endpush
