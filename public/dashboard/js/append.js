function getClientInfo(route, id) {
    $.ajax({
        type: "GET",
        dataType: "json",
        url: route + "/" + id,
        success: function (data) {
            var html = '<option value="' + data.id + '">' + data.client_name + "</option>";
            $("#client_id").append(html);
            $("#client_id").val(data.id).trigger("change");
        },
    });
}

function getClientGroupInfo(route, id) {
    $.ajax({
        type: "GET",
        dataType: "json",
        url: route + "/" + id,
        success: function (data) {
            var html = '<option value="' + data.id + '">' + data.name + "</option>";
            $("#client_group_id, .client_group_id").append(html);
            $("#client_group_id, .client_group_id").val(data.id).trigger("change");
        },
    });
}

function getCategoryInfo(route, id) {
    $.ajax({
        type: "GET",
        dataType: "json",
        url: route + "/" + id,
        success: function (data) {
            var html = '<option value="' + data.id + '">' + data.name + "</option>";
            $("#category_id, .category_id").append(html);
            $("#category_id, .category_id").val(data.id).trigger("change");
        },
    });
}

function getSubCategoryInfo(route, id) {
    $.ajax({
        type: "GET",
        dataType: "json",
        url: route + "/" + id,
        success: function (data) {
            var html = '<option value="' + data.id + '">' + data.name + "</option>";
            $("#subcategory_id, .subcategory_id").append(html);
            $("#subcategory_id, .subcategory_id").val(data.id).trigger("change");
        },
    });
}

function getSubSubCategoryInfo(route, id) {
    $.ajax({
        type: "GET",
        dataType: "json",
        url: route + "/" + id,
        success: function (data) {
            var html = '<option value="' + data.id + '">' + data.name + "</option>";
            $("#subsubcategory_id, .subsubcategory_id").append(html);
            $("#subsubcategory_id, .subsubcategory_id").val(data.id).trigger("change");
        },
    });
}

function getSupplierInfo(route, id) {
    $.ajax({
        type: "GET",
        dataType: "json",
        url: route + "/" + id,
        success: function (data) {
            var html = '<option value="' + data.id + '">' + data.supplier_name + "</option>";
            $("#supplier_id").append(html);
            $("#supplier_id").val(data.id).trigger("change");
        },
    });
}

function getSupplierGroupInfo(route, id) {
    $.ajax({
        type: "GET",
        dataType: "json",
        url: route + "/" + id,
        success: function (data) {
            var html = '<option value="' + data.id + '">' + data.name + "</option>";
            $("#supplier_group_id, .supplier_group_id").append(html);
            $("#supplier_group_id, .supplier_group_id").val(data.id).trigger("change");
        },
    });
}

function getProductGroupInfo(route, id) {
    $.ajax({
        type: "GET",
        dataType: "json",
        url: route + "/" + id,
        success: function (data) {
            var html = '<option value="' + data.id + '">' + data.name + "</option>";
            $("#group_id, .group_id").append(html);
            $("#group_id, .group_id").val(data.id).trigger("change");
        },
    });
}

function getProductInfo(route, id) {
    $.ajax({
        type: "GET",
        dataType: "json",
        url: route + "/" + id,
        success: function (data) {
            var html = '<option value="' + data.id + '">' + data.name + "</option>";
            $("#product_search").append(html);
            $("#product_search").val(data.id).trigger("change");
        },
    });
}

function getProductColorInfo(route, id) {
    $.ajax({
        type: "GET",
        dataType: "json",
        url: route + "/" + id,
        success: function (data) {
            var html = '<option value="' + data.id + '">' + data.asset + "</option>";
            $("#color_id, .color_id").append(html);
            $("#color_id, .color_id").val(data.id).trigger("change");
        },
    });
}

function getProductSizeInfo(route, id) {
    $.ajax({
        type: "GET",
        dataType: "json",
        url: route + "/" + id,
        success: function (data) {
            var html = '<option value="' + data.id + '">' + data.asset + "</option>";
            $("#size_id, .size_id").append(html);
            $("#size_id, .size_id").val(data.id).trigger("change");
        },
    });
}

function getProductBrandInfo(route, id) {
    $.ajax({
        type: "GET",
        dataType: "json",
        url: route + "/" + id,
        success: function (data) {
            var html = '<option value="' + data.id + '">' + data.brand_name + "</option>";
            $("#brand_id, .brand_id").append(html);
            $("#brand_id, .brand_id").val(data.id).trigger("change");
        },
    });
}

function getProductUnitInfo(route, id) {
    $.ajax({
        type: "GET",
        dataType: "json",
        url: route + "/" + id,
        success: function (data) {
            var html = '<option value="' + data.id + '">' + data.name + "</option>";
            $("#unit_id, .unit_id").append(html);
            $("#unit_id, .unit_id").val(data.id).trigger("change");
        },
    });
}

function getAccountInfo(route, id) {
    $.ajax({
        type: "GET",
        dataType: "json",
        url: route + "/" + id,
        success: function (data) {
            var html = '<option value="' + data.id + '">' + data.title + "</option>";
            $("#account_id").append(html);
            $("#account_id").val(data.id).trigger("change");
        },
    });
}

function getBranchInfo(route, id) {
    $.ajax({
        type: "GET",
        dataType: "json",
        url: route + "/" + id,
        success: function (data) {
            var html = "<option value='" + data.id + "'>" + data.name + " (" + data.address + ")</option>";
            $("#branch_id").append(html);
            $("#branch_id").val(data.id).trigger("change");
        },
    });
}

function getExpenseCategoryInfo(route, id) {
    $.ajax({
        type: "GET",
        dataType: "json",
        url: route + "/" + id,
        success: function (data) {
            var html = '<option value="' + data.id + '">' + data.name + "</option>";
            $("#expense_category_id, .expense_category_id").append(html);
            $("#expense_category_id, .expense_category_id").val(data.id).trigger("change");
        },
    });
}
function getExpenseSubCategoryInfo(route, id) {
    $.ajax({
        type: "GET",
        dataType: "json",
        url: route + "/" + id,
        success: function (data) {
            var html = '<option value="' + data.id + '">' + data.name + "</option>";
            $("#subcategory_id, .subcategory_id").append(html);
            $("#subcategory_id, .subcategory_id").val(data.id).trigger("change");
        },
    });
}

function getReceiveCategoryInfo(route, id) {
    $.ajax({
        type: "GET",
        dataType: "json",
        url: route + "/" + id,
        success: function (data) {
            var html = '<option value="' + data.id + '">' + data.name + "</option>";
            $("#receive_category_id, .receive_category_id, #category_id").append(html);
            $("#receive_category_id, .receive_category_id, #category_id").val(data.id).trigger("change");
        },
    });
}

function getPaymentMethodInfo(route, id) {
    $.ajax({
        type: "GET",
        dataType: "json",
        url: route + "/" + id,
        success: function (data) {
            var html = '<option value="' + data.id + '">' + data.name + "</option>";
            $("#payment_id, .payment_id").append(html);
            $("#payment_id, .payment_id").val(data.id).trigger("change");
        },
    });
}
