@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    {{-- Back Button --}}
    <a href="{{ route('events.index') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline mb-6 inline-flex items-center">
        ← Back to Events
    </a>

    {{-- Form Card --}}
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">
            {{ isset($event) ? 'Edit Event' : 'Create Event' }}
        </h1>

        {{-- Display validation errors --}}
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 dark:bg-red-900 border border-red-200 dark:border-red-700 rounded-lg">
                <h3 class="font-semibold text-red-800 dark:text-red-200 mb-2">Validation Errors:</h3>
                <ul class="list-disc list-inside text-red-700 dark:text-red-300 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form --}}
        <form action="{{ isset($event) ? route('events.update', $event) : route('events.store') }}" method="POST" class="space-y-6">
            @csrf
            @if (isset($event))
                @method('PUT')
            @endif

            {{-- Title --}}
            <div>
                <label for="title" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">
                    Event Title <span class="text-red-600">*</span>
                </label>
                <input type="text" 
                       id="title" 
                       name="title" 
                       value="{{ old('title', $event->title ?? '') }}"
                       class="w-full px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500"
                       required>
            </div>

            {{-- Description --}}
            <div>
                <label for="description" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">
                    Description <span class="text-red-600">*</span>
                </label>
                <textarea id="description" 
                          name="description" 
                          rows="6"
                          class="w-full px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500"
                          required>{{ old('description', $event->description ?? '') }}</textarea>
            </div>

            {{-- Date and Time Grid --}}
            <div class="grid md:grid-cols-2 gap-4">
                {{-- Date --}}
                <div>
                    <label for="date" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">
                        Date <span class="text-red-600">*</span>
                    </label>
                    <input type="date" 
                           id="date" 
                           name="date" 
                           value="{{ old('date', isset($event) ? $event->date->format('Y-m-d') : '') }}"
                           class="w-full px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500"
                           required>
                </div>

                {{-- Time --}}
                <div>
                    <label for="time" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">
                        Time <span class="text-red-600">*</span>
                    </label>
                    <input type="time" 
                           id="time" 
                           name="time" 
                           value="{{ old('time', $event->time ?? '') }}"
                           class="w-full px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500"
                           required>
                </div>
            </div>

            {{-- Location and Capacity Grid --}}
            <div class="grid md:grid-cols-2 gap-4">
                {{-- Location --}}
                <div>
                    <label for="location" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">
                        Location <span class="text-red-600">*</span>
                    </label>
                    <input type="text" 
                           id="location" 
                           name="location" 
                           value="{{ old('location', $event->location ?? '') }}"
                           placeholder="e.g., Sports Hall, Room 201"
                           class="w-full px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500"
                           required>
                </div>

                {{-- Capacity --}}
                <div>
                    <label for="capacity" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">
                        Capacity <span class="text-red-600">*</span>
                    </label>
                    <input type="number" 
                           id="capacity" 
                           name="capacity" 
                           value="{{ old('capacity', $event->capacity ?? 100) }}"
                           min="1"
                           class="w-full px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500"
                           required>
                </div>
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
