<script>
    $(document).ready(function() {
        $("#barcode_number").focus();
        // for sales return
        @if ($_SERVER['QUERY_STRING'] == 'sales-return')
            $("#client_id").on('change', function() {
                setTimeout(() => {
                    // to set current due for sales return
                    var due = $('#client_due').attr('title');
                    $('#previous_due_show_only').val(due);

                    $('#previous_due').val(0);
                    $('#previous_due').keyup();
                }, 700);
            });
        @endif

        // Initialize the row count based on the existing number of rows
        var rowCount = $("#order_table tbody tr").length + 1;

        // Add Row button click event
        $(document).on("click", ".add-row", function() {
            rowCount++;
            updateRowIds();
        });

        // Delete Row button click event
        $(document).on("click", ".delete-row", function() {
            var row = $(this).closest("tr");
            var rowId = row.find("input[name='row_id']").val();
            row.remove();
            // Update row IDs
            $('.discount').keyup();
            updateRowIds();
            updateTotalBill();

            getReceiveAmountAutomatically();
        });

        // Function to update row IDs
        function updateRowIds() {
            $("#order_table tbody tr").each(function(index) {
                $(this).find("input[name='row_id']").val(index + 1);
            });
        }

        // Update total when quantity or price changes
        $(document).on("keyup", ".quantity, .return-quantity, .previous_due, [name='selling_price[]']", function() {
            var row = $(this).closest("tr");
            var quantity = parseFloat(row.find(".quantity").val()) || 0;
            var return_quantity = parseFloat(row.find(".return-quantity").val()) || 0;
            var price = parseFloat(row.find("[name='selling_price[]']").val()) || 0;
            var total = (quantity - return_quantity) * price;
            row.find(".total").val(total.toFixed(2));

            updateTotalBill();

            var currentStock = parseFloat(row.find(".total_current_stock").val());

            @if (config('invoices_over_stock_selling') == 1)
                if (quantity > currentStock) {
                    @if (!$salesReturnSection)
                        Swal.fire({
                            toast: true,
                            position: 'top',
                            icon: 'warning',
                            title: 'Over Stock Selling Is On!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    @endif
                    toastr.success("Quantity increased!");
                }
            @else
                if (quantity > currentStock || currentStock < 0) {
                    row.find(".quantity").val(currentStock);
                    row.find(".quantity").keyup();
                    @if (!$salesReturnSection)
                        Swal.fire({
                            toast: true,
                            position: 'top',
                            icon: 'error',
                            title: 'Stock Out!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    @endif
                }
            @endif
        });

        // Function to update the grand total
        function updateTotalBill() {
            var totalBill = 0;
            $(".total").each(function() {
                totalBill += parseFloat($(this).val()) || 0;
            });
            $(".total_bill").val(totalBill.toFixed(2)); // total_bill_amount
            $(".invoice_bill").val(totalBill.toFixed(2)); // invoice bill
            $('#receive_amount').keyup();
        }


        // Update values based on input changes
        $(document).on("keyup", "#discount, #transport_fare, #labour_cost, #receive_amount, #bill_amount, #due_amount, #vat, #vat_type, #discount_type, #adjusting_amount_input", function() {
            // Get discount details
            var discount_type = $("#discount_type").val();
            var discount = parseFloat($("#discount").val()) || 0; // Convert discount to a number, default to 0 if not valid

            // Get other input values
            var transport_fare = parseFloat($("#transport_fare").val()) || 0; // Convert transport fare to a number, default to 0 if not valid
            var labour_cost = parseFloat($("#labour_cost").val()) || 0; // Convert labour cost to a number, default to 0 if not valid
            var receive_amount = parseFloat($("#receive_amount").val()) || 0; // Convert receive amount to a number, default to 0 if not valid
            var line_total = parseFloat($(".total_bill").val()) || 0; // Convert bill amount to a number, default to 0 if not valid
            var due_amount = parseFloat($("#due_amount").val()) || 0; // Convert due amount to a number, default to 0 if not valid
            var previous_due = parseFloat($("#previous_due").val()) || 0;

            // Calculate discount amount based on type
            var discountAmount = (discount_type === 'percentage') ? (line_total * discount / 100) : discount;

            // Display total bill and total discount
            $(".total_bill").val(line_total); // Display the bill amount
            $(".total_discount").val(discountAmount); // Display the calculated discount amount

            // Display transport fare and labour cost
            $(".transport_fare").val(transport_fare); // Display the transport fare
            $(".labour_cost").val(labour_cost); // Display the labour cost

            // Get VAT details
            var vat_type = $("#vat_type").val();
            var vat = parseFloat($("#vat").val()) || 0;

            // Calculate VAT amount based on type
            var vatAmount = (vat_type === 'percentage') ? (line_total * vat / 100) : vat;

            // Calculate grand total, invoice total bill, previous due and total due
            var grand_total = line_total + vatAmount;
            var invoice_bill = grand_total + transport_fare + labour_cost - discountAmount;

            // Display VAT, grand total, total payment, invoice total bill, and total due
            $(".total_vat").val(vatAmount);
            $(".invoice_bill").val(invoice_bill);
            var totalBill = invoice_bill;
            var total_due = totalBill - receive_amount;
            $(".grand_total").val(totalBill.toFixed(2));
            $(".total_payment").val(receive_amount);
            @if ($salesReturnSection)
                $(".adjusting_amount").val(0);
                $(".total_due").val(totalBill - receive_amount);
            @else
                $(".total_due").val(total_due);
            @endif

            // this section is for only showing previous due when sales returning
            var previousDueShowOnly = $("#previous_due_show_only").val();
            $("#upcoming_due_show_only").val(previousDueShowOnly - totalBill);
            // this section is for only showing previous due when sales returning

            $("#bill_amount").val(totalBill.toFixed(2));
            if (receive_amount >= totalBill) {
                $("#due_amount").val(0.00);
            } else {
                var due_amount = (totalBill - receive_amount).toFixed(2);
                $("#due_amount").val(due_amount);
            }
        });

        $(document).on("keyup", "#discount, #transport_fare, #labour_cost, #bill_amount, #due_amount, #vat, #vat_type, #discount_type", function() {
            getReceiveAmountAutomatically();
        });

        $(document).on("keyup", "#discount, #transport_fare, #labour_cost, #bill_amount, #due_amount, #vat, #vat_type, #discount_type", function() {
            getReceiveAmountAutomatically();
        });

        $("#discount_type").on('change', function() { // when discount type changes, trigger the keyup event on the discount input
            $("#discount").trigger('keyup');
        });
        $("#vat_type").on('change', function() { // when discount type changes, trigger the keyup event on the discount input
            $("#vat").trigger('keyup');
        });
    });
</script>

{{-- invoice add product to list js --}}
<script>
    var timeoutId; // Variable to store the timeout ID
    var product_id; // Declare product_id outside the setTimeout function
    var minDelay = 500; // Minimum delay in milliseconds
    $("#barcode_number").on('input', function(event) {
        if (event.ctrlKey && event.key === 'j') {
            event.preventDefault();
            return false;
        }
        var rowCount = $("#order_table tbody tr").length + 1; // Initial row index number
        clearTimeout(timeoutId);

        timeoutId = setTimeout(function() {
            var product_id = $(event.target).val().replace(/,/g, '');

            var purchased_id = $(event.target).val().replace(/,/g, '');
            @if (config('products_custom_barcode_no') == 1)
                var url = '{{ route('get.product', ':id') }}?barcode';
            @else
                var url = '{{ route('get.product', ':id') }}';
            @endif
            url = url.replace(':id', product_id);

            @if (config('invoices_seperate_item') == 1)
                var existingRow = 0;
            @else
                @if (config('products_custom_barcode_no') == 1)
                    var existingRow = $("#order_table tbody").find("input[name='custom_barcode_no[]'][value='" + product_id + "']").closest("tr");
                @else
                    var existingRow = $("#order_table tbody").find("input[name='product_id[]'][value='" + product_id + "']").closest("tr");
                @endif
            @endif

            if (existingRow.length > 0) {
                var quantityInput = existingRow.find(".quantity");
                var currentQuantity = parseFloat(quantityInput.val());

                var currentStock = parseFloat(existingRow.find(".total_current_stock").val());

                @if (config('invoices_over_stock_selling') == 1)
                    quantityInput.val(currentQuantity + 1);
                    toastr.success("Quantity increased!");
                    if (currentQuantity >= currentStock) {
                        @if (!$salesReturnSection)
                            Swal.fire({
                                toast: true,
                                position: 'top',
                                icon: 'warning',
                                title: 'Over Stock Selling Is On!',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        @endif
                    }
                @else
                    if (currentQuantity >= currentStock || currentStock <= 0) {
                        @if (!$salesReturnSection)
                            Swal.fire({
                                toast: true,
                                position: 'top',
                                icon: 'error',
                                title: 'Stock Out!',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        @endif
                    } else {
                        quantityInput.val(currentQuantity + 1);
                        toastr.success("Quantity increased!");
                    }
                @endif

                $('#barcode_number').val('');
                $('#product_search').val('');
                $('.quantity').keyup();
                $('#discount').keyup();
            } else {
                $.ajax({
                    url: url,
                    dataType: 'json',
                    success: function(data) {
                        var unit = data.unit_id ?? null;
                        if (unit !== null) {
                            var unitName = data.unit_name;
                            var unitId = data.unit_id;
                        } else {
                            var unitName = 'None';
                            var unitId = '';
                        }

                        @if (config('products_multi_pricing') == 1)
                            @if (config('products_new_price_sale_only') == 1)
                                var prices = data.multi_price_latest;
                                var buyingPrice = data.multi_price_latest.buying_price;
                            @else
                                var prices = data.multi_price ?? data.selling_price;
                                console.log(prices);
                                var buyingPrice = data.buying_price;
                            @endif
                        @else
                            var prices = [];
                            var buyingPrice = data.buying_price;
                        @endif
                        var priceOptions = "";
                        if (prices.length > 0) {
                            var firstPurchasedId = prices[0]['purchase_id'] ?? '';
                            @if (config('products_new_price_sale_only') == 1)
                                priceOptions += `<option title="${data.purchase_id}" value="${data.buying_price}">${data.buying_price}</option>`;
                            @else
                                prices.forEach(priceData => { // Assuming each price object has a 'price' property
                                    if (Number(priceData.item_wise_stock) > 0) {
                                        priceOptions += `<option title="${priceData.purchase_id}" value="${priceData.buying_price}">${priceData.buying_price}</option>`;
                                    }
                                });
                            @endif
                        } else {
                            var firstPurchasedId = '';
                        }

                        var newRow = $(
                            "<tr>" +
                            "<td width='3%'><input type='text' class='form-control fcsm bg-white text-center' name='row_id' value='" + rowCount + "' readonly></td>" +
                            "<td width='3%'>" +
                            "<select class='form-control text-dark rounded fcsm select2-tags selling_type' name='selling_type[]'>" +
                            "<option value='regular'>Regular</option>" +
                            "<option value='wholesale'>Wholesale</option>" +
                            "</select>" +
                            "</td>" +
                            "<input class='d-none' type='hidden' value='" + firstPurchasedId + "' name='purchased_id[]'><input type='hidden' value='" + data.custom_barcode_no + "' name='custom_barcode_no[]'>" +
                            "<td><input type='text' class='form-control fcsm' value='" + data.name + "'><input type='hidden' value='" + data.id + "' name='product_id[]'></td>" +
                            @if (!$salesReturnSection)
                                "<td><input type='text' class='form-control fcsm' value='" + (data.description ?? '') + "' placeholder='Type' name='description[]'></td>" +
                            @endif
                            "<td><input type='number' class='form-control fcsm text-center bg-white total_current_stock' value='" + data.total_stock + "' name='stock[]' readonly><input type='text' class='form-control fcsm text-center bg-white individual_stock' readonly></td>" +
                            "<td><input type='number' step='any' class='form-control fcsm quantity' value='1' min='1' name='quantity[]'></td>" +
                            @if ($salesReturnSection)
                                "<td><select class='form-control text-dark rounded fcsm select2-tags' name='return_type[]'>" +
                                "<option value='exchange' selected>Exchange</option>" +
                                "<option value='damage'>Damage</option>" +
                                "<option value='expired'>Expired</option>" +
                                "</select></td>" +
                                "<td><input type='text' class='form-control fcsm' value='" + (data.description ?? '') + "' placeholder='Type' name='description[]'></td>" +
                            @endif
                            (prices.length > 0 ?
                                "<td class='{{ $salesReturnSection ? 'd-none' : '' }}'><select class='form-control text-dark rounded fcsm multi-price select2-tags' name='buying_price[]'>" + priceOptions + "</select></td>" :
                                "<td class='{{ $salesReturnSection ? 'd-none' : '' }}'><input type='number' class='form-control fcsm' min='0' readonly value='" + buyingPrice + "' name='buying_price[]'></td>"
                            ) +
                            "<td><input type='number' step='any' class='form-control fcsm selling-price' value='" + data.selling_price + "' name='selling_price[]' min='1'></td>" +
                            "<td class='return_quantity_td d-none'><input type='number' min='0' step='any' class='form-control fcsm return-quantity' value='0' name='return_quantity[]'></td>" +
                            "<td><input type='text' class='form-control fcsm text-center bg-white' value='" + unitName + "' readonly><input type='hidden' value='" + unitId + "' name='unit_id[]'></td>" +
                            "<td><input type='text' class='form-control fcsm total' value='' name='total[]'></td>" +
                            "<td class='text-center'><a href='javascript:;' class='btn btn-danger btn-sm p-1 delete-row'><i class='fas fa-trash'></i></a></td>" +
                            "</tr>"
                            // <a href='javascript:;' class='btn btn-success btn-sm p-1 add-row'><i class='fas fa-plus'></i></a>
                        );
                        @if (config('invoices_seperate_item') == 1)
                            var totalQuantity = 1;
                            $("#order_table tbody tr").each(function() {
                                var productId = $(this).find("[name='product_id[]']").val();
                                if (productId === product_id) {
                                    var currentQuantity = parseFloat($(this).find(".quantity").val()) || 1;
                                    totalQuantity += currentQuantity;
                                }
                            });
                            console.log('Product ID: ' + product_id + ' QTY:' + totalQuantity);
                            var currentQuantity = totalQuantity;
                        @else
                            var currentQuantity = newRow.find(".quantity").val(); // Selecting quantity input within the new row
                        @endif
                        var currentStock = data.total_stock;

                        @if (config('invoices_over_stock_selling') == 1)
                            $("#order_table tbody").append(newRow);
                            if (currentQuantity >= currentStock) {
                                @if (!$salesReturnSection)
                                    Swal.fire({
                                        toast: true,
                                        position: 'top',
                                        icon: 'warning',
                                        title: 'Over Stock Selling Is On!',
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                @endif
                            }
                        @else
                            if (currentQuantity > currentStock || data.total_stock <= 0) {
                                @if (!$salesReturnSection)
                                    Swal.fire({
                                        toast: true,
                                        position: 'top',
                                        icon: 'error',
                                        title: 'Stock Out!',
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                @endif
                            } else {
                                $("#order_table tbody").append(newRow);
                            }
                        @endif
                        $('#barcode_number').val('');
                        $('.quantity').keyup();
                        $('#discount').keyup();
                        $('#product_search').val('').trigger('change');

                        $(".multi-price").on('change', function() {
                            var purchasedID = $(this).find(':selected').attr('title');
                            $("#order_table tbody tr [name='purchased_id[]']").val(purchasedID)
                            $(".quantity").keyup();
                        });

                        updateBuyingPrice();
                        multiPriceSelectFirst(newRow);
                        $('.select2-tags').select2({
                            tags: true
                        });


                    },
                    error: function(error) {
                        setTimeout(() => {
                            $('#barcode_number').val('');
                            Swal.fire({
                                toast: true,
                                position: 'top-center',
                                icon: 'error',
                                title: 'Product Not Found!',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }, 500);
                    }
                });
            }
        }, Math.max(minDelay, 500));
    });
    $("#product_search").on('change', function(event) {
        if (event.ctrlKey && event.key === 'j') {
            event.preventDefault();
            return false;
        }
        var rowCount = $("#order_table tbody tr").length + 1; // Initial row index number
        var product_id = $(this).val(); // Get product id from product search form
        //var purchased_id = $("#product_search option:selected").attr('title');
        var purchased_id = $(this).val();
        var url = '{{ route('get.product', ':id') }}';
        url = url.replace(':id', purchased_id);
        @if (config('invoices_seperate_item') == 1)
            var existingRow = 0;
        @else
            var existingRow = $("#order_table tbody").find("input[name='product_id[]'][value='" + product_id + "']").closest("tr");
        @endif

        if (existingRow.length > 0) {
            var quantityInput = existingRow.find(".quantity");
            var currentQuantity = parseFloat(quantityInput.val());

            var currentStock = parseFloat(existingRow.find(".total_current_stock").val());

            @if (config('invoices_over_stock_selling') == 1)
                quantityInput.val(currentQuantity + 1);
                toastr.success("Quantity increased!");
                if (currentQuantity >= currentStock) {
                    @if (!$salesReturnSection)
                        Swal.fire({
                            toast: true,
                            position: 'top',
                            icon: 'warning',
                            title: 'Over Stock Selling Is On!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    @endif
                }
            @else
                if (currentQuantity >= currentStock || currentStock <= 0) {
                    @if (!$salesReturnSection)
                        Swal.fire({
                            toast: true,
                            position: 'top',
                            icon: 'error',
                            title: 'Stock Out!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    @endif
                } else {
                    quantityInput.val(currentQuantity + 1);
                    toastr.success("Quantity increased!");
                }
            @endif

            $('#barcode_number').val('');
            $('#product_search').val('');
            $('.quantity').keyup();
            $('#discount').keyup();
        } else {
            $.ajax({
                url: url,
                dataType: 'json',
                success: function(data) {
                    console.log(data);

                    var unit = data.unit_id;
                    if (unit != null) {
                        var unitName = data.unit_name;
                        var unitId = data.unit_id;
                    } else {
                        var unitName = 'None';
                        var unitId = '';
                    }

                    @if (config('products_multi_pricing') == 1)
                        @if (config('products_new_price_sale_only') == 1)
                            var prices = data.multi_price_latest;
                            var buyingPrice = data.multi_price_latest.buying_price;
                        @else
                            var prices = data.multi_price ?? data.buying_price;
                            console.log(prices);
                            var buyingPrice = data.buying_price;
                        @endif
                    @else
                        var prices = [];
                        var buyingPrice = data.buying_price;
                    @endif
                    var priceOptions = "";

                    if (prices.length > 0) {
                        var firstPurchasedId = prices[0]['purchase_id'] ?? '';
                        @if (config('products_new_price_sale_only') == 1)
                            priceOptions += `<option title="${data.purchase_id}" value="${data.buying_price}">${data.buying_price}</option>`;
                        @else
                            prices.forEach(priceData => { // Assuming each price object has a 'price' property
                                if (Number(priceData.item_wise_stock) > 0) {
                                    var productId = priceData.id || 0;
                                    priceOptions += `<option title="${productId}" data-product-id="${priceData.product_id}" value="${priceData.buying_price}">${priceData.buying_price}</option>`;
                                }
                            });
                        @endif
                    } else {
                        var firstPurchasedId = '';
                    }
                    var newRow = $(
                        "<tr>" +
                        "<td width='3%'><input type='text' class='form-control fcsm bg-white text-center' name='row_id' value='" + rowCount + "' readonly></td>" +
                        "<td width='3%'>" +
                        "<select class='form-control text-dark rounded fcsm select2-tags selling_type' name='selling_type[]'>" +
                        "<option value='regular'>Regular</option>" +
                        "<option value='wholesale'>Wholesale</option>" +
                        "</select>" +
                        "</td>" +
                        "<input class='d-none' type='hidden' value='" + firstPurchasedId + "' name='purchased_id[]'>" +
                        "<td><input type='text' class='form-control fcsm' value='" + data.name + "'><input type='hidden' value='" + data.id + "' name='product_id[]'></td>" +
                        @if (!$salesReturnSection)
                            "<td><input type='text' class='form-control fcsm' value='" + (data.description ?? '') + "' placeholder='Type' name='description[]'></td>" +
                        @endif
                        "<td><input type='number' class='form-control fcsm text-center bg-white total_current_stock' value='" + data.total_stock + "' name='stock[]' readonly><input type='text' class='form-control fcsm text-center bg-white individual_stock' readonly></td>" +
                        "<td><input type='number' step='any' class='form-control fcsm quantity' value='1' min='1' name='quantity[]'></td>" +
                        @if ($salesReturnSection)
                            "<td><select class='form-control text-dark rounded fcsm select2-tags' name='return_type[]'>" +
                            "<option value='exchange' selected>Exchange</option>" +
                            "<option value='damage'>Damage</option>" +
                            "<option value='expired'>Expired</option>" +
                            "</select></td>" +
                            "<td><input type='text' class='form-control fcsm' value='" + (data.description ?? '') + "' placeholder='Type' name='description[]'></td>" +
                        @endif
                        (prices.length > 0 ?
                            "<td class='{{ $salesReturnSection ? 'd-none' : '' }}'><select class='form-control text-dark rounded fcsm multi-price select2-tags' name='buying_price[]'>" + priceOptions + "</select></td>" :
                            "<td class='{{ $salesReturnSection ? 'd-none' : '' }}'><input type='number' class='form-control fcsm' min='0' readonly value='" + buyingPrice + "' name='buying_price[]'></td>"
                        ) +
                        "<td><input type='number' step='any' class='form-control fcsm quantity selling-price' value='" + data.selling_price + "' name='selling_price[]' min='1'></td>" +
                        "<td class='return_quantity_td d-none'><input type='number' min='0' step='any' class='form-control fcsm return-quantity' value='0' name='return_quantity[]'></td>" +
                        "<td><input type='text' class='form-control fcsm text-center bg-white' value='" + unitName + "' readonly><input type='hidden' value='" + unitId + "' name='unit_id[]'></td>" +
                        "<td><input type='text' class='form-control fcsm total' value='' name='total[]'></td>" +
                        "<td class='text-center'><a href='javascript:;' class='btn btn-danger btn-sm p-1 delete-row'><i class='fas fa-trash'></i></a></td>" +
                        "</tr>"
                        // <a href='javascript:;' class='btn btn-success btn-sm p-1 add-row'><i class='fas fa-plus'></i></a>
                    );

                    @if (config('invoices_seperate_item') == 1)
                        var totalQuantity = 1;
                        $("#order_table tbody tr").each(function() {
                            var productId = $(this).find("[name='product_id[]']").val();
                            if (productId === product_id) {
                                var currentQuantity = parseFloat($(this).find(".quantity").val()) || 1;
                                totalQuantity += currentQuantity;
                            }
                        });
                        // console.log('Product ID: ' + product_id + ' QTY:' + totalQuantity);
                        var currentQuantity = totalQuantity;
                    @else
                        var currentQuantity = newRow.find(".quantity").val(); // Selecting quantity input within the new row
                    @endif
                    var currentStock = data.total_stock;
                    @if (config('invoices_over_stock_selling') == 1)
                        $("#order_table tbody").append(newRow);
                        if (currentQuantity >= currentStock) {
                            @if (!$salesReturnSection)
                                Swal.fire({
                                    toast: true,
                                    position: 'top',
                                    icon: 'warning',
                                    title: 'Over Stock Selling Is On!',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            @endif
                        }
                    @else
                        if (currentQuantity > currentStock || data.total_stock <= 0) {
                            @if (!$salesReturnSection)
                                Swal.fire({
                                    toast: true,
                                    position: 'top',
                                    icon: 'error',
                                    title: 'Stock Out!',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            @endif
                        } else {
                            $("#order_table tbody").append(newRow);
                        }
                    @endif
                    $('#barcode_number').val('');
                    $('.quantity').keyup();
                    $('#discount').keyup();
                    $('#product_search').val('').trigger('change');

                    updateBuyingPrice();
                    multiPriceSelectFirst(newRow);
                    $('.select2-tags').select2({
                        tags: true
                    });
                    @if (config('invoices_open_product_after_select') == 1)
                        var productSearchSelect = $("#product_search");
                        productSearchSelect.select2('open');
                        productSearchSelect.trigger('select2:open');
                    @endif

                    setTimeout(() => {
                        getReceiveAmountAutomatically();
                    }, 500);
                }
            });
        }
    });

    function multiPriceSelectFirst(newRow) {
        @if (config('products_multi_pricing') == 1)
            var firstOptionValue = newRow.find('.multi-price').find('option:first').val();
            setTimeout(() => {
                newRow.find('.multi-price').val(firstOptionValue).trigger('change');
            }, 500);
        @endif
    }

    function updateBuyingPrice() {
        $(".multi-price").on('change', function() {
            var purchasedID = $(this).find(':selected').attr('title');
            if (purchasedID == 0) {
                var multiPriceRow = $(this).closest("tr");
                var productId = $(this).find(':selected').attr('data-product-id')
                var url = '{{ route('get.product', ':id') }}';
                url = url.replace(':id', productId);
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: url,
                    success: function(data) {
                        var sellingType = multiPriceRow.find("[name='selling_type[]']").val();

                        if (sellingType == 'wholesale') {
                            multiPriceRow.find(".selling-price").val(data.wholesale_price);
                        } else {
                            multiPriceRow.find(".selling-price").val(data.selling_price);
                        }
                        multiPriceRow.find("[name='selling_price[]']").keyup();
                        multiPriceRow.find(".wholesale_price").val(data.wholesale_price);
                        multiPriceRow.find(".individual_stock").val('{{ __('messages.purchase') }}: ' + data.opening_stock);
                    },
                    error: function(error) {
                        Swal.fire({
                            position: 'top-center',
                            icon: 'error',
                            title: 'Product Not Found!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                })
            } else {
                var multiPriceRow = $(this).closest("tr");
                multiPriceRow.find("[name='purchased_id[]']").val(purchasedID);
                $(".quantity").keyup();
                var url = '{{ route('get.purchased.product', ':id') }}';
                url = url.replace(':id', purchasedID);
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: url,
                    success: function(data) {
                        var sellingType = multiPriceRow.find("[name='selling_type[]']").val();

                        if (sellingType == 'wholesale') {
                            multiPriceRow.find(".selling-price").val(data.wholesale_price);
                        } else {
                            multiPriceRow.find(".selling-price").val(data.selling_price);
                        }
                        multiPriceRow.find("[name='selling_price[]']").keyup();
                        multiPriceRow.find(".individual_stock").val('{{ __('messages.purchase') }}: ' + data.seperate_stock);
                    },
                    error: function(error) {
                        Swal.fire({
                            position: 'top-center',
                            icon: 'error',
                            title: 'Purchase Not Found!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                })
            }
        });
        $(".selling_type").on('change', function() {
            var closestRow = $(this).closest("tr");
            var purchasedID = closestRow.find('.multi-price').find(':selected').attr('title');
            console.log(purchasedID);

            var sellingType = $(this).val();

            if (purchasedID == 0) {
                var productId = closestRow.find('.multi-price').find(':selected').attr('data-product-id');
                var url = '{{ route('get.product', ':id') }}';
                url = url.replace(':id', productId);
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: url,
                    success: function(data) {
                        if (sellingType == 'wholesale') {
                            closestRow.find(".selling-price").val(data.wholesale_price);
                        } else {
                            closestRow.find(".selling-price").val(data.selling_price);
                        }
                        closestRow.find("[name='selling_price[]']").keyup();
                        closestRow.find(".wholesale_price").val(data.wholesale_price);
                        closestRow.find(".individual_stock").val('{{ __('messages.purchase') }}: ' + data.opening_stock);
                    },
                    error: function(error) {
                        Swal.fire({
                            position: 'top-center',
                            icon: 'error',
                            title: 'Product Not Found!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                })
            } else {
                closestRow.find("[name='purchased_id[]']").val(purchasedID);
                $(".quantity").keyup();
                var url = '{{ route('get.purchased.product', ':id') }}';
                url = url.replace(':id', purchasedID);
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: url,
                    success: function(data) {
                        if (sellingType == 'wholesale') {
                            closestRow.find(".selling-price").val(data.wholesale_price);
                        } else {
                            closestRow.find(".selling-price").val(data.selling_price);
                        }
                        closestRow.find("[name='selling_price[]']").keyup();
                        closestRow.find(".individual_stock").val('{{ __('messages.purchase') }}: ' + data.seperate_stock);
                    },
                    error: function(error) {
                        Swal.fire({
                            position: 'top-center',
                            icon: 'error',
                            title: 'Purchase Not Found!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                })
            }
        });
    }


    function getReceiveAmountAutomatically() {
        @if (config('invoices_set_receive_amount') == 1)
            var totalBill = parseFloat($('#grand_total').val()) || 0;
            var previousDue = parseFloat($('#previous_due').val()) || 0;
            var netTotal = totalBill + previousDue;
            @if ($queryString == 'create' || $queryString == 'sales-return')
                $('#receive_amount').val(netTotal);
            @endif
            setTimeout(() => {
                $('#receive_amount').keyup();
            }, 500);
        @endif
    }

    // {{-- invoice add update delete js --}}
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="carf-token"]').attr('content')
        }
    });

    function clearInvoiceField() {
        $('#client_id').val('');
        $('#client_id_Error').text('');
        $('#client_id').removeClass('border-danger');

        $('#staff_id').val('');
        $('#staff_id_Error').text('');
        $('#staff_id').removeClass('border-danger');

        $('#issued_date').val('');
        $('#issued_date_Error').text('');
        $('#issued_date').removeClass('border-danger');

        $('#issued_time').val('');
        $('#issued_time_Error').text('');
        $('#issued_time').removeClass('border-danger');

        $('#discount').val('');
        $('#discount_Error').text('');
        $('#discount').removeClass('border-danger');

        $('#discount_type').val('');
        $('#discount_type_Error').text('');
        $('#discount_type').removeClass('border-danger');

        $('#transport_fare').val('');
        $('#transport_fare_Error').text('');
        $('#transport_fare').removeClass('border-danger');

        $('#labour_cost').val('');
        $('#labour_cost_Error').text('');
        $('#labour_cost').removeClass('border-danger');

        $('#account_id').val('');
        $('#account_id_Error').text('');
        $('#account_id').removeClass('border-danger');

        $('#bank_id').val('');
        $('#bank_id_Error').text('');
        $('#bank_id').removeClass('border-danger');

        $('#cheque_number').val('');
        $('#cheque_number_Error').text('');
        $('#cheque_number').removeClass('border-danger');

        $('#cheque_issued_date').val('');
        $('#cheque_issued_date_Error').text('');
        $('#cheque_issued_date').removeClass('border-danger');

        $('#category_id').val('');
        $('#category_id_Error').text('');
        $('#category_id').removeClass('border-danger');

        $('#receive_amount').val('');
        $('#receive_amount_Error').text('');
        $('#receive_amount').removeClass('border-danger');

        $('#cash_receive').val('');
        $('#cash_receive_Error').text('');
        $('#cash_receive').removeClass('border-danger');

        $('#change_amount').val('');
        $('#change_amount_Error').text('');
        $('#change_amount').removeClass('border-danger');

        $('#bill_amount').val('');
        $('#bill_amount_Error').text('');
        $('#bill_amount').removeClass('border-danger');

        $('#due_amount').val('');
        $('#due_amount_Error').text('');
        $('#due_amount').removeClass('border-danger');

        $('#highest_due').val('');
        $('#highest_due_Error').text('');
        $('#highest_due').removeClass('border-danger');

        $('#vat_type').val('');
        $('#vat_type_Error').text('');
        $('#vat_type').removeClass('border-danger');

        $('#vat').val('');
        $('#vat_Error').text('');
        $('#vat').removeClass('border-danger');

        $('#description').val('');
        $('#description_Error').text('');
        $('#description').removeClass('border-danger');

        $('#send_sms').val('');
        $('#send_sms_Error').text('');
        $('#send_sms').removeClass('border-danger');

        $('#send_email').val('');
        $('#send_email_Error').text('');
        $('#send_email').removeClass('border-danger');

        $("#receive_amount").keyup();
    }

    // add client using ajax
    function addInvoice(button = null) {
        $("#addInvoice").attr('disabled', '');
        setTimeout(() => {
            $("#addInvoice").removeAttr('disabled', '');
        }, 4000);
        if (button !== null && button != 'saveAndPrint') {
            var invoice_type = 'invoice-draft';
        } else {
            var invoice_type = $('#invoice_type').val();
        }
        var client_id = $('#client_id').val();
        var staff_id = $('#staff_id').val();
        var issued_date = $('#issued_date').val();
        var issued_time = $('#issued_time').val();
        var track_number = $('#track_number').val();
        var discount = $('#discount').val();
        var discount_type = $('#discount_type').val();
        var transport_fare = $('#transport_fare').val();
        var labour_cost = $('#labour_cost').val();
        var account_id = $('#account_id').val();

        var bank_id = $('#bank_id').val() ?? null;
        var cheque_number = $('#cheque_number').val() ?? null;
        var cheque_issued_date = $('#cheque_issued_date').val() ?? null;

        var category_id = $('#category_id').val();
        var receive_amount = $('#receive_amount').val();
        var cash_receive = $('#cash_receive').val();
        var change_amount = $('#change_amount').val();
        var bill_amount = $('#bill_amount').val();
        var due_amount = $('#due_amount').val();
        var highest_due = $('#highest_due').val();
        var vat_type = $('#vat_type').val();
        var vat = $('#vat').val();
        var description = $('#description').val();
        var send_sms = $('#send_sms').is(":checked");
        var send_email = $('#send_email').is(":checked");

        var total_discount = $('#total_discount').val();
        var invoice_bill = $('#invoice_bill').val();
        var previous_due = $('#previous_due').val();
        var due_before_return = $('#previous_due_show_only').val();
        var total_vat = $('#total_vat').val();
        var grand_total = $('#grand_total').val();
        var total_due = $('#total_due').val();
        var adjusting_amount = $('#adjusting_amount').val() ?? 0;

        var max_due_limit = parseInt($("#highest_due").val());

        var tableData = [];
        $('#order_table tbody tr').each(function() {
            var row = $(this);
            var rowData = {
                row_id: row.find('[name="row_id"]').val(),
                purchased_id: row.find('[name="purchased_id[]"]').val(),
                product_id: row.find('[name="product_id[]"]').val(),
                description: row.find('[name="description[]"]').val(),
                stock: row.find('[name="stock[]"]').val(),
                buying_price: row.find('[name="buying_price[]"]').val(),
                selling_price: row.find('[name="selling_price[]"]').val(),
                selling_type: row.find('[name="selling_type[]"]').val(),
                quantity: row.find('[name="quantity[]"]').val(),
                return_type: row.find('[name="return_type[]"]').val() ?? '',
                return_quantity: row.find('[name="return_quantity[]"]').val(),
                unit_id: row.find('[name="unit_id[]"]').val(),
                total: row.find('[name="total[]"]').val(),
            };
            tableData.push(rowData);
        });

        var maxDueToggle = "{{ config('invoices_highest_due') }}";
        if (max_due_limit < total_due && max_due_limit != 0 && maxDueToggle == 1) {
            // console.log(max_due_limit + ' ' + total_due);
            Swal.fire({
                toast: true,
                position: 'center',
                icon: 'error',
                title: 'Max Due Limit exist! Please increase receive amount.',
                showConfirmButton: false,
                timer: 1500
            });
            $("#receive_amount").focus();
        } else {
            $.ajax({
                type: "POST",
                dataType: "json",
                data: {
                    status: invoice_type,
                    client_id: client_id,
                    staff_id: staff_id,
                    track_number: track_number,
                    issued_date: issued_date,
                    issued_time: issued_time,
                    discount: discount,
                    discount_type: discount_type,
                    transport_fare: transport_fare,
                    labour_cost: labour_cost,
                    account_id: account_id,

                    bank_id: bank_id,
                    cheque_number: cheque_number,
                    cheque_issued_date: cheque_issued_date,

                    category_id: category_id,
                    receive_amount: receive_amount,
                    cash_receive: cash_receive,
                    change_amount: change_amount,
                    bill_amount: bill_amount,
                    due_amount: due_amount,
                    highest_due: highest_due,
                    vat_type: vat_type,
                    vat: vat,
                    description: description,

                    total_discount: total_discount,
                    invoice_bill: invoice_bill,
                    previous_due: previous_due,
                    due_before_return: due_before_return,
                    total_vat: total_vat,
                    grand_total: grand_total,
                    total_due: total_due,
                    adjusting_amount: adjusting_amount,

                    send_sms: send_sms,
                    send_email: send_email,

                    ordered_items: tableData,
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                url: "{{ route('user.invoice.store') }}",
                success: function(data) {
                    clearInvoiceField();
                    $("#order_table tbody").empty();

                    $("#invoiceCollapse").collapse("toggle");
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Invoice added successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    $('.yajra-datatable').DataTable().ajax.reload();

                    if (data.status == 4) {
                        window.location.href = "{{ route('user.invoice.sales.return') }}";
                    } else if (data.status == 5) {
                        window.location.href = "{{ route('user.invoice.index') }}?draft";
                    } else {
                        if (button !== null && button == 'saveAndPrint') {
                            var printDestination = "{{ config('invoices_print_destination') }}";

                            if (printDestination == 1) {
                                var url = '{{ route('user.invoice.show', ':id') }}?print=1';
                            } else {
                                var url = '{{ route('user.invoice.pos.show', ':id') }}?print=1';
                            }
                            url = url.replace(':id', data.id);
                            window.location.href = url;
                        } else {
                            window.location.href = "{{ route('user.invoice.index') }}";
                        }
                    }
                },
                error: function(error) {
                    var $errors = error.responseJSON.errors;
                    if ($errors.client_id) {
                        $('#client_id_Error').text($errors.client_id);
                        $('#client_id').addClass('border-danger');
                        toastr.error($errors.client_id);
                        $('#client_id').focus();
                    }

                    if ($errors.staff_id) {
                        $('#staff_id_Error').text($errors.staff_id);
                        $('#staff_id').addClass('border-danger');
                        toastr.error($errors.staff_id);
                        $('#staff_id').focus();
                    }

                    if ($errors.track_number) {
                        $('#track_number_Error').text($errors.track_number);
                        $('#track_number').addClass('border-danger');
                        toastr.error($errors.track_number);
                        $('#track_number').focus();
                    }
                    if ($errors.issued_date) {
                        $('#issued_date_Error').text($errors.issued_date);
                        $('#issued_date').addClass('border-danger');
                        toastr.error($errors.issued_date);
                        $('#issued_date').focus();
                    }
                    if ($errors.issued_time) {
                        $('#issued_time_Error').text($errors.issued_time);
                        $('#issued_time').addClass('border-danger');
                        toastr.error($errors.issued_time);
                        $('#issued_time').focus();
                    }
                    if ($errors.discount) {
                        $('#discount_Error').text($errors.discount);
                        $('#discount').addClass('border-danger');
                        toastr.error($errors.discount);
                        $('#discount').focus();
                    }
                    if ($errors.discount_type) {
                        $('#discount_type_Error').text($errors.discount_type);
                        $('#discount_type').addClass('border-danger');
                        toastr.error($errors.discount_type);
                        $('#discount_type').focus();
                    }
                    if ($errors.transport_fare) {
                        $('#transport_fare_Error').text($errors.transport_fare);
                        $('#transport_fare').addClass('border-danger');
                        toastr.error($errors.transport_fare);
                        $('#transport_fare').focus();
                    }
                    if ($errors.labour_cost) {
                        $('#labour_cost_Error').text($errors.labour_cost);
                        $('#labour_cost').addClass('border-danger');
                        toastr.error($errors.labour_cost);
                        $('#labour_cost').focus();
                    }
                    if ($errors.account_id) {
                        $('#account_id_Error').text($errors.account_id);
                        $('#account_id').addClass('border-danger');
                        toastr.error($errors.account_id);
                        $('#account_id').focus();
                    }

                    if ($errors.bank_id) {
                        $('#bank_id_Error').text($errors.bank_id);
                        $('#bank_id').addClass('border-danger');
                        toastr.error($errors.bank_id);
                        $('#bank_id').focus();
                    }

                    if ($errors.cheque_number) {
                        $('#cheque_number_Error').text($errors.cheque_number);
                        $('#cheque_number').addClass('border-danger');
                        toastr.error($errors.cheque_number);
                        $('#cheque_number').focus();
                    }

                    if ($errors.cheque_issued_date) {
                        $('#cheque_issued_date_Error').text($errors.cheque_issued_date);
                        $('#cheque_issued_date').addClass('border-danger');
                        toastr.error($errors.cheque_issued_date);
                        $('#cheque_issued_date').focus();
                    }

                    if ($errors.category_id) {
                        $('#category_id_Error').text($errors.category_id);
                        $('#category_id').addClass('border-danger');
                        toastr.error($errors.category_id);
                        $('#category_id').focus();
                    }
                    if ($errors.receive_amount) {
                        $('#receive_amount_Error').text($errors.receive_amount);
                        $('#receive_amount').addClass('border-danger');
                        toastr.error($errors.receive_amount);
                        $('#receive_amount').focus();
                    }
                    if ($errors.bill_amount) {
                        $('#bill_amount_Error').text($errors.bill_amount);
                        $('#bill_amount').addClass('border-danger');
                        toastr.error($errors.bill_amount);
                        $('#bill_amount').focus();
                    }
                    if ($errors.due_amount) {
                        $('#due_amount_Error').text($errors.due_amount);
                        $('#due_amount').addClass('border-danger');
                        toastr.error($errors.due_amount);
                        $('#due_amount').focus();
                    }
                    if ($errors.highest_due) {
                        $('#highest_due_Error').text($errors.highest_due);
                        $('#highest_due').addClass('border-danger');
                        toastr.error($errors.highest_due);
                        $('#highest_due').focus();
                    }
                    if ($errors.vat_type) {
                        $('#vat_type_Error').text($errors.vat_type);
                        $('#vat_type').addClass('border-danger');
                        toastr.error($errors.vat_type);
                        $('#vat_type').focus();
                    }
                    if ($errors.vat) {
                        $('#vat_Error').text($errors.vat);
                        $('#vat').addClass('border-danger');
                        toastr.error($errors.vat);
                        $('#vat').focus();
                    }
                    if ($errors.description) {
                        $('#description_Error').text($errors.description);
                        $('#description').addClass('border-danger');
                        toastr.error($errors.description);
                        $('#description').focus();
                    }
                    if ($errors.send_sms) {
                        $('#send_sms_Error').text($errors.send_sms);
                        $('#send_sms').addClass('border-danger');
                        toastr.error($errors.send_sms);
                        $('#send_sms').focus();
                    }
                    if ($errors.send_email) {
                        $('#send_email_Error').text($errors.send_email);
                        $('#send_email').addClass('border-danger');
                        toastr.error($errors.send_email);
                        $('#send_email').focus();
                    }
                }
            })
        }
    }
    // add client using ajax


    // edit client using ajax
    function edit(id) {
        var rowCount = $("#order_table tbody tr").length + 1; // initial row index number
        var data_id = id;
        var url = '{{ route('user.invoice.edit', ':id') }}';
        url = url.replace(':id', data_id);
        $(".return_quantity_td").removeClass('d-none');
        $.ajax({
            type: "GET",
            dataType: "json",
            url: url,
            success: function(data) {
                // adding the data to fields
                var html = '<option value="' + data.client_id + '">' + data.client_name + '</option>'
                $('#client_id').html(html);

                getAccountInfo('/get-account', data.account_id);
                getReceiveCategoryInfo('/get-receive-category', data.category_id);

                if (data.status == 4) {
                    var invoice_type = "invoice-return";
                } else if (data.status == 5) {
                    var invoice_type = "invoice-draft";
                } else {
                    var invoice_type = "invoice";
                }
                $('#invoice_type').val(invoice_type);

                $('#client_id').val(data.client_id).trigger('change');
                @if (config('invoices_staff_id') == 1)
                    $('#staff_id').val(data.staff_id).trigger('change');
                @endif
                $('#track_number').val(data.track_number).trigger('change');
                $('#issued_date').val(data.issued_date);
                $('#issued_time').val(data.issued_time);
                $('#discount').val(data.discount);
                $('#discount_type').val(data.discount_type);
                $('#transport_fare').val(data.transport_fare);
                $('#labour_cost').val(data.labour_cost);
                $('#account_id').val(data.account_id).trigger('change');

                $('#bank_id').val(data.bank_id).trigger('change');
                $('#cheque_number').val(data.cheque_number);
                $('#cheque_issued_date').val(data.cheque_issued_date);

                $('#category_id').val(data.category_id).trigger('change');
                $('#receive_amount').val(data.receive_amount);
                $('#cash_receive').val(data.cash_receive);
                $('#change_amount').val(data.change_amount);
                $('#bill_amount').val(data.bill_amount);
                $('#due_amount').val(data.due_amount);
                $('#highest_due').val(data.highest_due);
                $('#vat_type').val(data.vat_type);
                $('#vat').val(data.vat);
                // var description = data.description.replace(/<br\s*\/?>/gi, '\n');
                $('#description').val(data.description);

                var items = data.ordered_items;
                var html = '';
                $.each(items, function(index, value) {
                    @if (config('products_multi_pricing') == 1)
                        var prices = value['product']['prices'];
                    @else
                        var prices = [];
                    @endif
                    var priceOptions = "";
                    if (prices.length > 0) {
                        var firstPurchasedId = prices[0]['purchase_id'] ?? '';
                        prices.forEach(priceData => { // Assuming each price object has a 'price' property
                            priceOptions += `<option ${priceData.buying_price == value.buying_price ? "selected" : ''} title="${priceData.purchase_id}" value="${priceData.buying_price}">${priceData.buying_price}</option>`;
                        });
                    } else {
                        var firstPurchasedId = '';
                    }

                    html += "<tr>";
                    html += "<input type='hidden' value='" + value.id + "' name='id[]'>";
                    html += "<td width='3%'><input type='text' class='form-control fcsm bg-white text-center' name='row_id' value='" + rowCount++ + "' readonly></td>";
                    html += "<td width='3%'>";
                    html += "<select class='form-control text-dark rounded fcsm select2-tags selling_type' disabled name='selling_type[]'>";
                    html += "<option " + (value.selling_type == 'regular' ? 'selected' : '') + " value='regular'>Regular</option>";
                    html += "<option " + (value.selling_type == 'wholesale' ? 'selected' : '') + " value='wholesale'>Wholesale</option>";
                    html += "</select>";
                    html += "</td>";
                    html += "<input class='d-none' type='hidden' value='" + firstPurchasedId + "' name='purchased_id[]'>";
                    html += "<td><input type='text' class='form-control fcsm' value='" + value.product.name + "'><input type='hidden' value='" + value.product_id + "' name='product_id[]'></td>";
                    @if (!$salesReturnSection)
                        html += "<td><input type='text' class='form-control fcsm' value='" + (value.description ?? '') + "' name='description[]'></td>";
                    @endif
                    html += "<td><input type='number' class='form-control fcsm text-center bg-white' value='" + value.stock + "' name='stock[]' readonly></td>";
                    html += "<td><input type='number' step='any' class='form-control fcsm quantity' value='" + value.quantity + "' min='1' name='quantity[]'></td>";
                    @if ($salesReturnSection)
                        html += "<td><select class='form-control text-dark rounded fcsm select2-tags' name='return_type[]'>";
                        html += "<option " + (value.return_type == 'exchange' ? 'selected' : '') + " value='exchange' selected>Exchange</option>";
                        html += "<option " + (value.return_type == 'damage' ? 'selected' : '') + " value='damage'>Damage</option>";
                        html += "<option " + (value.return_type == 'expired' ? 'selected' : '') + " value='expired'>Expired</option>";
                        html += "</select></td>";
                        html += "<td><input type='text' class='form-control fcsm' value='" + (value.description ?? '') + "' name='description[]'></td>";
                    @endif
                    html += "<td><input type='number' class='form-control fcsm' min='0' value='" + parseFloat(value.buying_price).toFixed(2) + "' name='buying_price[]'></td>"
                    html += "<td><input type='number' step='any' class='form-control fcsm selling-price' value='" + value.selling_price + "' name='selling_price[]' min='1'></td>";
                    html += "<td class='d-none'><input type='number' min='0' step='any' class='form-control fcsm return-quantity' value='" + value.return_quantity + "' name='return_quantity[]'></td>";
                    html += "<td><input type='text' class='form-control fcsm text-center bg-white' value='" + value.unit_name + "' readonly><input type='hidden' value='" + value.unit_id + "' name='unit_id[]'></td>";
                    html += "<td><input type='text' class='form-control fcsm total' value='" + value.total + "' name='total[]'></td>";
                    html += "<td class='text-center'><a href='javascript:;' class='btn btn-danger btn-sm p-1 delete-row' onclick='destroyItem(" + value.id + ");'><i class='fas fa-trash'></i></a></td>";
                    html += "</tr>";
                });
                $('#order_table tbody').html(html);

                $('#total_discount').val(data.total_discount)
                $('#invoice_bill').val(data.invoice_bill)
                setTimeout(() => {
                    $('#previous_due').val(data.previous_due)
                    $('#previous_due_show_only').val(data.due_before_return)
                    $('#previous_due').keyup();
                    $('#previousDueBox').hide();
                }, 1000);
                $('#total_vat').val(data.total_vat)
                $('#grand_total').val(data.grand_total)
                $('#total_due').val(data.total_due)
                $('.quantity').keyup();

                $('#discount').keyup();
                $('#transport_fare').keyup();
                $('#labour_cost').keyup();
                $('#receive_amount').keyup();

                $('#row_id').val(data.id);
                // adding the data to fields

                // hide show btn
                $('#addInvoiceText').addClass('d-none');
                $('#updateInvoiceText').removeClass('d-none');
                $('#voucher_no').text(data.id);
                $('#addInvoice').addClass('d-none');
                $('#updateInvoice').removeClass('d-none');
                // hide show btn

                // hide save new draft when updating and showed edited draft
                $("#saveAsDraft").addClass('d-none');
                $("#saveandprint").addClass('d-none');
                if (data.status == 0) {
                    $("#saveAsDraftUpdate").addClass('d-none');
                } else {
                    $("#saveAsDraftUpdate").removeClass('d-none');
                }

                $(".multi-price").on('change', function() {
                    var purchasedID = $(this).find(':selected').attr('title');
                    $("#order_table tbody tr [name='purchased_id[]']").val(purchasedID)
                    $(".quantity").keyup();
                });

                updateBuyingPrice();

                $('.select2-tags').select2({
                    tags: true
                });

                // modal show when edit button is clicked
                $("#invoiceCollapse").collapse("show");
                $("html, body").animate({
                    scrollTop: 0
                }, 100);
                // modal show when edit button is clicked
            },
            error: function(error) {
                Swal.fire({
                    position: 'top-center',
                    icon: 'error',
                    title: 'Invoice Not Found!',
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        })
    }
    // edit client using ajax

    // update data using ajax
    function updateInvoice(button = null) {
        var invoice_id = $('#row_id').val();
        var client_id = $('#client_id').val();
        var staff_id = $('#staff_id').val();
        var track_number = $('#track_number').val();
        var issued_date = $('#issued_date').val();
        var issued_time = $('#issued_time').val();
        var discount = $('#discount').val();
        var discount_type = $('#discount_type').val();
        var transport_fare = $('#transport_fare').val();
        var labour_cost = $('#labour_cost').val();
        var account_id = $('#account_id').val();

        var bank_id = $('#bank_id').val() ?? null;
        var cheque_number = $('#cheque_number').val() ?? null;
        var cheque_issued_date = $('#cheque_issued_date').val() ?? null;

        var category_id = $('#category_id').val();
        var receive_amount = $('#receive_amount').val();
        var cash_receive = $('#cash_receive').val();
        var change_amount = $('#change_amount').val();
        var bill_amount = $('#bill_amount').val();
        var due_amount = $('#due_amount').val();
        var highest_due = $('#highest_due').val();
        var vat_type = $('#vat_type').val();
        var vat = $('#vat').val();
        var description = $('#description').val();

        var total_discount = $('#total_discount').val();
        var invoice_bill = $('#invoice_bill').val();
        var previous_due = $('#previous_due').val();
        var due_before_return = $('#previous_due_show_only').val();
        var total_vat = $('#total_vat').val();
        var grand_total = $('#grand_total').val();
        var total_due = $('#total_due').val();
        var adjusting_amount = $('#adjusting_amount').val() ?? 0;

        var send_sms = $('#send_sms').is(":checked");
        var send_email = $('#send_email').is(":checked");
        var max_due_limit = $("#highest_due").val();

        var tableData = [];
        $('#order_table tbody tr').each(function() {
            var row = $(this);
            var rowData = {
                id: row.find('[name="id[]"]').val(),
                row_id: row.find('[name="row_id"]').val(),
                purchased_id: row.find('[name="purchased_id[]"]').val(),
                product_id: row.find('[name="product_id[]"]').val(),
                description: row.find('[name="description[]"]').val(),
                stock: row.find('[name="stock[]"]').val(),
                buying_price: row.find('[name="buying_price[]"]').val(),
                selling_price: row.find('[name="selling_price[]"]').val(),
                selling_type: row.find('[name="selling_type[]"]').val(),
                quantity: row.find('[name="quantity[]"]').val(),
                return_type: row.find('[name="return_type[]"]').val() ?? '',
                return_quantity: row.find('[name="return_quantity[]"]').val(),
                unit_id: row.find('[name="unit_id[]"]').val(),
                total: row.find('[name="total[]"]').val(),
            };
            tableData.push(rowData);
        });

        var url = '{{ route('user.invoice.update', ':id') }}';
        url = url.replace(':id', invoice_id);
        @if ($_SERVER['QUERY_STRING'] == 'sales-return' || request()->routeIs('user.invoice.sales.return'))
            var status = 4; // for sales-return
        @else
            if (button !== null && button != 'saveAndPrint') {
                var status = 5; // for draft
            } else {
                var status = 0; // default
            }
        @endif
        var maxDueToggle = "{{ config('invoices_highest_due') }}";
        if (max_due_limit < total_due && max_due_limit != 0 && maxDueToggle == 1) {
            // console.log(max_due_limit + ' ' + total_due);
            Swal.fire({
                toast: true,
                position: 'center',
                icon: 'error',
                title: 'Max Due Limit exist! Please increase receive amount.',
                showConfirmButton: false,
                timer: 1500
            });
            $("#receive_amount").focus();
        } else {
            $.ajax({
                type: "PUT",
                dataType: "json",
                data: {
                    status: status,
                    client_id: client_id,
                    staff_id: staff_id,
                    track_number: track_number,
                    issued_date: issued_date,
                    issued_time: issued_time,
                    discount: discount,
                    discount_type: discount_type,
                    transport_fare: transport_fare,
                    labour_cost: labour_cost,
                    account_id: account_id,

                    bank_id: bank_id,
                    cheque_number: cheque_number,
                    cheque_issued_date: cheque_issued_date,

                    category_id: category_id,
                    receive_amount: receive_amount,
                    cash_receive: cash_receive,
                    change_amount: change_amount,
                    bill_amount: bill_amount,
                    due_amount: due_amount,
                    highest_due: highest_due,
                    vat_type: vat_type,
                    vat: vat,
                    description: description,

                    total_discount: total_discount,
                    invoice_bill: invoice_bill,
                    previous_due: previous_due,
                    due_before_return: due_before_return,
                    total_vat: total_vat,
                    grand_total: grand_total,
                    total_due: total_due,
                    adjusting_amount: adjusting_amount,

                    send_sms: send_sms,
                    send_email: send_email,

                    ordered_items: tableData,
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                url: url,
                success: function(data) {

                    clearInvoiceField();
                    $("#order_table tbody").empty();

                    $("#invoiceCollapse").collapse("toggle");
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Invoice updated successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    $('.yajra-datatable').DataTable().ajax.reload();
                    if (data.status == 4) {
                        window.location.href = "{{ route('user.invoice.sales.return') }}";
                    } else if (data.status == 5) {
                        window.location.href = "{{ route('user.invoice.index') }}?draft";
                    } else {
                        window.location.href = "{{ route('user.invoice.index') }}";
                    }
                },
                error: function(error) {
                    var $errors = error.responseJSON.errors;
                    toastr.error($errors);
                    if ($errors.client_id) {
                        $('#client_id_Error').text($errors.client_id);
                        $('#client_id').addClass('border-danger');
                        toastr.error($errors.client_id);
                        $('#client_id').focus();
                    }

                    if ($errors.staff_id) {
                        $('#staff_id_Error').text($errors.staff_id);
                        $('#staff_id').addClass('border-danger');
                        toastr.error($errors.staff_id);
                        $('#staff_id').focus();
                    }

                    if ($errors.track_number) {
                        $('#track_number_Error').text($errors.track_number);
                        $('#track_number').addClass('border-danger');
                        toastr.error($errors.track_number);
                        $('#track_number').focus();
                    }
                    if ($errors.issued_date) {
                        $('#issued_date_Error').text($errors.issued_date);
                        $('#issued_date').addClass('border-danger');
                        toastr.error($errors.issued_date);
                        $('#issued_date').focus();
                    }
                    if ($errors.issued_time) {
                        $('#issued_time_Error').text($errors.issued_time);
                        $('#issued_time').addClass('border-danger');
                        toastr.error($errors.issued_time);
                        $('#issued_time').focus();
                    }
                    if ($errors.discount) {
                        $('#discount_Error').text($errors.discount);
                        $('#discount').addClass('border-danger');
                        toastr.error($errors.discount);
                        $('#discount').focus();
                    }
                    if ($errors.discount_type) {
                        $('#discount_type_Error').text($errors.discount_type);
                        $('#discount_type').addClass('border-danger');
                        toastr.error($errors.discount_type);
                        $('#discount_type').focus();
                    }
                    if ($errors.transport_fare) {
                        $('#transport_fare_Error').text($errors.transport_fare);
                        $('#transport_fare').addClass('border-danger');
                        toastr.error($errors.transport_fare);
                        $('#transport_fare').focus();
                    }
                    if ($errors.labour_cost) {
                        $('#labour_cost_Error').text($errors.labour_cost);
                        $('#labour_cost').addClass('border-danger');
                        toastr.error($errors.labour_cost);
                        $('#labour_cost').focus();
                    }
                    if ($errors.account_id) {
                        $('#account_id_Error').text($errors.account_id);
                        $('#account_id').addClass('border-danger');
                        toastr.error($errors.account_id);
                        $('#account_id').focus();
                    }

                    if ($errors.bank_id) {
                        $('#bank_id_Error').text($errors.bank_id);
                        $('#bank_id').addClass('border-danger');
                        toastr.error($errors.bank_id);
                        $('#bank_id').focus();
                    }

                    if ($errors.cheque_number) {
                        $('#cheque_number_Error').text($errors.cheque_number);
                        $('#cheque_number').addClass('border-danger');
                        toastr.error($errors.cheque_number);
                        $('#cheque_number').focus();
                    }

                    if ($errors.cheque_issued_date) {
                        $('#cheque_issued_date_Error').text($errors.cheque_issued_date);
                        $('#cheque_issued_date').addClass('border-danger');
                        toastr.error($errors.cheque_issued_date);
                        $('#cheque_issued_date').focus();
                    }

                    if ($errors.category_id) {
                        $('#category_id_Error').text($errors.category_id);
                        $('#category_id').addClass('border-danger');
                        toastr.error($errors.category_id);
                        $('#category_id').focus();
                    }
                    if ($errors.receive_amount) {
                        $('#receive_amount_Error').text($errors.receive_amount);
                        $('#receive_amount').addClass('border-danger');
                        toastr.error($errors.receive_amount);
                        $('#receive_amount').focus();
                    }
                    if ($errors.bill_amount) {
                        $('#bill_amount_Error').text($errors.bill_amount);
                        $('#bill_amount').addClass('border-danger');
                        toastr.error($errors.bill_amount);
                        $('#bill_amount').focus();
                    }
                    if ($errors.due_amount) {
                        $('#due_amount_Error').text($errors.due_amount);
                        $('#due_amount').addClass('border-danger');
                        toastr.error($errors.due_amount);
                        $('#due_amount').focus();
                    }
                    if ($errors.highest_due) {
                        $('#highest_due_Error').text($errors.highest_due);
                        $('#highest_due').addClass('border-danger');
                        toastr.error($errors.highest_due);
                        $('#highest_due').focus();
                    }
                    if ($errors.vat_type) {
                        $('#vat_type_Error').text($errors.vat_type);
                        $('#vat_type').addClass('border-danger');
                        toastr.error($errors.vat_type);
                        $('#vat_type').focus();
                    }
                    if ($errors.vat) {
                        $('#vat_Error').text($errors.vat);
                        $('#vat').addClass('border-danger');
                        toastr.error($errors.vat);
                        $('#vat').focus();
                    }
                    if ($errors.description) {
                        $('#description_Error').text($errors.description);
                        $('#description').addClass('border-danger');
                        toastr.error($errors.description);
                        $('#description').focus();
                    }
                    if ($errors.send_sms) {
                        $('#send_sms_Error').text($errors.send_sms);
                        $('#send_sms').addClass('border-danger');
                        toastr.error($errors.send_sms);
                        $('#send_sms').focus();
                    }
                    if ($errors.send_email) {
                        $('#send_email_Error').text($errors.send_email);
                        $('#send_email').addClass('border-danger');
                        toastr.error($errors.send_email);
                        $('#send_email').focus();
                    }
                }
            })
        }
    }
    // update data using ajax
</script>
