<div id="moneyReceiptBody">
    <div class="card " style="border: 2px solid #0fb465 !important; margin-bottom: 0px; font-family: 'Bree Serif', serif;">
        <div class="card-header" style="background: #0fb46508!important; border-bottom: 2px solid #0fb465; padding-bottom: 2px;">
            <div class="row">
                <div class="col-2 text-center m-auto">
                    <img src="{{ config('company.logo') }}" class="img-fluid logo" alt="" style="width: 80px;">
                </div>
                <div class="col-7 px-1">

                    <h3 class="receipt-name" style="margin-bottom: 1px; font-size: 18px; color: #008000; text-transform: uppercase; font-weight: 600; letter-spacing: 4px;">{{ config('company.name') }}</h3>

                    <h4 class="receipt-address" style="font-size: 16px; color: #252525; text-transform: capitalize; font-weight: 500; letter-spacing: 1px; font-family: 'Stoke', serif; margin: 4px 0px 3px 0px;">{{ config('company.address') }}</h4>

                    <h5 class="receipt-email" style="font-size: 16px; color: #252525; text-transform: lowercase; font-weight: 500; letter-spacing: 1px; font-family: 'Stoke', serif; margin: 4px 0px 3px 0px;">{{ config('company.email') }}</h5>

                    <h5 class="receipt-phone" style="font-size: 16px; color: #252525; text-transform: capitalize; font-weight: 500; letter-spacing: 1px; font-family: 'Stoke', serif; margin: 4px 0px 3px 0px;">{{ config('company.phone') }}</h5>

                </div>
                <div class="col-3 px-0">
                    <table class="table-bordered w-100 receipt-info">
                        <tr>
                            <td class="receipt-no" style="padding: 10px !important; font-size: 12px; font-weight: 600; letter-spacing: 1px; font-family: sans-serif; border: 1px solid #0fb465; background: #0fb465; color: #fff;">
                                Receipt No : #{{ zero($transaction->id) . $transaction->id }}
                            </td>
                        </tr>
                        <tr>
                            <td class="receipt-date" style="padding: 10px !important; font-size: 12px; font-weight: 600; letter-spacing: 1px; font-family: sans-serif; border: 1px solid #0fb465; background: #fff; color: #333;">
                                Date : {{ bnDateFormat($transaction->date) }}
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-12" style="text-align: center;">
                    <h2 style="font-size: 24px; margin: 0; text-align: center; font-weight: 700; color: #0fb465; letter-spacing: 1.5px; text-transform: uppercase; font-family: sans-serif; margin-top: 11px;">Money Receipt</h2>
                </div>
            </div>
        </div>
        <div class="card-body" style="background: #0fb46508!important;">
            <div class="client-info">
                <h2 style="margin-bottom: 10px; font-size: 18px; font-family: 'Stoke', serif; border-bottom: 1px dashed #0fb465; padding-bottom: 5px;"><strong>Received From :</strong> {{ $receiver_name ?? 'N/A' }}</h2>

                <div class="row">
                    <div class="col-6">
                        <h2 style="margin-bottom: 10px; font-size: 18px; font-family: 'Stoke', serif; border-bottom: 1px dashed #0fb465; padding-bottom: 5px;"><strong>Mobile :</strong> {{ $receiver_phone ?? 'N/A' }}</h2>
                    </div>
                    <div class="col-6">
                        <h2 style="margin-bottom: 10px; font-size: 18px; font-family: 'Stoke', serif; border-bottom: 1px dashed #0fb465; padding-bottom: 5px;"><strong>Bank :</strong> {{ $receiver_bank ?? 'N/A' }}</h2>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6">
                        <h2 style="margin-bottom: 10px; font-size: 18px; font-family: 'Stoke', serif; border-bottom: 1px dashed #0fb465; padding-bottom: 5px; text-transform: capitalize;"><strong>Cheque No :</strong> {{ $transaction->cheque_no }}</h2>
                    </div>
                    <div class="col-6">
                        <h2 style="margin-bottom: 10px; font-size: 18px; font-family: 'Stoke', serif; border-bottom: 1px dashed #0fb465; padding-bottom: 5px;"><strong>Payment Method :</strong> {{ $transaction->paymentMethod->name ?? '' }}</h2>
                    </div>
                </div>

                <h2 style="margin-bottom: 10px; font-size: 18px; font-family: 'Stoke', serif; border-bottom: 1px dashed #0fb465; padding-bottom: 5px;"><strong>Description :</strong> {{ $transaction->description ?? '' }}</h2>

                <h2 style="margin-bottom: 10px; font-size: 18px; font-family: 'Stoke', serif; border-bottom: 1px dashed #0fb465; padding-bottom: 5px; text-transform: capitalize;"><strong>Amount (In Word) :</strong> {{ number2word($transaction->amount) }}</h2>

                <h2 style="margin-bottom: 10px; padding-top: 10px; margin-top: 10px; font-size: 18px; font-family: 'Stoke', serif; padding-bottom: 5px;">
                    <div class="d-flex justify-content-between">
                        <div>
                            <strong>BDT :</strong> <span style="border: 1px solid #0fb465; padding: 5px 50px; font-size: 17px; font-weight: 600; padding-left: 10px">{{ $transaction->amount ?? '0.00' }}</span>
                        </div>
                        <div>
                            <strong>{{ __('messages.last_due') }} :</strong> <span style="border: 1px solid #0fb465; padding: 5px 50px; font-size: 17px; font-weight: 600; padding-left: 10px">{{ $transaction->current_due < 0 ? 0 : $transaction->current_due }}</span>
                        </div>
                    </div>
                </h2>
            </div>
            <div class="client-info" style="margin-top: 70px;">
                <div class="row">
                    <div class="col-4 px-0" style="text-align: center;">
                        <h5 style="width: 70%; padding-top: 10px; border-top: 1px solid #0fb465; margin: auto;">{{ __('messages.receiver_signature') }}</h5>
                    </div>
                    <div class="col-4 px-0" style="text-align: center;">
                        <h5 style="width: 70%; padding-top: 10px; border-top: 1px solid #0fb465; margin: auto;">{{ __('messages.account') }}</h5>
                    </div>
                    <div class="col-4 px-0" style="text-align: center;">
                        <h5 style="width: 70%; padding-top: 10px; border-top: 1px solid #0fb465; margin: auto;">{{ __('messages.authorization_signature') }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
