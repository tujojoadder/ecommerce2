@extends('layouts.user.app')
@section('content')
    @php
        $queryString = $_SERVER['QUERY_STRING'];
    @endphp
    @include('user.accounts.receive.receive-collapse')
    <div class="main-content-body">
        <div class="row row-sm">
            <div class="card px-0">
                <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                    <p class="card-title my-0">{{ $pageTitle }}</p>
                    <div class="d-flex align-items-center">
                        <a href="{{ url()->previous() }}" class="btn btn-secondary me-2"><i class="fas fa-undo d-inline"></i> {{ __('messages.go_back') }}</a>
                        <a href="{{ route('user.client-group.index') }}" class="btn btn-secondary me-2">
                            <i class="fas fa-layer-group d-inline"></i> {{ __('messages.client') }} {{ __('messages.group') }}
                        </a>
                        @if ($queryString == 'loan')
                            <a href="{{ route('user.client.create') }}?loan" class="btn btn-success me-2"><i class="fas fa-plus d-inline"></i> {{ __('messages.add_new') }}</a>
                        @else
                            <a href="{{ route('user.client.create') }}" class="btn btn-success me-2"><i class="fas fa-plus d-inline"></i> {{ __('messages.add_new') }}</a>
                        @endif
                        <div class="d-flex">
                            <a href="javascript:;" data-bs-target="#youtube-modal" data-bs-toggle="modal" id="youtubeModalInstructionBtn" data-link="https://www.youtube.com/embed/vGrV7oYp93s?si=LXxUqSMaWlRzNZL5">
                                <img width="100" class="border p-2 rounded-lg bg-white" src="{{ asset('dashboard/img/youtube.jpg') }}" alt="">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body bg-white table-responsive">
                    <div class="row mb-3 mt-4 justify-content-center">
                        <div class="col-md-12">
                            <div class="row justify-content-center">
                                <div class="col-md-3 mb-1" id="clients">
                                    <label for="search_text">&nbsp;</label>
                                    <div class="form-group">
                                        <input type="text" id="search_text" class="form-control" style="width: 100% !important;" placeholder="{{ __('messages.search') . ' ' . __('messages.all') }}">
                                        <label class="animated-label active-label" for="client_id">{{ __('messages.search') . ' ' . __('messages.all') }}</label>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-1" id="clients">
                                    <label for="client_id">{{ __('messages.search_by_client') }} {{ __('messages.group') }}</label>
                                    <select id="client_group_id" class="select2 form-control" style="width: 100% !important;">
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
                    {!! $dataTable->table() !!}
                </div>
            </div>
        </div>
    </div>
    {{-- for receive modal --}}
    @include('user.project.project-modal')
    @include('user.client.client-add-modal')
    @include('user.client.view')
    @include('user.accounts.receive.category.modal')
    @include('user.accounts.account.account-modal')
    @include('user.config.chart-of-account.chart-of-account-modal')
    @include('user.config.chart-of-account.chart-group-modal')
    @include('user.client.adjustment-modal')
    @include('user.client.remaining-due-modal')
    {{-- for receive modal --}}
@endsection

