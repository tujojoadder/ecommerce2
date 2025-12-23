<div class="modal fade" id="remainingDueDate">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-content-demo shadow-lg">
            <div class="modal-header">
                <h6 class="modal-title" id="modalHeader"></h6>
            </div>
            <div class="modal-body">
                <div class="row mx-auto">
                    <div class="form-group">
                        <input type="text" name="remaining_due_date" id="remaining_due_date" class="fc-datepicker form-control" placeholder="DD/MM/YYYY">
                        <input type="hidden" id="supplier_id_for_due" value="">
                        <label for="remaining_due_date" class="ms-2 animated-label active-label">{{ __('messages.remaining_due_date') }}</label>
                    </div>
                    <button onclick="updateRemainingDueDate();" type="button" class="btn btn-success">{{ __('messages.update') }}</button>
                </div>
            </div>
            <div class="modal-footer py-2">
                <button class="btn btn-secondary m-0" data-bs-dismiss="modal" id="remainingDueDateClose" type="button">Close</button>
            </div>
        </div>
    </div>
</div>
