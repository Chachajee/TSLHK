<?php

namespace App\Http\Controllers;

use App\Models\CreditNote;
use App\Http\Requests\StoreCreditNoteRequest;
use App\Http\Requests\UpdateCreditNoteRequest;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class CreditNoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $creditNotes = CreditNote::orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.credit-notes.index', compact('creditNotes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.credit-notes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCreditNoteRequest $request)
    {
        try {
            // Calculate credit balance
            $creditBalance = $request->amount_paid - $request->amount_spent;

            $creditNote = CreditNote::create([
                'customer_name' => $request->customer_name,
                'amount_paid' => $request->amount_paid,
                'amount_spent' => $request->amount_spent,
                'credit_balance' => $creditBalance,
                'notes' => $request->notes,
            ]);

            return redirect()->route('admin.credit-notes.index')
                ->with('success', 'Credit note created successfully!');

        } catch (\Exception $e) {
            return back()->with('error', 'Error creating credit note: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(CreditNote $creditNote)
    {
        try {
            return response()->json([
                'success' => true,
                'creditNote' => $creditNote,
                'formatted_amount_paid' => $creditNote->formatted_amount_paid,
                'formatted_amount_spent' => $creditNote->formatted_amount_spent,
                'formatted_credit_balance' => $creditNote->formatted_credit_balance,
            ]);

        } catch (\Exception $e) {
            \Log::error('Error loading credit note details: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error loading credit note details: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CreditNote $creditNote)
    {
        return view('admin.credit-notes.edit', compact('creditNote'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCreditNoteRequest $request, CreditNote $creditNote)
    {
        try {
            // Calculate credit balance
            $creditBalance = $request->amount_paid - $request->amount_spent;

            $creditNote->update([
                'customer_name' => $request->customer_name,
                'amount_paid' => $request->amount_paid,
                'amount_spent' => $request->amount_spent,
                'credit_balance' => $creditBalance,
                'notes' => $request->notes,
            ]);

            return redirect()->route('admin.credit-notes.index')
                ->with('success', 'Credit note updated successfully!');

        } catch (\Exception $e) {
            return back()->with('error', 'Error updating credit note: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CreditNote $creditNote)
    {
        try {
            $creditNote->delete();

            return response()->json([
                'success' => true,
                'message' => 'Credit note deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting credit note: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Download credit note as PDF.
     */
    public function download(CreditNote $creditNote)
    {
        try {
            $pdf = PDF::loadView('admin.credit-notes.pdf', compact('creditNote'));
            
            return $pdf->download('credit-note-' . $creditNote->id . '-' . $creditNote->customer_name . '.pdf');
        } catch (\Exception $e) {
            return back()->with('error', 'Error generating PDF: ' . $e->getMessage());
        }
    }
}
