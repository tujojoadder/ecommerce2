function getSupplierInfo(route, id){
    $.ajax({
        type: "GET",
        dataType: "json",
        url: route + '/' + id,
        success: function(data) {
            var html = '<option value="' + data.id + '">' + data.client_name + '</option>'
            $('#client_id').html(html);
            $('#client_id').val(data.id).trigger('change');
        }
    });
}
