<div class="modal fade" id="ChartOfAccountGroupModal">
    <div class="modal-dialog modal-md  " role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title" id="addText">{{ __('messages.add_chart_of_account_group') }}</h6>
                <h6 class="modal-title d-none" id="updateText">{{ __('messages.update') }} {{ __('messages.chart_of_account') }} {{ __('messages.group') }}</h6>
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
                                <span class="input-group-text" title="GroupName" id="basic-addon1"><i class="fas fa-bars" title="{{ __('messages.chart_of_account') }} {{ __('messages.group') }}"></i></span>
                                <input type="text" class="form-control" data-bs-toggle="tooltip-primary" title="Group Name" name="group_name" id="group_name" placeholder="{{ __('messages.chart_of_account') }} {{ __('messages.group') }}">
                            </div>
                            <span class="text-danger small" id="group_name_Error"></span>
                        </div><br><br><br>
                        <div class="form-group col-xl-12 col-lg-12 col-md-12 m-auto">
                            <div class="d-flex">
                                <span class="input-group-text"id="basic-addon1"><i class="fas fa-balance-scale" title="{{ __('messages.chart_of_account') }}"></i></span>
                                <div class="input-group" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.chart_of_account') }}">
                                    <select name="income_category" class="form-control select2" id="chart_of_account_id">
                                    </select>
                                </div>
                            </div>
                            <span class="text-danger small" id="chart_Error"></span>
                        </div>
                    </div>

                    <input type="hidden" id="row_id">
                    {{-- form field end --}}
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" type="button" id="addChartOfAccountGroup" onclick="addChartOfAccountGroup();">{{ __('messages.add') }}</button>
                    <button class="btn btn-info" type="button" id="updateChartOfAccountGroup" onclick="updateChartOfAccountGroup();">{{ __('messages.update') }}</button>
                    <button class="btn btn-danger" data-bs-dismiss="modal" id="ChartOfAccountGroupModalClose" type="button">{{ __('messages.cancel') }}</button>
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

        function clearChartOfAccountGroupField() {
            $('#group_name').val('');
            $('#group_name_Error').text('');
            $('#group_name').removeClass('border-danger');


        }
        //ChartOfAccount Information
        function fetchChartOfAccount2() {
            $.ajax({
                url: "{{ route('get.chart_of_accounts') }}",
                dataType: 'json',
                success: function(data) {
                    var html = '';
                    $.each(data, function(index, value) {
                        html += '<option value="">Select</option>';
                        html += '<option value="' + value.id + '">' + value.name + '</option>';
                    });
                    $('#chart_of_account_id').html(html);
                    // console.log(html);

                }
            });
        }

        $(document).ready(function() {
            fetchChartOfAccount2();
        });

        $('#chart-of-account-group-form').find('input, textarea, select').each(function() {
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
        function addChartOfAccountGroup() {
            var name = $('#group_name').val();
            var chart_id = $('#chart_of_account_id').val();


            $.ajax({
                type: "POST",
                dataType: "json",
                data: {
                    name: name,
                    chart_id: chart_id,
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                url: "{{ route('user.configuration.chart-of-account-group.store') }}",
                success: function(group) {
                    clearChartOfAccountGroupField();

                    $("#ChartOfAccountGroupModalClose").click();
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
                    fetchChartOfAccountGroup();
                    // select last inserted data
                    setTimeout(() => {
                        var id = $("#chart_group_id option:last").val();
                        $("#chart_group_id").val(id).trigger('change');
                    }, 1000);
                },
                error: function(error) {
                    var $errors = error.responseJSON.errors;

                    if ($errors.name) {
                        $('#group_name_Error').text($errors.name);
                        $('#group_name').addClass('border-danger');
                        toastr.error($errors.name);
                    }
                    if ($errors.chart_id) {
                        $('#chart_Error').text($errors.name);
                        $('#chart_of_account_id').addClass('border-danger');
                        toastr.error($errors.chart_id);
                    }


                }
            });
        }

        // add product using ajax


        // edit product using ajax
        function edit(id) {
            var data_id = id;
            var url = "{{ route('user.configuration.chart-of-account-group.edit', ':id') }}";
            url = url.replace(':id', data_id);

            $.ajax({
                type: "GET",
                dataType: "json",
                url: url,

                success: function(data) {
                    // adding the data to fields
                    $('#group_name').val(data.name);
                    $('#chart_of_account_id').val(data.chart_id).trigger('change');
                    $('#row_id').val(data.id);
                    // adding the data to fields

                    // // hide show btn
                    $('#addChartOfAccountGroup').addClass('d-none');
                    $('#addText').addClass('d-none');
                    $('#updateText').removeClass('d-none');
                    $('#updateChartOfAccountGroup').removeClass('d-none');
                    // hide show btn

                    // modal show when edit button is clicked
                    $("#ChartOfAccountGroupModal").modal("show");
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
        function updateChartOfAccountGroup(id) {
            //var receive_id = $('#row_id').val();

            var data_id = $('#row_id').val();
            var chart_id = $('#chart_of_account_id').val();
            var name = $('#group_name').val();


            var url = "{{ route('user.configuration.chart-of-account-group.update', ':id') }}";
            url = url.replace(':id', data_id);
            $.ajax({
                type: "PUT",
                dataType: "json",
                data: {
                    name: name,
                    chart_id: chart_id,

                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                url: url,
                success: function(group) {
                    clearChartOfAccountGroupField();

                    $("#expenseSubcategoryModalClose").click();
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Group updated successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    $('#file-export-datatable').DataTable().ajax.reload();
                    $("#ChartOfAccountGroupModal").click();

                },
                error: function(error) {
                    var $errors = error.responseJSON.errors;
                    if ($errors.name) {
                        $('#group_name_Error').text($errors.name);
                        $('#group_name').addClass('border-danger');
                        toastr.error($errors.name);
                    }
                    if ($errors.chart_id) {
                        $('#chart_Error').text($errors.chart_id);
                        $('#chart_of_account_id').addClass('border-danger');
                        toastr.error($errors.chart_id);
                    }


                }
            })
        }
        // update data using ajax
    </script>
@endpush
