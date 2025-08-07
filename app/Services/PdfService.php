<?php

namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Log;

class PdfService
{
    /**
     * Default DomPDF options optimized for better rendering
     */
    private array $defaultOptions = [
        'paper' => 'a4',
        'orientation' => 'portrait',
        'dpi' => 150,
        'defaultFont' => 'sans-serif',
        'isRemoteEnabled' => true,
        'isHtml5ParserEnabled' => true,
        'isFontSubsettingEnabled' => true,
        'defaultPaperSize' => 'a4',
        'tempDir' => null,
        'chroot' => null,
        'logOutputFile' => null,
        'defaultMediaType' => 'screen',
        'isCssFloatEnabled' => true,
        'isJavascriptEnabled' => false,
    ];

    /**
     * Generate PDF from HTML content with enhanced options
     *
     * @param string $html
     * @param string $filename
     * @param array $options
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function generatePdf($html, $filename, $options = [])
    {
        try {
            // Merge with default options
            $options = array_merge($this->defaultOptions, $options);

            // Clean and optimize HTML for DomPDF
            $html = $this->optimizeHtmlForDomPdf($html);

            // Create PDF instance
            $pdf = Pdf::loadHTML($html);
            
            // Set paper size and orientation
            $pdf->setPaper($options['paper'], $options['orientation']);

            // Set additional options
            $pdf->setOptions([
                'dpi' => $options['dpi'],
                'defaultFont' => $options['defaultFont'],
                'isRemoteEnabled' => $options['isRemoteEnabled'],
                'isHtml5ParserEnabled' => $options['isHtml5ParserEnabled'],
                'isFontSubsettingEnabled' => $options['isFontSubsettingEnabled'],
                'isCssFloatEnabled' => $options['isCssFloatEnabled'],
                'isJavascriptEnabled' => $options['isJavascriptEnabled'],
            ]);

            // Return PDF as download response
            return $pdf->download($filename . '.pdf');

        } catch (\Exception $e) {
            Log::error('PDF Generation Error: ' . $e->getMessage(), [
                'filename' => $filename,
                'trace' => $e->getTraceAsString()
            ]);
            throw new \Exception('PDF Generation Error: ' . $e->getMessage());
        }
    }

    /**
     * Generate invoice PDF with enhanced styling
     *
     * @param \App\Models\Invoice $invoice
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function generateInvoicePdf($invoice)
    {
        try {
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

            // Render the view with enhanced template
            $html = View::make('admin.invoices.pdf', $data)->render();
            
            $filename = "Invoice_{$invoice->invoice_no}";
            
            return $this->generatePdf($html, $filename, [
                'paper' => 'a4',
                'orientation' => 'portrait'
            ]);

        } catch (\Exception $e) {
            Log::error('Invoice PDF Generation Error: ' . $e->getMessage(), [
                'invoice_id' => $invoice->id ?? null,
                'invoice_no' => $invoice->invoice_no ?? null
            ]);
            throw new \Exception('Invoice PDF Generation Error: ' . $e->getMessage());
        }
    }

    /**
     * Generate salary slip PDF with enhanced styling
     *
     * @param \App\Models\SalarySlip $salary
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function generateSalaryPdf($salary)
    {
        try {
            $salary->load(['payments', 'deductions']);
            
            // Render the view with enhanced template
            $html = View::make('admin.salaries.pdf', compact('salary'))->render();
            
            $filename = "salary-slip-{$salary->employee_id_number}-{$salary->period_from->format('Y-m')}";
            
            return $this->generatePdf($html, $filename, [
                'paper' => 'a4',
                'orientation' => 'portrait'
            ]);

        } catch (\Exception $e) {
            Log::error('Salary PDF Generation Error: ' . $e->getMessage(), [
                'salary_id' => $salary->id ?? null,
                'employee_id' => $salary->employee_id_number ?? null
            ]);
            throw new \Exception('Salary PDF Generation Error: ' . $e->getMessage());
        }
    }

    /**
     * Generate credit note PDF with enhanced styling
     *
     * @param \App\Models\CreditNote $creditNote
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function generateCreditNotePdf($creditNote)
    {
        try {
            // Render the view with enhanced template
            $html = View::make('admin.credit-notes.pdf', compact('creditNote'))->render();
            
            $filename = "credit-note-{$creditNote->id}-{$creditNote->customer_name}";
            
            return $this->generatePdf($html, $filename, [
                'paper' => 'a4',
                'orientation' => 'portrait'
            ]);

        } catch (\Exception $e) {
            Log::error('Credit Note PDF Generation Error: ' . $e->getMessage(), [
                'credit_note_id' => $creditNote->id ?? null,
                'customer_name' => $creditNote->customer_name ?? null
            ]);
            throw new \Exception('Credit Note PDF Generation Error: ' . $e->getMessage());
        }
    }

    /**
     * Save PDF to storage
     *
     * @param string $html
     * @param string $filename
     * @param array $options
     * @return string
     */
    public function savePdf($html, $filename, $options = [])
    {
        try {
            // Merge with default options
            $options = array_merge($this->defaultOptions, $options);

            // Clean and optimize HTML for DomPDF
            $html = $this->optimizeHtmlForDomPdf($html);

            // Generate PDF using DomPDF
            $pdf = Pdf::loadHTML($html);
            
            // Set paper size and orientation
            $pdf->setPaper($options['paper'], $options['orientation']);

            // Set additional options
            $pdf->setOptions([
                'dpi' => $options['dpi'],
                'defaultFont' => $options['defaultFont'],
                'isRemoteEnabled' => $options['isRemoteEnabled'],
                'isHtml5ParserEnabled' => $options['isHtml5ParserEnabled'],
                'isFontSubsettingEnabled' => $options['isFontSubsettingEnabled'],
                'isCssFloatEnabled' => $options['isCssFloatEnabled'],
                'isJavascriptEnabled' => $options['isJavascriptEnabled'],
            ]);

            // Save to storage
            $filePath = 'pdfs/' . $filename . '.pdf';
            Storage::put($filePath, $pdf->output());

            return $filePath;

        } catch (\Exception $e) {
            Log::error('PDF Save Error: ' . $e->getMessage(), [
                'filename' => $filename,
                'trace' => $e->getTraceAsString()
            ]);
            throw new \Exception('PDF Save Error: ' . $e->getMessage());
        }
    }

