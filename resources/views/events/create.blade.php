@extends('layouts.app')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="bg-gradient-to-r from-blue-600 to-cyan-600 dark:from-blue-700 dark:to-cyan-700 rounded-2xl shadow-xl p-8 text-white">
        <h1 class="text-4xl md:text-5xl font-bold mb-2">📅 {{ isset($event) ? 'Edit Event' : 'Create Event' }}</h1>
        <p class="text-blue-100 text-lg">{{ isset($event) ? 'Update event details' : 'Organize an amazing event for the club' }}</p>
    </div>

    <!-- Form Card -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-slate-200 dark:border-slate-700 p-8 max-w-4xl">
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 dark:bg-red-950 border-2 border-red-300 dark:border-red-800 rounded-lg">
                <h3 class="font-semibold text-red-900 dark:text-red-200 mb-2">⚠️ Validation Errors:</h3>
                <ul class="list-disc list-inside text-red-800 dark:text-red-300 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ isset($event) ? route('events.update', $event) : route('events.store') }}" method="POST" class="space-y-8">
            @csrf
            @if (isset($event))
                @method('PUT')
            @endif

            <!-- Title & Date Row -->
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label for="title" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">📋 Event Title *</label>
                    <input type="text" id="title" name="title" required value="{{ old('title', $event->title ?? '') }}" 
                        class="w-full px-4 py-2 border-2 border-slate-300 dark:border-slate-600 rounded-lg 
                        focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-800 
                        dark:bg-slate-700 dark:text-white transition" placeholder="Event name">
                    @error('title')
                        <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="date" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">📅 Date *</label>
                    <input type="date" id="date" name="date" required value="{{ old('date', isset($event) ? $event->date->format('Y-m-d') : '') }}" 
                        class="w-full px-4 py-2 border-2 border-slate-300 dark:border-slate-600 rounded-lg 
                        focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-800 
                        dark:bg-slate-700 dark:text-white transition">
                    @error('date')
                        <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Time & Location Row -->
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label for="time" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">⏰ Time *</label>
                    <input type="time" id="time" name="time" required value="{{ old('time', $event->time ?? '') }}" 
                        class="w-full px-4 py-2 border-2 border-slate-300 dark:border-slate-600 rounded-lg 
                        focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-800 
                        dark:bg-slate-700 dark:text-white transition">
                    @error('time')
                        <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="location" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">📍 Location *</label>
                    <input type="text" id="location" name="location" required value="{{ old('location', $event->location ?? '') }}" 
                        class="w-full px-4 py-2 border-2 border-slate-300 dark:border-slate-600 rounded-lg 
                        focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-800 
                        dark:bg-slate-700 dark:text-white transition" placeholder="Event venue">
                    @error('location')
                        <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">📝 Description *</label>
                <textarea id="description" name="description" required rows="6" 
                    class="w-full px-4 py-2 border-2 border-slate-300 dark:border-slate-600 rounded-lg 
                    focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-800 
                    dark:bg-slate-700 dark:text-white transition" placeholder="Tell us about the event...">{{ old('description', $event->description ?? '') }}</textarea>
                @error('description')
                    <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Capacity Row -->
            <div>
                <label for="capacity" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">👥 Capacity *</label>
                <input type="number" id="capacity" name="capacity" required min="1" value="{{ old('capacity', $event->capacity ?? 100) }}" 
                    class="w-full px-4 py-2 border-2 border-slate-300 dark:border-slate-600 rounded-lg 
                    focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-800 
                    dark:bg-slate-700 dark:text-white transition" placeholder="Max attendees">
                @error('capacity')
                    <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Form Actions --}}
            <div class="flex gap-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                <button type="submit" class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition font-semibold">
                    {{ isset($event) ? 'Update Event' : 'Create Event' }}
                </button>
                <a href="{{ route('events.index') }}" class="px-6 py-3 bg-gray-300 dark:bg-gray-600 text-gray-900 dark:text-white rounded-lg hover:bg-gray-400 dark:hover:bg-gray-700 transition font-semibold">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
