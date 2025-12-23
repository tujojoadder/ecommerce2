<div class="modal fade" id="printReceiptModal">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content shadow-lg">
            <div class="modal-header">
                <h6 class="modal-title">EXPENSE VOUCHER</h6>
                <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body moneyReceiptBody">

            </div>
            <div class="modal-footer">
                <button class="btn btn-success" onclick="printDiv('moneyReceiptBody')" type="button"><i class="fas fa-print"></i> Print</button>
                <button class="btn btn-danger" data-bs-dismiss="modal" id="receiveModalClose" type="button"><i class="far fa-times-circle"></i> Cancel</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        function printReceipt(id) {
            var data_id = id;
            var url = '{{ route('user.expense.view', ':id') }}';
            url = url.replace(':id', data_id);
            $.ajax({
                url: url,
                type: "GET",
                success: function(data) {
                    $('.moneyReceiptBody').html('');
                    $('.moneyReceiptBody').html(data);
                    $("#printReceiptModal").modal("show");
                }
            });
        }
    </script>
@endpush

@push('scripts')
    <script>
        function printDiv(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;
            $('body').css('background', '#fff');

            window.print();

            document.body.innerHTML = originalContents;
        }
    </script>
@endpush
