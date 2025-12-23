<a href="javascript:;" onclick="updateClientWallet({{ $row->id }})" class="btn btn-sm btn-secondary my-1" id="dropdownMenuButton"><i class="fas fa-wallet"></i> Update Wallet</a>
<div class="dropdown bg-transparrent">
    <button aria-expanded="false" aria-haspopup="true" class="btn ripple btn-success w-100" data-bs-toggle="dropdown" id="dropdownMenuButton" type="button">
        Action<i class="fas fa-caret-down ms-1"></i>
    </button>
    <div class="dropdown-menu tx-13 shadow">
        @canany(['access-all', 'client-add'])
            <a href="javascript:;" onclick="activeToggle({{ $row->id }})" class="dropdown-item">
                @if ($row->status == 1)
                    <i class="fas fa-toggle-off"></i> {{ __('messages.deactive') }}
                @else
                    <i class="fas fa-toggle-on"></i> {{ __('messages.active') }}
                @endif
            </a>
        @endcanany

        @canany(['access-all', 'client-view'])
            <a href="javascript:;" onclick="view({{ $row->id }})" class="dropdown-item"><i class="fas fa-eye"></i> {{ __('messages.view') }}</a>
        @endcanany

        @canany(['access-all', 'receive-visibility', 'receive-create'])
            <a href="javascript:;" onclick="receive({{ $row->id }})" class="dropdown-item"><i class="fas fa-hand-holding-usd"></i> {{ __('messages.receive') }}</a>
        @endcanany

        @canany(['access-all', 'client-edit'])
            <a href="{{ route('user.client.edit', $row->id) }}" class="dropdown-item"><i class="fas fa-pen"></i> {{ __('messages.edit') }}</a>
        @endcanany

        @canany(['access-all', 'client-delete'])
            <a href="javascript:;" class="dropdown-item" onclick="destroy({{ $row->id }})"><i class="fas fa-trash" style="color: red !important;"></i> <span style="color: red !important;">{{ __('messages.delete') }}</span></a>
        @endcanany

        @canany(['access-all', 'client-view'])
            <a href="{{ route('user.client.statements', ['client_id' => $row->id]) }}" class="dropdown-item"><i class="fas fa-receipt"></i> {{ __('messages.view') }} {{ __('messages.statement') }}</a>
        @endcanany
    </div>
</div>
