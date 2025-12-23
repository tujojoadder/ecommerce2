@extends('layouts.user.app', ['pageTitle' => $pageTitle])
@section('content')
<style>
    /* The switch container */
.custom-switch {
  position: relative;
  display: inline-block;
  width: 50px;   /* switch width */
  height: 28px;  /* switch height */
}

/* Hide default checkbox */
.custom-switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

/* The slider */
.custom-switch .slider {
  position: absolute;
  cursor: pointer;
  top: 0; left: 0; right: 0; bottom: 0;
  background-color: #ccc; /* off color */
  transition: 0.4s;
  border-radius: 28px;
}

/* The circle inside */
.custom-switch .slider::before {
  position: absolute;
  content: "";
  height: 22px;
  width: 22px;
  left: 3px;
  top: 3px;
  background-color: white;
  border-radius: 50%;
  transition: 0.4s;
}

/* Checked state */
.custom-switch input:checked + .slider {
  background-color: #4caf50; /* on color */
}

/* Move circle when checked */
.custom-switch input:checked + .slider::before {
  transform: translateX(22px);
}

</style>
<div class="main-content-body">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <p class="h3">{{ $pageTitle }}</p>
                <button class="btn btn-success" id="createNewCategory">
                    <i class="fas fa-plus"></i> {{ __('messages.add') }} {{ __('messages.category') }}
                </button>
            </div>
        </div>
        <div class="card-body bg-white table-responsive">
            {!! $dataTable->table(['id' => 'categoryTable']) !!}
        </div>
    </div>
</div>

@include('user.category.category-modal')
@endsection

@push('scripts')
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
<script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
<script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
{!! $dataTable->scripts() !!}

<script>
       // Open modal for Add
    let save_method = 'add';   // global
    let category_id = null;    // global

    // Open modal for Add
    $('#createNewCategory').click(function() {
        save_method = 'add';
        category_id = null;
        $('#categoryForm')[0].reset();
        $('#formMethod').val('POST');
        $('#categoryModalLabel').text("{{ __('messages.add') }} {{ __('messages.category') }}");
        $('#saveCategory').text("{{ __('messages.add') }}");
        $('#categoryModal').modal('show');
    });

    // Open modal for Edit
    $(document).on('click', '.editCategory', function() {
        save_method = 'edit';  // set to edit
        category_id = $(this).data('id');
        $('#categoryForm')[0].reset();

        $.get("{{ url('user/category/edit/') }}/" + category_id, function(data) {
            $('#name').val(data.name);
            $('#categoryModalLabel').text("{{ __('messages.update') }} {{ __('messages.category') }}");
            $('#saveCategory').text("{{ __('messages.update') }}");
            $('#categoryModal').modal('show');
        });
    });

    // Save (Add/Update) via AJAX
    

    // Delete
    $(document).on('click', '.deleteCategory', function() {
        let id = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won’t be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "GET",
                    url: "{{ url('user/category/delete') }}/" + id,
                    data: { _token: '{{ csrf_token() }}' },
                    success: function() {
                        $('#categoryTable').DataTable().ajax.reload();
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: 'Category deleted!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                });
            }
        })
    });
</script>
<script>
$(document).ready(function() {
    // Delegate event for dynamically generated elements
    $(document).on('change', '.status-toggle', function() {
        const checkbox = $(this);
        const url = checkbox.data('url');
        const status = checkbox.prop('checked') ? 1 : 0;

        $.ajax({
            url: url,
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                status: status
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        position: "top-end",
                        text: response.message,
                        icon: "success",
                        toast: true,
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        showCloseButton:true,
                    });
                }
            },
            error: function(xhr) {
                Swal.fire({
                    position: "top-end",
                    text: 'Error updating status',
                    icon: "error",
                    toast: true,
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    showCloseButton:true,
                });

                // revert checkbox on error
                checkbox.prop('checked', !checkbox.prop('checked'));
            }
        });
    });
});
</script>

@endpush
