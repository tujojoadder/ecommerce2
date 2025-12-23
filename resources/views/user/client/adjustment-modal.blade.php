<div class="modal fade" id="balanceAdjustmentModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-content-demo shadow-lg">
            <div class="modal-header">
                <h6 class="modal-title" id="addText">{{ __('messages.balance_adjustment') }} {{ __('messages.list') }}</h6>
                <button aria-label="Close" class="btn-close text-danger" data-bs-dismiss="modal" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered text-center adjustmentTable">
                    <thead>
                        <tr>
                            <th>{{ __('messages.sl') }}</th>
                            <th>{{ __('messages.date') }}</th>
                            <th>{{ __('messages.amount') }}</th>
                            <th>{{ __('messages.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer py-2">
                <button class="btn btn-dark m-0" data-bs-dismiss="modal" type="button">{{ __('messages.close') }}</button>
            </div>
        </div>
    </div>
</div>
