@extends('layouts.app')

@section('title', 'Events Calendar - TUK Ability Club')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="bg-gradient-to-r from-blue-600 to-cyan-600 dark:from-blue-700 dark:to-cyan-700 rounded-2xl shadow-xl p-8 text-white">
        <h1 class="text-4xl md:text-5xl font-bold mb-2">📅 Events Calendar</h1>
        <p class="text-blue-100 text-lg">View all upcoming and past club events</p>
    </div>

    <!-- Calendar Grid Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- Main Calendar -->
        <div class="lg:col-span-3">
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-slate-200 dark:border-slate-700 p-8">
                <!-- Calendar Controls -->
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white" id="monthYear"></h2>
                    <div class="flex gap-2">
                        <button onclick="previousMonth()" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition font-semibold">← Prev</button>
                        <button onclick="currentMonth()" class="px-4 py-2 bg-slate-500 hover:bg-slate-600 text-white rounded-lg transition font-semibold">Today</button>
                        <button onclick="nextMonth()" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition font-semibold">Next →</button>
                    </div>
                </div>

                <!-- Calendar Table -->
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead class="bg-blue-50 dark:bg-slate-700/50">
                            <tr>
                                <th class="border border-slate-200 dark:border-slate-600 p-3 text-center font-bold text-gray-800 dark:text-white">Sun</th>
                                <th class="border border-slate-200 dark:border-slate-600 p-3 text-center font-bold text-gray-800 dark:text-white">Mon</th>
                                <th class="border border-slate-200 dark:border-slate-600 p-3 text-center font-bold text-gray-800 dark:text-white">Tue</th>
                                <th class="border border-slate-200 dark:border-slate-600 p-3 text-center font-bold text-gray-800 dark:text-white">Wed</th>
                                <th class="border border-slate-200 dark:border-slate-600 p-3 text-center font-bold text-gray-800 dark:text-white">Thu</th>
                                <th class="border border-slate-200 dark:border-slate-600 p-3 text-center font-bold text-gray-800 dark:text-white">Fri</th>
                                <th class="border border-slate-200 dark:border-slate-600 p-3 text-center font-bold text-gray-800 dark:text-white">Sat</th>
                            </tr>
                        </thead>
                        <tbody id="calendarBody"></tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Quick Add Card -->
            <div class="bg-gradient-to-br from-blue-50 to-cyan-50 dark:from-blue-950/50 dark:to-cyan-950/50 rounded-2xl border-2 border-blue-200 dark:border-blue-800 p-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">📝 Quick Add</h3>
                <a href="{{ route('events.create') }}" class="block w-full px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg transition text-center">
                    + Create Event
                </a>
            </div>

            <!-- Upcoming Events -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-slate-200 dark:border-slate-700 p-6">
                <h3 class="font-bold text-gray-900 dark:text-white mb-4">🔔 Next 7 Days</h3>
                <div class="space-y-3">
                    @forelse($upcomingEvents ?? [] as $event)
                        <a href="{{ route('events.show', $event) }}" class="block p-3 bg-blue-50 dark:bg-slate-700/50 border-l-4 border-blue-600 rounded hover:shadow-md transition">
                            <p class="font-semibold text-gray-900 dark:text-white text-sm">{{ $event->title }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $event->date->format('M d') }}</p>
                        </a>
                    @empty
                        <p class="text-gray-500 dark:text-gray-400 text-sm">No upcoming events</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- All Events Section -->
    <div>
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">📋 All Events</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"></h2>

            @forelse($events ?? [] as $event)
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition">
                    <div class="h-32 bg-gradient-to-r from-blue-400 to-cyan-400 dark:from-blue-900 dark:to-cyan-900 flex items-center justify-center text-5xl">📅</div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">{{ $event->title }}</h3>
                        <div class="space-y-2 text-sm text-gray-600 dark:text-gray-300 mb-4">
                            <p>📅 {{ $event->date->format('M d, Y') }} @ {{ $event->time }}</p>
                            <p>📍 {{ $event->location }}</p>
                            <p>👥 {{ $event->registrations_count ?? 0 }} / {{ $event->capacity }} attendees</p>
                        </div>
                        <a href="{{ route('events.show', $event) }}" class="inline-block px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition">
                            View Details →
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-gray-500 dark:text-gray-400 text-lg">No events scheduled yet</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<script>
let currentDate = new Date();

function renderCalendar() {
    const year = currentDate.getFullYear();
    const month = currentDate.getMonth();
    
    document.getElementById('monthYear').textContent = currentDate.toLocaleString('default', { month: 'long', year: 'numeric' });
    
    const firstDay = new Date(year, month, 1);
    const lastDay = new Date(year, month + 1, 0);
    const prevLastDay = new Date(year, month, 0);
    
    const nextDays = 7 - lastDay.getDay();
    
    let html = '';
    let date = new Date(firstDay);
    date.setDate(date.getDate() - firstDay.getDay());
    
    for (let i = 0; i < 6; i++) {
        html += '<tr>';
        for (let j = 0; j < 7; j++) {
            const isCurrentMonth = date.getMonth() === month;
            const isToday = date.toDateString() === new Date().toDateString();
            
            let cellClass = 'border border-slate-200 dark:border-slate-600 p-3 h-24 text-sm ';
            cellClass += isCurrentMonth ? 'bg-white dark:bg-slate-800' : 'bg-slate-50 dark:bg-slate-900 text-gray-400 dark:text-gray-600';
            cellClass += isToday ? ' bg-blue-100 dark:bg-blue-900/30 font-bold text-blue-700 dark:text-blue-400' : '';
            
            html += `<td class="${cellClass}"><strong>${date.getDate()}</strong></td>`;
            date.setDate(date.getDate() + 1);
        }
        html += '</tr>';
    }
    
    document.getElementById('calendarBody').innerHTML = html;
}

function previousMonth() {
    currentDate.setMonth(currentDate.getMonth() - 1);
    renderCalendar();
}

function nextMonth() {
    currentDate.setMonth(currentDate.getMonth() + 1);
    renderCalendar();
}

function currentMonth() {
    currentDate = new Date();
    renderCalendar();
}

// Initial render
renderCalendar();
</script>
@endsection
