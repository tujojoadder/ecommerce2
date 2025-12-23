// Clients group ----------------------------------------------------
function fetchClientGroups(send_to_all = null) {
    $("#client_group_id, .client_group_id").select2({
        ajax: {
            url: "/clients-group",
            dataType: "json",
            delay: 250,
            data: function (params) {
                return {
                    search_text: params.term, // Search term entered by the user
                };
            },
            processResults: function (data) {
                var results = $.map(data, function (item) {
                    return {
                        id: item.id,
                        text: item.name,
                    };
                });

                if (send_to_all == 1) {
                    var option = {
                        id: "send_to_all",
                        text: "Send To All",
                    };
                    results.unshift(option);
                }

                return {
                    results: results,
                };
            },
            cache: true,
        },
        placeholder: "Select client group",
    });
}
function fetchCategories() {
    $("#category_id, .category_id").select2({
        ajax: {
            url: "/get-category",
            dataType: "json",
            delay: 250,
            data: function (params) {
                return {
                    search_text: params.term, // Search term entered by the user
                };
            },
            processResults: function (data) {
                var results = $.map(data, function (item) {
                    return {
                        id: item.id,
                        text: item.name,
                    };
                });

                return {
                    results: results,
                };
            },
            cache: true,
        },
        placeholder: "Select Category",
    });
}
function fetchSubCategories($category_id) {
    $("#subcategory_id, .subcategory_id").select2({
        ajax: {
            url: "/get-sub-category/" + $category_id,
            dataType: "json",
            delay: 250,
            data: function (params) {
                return {
                    search_text: params.term, // Search term entered by the user
                };
            },
            processResults: function (data) {
                var results = $.map(data, function (item) {
                    return {
                        id: item.id,
                        text: item.name,
                    };
                });

                return {
                    results: results,
                };
            },
            cache: true,
        },
        placeholder: "Select Sub Category",
    });
}
function fetchSubSubCategories($category_id, $subcategory_id) {
    $("#subsubcategory_id, .subsubcategory_id").select2({
        ajax: {
            url: "/get-sub-sub-category/" + $category_id + '/' + $subcategory_id,
            dataType: "json",
            delay: 250,
            data: function (params) {
                return {
                    search_text: params.term, // Search term entered by the user
                };
            },
            processResults: function (data) {
                var results = $.map(data, function (item) {
                    return {
                        id: item.id,
                        text: item.name,
                    };
                });

                return {
                    results: results,
                };
            },
            cache: true,
        },
        placeholder: "Select Child Category",
    });
}
// Suppliers group ----------------------------------------------------
function fetchSupplierGroups(send_to_all = null) {
    $("#supplier_group_id").select2({
        ajax: {
            url: "/suppliers-group",
            dataType: "json",
            delay: 250,
            data: function (params) {
                return {
                    search_text: params.term, // Search term entered by the user
                };
            },
            processResults: function (data) {
                var results = $.map(data, function (item) {
                    return {
                        id: item.id,
                        text: item.name,
                    };
                });

                if (send_to_all == 1) {
                    var option = {
                        id: "send_to_all",
                        text: "Send To All",
                    };
                    results.unshift(option);
                }

                return {
                    results: results,
                };
            },
            cache: true,
        },
        placeholder: "Select a group",
    });
}

// clear client and supplier info after clicking clear filter
$("#clearFilter").on("click", function () {
    $("#client_Infobox").addClass("d-none");
    $("#supplier_Infobox").html("");
    $("#supplier_id_Error").text("");
});

