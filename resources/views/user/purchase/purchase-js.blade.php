<script>
    $(document).ready(function() {
        // Initialize the row count based on the existing number of rows
        var rowCount = $("#order_table tbody tr").length + 1;

        // Add Row button click event
        $(document).on("click", ".add-row", function() {
            rowCount++;
            // Update row IDs
            updateRowIds();
        });

        // Delete Row button click event
        $(document).on("click", ".delete-row", function() {
            var row = $(this).closest("tr");
            var rowId = row.find("input[name='row_id[]']").val();
            row.remove();

            // Update row IDs
            updateRowIds();
            updateTotalBill();
        });

        // Function to update row IDs
        function updateRowIds() {
            $("#order_table tbody tr").each(function(index) {
                $(this).find("input[name='row_id[]']").val(index + 1);
            });
        }


        // Update total when quantity or price changes
        $(document).on("keyup", ".quantity, [name='selling_price[]'], .purchase-buying_price", function() {
            var row = $(this).closest("tr");
            var quantity = parseFloat(row.find(".quantity").val()) || 0;
            var selling_price = parseFloat(row.find("[name='selling_price[]']").val()) || 0;
            var selling_total = quantity * selling_price;
            row.find(".cal_selling_total").val(selling_total.toFixed(2));

            var buying_price = parseFloat(row.find("[name='buying_price[]']").val()) || 0;
            var buying_total = quantity * buying_price;
            row.find(".cal_buying_total").val(buying_total.toFixed(2));
            $("#discount").keyup(); // invoice bill

            updateTotalBill();
        });

        // Function to update the grand total
        function updateTotalBill() {
            var totalBill = 0;
            $(".cal_buying_total").each(function() {
                totalBill += parseFloat($(this).val()) || 0;
            });
            $(".purchase_bill").val(totalBill.toFixed(2)); // total_total_bill
            $(".grand_total").val(totalBill.toFixed(2)); // grand_total
            $(".total_due").val(totalBill.toFixed(2)); // grand_total
        }

        // update the receive amount and due amount
        $(document).on("keyup", "#receive_amount", function() {
            var receive_amount = parseFloat($("#receive_amount").val());
            var total_bill = parseFloat($(".purchase_bill").val());
        });

        // Update values based on input changes
        $(document).on("keyup", "#discount, #transport_fare, #receive_amount, .purchase_bill, #vat, #vat_type, #discount_type", function() {
            // Get discount details
            var discount_type = $("#discount_type").val();
            var discount = parseFloat($("#discount").val()) || 0; // Convert discount to a number, default to 0 if not valid

            // Get other input values
            var transport_fare = parseFloat($("#transport_fare").val()) || 0; // Convert transport fare to a number, default to 0 if not valid
            var receive_amount = parseFloat($("#receive_amount").val()) || 0; // Convert receive amount to a number, default to 0 if not valid
            var total_bill = parseFloat($(".purchase_bill").val()) || 0; // Convert bill amount to a number, default to 0 if not valid
            var due_amount = parseFloat($("#due_amount").val()) || 0; // Convert due amount to a number, default to 0 if not valid

            // Calculate discount amount based on type
            var discountAmount = (discount_type === 'percentage') ? (total_bill * discount / 100) : discount;

            // Display total bill and total discount
            $(".purchase_bill").val(total_bill); // Display the bill amount
            $(".total_discount").val(discountAmount); // Display the calculated discount amount

            // Display transport fare and labour cost
            $(".transport_fare").val(transport_fare); // Display the transport fare

            // Get VAT details
            var vat_type = $("#vat_type").val();
            var vat = parseFloat($("#vat").val()) || 0; // Convert VAT to a number, default to 0 if not valid

            // Calculate VAT amount based on type
            var vatAmount = (vat_type === 'percentage') ? (total_bill * vat / 100) : vat;

            // Calculate grand total, invoice total bill, and total due
            var invoice_total = total_bill + vatAmount;
            var grand_total = invoice_total + transport_fare - discountAmount;
            var total_due = grand_total - receive_amount;

            // Display VAT, grand total, total payment, invoice total bill, and total due
            $(".total_vat").val(vatAmount); // Display VAT
            // $(".grand_total").val(purchase_bill - vatAmount); // Display invoice total bill without VAT
            $(".grand_total").val(grand_total.toFixed(2)); // Display the calculated grand total with two decimal places
            $(".total_payment").val(receive_amount.toFixed(2)); // Display the receive amount
            $(".total_due").val(total_due.toFixed(2)); // Display the calculated total due with two decimal places
        });


        $("#discount_type").on('change', function() { // when discount type changes, trigger the keyup event on the discount input
            $("#discount").trigger('keyup');
        });
        $("#vat_type").on('change', function() { // when discount type changes, trigger the keyup event on the discount input
            $("#vat").trigger('keyup');
        });
    });