@push('scripts')
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
    <script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
    {{-- <script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
    {!! $dataTable->scripts() !!} --}}
    <script src="{{ asset('dashboard/js/select2-fetch.js') }}"></script>
    <script src="{{ asset('dashboard/js/append.js') }}"></script>
    <script>
        $(document).ready(function() {
            fetchClients();
            fetchClientGroups();
            fetchAccounts();
            fetchProjects();
            fetchReceiveCategories();
            fetchChartOfAccount();
            fetchChartOfAccountGroup();
            fetchPaymentMethods();
            fetchInvoiceDue();
        });

        $("#clearFilter").on('click', function() {
            $("#search_text").val('');
            $("#client_group_id").val('');
            $("#starting_date").val('');
            $("#ending_date").val('');

            fetchClients();
            fetchClientGroups();
            $('#file-export-datatable').DataTable().ajax.reload();
        });

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

        // for receive modal
        $(document).ready(function() {
            $("#receiveBtn").click(function() {
                $("#addReceiveModal").modal("show");
            });
            $("#accountModalBtn").click(function() {
                $("#accountAddModal").modal("show");
            });
            $("#receiveCategoryAddModalBtn").click(function() {
                $("#receiveCategoryModal").modal("show");
            });
            $("#chartOfAccountBtn").click(function() {
                $('#updateChartOfAccount').addClass('d-none');
                $("#chartOfAccountModal").modal("show");
            });
            $("#chartOfAccountGroup").click(function() {
                $('#updateChartOfAccountGroup').addClass('d-none');
                $("#ChartOfAccountGroupModal").modal("show");
            });

        });

        function remainingDueDate(id) {
            var data_id = id;
            $("#client_id_for_due").val(id);
            $("#remainingDueDate").modal('show');
            var url = '{{ route('user.client.remaining.due.date', ':id') }}';
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

        function updateClientWallet(client_id) {
            var url = '{{ route('update.client.wallet', ':id') }}';
            url = url.replace(':id', client_id);
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

        function updateRemainingDueDate() {
            var date = $("#remaining_due_date").val();
            var client_id = $("#client_id_for_due").val();
            var url = '{{ route('user.client.update.remaining.due.date', ':id') }}';
            url = url.replace(':id', client_id);
            $.ajax({
                type: "GET",
                dataType: "json",
                data: {
                    remaining_due_date: date,
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
                    $("#client_id_for_due").val('');
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
    </script>
    <script>
        $(function() {
            var dataTable;

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $("#client_group_id, #starting_date, #ending_date").on("change", function() {
                dataTable.ajax.reload();
            });
            $("#search_text").on("input", function() {
                dataTable.ajax.reload();
            });

            dataTable = $('#file-export-datatable').DataTable({
                processing: true,
                serverSide: true,
                pageLength: "{{ siteSettings()->page_length }}",
                dom: 'lBfrtip',
                buttons: [{
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
                    'reset'
                ],
                ajax: {
                    url: "{{ url()->current() }}",
                    data: function(d) {
                        d.search_text = $("#search_text").val();
                        d.client_group = $("#client_group_id").val();
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
                        data: 'client_info',
                        name: 'client_info',
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
                    var url = '{{ route('user.client.destroy', ':id') }}';
                    url = url.replace(':id', data_id);
                    $.ajax({
                        type: "GET",
                        dataType: "json",
                        url: url,
                        success: function(data) {
                            if (data.error != null) {
                                Swal.fire({
                                    toast: true,
                                    position: 'top-end',
                                    icon: 'warning',
                                    title: data.error,
                                    showConfirmButton: false,
                                    timer: 3500
                                });
                            } else {
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
                        }
                    });
                }
            })
        }

        function balanceAdjustmentStatement(id) {
            var data_id = id;
            var url = '{{ route('user.client.get.adjust.balance', ':id') }}';
            url = url.replace(':id', data_id);
            $.ajax({
                type: "GET",
                dataType: "json",
                url: url,
                success: function(data) {
                    console.log(data);
                    $("#balanceAdjustmentModal").modal('show');
                    var row = "";
                    data.forEach((item, index) => {
                        var key = index + 1;
                        row += "<tr>";
                        row += "<td>" + key + "</td>";
                        row += "<td>" + item.date + "</td>";
                        row += "<td>" + item.amount + "</td>";
                        row += "<td>"
                        row += "<a href='javascript:;' onclick='editAdjustBalance(" + item.id + ")' class='btn p-0 pt-1 pb-0 m-1 btn-info'><i class='fas fa-pen'></i></a>";
                        row += "<a href='javascript:;' onclick='destroyAdjustBalance(" + item.id + ")' class='btn p-0 pt-1 pb-0 m-1 btn-danger'><i class='fas fa-trash'></i></a>";
                        row += "</td>"
                        row += "</tr>";
                    });
                    $("#balanceAdjustmentModal .adjustmentTable tbody").html(row);
                }
            });
        }

        function editAdjustBalance(id) {
            var adjust_amount = result.value;
            var data_id = id;
            var url = '{{ route('user.client.edit.adjust.balance', ':id') }}';
            url = url.replace(':id', data_id);
            $.ajax({
                type: "GET",
                dataType: "json",
                url: url,
                success: function(data) {
                    $("#balanceAdjustmentModal").modal('toggle');
                    var amount = data.amount;
                    console.log(amount);
                    Swal.fire({
                        title: "{{ __('messages.edit') }} {{ __('messages.balance_adjustment') }}",
                        text: "{{ __('messages.note') }}: {{ __('messages.adjustment_warning') }}.",
                        input: "number",
                        inputAttributes: {
                            name: "adjust_amount",
                            required: "required",
                            min: 1,
                        },
                        inputValue: amount,
                        showCancelButton: true,
                        confirmButtonText: "Confirm",
                        showLoaderOnConfirm: true,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            var adjust_amount = result.value;
                            var data_id = id;
                            var url = '{{ route('user.client.update.adjust.balance', ':id') }}';
                            url = url.replace(':id', data_id);
                            $.ajax({
                                type: "GET",
                                dataType: "json",
                                data: {
                                    adjustment_amount: adjust_amount
                                },
                                url: url,
                                success: function(data) {
                                    console.log(data);
                                    $('#file-export-datatable').DataTable().ajax.reload();
                                    if (data.error) {
                                        Swal.fire({
                                            toast: true,
                                            position: 'top-end',
                                            icon: 'error',
                                            title: data.error,
                                            showConfirmButton: false,
                                            timer: 1500
                                        });
                                    } else {
                                        Swal.fire({
                                            toast: true,
                                            position: 'top-end',
                                            icon: 'success',
                                            title: data.message,
                                            showConfirmButton: false,
                                            timer: 1500
                                        });
                                    }
                                },
                                error: function(xhr, status, error) {
                                    console.error(xhr.responseText); // Log the error response
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'Failed to fetch user data from GitHub!',
                                    });
                                }
                            });
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText); // Log the error response
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Failed to fetch user data from GitHub!',
                    });
                }
            });
        }

        function destroyAdjustBalance(id) {
            $("#balanceAdjustmentModal").modal('toggle');
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
                    var url = '{{ route('user.client.destroy.adjust.balance', ':id') }}';
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
                                title: 'Adjustment deleted successfully!',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    });
                }
            })
        }

        function adjustDue(id) {
            Swal.fire({
                title: "{{ __('messages.balance_adjustment') }}",
                text: "{{ __('messages.note') }}: {{ __('messages.adjustment_warning') }}.",
                input: "number",
                inputAttributes: {
                    name: "adjust_amount",
                    required: "required",
                    min: 1
                },
                showCancelButton: true,
                confirmButtonText: "Confirm",
                showLoaderOnConfirm: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    var adjust_amount = result.value;
                    var data_id = id;
                    var url = '{{ route('user.client.adjust.balance', ':id') }}';
                    url = url.replace(':id', data_id);
                    $.ajax({
                        type: "GET",
                        dataType: "json",
                        data: {
                            adjustment_amount: adjust_amount
                        },
                        url: url,
                        success: function(data) {
                            $('#file-export-datatable').DataTable().ajax.reload();
                            if (data.error) {
                                Swal.fire({
                                    toast: true,
                                    position: 'top-end',
                                    icon: 'error',
                                    title: data.error,
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            } else {
                                Swal.fire({
                                    toast: true,
                                    position: 'top-end',
                                    icon: 'success',
                                    title: data.message,
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText); // Log the error response
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Failed to fetch user data from GitHub!',
                            });
                        }
                    });
                }
            });
        }

        function receive(id) {
            var client_id = id;
            $("#addReceiveCollapse").collapse('show');
            $("html, body").animate({
                scrollTop: 0
            }, "fast");

            getClientInfo('/get-client-info', client_id);
        }

        function view(id) {
            var client_id = id;
            var url = '{{ route('user.client.view', ':id') }}';
            url = url.replace(':id', client_id);
            $.ajax({
                type: "GET",
                dataType: "json",
                url: url,
                success: function(data) {
                    $("#clientView").modal('show');
                    setTimeout(() => {
                        $("#modalHeader").text("Client View | " + data.client_name);
                        $(".client_id_no").text(data.id_no || '---');
                        $(".client_name").text(data.client_name);
                        $(".client_email").text(data.email || '---');
                        $(".client_mobile").text(data.phone || '---');
                        $(".client_dob").text(data.date_of_birth || '---');
                        $(".client_address").text(data.address || '---');
                        $(".client_group").text(data.group_name || '---');
                        $(".client_zip_code").text(data.zip_code || '---');

                        $("#view_previous_due").text(data.previous_due || '0');
                        $("#view_sales").text(data.sales || '---');
                        $("#view_totalBillAmount").text(data.sales || '---');
                        $("#view_deposit").text(data.receive || '---');
                        $("#view_sales_return").text(data.sales_return || '---');
                        $("#view_money_return").text(data.money_return || '---');
                        $("#view_sales_return_adjustment").text(data.sales_return_adjustment || '---');
                        $("#view_adjustment").text(data.adjustment || '---');
                        $("#view_due").text(data.due || '---');
                        $("#view_remaining_due_date").text(data.remaining_due_date || '---');
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

        function activeToggle(id) {
            var client_id = id;
            var url = '{{ route('user.client.activeToggle', ':id') }}';
            url = url.replace(':id', client_id);
            $.ajax({
                type: "GET",
                dataType: "json",
                url: url,
                success: function(data) {
                    if (data.status == 1) {
                        toastr.success('Client activated!');
                    } else {
                        toastr.error('Client deactivated!');
                    }
                    $('#file-export-datatable').DataTable().ajax.reload();
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
