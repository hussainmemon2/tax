<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\FinanceExpense;
use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }
    public function chartData(Request $request)
    {
        $range = $request->range ?? '6M';

        if($range == '6M'){
            $months = 6;
        }elseif($range == '1Y'){
            $months = 12;
        }else{
            $months = 24;
        }

        $startDate = Carbon::now()->subMonths($months);

        // Revenue
        $revenue = Payment::select(
                DB::raw('MONTH(payment_date) as month'),
                DB::raw('SUM(amount) as total')
            )
            ->where('payment_date','>=',$startDate)
            ->groupBy('month')
            ->pluck('total','month');

        // Expenses
        $expenses = FinanceExpense::select(
                DB::raw('MONTH(expense_date) as month'),
                DB::raw('SUM(amount) as total')
            )
            ->where('expense_date','>=',$startDate)
            ->groupBy('month')
            ->pluck('total','month');

        // Invoices (for outstanding)
        $invoices = Invoice::select(
                DB::raw('MONTH(issued_date) as month'),
                DB::raw('SUM(total_amount) as total')
            )
            ->where('issued_date','>=',$startDate)
            ->groupBy('month')
            ->pluck('total','month');

        $labels = [];
        $revenueData = [];
        $expenseData = [];
        $outstandingData = [];

        for($i=$months-1;$i>=0;$i--){

            $date = Carbon::now()->subMonths($i);
            $monthNumber = $date->month;

            $labels[] = $date->format('M');

            $rev = $revenue[$monthNumber] ?? 0;
            $exp = $expenses[$monthNumber] ?? 0;
            $inv = $invoices[$monthNumber] ?? 0;

            $revenueData[] = $rev;
            $expenseData[] = $exp;

            // outstanding = invoice - payments
            $outstandingData[] = $inv - $rev;
        }

        return response()->json([
            'labels'=>$labels,
            'revenue'=>$revenueData,
            'expenses'=>$expenseData,
            'outstanding'=>$outstandingData
        ]);
    }
}
