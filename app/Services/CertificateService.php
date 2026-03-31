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
    public function printCertificate(Certificate $certificate, $isEmployer = false , string $destination='D'): void
    {
        // Offer Cover page
        $mainPage = $this->generatePdf('templates.pdf.certificate_slip', ['certificate' => $certificate, 'isEmployer'=>$isEmployer , 'pageNumber' => 1]);

        $files[] = $this->saveToTemp($mainPage);

        $mainName = $isEmployer ? $certificate->employer_name : $certificate->employee_last_name;

        // merging all pages
        $fileName = $certificate->certificate_number . '-' . $mainName .'.pdf';
        $this->mergePDFFiles($files, $fileName, $destination);
    }

}