// Clients ----------------------------------------------------
function fetchClients(send_to_all = null) {
    $(".client_id, #client_id").select2({
        ajax: {
            url: "/clients",
            dataType: "json",
            delay: 250,
            data: function (params) {
                return {
                    search_text: params.term, // Search term entered by the user
                };
            },
            processResults: function (data) {
                var results = $.map(data, function (item) {
                    var phone = item.phone == null ? "" : "- " + item.phone;
                    return {
                        id: item.id,
                        text:
                            item.client_name +
                            " (" +
                            item.company_name +
                            ") " +
                            phone,
                    };
                });

                if (send_to_all == 1) {
                    var option = {
                        id: "send_to_all",
                        text: "Send To All",
                    };
                    results.unshift(option);
                }

                return {
                    results: results,
                };
            },
            cache: true,
        },
        placeholder: "Select Client",
        allowClear: true,
    });

    $(".client_id, #client_id").on("change", function () {
        var client_id = $(this).val();
        $.ajax({
            url: "/get-client-invoices/" + client_id,
            dataType: "json",
            success: function (data) {
                var html = "";
                $.each(data, function (index, value) {
                    html += '<option value="">Select</option>';
                    html +=
                        '<option value="' +
                        value.id +
                        '"> Invoice ID: ' +
                        value.id +
                        "</option>";
                });
                $("#invoice_id").html(html);
                $("#invoice_id_Error").text("");
            },
        });

        // get client due
        $.ajax({
            url: "/get-client-due/" + client_id,
            dataType: "json",
            success: function (data) {
                if (data < 0) {
                    var type =
                        "<span id='client_due' title='" +
                        data +
                        "' class='text-success'>Advance: " +
                        Math.abs(data) +
                        "</span>";
                } else {
                    if (data <= 0) {
                        var type =
                            "<span id='client_due' title='" +
                            data +
                            "' class='text-danger'>Due: " +
                            data +
                            "</span>";
                    } else {
                        var type =
                            "<span id='client_due' title='" +
                            data +
                            "' class='text-danger'>Due: " +
                            data +
                            "</span>";
                    }
                }

                setTimeout(() => {
                    $("#client_id_Error").html(type);
                    $("#amount").val("");
                    if (data > 0) {
                        $("#previous_due").val(Math.abs(data));
                    } else {
                        $("#previous_due").val(0);
                    }
                    $("#discount").keyup();
                }, 300);
            },
        });

        // get client info on client select
        $.ajax({
            url: "/get-client-info/" + client_id,
            dataType: "json",
            success: function (data) {
                var currentDate = new Date().toLocaleDateString("en-US", {
                    day: "2-digit",
                    month: "short",
                    year: "numeric",
                });

                $(".id_no").text(data["id_no"]);
                $(".client_name").text(data["client_name"]);
                $(".fathers_name").text(data["fathers_name"]);
                $(".address").text(data["address"]);
                $(".contact_no").text(data["phone"] ?? "N/A");
                $(".reference").text(data["reference"]);
                $(".street_road").text(data["street_road"]);
                $("#client_Infobox").removeClass("d-none");
                $("#highest_due").val(data["max_due_limit"]);

                setTimeout(() => {
                    $("#amount-label").addClass("active-label");
                    $("#amount").val(data["total_due"]);
                }, 500);

                $("#remaining_due_date").val(data["remaining_due_date"]);
            },
        });

        $("#remaining-due").removeClass("d-none");
        $("#client_id_for_due").val(client_id);

        // get client all invoices
        $.ajax({
            url: "/get-client-invoices/" + client_id,
            dataType: "json",
            success: function (data) {
                var html = "";
                $.each(data, function (index, value) {
                    html += '<option value="">Select</option>';
                    html +=
                        '<option value="' +
                        value.id +
                        '"> Invoice ID: ' +
                        value.id +
                        "</option>";
                });
                $("#invoice_id").html(html);
            },
        });
    });
}

// Suppliers ----------------------------------------------------
function fetchSuppliers(send_to_all = null) {
    $(".supplier_id, #supplier_id").on("change", function () {
        var supplier_id = $(this).val();

        // get client info on client select
        $.ajax({
            url: "/get-supplier-info/" + supplier_id,
            dataType: "json",
            success: function (data) {
                var currentDate = new Date().toLocaleDateString("en-US", {
                    day: "2-digit",
                    month: "short",
                    year: "numeric",
                });

                var html = "";
                html += "<div class='row mb-3'>";
                html += "<div class='col-8'>";
                html += "Supplier Due: " + data["supplier_due"] + "<br>";
                html += "Supplier Name: " + data["supplier_name"] + "<br>";
                html += "</div>";
                html += "<div class='col-4 text-end'>";
                html += "Supplier Address: " + data["address"] + "<br>";
                html += "Supplier Phone: " + data["phone"] + "<br>";
                html += "</div>";
                html += "</div>";
                $("#supplier_Infobox, #supplier_id_Error").html(html);
            },
        });
    });

    $(".supplier_id, #supplier_id").select2({
        ajax: {
            url: "/suppliers",
            dataType: "json",
            delay: 250,
            data: function (params) {
                return {
                    search_text: params.term, // Search term entered by the user
                };
            },
            processResults: function (data) {
                var results = $.map(data, function (item) {
                    var phone = item.phone == null ? "" : "- " + item.phone;
                    return {
                        id: item.id,
                        text:
                            item.supplier_name +
                            " - (" +
                            item.company_name +
                            ") " +
                            phone,
                    };
                });

                if (send_to_all == 1) {
                    var option = {
                        id: "send_to_all",
                        text: "Send To All",
                    };
                    results.unshift(option);
                }

                return {
                    results: results,
                };
            },
            cache: true,
        },
        placeholder: "Select Suppliers",
        allowClear: true,
    });
}

