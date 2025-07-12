<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\InvoiceParty;
use App\Models\PaymentInstruction;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = Invoice::with(['billTo', 'shipTo'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.invoices.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.invoices.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInvoiceRequest $request)
    {
        try {
            DB::beginTransaction();

            // Create invoice
            $invoice = Invoice::create([
                'invoice_no' => $request->invoice_no,
                'invoice_date' => $request->invoice_date,
                'ship_via' => $request->ship_via,
                'tracking_no' => $request->tracking_no,
                'tax_id' => $request->tax_id,
                'subtotal' => $request->subtotal,
                'shipping' => $request->shipping,
                'total' => $request->total,
                'paid' => $request->paid,
                'balance_due' => $request->balance_due,
                'notes' => $request->notes,
            ]);

            // Create bill to party
            InvoiceParty::create([
                'invoice_id' => $invoice->id,
                'type' => 'bill_to',
                'company_name' => $request->bill_company_name,
                'address' => $request->bill_address,
                'vat_no' => $request->bill_vat_no,
                'eori' => $request->bill_eori,
                'phone' => $request->bill_phone,
                'email' => $request->bill_email,
            ]);

            // Create ship to party
            InvoiceParty::create([
                'invoice_id' => $invoice->id,
                'type' => 'ship_to',
                'company_name' => $request->ship_company_name,
                'address' => $request->ship_address,
                'vat_no' => $request->ship_vat_no,
                'eori' => $request->ship_eori,
                'phone' => '',
                'email' => $request->ship_email,
            ]);

            // Create invoice items
            foreach ($request->description as $index => $description) {
                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'description' => $description,
                    'quantity' => $request->quantity[$index],
                    'rate' => $request->rate[$index],
                    'amount' => $request->amount[$index],
                ]);
            }

            // Create payment instructions
            PaymentInstruction::create([
                'invoice_id' => $invoice->id,
                'bank_name' => $request->bank_name,
                'bank_code' => $request->bank_code,
                'swift_bic' => $request->swift_bic,
                'multi_currency_ac_no' => $request->multi_currency_ac_no,
            ]);

            DB::commit();

            return redirect()->route('admin.invoices.index')
                ->with('success', 'Invoice created successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error creating invoice: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        try {
            // Load all the relationships
            $invoice->load(['items', 'billTo', 'shipTo', 'paymentInstructions']);

            // Check if the invoice exists
            if (!$invoice) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invoice not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'invoice' => $invoice,
                'items' => $invoice->items ?? [],
                'billTo' => $invoice->billTo,
                'shipTo' => $invoice->shipTo,
                'paymentInstructions' => $invoice->paymentInstructions,
            ]);

        } catch (\Exception $e) {
            \Log::error('Error loading invoice details: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error loading invoice details: ' . $e->getMessage()
            ], 500);
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        $invoice->load(['items', 'billTo', 'shipTo', 'paymentInstructions']);

        return view('admin.invoices.edit', compact('invoice'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInvoiceRequest $request, Invoice $invoice)
    {
        try {
            DB::beginTransaction();

            // Update invoice
            $invoice->update([
                'invoice_no' => $request->invoice_no,
                'invoice_date' => $request->invoice_date,
                'ship_via' => $request->ship_via,
                'tracking_no' => $request->tracking_no,
                'tax_id' => $request->tax_id,
                'subtotal' => $request->subtotal,
                'shipping' => $request->shipping,
                'total' => $request->total,
                'paid' => $request->paid,
                'balance_due' => $request->balance_due,
                'notes' => $request->notes,
            ]);

            // Update bill to party
            $invoice->billTo->update([
                'company_name' => $request->bill_company_name,
                'address' => $request->bill_address,
                'vat_no' => $request->bill_vat_no,
                'eori' => $request->bill_eori,
                'phone' => $request->bill_phone,
                'email' => $request->bill_email,
            ]);

            // Update ship to party
            $invoice->shipTo->update([
                'company_name' => $request->ship_company_name,
                'address' => $request->ship_address,
                'vat_no' => $request->ship_vat_no,
                'eori' => $request->ship_eori,
                'email' => $request->ship_email,
            ]);

            // Delete existing items and create new ones
            $invoice->items()->delete();
            foreach ($request->description as $index => $description) {
                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'description' => $description,
                    'quantity' => $request->quantity[$index],
                    'rate' => $request->rate[$index],
                    'amount' => $request->amount[$index],
                ]);
            }

            // Update payment instructions
            $invoice->paymentInstructions->update([
                'bank_name' => $request->bank_name,
                'bank_code' => $request->bank_code,
                'swift_bic' => $request->swift_bic,
                'multi_currency_ac_no' => $request->multi_currency_ac_no,
            ]);

            DB::commit();

            return redirect()->route('admin.invoices.index')
                ->with('success', 'Invoice updated successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error updating invoice: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        try {
            $invoice->delete(); // Cascade delete will handle related records

            return response()->json([
                'success' => true,
                'message' => 'Invoice deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting invoice: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Download invoice as PDF.
     */
    public function download(Invoice $invoice)
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

            // Generate PDF
            $pdf = Pdf::loadView('admin.invoices.pdf', $data);
            
            // Set paper size and orientation
            $pdf->setPaper('a4', 'portrait');
            
            // Download the PDF with a descriptive filename
            return $pdf->download("Invoice_{$invoice->invoice_no}.pdf");

        } catch (\Exception $e) {
            \Log::error('Error generating PDF: ' . $e->getMessage());
            
            return back()->with('error', 'Error generating PDF: ' . $e->getMessage());
        }
    }
}