<style>
    .select2-container {
        z-index: 222222 !important;
    }
</style>
<div class="modal fade" id="ChartOfAccountSubcategoryModal" tabindex="-1" aria-labelledby="ChartOfAccountSubcategoryModal" aria-hidden="true">
    <div class="modal-dialog modal-md  " role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title" id="addText">{{ __('messages.add_chart_of_account_subcategory') }}</h6>
                <h6 class="modal-title d-none" id="updateText">{{ __('messages.update') }} {{ __('messages.chart_of_account') }} {{ __('messages.subcategory') }}</h6>
                <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- form field start --}}
                <div class="card-body">
                    <div class="row" id="chart-of-account-form">
                        <div class="form-group col-xl-12 col-lg-12 col-md-12 m-auto">
                            <div class="input-group">
                                <span class="input-group-text" title="GroupName" id="basic-addon1"><i class="fas fa-bars" title=""></i></span>
                                <input type="text" class="form-control" data-bs-toggle="tooltip-primary" title="{{ __('messages.subcategory') }} {{ __('messages.name') }}" name="name" id="name" placeholder="{{ __('messages.subcategory') }} {{ __('messages.name') }}">
                            </div>
                            <span class="text-danger small" id="name_Error"></span>
                        </div>
                        <div class="form-group col-xl-12 col-lg-12 col-md-12 m-auto">
                            <div class="d-flex">
                                <span class="input-group-text"id="basic-addon1"><i class="fas fa-balance-scale" title="{{ __('messages.chart_of_account') }}"></i></span>
                                <div class="input-group" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.chart_of_account') }}">
                                    <select name="income_category" class="form-control select2" id="chart_id">
                                        <option value=""> {{ __('messages.chart_of_account') }}</option>
                                        @foreach ($chart as $row)
                                            <option value="{{ $row->id }}">{{ $row->name }}</option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>
                            <span class="text-danger small" id="chart_Error"></span>
                        </div><br><br>
                        <div class="form-group col-xl-12 col-lg-12 col-md-12 m-auto">
                            <div class="d-flex">
                                <span class="input-group-text"id="basic-addon1"><i class="fas fa-balance-scale" title="{{ __('messages.chart_of_account') }} {{ __('messages.group') }}"></i></span>
                                <div class="input-group" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.group') }}">
                                    <select name="income_category" class="form-control select2" id="group_id">
                                        <option value=""> {{ __('messages.group') }}</option>
                                        @foreach ($group as $rows)
                                            <option value="{{ $rows->id }}">{{ $rows->name }}</option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>
                            <span class="text-danger small" id="group_Error"></span>
                        </div>
                    </div>

                    <input type="hidden" id="row_id">
                    {{-- form field end --}}

                    <div class="modal-footer">
                        <button class="btn btn-success" type="button" id="addChartOfAccountSubcategory" onclick="addChartOfAccountSubcategory();">{{ __('messages.add') }}</button>
                        <button class="btn btn-info" type="button" id="updateChartOfAccountSubcategory" onclick="updateChartOfAccountSubcategory();">{{ __('messages.update') }}</button>
                        <button class="btn btn-danger" data-bs-dismiss="modal" id="ChartOfAccountSubcategoryModalClose" type="button">{{ __('messages.cancel') }}</button>
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

                function clearChartOfAccountSubcategoryField() {
                    $('#name').val('');
                    $('#name_Error').text('');
                    $('#name').removeClass('border-danger');

                    $('#chart_id').val('');
                    $('#chart_Error').text('');
                    $('#chart_id').removeClass('border-danger');

                    $('#group_id').val('');
                    $('#group_Error').text('');
                    $('#group_id').removeClass('border-danger');


                }

                $('#chart-of-account-Subcategory-form').find('input, textarea, select').each(function() {
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
                function addChartOfAccountSubcategory() {
                    var name = $('#name').val();
                    var chart_id = $('#chart_id').val();
                    var group_id = $('#group_id').val();


                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        data: {
                            name: name,
                            chart_id: chart_id,
                            group_id: group_id,
                            _token: $('meta[name="csrf-token"]').attr('content'),
                        },
                        url: "{{ route('user.configuration.chart-of-account-subcategory.store') }}",
                        success: function(Subcategory) {
                            clearChartOfAccountSubcategoryField();

                            $("#ChartOfAccountSubcategoryModalClose").click();
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'success',
                                title: 'Subcategory added successfully!',
                                showConfirmButton: false,
                                timer: 1500
                            });
                            $('#file-export-datatable').DataTable().ajax.reload();
                        },
                        error: function(error) {
                            var $errors = error.responseJSON.errors;

                            if ($errors.name) {
                                $('#name_Error').text($errors.name);
                                $('#name').addClass('border-danger');
                                toastr.error($errors.name);
                            }
                            if ($errors.chart_id) {
                                $('#chart_Error').text($errors.chart_id);
                                $('#chart_id').addClass('border-danger');
                                toastr.error($errors.chart_id);
                            }
                            if ($errors.group_id) {
                                $('#group_Error').text($errors.group_id);
                                $('#group_id').addClass('border-danger');
                                toastr.error($errors.group_id);
                            }


                        }
                    });
                }

                // add product using ajax


                // edit product using ajax
                function edit(id) {
                    var data_id = id;
                    var url = "{{ route('user.configuration.chart-of-account-subcategory.edit', ':id') }}";
                    url = url.replace(':id', data_id);

                    $.ajax({
                        type: "GET",
                        dataType: "json",
                        url: url,

                        success: function(data) {
                            // adding the data to fields
                            $('#name').val(data.name);
                            $('#group_id').val(data.group_id).trigger('change');
                            $('#chart_id').val(data.chart_id).trigger('change');
                            $('#row_id').val(data.id);
                            // adding the data to fields

                            // // hide show btn
                            $('#addChartOfAccountSubcategory').addClass('d-none');
                            $('#addText').addClass('d-none');
                            $('#updateText').removeClass('d-none');
                            $('#updateChartOfAccountSubcategory').removeClass('d-none');
                            // hide show btn

                            // modal show when edit button is clicked
                            $("#ChartOfAccountSubcategoryModal").modal("show");
                            // modal show when edit button is clicked
                        },
                        error: function(error) {
                            Swal.fire({
                                position: 'top-center',
                                icon: 'error',
                                title: 'Subcategory Not Found!',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    })
                }
                // edit client using ajax

                // update data using ajax
                function updateChartOfAccountSubcategory(id) {
                    //var receive_id = $('#row_id').val();

                    var data_id = $('#row_id').val();
                    var chart_id = $('#chart_id').val();
                    var group_id = $('#group_id').val();
                    var name = $('#name').val();


                    var url = "{{ route('user.configuration.chart-of-account-subcategory.update', ':id') }}";
                    url = url.replace(':id', data_id);
                    $.ajax({
                        type: "PUT",
                        dataType: "json",
                        data: {
                            name: name,
                            group_id: group_id,
                            chart_id: chart_id,

                            _token: $('meta[name="csrf-token"]').attr('content'),
                        },
                        url: url,
                        success: function(group) {
                            clearChartOfAccountSubcategoryField();

                            $("#expenseSubcategoryModalClose").click();
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'success',
                                title: 'Subcategory updated successfully!',
                                showConfirmButton: false,
                                timer: 1500
                            });
                            $('#file-export-datatable').DataTable().ajax.reload();
                            $("#ChartOfAccountSubcategoryModal").click();

                        },
                        error: function(error) {
                            var $errors = error.responseJSON.errors;
                            if ($errors.name) {
                                $('#name_Error').text($errors.name);
                                $('#name').addClass('border-danger');
                                toastr.error($errors.name);
                            }
                            if ($errors.chart_id) {
                                $('#chart_Error').text($errors.chart_id);
                                $('#chart_id').addClass('border-danger');
                                toastr.error($errors.chart_id);
                            }
                            if ($errors.group_id) {
                                $('#group_Error').text($errors.group_id);
                                $('#group_id').addClass('border-danger');
                                toastr.error($errors.group_id);
                            }


                        }
                    })
                }
                // update data using ajax
            </script>
        @endpush
