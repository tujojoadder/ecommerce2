function preset(type, route, id) {
    $.ajax({
        type: "GET",
        dataType: "json",
        url: route + '/' + id,
        success: function (data) {
            setTimeout(() => {

                if (type === "client_id") {
                    var html = '<option value="' + data.id + '">' + data.client_name + '</option>'
                    $('#client_id, .client_id').html(html);
                    $('#client_id, .client_id').val(data.id).trigger('change');
                }
                if (type === "supplier_id") {
                    var html = '<option value="' + data.id + '">' + data.supplier_name + '</option>'
                    $('#supplier_id, .supplier_id').html(html);
                    $('#supplier_id, .supplier_id').val(data.id).trigger('change');
                }
                if (type === "client_group_id") {
                    var html = '<option value="' + data.id + '">' + data.name + '</option>'
                    $('#client_group_id, .client_group_id').html(html);
                    $('#client_group_id, .client_group_id').val(data.id).trigger('change');
                }
                if (type === "supplier_group_id") {
                    var html = '<option value="' + data.id + '">' + data.name + '</option>'
                    $('#supplier_group_id, .supplier_group_id').html(html);
                    $('#supplier_group_id, .supplier_group_id').val(data.id).trigger('change');
                }
                if (type === "expense_category_id") {
                    var html = '<option value="' + data.id + '">' + data.name + '</option>'
                    $('#expense_category_id, .expense_category_id').html(html);
                    $('#expense_category_id, .expense_category_id').val(data.id).trigger('change');
                }
                if (type === "receive_category_id") {
                    var html = '<option value="' + data.id + '">' + data.name + '</option>'
                    $('#receive_category_id, .receive_category_id').html(html);
                    $('#receive_category_id, .receive_category_id').val(data.id).trigger('change');
                }
                if (type === "account_id") {
                    var html = '<option value="' + data.id + '">' + data.title + '</option>'
                    $('#account_id, .account_id').html(html);
                    $('#account_id, .account_id').val(data.id).trigger('change');
                }
            }, 500);
        }
    });
}
