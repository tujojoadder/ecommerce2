<div class="modal fade" id="brandModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-content-demo shadow-lg">
            <div class="modal-header">
                <h6 class="modal-title" id="addText">{{ __('messages.add_new') }}</h6>
                <h6 class="modal-title d-none" id="updateText">Update brand | ID No: <span id="id_no"></span></h6>
                <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- form field start --}}
                <div class="row" id="brand-form">
                    <div class="col-xl-12 mt-2">
                        <div class="form-group mb-0">
                            <label> Brand name</label>
                            <input type="text" class="form-control" name="brand_name" id="brand_name">
                            <span class="text-danger small" id="brand_name_Error"></span>
                        </div>
                        <div class="form-group mb-0">
                            <label> Brand Image (Width: 146px, height: 49px)</label>
                            <input type="file" class="form-control" name="image" id="brand_image">
                            <span class="text-danger small" id="image_Error"></span>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="row_id">
            </div>
            <div class="modal-footer py-2">
                <button class="btn btn-success" type="button" id="addbrand" onclick="addbrand();"><i class="fas fa-plus"></i> {{ __('messages.add_new') }}</button>
                <button class="btn btn-info d-none" type="button" id="updateBrand" onclick="updateBrand();"><i class="fas fa-sync"></i> {{ __('messages.update') }}</button>
                <button class="btn btn-danger m-0" data-bs-dismiss="modal" id="brandModalClose" type="button"><i class="fas fa-ban"></i> {{ __('messages.cancel') }}</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function clearbrandField() {
        $('#brand_name').val('').removeClass('border-danger');
        $('#subtitle_Error, #title_Error, #des_Error, #image_Error, #subimage_Error').text('');
        $('#image, #subimage').val('');
    }

    // Add brand
    function addbrand() {
        var formData = new FormData();
        formData.append("brand_name", $('#brand_name').val());
        formData.append("image", $('#brand_image')[0].files[0]);

        $.ajax({
            type: "POST",
            url: "{{ route('user.brand.store') }}",
            data: formData,
            contentType: false,
            processData: false,
            success: function(data) {
                clearbrandField();
                $("#brandModalClose").click();
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'brand added successfully!',
                    showConfirmButton: false,
                    timer: 1500
                });
                $('#file-export-datatable').DataTable().ajax.reload();
                setTimeout(() => {
                    getProductBrandInfo('/get-product-brand', data.id);
                }, 500);
            },
            error: function(error) {
                var $errors = error.responseJSON.errors;
                if ($errors) {
                    if ($errors.image) { $('#image_Error').text($errors.image[0]); }
                }
            }
        });
    }

    // Edit brand
    function editBrand(id) {
        var url = '{{ route("user.brand.edit", ":id") }}';
        url = url.replace(':id', id);

        $.ajax({
            type: "GET",
            url: url,
            success: function(data) {
                $('#row_id').val(data.id);

                $('#id_no').text(data.id);
                $('#brand_name').val(data.brand_name);
                $('#addText').addClass('d-none');
                $('#addbrand').addClass('d-none');
                $('#updateText').removeClass('d-none');
                $('#updateBrand').removeClass('d-none');

                $("#brandModal").modal("show");
            },
            error: function() {
                Swal.fire({
                    position: 'top-center',
                    icon: 'error',
                    title: 'brand Not Found!',
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        });
    }

    // Update brand
    function updateBrand() {
        var data_id = $('#row_id').val();
        var url = '{{ route("user.brand.update", ":id") }}';
        url = url.replace(':id', data_id);

        var formData = new FormData();
        formData.append("brand_name", $('#brand_name').val());
        if ($('#image')[0].files[0]) formData.append("image", $('#image')[0].files[0]);
        formData.append("_method", "PUT");

        $.ajax({
            type: "POST",
            url: url,
            data: formData,
            contentType: false,
            processData: false,
            success: function(data) {
                clearbrandField();
                $("#brandModalClose").click();
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'brand updated successfully!',
                    showConfirmButton: false,
                    timer: 1500
                });
                $('#file-export-datatable').DataTable().ajax.reload();
            },
            error: function(error) {
                var $errors = error.responseJSON.errors;
                if ($errors) {
                    if ($errors.image) { $('#image_Error').text($errors.image[0]); }
                }
            }
        });
    }
</script>
@endpush
