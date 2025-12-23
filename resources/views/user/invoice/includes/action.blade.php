@if (request()->draft != null)
    @if (Gate::any(['access-all', 'draft-invoice-edit']))
        <a href="javascript:;" class="btn btn-sm mx-1 btn-info" onclick="edit({{ $row->id }})">
            <i class="fas fa-pen-nib"></i>
        </a>
    @endif
    @if (Gate::any(['access-all', 'draft-invoice-delete']))
        <a href="javascript:;" class="btn btn-sm mx-1 btn-danger" onclick="destroy({{ $row->id }})">
            <i class="fas fa-trash"></i>
        </a>
    @endif
@else
    @if (Gate::any(['access-all', 'invoice-edit']))
        {{-- <a href="javascript:;" class="btn btn-sm mx-1 btn-info" onclick="edit({{ $row->id }})">
            <i class="fas fa-pen-nib"></i>
        </a> --}}
        <a href="{{ route('user.invoice.edit', $row->id) }}" class="btn btn-sm mx-1 btn-info">
            <i class="fas fa-pen-nib"></i>
        </a>
    @endif
    @if (Gate::any(['access-all', 'invoice-delete']))
        <a href="javascript:;" class="btn btn-sm mx-1 btn-danger" onclick="destroy({{ $row->id }})">
            <i class="fas fa-trash"></i>
        </a>
    @endif
@endif
