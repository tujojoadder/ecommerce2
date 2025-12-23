var elementId = $("table").attr("id");
console.log(elementId);
var printContent = $("#" + elementId).prop("outerHTML");
var printWindow = window.open("", "_blank");
printWindow.document.open();
printWindow.document.write("<html><head><title>Print</title>");
printWindow.document.write(
    '<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">'
);

const cssStyles = `
  <style type="text/css">
    @media print {
      table {
        width: 100% !important;
      }
      td {
        padding-left: 0 !important;
        padding-right: 0 !important;
        border: 1px solid black !important;
      }
      .product-cell { width: 15% !important; }
      .datatable { border-collapse: collapse !important; border-spacing: 0 !important; }
      .datatable tbody { margin: 0 !important; padding: 0 !important; }
      .datatable tbody tr td {
        text-align: center !important;
        font-size: 16px !important;
        padding: 10px !important;
        border: 1px solid black !important;
        border-right: none;
      }
      .datatable tbody tr td:not(:last-child) {
        border-right: 1px solid black !important;
      }
      tr:last-child { page-break-after: auto; }
      .datatable thead tr th {
        font-size: 17px !important;
        padding-left: 0 !important;
        padding-right: 0 !important;
        border: 1px solid black !important;
      }
      .datatable thead tr .date-cell {
        width: 200px !important;
        text-wrap: nowrap !important;
      }
      .datatable thead tr .print-hide {
        display: none !important;
      }
      .datatable .hide-last-two-column tr td:nth-last-child(-n+2) {
        display: none !important;
      }
      #client_Infobox .col-12 {
        display: flex !important;
        justify-content: space-between !important;
      }
      h4 {
        margin: 0 !important;
        line-height: 22px !important;
        font-size: 20px !important;
      }
      #client_Infobox .datatable tbody tr td {
        font-size: 20px !important;
      }
      .datatable tfoot tr th {
        padding-left: 0 !important;
        padding-right: 0 !important;
        border: 1px solid black !important;
        border: 1px solid black !important;
      }
      .datatable tfoot tr td {
        border: 1px solid black !important;
        color: black !important;
      }
      tfoot {
        display: table-row-group !important;
      }
      th {
        vertical-align: middle !important;
      }
      @page :last {
        tfoot {
          display: table-footer-group !important;
        }
      }
    }
  </style>
`;

printWindow.document.write(cssStyles);

printWindow.document.write("</head><body>");
printWindow.document.write(printContent);

// Additional styling and content modifications
var headerHtml = $(".header").prop("outerHTML");

var htmlSupplierInfo = $("#supplier_Infobox").html();
$(printWindow.document.body).prepend(htmlSupplierInfo);

$(printWindow.document.body).find("h1").css("display", "none");
$(printWindow.document.body).prepend(headerHtml);

printWindow.document.write("</body></html>");
printWindow.document.close();
printWindow.print();
setTimeout(function () {
    printWindow.close();
    location.reload();
}, 300);