    /**
     * Generate PDF and return as base64 string
     *
     * @param string $html
     * @param array $options
     * @return string
     */
    public function generatePdfAsBase64($html, $options = [])
    {
        try {
            // Merge with default options
            $options = array_merge($this->defaultOptions, $options);

            // Clean and optimize HTML for DomPDF
            $html = $this->optimizeHtmlForDomPdf($html);

            // Generate PDF using DomPDF
            $pdf = Pdf::loadHTML($html);
            
            // Set paper size and orientation
            $pdf->setPaper($options['paper'], $options['orientation']);

            // Set additional options
            $pdf->setOptions([
                'dpi' => $options['dpi'],
                'defaultFont' => $options['defaultFont'],
                'isRemoteEnabled' => $options['isRemoteEnabled'],
                'isHtml5ParserEnabled' => $options['isHtml5ParserEnabled'],
                'isFontSubsettingEnabled' => $options['isFontSubsettingEnabled'],
                'isCssFloatEnabled' => $options['isCssFloatEnabled'],
                'isJavascriptEnabled' => $options['isJavascriptEnabled'],
            ]);

            return base64_encode($pdf->output());

        } catch (\Exception $e) {
            Log::error('PDF Base64 Generation Error: ' . $e->getMessage());
            throw new \Exception('PDF Base64 Generation Error: ' . $e->getMessage());
        }
    }

