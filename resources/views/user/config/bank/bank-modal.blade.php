<div class="modal fade" id="bankModal" tabindex="-1" aria-labelledby="bankModal" aria-hidden="true">
    <div class="modal-dialog modal-md  " role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title" id="addText">{{ __('messages.add_new_bank') }}</h6>
                <h6 class="modal-title d-none" id="updateText">{{ __('messages.update') }} {{ __('messages.bank') }}</h6>
                <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- form field start --}}
                <div class="card-body p-0">
                    <div class="row" id="expense-subcategory-form">
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="form-group">
                                <input type="text" class="form-control" name="name" id="name" placeholder="{{ __('messages.bank') }} {{ __('messages.name') }}">
                                <label for="name" class="animated-label"><i class="fas fa-layer-group"></i> {{ __('messages.bank') . ' ' . __('messages.name') }}</label>
                            </div>
                            <span class="text-danger small" id="name_Error"></span>
                        </div>
                        <input type="hidden" id="row_id">
                    </div>
                    <div class="modal-footer pb-0">
                        <button class="btn btn-success" type="button" id="addBank" onclick="addBank();">{{ __('messages.add') }}</button>
                        <button class="btn btn-info d-none" type="button" id="updateBank" onclick="updateBank();">{{ __('messages.update') }}</button>
                        <button class="btn btn-danger" data-bs-dismiss="modal" id="BankModalClose" type="button">{{ __('messages.cancel') }}</button>
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

        function clearBankField() {
            $('#name').val('');
            $('#name_Error').text('');
            $('#name').removeClass('border-danger');


        }

        $('#bank-form').find('input, textarea, select').each(function() {
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
        function addBank() {

            var bank = $('#name').val();


            $.ajax({
                type: "POST",
                dataType: "json",
                data: {
                    name: bank,
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                url: "{{ route('user.configuration.bank.store') }}",
                success: function(group) {
                    clearBankField();

                    $("#BankModalClose").click();
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Bank added successfully!',
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


                }
            });
        }

        // add product using ajax


        // edit product using ajax
        function edit(id) {
            var data_id = id;
            var url = '{{ route('user.configuration.bank.edit', ':id') }}';
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
                    $('#addBank').addClass('d-none');
                    $('#updateText').addClass('d-none');
                    $('#updateText').removeClass('d-none');
                    $('#updateBank').removeClass('d-none');
                    // hide show btn

                    // modal show when edit button is clicked
                    $("#bankModal").modal("show");
                    // modal show when edit button is clicked
                    setTimeout(() => {
                        $('.animated-label').addClass('active-label');
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
        function updateBank(id) {
            //var receive_id = $('#row_id').val();

            var data_id = $('#row_id').val();
            var name = $('#name').val();


            var url = '{{ route('user.configuration.bank.update', ':id') }}';
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
                    clearBankField();

                    $("#BankModalClose").click();
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Bank updated successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    $('#file-export-datatable').DataTable().ajax.reload();
                    $("#BankModalClose").click();

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
