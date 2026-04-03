@extends('layouts.app')

@section('title', 'Financial Reports - TUK Ability Club')
@section('header', 'Financial Reports')

@section('content')
<div class="space-y-6">
    <!-- Report Filters -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">
            <i class="fas fa-filter mr-2 text-blue-600"></i>Report Filters
        </h3>
        
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <!-- Date Range Start -->
            <div>
                <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                <input 
                    type="date" 
                    id="start_date" 
                    name="start_date"
                    value="{{ request('start_date', now()->subMonths(3)->format('Y-m-d')) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                >
            </div>

            <!-- Date Range End -->
            <div>
                <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                <input 
                    type="date" 
                    id="end_date" 
                    name="end_date"
                    value="{{ request('end_date', now()->format('Y-m-d')) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                >
            </div>

            <!-- Category Filter -->
            <div>
                <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                <select id="category" name="category" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">All Categories</option>
                    <option value="membership" {{ request('category') === 'membership' ? 'selected' : '' }}>Membership Fees</option>
                    <option value="fundraising" {{ request('category') === 'fundraising' ? 'selected' : '' }}>Fundraising</option>
                    <option value="operations" {{ request('category') === 'operations' ? 'selected' : '' }}>Operations</option>
                    <option value="events" {{ request('category') === 'events' ? 'selected' : '' }}>Events</option>
                    <option value="supplies" {{ request('category') === 'supplies' ? 'selected' : '' }}>Supplies</option>
                </select>
            </div>

            <!-- Filter Button -->
            <div>
                <button type="submit" class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition duration-200">
                    <i class="fas fa-search mr-2"></i>Apply Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Summary Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- Total Income -->
        <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-green-500">
            <p class="text-gray-600 text-sm font-semibold uppercase">Total Income</p>
            <h3 class="text-3xl font-bold text-green-600 mt-2">KES {{ number_format($summary['income'] ?? 0, 2) }}</h3>
            <p class="text-gray-500 text-sm mt-2">{{ ($summary['income_count'] ?? 0) }} transactions</p>
        </div>

        <!-- Total Expenses -->
        <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-red-500">
            <p class="text-gray-600 text-sm font-semibold uppercase">Total Expenses</p>
            <h3 class="text-3xl font-bold text-red-600 mt-2">KES {{ number_format($summary['expense'] ?? 0, 2) }}</h3>
            <p class="text-gray-500 text-sm mt-2">{{ ($summary['expense_count'] ?? 0) }} transactions</p>
        </div>

        <!-- Net Profit/Loss -->
        <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-blue-500">
            <p class="text-gray-600 text-sm font-semibold uppercase">Net Balance</p>
            <h3 class="text-3xl font-bold text-blue-600 mt-2">KES {{ number_format(($summary['income'] ?? 0) - ($summary['expense'] ?? 0), 2) }}</h3>
            <p class="text-gray-500 text-sm mt-2">All transactions</p>
        </div>

        <!-- Profit Margin -->
        <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-purple-500">
            <p class="text-gray-600 text-sm font-semibold uppercase">Profit Margin</p>
            <h3 class="text-3xl font-bold text-purple-600 mt-2">
                {{ ($summary['income'] ?? 0) > 0 ? round((($summary['income'] - $summary['expense']) / $summary['income']) * 100, 1) : 0 }}%
            </h3>
            <p class="text-gray-500 text-sm mt-2">Efficiency ratio</p>
        </div>
    </div>

    <!-- Charts -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Income vs Expenses Chart -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">
                <i class="fas fa-chart-bar mr-2 text-blue-600"></i>Income vs Expenses
            </h3>
            <div class="space-y-4">
                <div>
                    <div class="flex justify-between mb-1">
                        <span class="text-sm font-medium text-green-700">Income</span>
                        <span class="text-sm font-bold text-green-700">KES {{ number_format($summary['income'] ?? 0, 0) }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-3">
                        <div class="bg-green-500 h-3 rounded-full" style="width: {{ min(100, (($summary['income'] ?? 0) / (($summary['income'] ?? 0) + ($summary['expense'] ?? 0)) * 100)) }}%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between mb-1">
                        <span class="text-sm font-medium text-red-700">Expenses</span>
                        <span class="text-sm font-bold text-red-700">KES {{ number_format($summary['expense'] ?? 0, 0) }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-3">
                        <div class="bg-red-500 h-3 rounded-full" style="width: {{ min(100, (($summary['expense'] ?? 0) / (($summary['income'] ?? 0) + ($summary['expense'] ?? 0)) * 100)) }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Category Breakdown -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">
                <i class="fas fa-pie-chart mr-2 text-blue-600"></i>Expenses by Category
            </h3>
            <div class="space-y-3">
                @foreach($categoryBreakdown ?? [] as $category => $amount)
                    @if($amount > 0)
                    <div>
                        <div class="flex justify-between mb-1">
                            <span class="text-sm font-medium text-gray-700">{{ ucfirst($category) }}</span>
                            <span class="text-sm font-bold text-gray-800">KES {{ number_format($amount, 0) }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div 
                                class="bg-blue-500 h-2 rounded-full" 
                                style="width: {{ ($amount / (max($categoryBreakdown ?? []) ?? 1)) * 100 }}%"
                            ></div>
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>

    <!-- Detailed Transactions Table -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-bold text-gray-800">
                <i class="fas fa-table mr-2 text-blue-600"></i>Transaction Details
            </h3>
        </div>
        
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Date</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Description</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Category</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Type</th>
                    <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">Amount</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($transactions ?? [] as $transaction)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm text-gray-800">{{ \Carbon\Carbon::parse($transaction->date)->format('M d, Y') }}</td>
                        <td class="px-6 py-4 text-sm text-gray-800 font-medium">{{ $transaction->description }}</td>
                        <td class="px-6 py-4 text-sm"><span class="px-2 py-1 bg-gray-100 rounded text-xs">{{ ucfirst($transaction->category) }}</span></td>
                        <td class="px-6 py-4 text-sm">
                            @if($transaction->type === 'income')
                                <span class="text-green-600 font-bold">Income</span>
                            @else
                                <span class="text-red-600 font-bold">Expense</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm font-bold text-right {{ $transaction->type === 'income' ? 'text-green-600' : 'text-red-600' }}">
                            {{ $transaction->type === 'income' ? '+' : '-' }}KES {{ number_format($transaction->amount, 2) }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                            <i class="fas fa-inbox text-gray-300 text-4xl mb-2 block"></i>
                            No transactions found for the selected period
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Export Options -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">
            <i class="fas fa-download mr-2 text-blue-600"></i>Export Report
        </h3>
        <div class="flex flex-col md:flex-row gap-4">
            <a href="{{ route('reports.export', ['format' => 'pdf'] + request()->query()) }}" class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition duration-200 inline-block">
                <i class="fas fa-file-pdf mr-2"></i>Export as PDF
            </a>
            <a href="{{ route('reports.export', ['format' => 'csv'] + request()->query()) }}" class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition duration-200 inline-block">
                <i class="fas fa-file-csv mr-2"></i>Export as CSV
            </a>
            <a href="{{ route('reports.export', ['format' => 'excel'] + request()->query()) }}" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition duration-200 inline-block">
                <i class="fas fa-file-excel mr-2"></i>Export as Excel
            </a>
        </div>
    </div>
</div>
@endsection
