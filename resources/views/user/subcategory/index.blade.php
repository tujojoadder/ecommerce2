@extends('layouts.user.app', ['pageTitle' => $pageTitle])
@section('content')
<div class="main-content-body">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <p class="h3 font-weight-light">{{ $pageTitle }}</p>
                <button type="button" class="btn btn-success" id="addBtn" data-bs-toggle="modal" data-bs-target="#subcategoryModal">
                    <i class="fas fa-plus"></i> {{ __('messages.add') }} {{ __('messages.subcategory') }}
                </button>
            </div>
        </div>
        <div class="card-body bg-white table-responsive">
            {!! $dataTable->table(['id' => 'subcategoryTable']) !!}
        </div>
    </div>
</div>

@include('user.subcategory.sub-cat-modal')
@endsection

@push('scripts')
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
<script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
<script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
{!! $dataTable->scripts() !!}

<script>


    // Add button click
    $('#addBtn').click(function(){
        save_method = 'add';
        edit_id = null;
        $('#subcategoryform')[0].reset();
        $('#modalHeading').text("{{ __('messages.add') }} {{ __('messages.subcategory') }}");
        $('#subcategoryModal').modal('show');
    });

    // Submit form

    // Edit
    function editSubCategory(id){
        $.get("{{ url('user/subcategory/edit') }}/" + id, function(res){
            save_method = 'edit';
            edit_id = id;
            getCategoryInfo('/get-cateogry-info', res.category_id);
            $('#modalHeading').text("{{ __('messages.update') }} {{ __('messages.subcategory') }}");
            $('#subcategoryform')[0].reset();
            $('input[name="name"]').val(res.name);
            $('#subcategoryModal').modal('show');
        });
    }

    // Delete
    function destroy(id){
        Swal.fire({
            title: 'Are you sure?',
            text: "This will be deleted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result)=>{
            if(result.isConfirmed){
                $.ajax({
                    type: "POST",
                    url: "{{ url('user/subcategory/delete') }}/" + id,
                    data: {_token: '{{ csrf_token() }}'},
                    success: function(){
                        $('#subcategoryTable').DataTable().ajax.reload();
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: 'Deleted successfully!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                });
            }
        });
    }
</script>
@endpush
