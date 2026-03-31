<?php

namespace App\Services;

use App\Models\Medical\Certificate;
use App\Traits\pdfTrait;
use Mpdf\MpdfException;
use setasign\Fpdi\PdfParser\CrossReference\CrossReferenceException;
use setasign\Fpdi\PdfParser\PdfParserException;
use setasign\Fpdi\PdfParser\Type\PdfTypeException;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use ZipArchive;

class CertificateService extends BaseService
{
    use pdfTrait;

    /**
     * print all the Services in the given order
     *
     * @param Certificate $certificate
     * @param bool $isEmployer
     * @param string $destination
     * @return false|string
     * @throws CrossReferenceException
     * @throws MpdfException
     * @throws PdfParserException
     * @throws PdfTypeException
     */
    public function printCertificate(Certificate $certificate, bool $isEmployer = false , string $destination='D'): false|string
    {
        $files = [];

        // Offer Cover page
        $mainPage = $this->generatePdf('templates.pdf.certificate_slip', ['certificate' => $certificate, 'isEmployer'=>$isEmployer , 'pageNumber' => 1]);

        $files[] = $this->saveToTemp($mainPage);

        $mainName = $isEmployer ? $certificate->employer_name : $certificate->employee_last_name;

        // merging all pages
        $fileName = $certificate->certificate_number . '-' . $mainName .'.pdf';
        return $this->mergePDFFiles($files, $fileName, $destination);
    }

    /**
     * @throws CrossReferenceException
     * @throws MpdfException
     * @throws PdfParserException
     * @throws PdfTypeException
     */
    public function downloadCertificatesZip(Certificate $certificate): BinaryFileResponse
    {
        // 1. Generate both PDFs as files
        $employerPath = $this->printCertificate($certificate, true, 'F');
        $employeePath = $this->printCertificate($certificate, false, 'F');

        // 2. Create ZIP
        $zipName = $certificate->certificate_number . '.zip';
        $zipPath = storage_path('app/mpdf/' . $zipName);

        $zip = new ZipArchive;

        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            $zip->addFile($employerPath, basename($employerPath));
            $zip->addFile($employeePath, basename($employeePath));
            $zip->close();
        }

        // 3. Return response directly from service
        return response()->download($zipPath)->deleteFileAfterSend(true);
    }

}


