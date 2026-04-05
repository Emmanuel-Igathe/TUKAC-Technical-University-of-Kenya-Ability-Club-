@extends('layouts.app')

@section('title', 'Transactions - TUK Ability Club')
@section('header', 'Transaction History')

@section('content')
<div class="space-y-6">
    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Total Income -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Total Income</p>
                    <h3 class="text-2xl font-bold text-green-600">KES {{ number_format($totals['income'] ?? 0, 2) }}</h3>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-arrow-up text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Expenses -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Total Expenses</p>
                    <h3 class="text-2xl font-bold text-red-600">KES {{ number_format($totals['expense'] ?? 0, 2) }}</h3>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-arrow-down text-red-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Net Balance -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Net Balance</p>
                    <h3 class="text-2xl font-bold text-blue-600">KES {{ number_format(($totals['income'] ?? 0) - ($totals['expense'] ?? 0), 2) }}</h3>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-wallet text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Add Transaction -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex flex-col md:flex-row gap-4">
                <!-- Filter by Type -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Filter by Type:</label>
                    <select id="filterType" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="">All Transactions</option>
                        <option value="income">Income</option>
                        <option value="expense">Expenses</option>
                    </select>
                </div>

                <!-- Filter by Category -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Filter by Category:</label>
                    <select id="filterCategory" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="">All Categories</option>
                        <option value="membership">Membership Fees</option>
                        <option value="fundraising">Fundraising</option>
                        <option value="operations">Operations</option>
                        <option value="events">Events</option>
                        <option value="supplies">Supplies</option>
                        <option value="other">Other</option>
                    </select>
                </div>
            </div>

            <!-- Add Transaction Button -->
            @can('create', \App\Models\Transaction::class)
            <div>
                <a href="{{ route('transactions.create') }}" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition duration-200 inline-block">
                    <i class="fas fa-plus mr-2"></i>Add Transaction
                </a>
            </div>
            @endcan
        </div>
    </div>

    <!-- Transactions Table -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Date</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Description</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Category</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Type</th>
                    <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">Amount</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Created By</th>
                    <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($transactions ?? [] as $transaction)
                    <tr class="hover:bg-gray-50 transition duration-150" data-type="{{ $transaction->type }}" data-category="{{ $transaction->category }}">
                        <td class="px-6 py-4 text-sm text-gray-800">
                            {{ \Carbon\Carbon::parse($transaction->date)->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-800 font-medium">{{ $transaction->description }}</td>
                        <td class="px-6 py-4 text-sm">
                            <span class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-xs">
                                {{ ucfirst($transaction->category) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            @if($transaction->type === 'income')
                                <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold">
                                    <i class="fas fa-arrow-up mr-1"></i>Income
                                </span>
                            @else
                                <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs font-semibold">
                                    <i class="fas fa-arrow-down mr-1"></i>Expense
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm font-bold text-right {{ $transaction->type === 'income' ? 'text-green-600' : 'text-red-600' }}">
                            {{ $transaction->type === 'income' ? '+' : '-' }}KES {{ number_format($transaction->amount, 2) }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $transaction->createdBy?->name ?? 'System' }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center space-x-2">
                                @can('view', $transaction)
                                <a href="{{ route('transactions.show', $transaction) }}" class="text-blue-600 hover:text-blue-700">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @endcan

                                @can('update', $transaction)
                                <a href="{{ route('transactions.edit', $transaction) }}" class="text-yellow-600 hover:text-yellow-700">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @endcan

                                @can('delete', $transaction)
                                <form action="{{ route('transactions.destroy', $transaction) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this transaction?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-700">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <i class="fas fa-inbox text-gray-300 text-5xl mb-4 block"></i>
                            <p class="text-gray-500">No transactions recorded yet</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if(isset($transactions) && $transactions->hasPages())
    <div class="flex justify-center">
        {{ $transactions->links() }}
    </div>
    @endif
</div>

<script>
document.getElementById('filterType').addEventListener('change', function() {
    filterTransactions();
});

document.getElementById('filterCategory').addEventListener('change', function() {
    filterTransactions();
});

function filterTransactions() {
    const typeFilter = document.getElementById('filterType').value;
    const categoryFilter = document.getElementById('filterCategory').value;
    const rows = document.querySelectorAll('tbody tr[data-type]');

    rows.forEach(row => {
        let show = true;
        if (typeFilter && row.getAttribute('data-type') !== typeFilter) show = false;
        if (categoryFilter && row.getAttribute('data-category') !== categoryFilter) show = false;
        row.style.display = show ? '' : 'none';
    });
}
</script>
@endsection
