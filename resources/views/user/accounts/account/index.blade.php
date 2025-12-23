@extends('layouts.user.app')
@section('content')
    <div class="main-content-body">
        <div class="row row-sm">
            <div class="card px-0">
                <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                    <p class="card-title my-0">{{ $pageTitle }}</p>
                    <div class="d-flex align-items-center">
                        <a href="{{ url()->previous() }}" class="btn btn-secondary me-2">{{ __('messages.go_back') }}</a>
                        <a href="{{ route('user.account.create') }}" class="btn btn-success me-2">{{ __('messages.add_new') }}</a>
                        <div class="d-flex">
                            <a href="javascript:;" data-bs-target="#youtube-modal" data-bs-toggle="modal" id="youtubeModalInstructionBtn" data-link="https://www.youtube.com/embed/DH9YbBFvQUM?si=KO5UuK4XD1l4Kshi">
                                <img width="100" class="border p-2 rounded-lg bg-white" src="{{ asset('dashboard/img/youtube.jpg') }}" alt="">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body bg-white table-responsive">
                    <div class="row justify-content-center">
                        <div class="col-md-12 my-2 table-responsive" id="printableArea">
                            <table class="table table-sm table-bordered yajra-datatable">
                                <thead class="text-center">
                                    <th>{{ __('messages.id_no') }}</th>
                                    <th>{{ __('messages.title') }}</th>
                                    <th>{{ __('messages.account') }}</th>
                                    <th>{{ __('messages.description') }}</th>
                                    <th>{{ __('messages.contact_person') }}</th>
                                    <th>{{ __('messages.phone_number') }}</th>
                                    <th>{{ __('messages.action') }}</th>
                                </thead>
                                <tbody class="text-center">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card-footer"></div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
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
                    var url = '{{ route('user.account.destroy', ':id') }}';
                    url = url.replace(':id', data_id);
                    $.ajax({
                        type: "GET",
                        dataType: "json",
                        url: url,
                        success: function(data) {
                            $('.yajra-datatable').DataTable().ajax.reload();
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'error',
                                title: 'Account deleted successfully!',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    });
                }
            })
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

            $("#client_id, #client_group_id, .date, .date1").on("change", function() {
                dataTable.ajax.reload();
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
                buttons: [
                    // 'copy',
                    'excel',
                    'csv',
                    'pdf',
                    'print',
                    'reset',
                    'colvis'
                ],
                ajax: {
                    url: "{{ url()->current() }}",
                },
                columns: [{
                        data: 'id',
                        name: 'id',
                        className: 'text-center',
                        searchable: false,
                        orderable: true
                    },
                    {
                        data: 'title',
                        name: 'title',
                        className: 'text-left',
                        orderable: true
                    },
                    {
                        data: 'account_number',
                        name: 'account_number',
                        className: 'text-center',
                        orderable: false
                    },
                    {
                        data: 'description',
                        name: 'description',
                        className: 'text-center',
                        orderable: false
                    },
                    {
                        data: 'contact_person',
                        name: 'contact_person',
                        className: 'text-center',
                        orderable: false
                    },
                    {
                        data: 'phone',
                        name: 'phone',
                        className: 'text-center',
                        orderable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        className: 'text-center',
                        orderable: false
                    },
                ],
            });
        });
    </script>
@endpush
