@extends('layout')

@section('page_title', 'Search Results')

@section('content')
    <h3 class="text-lg font-semibold mb-4">Search Results for "{{ $q }}"</h3>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <h4 class="font-semibold mb-2">Employees ({{ $employees->count() }})</h4>
            <div class="bg-white p-4 rounded-lg shadow-sm">
                @if($employees->isEmpty())
                    <p class="text-sm text-gray-500">No employees found.</p>
                @else
                    <ul class="space-y-2">
                        @foreach($employees as $e)
                            <li class="flex items-center justify-between">
                                <div>
                                    <a href="{{ route('employees.show', $e) }}" class="font-semibold text-blue-600">{{ $e->name }}</a>
                                    <div class="text-xs text-gray-500">{{ $e->email }} • {{ $e->position }}</div>
                                </div>
                                <div class="text-xs text-gray-400">{{ $e->departments->pluck('name')->join(', ') }}</div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>

        <div>
            <h4 class="font-semibold mb-2">Departments ({{ $departments->count() }})</h4>
            <div class="bg-white p-4 rounded-lg shadow-sm">
                @if($departments->isEmpty())
                    <p class="text-sm text-gray-500">No departments found.</p>
                @else
                    <ul class="space-y-2">
                        @foreach($departments as $d)
                            <li class="flex items-center justify-between">
                                <div>
                                    <a href="{{ route('departments.show', $d) }}" class="font-semibold text-blue-600">{{ $d->name }}</a>
                                    <div class="text-xs text-gray-500">{{ Str::limit($d->description, 80) }}</div>
                                </div>
                                <div class="text-xs text-gray-400">{{ $d->employees->count() }} members</div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
@endsection
