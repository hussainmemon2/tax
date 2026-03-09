<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\FinanceExpense;
use Carbon\Carbon;

class ReportController extends Controller
{

    public function index()
    {
        return view('reports.index');
    }

    public function ajax(Request $request)
    {

        $tab = $request->tab;

        // Validation
        $request->validate([
            'from' => 'nullable|date',
            'to'   => 'nullable|date|after_or_equal:from'
        ]);

        // Default last 30 days
        $from = $request->from ?? Carbon::now()->subDays(30)->toDateString();
        $to   = $request->to   ?? Carbon::now()->toDateString();

        if ($tab == 'profitloss') {

            $income = Payment::whereBetween('payment_date', [$from, $to])
                ->sum('amount');

            $expense = FinanceExpense::whereBetween('expense_date', [$from, $to])
                ->sum('amount');

            $profit = $income - $expense;

            return view('reports.partials.profitloss', compact(
                'income',
                'expense',
                'profit',
                'from',
                'to'
            ));
        }

    }

}