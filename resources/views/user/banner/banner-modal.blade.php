<div class="modal fade" id="bannerModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-content-demo shadow-lg">
            <div class="modal-header">
                <h6 class="modal-title" id="addText">{{ __('messages.add_new') }}</h6>
                <h6 class="modal-title d-none" id="updateText">Update Banner | ID No: <span id="id_no"></span></h6>
                <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- form field start --}}
                <div class="row" id="banner-form">
                    <div class="col-xl-12 mt-2">
                        <div class="form-group mb-0">
                            <label> Main Image (Width: 585px, height: 120px)</label>
                            <input type="file" class="form-control" name="image" id="image">
                            <span class="text-danger small" id="image_Error"></span>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="row_id">
            </div>
            <div class="modal-footer py-2">
                <button class="btn btn-success" type="button" id="addBanner" onclick="addBanner();"><i class="fas fa-plus"></i> {{ __('messages.add_new') }}</button>
                <button class="btn btn-info d-none" type="button" id="updateBanner" onclick="updateBanner();"><i class="fas fa-sync"></i> {{ __('messages.update') }}</button>
                <button class="btn btn-danger m-0" data-bs-dismiss="modal" id="bannerModalClose" type="button"><i class="fas fa-ban"></i> {{ __('messages.cancel') }}</button>
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

    function clearBannerField() {
        $('#subtitle, #title, #des').val('').removeClass('border-danger');
        $('#subtitle_Error, #title_Error, #des_Error, #image_Error, #subimage_Error').text('');
        $('#image, #subimage').val('');
    }

    // Add Banner
    function addBanner() {
        var formData = new FormData();
        formData.append("image", $('#image')[0].files[0]);

        $.ajax({
            type: "POST",
            url: "{{ route('user.banner.store') }}",
            data: formData,
            contentType: false,
            processData: false,
            success: function(data) {
                clearBannerField();
                $("#bannerModalClose").click();
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'Banner added successfully!',
                    showConfirmButton: false,
                    timer: 1500
                });
                $('#file-export-datatable').DataTable().ajax.reload();
            },
            error: function(error) {
                var $errors = error.responseJSON.errors;
                if ($errors) {
                    if ($errors.subtitle) { $('#subtitle_Error').text($errors.subtitle[0]); $('#subtitle').addClass('border-danger'); }
                    if ($errors.title) { $('#title_Error').text($errors.title[0]); $('#title').addClass('border-danger'); }
                    if ($errors.des) { $('#des_Error').text($errors.des[0]); $('#des').addClass('border-danger'); }
                    if ($errors.image) { $('#image_Error').text($errors.image[0]); }
                    if ($errors.subimage) { $('#subimage_Error').text($errors.subimage[0]); }
                }
            }
        });
    }

    // Edit Banner
    function editBanner(id) {
        var url = '{{ route("user.banner.edit", ":id") }}';
        url = url.replace(':id', id);

        $.ajax({
            type: "GET",
            url: url,
            success: function(data) {
                $('#row_id').val(data.id);

                $('#id_no').text(data.id);
                $('#addText').addClass('d-none');
                $('#addBanner').addClass('d-none');
                $('#updateText').removeClass('d-none');
                $('#updateBanner').removeClass('d-none');

                $("#bannerModal").modal("show");
            },
            error: function() {
                Swal.fire({
                    position: 'top-center',
                    icon: 'error',
                    title: 'Banner Not Found!',
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        });
    }

    // Update Banner
    function updateBanner() {
        var data_id = $('#row_id').val();
        var url = '{{ route("user.banner.update", ":id") }}';
        url = url.replace(':id', data_id);

        var formData = new FormData();
        if ($('#image')[0].files[0]) formData.append("image", $('#image')[0].files[0]);
        formData.append("_method", "PUT");

        $.ajax({
            type: "POST",
            url: url,
            data: formData,
            contentType: false,
            processData: false,
            success: function(data) {
                clearBannerField();
                $("#bannerModalClose").click();
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'Banner updated successfully!',
                    showConfirmButton: false,
                    timer: 1500
                });
                $('#file-export-datatable').DataTable().ajax.reload();
            },
            error: function(error) {
                var $errors = error.responseJSON.errors;
                if ($errors) {
                    if ($errors.subtitle) { $('#subtitle_Error').text($errors.subtitle[0]); $('#subtitle').addClass('border-danger'); }
                    if ($errors.title) { $('#title_Error').text($errors.title[0]); $('#title').addClass('border-danger'); }
                    if ($errors.des) { $('#des_Error').text($errors.des[0]); $('#des').addClass('border-danger'); }
                    if ($errors.image) { $('#image_Error').text($errors.image[0]); }
                    if ($errors.subimage) { $('#subimage_Error').text($errors.subimage[0]); }
                }
            }
        });
    }
</script>
@endpush
