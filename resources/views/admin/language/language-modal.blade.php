<div class="modal fade" id="languageModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo shadow-lg">
            <div class="modal-header">
                <h6 class="modal-title" id="addText">Add New Language</h6>
                <h6 class="modal-title d-none" id="updateText">Update Language | ID No: <span id="id_no"></span></h6>
                <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row" id="client-group-form">
                    <div class="col-md-6 mb-2">
                        <div class="form-group col-xl-12 col-lg-12 col-md-12 m-auto">
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1"><i class="fas fa-hands-helping"></i></span>
                                <input type="text" class="form-control" name="keyword" id="keyword" placeholder="Keyword Eg: (client_name)">
                            </div>
                            <span class="text-danger small" id="keyword_Error"></span>
                        </div>
                    </div>
                    <div class="col-md-6 mb-2">
                        <div class="form-group col-xl-12 col-lg-12 col-md-12 m-auto">
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1"><i class="fas fa-language"></i></span>
                                <input type="text" class="form-control" name="english" id="english" placeholder="English Eg: (Greetings)">
                            </div>
                            <span class="text-danger small" id="english_Error"></span>
                        </div>
                    </div>
                    <div class="col-md-6 mb-2">
                        <div class="form-group col-xl-12 col-lg-12 col-md-12 m-auto">
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1"><i class="fas fa-language"></i></span>
                                <input type="text" class="form-control" name="bangla" id="bangla" placeholder="Bangla Eg: (আসসালামু আলাইকুম)">
                            </div>
                            <span class="text-danger small" id="bangla_Error"></span>
                        </div>
                    </div>
                    <div class="col-md-6 mb-2">
                        <div class="form-group col-xl-12 col-lg-12 col-md-12 m-auto">
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1"><i class="fas fa-language"></i></span>
                                <input type="text" class="form-control" name="arabic" id="arabic" placeholder="Arabic Eg: (ٱلسَّلَامُ عَلَيْكُمْ)">
                            </div>
                            <span class="text-danger small" id="arabic_Error"></span>
                        </div>
                    </div>
                    <div class="col-md-6 mb-2">
                        <div class="form-group col-xl-12 col-lg-12 col-md-12 m-auto">
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1"><i class="fas fa-language"></i></span>
                                <input type="text" class="form-control" name="hindi" id="hindi" placeholder="Hindi Eg: (असलम अलैकुम)">
                            </div>
                            <span class="text-danger small" id="hindi_Error"></span>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="row_id">
            </div>
            <div class="modal-footer py-2">
                <button class="btn btn-success" type="button" id="addLanguage" onclick="addLanguage();">Add New Language</button>
                <button class="btn btn-info d-none" type="button" id="updateLanguage" onclick="updateLanguage();">Update Language</button>
                <button class="btn btn-danger m-0" data-bs-dismiss="modal" id="languageModalClose" type="button">Cancel</button>
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

        function clearLanguageField() {
            $('#keyword').val('');
            $('#keyword_Error').text('');
            $('#keyword').removeClass('border-danger');
            $('#arabic').val('');
            $('#arabic_Error').text('');
            $('#arabic').removeClass('border-danger');
            $('#bangla').val('');
            $('#bangla_Error').text('');
            $('#bangla').removeClass('border-danger');
            $('#english').val('');
            $('#english_Error').text('');
            $('#english').removeClass('border-danger');
            $('#hindi').val('');
            $('#hindi_Error').text('');
            $('#hindi').removeClass('border-danger');
        }

        // add client using ajax
        function addLanguage() {
            var keyword = $('#keyword').val();
            var arabic = $('#arabic').val();
            var bangla = $('#bangla').val();
            var english = $('#english').val();
            var hindi = $('#hindi').val();
            $.ajax({
                type: "POST",
                dataType: "json",
                data: {
                    keyword: keyword,
                    arabic: arabic,
                    bangla: bangla,
                    english: english,
                    hindi: hindi,
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                url: "{{ route('admin.lang.store') }}",
                success: function(data) {
                    if (data === 'duplicate') {
                        $("#keyword").addClass('border-danger');
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'error',
                            title: 'Duplicate entry!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    } else {
                        clearLanguageField();
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: 'Language added successfully!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        $('#file-export-datatable').DataTable().ajax.reload();
                    }
                },
                error: function(error) {
                    var $errors = error.responseJSON.errors;
                    if ($errors.keyword) {
                        $('#keyword_Error').text($errors.keyword);
                        $('#keyword').addClass('border-danger');
                        toastr.error($errors.keyword);
                    }
                    if ($errors.arabic) {
                        $('#arabic_Error').text($errors.arabic);
                        $('#arabic').addClass('border-danger');
                        toastr.error($errors.arabic);
                    }
                    if ($errors.bangla) {
                        $('#bangla_Error').text($errors.bangla);
                        $('#bangla').addClass('border-danger');
                        toastr.error($errors.bangla);
                    }
                    if ($errors.english) {
                        $('#english_Error').text($errors.english);
                        $('#english').addClass('border-danger');
                        toastr.error($errors.english);
                    }
                    if ($errors.hindi) {
                        $('#hindi_Error').text($errors.hindi);
                        $('#hindi').addClass('border-danger');
                        toastr.error($errors.hindi);
                    }
                }
            });
        }

        // add product using ajax


        // edit product using ajax
        function edit(id) {
            var data_id = id;

            var url = '{{ route('admin.lang.edit', ':id') }}';
            url = url.replace(':id', data_id);

            $.ajax({
                type: "GET",
                dataType: "json",
                url: url,

                success: function(data) {
                    // adding the data to fields
                    $('#keyword').val(data.keyword);
                    $('#arabic').val(data.arabic);
                    $('#bangla').val(data.bangla);
                    $('#english').val(data.english);
                    $('#hindi').val(data.hindi);
                    $('#row_id').val(data.id);
                    // adding the data to fields

                    // // hide show btn
                    $('#id_no').text(data.id);
                    $('#addText').addClass('d-none');
                    $('#addLanguage').addClass('d-none');
                    $('#updateText').removeClass('d-none');
                    $('#updateLanguage').removeClass('d-none');
                    // hide show btn

                    // modal show when edit button is clicked
                    $("#languageModal").modal("show");
                    // modal show when edit button is clicked
                },
                error: function(error) {
                    Swal.fire({
                        position: 'top-center',
                        icon: 'error',
                        title: 'Language Not Found!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            })
        }
        // edit client using ajax

        // update data using ajax
        function updateLanguage(id) {
            var data_id = $('#row_id').val();
            var keyword = $('#keyword').val();
            var arabic = $('#arabic').val();
            var bangla = $('#bangla').val();
            var english = $('#english').val();
            var hindi = $('#hindi').val();

            var url = '{{ route('admin.lang.update', ':id') }}';
            url = url.replace(':id', data_id);
            $.ajax({
                type: "POST",
                dataType: "json",
                data: {
                    keyword: keyword,
                    arabic: arabic,
                    bangla: bangla,
                    english: english,
                    hindi: hindi,
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                url: url,
                success: function(group) {
                    clearLanguageField();
                    $("#languageModalClose").click();
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Language updated successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    $('#file-export-datatable').DataTable().ajax.reload();
                },
                error: function(error) {
                    var $errors = error.responseJSON.errors;
                    if ($errors.keyword) {
                        $('#keyword_Error').text($errors.keyword);
                        $('#keyword').addClass('border-danger');
                        toastr.error($errors.keyword);
                    }
                    if ($errors.arabic) {
                        $('#arabic_Error').text($errors.arabic);
                        $('#arabic').addClass('border-danger');
                        toastr.error($errors.arabic);
                    }
                    if ($errors.bangla) {
                        $('#bangla_Error').text($errors.bangla);
                        $('#bangla').addClass('border-danger');
                        toastr.error($errors.bangla);
                    }
                    if ($errors.english) {
                        $('#english_Error').text($errors.english);
                        $('#english').addClass('border-danger');
                        toastr.error($errors.english);
                    }
                    if ($errors.hindi) {
                        $('#hindi_Error').text($errors.hindi);
                        $('#hindi').addClass('border-danger');
                        toastr.error($errors.hindi);
                    }
                }
            })
        }
        // update data using ajax

        // destroy using ajax
        function destroy(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    var data_id = id;
                    var url = '{{ route('admin.lang.destroy', ':id') }}';
                    url = url.replace(':id', data_id);
                    $.ajax({
                        type: "GET",
                        dataType: "json",
                        url: url,
                        success: function(data) {
                            $('#file-export-datatable').DataTable().ajax.reload();
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'error',
                                title: 'Language deleted successfully!',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    });
                }
            })
        }
        // destroy using ajax
    </script>
@endpush
