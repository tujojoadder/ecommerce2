<div class="modal fade" id="shortcutMenuModal" tabindex="-1" aria-labelledby="shortcutMenuModal" aria-hidden="true">
    <div class="modal-dialog modal-md  " role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title" id="addIncomeCategoryText">{{ __('messages.add_shortcut_menu') }}</h6>
                <h6 class="modal-title d-none" id="updateIncomeCategoryText">{{ __('messages.update') }} {{ __('messages.shortcut_menu') }}</h6>
                <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- form field start --}}
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="form-group">
                                <input type="text" id="row_id" hidden>
                                <input type="text" class="form-control" id="title" name="title" required data-bs-toggle="tooltip-primary" title="{{ __('messages.title') }}" id="title" placeholder="{{ __('messages.title') }}">
                                <label for="title" class="animated-label"><i class="fas fa-pencil-alt"></i> {{ __('messages.title') }}</label>
                            </div>
                            <span class="text-danger small" id="title_Error"></span>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="form-group">
                                <input type="text" class="form-control" id="address" name="address" required placeholder="{{ __('messages.address') }}">
                                <label for="title" class="animated-label"><i class="fas fa-link"></i> {{ __('messages.address') }}</label>
                            </div>
                            <span class="text-danger small" id="address_Error"></span>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 d-none">
                            <div class="form-group">
                                <input type="file" accept="image/*" class="form-control" id="img" name="img" data-bs-toggle="tooltip-primary" title="PNG Icon" id="img" placeholder="PNG Icon">
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="form-group" data-bs-toggle="tooltip-primary" title="Fontawesome Icon Class" placeholder="Fontawesome Icon Class">
                                <div class="dropdown">
                                    <button class="btn border bg-success dropdown-toggle w-100" type="button" id="iconDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i id="selectedIcon" class="fas fa-plus-circle me-2"></i> Select Icon
                                    </button>
                                    <ul class="dropdown-menu w-100" aria-labelledby="iconDropdown">
                                        <li><a class="dropdown-item" href="#" data-icon="fas fa-plus-circle"><i class="fas fa-plus-circle me-2"></i> Plus</a></li>
                                        <li><a class="dropdown-item" href="#" data-icon="fas fa-receipt"><i class="fas fa-receipt me-2"></i> Receipt</a></li>
                                        <li><a class="dropdown-item" href="#" data-icon="fas fa-link"><i class="fas fa-link me-2"></i> Link</a></li>
                                        <li><a class="dropdown-item" href="#" data-icon="fas fa-home"><i class="fas fa-home me-2"></i> Home</a></li>
                                        <li><a class="dropdown-item" href="#" data-icon="fas fa-user"><i class="fas fa-user me-2"></i> User</a></li>
                                        <li><a class="dropdown-item" href="#" data-icon="fas fa-cog"><i class="fas fa-cog me-2"></i> Settings</a></li>
                                        <li><a class="dropdown-item" href="#" data-icon="fas fa-envelope"><i class="fas fa-envelope me-2"></i> Envelope</a></li>
                                        <li><a class="dropdown-item" href="#" data-icon="fas fa-phone"><i class="fas fa-phone me-2"></i> Phone</a></li>
                                        <li><a class="dropdown-item" href="#" data-icon="fas fa-calendar"><i class="fas fa-calendar me-2"></i> Calendar</a></li>
                                        <li><a class="dropdown-item" href="#" data-icon="fas fa-chart-bar"><i class="fas fa-chart-bar me-2"></i> Chart</a></li>
                                        <li><a class="dropdown-item" href="#" data-icon="fas fa-shopping-cart"><i class="fas fa-shopping-cart me-2"></i> Shopping Cart</a></li>
                                        <li><a class="dropdown-item" href="#" data-icon="fas fa-heart"><i class="fas fa-heart me-2"></i> Heart</a></li>
                                        <li><a class="dropdown-item" href="#" data-icon="fas fa-star"><i class="fas fa-star me-2"></i> Star</a></li>
                                        <li><a class="dropdown-item" href="#" data-icon="fas fa-camera"><i class="fas fa-camera me-2"></i> Camera</a></li>
                                        <li><a class="dropdown-item" href="#" data-icon="fas fa-bell"><i class="fas fa-bell me-2"></i> Bell</a></li>
                                        <li><a class="dropdown-item" href="#" data-icon="fas fa-search"><i class="fas fa-search me-2"></i> Search</a></li>
                                        <li><a class="dropdown-item" href="#" data-icon="fas fa-trash"><i class="fas fa-trash me-2"></i> Trash</a></li>
                                        <li><a class="dropdown-item" href="#" data-icon="fas fa-edit"><i class="fas fa-edit me-2"></i> Edit</a></li>
                                        <li><a class="dropdown-item" href="#" data-icon="fas fa-lock"><i class="fas fa-lock me-2"></i> Lock</a></li>
                                        <li><a class="dropdown-item" href="#" data-icon="fas fa-unlock"><i class="fas fa-unlock me-2"></i> Unlock</a></li>
                                    </ul>
                                    <input type="hidden" id="icon" name="icon" value="fas fa-plus-circle">
                                </div>

                                <script>
                                    document.querySelectorAll('.dropdown-item').forEach(item => {
                                        item.addEventListener('click', function (e) {
                                            e.preventDefault();
                                            const selectedIcon = this.getAttribute('data-icon');
                                            document.getElementById('selectedIcon').className = selectedIcon + ' me-2';
                                            document.getElementById('icon').value = selectedIcon;
                                        });
                                    });
                                </script>
                            </div>
                            <span class="text-danger small" id="icon_Error"></span>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <label for="bg_color">{{ __('messages.bg_color') }}</label>
                            <input type="color" class="form-control px-0" id="bg_color" name="bg_color" value="#0ba360" style="width: 100%; height: 40px;">
                            <span class="text-danger small" id="bg_color_Error"></span>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <label for="text_color">{{ __('messages.text_color') }}</label>
                            <input type="color" class="form-control px-0" id="text_color" name="text_color" value="#FFFFFF" style="width: 100%; height: 40px;">
                            <span class="text-danger small" id="text_color_Error"></span>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button class="btn btn-danger" data-bs-dismiss="modal" id="ShortcutMenuModalClose" type="button">{{ __('messages.cancel') }}</button>
                        <button class="btn btn-success" type="button" id="addShortcutMenu" onclick="addShortcutMenu();">{{ __('messages.add') }}</button>
                        <button class="btn btn-info" type="button" id="updateShortcutMenu" onclick="updateShortcutMenu();">{{ __('messages.update') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    {{-- ----------------------------------------------------------------------------------------------------------------------------------- --}}
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="carf-token"]').attr('content')
            }
        });

        function clearShortcutMenuField() {
            $('#title').val('');
            $('#title_Error').text('');
            $('#title').removeClass('border-danger');
            $('#address').val('');
            $('#address_Error').text('');
            $('#address').removeClass('border-danger');
            $('#img').val('');
            $('#img_Error').text('');
            $('#img').removeClass('border-danger');
            $('#icon').val('');
            $('#icon_Error').text('');
            $('#icon').removeClass('border-danger');
            $('#bg_color').val('');
            $('#bg_color_Error').text('');
            $('#bg_color').removeClass('border-danger');
            $('#text_color').val('');
            $('#text_color_Error').text('');
            $('#text_color').removeClass('border-danger');
        }

        // add client using ajax
        function addShortcutMenu() {
            var title = $('#title').val();
            var address = $('#address').val();
            var img = $('#img').val();
            var icon = $('#icon').val();
            var bg_color = $('#bg_color').val();
            var text_color = $('#text_color').val();
            $.ajax({
                type: "POST",
                dataType: "json",
                data: {
                    title: title,
                    address: address,
                    img: img,
                    icon: icon,
                    bg_color: bg_color,
                    text_color: text_color,
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                url: "{{ route('user.configuration.shortcut-menu.store') }}",
                success: function(group) {
                    clearShortcutMenuField();

                    $("#ShortcutMenuModalClose").click();
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Product added successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    $('#file-export-datatable').DataTable().ajax.reload();
                },
                error: function(error) {
                    var $errors = error.responseJSON.errors;

                    if ($errors.title) {
                        $('#title_Error').text($errors.title);
                        $('#title').addClass('border-danger');
                        toastr.error($errors.title);
                    }
                    if ($errors.address) {
                        $('#address_Error').text($errors.address);
                        $('#address').addClass('border-danger');
                        toastr.error($errors.address);
                    }
                    if ($errors.position) {
                        $('#position_Error').text($errors.position);
                        $('#position').addClass('border-danger');
                        toastr.error($errors.position);
                    }
                    if ($errors.img) {
                        $('#img_Error').text($errors.img);
                        $('#img').addClass('border-danger');
                        toastr.error($errors.img);
                    }
                    if ($errors.icon) {
                        $('#icon_Error').text($errors.icon);
                        $('#icon').addClass('border-danger');
                        toastr.error($errors.icon);
                    }
                    if ($errors.bg_color) {
                        $('#bg_color_Error').text($errors.bg_color);
                        $('#bg_color').addClass('border-danger');
                        toastr.error($errors.bg_color);
                    }
                    if ($errors.text_color) {
                        $('#text_color_Error').text($errors.text_color);
                        $('#text_color').addClass('border-danger');
                        toastr.error($errors.text_color);
                    }
                }
            });
        }

        // add product using ajax


        // edit product using ajax
        function edit(id) {
            var data_id = id;

            var url = '{{ route('user.configuration.shortcut-menu.edit', ':id') }}';
            url = url.replace(':id', data_id);

            $.ajax({
                type: "GET",
                dataType: "json",
                url: url,

                success: function(data) {
                    // adding the data to fields
                    $('#title').val(data.title);
                    $('#address').val(data.address);
                    $('#icon').val(data.icon).trigger('change');
                    $('#bg_color').val(data.bg_color);
                    $('#text_color').val(data.text_color);
                    $('#row_id').val(data.id);
                    // adding the data to fields

                    // // hide show btn
                    $('#addShortcutMenu').addClass('d-none');
                    $('#addText').addClass('d-none');
                    $('#updateText').removeClass('d-none');
                    $('#updateShortcutMenu').removeClass('d-none');
                    // hide show btn

                    // modal show when edit button is clicked
                    $("#shortcutMenuModal").modal("show");
                    // modal show when edit button is clicked
                    setTimeout(() => {
                        $('.animated-label').addClass('active-label')
                    }, 500);
                },
                error: function(error) {
                    Swal.fire({
                        position: 'top-center',
                        icon: 'error',
                        title: 'Group Not Found!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            })
        }
        // edit client using ajax

        // update data using ajax
        function updateShortcutMenu(id) {
            //var receive_id = $('#row_id').val();

            var data_id = $('#row_id').val();
            var title = $('#title').val();
            var address = $('#address').val();
            var icon = $('#icon').val();
            console.log(icon);
            var img = $('#img').val();
            var bg_color = $('#bg_color').val();
            var text_color = $('#text_color').val();


            var url = '{{ route('user.configuration.shortcut-menu.update', ':id') }}';
            url = url.replace(':id', data_id);
            $.ajax({
                type: "PUT",
                dataType: "json",
                data: {
                    title: title,
                    address: address,
                    icon: icon,
                    img: img,
                    bg_color: bg_color,
                    text_color: text_color,
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                url: url,
                success: function(group) {
                    clearShortcutMenuField();

                    $("#ShortcutMenuModalClose").click();
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Group updated successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    $('#file-export-datatable').DataTable().ajax.reload();
                    $("#ShortcutMenuModalClose").click();

                },
                error: function(error) {
                    var $errors = error.responseJSON.errors;
                    if ($errors.title) {
                        $('#title_Error').text($errors.title);
                        $('#title').addClass('border-danger');
                        toastr.error($errors.title);
                    }
                    if ($errors.address) {
                        $('#income_category_Error').text($errors.address);
                        $('#address').addClass('border-danger');
                        toastr.error($errors.address);
                    }
                    if ($errors.position) {
                        $('#position_Error').text($errors.position);
                        $('#position').addClass('border-danger');
                        toastr.error($errors.position);
                    }
                    if ($errors.img) {
                        $('#img_Error').text($errors.img);
                        $('#img').addClass('border-danger');
                        toastr.error($errors.img);
                    }
                    if ($errors.icon) {
                        $('#icon_Error').text($errors.icon);
                        $('#icon').addClass('border-danger');
                        toastr.error($errors.icon);
                    }
                    if ($errors.bg_color) {
                        $('#bg_color_Error').text($errors.bg_color);
                        $('#bg_color').addClass('border-danger');
                        toastr.error($errors.bg_color);
                    }
                    if ($errors.text_color) {
                        $('#text_color_Error').text($errors.text_color);
                        $('#text_color').addClass('border-danger');
                        toastr.error($errors.text_color);
                    }

                }
            })
        }
        // update data using ajax
    </script>
@endpush
