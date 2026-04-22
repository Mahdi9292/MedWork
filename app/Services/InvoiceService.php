<?php

namespace App\Services;

use App\Models\Finance\Invoice;
use App\Traits\pdfTrait;
use Mpdf\MpdfException;
use setasign\Fpdi\PdfParser\CrossReference\CrossReferenceException;
use setasign\Fpdi\PdfParser\PdfParserException;
use setasign\Fpdi\PdfParser\Type\PdfTypeException;

class InvoiceService extends BaseService
{
    use pdfTrait;

    /**
     * print all the Services in the given order
     *
     * @param Invoice $invoice
     * @param string $destination
     * @throws CrossReferenceException
     * @throws MpdfException
     * @throws PdfParserException
     * @throws PdfTypeException
     */
    public function printInvoice(Invoice $invoice, string $destination='D'): void
    {


        // page count
        $totalPages = $invoice->invoiceItems()->count()+1;

        // Check if at least one item has a description
        $hasDescription = $invoice->invoiceItems?->contains(fn($s) => !empty($s->description));

        // Offer Cover page
        $mainPage = $this->generatePdf('templates.pdf.invoice_slip',
            [
                'invoice' => $invoice,
                'totalPages' => $totalPages,
                'pageNumber' => 1,
                'hasDescription' => $hasDescription,
            ]);

        $files[] = $this->saveToTemp($mainPage);

        // merging all pages
        $fileName = 'Rechnung_'.$invoice->invoice_number.'_' . $invoice->id .'.pdf';
        $this->mergePDFFiles($files, $fileName, $destination);
    }

}