</script>
<script src="{{ asset('dashboard/js/select2-fetch.js') }}"></script>
<script>
    $(document).ready(function() {
        $("#accountAddModalBtn").on('click', function() {
            $("#accountAddModal").modal('show');
        });
        $("#expenseCategoryAddModalBtn").on('click', function() {
            $("#expenseCategoryModal").modal('show');
        });
        $("#receiveCategoryAddModalBtn").on('click', function() {
            $("#receiveCategoryModal").modal('show');
        });
        $("#supplierAddModalBtn").on('click', function() {
            $("#supplierAddModal").modal('show');
        });
    });

    $(document).ready(function() {
        fetchWarehouses();
        fetchSuppliers();
        fetchAccounts();
        fetchProducts();
        @if ($queryString == 'purchase-return' || Request::is('user/invoice/sales-return') || Request::is('user/purchase/edit-page*'))
            fetchReceiveCategories();
        @else
            fetchExpenseCategories();
        @endif
    });

    $("#product_search").on('change', function() {
        var rowCount = $("#order_table tbody tr").length + 1; // initial row index number
        var product_id = $(this).val(); // get product id from product search form

        var url = '{{ route('get.product', ':id') }}';
        url = url.replace(':id', product_id);

        @if (config('purchases_seperate_item') == 1)
            var existingRow = 0;
        @else
            var existingRow = $("#order_table tbody").find("input[name='product_id[]'][value='" + product_id + "']").closest("tr");
        @endif

        if (existingRow.length > 0) {
            var quantityInput = existingRow.find(".quantity");
            var currentQuantity = parseFloat(quantityInput.val());
            quantityInput.val(currentQuantity + 1);

            // Clear and reset the product search input
            $('#product_search').val('');
            $('.quantity').keyup();

            toastr.success("Quantity increase 1+");
        } else {
            $.ajax({
                url: url,
                dataType: 'json',
                success: function(data) {
                    var unit = data.unit ?? 0;
                    var newRow = $(
                        "<tr>" +
                        "<td width='3%'><input type='text' class='form-control fcsm bg-white text-center' name='row_id[]' value='" + rowCount + "' readonly></td>" +
                        "<td><input type='text' class='form-control fcsm purchase-name' value='" + data.name + "' readonly><input type='hidden' value='" + data.id + "' name='product_id[]'></td>" +
                        "<td><input type='number' step='any' class='form-control fcsm quantity' value='1' name='quantity[]'></td>" +
                        @if ($queryString == 'purchase-return' || Request::is('user/invoice/sales-return') || Request::is('user/purchase/edit-page*'))
                            "<td><select class='form-control text-dark rounded form-control-sm select2-tags' name='return_type[]'>" +
                            "<option value='exchange' selected>Exchange</option>" +
                            "<option value='damage'>Damage</option>" +
                            "<option value='expired'>Expired</option>" +
                            "</select></td>" +
                        @endif
                        "<td><input type='number' class='form-control fcsm purchase-buying_price' value='" + data.buying_price + "' name='buying_price[]'></td>" +
                        "<td><input type='number' class='form-control fcsm cal_buying_total' value='' name='total_buying_price[]'></td>" +
                        "<td><input type='number' class='form-control fcsm purchase-selling_price' value='" + data.selling_price + "' name='selling_price[]'></td>" +
                        "<td class='d-none'><input type='hidden' step='any' class='form-control fcsm free' value='0' name='free[]'></td>" +
                        "<td><input type='number' class='form-control fcsm cal_selling_total' readonly value='' name='total_selling_price[]'></td>" +
                        "<td><input type='text' class='form-control fcsm wholesale_price' value='" + data.wholesale_price + "' name='wholesale_price[]'></td>" +
                        "<td><input type='text' class='form-control fcsm text-center bg-white purchase-unit' value='" + data.unit_name + "' readonly><input type='hidden' value='" + data.unit_id + "' name='unit_id[]'></td>" +
                        "<td><input type='text' class='form-control fcsm purchase-description' value='" + data.description + "' name='description[]'></td>" +
                        "<td class='text-center'><a target='_blank' href='{{ route('user.product-barcode.index') }}?product_id=" + data.id + "&quantity=1' class='btn btn-sm btn-dark py-1'><i class='fas fa-qrcode' style='font-size: 15px !important;'></i></a><input type='hidden' class='form-control fcsm' value='" + data.id + "' name='barcode_id[]'></td>" +
                        "<td class='text-center'><a href='javascript:;' class='btn btn-danger btn-sm p-1 delete-row'><i class='fas fa-trash'></i></a></td>" +
                        "</tr>"
                    );
                    $("#order_table tbody").append(newRow);
                    $('.quantity').keyup();
                    $('#product_search').val('').trigger('change');
                }
            });
            $('.select2-tags').select2({
                tags: true
            });
        }
    });
