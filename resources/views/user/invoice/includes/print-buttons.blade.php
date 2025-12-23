<div class="d-flex justify-content-center">
    <a href="{{ route('user.invoice.pos.show', $row->id) }}" class="btn btn-sm mx-1 btn-success">
        <i class="fas fa-receipt"></i> Pos View
    </a>
    <br>
    <a href="{{ route('user.invoice.show', $row->id) }}" class="btn btn-sm mx-1 btn-success" onclick="printInvoice({{ $row->id }})">
        <i class="fas fa-receipt"></i> {{ __('messages.invoice') }} {{ __('messages.view') }}
    </a>
    <a href="{{ route('user.invoice.challan', $row->id) }}" class="btn btn-sm mx-1 btn-success" onclick="printInvoice({{ $row->id }})">
        <i class="fas fa-receipt"></i> {{ __('messages.challan') }}
    </a>
</div>
