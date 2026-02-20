<?php

namespace App\Traits;

use Mpdf\Mpdf;
use Mpdf\MpdfException;
use Illuminate\Support\Facades\File;
use Mccarlosen\LaravelMpdf\LaravelMpdf;
use setasign\Fpdi\PdfParser\PdfParserException;
use setasign\Fpdi\PdfParser\Type\PdfTypeException;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf as pdf;
use setasign\Fpdi\PdfParser\CrossReference\CrossReferenceException;

/**
 * Class pdfTrait
 * contain all utility functions to handle PDF files
 *
 * @package App
 */
trait pdfTrait
{
    /**
     * generate PDF for the given template
     *
     * @param string $template
     * @param array $data
     * @return LaravelMpdf
     * @throws MpdfException
     */
    public function generatePdf(string $template, array $data=[]): LaravelMpdf
    {
        return pdf::chunkLoadView('<html-separator/>', $template, $data, [], ['curlAllowUnsafeSslRequests' => true, 'mirrorMargins' => true]);
    }

    /**
     * Merge given PDF files.
     * $files:
     * - should contain a valid and full file path.
     * $outputFileName:
     * - should contain a full path in case of save
     * - should only contain the name of a file for download
     * $destination:
     * - I = Inline, D = Download, F = File save (full path required), S = string return
     *
     * @param array $files
     * @param string $outputFileName
     * @param string $destination
     * @return false|string
     * @throws MpdfException|CrossReferenceException|PdfParserException|PdfTypeException
     */
    public function mergePDFFiles(Array $files, string $outputFileName='document.pdf', string $destination='D')
    {
        $mpdf = new Mpdf(['tempDir'=> storage_path('app/mpdf'), 'curlAllowUnsafeSslRequests' => true]);
        $mpdf->curlAllowUnsafeSslRequests = true;

        if(!$files) {
            return false;
        }

        $fileNumber = 1;
        foreach ($files as $fileName)
        {
            if (!file_exists($fileName)) {
                continue;
            }

            // merging files
            $pagesInFile = $mpdf->setSourceFile($fileName);
            for ($i = 1; $i <= $pagesInFile; $i++)
            {
                $tplId = $mpdf->importPage($i);
                $mpdf->useTemplate($tplId);
                if (($fileNumber < sizeof($files)) || ($i != $pagesInFile)) {
                    $mpdf->WriteHTML('<pagebreak />');
                }
            }

            $fileNumber++;
        }

        $fullPath = storage_path('app/mpdf/'.$outputFileName);
        $output = $mpdf->Output(($destination == 'F' ? $fullPath : $outputFileName), $destination);

       return $destination == 'F' ? $fullPath : $output;
    }

    /**
     * save generated pdf to temporary folder
     * return path of the saved file.
     *
     * @throws MpdfException
     */
    public function saveToTemp(LaravelMpdf $pdf): string
    {
        $fileName = uniqid('temp_'.time(), true) .'.pdf';
        $filePath = storage_path('app/mpdf/'.$fileName);
        $pdf->save($filePath);

        return $filePath;
    }

    /**
     * delete all files from pdf temp directory
     * Folder: storage\app\mpdf
     *
     * @return void
     */
    public function cleanPdfTempDirectory(): void
    {
        File::cleanDirectory(storage_path('app/mpdf'));
    }
}
