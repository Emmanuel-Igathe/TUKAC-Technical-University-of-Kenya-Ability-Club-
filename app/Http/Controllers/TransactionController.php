<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Display transactions
     */
    public function index(Request $request)
    {
        $query = Transaction::query();

        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        $transactions = $query->latest()->paginate(20);
        return view('finance.transactions', ['transactions' => $transactions]);
    }

    /**
     * Show create form
     */
    public function create()
    {
        $this->authorize('isExecutive');
        return view('finance.create');
    }

    /**
     * Store transaction
     */
    public function store(Request $request)
    {
        $this->authorize('isExecutive');

        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'type' => 'required|in:income,expense',
            'category' => 'required|string',
            'date' => 'required|date',
            'receipt' => 'nullable|file|mimes:pdf,jpg,png|max:5000',
        ]);

        $transaction = Transaction::create([
            'description' => $validated['description'],
            'amount' => $validated['amount'],
            'type' => $validated['type'],
            'category' => $validated['category'],
            'date' => $validated['date'],
            'created_by' => Auth::id(),
        ]);

        if ($request->hasFile('receipt')) {
            $path = $request->file('receipt')->store('receipts', 'private');
            $transaction->update(['receipt_path' => $path]);
        }

        return redirect('/finance')->with('status', 'Transaction recorded!');
    }

    /**
     * Financial dashboard
     */
    public function dashboard()
    {
        $totalIncome = Transaction::income()->sum('amount');
        $totalExpense = Transaction::expense()->sum('amount');
        $balance = $totalIncome - $totalExpense;

        $recentTransactions = Transaction::latest()->limit(10)->get();

        return view('finance.dashboard', [
            'totalIncome' => $totalIncome,
            'totalExpense' => $totalExpense,
            'balance' => $balance,
            'recentTransactions' => $recentTransactions,
        ]);
    }
}
