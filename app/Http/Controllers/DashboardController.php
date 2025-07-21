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
        dd('Dashboard index method called');
        
    }
}