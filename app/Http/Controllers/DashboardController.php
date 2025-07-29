<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\SalarySlip;
use App\Models\CreditNote;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Fetch counts from the database
        $invoiceCount = Invoice::count();
        $salaryCount = SalarySlip::count();
        $creditNoteCount = CreditNote::count();
        
        return view('dashboard', compact('invoiceCount', 'salaryCount', 'creditNoteCount'));
    }
    public function home()
    {
        return view('frontend.home');
    }
} 