// Suppliers ----------------------------------------------------
function fetchWarehouses() {
    $(".warehouse_id, #warehouse_id").select2({
        ajax: {
            url: "/warehouses",
            dataType: "json",
            delay: 250,
            data: function (params) {
                return {
                    search_text: params.term, // Search term entered by the user
                };
            },
            processResults: function (data) {
                var results = $.map(data, function (item) {
                    return {
                        id: item.id,
                        text: item.name,
                    };
                });

                return {
                    results: results,
                };
            },
            cache: true,
        },
        placeholder: "Select Warehouse",
        allowClear: true,
    });
}

// Staffs ----------------------------------------------------
function fetchStaffs() {
    $(".staff_id, #staff_id").select2({
        ajax: {
            url: "/staffs",
            dataType: "json",
            delay: 250,
            data: function (params) {
                return {
                    search_text: params.term, // Search term entered by the user
                };
            },
            processResults: function (data) {
                var results = $.map(data, function (item) {
                    return {
                        id: item.id,
                        text: item.name,
                    };
                });

                return {
                    results: results,
                };
            },
            cache: true,
        },
        placeholder: "Select Staffs",
        allowClear: true,
    });

    $("#staff_id").on("change", function () {
        var staff_id = $(this).val();
        $.ajax({
            url: "/get-staff-due/" + staff_id,
            dataType: "json",
            success: function (data) {
                var html = "";
                html += "Monthly Payment: " + data.total_monthly_payment + "<br>";
                html += "Monthly Due: " + data.total_monthly_due + "<br>";
                html += "Total Due: " + data.total_due + "<br>";
                $("#staff_id_Error").html(html);
            },
        });
    });
}

// Supplier Due ----------------------------------------------------
function getSupplierDue() {
    $(".supplier_id, #supplier_id").on("change", function () {
        var supplier_id = $(this).val();
        //  get supplier due
        $.ajax({
            type: "GET",
            url: "/get-supplier-due/" + supplier_id,
            success: function (res) {
                $("#supplier_id_Error").html(
                    "Supplier Due : " + parseFloat(res).toFixed(2)
                );
                $("#amount").val();
                $("#amount").val(res);

                // get supplier invoices
                $.ajax({
                    type: "GET",
                    url: "/get-supplier-invoices/" + supplier_id,
                    dataType: "json",
                    success: function (data) {
                        var html = "";
                        html += '<option value="">Select</option>';
                        $.each(data, function (index, value) {
                            html +=
                                '<option value="' +
                                value.id +
                                '"> Purchase ID : ' +
                                value.id +
                                "</option>";
                        });
                        $("#purchase_id").html(html);
                    },
                    error: function (error) {
                        Swal.fire({
                            toast: true,
                            position: "top-end",
                            icon: "success",
                            title: "Invoice Not Found!",
                            showConfirmButton: false,
                            timer: 1500,
                        });
                    },
                });
            },
            error: function (error) {
                // Swal.fire({
                //     toast: true,
                //     position: "top-end",
                //     icon: "success",
                //     title: "Supplier Not Found!",
                //     showConfirmButton: false,
                //     timer: 1500,
                // });
            },
        });
    });

    // get purchase list and it's due after selected
    $("#purchase_id").change(function () {
        var invoice_id = $(this).val();
        $.ajax({
            type: "GET",
            url: "/get-supplier-invoices/due/" + invoice_id,
            dataType: "json",
            success: function (res) {
                $("#purchase_id_Error").html(
                    "Purchase Due : " + parseFloat(res).toFixed(2)
                );
                $("#amount").val();
                $("#amount").val(res);
            },
            error: function (error) {
                Swal.fire({
                    toast: true,
                    position: "top-end",
                    icon: "success",
                    title: "Supplier Invoice Not Found!",
                    showConfirmButton: false,
                    timer: 1500,
                });
            },
        });
    });
}

