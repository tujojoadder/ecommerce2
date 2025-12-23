<div class="modal fade" id="stockModal" tabindex="-1" aria-labelledby="stockModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="stockModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if (config('products_show_stock_warning') == 1)
                    <h5 class="modal-title">{{ __('messages.stock') . ' ' . __('messages.warning') }}</h5>
                    <table class="table table-bordered mb-0 text-center">
                        <thead>
                            <tr>
                                <th>{{ __('messages.name') }}</th>
                                <th>{{ __('messages.group') }}</th>
                                <th>{{ __('messages.brand') }}</th>
                                <th>{{ __('messages.unit') }}</th>
                                <th>{{ __('messages.stock') }}</th>
                            </tr>
                        </thead>
                        @foreach (products() as $product)
                            <tr>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->group_name ?? '--' }}</td>
                                <td>{{ $product->asset_name ?? '--' }}</td>
                                <td>{{ $product->unit_name ?? '--' }}</td>
                                <td class="text-danger">{{ stock($product->id) }}</td>
                            </tr>
                        @endforeach
                    </table>
                    <div class="text-end"><a href="{{ route('user.stock.index') }}" class="btn btn-sm btn-info py-0 mt-1">View All</a></div>
                @endif

                @if (config('client.remaining_due_date') == 1)
                    <h5 class="modal-title {{ config('products_show_stock_warning') == 1 ? 'mt-3' : '' }}">{{ __('messages.client') }} {{ __('messages.remaining_due_date') }}</h5>
                    <table class="table table-bordered mb-0 text-center">
                        <thead>
                            <tr>
                                <th>{{ __('messages.name') }}</th>
                                <th>{{ __('messages.phone') }}</th>
                                <th>{{ __('messages.address') }}</th>
                                <th>{{ __('messages.date') }}</th>
                                <th>{{ __('messages.action') }}</th>
                            </tr>
                        </thead>
                        @foreach (clientDueDates() as $dueDate)
                            <tr>
                                <td>{{ $dueDate->client_name }}</td>
                                <td>{{ $dueDate->phone ?? '--' }}</td>
                                <td>{{ $dueDate->address ?? '--' }}</td>
                                <td>{{ enDateFormat($dueDate->remaining_due_date) }}</td>
                                <td>
                                    <a href="javascript:;" onclick="remainingDueDate({{ $dueDate->id }});" title="{{ $dueDate->remaining_due_date == !null ? enToBnDate($dueDate->remaining_due_date) : '00/00/0000' }}"><i class="bg-warning p-1 my-1 rounded fas fa-pen"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    <div class="text-end"><a href="{{ route('user.client.remaining.due.list') }}" class="btn btn-sm btn-info py-0 mt-1">View All</a></div>
                @endif

                @if (config('supplier.remaining_due_date') == 1)
                    <h5 class="modal-title {{ config('products_show_stock_warning') == 1 || config('client.remaining_due_date') == 1 ? 'mt-3' : '' }}">{{ __('messages.supplier') }} {{ __('messages.remaining_due_date') }}</h5>
                    <table class="table table-bordered mb-0 text-center">
                        <thead>
                            <tr>
                                <th>{{ __('messages.name') }}</th>
                                <th>{{ __('messages.phone') }}</th>
                                <th>{{ __('messages.address') }}</th>
                                <th>{{ __('messages.date') }}</th>
                            </tr>
                        </thead>
                        @foreach (supplierDueDates() as $dueDate)
                            <tr>
                                <td>{{ $dueDate->supplier_name }}</td>
                                <td>{{ $dueDate->phone ?? '--' }}</td>
                                <td>{{ $dueDate->address ?? '--' }}</td>
                                <td>{{ enDateFormat($dueDate->remaining_due_date) }}</td>
                            </tr>
                        @endforeach
                    </table>
                    <div class="text-end"><a href="{{ route('user.supplier.remaining.due.list') }}" class="btn btn-sm btn-info py-0 mt-1">View All</a></div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@include('user.client.remaining-due-modal')
