@extends('layouts.user.app', ['pageTitle' => $pageTitle])
@section('content')
    @php
        $queryString = $_SERVER['QUERY_STRING'];
        $month = $_GET['month'] ?? 0;
        $year = $_GET['year'] ?? 0;
        $staff_id = $_GET['staff_id'] ?? 0;
    @endphp
    <div class="main-content-body">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mb-2">
                    <div class="card-body">
                        <form action="{{ route('user.staff.attendance.monthly') }}" method="GET">
                            <div class="row justify-content-center">
                                <div class="col-md-12">
                                    <div class="d-flex align-items-end justify-content-between">
                                        <div class="input-group me-1" data-bs-placement="bottom" data-bs-toggle="tooltip-primary" title="{{ __('messages.staff') }}">
                                            <select name="staff_id" id="staff_id" class="form-control select2 staff_id" required>
                                            </select>
                                        </div>
                                        <div class="input-group me-1" data-bs-placement="bottom" data-bs-toggle="tooltip-primary" title="{{ __('messages.month') }}">
                                            <select name="month" id="month" class="form-control select2 month" required>
                                                <option {{ $month == 1 ? 'selected' : '' }} value="1">January</option>
                                                <option {{ $month == 2 ? 'selected' : '' }} value="2">February</option>
                                                <option {{ $month == 3 ? 'selected' : '' }} value="3">March</option>
                                                <option {{ $month == 4 ? 'selected' : '' }} value="4">April</option>
                                                <option {{ $month == 5 ? 'selected' : '' }} value="5">May</option>
                                                <option {{ $month == 6 ? 'selected' : '' }} value="6">June</option>
                                                <option {{ $month == 7 ? 'selected' : '' }} value="7">July</option>
                                                <option {{ $month == 8 ? 'selected' : '' }} value="8">August</option>
                                                <option {{ $month == 9 ? 'selected' : '' }} value="9">September</option>
                                                <option {{ $month == 10 ? 'selected' : '' }} value="10">October</option>
                                                <option {{ $month == 11 ? 'selected' : '' }} value="11">November</option>
                                                <option {{ $month == 12 ? 'selected' : '' }} value="12">December</option>
                                            </select>
                                        </div>
                                        <div class="input-group me-1" data-bs-placement="bottom" data-bs-toggle="tooltip-primary" title="{{ __('messages.year') }}">
                                            <select name="year" id="year" class="form-control select2 year" required>
                                                @for ($i = date('Y') - 2; $i <= date('Y'); $i++)
                                                    <option {{ ($year ? ($year == $i ? 'selected' : '') : date('Y') == $i) ? 'selected' : '' }} value="{{ $i }}">{{ $i }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="input-group">
                                            <button class="btn btn-lg w-100 btn-success">{{ __('messages.search') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @if ($queryString)
            <div class="card mt-3">
                <div class="card-body">
                    @include('layouts.user.print-header')
                    <div class="row justify-content-center">
                        <div class="col-md-12 my-2 table-responsive" id="printableArea">
                            <table class="table table-sm table-bordered yajra-datatable">
                                <thead class="text-center">
                                    <th>{{ __('messages.sl') }}</th>
                                    <th class="date-cell">{{ __('messages.date') }}</th>
                                    <th>{{ __('messages.in_time') }}</th>
                                    <th>{{ __('messages.out_time') }}</th>
                                    <th>{{ __('messages.attendance') }}</th>
                                </thead>
                                <tbody class="text-center">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('dashboard/js/select2-fetch.js') }}"></script>
    <script>
        $(document).ready(function() {
            fetchStaffs();
            setTimeout(() => {
                $("#staff_id").val("{{ $staff_id }}").trigger('change');
            }, 1000);
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


            dataTable = $('.yajra-datatable').DataTable({
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
                        extend: 'pdf',
                        text: 'PDF',
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
                        d.month = "{{ $month }}";
                        d.year = "{{ $year }}";
                        d.staff_id = "{{ $staff_id }}";
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        // Handle the error, e.g., display a message or take appropriate action
                        console.error("Error: " + textStatus, errorThrown);
                    },
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: 'date',
                        name: 'date',
                        searchable: true,
                        orderable: false,
                    },
                    {
                        data: 'in_time',
                        name: 'in_time',
                        orderable: false,
                    },
                    {
                        data: 'out_time',
                        name: 'out_time',
                        orderable: false,
                    },
                    {
                        data: 'attendance',
                        name: 'attendance',
                        orderable: false,
                    },
                ],
                initComplete: function(settings, json) {
                    // Function to calculate and update footer totals
                    function updateFooterTotals() {
                        var totalPresent = 0;
                        var totalLate = 0;
                        var totalAbsence = 0;
                        var totalLeave = 0;

                        // Loop through the rows in the current page
                        dataTable.rows({
                            page: 'current'
                        }).data().each(function(rowData) {
                            var attendanceHtml = rowData.attendance;

                            // Extract the attendance type from the HTML content
                            var attendanceType = $(attendanceHtml).text();

                            if (attendanceType === 'Present') {
                                totalPresent++;
                            } else if (attendanceType === 'Late') {
                                totalLate++;
                            } else if (attendanceType === 'Absence') {
                                totalAbsence++;
                            } else if (attendanceType === 'Leave') {
                                totalLeave++;
                            }
                        });

                        // Update the footer with the totals
                        $('.yajra-datatable tfoot th:eq(1)').text('Total Present: ' + totalPresent);
                        $('.yajra-datatable tfoot th:eq(2)').text('Total Late: ' + totalLate);
                        $('.yajra-datatable tfoot th:eq(3)').text('Total Absence: ' + totalAbsence);
                        $('.yajra-datatable tfoot th:eq(4)').text('Total Leave: ' + totalLeave);
                    }

                    // Add the footer row initially
                    $('.yajra-datatable').append('<tfoot class="text-center"><tr><th>Total: </th><th></th><th></th><th></th><th></th></tr></tfoot>');

                    // Calculate and update footer totals initially
                    updateFooterTotals();

                    // Bind the updateFooterTotals function to the draw.dt event
                    dataTable.on('draw.dt', function() {
                        updateFooterTotals();
                    });
                }

            });
        });
    </script>
@endpush
