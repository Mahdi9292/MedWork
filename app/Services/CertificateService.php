<?php

namespace App\Services;

use App\Models\Medical\Certificate;
use App\Traits\pdfTrait;
use Mpdf\MpdfException;
use setasign\Fpdi\PdfParser\CrossReference\CrossReferenceException;
use setasign\Fpdi\PdfParser\PdfParserException;
use setasign\Fpdi\PdfParser\Type\PdfTypeException;

class CertificateService extends BaseService
{
    use pdfTrait;

    /**
     * print all the Services in the given order
     *
     * @param Certificate $certificate
     * @param string $destination
     * @throws CrossReferenceException
     * @throws MpdfException
     * @throws PdfParserException
     * @throws PdfTypeException
     */
    public function printCertificate(Certificate $certificate, string $destination='D'): void
    {


        // Offer Cover page
        $mainPage = $this->generatePdf('templates.pdf.certificate_slip', ['certificate' => $certificate, 'pageNumber' => 1]);

        $files[] = $this->saveToTemp($mainPage);

        // merging all pages
        $fileName = 'Rechnung_'.$certificate->certificate_number.'_' . $certificate->id .'.pdf';
        $this->mergePDFFiles($files, $fileName, $destination);
    }

}


