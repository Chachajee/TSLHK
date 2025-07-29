<?php

namespace App\Http\Controllers;

use App\Models\SalarySlip;
use App\Models\SalaryPayment;
use App\Models\SalaryDeduction;
use App\Http\Requests\StoreSalarySlipRequest;
use App\Http\Requests\UpdateSalarySlipRequest;
use App\Services\PdfService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $salarySlips = SalarySlip::with(['payments', 'deductions'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.salaries.index', compact('salarySlips'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.salaries.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSalarySlipRequest $request)
    {
        try {
            DB::beginTransaction();

            // Create salary slip
            $salarySlip = SalarySlip::create([
                'employee_name' => $request->employee_name,
                'employee_id_number' => $request->employee_id_number,
                'designation' => $request->designation,
                'period_from' => $request->period_from,
                'period_to' => $request->period_to,
                'generated_date' => $request->generated_date,
            ]);

            // Create salary payments
            foreach ($request->payment_method as $index => $method) {
                SalaryPayment::create([
                    'salary_slip_id' => $salarySlip->id,
                    'payment_method' => $method,
                    'amount' => $request->payment_amount[$index],
                    'received_date' => $request->payment_received_date[$index],
                ]);
            }

            // Create salary deductions (if any)
            if ($request->has('deduction_type') && is_array($request->deduction_type)) {
                foreach ($request->deduction_type as $index => $type) {
                    SalaryDeduction::create([
                        'salary_slip_id' => $salarySlip->id,
                        'deduction_type' => $type,
                        'description' => $request->deduction_description[$index],
                        'amount' => $request->deduction_amount[$index],
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('admin.salaries.index')
                ->with('success', 'Salary slip created successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error creating salary slip: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(SalarySlip $salary)
    {
        try {
            // Load all the relationships
            $salary->load(['payments', 'deductions']);

            // Check if the salary slip exists
            if (!$salary) {
                return response()->json([
                    'success' => false,
                    'message' => 'Salary slip not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'salary' => $salary,
                'payments' => $salary->payments ?? [],
                'deductions' => $salary->deductions ?? [],
                'total_paid' => $salary->total_paid,
                'total_deductions' => $salary->total_deductions,
                'net_salary' => $salary->net_salary,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error loading salary slip details: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SalarySlip $salary)
    {
        $salary->load(['payments', 'deductions']);

        return view('admin.salaries.edit', compact('salary'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSalarySlipRequest $request, SalarySlip $salary)
    {
        try {
            DB::beginTransaction();

            // Update salary slip
            $salary->update([
                'employee_name' => $request->employee_name,
                'employee_id_number' => $request->employee_id_number,
                'designation' => $request->designation,
                'period_from' => $request->period_from,
                'period_to' => $request->period_to,
                'generated_date' => $request->generated_date,
            ]);

            // Delete existing payments and create new ones
            $salary->payments()->delete();
            foreach ($request->payment_method as $index => $method) {
                SalaryPayment::create([
                    'salary_slip_id' => $salary->id,
                    'payment_method' => $method,
                    'amount' => $request->payment_amount[$index],
                    'received_date' => $request->payment_received_date[$index],
                ]);
            }

            // Delete existing deductions and create new ones
            $salary->deductions()->delete();
            if ($request->has('deduction_type') && is_array($request->deduction_type)) {
                foreach ($request->deduction_type as $index => $type) {
                    SalaryDeduction::create([
                        'salary_slip_id' => $salary->id,
                        'deduction_type' => $type,
                        'description' => $request->deduction_description[$index],
                        'amount' => $request->deduction_amount[$index],
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('admin.salaries.index')
                ->with('success', 'Salary slip updated successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error updating salary slip: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SalarySlip $salary)
    {
        try {
            $salary->delete(); // Cascade delete will handle related records

            return response()->json([
                'success' => true,
                'message' => 'Salary slip deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting salary slip: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Download salary slip as PDF.
     */
    public function download(SalarySlip $salary, PdfService $pdfService)
    {
        try {
            return $pdfService->generateSalaryPdf($salary);
        } catch (\Exception $e) {
            return back()->with('error', 'Error generating PDF: ' . $e->getMessage());
        }
    }
}
