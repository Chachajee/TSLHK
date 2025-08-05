<?php

namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;

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
            // Get default options
            $defaultOptions = [
                'paper' => 'a4',
                'orientation' => 'portrait',
            ];

            $options = array_merge($defaultOptions, $options);

            // Generate PDF using DomPDF
            $pdf = Pdf::loadHTML($html);
            
            // Set paper size and orientation
            $pdf->setPaper($options['paper'], $options['orientation']);

            // Return PDF as download response
            return $pdf->download($filename . '.pdf');

        } catch (\Exception $e) {
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
        $html = View::make('admin.invoices.pdf', $data)->render();
        
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
        $html = View::make('admin.salaries.pdf', compact('salary'))->render();
        
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
        $html = View::make('admin.credit-notes.pdf', compact('creditNote'))->render();
        
        $filename = "credit-note-{$creditNote->id}-{$creditNote->customer_name}";
        
        return $this->generatePdf($html, $filename);
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
            // Get default options
            $defaultOptions = [
                'paper' => 'a4',
                'orientation' => 'portrait',
            ];

            $options = array_merge($defaultOptions, $options);

            // Generate PDF using DomPDF
            $pdf = Pdf::loadHTML($html);
            
            // Set paper size and orientation
            $pdf->setPaper($options['paper'], $options['orientation']);

            // Save to storage
            $filePath = 'pdfs/' . $filename . '.pdf';
            Storage::put($filePath, $pdf->output());

            return $filePath;

        } catch (\Exception $e) {
            throw new \Exception('PDF Save Error: ' . $e->getMessage());
        }
    }
} 