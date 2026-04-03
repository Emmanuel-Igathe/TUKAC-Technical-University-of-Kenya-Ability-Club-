@extends('layouts.app')

@section('title', 'Events Calendar - TUK Ability Club')
@section('header', 'Events Calendar')

@section('content')
<div class="space-y-6">
    <!-- Calendar Header -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="md:col-span-3">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-gray-800" id="monthYear"></h2>
                    <div class="flex space-x-2">
                        <button onclick="previousMonth()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            <i class="fas fa-chevron-left"></i> Previous
                        </button>
                        <button onclick="currentMonth()" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
                            Today
                        </button>
                        <button onclick="nextMonth()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            Next <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>

                <!-- Calendar Grid -->
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="border border-gray-300 p-2 text-center text-gray-700 font-semibold">Sun</th>
                                <th class="border border-gray-300 p-2 text-center text-gray-700 font-semibold">Mon</th>
                                <th class="border border-gray-300 p-2 text-center text-gray-700 font-semibold">Tue</th>
                                <th class="border border-gray-300 p-2 text-center text-gray-700 font-semibold">Wed</th>
                                <th class="border border-gray-300 p-2 text-center text-gray-700 font-semibold">Thu</th>
                                <th class="border border-gray-300 p-2 text-center text-gray-700 font-semibold">Fri</th>
                                <th class="border border-gray-300 p-2 text-center text-gray-700 font-semibold">Sat</th>
                            </tr>
                        </thead>
                        <tbody id="calendarBody"></tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Sidebar: Quick Add Event -->
        <div class="bg-white rounded-lg shadow-sm p-6 h-fit">
            <h3 class="text-lg font-bold text-gray-800 mb-4">
                <i class="fas fa-plus-circle text-blue-600 mr-2"></i>Quick Add
            </h3>
            <a href="{{ route('events.create') }}" class="block w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg text-center transition duration-200 mb-4">
                Create Event
            </a>

            <!-- Upcoming Events Preview -->
            <h3 class="text-lg font-bold text-gray-800 mb-4 mt-6">
                <i class="fas fa-clock text-blue-600 mr-2"></i>Upcoming (7 days)
            </h3>
            <div class="space-y-3">
                @forelse($upcomingEvents ?? [] as $event)
                    <div class="border-l-4 border-blue-600 bg-blue-50 p-3 rounded">
                        <a href="{{ route('events.show', $event) }}" class="font-semibold text-blue-600 hover:text-blue-700">
                            {{ $event->title }}
                        </a>
                        <p class="text-sm text-gray-600">
                            <i class="fas fa-calendar mr-1"></i>{{ $event->date->format('M d') }}
                        </p>
                    </div>
                @empty
                    <p class="text-gray-500 text-sm">No upcoming events in the next 7 days</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- All Events List (below calendar) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-8">
        <h2 class="col-span-full text-2xl font-bold text-gray-800 mb-2">All Events</h2>

        @forelse($events ?? [] as $event)
            <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition duration-200 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4 text-white">
                    <h3 class="text-xl font-bold">{{ $event->title }}</h3>
                    <p class="text-sm opacity-90">{{ $event->description }}</p>
                </div>
                <div class="p-6 space-y-3">
                    <div class="flex items-center text-gray-600">
                        <i class="fas fa-calendar w-5 mr-3 text-blue-600"></i>
                        <span>{{ $event->date->format('M d, Y') }} @ {{ $event->time }}</span>
                    </div>
                    <div class="flex items-center text-gray-600">
                        <i class="fas fa-map-marker-alt w-5 mr-3 text-blue-600"></i>
                        <span>{{ $event->location }}</span>
                    </div>
                    <div class="flex items-center text-gray-600">
                        <i class="fas fa-users w-5 mr-3 text-blue-600"></i>
                        <span>{{ $event->registrations_count ?? 0 }} / {{ $event->capacity }} attendees</span>
                    </div>
                    <div class="pt-3 border-t border-gray-200">
                        <a href="{{ route('events.show', $event) }}" class="text-blue-600 hover:text-blue-700 font-semibold">
                            View Details <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <i class="fas fa-calendar-times text-gray-300 text-5xl mb-4"></i>
                <p class="text-gray-500">No events scheduled yet</p>
            </div>
        @endforelse
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
            const tdClass = date.getMonth() !== month ? 'bg-gray-50 text-gray-400' : date.toDateString() === new Date().toDateString() ? 'bg-blue-100 font-bold text-blue-600' : 'bg-white';
            html += `<td class="border border-gray-300 p-2 h-24 ${tdClass} text-sm"><strong>${date.getDate()}</strong></td>`;
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