    /**
     * Stream PDF directly to browser
     *
     * @param string $html
     * @param string $filename
     * @param array $options
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function streamPdf($html, $filename, $options = [])
    {
        try {
            // Merge with default options
            $options = array_merge($this->defaultOptions, $options);

            // Clean and optimize HTML for DomPDF
            $html = $this->optimizeHtmlForDomPdf($html);

            // Generate PDF using DomPDF
            $pdf = Pdf::loadHTML($html);
            
            // Set paper size and orientation
            $pdf->setPaper($options['paper'], $options['orientation']);

            // Set additional options
            $pdf->setOptions([
                'dpi' => $options['dpi'],
                'defaultFont' => $options['defaultFont'],
                'isRemoteEnabled' => $options['isRemoteEnabled'],
                'isHtml5ParserEnabled' => $options['isHtml5ParserEnabled'],
                'isFontSubsettingEnabled' => $options['isFontSubsettingEnabled'],
                'isCssFloatEnabled' => $options['isCssFloatEnabled'],
                'isJavascriptEnabled' => $options['isJavascriptEnabled'],
            ]);

            // Return PDF as stream response
            return $pdf->stream($filename . '.pdf');

        } catch (\Exception $e) {
            Log::error('PDF Stream Error: ' . $e->getMessage(), [
                'filename' => $filename
            ]);
            throw new \Exception('PDF Stream Error: ' . $e->getMessage());
        }
    }

    /**
     * Optimize HTML content for better DomPDF rendering
     *
     * @param string $html
     * @return string
     */
    private function optimizeHtmlForDomPdf($html)
    {
        // Remove external font imports that might cause issues
        $html = preg_replace('/@import\s+url\([^)]+\);?/', '', $html);
        
        // Replace Google Fonts with fallback fonts
        $html = str_replace(
            "font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;",
            "font-family: DejaVu Sans, sans-serif;",
            $html
        );

        // Ensure all images have proper dimensions
        $html = preg_replace_callback(
            '/<img([^>]*)>/',
            function ($matches) {
                $img = $matches[0];
                if (!preg_match('/width\s*[:=]/', $img) && !preg_match('/height\s*[:=]/', $img)) {
                    $img = str_replace('<img', '<img style="max-width: 100%; height: auto;"', $img);
                }
                return $img;
            },
            $html
        );

        // Add meta tags for better PDF rendering
        if (!preg_match('/<meta[^>]+charset[^>]*>/i', $html)) {
            $html = str_replace('<head>', '<head><meta charset="UTF-8">', $html);
        }

        // Add viewport meta tag
        if (!preg_match('/<meta[^>]+viewport[^>]*>/i', $html)) {
            $html = str_replace(
                '<meta charset="UTF-8">',
                '<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">',
                $html
            );
        }

        return $html;
    }

    /**
     * Get DomPDF supported fonts
     *
     * @return array
     */
    public function getSupportedFonts()
    {
        return [
            'serif' => 'Times-Roman',
            'sans-serif' => 'Helvetica',
            'monospace' => 'Courier',
            'dejavu-sans' => 'DejaVu Sans',
            'dejavu-serif' => 'DejaVu Serif',
            'dejavu-mono' => 'DejaVu Sans Mono',
        ];
    }

    /**
     * Validate PDF generation requirements
     *
     * @param string $html
     * @return bool
     * @throws \Exception
     */
    public function validatePdfRequirements($html)
    {
        // Check if HTML is not empty
        if (empty(trim($html))) {
            throw new \Exception('HTML content cannot be empty');
        }

        // Check for valid HTML structure
        if (!preg_match('/<html[^>]*>.*<\/html>/is', $html)) {
            throw new \Exception('Invalid HTML structure - missing html tags');
        }

        // Check for head and body tags
        if (!preg_match('/<head[^>]*>.*<\/head>/is', $html)) {
            throw new \Exception('Invalid HTML structure - missing head tags');
        }

        if (!preg_match('/<body[^>]*>.*<\/body>/is', $html)) {
            throw new \Exception('Invalid HTML structure - missing body tags');
        }

        return true;
    }

    /**
     * Get PDF generation statistics
     *
     * @return array
     */
    public function getGenerationStats()
    {
        return [
            'default_options' => $this->defaultOptions,
            'supported_fonts' => $this->getSupportedFonts(),
            'max_execution_time' => ini_get('max_execution_time'),
            'memory_limit' => ini_get('memory_limit'),
            'dompdf_version' => class_exists('\Dompdf\Dompdf') ? \Dompdf\Dompdf::VERSION : 'Unknown',
        ];
    }
}