@extends('layouts.user.app', ['pageTitle' => $pageTitle])
@section('content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-print-css@1.0.1/css/bootstrap-print.min.css" rel="stylesheet">
    <div class="main-content-body">
        <div class="card">
            <div class="card-header">{{ $pageTitle }}</div>
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div id="barcode-form" class="d-flex flex">
                            <div class="input-group flex-grow-1">
                                <select id="product_id" class="form-control select2" name="product_id" required></select>
                            </div>
                            <div class="input-group">
                                <input type="number" id="quantity" value="1" min="1" class="form-control rounded-0" placeholder="{{ __('messages.quantity') }}">
                                <button type="button" class="btn add-btn btn-dark" id="generate-barcode-btn">{{ __('messages.create') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="btn btn-info mt-3" onclick="printElement('elementToPrint');">
                    <i class="fas fa-print"></i> {{ __('messages.print') }}
                </button>
                <div class="row mx-auto mt-4" id="elementToPrint"></div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('dashboard/js/select2-fetch.js') }}"></script>
    <script>
        $(document).ready(function() {
            fetchProducts();
        });
        $(document).ready(function() {
            $('#generate-barcode-btn').on('click', function(e) {
                e.preventDefault();

                const productId = $('#product_id').val();
                const quantity = $('#quantity').val();
                const barcodeContainer = $('#elementToPrint');

                if (!productId || quantity < 1) {
                    alert('Please select a product and enter a valid quantity.');
                    return;
                }

                $.ajax({
                    url: `/api/get-product-barcode/${productId}`,
                    type: 'GET',
                    dataType: 'json',
                    success: function(product) {
                        if (!product || !product.id) {
                            alert('Invalid product selected.');
                            return;
                        }

                        for (let i = 0; i < quantity; i++) {
                            const barcodeHTML = `
                                <div class="col-md-3 p-2">
                                    <div class="card-body border border-dark text-center p-2">
                                        <span class="company_name">{{ config('company.name') }}</span>
                                        <br>
                                        <b class="product_name">${product.name}</b>
                                        <br>
                                        <span class="price">{{ __('messages.price') }}: ${product.selling_price}</span>
                                        <br>
                                        <div class="mb-1">
                                            <div class="d-flex justify-content-center">
                                                <img class="barcode_image" src="data:image/png;base64,${product.barcode}" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;
                            barcodeContainer.append(barcodeHTML);
                        }

                        toastr.success('Barcodes generated successfully.');
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                        alert('An error occurred while generating barcodes.');
                    }
                });
            });
        });

        function printElement(elementId) {
            const printContent = document.getElementById(elementId).outerHTML;
            const printWindow = window.open('', '_blank');
            printWindow.document.open();
            printWindow.document.write(`
                <html>
                    <head>
                        <title>Print</title>
                        <style>
                            @page {
                                size: auto !important;
                                margin: 0 !important;
                            }
                            body {
                                text-align: center;
                                font-size: 12px;
                                margin: 0px;
                            }
                            .company_name {
                                font-size: 13px;
                                font-weight: 700;
                            }
                            .product_name {
                                font-size: 12px;
                            }
                            .price {
                                font-size: 14px;
                                font-weight: 700;
                            }
                            .barcode_image {
                                width: 150px;
                                height: 20px;
                                margin-top: 3px;
                            }
                            @media print {
                                @page {
                                    size: auto !important;
                                    margin: 0 !important;
                                }
                                .row {
                                    display: flex;
                                    flex-wrap: wrap;
                                    justify-content: center;
                                }
                                .col-md-3 {
                                    flex: 0 0 calc(20% - 10px);
                                    margin: 5px;
                                    border: 1px solid black;
                                    padding: 5px;
                                }
                            }
                        </style>
                    </head>
                    <body>
                        ${printContent}
                    </body>
                </html>
            `);
            printWindow.document.close();
            printWindow.print();
            setTimeout(() => {
                printWindow.close();
                location.reload();
            }, 100);
        }
    </script>
@endpush
