<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Transaction;

class ReportController extends Controller
{

    public function showrecord(){
        //get all reports
        $records=Report::all();
        return $records;

    }

    public function generateReport(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'user_id' => 'required|exists:users,id', // Assuming a relationship with users
        ]);

        // Get the start and end dates from the request
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $id = $request->input('user_id');

        // Generate the monthly report
        $report = $this->generateMonthlyReport($startDate, $endDate, $id);

        // Store the report in the database
        Report::insert($report);

        return response()->json(['message' => 'Monthly report generated and stored successfully.',$report]);
    }

    private function generateMonthlyReport($startDate, $endDate, $id)
    {
        $report = [];

        // Loop through each month in the date range
        $currentDate = \Carbon\Carbon::parse($startDate);
        $endDate = \Carbon\Carbon::parse($endDate);

        while ($currentDate <= $endDate) {
            // Calculate the start and end of the current month
            $startOfMonth = $currentDate->startOfMonth();
            $endOfMonth = $currentDate->endOfMonth();

            // Query transactions for the current month
            $transactions = Transaction::where('user_id', $id)
                ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->get();

            // Calculate paid, outstanding, and overdue amounts for the current month
            $paidAmount = $transactions->where('status', 'paid')->sum('amount');
            $outstandingAmount = $transactions->where('status', 'outstanding')->sum('amount');
            $overdueAmount = $transactions->where('status', 'overdue')->sum('amount');

            // Add the report entry for the current month
            $report[] = [
                'user_id' => $id,
                'month' => $currentDate->month,
                'year' => $currentDate->year,
                'paid' => $paidAmount,
                'outstanding' => $outstandingAmount,
                'overdue' => $overdueAmount,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // Move to the next month
            $currentDate->addMonth();
        }

        return $report;
    }
}
