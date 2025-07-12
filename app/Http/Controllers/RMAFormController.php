<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RMAFormController extends Controller
{
    /**
     * Display the RMA form page with policy details and download button.
     */
    public function index()
    {
        return view('rma.index');
    }

    /**
     * Download the RMA form Excel file.
     */
    public function download()
    {
        $filePath = public_path('forms/rma-form.xlsx');
        
        // Check if file exists
        if (!file_exists($filePath)) {
            return back()->with('error', 'RMA form file not found. Please contact administrator.');
        }
        
        return response()->download($filePath, 'rma-form.xlsx');
    }
}
