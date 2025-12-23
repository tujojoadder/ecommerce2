@extends('layouts.user.app', ['pageTitle' => $pageTitle])
@section('content')
    <div class="main-content-body">
        <div class="card">
            <div class="card-header">
                <div class="text-end">
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="text-center h3 font-weight-light">{{ $pageTitle }}</p>
                        <a href="{{ route('user.product.create') }}" class="btn btn-success"><i class="fas fa-plus"></i> {{ __('messages.add_new') }}</a>
                    </div>
                </div>
            </div>
            <div class="card-body bg-white table-responsive">
                @include('layouts.user.print-header')
                <div class="row mb-3 mt-4 justify-content-center">
                    <div class="col-md-12">
                        <div class="row justify-content-center">
                            <div class="col-md-3 mb-1" id="clients">
                                <label for="client_id">{{ __('messages.search_by_client') }}</label>
                                <select id="client_id" class="select2 form-control" style="width: 100% !important;">
                                </select>
                            </div>
                            <div class="col-md-3 mb-1" id="suppliers">
                                <label for="supplier_id">{{ __('messages.search_by_supplier') }}</label>
                                <select id="supplier_id" class="select2 form-control" style="width: 100% !important;">
                                </select>
                            </div>
                            <div id="dateSearch" class="col-md-3 mb-1">
                                <label for="">{{ __('messages.search_by_date') }}</label>
                                <div class="input-group">
                                    <input type="text" id="starting_date" class="fc-datepicker starting_date form-control" placeholder="DD/MM/YYYY">
                                    <input type="text" id="ending_date" class="fc-datepicker ending_date form-control" placeholder="DD/MM/YYYY">
                                </div>
                            </div>
                            <div class="col-md-3 mb-lg-2 mb-5">
                                <label for="">&nbsp;</label>
                                <button class="btn btn-block btn-lg btn-secondary" id="clearFilter">{{ __('messages.clear') }} {{ __('messages.filter') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
                {!! $dataTable->table() !!}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
    <script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>

    <script src="{{ asset('dashboard/js/select2-fetch.js') }}"></script>
    <script>
        $(document).ready(function() {
            fetchClients();
            fetchSuppliers();
        });

        $("#clearFilter").on('click', function() {
            $("#supplier_id").val('').trigger('change');
            $("#client_id").val('').trigger('change');
            $("#starting_date").val('');
            $("#ending_date").val('');
            $('#file-export-datatable').DataTable().ajax.reload();
        });
    </script>
    <script>
        $(function() {
            var dataTable;

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $("#supplier_id, #client_id, #starting_date, #ending_date").on("change", function() {
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
                searching: false,
                dom: 'lBfrtip',
                buttons: [
                    'reset'
                ],
                ajax: {
                    url: "{{ url()->current() }}",
                    data: function(d) {
                        d.search_text = $("#search_text").val();
                        d.supplier_id = $("#supplier_id").val();
                        d.client_id = $("#client_id").val();
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
                        data: 'sent_to',
                        name: 'sent_to',
                        className: 'text-left',
                        orderable: true
                    },

                    {
                        data: 'message_body',
                        name: 'message_body',
                        className: 'text-left',
                        orderable: true
                    },

                    {
                        data: 'schedule_at',
                        name: 'schedule_at',
                        className: 'text-left',
                        orderable: true
                    },

                    {
                        data: 'status',
                        name: 'status',
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
                    var url = '{{ route('user.product.destroy', ':id') }}';
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
                                title: 'Receive deleted successfully!',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    });
                }
            })
        }

        $("#productBtn").on('click', function() {
            $('#addReceiveText').removeClass('d-none');
            $('#updateReceiveText').addClass('d-none');
            $('#addProduct').removeClass('d-none');
            $('#updateProduct').addClass('d-none');

            $('#product-form').find('input, textarea, select').each(function() {
                var id = this.id;
                $('#' + id + '').val('');
                if (id == 'date') {
                    $('#date').val("{{ date('d/m/Y') }}");
                }
                if (id == 'sms') {
                    $('#sms').prop('checked', false);
                }
                if (id == 'email') {
                    $('#email').prop('checked', false);
                }
            });
        });
        $("#productEditBtn").on('click', function() {
            $('#addReceiveText').addClass('d-none');
            $('#updateReceiveText').addClass('d-none');
            $('#updateProduct').removeClass('d-none');
            $('#addProduct').addClass('d-none');
            $('#updateReceive').removeClass('d-none');

            $('#product-form').find('input, textarea, select').each(function() {
                var id = this.id;
                $('#' + id + '').val('');
                if (id == 'date') {
                    $('#date').val("{{ date('d/m/Y') }}");
                }
                if (id == 'sms') {
                    $('#sms').prop('checked', false);
                }
                if (id == 'email') {
                    $('#email').prop('checked', false);
                }
            });
        });
    </script>
@endpush
