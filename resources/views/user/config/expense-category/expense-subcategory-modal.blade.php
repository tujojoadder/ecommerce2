<style>
    .select2-container {
        z-index: 222222;
    }
</style>
<div class="modal fade" id="ExpenseSubcategoryModal" tabindex="-1" aria-labelledby="ExpenseSubcategoryModal" aria-hidden="true">
    <div class="modal-dialog modal-md  " role="document">
        <div class="modal-content modal-content-demo shadow-lg">
            <div class="modal-header">
                <h6 class="modal-title" id="addText">{{ __('messages.add_new_expense_subcategory') }}</h6>
                <h6 class="modal-title d-none" id="updateText">{{ __('messages.update') }} {{ __('messages.expense') }} {{ __('messages.subcategory') }}</h6>
                <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- form field start --}}
                <div class="card-body">
                    <div class="row" id="expense-subcategory-form">
                        <div class="form-group col-xl-12 col-lg-12 col-md-12 mb-4">
                            <div class="d-flex">
                                <div class="input-group" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.category') }}">
                                    <select name="expense_category" class="form-control select2" id="category_id">
                                    </select>
                                </div>
                            </div>
                            <span class="text-danger small" id="category_Error"></span>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 mb-3">
                            <div class="form-group">
                                <input type="text" class="form-control" data-bs-toggle="tooltip-primary" title="{{ __('messages.subcategory') }} {{ __('messages.name') }}" name="subcategory_name" id="subcategory_name" placeholder="{{ __('messages.subcategory') }} {{ __('messages.name') }}">
                                <label for="subcategory_name" class="animated-label"><i class="fas fa-layer-group"></i> {{ __('messages.subcategory') }} {{ __('messages.name') }}</label>
                            </div>
                            <span class="text-danger small" id="subcategory_name_Error"></span>
                        </div>
                        <input type="hidden" id="row_id">
                        {{-- form field end --}}
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" type="button" id="addexpenseSubcategory" onclick="addExpenseSubcategory();"><i class="fas fa-plus"></i> {{ __('messages.add') }}</button>
                    <button class="btn btn-info" type="button" id="updateExpenseSubcategory" onclick="updateExpenseSubcategory();"><i class="fas fa-plus"></i> {{ __('messages.update') }}</button>
                    <button class="btn btn-danger" data-bs-dismiss="modal" id="ExpenseSubcategoryModalClose" type="button"><i class="fas fa-ban"></i> {{ __('messages.cancel') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    {{-- ----------------------------------------------------------------------------------------------------------------------------------- --}}
    <script>
        function fetchExpenseCategory2() {
            $.ajax({
                url: "{{ route('get.expense.categories') }}",
                dataType: 'json',
                success: function(data) {
                    var html = '';
                    $.each(data, function(index, value) {
                        html += '<option value="">Select</option>';
                        html += '<option value="' + value.id + '">' + value.name + '</option>';
                    });
                    $('#category_id').html(html);
                }
            });
        }
        $(document).ready(function() {
            fetchExpenseCategory2();

        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="carf-token"]').attr('content')
            }
        });

        function clearExpenseCategoryField() {
            $('#subcategory_name').val('');
            $('#subcategory_name_Error').text('');
            $('#subcategory_name').removeClass('border-danger');


        }

        $('#expense-category-form').find('input, textarea, select').each(function() {
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

        // getting all input field id
        // $('#receive-form').find('input, textarea, select').each(function() {
        //     var id = this.id;
        //     $('#' + id + '').val('');
        //     $('#' + id + '_Error').text('Fill the input first');
        //     $('#' + id + '').addClass('border-danger');
        // });

        // add client using ajax
        function addExpenseSubcategory() {
            var name = $('#subcategory_name').val();
            var category_id = $('#category_id').val();
            console.log(name);
            $.ajax({
                type: "POST",
                dataType: "json",
                data: {
                    name: name,
                    category_id: category_id,
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                url: "{{ route('user.configuration.expense-subcategory.store') }}",
                success: function(group) {
                    clearExpenseCategoryField();

                    $("#ExpenseSubcategoryModalClose").click();
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Product added successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    $('#file-export-datatable').DataTable().ajax.reload();
                    // fetch updatd list when data is added from another modal
                    fetchExpenseSubcategories();
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
                        $('#category_id').addClass('border-danger');
                        toastr.error($errors.category_id);
                    }



                }
            });
        }

        // add product using ajax


        // edit product using ajax
        function edit(id) {
            var data_id = id;

            var url = '{{ route('user.configuration.expense-subcategory.edit', ':id') }}';
            url = url.replace(':id', data_id);

            $.ajax({
                type: "GET",
                dataType: "json",
                url: url,

                success: function(data) {
                    // adding the data to fields
                    $('#subcategory_name').val(data.name);
                    $('#row_id').val(data.id);
                    $('#category_id').val(data.category_id).trigger('change');
                    // adding the data to fields

                    // // hide show btn
                    $('#addexpenseSubcategory').addClass('d-none');
                    $('#addText').addClass('d-none');
                    $('#updateText').removeClass('d-none');
                    $('#updateExpenseSubcategory').removeClass('d-none');
                    // hide show btn

                    // modal show when edit button is clicked
                    $("#ExpenseSubcategoryModal").modal("show");
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
        function updateExpenseSubcategory(id) {
            //var receive_id = $('#row_id').val();
            var data_id = $('#row_id').val();
            var name = $('#subcategory_name').val();
            var category_id = $('#category_id').val();

            var url = '{{ route('user.configuration.expense-subcategory.update', ':id') }}';
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
                    clearExpenseCategoryField();

                    $("#ExpenseSubcategoryModalClose").click();
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Expense Subcategory updated successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    $('#file-export-datatable').DataTable().ajax.reload();
                    $("#expenseSubcategoryModalClose").click();

                },
                error: function(error) {
                    var $errors = error.responseJSON.errors;
                    if ($errors.name) {
                        $('#subcategory_name').text($errors.name);
                        $('#name_Error').addClass('border-danger');
                        toastr.error($errors.name);
                    }
                    if ($errors.category_id) {
                        $('#category_Error').text($errors.category_id);
                        $('#category_id').addClass('border-danger');
                        toastr.error($errors.category_id);
                    }


                }
            })
        }
        // update data using ajax
    </script>
@endpush
