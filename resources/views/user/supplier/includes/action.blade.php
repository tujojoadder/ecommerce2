<a href="javascript:;" onclick="updateSupplierWallet({{ $row->id }})" class="btn btn-sm btn-secondary my-1" id="dropdownMenuButton"><i class="fas fa-wallet"></i> Update Wallet</a>
<div class="dropdown bg-transparrent">
    <button aria-expanded="false" aria-haspopup="true" class="btn ripple btn-success w-100" data-bs-toggle="dropdown" id="dropdownMenuButton" type="button">Action<i class="fas fa-caret-down ms-1"></i></button>
    <div class="dropdown-menu tx-13 shadow">
        @canany(['access-all', 'supplier-view'])
            <a href="javascript:;" onclick="view({{ $row->id }})" class="dropdown-item">
                <i class="fas fa-eye"></i> {{ __('messages.view') }}
            </a>
        @endcanany

        @canany(['access-all', 'supplier-edit'])
            <a href="{{ route('user.supplier.edit', $row->id) }}" class="dropdown-item">
                <i class="fas fa-pen"></i> {{ __('messages.edit') }}
            </a>
        @endcanany

        @canany(['access-all', 'supplier-delete'])
            <a href="javascript:;" class="dropdown-item" onclick="destroy({{ $row->id }})">
                <i class="fas fa-trash"></i> {{ __('messages.delete') }}
            </a>
        @endcanany

        @canany(['access-all', 'supplier-create'])
            <a href="{{ route('user.expense.index') }}?create-supplier-payment&supplier_id={{ $row->id }}" class="dropdown-item">
                <i class="fas fa-hand-holding-usd"></i> {{ __('messages.payment') }}
            </a>
        @endcanany

        @canany(['access-all', 'supplier-payment-visibility', 'supplier-payment-create'])
            <a href="{{ route('user.report.expense.supplier.payment.report') }}?&supplier_id={{ $row->id }}" class="dropdown-item">
                <i class="fas fa-receipt pe-1"></i> {{ __('messages.payment') }} {{ __('messages.report') }}
            </a>
        @endcanany

        @canany(['access-all', 'supplier-view'])
            <a href="{{ route('user.purchase.report') }}?&supplier_id={{ $row->id }}" class="dropdown-item">
                <i class="fas fa-receipt pe-1"></i> {{ __('messages.purchase') }} {{ __('messages.report') }}
            </a>
        @endcanany

        @canany(['access-all', 'supplier-view'])
            <a href="{{ route('user.supplier.statements') }}?&supplier_id={{ $row->id }}" class="dropdown-item">
                <i class="fas fa-receipt pe-1"></i> {{ __('messages.statement') }}
            </a>
        @endcanany
    </div>
</div>
