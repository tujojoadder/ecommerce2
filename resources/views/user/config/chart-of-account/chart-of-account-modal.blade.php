<div class="modal fade" id="chartOfAccountModal" tabindex="-1" aria-labelledby="chartOfAccountModal" aria-hidden="true">
    <div class="modal-dialog modal-md  " role="document">
        <div class="modal-content modal-content-demo shadow-lg">
            <div class="modal-header">
                <h6 class="modal-title" id="addText">{{ __('messages.add_chart_of_account') }}</h6>
                <h6 class="modal-title d-none" id="updateText">{{ __('messages.update') }} {{ __('messages.chart_of_account') }}</h6>
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
                                <span class="input-group-text" title="GroupName" id="basic-addon1"><i class="fas fa-bars" title="expense_category"></i></span>
                                <input type="text" class="form-control" name="name" id="chartOfAccountName" placeholder="{{ __('messages.chart_of_account') }} {{ __('messages.name') }}" data-bs-toggle="tooltip-primary" title="{{ __('messages.chart_of_account') }} {{ __('messages.name') }}">
                                <button class="btn btn-success" type="button" id="addChartOfAccount" onclick="addChartOfAccount();">{{ __('messages.add') }}</button>
                                <button class="btn btn-info" type="button" id="updateChartOfAccount" onclick="updateChartOfAccount();">{{ __('messages.update') }}</button>
                            </div>
                            <span class="text-danger small" id="chartOfAccountName_Error"></span>
                        </div>
                    </div>

                    <input type="hidden" id="row_id">
                    {{-- form field end --}}
                </div>
                <div class="modal-footer">

                    <button class="btn btn-sm btn-danger" data-bs-dismiss="modal" id="ChartOfAccountModalClose" type="button">{{ __('messages.cancel') }}</button>
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

        function clearChartOfAccountField() {
            $('#chartOfAccountName').val('');
            $('#chartOfAccountName_Error').text('');
            $('#chartOfAccountName').removeClass('border-danger');


        }

        $('#chart-of-account-form').find('input, textarea, select').each(function() {
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
        function addChartOfAccount() {
            var chartOfAccountName = $('#chartOfAccountName').val();


            $.ajax({
                type: "POST",
                dataType: "json",
                data: {
                    name: chartOfAccountName,
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                url: "{{ route('user.configuration.chart-of-account.store') }}",
                success: function(group) {
                    clearChartOfAccountField();

                    $("#ChartOfAccountModalClose").click();
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
                    fetchChartOfAccount();
                    // select last inserted data
                    setTimeout(() => {
                        var id = $("#chart_account_id option:last").val();
                        $("#chart_account_id").val(id).trigger('change');
                    }, 1000);
                },
                error: function(error) {
                    var $errors = error.responseJSON.errors;

                    if ($errors.name) {
                        $('#chartOfAccountName_Error').text($errors.name);
                        $('#chartOfAccountName').addClass('border-danger');
                        toastr.error($errors.name);
                    }


                }
            });
        }

        // add product using ajax


        // edit product using ajax
        function edit(id) {
            var data_id = id;
            var url = '{{ route('user.configuration.chart-of-account.edit', ':id') }}';
            url = url.replace(':id', data_id);

            $.ajax({
                type: "GET",
                dataType: "json",
                url: url,

                success: function(data) {
                    // adding the data to fields
                    $('#chartOfAccountName').val(data.name);
                    $('#row_id').val(data.id);
                    // adding the data to fields

                    // // hide show btn
                    $('#addChartOfAccount').addClass('d-none');
                    $('#addText').addClass('d-none');
                    $('#updateText').removeClass('d-none');
                    $('#updateChartOfAccount').removeClass('d-none');
                    // hide show btn

                    // modal show when edit button is clicked
                    $("#chartOfAccountModal").modal("show");
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
        function updateChartOfAccount(id) {
            //var receive_id = $('#row_id').val();

            var data_id = $('#row_id').val();
            var name = $('#chartOfAccountName').val();


            var url = '{{ route('user.configuration.chart-of-account.update', ':id') }}';
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
                    clearChartOfAccountField();

                    $("#ChartOfAccountModalClose").click();
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Group updated successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    $('#file-export-datatable').DataTable().ajax.reload();
                    $("#ChartOfAccountModal").click();

                },
                error: function(error) {
                    var $errors = error.responseJSON.errors;
                    if ($errors.name) {
                        $('#chartOfAccountName_Error').text($errors.name);
                        $('#chartOfAccountName').addClass('border-danger');
                        toastr.error($errors.name);
                    }


                }
            })
        }
        // update data using ajax
    </script>
@endpush
