<div class="modal fade" id="paymentMethodModal" tabindex="-1" aria-labelledby="paymentMethodModal" aria-hidden="true">
    <div class="modal-dialog modal-md  " role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title" id="addReceiveCategoryText">{{ __('messages.add_payment_method') }}</h6>
                <h6 class="modal-title d-none" id="updateReceiveCategoryText">{{ __('messages.update') }} {{ __('messages.payment') }} {{ __('messages.method') }}</h6>
                <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- form field start --}}
                <div class="card-body">
                    <div class="row" id="Receive-category-form">
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="form-group">
                                <input type="text" class="form-control" name="Receive_category" id="name" placeholder="{{ __('messages.payment') }} {{ __('messages.method') }}" data-bs-toggle="tooltip-primary" title="{{ __('messages.payment') }} {{ __('messages.method') }}">
                                <label for="name" class="animated-label"><i class="fas fa-layer-group"></i> {{ __('messages.payment') }} {{ __('messages.method') }}</label>
                            </div>
                            <span class="text-danger small" id="payment_Error"></span>
                        </div>
                    </div>

                    <input type="hidden" id="row_id">
                    {{-- form field end --}}
                </div>
                <div class="modal-footer">

                    <button class="btn btn-success" type="button" id="addPaymentMethod" onclick="addPaymentMethod();"><i class="fas fa-plus"></i> {{ __('messages.add') }}</button>
                    <button class="btn btn-info d-none" type="button" id="updatePaymentMethod" onclick="updatePaymentMethod();"><i class="fas fa-plus"></i> {{ __('messages.update') }}</button>
                    <button class="btn btn-danger" data-bs-dismiss="modal" id="PaymentMethodModalClose" type="button"><i class="fas fa-ban"></i> {{ __('messages.cancel') }}</button>
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

                function clearPaymentMethodField() {
                    $('#name').val('');
                    $('#name_Error').text('');
                    $('#name').removeClass('border-danger');


                }

                $('#payment-method-form').find('input, textarea, select').each(function() {
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
                function addPaymentMethod() {
                    var name = $('#name').val();


                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        data: {
                            name: name,
                            _token: $('meta[name="csrf-token"]').attr('content'),
                        },
                        url: "{{ route('user.configuration.payment-method.store') }}",
                        success: function(method) {
                            clearPaymentMethodField();

                            $("#PaymentMethodModalClose").click();
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'success',
                                title: 'Product added successfully!',
                                showConfirmButton: false,
                                timer: 1500
                            });
                            $('#file-export-datatable').DataTable().ajax.reload();
                            fetchPaymentMethods();
                            setTimeout(() => {
                                getPaymentMethodInfo('/get-payment-method', method.id);
                            }, 1000);
                        },
                        error: function(error) {
                            var $errors = error.responseJSON.errors;

                            if ($errors.name) {
                                $('#payment_Error').text($errors.name);
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

                    var url = '{{ route('user.configuration.payment-method.edit', ':id') }}';
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
                            $('#addPaymentMethod').addClass('d-none');
                            $('#addText').addClass('d-none');
                            $('#updateText').removeClass('d-none');
                            $('#updatePaymentMethod').removeClass('d-none');
                            // hide show btn

                            // modal show when edit button is clicked
                            $("#paymentMethodModal").modal("show");
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
                function updatePaymentMethod(id) {
                    //var receive_id = $('#row_id').val();

                    var data_id = $('#row_id').val();
                    var name = $('#name').val();


                    var url = '{{ route('user.configuration.payment-method.update', ':id') }}';
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
                            clearPaymentMethodField();

                            $("#ReceiveCategoryModalClose").click();
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'success',
                                title: 'Group updated successfully!',
                                showConfirmButton: false,
                                timer: 1500
                            });
                            $('#file-export-datatable').DataTable().ajax.reload();
                            $("#PaymentMethodModalClose").click();

                        },
                        error: function(error) {
                            var $errors = error.responseJSON.errors;
                            if ($errors.name) {
                                $('#payment_Error').text($errors.name);
                                $('#name').addClass('border-danger');
                                toastr.error($errors.name);
                            }


                        }
                    })
                }
                // update data using ajax
            </script>
        @endpush
