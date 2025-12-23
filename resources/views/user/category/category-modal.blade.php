<div class="modal fade" id="categoryModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="categoryForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="formMethod" value="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="categoryModalLabel">{{ __('messages.category') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body row">
                    <div class="col-6">
                        <div class="form-group mb-3">
                            <label>{{ __('messages.category') }} {{ __('messages.name') }}</label>
                            <input type="text" class="form-control" name="name" id="name" required>
                        </div>
                    </div>
                    <div class="col-6">
                        <label>Icon (20x20)</label>
                        <input type="file" class="form-control" name="icon">
                    </div>
                    <div class="col-6 mt-3 d-none">
                        <label>Banner (848x132)</label>
                        <input type="file" class="form-control" name="banner">
                    </div>
                    <div class="col-6 mt-3  d-none">
                        <label>Banner2 (370x348)</label>
                        <input type="file" class="form-control" name="banner2">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="saveCategory" class="btn btn-success"></button>
                </div>
            </form>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        $('#categoryForm').submit(function(e) {
            e.preventDefault();

            let formData = new FormData(this);

            let url = (save_method === 'add') ?
                "{{ route('user.category.store') }}" :
                "{{ url('user/category/update') }}/" + category_id;

            if (save_method === 'edit') {
                formData.append('_method', 'PUT');
            }

            $.ajax({
                type: "POST",
                url: url,
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    $('#categoryModal').modal('hide');
                    $('#categoryTable').DataTable().ajax.reload();
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: (save_method === 'add') ? 'Category added!' :
                            'Category updated!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    setTimeout(() => {
                        getCategoryInfo('/get-cateogry-info', res.id);
                    }, 500);
                },
                error: function(err) {
                    let errors = err.responseJSON.errors;
                    let msg = '';
                    $.each(errors, function(key, value) {
                        msg += value[0] + '<br>';
                    });
                    Swal.fire('Error', msg, 'error');
                }
            });
        });
    </script>
@endpush
