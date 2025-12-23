@extends('layouts.user.app')
@section('content')
    @include('layouts.table-css')
    <div class="main-content-body">
        <div class="row row-sm">
            <div class="card px-0">
                <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                    <p class="card-title my-0">{{ $pageTitle }}</p>
                    <div class="d-flex align-items-center">
                        <a href="{{ url()->previous() }}" class="btn btn-secondary me-2"><i class="fas fa-undo d-inline"></i> {{ __('messages.go_back') }}</a>
                        <a href="{{ route('user.supplier-group.index') }}" class="btn btn-secondary me-2">
                            <i class="fas fa-layer-group d-inline"></i> {{ __('messages.supplier') }} {{ __('messages.group') }}
                        </a>
                        <a href="{{ route('user.supplier.create') }}" class="btn btn-success me-2"><i class="fas fa-plus d-inline"></i> {{ __('messages.add') }}</a>
                        <div class="d-flex">
                            <a href="javascript:;" data-bs-target="#youtube-modal" data-bs-toggle="modal" id="youtubeModalInstructionBtn" data-link="https://www.youtube.com/embed/leY6s7skQgg?si=80TGmPfL-gC0i8CR">
                                <img width="100" class="border p-2 rounded-lg bg-white" src="{{ asset('dashboard/img/youtube.jpg') }}" alt="">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row mb-3 mt-4 justify-content-center">
                    <div class="col-md-12 px-4">
                        <div class="row px-1 justify-content-center">
                            <div class="col-md-3 mb-1" id="clients">
                                <label for="search_text">&nbsp;</label>
                                <div class="form-group">
                                    <input type="text" id="search_text" class="form-control" style="width: 100% !important;" placeholder="{{ __('messages.search') . ' ' . __('messages.all') }}">
                                    <label class="animated-label active-label" for="client_id">{{ __('messages.search') . ' ' . __('messages.all') }}</label>
                                </div>
                            </div>
                            <div class="col-md-3 mb-1" id="clients">
                                <label for="supplier_group_id">{{ __('messages.search_by') }} {{ __('messages.supplier_group') }}</label>
                                <select id="supplier_group_id" class="select2 form-control" style="width: 100% !important;">
                                </select>
                            </div>
                            <div id="dateSearch" class="col-md-3">
                                <label for="">{{ __('messages.search_by_date') }}</label>
                                <div class="input-group">
                                    <input type="text" id="starting_date" class="fc-datepicker starting_date form-control" placeholder="DD/MM/YYYY">
                                    <input type="text" id="ending_date" class="fc-datepicker ending_date form-control" placeholder="DD/MM/YYYY">
                                </div>
                            </div>
                            <div class="col-md-3 mb-lg-2 mb-5">
                                <label for="button">&nbsp;</label>
                                <button class="btn btn-block btn-lg btn-secondary" id="clearFilter">{{ __('messages.clear') }} {{ __('messages.filter') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body bg-white table-responsive">
                    {!! $dataTable->table() !!}
                </div>
            </div>
        </div>
    </div>
    @include('user.supplier.view')
    @include('user.supplier.remaining-due-modal')
@endsection

@push('scripts')
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
    <script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
    <script src="{{ asset('dashboard/js/select2-fetch.js') }}"></script>
    <script>
        fetchSupplierGroups();
        $("#clearFilter").on('click', function() {
            $("#search_text").val('');
            $("#supplier_group_id").val('');
            $("#starting_date").val('');
            $("#ending_date").val('');

            fetchSupplierGroups();
            $('#file-export-datatable').DataTable().ajax.reload();
        });

        function updateSupplierWallet(supplier_id) {
            var url = '{{ route('update.supplier.wallet', ':id') }}';
            url = url.replace(':id', supplier_id);
            $.ajax({
                url: url,
                type: 'GET',
                success: function (data) {
                    $('#file-export-datatable').DataTable().ajax.reload();
                    Swal.fire({
                        toast: true,
                        position: 'top-right',
                        icon: 'success',
                        title: data.success,
                        showConfirmButton: false,
                        timer: 1500
                    });
                },
                error: function (error) {
                    Swal.fire({
                        toast: true,
                        position: 'top-right',
                        icon: 'error',
                        title: data.error,
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            });
        }

        $(document).ready(function() {
            $(document).on('change', '.image-input', function() {
                console.log('File input changed');
                let imageMain = $(this).closest('.text-center').find('.image-main');
                setTimeout(() => {
                    var file = this.files[0];
                    if (file) {
                        console.log('File selected:', file);
                        var reader = new FileReader();

                        reader.onload = function(e) {
                            console.log('File read result:', e.target.result);
                            imageMain.attr('src', e.target.result);
                        };
                        reader.readAsDataURL(file);
                    }
                }, 200);
            });
        });

        function remainingDueDate(id) {
            var data_id = id;
            $("#supplier_id_for_due").val(id);
            $("#remainingDueDate").modal('show');
            var url = '{{ route('user.supplier.remaining.due.date', ':id') }}';
            url = url.replace(':id', data_id);
            $.ajax({
                type: "GET",
                dataType: "json",
                url: url,
                success: function(data) {
                    setTimeout(() => {
                        var dueDate = data.remaining_due_date ?? '';
                        $("#remaining_due_date").val(dueDate);
                    }, 200);
                }
            });
        }

        function updateRemainingDueDate() {
            var date = $("#remaining_due_date").val();
            var client_id = $("#supplier_id_for_due").val();
            var url = '{{ route('user.supplier.update.remaining.due.date', ':id') }}';
            url = url.replace(':id', client_id);
            $.ajax({
                type: "GET",
                dataType: "json",
                data: {
                    date: date,
                },
                url: url,
                success: function(data) {
                    $("#remainingDueDate").modal('hide');
                    Swal.fire({
                        position: 'top-center',
                        icon: 'success',
                        title: 'Updated!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    $("#supplier_id_for_due").val('');
                    $('#file-export-datatable').DataTable().ajax.reload();
                },
                error: function(error) {
                    Swal.fire({
                        position: 'top-center',
                        icon: 'error',
                        title: 'Someting went wrong!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            });
        }
        $(function() {
            var dataTable;

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $("#supplier_group_id, #starting_date, #ending_date").on("change", function() {
                dataTable.ajax.reload();
            });
            $("#search_text").on("input", function() {
                dataTable.ajax.reload();
            });

            dataTable = $('#file-export-datatable').DataTable({
                processing: true,
                serverSide: true,
                pageLength: "{{ siteSettings()->page_length }}",
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"],
                ],
                dom: 'lBfrtip',
                buttons: [{
                        extend: 'excel',
                        text: 'Excel',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'print',
                        text: 'Print',
                        exportOptions: {
                            columns: ':visible'
                        },
                        customize: function(win) {
                            var html = $('.header');
                            $(win.document.body).find('h1').css('display', 'none');
                            $(win.document.body).prepend(html);
                        }
                    },
                    'reset',
                    'colvis'
                ],
                ajax: {
                    url: "{{ url()->current() }}",
                    data: function(d) {
                        d.search_text = $("#search_text").val();
                        d.supplier_group = $("#supplier_group_id").val();
                        d.starting_date = $("#starting_date").val();
                        d.ending_date = $("#ending_date").val();
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        console.error("Error: " + textStatus, errorThrown);
                    },
                },

                columns: [{
                        data: 'dt_id',
                        name: 'dt_id',
                        className: 'text-left',
                        orderable: true
                    },
                    {
                        data: 'image',
                        name: 'image',
                        className: 'text-left',
                        orderable: true
                    },
                    {
                        data: 'supplier_info',
                        name: 'supplier_info',
                        className: 'text-left',
                        orderable: true
                    },
                    {
                        data: 'account',
                        name: 'account',
                        className: 'text-left',
                        orderable: true
                    },
                    {
                        data: 'action',
                        name: 'action',
                        className: 'text-left',
                        orderable: true
                    },
                ],
            });

        });
    </script>

    <script>
        function destroy(id) {
            console.log(id);
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
                    var url = '{{ route('user.supplier.destroy', ':id') }}';
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
                                title: 'Payment deleted successfully!',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    });
                }
            })
        }

        function view(id) {
            var supplier_id = id;
            var url = '{{ route('user.supplier.view', ':id') }}';
            url = url.replace(':id', supplier_id);
            $.ajax({
                type: "GET",
                dataType: "json",
                url: url,
                success: function(data) {
                    $("#supplierView").modal('show');
                    setTimeout(() => {
                        $("#modalHeader").text("Supplier View | " + data.supplier_name);
                        $(".supplier_name").text(data.supplier_name);
                        $(".supplier_email").text(data.email);
                        $(".supplier_mobile").text(data.phone);
                        $(".supplier_company").text(data.company_name);
                        $(".supplier_address").text(data.address);
                        $(".supplier_group").text(data.group_name);
                        $(".supplier_zip_code").text(data.zip_code);
                        $(".supplier_country").text(data.country_name);
                    }, 0);
                },
                error: function(error) {
                    Swal.fire({
                        position: 'top-center',
                        icon: 'error',
                        title: 'Client Group Not Found!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            })
        }
    </script>
@endpush
