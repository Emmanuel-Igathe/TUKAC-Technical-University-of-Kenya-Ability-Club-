<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    /**
     * Generate financial report
     */
    public function financialReport()
    {
        $this->authorize('isExecutive');

        $totalIncome = Transaction::income()->sum('amount');
        $totalExpense = Transaction::expense()->sum('amount');
        $balance = $totalIncome - $totalExpense;

        $transactionsByCategory = Transaction::selectRaw('category, type, SUM(amount) as total')
            ->groupBy('category', 'type')
            ->get();

        return view('reports.financial', [
            'totalIncome' => $totalIncome,
            'totalExpense' => $totalExpense,
            'balance' => $balance,
            'transactionsByCategory' => $transactionsByCategory,
        ]);
    }

    /**
     * Export transactions
     */
    public function exportTransactions()
    {
        $this->authorize('isExecutive');

        $transactions = Transaction::all();

        $csv = "Description,Amount,Type,Category,Date\n";
        foreach ($transactions as $t) {
            $csv .= "\"{$t->description}\",{$t->amount},{$t->type},{$t->category},{$t->date}\n";
        }

        return response($csv, 200)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="transactions.csv"');
    }
}