// Accounts ----------------------------------------------------
function fetchAccounts() {
    $(".account_id, #account_id").select2({
        ajax: {
            url: "/accounts",
            dataType: "json",
            delay: 250,
            data: function (params) {
                return {
                    search_text: params.term, // Search term entered by the user
                };
            },
            processResults: function (data) {
                var results = $.map(data, function (item) {
                    return {
                        id: item.id,
                        text: item.title,
                    };
                });

                var selectedOption = $(
                    ".from_account_id, #from_account_id"
                ).val();
                if (selectedOption) {
                    results.forEach(function (result) {
                        if (result.id == selectedOption) {
                            result.disabled = true;
                        }
                    });
                }

                return {
                    results: results,
                };
            },
            cache: true,
        },
        placeholder: "Select Account",
        allowClear: true,
    });

    $(
        ".account_id, #account_id, .from_account_id, #from_account_id, .to_account_id, #to_account_id"
    ).on("change", function () {
        var account_id = $(this).val();
        var senderOrReceiverId = $(this).attr("id");
        $.ajax({
            url: "/account/" + account_id,
            dataType: "json",
            success: function (data) {
                if (senderOrReceiverId == "from_account_id") {
                    if (data.current_balance < 0) {
                        $("#from_account_id_Error").addClass("text-danger");
                    } else {
                        $("#from_account_id_Error").addClass("text-success");
                    }
                    $("#from_account_id_Error").html(
                        "Current Balance: " + data.current_balance
                    );
                } else {
                    if (data.current_balance < 0) {
                        $("#to_account_id_Error").addClass("text-danger");
                    } else {
                        $("#to_account_id_Error").addClass("text-success");
                    }
                    $("#to_account_id_Error").html(
                        "Current Balance: " + data.current_balance
                    );
                }
                if (
                    data.title == "Cheque" ||
                    data.title == "cheque" ||
                    data.title == "চেক"
                ) {
                    $(".cheque-form").removeClass("d-none");
                } else {
                    $(".cheque-form").addClass("d-none");
                }
            },
        });
    });
}

function fetchChartOfAccount() {
    $("#chart_account_id").select2({
        ajax: {
            url: "/get-chart-of-accounts",
            dataType: "json",
            delay: 250,
            data: function (params) {
                return {
                    search_text: params.term, // Search term entered by the user
                };
            },
            processResults: function (data) {
                var results = $.map(data, function (item) {
                    return {
                        id: item.id,
                        text: item.name,
                    };
                });

                return {
                    results: results,
                };
            },
            cache: true,
        },
        placeholder: "Select Chart Of Account",
        allowClear: true,
    });
}

function fetchPaymentMethods() {
    $(".payment_id, #payment_id").select2({
        ajax: {
            url: "/payment-methods",
            dataType: "json",
            delay: 250,
            data: function (params) {
                return {
                    search_text: params.term, // Search term entered by the user
                };
            },
            processResults: function (data) {
                var results = $.map(data, function (item) {
                    return {
                        id: item.id,
                        text: item.name,
                    };
                });

                return {
                    results: results,
                };
            },
            cache: true,
        },
        placeholder: "Select Payment Method",
        allowClear: true,
    });
}

function fetchBanks() {

    $(".bank_id, #bank_id").select2({
        ajax: {
            url: "/get-banks",
            dataType: "json",
            delay: 250,
            data: function (params) {
                return {
                    search_text: params.term, // Search term entered by the user
                };
            },
            processResults: function (data) {
                var results = $.map(data, function (item) {
                    return {
                        id: item.id,
                        text: item.name,
                    };
                });

                return {
                    results: results,
                };
            },
            cache: true,
        },
        placeholder: "Select Bank",
        allowClear: true,
    });
}

function fetchChartOfAccountGroup() {
    $("#chart_group_id").select2({
        ajax: {
            url: "/get-chart-of-account-groups",
            dataType: "json",
            delay: 250,
            data: function (params) {
                return {
                    search_text: params.term, // Search term entered by the user
                };
            },
            processResults: function (data) {
                var results = $.map(data, function (item) {
                    return {
                        id: item.id,
                        text: item.name,
                    };
                });

                return {
                    results: results,
                };
            },
            cache: true,
        },
        placeholder: "Select Chart Of Account Group",
        allowClear: true,
    });
}

