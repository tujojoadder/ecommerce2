<div class="modal fade" id="sliderModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-content-demo shadow-lg">
            <div class="modal-header">
                <h6 class="modal-title" id="addText">{{ __('messages.add_new') }}</h6>
                <h6 class="modal-title d-none" id="updateText">Update Slider | ID No: <span id="id_no"></span></h6>
                <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- form field start --}}
                <div class="row" id="slider-form">

                    <div class="col-xl-12 d-none">
                        <div class="form-group mb-0">
                            <input type="text" class="form-control" name="subtitle" id="subtitle">
                            <label for="subtitle" class="animated-label"><i class="fas fa-bars"></i> Sub Title</label>
                            <span class="text-danger small" id="subtitle_Error"></span>
                        </div>
                    </div>
                    <div class="col-xl-12 mt-2">
                        <div class="form-group mb-0">
                            <input type="text" class="form-control" name="title" id="title">
                            <label for="title" class="animated-label"><i class="fas fa-bars"></i> Title</label>
                            <span class="text-danger small" id="title_Error"></span>
                        </div>
                    </div>
                    <div class="col-xl-12 mt-2  d-none">
                        <div class="form-group mb-0">
                            <input type="text" class="form-control" name="des" id="des">
                            <label for="des" class="animated-label"><i class="fas fa-bars"></i> Description</label>
                            <span class="text-danger small" id="des_Error"></span>
                        </div>
                    </div>
                    <div class="col-xl-12 mt-2  d-none">
                        <div class="form-group mb-0">
                            <input type="text" class="form-control" name="link" id="link">
                            <label for="link" class="animated-label"><i class="fas fa-bars"></i> Link</label>
                            <span class="text-danger small" id="des_Error"></span>
                        </div>
                    </div>
                    <div class="col-xl-12 mt-2">
                        <div class="form-group mb-0">
                            <label> Main Image (Width: 890px, height: 443px)</label>
                            <input type="file" class="form-control" name="image" id="image">
                            <span class="text-danger small" id="image_Error"></span>
                        </div>
                    </div>
                    <div class="col-xl-12 mt-2  d-none">
                        <div class="form-group mb-0">
                            <label> Sub Image (Width: 432px, height: 376px)</label>
                            <input type="file" class="form-control" name="subimage" id="subimage">
                            <span class="text-danger small" id="subimage_Error"></span>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="row_id">
            </div>
            <div class="modal-footer py-2">
                <button class="btn btn-success" type="button" id="addSlider" onclick="addSlider();"><i
                        class="fas fa-plus"></i> {{ __('messages.add_new') }}</button>
                <button class="btn btn-info d-none" type="button" id="updateSlider" onclick="updateSlider();"><i
                        class="fas fa-sync"></i> {{ __('messages.update') }}</button>
                <button class="btn btn-danger m-0" data-bs-dismiss="modal" id="sliderModalClose" type="button"><i
                        class="fas fa-ban"></i> {{ __('messages.cancel') }}</button>
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

        function clearSliderField() {
            $('#subtitle, #title, #des').val('').removeClass('border-danger');
            $('#subtitle_Error, #title_Error, #des_Error, #image_Error, #subimage_Error').text('');
            $('#image, #subimage').val('');
        }

        // Add Slider
        function addSlider() {
            var formData = new FormData();
            formData.append("subtitle", $('#subtitle').val());
            formData.append("link", $('#link').val());
            formData.append("title", $('#title').val());
            formData.append("des", $('#des').val());
            formData.append("image", $('#image')[0].files[0]);
            formData.append("subimage", $('#subimage')[0].files[0]);

            $.ajax({
                type: "POST",
                url: "{{ route('user.slider.store') }}",
                data: formData,
                contentType: false,
                processData: false,
                success: function(data) {
                    clearSliderField();
                    $("#sliderModalClose").click();
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Slider added successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    $('#file-export-datatable').DataTable().ajax.reload();
                },
                error: function(error) {
                    var $errors = error.responseJSON.errors;
                    if ($errors) {
                        if ($errors.subtitle) {
                            $('#subtitle_Error').text($errors.subtitle[0]);
                            $('#subtitle').addClass('border-danger');
                        }
                        if ($errors.title) {
                            $('#title_Error').text($errors.title[0]);
                            $('#title').addClass('border-danger');
                        }
                        if ($errors.des) {
                            $('#des_Error').text($errors.des[0]);
                            $('#des').addClass('border-danger');
                        }
                        if ($errors.image) {
                            $('#image_Error').text($errors.image[0]);
                        }
                        if ($errors.subimage) {
                            $('#subimage_Error').text($errors.subimage[0]);
                        }
                    }
                }
            });
        }

        // Edit Slider
        function editSlider(id) {
            var url = '{{ route('user.slider.edit', ':id') }}';
            url = url.replace(':id', id);

            $.ajax({
                type: "GET",
                url: url,
                success: function(data) {
                    $('#subtitle').val(data.subtitle);
                    $('#link').val(data.link);
                    $('#title').val(data.title);
                    $('#des').val(data.des);
                    $('#row_id').val(data.id);

                    $('#id_no').text(data.id);
                    $('#addText').addClass('d-none');
                    $('#addSlider').addClass('d-none');
                    $('#updateText').removeClass('d-none');
                    $('#updateSlider').removeClass('d-none');

                    $("#sliderModal").modal("show");
                },
                error: function() {
                    Swal.fire({
                        position: 'top-center',
                        icon: 'error',
                        title: 'Slider Not Found!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            });
        }

        // Update Slider
        function updateSlider() {
            var data_id = $('#row_id').val();
            var url = '{{ route('user.slider.update', ':id') }}';
            url = url.replace(':id', data_id);

            var formData = new FormData();
            formData.append("subtitle", $('#subtitle').val());
            formData.append("link", $('#link').val());
            formData.append("title", $('#title').val());
            formData.append("des", $('#des').val());
            if ($('#image')[0].files[0]) formData.append("image", $('#image')[0].files[0]);
            if ($('#subimage')[0].files[0]) formData.append("subimage", $('#subimage')[0].files[0]);
            formData.append("_method", "PUT");

            $.ajax({
                type: "POST",
                url: url,
                data: formData,
                contentType: false,
                processData: false,
                success: function(data) {
                    clearSliderField();
                    $("#sliderModalClose").click();
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Slider updated successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    $('#file-export-datatable').DataTable().ajax.reload();
                },
                error: function(error) {
                    var $errors = error.responseJSON.errors;
                    if ($errors) {
                        if ($errors.subtitle) {
                            $('#subtitle_Error').text($errors.subtitle[0]);
                            $('#subtitle').addClass('border-danger');
                        }
                        if ($errors.title) {
                            $('#title_Error').text($errors.title[0]);
                            $('#title').addClass('border-danger');
                        }
                        if ($errors.des) {
                            $('#des_Error').text($errors.des[0]);
                            $('#des').addClass('border-danger');
                        }
                        if ($errors.image) {
                            $('#image_Error').text($errors.image[0]);
                        }
                        if ($errors.subimage) {
                            $('#subimage_Error').text($errors.subimage[0]);
                        }
                    }
                }
            });
        }
    </script>
@endpush
