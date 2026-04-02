@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    {{-- Header --}}
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Finance Dashboard</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-2">Track club income and expenses</p>
        </div>
        @if (Auth::user()->isExecutive() || Auth::user()->isAdmin())
            <a href="{{ route('finance.transactions.create') }}" class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition font-semibold">
                + Record Transaction
            </a>
        @endif
    </div>

    {{-- Financial Overview Cards --}}
    @php
        $totalIncome = \App\Models\Transaction::income()->sum('amount');
        $totalExpenses = \App\Models\Transaction::expense()->sum('amount');
        $balance = $totalIncome - $totalExpenses;
        $thisMonthIncome = \App\Models\Transaction::income()->whereMonth('date', now()->month)->sum('amount');
        $thisMonthExpenses = \App\Models\Transaction::expense()->whereMonth('date', now()->month)->sum('amount');
    @endphp

    <div class="grid md:grid-cols-4 gap-6 mb-8">
        {{-- Total Income Card --}}
        <div class="bg-gradient-to-br from-green-50 to-emerald-50 dark:from-green-900 dark:to-emerald-900 rounded-lg shadow p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 dark:text-gray-400 text-sm font-semibold">Total Income</p>
                    <p class="text-3xl font-bold text-green-600 dark:text-green-400 mt-2">
                        KES {{ number_format($totalIncome, 2) }}
                    </p>
                </div>
                <span class="text-5xl">📈</span>
            </div>
        </div>

        {{-- Total Expenses Card --}}
        <div class="bg-gradient-to-br from-red-50 to-rose-50 dark:from-red-900 dark:to-rose-900 rounded-lg shadow p-6 border-l-4 border-red-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 dark:text-gray-400 text-sm font-semibold">Total Expenses</p>
                    <p class="text-3xl font-bold text-red-600 dark:text-red-400 mt-2">
                        KES {{ number_format($totalExpenses, 2) }}
                    </p>
                </div>
                <span class="text-5xl">📉</span>
            </div>
        </div>

        {{-- Balance Card --}}
        <div class="bg-gradient-to-br from-indigo-50 to-blue-50 dark:from-indigo-900 dark:to-blue-900 rounded-lg shadow p-6 border-l-4 border-indigo-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 dark:text-gray-400 text-sm font-semibold">Balance</p>
                    <p class="text-3xl font-bold text-indigo-600 dark:text-indigo-400 mt-2">
                        KES {{ number_format($balance, 2) }}
                    </p>
                </div>
                <span class="text-5xl">💰</span>
            </div>
        </div>

        {{-- This Month Card --}}
        <div class="bg-gradient-to-br from-purple-50 to-pink-50 dark:from-purple-900 dark:to-pink-900 rounded-lg shadow p-6 border-l-4 border-purple-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 dark:text-gray-400 text-sm font-semibold">This Month</p>
                    <p class="text-3xl font-bold text-purple-600 dark:text-purple-400 mt-2">
                        KES {{ number_format($thisMonthIncome - $thisMonthExpenses, 2) }}
                    </p>
                </div>
                <span class="text-5xl">📅</span>
            </div>
        </div>
    </div>

    {{-- Recent Transactions --}}
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Recent Transactions</h2>
            <a href="{{ route('finance.transactions') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">
                View All →
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-200 dark:border-gray-700">
                        <th class="text-left py-3 font-semibold text-gray-900 dark:text-white">Date</th>
                        <th class="text-left py-3 font-semibold text-gray-900 dark:text-white">Description</th>
                        <th class="text-left py-3 font-semibold text-gray-900 dark:text-white">Category</th>
                        <th class="text-left py-3 font-semibold text-gray-900 dark:text-white">Type</th>
                        <th class="text-right py-3 font-semibold text-gray-900 dark:text-white">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse (\App\Models\Transaction::latest()->take(10)->get() as $transaction)
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <td class="py-3 text-gray-700 dark:text-gray-300">
                                {{ $transaction->date->format('M d, Y') }}
                            </td>
                            <td class="py-3 text-gray-700 dark:text-gray-300">
                                {{ $transaction->description }}
                            </td>
                            <td class="py-3">
                                <span class="text-xs font-semibold text-gray-600 dark:text-gray-400 bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded">
                                    {{ ucfirst($transaction->category) }}
                                </span>
                            </td>
                            <td class="py-3">
                                @if ($transaction->type === 'income')
                                    <span class="text-xs font-semibold text-green-600 dark:text-green-400 bg-green-50 dark:bg-green-900 px-2 py-1 rounded">
                                        Income
                                    </span>
                                @else
                                    <span class="text-xs font-semibold text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-900 px-2 py-1 rounded">
                                        Expense
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 text-right font-semibold {{ $transaction->type === 'income' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                {{ $transaction->type === 'income' ? '+' : '-' }}KES {{ number_format($transaction->amount, 2) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-gray-500 dark:text-gray-400">
                                No transactions recorded yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Quick Stats Grid --}}
    <div class="mt-8 grid md:grid-cols-3 gap-6">
        {{-- Income Breakdown --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="font-bold text-gray-900 dark:text-white mb-4">Top Income Categories</h3>
            @php
                $incomeByCategory = \App\Models\Transaction::income()
                    ->groupBy('category')
                    ->selectRaw('category, sum(amount) as total')
                    ->orderByDesc('total')
                    ->limit(3)
                    ->get();
            @endphp
            @forelse ($incomeByCategory as $item)
                <div class="mb-4 last:mb-0">
                    <div class="flex justify-between mb-1">
                        <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ ucfirst($item->category) }}</span>
                        <span class="text-sm text-green-600 dark:text-green-400">KES {{ number_format($item->total, 2) }}</span>
                    </div>
                </div>
            @empty
                <p class="text-sm text-gray-500 dark:text-gray-400">No income recorded</p>
            @endforelse
        </div>

        {{-- Expense Breakdown --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="font-bold text-gray-900 dark:text-white mb-4">Top Expense Categories</h3>
            @php
                $expenseByCategory = \App\Models\Transaction::expense()
                    ->groupBy('category')
                    ->selectRaw('category, sum(amount) as total')
                    ->orderByDesc('total')
                    ->limit(3)
                    ->get();
            @endphp
            @forelse ($expenseByCategory as $item)
                <div class="mb-4 last:mb-0">
                    <div class="flex justify-between mb-1">
                        <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ ucfirst($item->category) }}</span>
                        <span class="text-sm text-red-600 dark:text-red-400">KES {{ number_format($item->total, 2) }}</span>
                    </div>
                </div>
            @empty
                <p class="text-sm text-gray-500 dark:text-gray-400">No expenses recorded</p>
            @endforelse
        </div>

        {{-- Quick Actions --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="font-bold text-gray-900 dark:text-white mb-4">Actions</h3>
            <div class="space-y-2">
                @if (Auth::user()->isExecutive() || Auth::user()->isAdmin())
                    <a href="{{ route('finance.transactions.create') }}" class="block p-3 bg-indigo-50 dark:bg-indigo-900 text-indigo-600 dark:text-indigo-400 rounded text-center text-sm font-semibold hover:bg-indigo-100 dark:hover:bg-indigo-800 transition">
                        Record Transaction
                    </a>
                    <a href="{{ route('reports.financial') }}" class="block p-3 bg-blue-50 dark:bg-blue-900 text-blue-600 dark:text-blue-400 rounded text-center text-sm font-semibold hover:bg-blue-100 dark:hover:bg-blue-800 transition">
                        View Reports
                    </a>
                    <a href="{{ route('reports.export.transactions') }}" class="block p-3 bg-green-50 dark:bg-green-900 text-green-600 dark:text-green-400 rounded text-center text-sm font-semibold hover:bg-green-100 dark:hover:bg-green-800 transition">
                        Export CSV
                    </a>
                @else
                    <a href="{{ route('finance.transactions') }}" class="block p-3 bg-indigo-50 dark:bg-indigo-900 text-indigo-600 dark:text-indigo-400 rounded text-center text-sm font-semibold hover:bg-indigo-100 dark:hover:bg-indigo-800 transition">
                        View Transactions
                    </a>
                    <a href="{{ route('reports.financial') }}" class="block p-3 bg-blue-50 dark:bg-blue-900 text-blue-600 dark:text-blue-400 rounded text-center text-sm font-semibold hover:bg-blue-100 dark:hover:bg-blue-800 transition">
                        View Reports
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