function fetchProjects() {
    $("#project_id").select2({
        ajax: {
            url: "/accounts",
            dataType: "json",
            delay: 250,
            data: function (params) {
                return {
                    search_text: params.term, // Search term entered by the user
                };
            },
            processResults: function (data) {
                var results = $.map(data, function (item) {
                    return {
                        id: item.id,
                        text: item.project_name,
                    };
                });

                return {
                    results: results,
                };
            },
            cache: true,
        },
        placeholder: "Select Project",
        allowClear: true,
    });
}

function fetchInvoices() {
    $("#invoice_id").select2({
        ajax: {
            url: "/invoices",
            dataType: "json",
            delay: 250,
            data: function (params) {
                return {
                    search_text: params.term, // Search term entered by the user
                };
            },
            processResults: function (data) {
                var results = $.map(data, function (item) {
                    return {
                        id: item.id,
                        text: "Invoice ID: " + item.id,
                    };
                });

                return {
                    results: results,
                };
            },
            cache: true,
        },
        placeholder: "Select Invoice",
        allowClear: true,
    });
}

function fetchInvoiceDue() {
    $("#invoice_id, .invoice_id").on("change", function () {
        var invoice_id = $(this).val();
        $.ajax({
            url: "/get-client-invoice-due/" + invoice_id,
            dataType: "json",
            success: function (data) {
                var due = "Invoice Due: " + data["client_invoice_due"];
                $("#invoice_id_Error").html(due);
                $("#amount-label").addClass("active-label");
                $("#amount").val(Math.abs(data["client_invoice_due"]));
            },
        });
    });
}

function fetchReceiveCategories() {
    $(
        "#category_id, .category_id, #receive_category_id, .receive_category_id"
    ).select2({
        ajax: {
            url: "/get-receive-categories",
            dataType: "json",
            delay: 250,
            data: function (params) {
                return {
                    search_text: params.term, // Search term entered by the user
                };
            },
            processResults: function (data) {
                var results = $.map(data, function (item) {
                    return {
                        id: item.id,
                        text: item.name,
                    };
                });

                return {
                    results: results,
                };
            },
            cache: true,
        },
        placeholder: "Select Categories",
        allowClear: true,
    });
}

function fetchReceiveSubCategories() {
    $("#subcategory_id").select2({
        ajax: {
            url: function () {
                var category_id = $("#category_id").val();
                return "/get-receive-subcategories?" + category_id;
            },
            dataType: "json",
            delay: 250,
            data: function (params) {
                return {
                    search_text: params.term, // Search term entered by the user
                };
            },
            processResults: function (data) {
                var results = $.map(data, function (item) {
                    return {
                        id: item.id,
                        text: item.name,
                    };
                });

                return {
                    results: results,
                };
            },
            cache: true,
        },
        placeholder: "Select Sub Categories",
        allowClear: true,
    });
}

function fetchProducts() {
    $("#product_search, #product_id").select2({
        ajax: {
            url: "/products",
            dataType: "json",
            delay: 250,
            data: function (params) {
                return {
                    search_text: params.term, // Search term entered by the user
                };
            },
            processResults: function (data) {
                var results = $.map(data, function (item) {
                    return {
                        id: item.id,
                        text: item.name + " (" + item.selling_price + ")",
                    };
                });

                return {
                    results: results,
                };
            },
            cache: true,
        },
        placeholder: "Select Product",
        allowClear: true,
    });
}

function fetchProductGroups() {
    $("#product_group_id, #group_id").select2({
        ajax: {
            url: "/product-groups",
            dataType: "json",
            delay: 250,
            data: function (params) {
                return {
                    search_text: params.term, // Search term entered by the user
                };
            },
            processResults: function (data) {
                var results = $.map(data, function (item) {
                    return {
                        id: item.id,
                        text: item.name,
                    };
                });

                return {
                    results: results,
                };
            },
            cache: true,
        },
        placeholder: "Select Product Group",
        allowClear: true,
    });
}

function fetchProductUnits() {
    $("#unit_id").select2({
        ajax: {
            url: "/products-units",
            dataType: "json",
            delay: 250,
            data: function (params) {
                return {
                    search_text: params.term, // Search term entered by the user
                };
            },
            processResults: function (data) {
                var results = $.map(data, function (item) {
                    return {
                        id: item.id,
                        text: item.name,
                    };
                });

                return {
                    results: results,
                };
            },
            cache: true,
        },
        placeholder: "Select a Unit",
        allowClear: true,
    });
}

