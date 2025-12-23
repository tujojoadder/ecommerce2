<div class="modal fade" id="subsubcategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="modalHeading"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="subsubcategoryform" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>{{ __('messages.category') }}</label>
                        <select name="category_id" id="" class="form-control category_id" required></select>
                    </div>
                    <div class="form-group">
                        <label>{{ __('messages.subcategory') }}</label>
                        <select name="subcategory_id" id="" class="form-control subcategory_id" required></select>
                    </div>
                    <div class="form-group mt-2">
                        <label>{{ __('messages.subsubcategory') }} {{ __('messages.name') }}</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <button type="submit" class="btn btn-success mt-3">{{ __('messages.save') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="{{ asset('dashboard/js/select2-fetch.js') }}"></script>
<script src="{{ asset('dashboard/js/append.js') }}"></script>
    <script>
        // $('.subcategory_id').select2({
        //     placeholder: 'Select D'
        // });
        $(".category_id").on('change', function() {
            var category_id = $(this).val();
            if (category_id) {
                setTimeout(() => {
                    fetchSubCategories(category_id);
                }, 500);
            }
        });
    </script>
    <script>
    let save_method = 'add'; // declare globally
    let edit_id = null;      // declare globally

    $('#subsubcategoryform').submit(function(e) {
        e.preventDefault();

        let formData = new FormData(this);

        // decide URL based on save_method
        let url = (save_method === 'add')
            ? "{{ route('user.subsubcategory.store') }}"
            : "{{ url('user/subsubcategory/update') }}/" + edit_id;

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
                $('#subsubcategoryModal').modal('hide');
                $('#subcategoryTable').DataTable().ajax.reload();
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: (save_method === 'add') ? 'SubSubcategory added!' : 'SubSubcategory updated!',
                    showConfirmButton: false,
                    timer: 1500
                });

                setTimeout(() => {
                    getSubSubCategoryInfo('/get-sub-sub-cateogry-info', res.id);
                }, 500);

                // reset state
                save_method = 'add';
                edit_id = null;
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
