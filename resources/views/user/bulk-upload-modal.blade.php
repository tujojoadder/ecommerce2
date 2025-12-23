<div class="modal fade" id="bulkModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-content-demo shadow-lg">
            <div class="modal-header">
                <h6 class="modal-title">{{ __('messages.bulk_upload') }}</h6>
                <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('user.bulk.upload') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <select name="type" class="form-control mb-3">
                        @if (Request::is('user/product*'))
                        <option value="products">{{ __('messages.product') }}</option>
                        @endif
                        @if (Request::is('user/invoice*'))
                            <option value="invoices">{{ __('messages.invoice') }}</option>
                        @endif
                        @if (Request::is('user/purchase*'))
                            <option value="purchases">{{ __('messages.purchase') }}</option>
                        @endif
                    </select>
                    @if (Request::is('user/invoice*') || Request::is('user/purchase*'))
                        <label for="">{{ Request::is('user/invoice*') ? __('messages.invoice') : __('messages.purchase') }} {{ __('messages.file') }}</label>
                        <input type="file" class="form-control mb-3" name="bulk_file">

                        {{-- <label for="">{{ Request::is('user/invoice*') ? __('messages.invoice_items') : __('messages.purchase_items') }} {{ __('messages.file') }}</label>
                        <input type="file" class="form-control mb-3" name="bulk_parent_file"> --}}
                    @else
                        <label for="">{{ __('messages.product') }} {{ __('messages.bulk') }} {{ __('messages.file') }}</label>
                        <input type="file" class="form-control mb-3" name="bulk_file">
                    @endif
                    <button type="submit" class="btn-block btn btn-success">{{ __('messages.save') }}</button>
                </form>
            </div>
            <div class="modal-footer py-2">
                <button class="btn btn-danger m-0" data-bs-dismiss="modal" type="button"><i class="fas fa-ban"></i> {{ __('messages.cancel') }}</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $('#uploadBulkFile, #uploadBulkFiles').on('click', function() {
            $('#bulkModal').modal('show');
        });
    </script>
@endpush
