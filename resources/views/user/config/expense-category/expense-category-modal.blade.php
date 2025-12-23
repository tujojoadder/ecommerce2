<div class="modal fade" id="expenseCategoryModal" tabindex="-1" aria-labelledby="expenseCategoryModal" aria-hidden="true">
    <div class="modal-dialog modal-md  " role="document">
        <div class="modal-content modal-content-demo shadow-lg">
            <div class="modal-header">
                <h6 class="modal-title" id="addExpenseSubcategoryText">{{ __('messages.add_new_expense_category') }}</h6>
                <h6 class="modal-title d-none" id="updateExpenseSubcategoryText">{{ __('messages.update') }} {{ __('messages.expense') }} {{ __('messages.category') }}</h6>
                <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- form field start --}}
                <div class="card-body">
                    <div class="row" id="expense-subcategory-form">
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="form-group">
                                <input type="text" class="form-control" name="name" id="name" placeholder="{{ __('messages.expense') }} {{ __('messages.category') }} {{ __('messages.name') }}">
                                <label for="name" class="animated-label"><i class="fas fa-layer-group"></i> {{ __('messages.expense') }} {{ __('messages.category') }} {{ __('messages.name') }}</label>
                            </div>
                            <span class="text-danger small" id="name_Error"></span>
                        </div>
                    </div>

                    <input type="hidden" id="row_id">
                    {{-- form field end --}}
                </div>
                <div class="modal-footer">

                    <button class="btn btn-success" type="button" id="addExpenseCategory" onclick="addExpenseCategory();"><i class="fas fa-plus"></i> {{ __('messages.add') }}</button>
                    <button class="btn btn-info" type="button" id="updateExpenseCategory" onclick="updateExpenseCategory();"><i class="fas fa-plus"></i> {{ __('messages.update') }}</button>
                    <button class="btn btn btn-danger" data-bs-dismiss="modal" id="ExpenseCategoryModalClose" type="button"><i class="fas fa-ban"></i> {{ __('messages.cancel') }}</button>
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

        function clearExpenseCategoryField() {
            $('#name').val('');
            $('#name_Error').text('');
            $('#name').removeClass('border-danger');


        }

        $('#expense-subcategory-form').find('input, textarea, select').each(function() {
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
        function addExpenseCategory() {
            var expense_category = $('#name').val();


            $.ajax({
                type: "POST",
                dataType: "json",
                data: {
                    name: expense_category,
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                url: "{{ route('user.configuration.expense-category.store') }}",
                success: function(group) {
                    clearExpenseCategoryField();

                    $("#ExpenseCategoryModalClose").click();
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Expense Category added successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    $('#file-export-datatable').DataTable().ajax.reload();
                    // fetch updatd list when data is added from another modal
                    fetchExpenseCategories();
                    // select last inserted data
                    setTimeout(() => {
                        var id = $("#expense_category_id option:last").val();
                        $("#expense_category_id").val(id).trigger('change');
                    }, 1000);
                },
                error: function(error) {
                    var $errors = error.responseJSON.errors;

                    if ($errors.name) {
                        $('#name_Error').text($errors.name);
                        $('#name').addClass('border-danger');
                        toastr.error($errors.name);
                    }


                }
            });
        }

        // add product using ajax


        // edit product using ajax
        function edit(id) {
            var data_id = id;
            var url = '{{ route('user.configuration.expense-category.edit', ':id') }}';
            url = url.replace(':id', data_id);

            $.ajax({
                type: "GET",
                dataType: "json",
                url: url,

                success: function(data) {
                    // adding the data to fields
                    $('#name').val(data.name);
                    $('#row_id').val(data.id);
                    // adding the data to fields

                    // // hide show btn
                    $('#addExpenseCategory').addClass('d-none');
                    $('#addExpenseSubcategoryText').addClass('d-none');
                    $('#updateExpenseSubcategoryText').removeClass('d-none');
                    $('#updateExpenseCategory').removeClass('d-none');
                    // hide show btn

                    // modal show when edit button is clicked
                    $("#expenseCategoryModal").modal("show");
                    // modal show when edit button is clicked
                },
                error: function(error) {
                    Swal.fire({
                        position: 'top-center',
                        icon: 'error',
                        title: 'Expense Category Not Found!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            })
        }
        // edit client using ajax

        // update data using ajax
        function updateExpenseCategory(id) {
            //var receive_id = $('#row_id').val();

            var data_id = $('#row_id').val();
            var name = $('#name').val();


            var url = '{{ route('user.configuration.expense-category.update', ':id') }}';
            url = url.replace(':id', data_id);
            $.ajax({
                type: "PUT",
                dataType: "json",
                data: {
                    name: name,
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                url: url,
                success: function(group) {
                    clearExpenseCategoryField();

                    $("#ExpenseCategoryModalClose").click();
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Expense Category updated successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    $('#file-export-datatable').DataTable().ajax.reload();
                    $("#expenseSubcategoryModalClose").click();

                },
                error: function(error) {
                    var $errors = error.responseJSON.errors;
                    if ($errors.name) {
                        $('#name_Error').text($errors.name);
                        $('#name').addClass('border-danger');
                        toastr.error($errors.name);
                    }


                }
            })
        }
        // update data using ajax
    </script>
@endpush
