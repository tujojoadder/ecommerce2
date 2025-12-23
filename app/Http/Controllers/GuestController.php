<?php

namespace App\Http\Controllers;

use App\Helpers\ClientBalanceHelper;
use App\Helpers\Traits\InvoiceTrait;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Mpdf\HTMLParserMode;
use Mpdf\Mpdf;

class GuestController extends Controller
{
    use InvoiceTrait;
    public function invoice($id)
    {
        try {
            $defaultFontConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
            $fontDirs = $defaultFontConfig['fontDir'];

            $defaultFontData = (new \Mpdf\Config\FontVariables())->getDefaults();
            $fontData = $defaultFontData['fontdata'];
            $path = public_path() . '/fonts';
            $mpdf = new Mpdf([
                'format' => 'A4',
                'margin_left' => 0,
                'margin_right' => 0,
                'margin_top' => 0,
                'margin_bottom' => 0,
                'margin_header' => 5,
                'margin_footer' => 5,
                'fontDir' => array_merge($fontDirs, [$path]),
                'fontdata' => $fontData + [
                    'solaimanlipi' => [
                        'R' => 'SolaimanLipi.ttf',
                        'useOTL' => 0xFF,
                    ],
                ],
                'default_font' => 'solaimanlipi',
                'autoScriptToLang' => true,
                'autoLangToFont' => true,
            ]);

            $invoice = Invoice::with('invoiceItems')->findOrFail($id);
            $invoice_items = InvoiceItem::with(['product', 'unit'])->where('invoice_id', $id)->get();
            $payment = $this->invoicePayment($id);
            $invoiceDue = $this->invoiceDue($id);
            $previousDue = ClientBalanceHelper::getClientTotalDue(Transaction::class, $invoice->client_id) - $invoiceDue;
            $totalDue = $invoice->grand_total + $previousDue;
            $netDue = $invoiceDue + $previousDue;
            $pageTitle = mb_convert_encoding(__('messages.invoice'), 'UTF-8');

            $data = [
                'invoice' => $invoice,
                'invoice_items' => $invoice_items,
                'pageTitle' => $pageTitle,
                'payment' => $payment,
                'previousDue' => $previousDue,
                'totalDue' => $totalDue,
                'invoiceDue' => $invoiceDue,
                'netDue' => $netDue
            ];

            $htmlContent = view('user.invoice.pdf', ['data' => $data])->render();
            // dd($htmlContent);
            $mpdf->WriteHTML($htmlContent);
            $mpdf->output(); // Remove this comment to view
            return response($mpdf->Output('invoice.pdf', 'D'), 200)->header('Content-Type', 'application/pdf');
        } catch (\Mpdf\MpdfException $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
