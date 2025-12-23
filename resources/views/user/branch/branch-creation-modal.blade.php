<div class="modal fade" id="branchModal">
    <div class="modal-dialog modal-md  " role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title" id="addText">{{ __('messages.product') }} {{ __('messages.group') }} {{ __('messages.create') }}</h6>
                <h6 class="modal-title d-none" id="updateText">{{ __('messages.update') }} {{ __('messages.product') }} {{ __('messages.group') }} | {{ __('messages.id_no') }}: <span id="voucher_no"></span></h6>
                <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- form field start --}}
                <div class="row" id="product-group-form">
                    <div class="col-xl-12 col-lg-12 col-md-12 m-auto">
                        <div class="form-group">
                            <input type="text" class="form-control" name="name" id="name">
                            <label class="animated-label" for="name"><i class="fas fa-balance-scale"></i> {{ __('messages.branch') }} {{ __('messages.name') }}</label>
                        </div>
                        <span class="text-danger small" id="name_Error"></span>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 m-auto">
                        <div class="form-group">
                            <input type="text" class="form-control" name="address" id="address">
                            <label class="animated-label" for="address"><i class="fas fa-balance-scale"></i> {{ __('messages.branch') }} {{ __('messages.address') }}</label>
                        </div>
                        <span class="text-danger small" id="address_Error"></span>
                    </div>
                </div>

                <input type="hidden" id="row_id">
                {{-- form field end --}}
            </div>
            <div class="modal-footer py-2">
                <button class="btn btn-success" type="button" id="addBranch" onclick="addBranch();"><i class="fas fa-plus"></i> {{ __('messages.add') }}</button>
                <button class="btn btn-info d-none" type="button" id="updateBranch" onclick="updateBranch();"><i class="fas fa-plus"></i> {{ __('messages.update') }}</button>
                <button class="btn btn-danger m-0" data-bs-dismiss="modal" id="branchModalClose" type="button"><i class="fas fa-ban"></i> {{ __('messages.cancel') }}</button>
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

        function clearBranchField() {
            $('#name').val('');
            $('#name_Error').text('');
            $('#name').removeClass('border-danger');

            $('#address').val('');
            $('#address_Error').text('');
            $('#address').removeClass('border-danger');
        }

        $('#product-group-form').find('input, textarea, select').each(function() {
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
        function addBranch() {
            var name = $('#name').val();
            var address = $('#address').val();
            $.ajax({
                type: "POST",
                dataType: "json",
                data: {
                    name: name,
                    address: address,
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                url: "{{ route('user.branch.store') }}",
                success: function(branch) {
                    clearBranchField();

                    $("#branchModalClose").click();
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Branch added successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    $('#file-export-datatable').DataTable().ajax.reload();
                    fetchBrances();
                    // select last inserted data
                    setTimeout(() => {
                        getBranchInfo('/get-branch', branch.id);
                    }, 500);
                },
                error: function(error) {
                    var $errors = error.responseJSON.errors;

                    if ($errors.name) {
                        $('#name_Error').text($errors.name);
                        $('#name').addClass('border-danger');
                        toastr.error($errors.name);
                    }

                    if ($errors.address) {
                        $('#address_Error').text($errors.address);
                        $('#address').addClass('border-danger');
                        toastr.error($errors.address);
                    }
                }
            });
        }

        // add product using ajax


        // edit product using ajax
        function edit(id) {
            var data_id = id;

            var url = '{{ route('user.branch.edit', ':id') }}';
            url = url.replace(':id', data_id);

            $.ajax({
                type: "GET",
                dataType: "json",
                url: url,

                success: function(data) {
                    // adding the data to fields
                    $('#branchModal #name').val(data.name);
                    $('#branchModal #address').val(data.address);
                    $('#branchModal #row_id').val(data.id);
                    $('#branchModal #voucher_id').text(data.id);
                    // adding the data to fields
                    // // hide show btn
                    $('#branchModal #voucher_no').text(data.id);
                    $('#branchModal #addText').addClass('d-none');
                    $('#branchModal #addBranch').addClass('d-none');
                    $('#branchModal #updateText').removeClass('d-none');
                    $('#branchModal #updateBranch').removeClass('d-none');
                    // hide show btn

                    // modal show when edit button is clicked
                    $("#branchModal").modal("show");
                    // modal show when edit button is clicked
                    setTimeout(() => {
                        $('#name').focus();
                    }, 500);
                },
                error: function(error) {
                    Swal.fire({
                        position: 'top-center',
                        icon: 'error',
                        title: 'Branch Not Found!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            })
        }
        // edit client using ajax

        // update data using ajax
        function updateBranch(id) {

            var data_id = $('#row_id').val();
            var name = $('#name').val();
            var address = $('#address').val();

            var url = '{{ route('user.branch.update', ':id') }}';
            url = url.replace(':id', data_id);
            $.ajax({
                type: "PUT",
                dataType: "json",
                data: {
                    name: name,
                    address: address,

                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                url: url,
                success: function(group) {
                    clearBranchField();

                    $("#branchModalClose").click();
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Branch updated successfully!',
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
                    if ($errors.address) {
                        $('#address_Error').text($errors.address);
                        $('#address').addClass('border-danger');
                        toastr.error($errors.address);
                    }
                }
            })
        }
        // update data using ajax
    </script>
@endpush
