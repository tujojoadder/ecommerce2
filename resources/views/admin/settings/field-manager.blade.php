@extends('layouts.admin.app', ['pageTitle' => 'Dashboard'])

@section('content')
    <div class="main-content-body">
        <div class="card">
            <div class="card-header">
                <h3>{{ $pageTitle }}</h3>
            </div>
            <div class="card-body">
                <div class="row m-auto">
                    @php
                        $previousTable = null;
                    @endphp

                    <div class="row">
                        @foreach (config('all') as $item)
                            @if ($previousTable != $item->table_name)
                                @if (!is_null($previousTable))
                                    <div class="clearfix"></div> <!-- Add clearfix to clear floats -->
                    </div> <!-- Close the previous table group -->
                    @endif
                    <div class="table-group form-group col-md-4">
                        <h3>{{ ucwords(str_replace('_', ' ', $item->table_name)) }}</h3>
                        @endif
                        <div class="group-section" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ ucwords(str_replace('_', ' ', $item->field_name)) }}">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">{{ ucwords(str_replace('_', ' ', $item->field_name)) }}</span>
                                <input type="checkbox" title="{{ $item->table_name }}" name="{{ $item->field_name }}" class="form-switch-input" {{ $item->status == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>
                        @php
                            $previousTable = $item->table_name;
                        @endphp
                        @endforeach
                    </div>
                </div>

                <h3>Preset Select</h3>
                <div class="row mt-3 mx-auto">
                    @include('user.settings.preset')
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="carf-token"]').attr('content')
            }
        });

        function capitalizeWords(str) {
            return str.replace(/\b\w/g, function(match) {
                return match.toUpperCase();
            });
        }
        $("input").on('click', function() {
            var table_name = $(this).prop("title");
            var field_name = $(this).prop("name");
            var status = $(this).prop("checked");

            var url = '{{ route('enable.disable.field', [':table', ':field']) }}';
            url = url.replace(':table', table_name).replace(':field', field_name);

            $.ajax({
                type: "GET",
                dataType: "json",
                url: url,
                success: function(data) {
                    var name = field_name.replace(/_/g, ' ');
                    toastr.success(capitalizeWords(name) + " Successfully Updated!");
                },
                error: function(error) {
                    Swal.fire({
                        position: 'top-center',
                        icon: 'error',
                        title: 'Not Found!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            })
        });
    </script>

    <script src="{{ asset('dashboard/js/preset.js') }}"></script>
    @if (presets() != null)
        <script>
            preset('client_id', '/get-client-info', "{{ presets()->client_id }}");
            preset('supplier_id', '/get-supplier-info', "{{ presets()->supplier_id }}");
            preset('client_group_id', '/get-client-group', "{{ presets()->client_group_id }}");
            preset('supplier_group_id', '/get-supplier-group', "{{ presets()->supplier_group_id }}");
            preset('expense_category_id', '/get-expense-category', "{{ presets()->expense_category_id }}");
            preset('receive_category_id', '/get-receive-category', "{{ presets()->receive_category_id }}");
            preset('account_id', '/get-account', "{{ presets()->account_id }}");
        </script>
    @endif
@endpush