</script>
{{-- ----------------------------------------------------------------------------------------------------------------------------------- --}}
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="carf-token"]').attr('content')
        }
    });

    function clearInvoiceField() {

        $('#invoice_id').val('').trigger('change');
        $('#invoice_id_Error').text('');
        $('#invoice_id').removeClass('border-danger');

        $('#issued_date').val('');
        $('#issued_date_Error').text('');
        $('#issued_date').removeClass('border-danger');

        $('#supplier_id').val('').trigger('change');
        $('#supplier_id_Error').text('');
        $('#supplier_id').removeClass('border-danger');

        $('#warehouse_id').val('').trigger('change');
        $('#warehouse_id_Error').text('');
        $('#warehouse_id').removeClass('border-danger');

        $('#discount').val('');
        $('#discount_Error').text('');
        $('#discount').removeClass('border-danger');

        $('#discount_type').val('').trigger('change');
        $('#discount_type_Error').text('');
        $('#discount_type').removeClass('border-danger');

        $('#transport_fare').val('');
        $('#transport_fare_Error').text('');
        $('#transport_fare').removeClass('border-danger');

        $('#vat').val('');
        $('#vat_Error').text('');
        $('#vat').removeClass('border-danger');

        $('#vat_type').val('').trigger('change');
        $('#vat_type_Error').text('');
        $('#vat_type').removeClass('border-danger');

        $('#account_id').val('').trigger('change');
        $('#account_id_Error').text('');
        $('#account_id').removeClass('border-danger');

        $('#expense_category_id').val('').trigger('change');
        $('#expense_category_id_Error').text('');
        $('#expense_category_id').removeClass('border-danger');

        $('#receive_amount').val('');
        $('#receive_amount_Error').text('');
        $('#receive_amount').removeClass('border-danger');

        $('#purchase_bill').val('');
        $('#purchase_bill_Error').text('');
        $('#purchase_bill').removeClass('border-danger');

        $('#total_vat').val('');
        $('#total_vat_Error').text('');
        $('#total_vat').removeClass('border-danger');

        $('#total_discount').val('');
        $('#total_discount_Error').text('');
        $('#total_discount').removeClass('border-danger');

        $('#grand_total').val('');
        $('#grand_total_Error').text('');
        $('#grand_total').removeClass('border-danger');

        $('#total_due').val('');
        $('#total_due_Error').text('');
        $('#total_due').removeClass('border-danger');
    }


    // add client using ajax
    function addInvoice() {

        var invoice_id = $('#invoice_id').val();
        var issued_date = $('#issued_date').val();
        var supplier_id = $('#supplier_id').val();
        var warehouse_id = $('#warehouse_id').val();
        var discount = $('#discount').val();
        var discount_type = $('#discount_type').val();
        var transport_fare = $('#transport_fare').val();
        var vat = $('#vat').val();
        var vat_type = $('#vat_type').val();
        var account_id = $('#account_id').val();
        var category_id = $('#expense_category_id').val() ?? $("#receive_category_id").val();
        var receive_amount = $('#receive_amount').val();
        var purchase_bill = $('#purchase_bill').val();
        var total_vat = $('#total_vat').val();
        var total_discount = $('#total_discount').val();
        var grand_total = $('#grand_total').val();
        var total_due = $('#total_due').val();

        var tableData = [];
        $('#order_table tbody tr').each(function() {
            var row = $(this);
            var rowData = {
                row_id: row.find('[name="row_id[]"]').val(),
                product_id: row.find('[name="product_id[]"]').val(),
                quantity: row.find('[name="quantity[]"]').val(),
                return_type: row.find('[name="return_type[]"]').val() ?? '',
                free: row.find('[name="free[]"]').val(),
                unit_id: row.find('[name="unit_id[]"]').val(),
                buying_price: row.find('[name="buying_price[]"]').val(),
                total_buying_price: row.find('[name="total_buying_price[]"]').val(),
                selling_price: row.find('[name="selling_price[]"]').val(),
                total_selling_price: row.find('[name="total_selling_price[]"]').val(),
                wholesale_price: row.find('[name="wholesale_price[]"]').val(),
                description: row.find('[name="description[]"]').val(),
                barcode_id: row.find('[name="barcode_id[]"]').val(),
            };
            tableData.push(rowData);
        });


        $.ajax({
            type: "POST",
            dataType: "json",
            data: {
                invoice_id: invoice_id,
                supplier_id: supplier_id,
                warehouse_id: warehouse_id,
                issued_date: issued_date,
                discount: discount,
                discount_type: discount_type,
                transport_fare: transport_fare,
                vat_type: vat_type,
                vat: vat,
                account_id: account_id,
                category_id: category_id,
                receive_amount: receive_amount,
                purchase_bill: purchase_bill,
                total_vat: total_vat,
                total_discount: total_discount,
                grand_total: grand_total,
                total_due: total_due,
                purchase_type: "{{ $queryString == 'purchase-return' ? 'return' : 'default' }}",

                purchased_items: tableData,
                _token: $('meta[name="csrf-token"]').attr('content'),
            },
            url: "{{ route('user.purchase.store') }}",
            success: function(group) {
                clearInvoiceField();
                $("#order_table tbody").empty();

                $("#invoiceModalClose").click();
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'Purchase added successfully!',
                    showConfirmButton: false,
                    timer: 1500
                });
                $('#file-export-datatable').DataTable().ajax.reload();
                setTimeout(function() {
                    @if ($queryString == 'purchase-return')
                        window.location.href = "{{ route('user.purchase.return.invoice') }}";
                    @else
                        window.location.href = "{{ route('user.purchase.invoice') }}";
                    @endif
                }, 1000); // 1000 milliseconds = 1 second
            },
            error: function(error) {
                var $errors = error.responseJSON.errors;

                if ($errors.invoice_id) {
                    $('#invoice_id_Error').text($errors.invoice_id);
                    $('#invoice_id').addClass('border-danger');
                    toastr.error($errors.supplier_id);
                }
                if ($errors.supplier_id) {
                    $('#supplier_id_Error').text($errors.supplier_id);
                    $('#supplier_id').addClass('border-danger');
                    toastr.error($errors.supplier_id);
                }
                if ($errors.warehouse_id) {
                    $('#warehouse_id_Error').text($errors.warehouse_id);
                    $('#warehouse_id').addClass('border-danger');
                    toastr.error($errors.supplier_id);
                }
                if ($errors.issued_date) {
                    $('#issued_date_Error').text($errors.issued_date);
                    $('#issued_date').addClass('border-danger');
                    toastr.error($errors.supplier_id);
                }
                if ($errors.discount) {
                    $('#discount_Error').text($errors.discount);
                    $('#discount').addClass('border-danger');
                    toastr.error($errors.supplier_id);
                }
                if ($errors.discount_type) {
                    $('#discount_type_Error').text($errors.discount_type);
                    $('#discount_type').addClass('border-danger');
                    toastr.error($errors.supplier_id);
                }
                if ($errors.transport_fare) {
                    $('#transport_fare_Error').text($errors.transport_fare);
                    $('#transport_fare').addClass('border-danger');
                    toastr.error($errors.supplier_id);
                }
                if ($errors.vat_type) {
                    $('#vat_type_Error').text($errors.vat_type);
                    $('#vat_type').addClass('border-danger');
                    toastr.error($errors.supplier_id);
                }
                if ($errors.vat) {
                    $('#vat_Error').text($errors.vat);
                    $('#vat').addClass('border-danger');
                    toastr.error($errors.supplier_id);
                }
                if ($errors.account_id) {
                    $('#account_id_Error').text($errors.account_id);
                    $('#account_id').addClass('border-danger');
                    toastr.error($errors.supplier_id);
                }
                if ($errors.category_id) {
                    $('#expense_category_id_Error').text($errors.category_id);
                    $('#expense_category_id').addClass('border-danger');
                    toastr.error($errors.supplier_id);
                }
                if ($errors.receive_amount) {
                    $('#receive_amount_Error').text($errors.receive_amount);
                    $('#receive_amount').addClass('border-danger');
                    toastr.error($errors.supplier_id);
                }
                if ($errors.purchase_bill) {
                    $('#purchase_bill_Error').text($errors.purchase_bill);
                    $('#purchase_bill').addClass('border-danger');
                    toastr.error($errors.supplier_id);
                }
                if ($errors.total_vat) {
                    $('#total_vat_Error').text($errors.total_vat);
                    $('#total_vat').addClass('border-danger');
                    toastr.error($errors.supplier_id);
                }
                if ($errors.total_discount) {
                    $('#total_discount_Error').text($errors.total_discount);
                    $('#total_discount').addClass('border-danger');
                    toastr.error($errors.supplier_id);
                }
                if ($errors.grand_total) {
                    $('#grand_total_Error').text($errors.grand_total);
                    $('#grand_total').addClass('border-danger');
                    toastr.error($errors.supplier_id);
                }
                if ($errors.total_due) {
                    $('#total_due_Error').text($errors.total_due);
                    $('#total_due').addClass('border-danger');
                    toastr.error($errors.supplier_id);
                }
            }
        })
    }
    // add client using ajax

    // update data using ajax
    function updateInvoice(id) {
        var purchased_id = $('#pucrhased_row_id').val();

        // var invoice_id = $('#invoice_id').val();
        var issued_date = $('#issued_date').val();
        var issued_time = "{{ time() }}";
        var supplier_id = $('#supplier_id').val();
        var warehouse_id = $('#warehouse_id').val();
        var discount = $('#discount').val();
        var discount_type = $('#discount_type').val();
        var transport_fare = $('#transport_fare').val();
        var vat = $('#vat').val();
        var vat_type = $('#vat_type').val();
        var account_id = $('#account_id').val();
        var category_id = $('#expense_category_id').val();
        var receive_amount = $('#receive_amount').val();
        var purchase_bill = $('#purchase_bill').val();
        var total_vat = $('#total_vat').val();
        var total_discount = $('#total_discount').val();
        var grand_total = $('#grand_total').val();
        var total_due = $('#total_due').val();

        var tableData = [];
        $('#order_table tbody tr').each(function() {
            var row = $(this);
            var rowData = {
                id: row.find('[name="id[]"]').val(),
                row_id: row.find('[name="row_id[]"]').val(),
                product_id: row.find('[name="product_id[]"]').val(),
                quantity: row.find('[name="quantity[]"]').val(),
                return_type: row.find('[name="return_type[]"]').val() ?? '',
                free: row.find('[name="free[]"]').val(),
                unit_id: row.find('[name="unit_id[]"]').val(),
                buying_price: row.find('[name="buying_price[]"]').val(),
                total_buying_price: row.find('[name="total_buying_price[]"]').val(),
                selling_price: row.find('[name="selling_price[]"]').val(),
                total_selling_price: row.find('[name="total_selling_price[]"]').val(),
                wholesale_price: row.find('[name="wholesale_price[]"]').val(),
                description: row.find('[name="description[]"]').val(),
                barcode_id: row.find('[name="barcode_id[]"]').val(),
            };
            tableData.push(rowData);
        });

        var url = '{{ route('user.purchase.update', ':id') }}';
        url = url.replace(':id', purchased_id);

        $.ajax({
            type: "POST",
            dataType: "json",
            data: {
                invoice_id: "{{ Request::is('user/purchase/edit-page*') ? $purchase->invoice_id : '' }}",
                supplier_id: supplier_id,
                warehouse_id: warehouse_id,
                issued_date: issued_date,
                discount: discount,
                discount_type: discount_type,
                transport_fare: transport_fare,
                vat_type: vat_type,
                vat: vat,
                account_id: account_id,
                category_id: category_id,
                receive_amount: receive_amount,
                purchase_bill: purchase_bill,
                total_vat: total_vat,
                total_discount: total_discount,
                grand_total: grand_total,
                total_due: total_due,
                purchase_type: "{{ $queryString == 'purchase-return' || Request::is('user/invoice/sales-return') || Request::is('user/purchase/edit-page*') ? 'return' : 'default' }}",

                purchased_items: tableData,
                _token: $('meta[name="csrf-token"]').attr('content'),
            },
            url: url,
            success: function(data) {
                clearInvoiceField();
                $("#order_table tbody").empty();

                $("#invoiceModalClose").click();
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'Purchase updated successfully!',
                    showConfirmButton: false,
                    timer: 1500
                });
                $('#file-export-datatable').DataTable().ajax.reload();
                @if ($queryString == 'purchase-return')
                    window.location.href = "{{ route('user.purchase.return.invoice') }}";
                @else
                    window.location.href = "{{ route('user.purchase.invoice') }}";
                @endif
            },
            error: function(error) {
                var $errors = error.responseJSON.errors;
                if ($errors.invoice_id) {
                    $('#invoice_id_Error').text($errors.invoice_id);
                    $('#invoice_id').addClass('border-danger');
                    toastr.error($errors.supplier_id);
                }
                if ($errors.supplier_id) {
                    $('#supplier_id_Error').text($errors.supplier_id);
                    $('#supplier_id').addClass('border-danger');
                    toastr.error($errors.supplier_id);
                }
                if ($errors.warehouse_id) {
                    $('#warehouse_id_Error').text($errors.warehouse_id);
                    $('#warehouse_id').addClass('border-danger');
                    toastr.error($errors.supplier_id);
                }
                if ($errors.issued_date) {
                    $('#issued_date_Error').text($errors.issued_date);
                    $('#issued_date').addClass('border-danger');
                    toastr.error($errors.supplier_id);
                }
                if ($errors.discount) {
                    $('#discount_Error').text($errors.discount);
                    $('#discount').addClass('border-danger');
                    toastr.error($errors.supplier_id);
                }
                if ($errors.discount_type) {
                    $('#discount_type_Error').text($errors.discount_type);
                    $('#discount_type').addClass('border-danger');
                    toastr.error($errors.supplier_id);
                }
                if ($errors.transport_fare) {
                    $('#transport_fare_Error').text($errors.transport_fare);
                    $('#transport_fare').addClass('border-danger');
                    toastr.error($errors.supplier_id);
                }
                if ($errors.vat_type) {
                    $('#vat_type_Error').text($errors.vat_type);
                    $('#vat_type').addClass('border-danger');
                    toastr.error($errors.supplier_id);
                }
                if ($errors.vat) {
                    $('#vat_Error').text($errors.vat);
                    $('#vat').addClass('border-danger');
                    toastr.error($errors.supplier_id);
                }
                if ($errors.account_id) {
                    $('#account_id_Error').text($errors.account_id);
                    $('#account_id').addClass('border-danger');
                    toastr.error($errors.supplier_id);
                }
                if ($errors.category_id) {
                    $('#expense_category_id_Error').text($errors.category_id);
                    $('#expense_category_id').addClass('border-danger');
                    toastr.error($errors.supplier_id);
                }
                if ($errors.receive_amount) {
                    $('#receive_amount_Error').text($errors.receive_amount);
                    $('#receive_amount').addClass('border-danger');
                    toastr.error($errors.supplier_id);
                }
                if ($errors.purchase_bill) {
                    $('#purchase_bill_Error').text($errors.purchase_bill);
                    $('#purchase_bill').addClass('border-danger');
                    toastr.error($errors.supplier_id);
                }
                if ($errors.total_vat) {
                    $('#total_vat_Error').text($errors.total_vat);
                    $('#total_vat').addClass('border-danger');
                    toastr.error($errors.supplier_id);
                }
                if ($errors.total_discount) {
                    $('#total_discount_Error').text($errors.total_discount);
                    $('#total_discount').addClass('border-danger');
                    toastr.error($errors.supplier_id);
                }
                if ($errors.grand_total) {
                    $('#grand_total_Error').text($errors.grand_total);
                    $('#grand_total').addClass('border-danger');
                    toastr.error($errors.supplier_id);
                }
                if ($errors.total_due) {
                    $('#total_due_Error').text($errors.total_due);
                    $('#total_due').addClass('border-danger');
                    toastr.error($errors.supplier_id);
                }
            }
        })
    }
    // update data using ajax
</script>
