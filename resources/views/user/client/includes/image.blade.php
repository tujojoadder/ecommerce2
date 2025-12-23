<div class="text-center">
    <div class="image-show">
        <img class="rounded-circle border image-main" src="{{ $row->image != null ? asset('storage/profile/' . $row->image) : asset('dashboard/img/user-bg.png') }}" alt="" height="100" width="100">
    </div>
    <br><br>
    <form action="{{ route('user.client.update.image', $row->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="input-group justify-content-center">
            <input type="file" name="image" class="border image-input" style="width: 40%;">
            <button class="btn btn-sm btn-secondary rounded-0 py-0">Save</button>
        </div>
    </form>
</div>

<!-- Modal -->
<div class="modal fade" id="productPicture{{ $row->id }}">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Name: {{ $row->client_name }}</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-2 d-flex justify-content-center">
                <img class="border" src="{{ $row->image != null ? asset('storage/profile/' . $row->image) : asset('dashboard/img/user-bg.png') }}" class="w-100">
            </div>
            <div class="modal-footer py-1">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