function fetchProductColors() {
    $("#color_id").select2({
        ajax: {
            url: "/products-colors",
            dataType: "json",
            delay: 250,
            data: function (params) {
                return {
                    search_text: params.term, // Search term entered by the user
                };
            },
            processResults: function (data) {
                var results = $.map(data, function (item) {
                    return {
                        id: item.id,
                        text: item.asset,
                    };
                });

                return {
                    results: results,
                };
            },
            cache: true,
        },
        placeholder: "Select Product Color",
        allowClear: true,
    });
}

function fetchProductSizes() {
    $("#size_id").select2({
        ajax: {
            url: "/products-sizes",
            dataType: "json",
            delay: 250,
            data: function (params) {
                return {
                    search_text: params.term, // Search term entered by the user
                };
            },
            processResults: function (data) {
                var results = $.map(data, function (item) {
                    return {
                        id: item.id,
                        text: item.asset,
                    };
                });

                return {
                    results: results,
                };
            },
            cache: true,
        },
        placeholder: "Select Product Size",
        allowClear: true,
    });
}

function fetchProductBrands() {
    $("#brand_id, .brand_id").select2({
        ajax: {
            url: "/products-brands",
            dataType: "json",
            delay: 250,
            data: function (params) {
                return {
                    search_text: params.term, // Search term entered by the user
                };
            },
            processResults: function (data) {
                var results = $.map(data, function (item) {
                    return {
                        id: item.id,
                        text: item.brand_name,
                    };
                });

                return {
                    results: results,
                };
            },
            cache: true,
        },
        placeholder: "Select Product Brand",
        allowClear: true,
    });
}

function fetchPurchasedProducts() {
    $("#product_search, #product_id").select2({
        ajax: {
            url: "/purchased-products",
            dataType: "json",
            delay: 250,
            data: function (params) {
                return {
                    search_text: params.term, // Search term entered by the user
                };
            },
            processResults: function (data) {
                var results = $.map(data, function (item) {
                    return {
                        id: item.id,
                        title: item.purchase_id,
                        text:
                            item.product.name + " (" + item.selling_price + ")",
                    };
                });

                return {
                    results: results,
                };
            },
            cache: true,
        },
        placeholder: "Select by Product Name",
        allowClear: true,
    });
}

function fetchExpenseCategories() {
    $(".expense_category_id, #expense_category_id").on("change", function () {
        $("#subcategory_id").val("").trigger("change");
    });

    $(".expense_category_id, #expense_category_id").select2({
        ajax: {
            url: "/get-expense-categories",
            dataType: "json",
            delay: 250,
            data: function (params) {
                return {
                    search_text: params.term, // Search term entered by the user
                };
            },
            processResults: function (data) {
                var results = $.map(data, function (item) {
                    return {
                        id: item.id,
                        text: item.name,
                    };
                });

                return {
                    results: results,
                };
            },
            cache: true,
        },
        placeholder: "Select Categories",
        allowClear: true,
    });
}

function fetchExpenseSubcategories() {
    $("#subcategory_id, #expense_subcategory_id").select2({
        ajax: {
            url: function () {
                var category_id = $("#expense_category_id").val();
                return "/get-expense-subcategories?" + category_id;
            },
            dataType: "json",
            delay: 250,
            data: function (params) {
                return {
                    search_text: params.term, // Search term entered by the user
                };
            },
            processResults: function (data) {
                var results = $.map(data, function (item) {
                    return {
                        id: item.id,
                        text: item.name,
                    };
                });

                return {
                    results: results,
                };
            },
            cache: true,
        },
        placeholder: "Select Sub Categories",
        allowClear: true,
    });
}

function fetchBranches() {
    $("#branch_id, .branch_id").select2({
        ajax: {
            url: "/get-branches",
            dataType: "json",
            delay: 250,
            data: function (params) {
                return {
                    search_text: params.term,
                };
            },
            processResults: function (data) {
                var results = $.map(data, function (item) {
                    return {
                        id: item.id,
                        text: item.name + " (" + item.address + ")",
                    };
                });

                return {
                    results: results,
                };
            },
            cache: true,
        },
        placeholder: "Select Branch",
        allowClear: true,
    });
}
