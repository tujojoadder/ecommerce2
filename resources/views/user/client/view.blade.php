<div class="modal fade" id="clientView">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-content-demo shadow-lg">
            <div class="modal-header">
                <h6 class="modal-title" id="modalHeader"></h6>
            </div>
            <div class="modal-body">
                <div class="row mx-0">
                    <p class="mt-3 px-0 text-dark h4">{{ __('messages.client_info') }}</p>
                    <table class="table table-sm table-bordered mb-0">
                        <tbody>
                            <tr>
                                <td>ID No</td>
                                <td>:</td>
                                <td><span class="client_id_no"></span></td>
                            </tr>
                            <tr>
                                <td>Name</td>
                                <td>:</td>
                                <td><span class="client_name"></span></td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>:</td>
                                <td><span class="client_email"></span></td>
                            </tr>
                            <tr>
                                <td>Mobile</td>
                                <td>:</td>
                                <td><span class="client_mobile"></span></td>
                            </tr>
                            <tr>
                                <td>Date Of Birth</td>
                                <td>:</td>
                                <td><span class="client_dob"></span></td>
                            </tr>
                            <tr>
                                <td>Address</td>
                                <td>:</td>
                                <td><span class="client_address"></span></td>
                            </tr>
                            <tr>
                                <td>Group</td>
                                <td>:</td>
                                <td><span class="client_group"></span></td>
                            </tr>
                            <tr>
                                <td>ZIP Code</td>
                                <td>:</td>
                                <td><span class="client_zip_code"></span></td>
                            </tr>
                        </tbody>
                    </table>

                    <p class="mt-3 px-0 text-dark h4">{{ __('messages.account_info') }}</p>
                    <table class="table table-sm table-bordered my-1 bg-transparent">
                        <tr class="bg-transparent">
                            <td class="py-0 w-50">{{ __('messages.previous_due') }}</td>
                            <td class="py-0 align-middle"><span id="view_previous_due"></span></td>
                        </tr>
                        <tr class="bg-transparent">
                            <td class="py-0 w-50">{{ __('messages.invoice_bill') }}</td>
                            <td class="py-0"><span id="view_sales"></span></td>
                        </tr>
                        <tr class="bg-transparent">
                            <td class="py-0 w-50">{{ __('messages.total_bill') }}</td>
                            <td class="py-0"><span id="view_totalBillAmount"></span></td>
                        </tr>
                        <tr class="bg-transparent">
                            <td class="py-0 w-50">{{ __('messages.receive') }}</td>
                            <td class="py-0"><span id="view_deposit"></span></td>
                        </tr>
                        <tr class="bg-transparent">
                            <td class="py-0 w-50">{{ __('messages.sales') . ' ' . __('messages.return') }}</td>
                            <td class="py-0"><span id="view_sales_return"></span></td>
                        </tr>
                        <tr class="bg-transparent">
                            <td class="py-0 w-50">{{ __('messages.money') }} {{ __('messages.return') }}</td>
                            <td class="py-0"><span id="view_money_return"></span></td>
                        </tr>
                        <tr class="bg-transparent">
                            <td class="py-0 w-50">{{ __('messages.sales') . ' ' . __('messages.return') . ' ' . __('messages.adjusting_amount') }}</td>
                            <td class="py-0"><span id="view_sales_return_adjustment"></span></td>
                        </tr>
                        <tr class="bg-transparent {{ config('client.client_balance_adjustment') == 1 ? '' : 'd-none' }}">
                            <td class="w-50">{{ __('messages.balance_adjustment') }}</td>
                            <td class="py-0"><span id="view_adjustment"></span></td>
                        </tr>
                        <tr class="bg-transparent">
                            <td class="w-50">{{ __('messages.due') }}</td>
                            <td class="py-0"><span id="view_due"></span></td>
                        </tr>
                        <tr class="bg-transparent {{ config('client.remaining_due_date') == 1 ? '' : 'd-none' }}">
                            <td class="w-50">{{ __('messages.remaining_due_date') }}</td>
                            <td class="py-0"><span id="view_remaining_due_date"></span></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="modal-footer py-2">
                <button class="btn btn-secondary m-0" data-bs-dismiss="modal" id="clientViewClose" type="button">Close</button>
            </div>
        </div>
    </div>
</div>
