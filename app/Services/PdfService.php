<?php

namespace App\Services;

use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Facades\Storage;

class PdfService
{
    /**
     * Generate PDF from HTML content
     *
     * @param string $html
     * @param string $filename
     * @param array $options
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function generatePdf($html, $filename, $options = [])
    {
        try {
            // Get default options from config
            $defaultOptions = config('browsershot.default_pdf_options', [
                'format' => 'A4',
                'landscape' => false,
                'margins' => [
                    'top' => '10mm',
                    'right' => '10mm',
                    'bottom' => '10mm',
                    'left' => '10mm'
                ],
                'preferCssPageSize' => true,
                'printBackground' => true,
                'timeout' => 30000,
            ]);

            $options = array_merge($defaultOptions, $options);

            // Create temporary PDF file
            $tempPdfPath = config('browsershot.temp_directory', storage_path('app/temp')) . '/' . uniqid() . '.pdf';
            
            // Ensure temp directory exists
            if (!file_exists(dirname($tempPdfPath))) {
                mkdir(dirname($tempPdfPath), 0755, true);
            }

            // Configure Browsershot with HTML content directly
            $browsershot = Browsershot::html($html)
                ->format($options['format'])
                ->landscape($options['landscape'])
                ->margins(
                    $options['margins']['top'],
                    $options['margins']['right'],
                    $options['margins']['bottom'],
                    $options['margins']['left']
                )
                ->preferCssPageSize($options['preferCssPageSize'])
                ->printBackground($options['printBackground'])
                ->timeout($options['timeout']);

            // Set Chrome path if configured
            if (config('browsershot.chrome_path')) {
                $browsershot->setChromePath(config('browsershot.chrome_path'));
            }

            // Set Node path if configured
            if (config('browsershot.node_path')) {
                $browsershot->setNodeBinary(config('browsershot.node_path'));
            }

            // Set NPM path if configured
            if (config('browsershot.npm_path')) {
                $browsershot->setNpmBinary(config('browsershot.npm_path'));
            }

            // Save PDF to temporary file
            $browsershot->savePdf($tempPdfPath);

            // Read PDF content
            $pdfContent = file_get_contents($tempPdfPath);

            // Clean up temporary file
            unlink($tempPdfPath);

            // Return PDF as download response
            return response($pdfContent)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'attachment; filename="' . $filename . '.pdf"')
                ->header('Content-Length', strlen($pdfContent));
            
        } catch (\Exception $e) {
            // Clean up temporary file if it exists
            if (isset($tempPdfPath) && file_exists($tempPdfPath)) {
                unlink($tempPdfPath);
            }
            
            throw new \Exception('PDF Generation Error: ' . $e->getMessage());
        }
    }

    /**
     * Generate invoice PDF
     *
     * @param \App\Models\Invoice $invoice
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function generateInvoicePdf($invoice)
    {
        // Load all the relationships
        $invoice->load(['items', 'billTo', 'shipTo', 'paymentInstructions']);

        // Prepare data for the PDF view
        $data = [
            'invoice' => $invoice,
            'items' => $invoice->items ?? [],
            'billTo' => $invoice->billTo,
            'shipTo' => $invoice->shipTo,
            'paymentInstructions' => $invoice->paymentInstructions,
        ];

        // Render the view
        $html = view('admin.invoices.pdf', $data)->render();
        
        $filename = "Invoice_{$invoice->invoice_no}";
        
        return $this->generatePdf($html, $filename);
    }

    /**
     * Generate salary slip PDF
     *
     * @param \App\Models\SalarySlip $salary
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function generateSalaryPdf($salary)
    {
        $salary->load(['payments', 'deductions']);
        
        // Render the view
        $html = view('admin.salaries.pdf', compact('salary'))->render();
        
        $filename = "salary-slip-{$salary->employee_id_number}-{$salary->period_from->format('Y-m')}";
        
        return $this->generatePdf($html, $filename);
    }

    /**
     * Generate credit note PDF
     *
     * @param \App\Models\CreditNote $creditNote
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function generateCreditNotePdf($creditNote)
    {
        // Render the view
        $html = view('admin.credit-notes.pdf', compact('creditNote'))->render();
        
        $filename = "credit-note-{$creditNote->id}-{$creditNote->customer_name}";
        
        return $this->generatePdf($html, $filename);
    }
} 