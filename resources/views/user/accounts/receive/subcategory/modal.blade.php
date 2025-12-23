<div class="modal fade" id="receiveSubcategoryModal" tabindex="-1" aria-labelledby="receiveSubcategoryModal" aria-hidden="true">
    <div class="modal-dialog modal-md  " role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title" id="addText">{{ __('messages.receive') }} {{ __('messages.subcategory') }} {{ __('messages.create') }}</h6>
                <h6 class="modal-title d-none" id="updateText">{{ __('messages.update') }} {{ __('messages.receive') }} {{ __('messages.subcategory') }}</h6>
                <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- form field start --}}

                <div class="card-body">
                    <div class="row" id="receive-subcategory-form">
                        <div class="form-group col-xl-12 col-lg-12 col-md-12 mb-4">
                            <div class="d-flex">
                                <div class="input-group" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.receive') }} {{ __('messages.category') }}">
                                    <select name="category_id" class="form-control select2 category_id" id="receive_category_id">
                                    </select>
                                </div>
                            </div>
                            <span class="text-danger small" id="category_Error"></span>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mb-1">
                                <input type="text" class="form-control" name="subcategory_name" id="subcategory_name" placeholder="{{ __('messages.subcategory') }} {{ __('messages.name') }}">
                                <label for="subcategory_name" class="animated-label"><i class="fas fa-layer-group"></i> {{ __('messages.subcategory') }} {{ __('messages.name') }}</label>
                            </div>
                        </div>
                        <span class="text-danger small" id="subcategory_name_Error"></span>
                    </div>
                    <input type="hidden" id="row_id">
                    {{-- form field end --}}
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" type="button" id="addReceiveSubcategory" onclick="addReceiveSubcategory();"><i class="fas fa-plus"></i> {{ __('messages.add') }}</button>
                    <button class="btn btn-info d-none" type="button" id="updateReceiveSubcategory" onclick="updateReceiveSubcategory();"><i class="fas fa-plus"></i> {{ __('messages.update') }}</button>
                    <button class="btn btn-danger" data-bs-dismiss="modal" id="ReceiveSubcategoryModalClose" type="button"><i class="fas fa-ban"></i> {{ __('messages.cancel') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script src="{{ asset('dashboard/js/select2-fetch.js') }}"></script>
    {{-- ----------------------------------------------------------------------------------------------------------------------------------- --}}
    <script>
        $(document).ready(function() {
            fetchReceiveCategories();
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="carf-token"]').attr('content')
            }
        });

        function clearReceiveSubcategoryField() {
            $('#subcategory_name').val('');
            $('#subcategory_name_Error').text('');
            $('#subcategory_name').removeClass('border-danger');

            $('#receive_category_id').val('').trigger('change');
            $('#receive_category_id_Error').text('');
            $('#receive_category_id').removeClass('border-danger');
        }

        $('#receive-subcategory-form').find('input, textarea, select').each(function() {
            var id = this.id;
            $("#" + id + "").on('keyup', function() {
                var length = $("#" + id + "").val().length;
                if (length < 1) {
                    $('#' + id + '').addClass('border-danger');
                    $('#' + id + '_Error').text('Fill the input');
                } else {
                    $('#' + id + '').removeClass('border-danger');
                    $('#' + id + '_Error').text('');
                }
            });
        });

        // add client using ajax
        function addReceiveSubcategory() {
            var name = $('#subcategory_name').val();
            var category_id = $('#receive_category_id').val();
            console.log(name);
            $.ajax({
                type: "POST",
                dataType: "json",
                data: {
                    category_id: category_id,
                    name: name,
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                url: "{{ route('user.configuration.receive-subcategory.store') }}",
                success: function(group) {
                    clearReceiveSubcategoryField();

                    $("#ReceiveSubcategoryModalClose").click();
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Product added successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    $('#file-export-datatable').DataTable().ajax.reload();

                    fetchReceiveSubCategories();
                    // select last inserted data
                    setTimeout(() => {
                        var id = $("#subcategory_id option:last").val();
                        $("#subcategory_id").val(id).trigger('change');
                    }, 1000);
                },
                error: function(error) {
                    var $errors = error.responseJSON.errors;

                    if ($errors.name) {
                        $('#subcategory_name_Error').text($errors.name);
                        $('#subcategory_name').addClass('border-danger');
                        toastr.error($errors.name);
                    }
                    if ($errors.category_id) {
                        $('#category_Error').text($errors.category_id);
                        $('#receive_category_id').addClass('border-danger');
                        toastr.error($errors.category_id);
                    }


                }
            });
        }

        // add product using ajax


        // edit product using ajax
        function edit(id) {
            var data_id = id;
            var url = '{{ route('user.configuration.receive-subcategory.edit', ':id') }}';
            url = url.replace(':id', data_id);
            //console.log(url);

            $.ajax({
                type: "GET",
                dataType: "json",
                url: url,

                success: function(data) {
                    // adding the data to fields
                    $('#subcategory_name').val(data.name);
                    $('#row_id').val(data.id);
                    $('#receive_category_id').val(data.category_id).trigger('change');
                    // adding the data to fields

                    // // hide show btn
                    $('#addReceiveSubcategory').addClass('d-none');
                    $('#addText').addClass('d-none');
                    $('#updateText').removeClass('d-none');
                    $('#updateReceiveSubcategory').removeClass('d-none');
                    // hide show btn

                    // modal show when edit button is clicked
                    $("#receiveSubcategoryModal").modal("show");
                    // modal show when edit button is clicked
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
        function updateReceiveSubcategory(id) {
            //var receive_id = $('#row_id').val();
            var data_id = $('#row_id').val();
            var name = $('#subcategory_name').val();
            var category_id = $('#receive_category_id').val();

            var url = '{{ route('user.configuration.receive-subcategory.update', ':id') }}';
            url = url.replace(':id', data_id);
            $.ajax({
                type: "PUT",
                dataType: "json",
                data: {
                    name: name,
                    category_id: category_id,

                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                url: url,
                success: function(group) {
                    clearReceiveSubcategoryField();

                    $("#ReceiveSubcategoryModalClose").click();
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Group updated successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    $('#file-export-datatable').DataTable().ajax.reload();
                    $("#ReceiveSubcategoryModalClose").click();

                },
                error: function(error) {
                    var $errors = error.responseJSON.errors;
                    if ($errors.name) {
                        $('#subcategory_name_Error').text($errors.name);
                        $('#subcategory_name').addClass('border-danger');
                        toastr.error($errors.name);
                    }
                    if ($errors.category_id) {
                        $('#category_Error').text($errors.category_id);
                        toastr.error($errors.category_id);
                    }


                }
            })
        }
        // update data using ajax
    </script>
@endpush
