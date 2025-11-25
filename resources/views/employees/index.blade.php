@extends('layout')

@section('title', 'Employees')
@section('page_title', 'Employees')

@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Employees</h1>
        <p class="text-gray-600 mt-1">Manage your workforce</p>
    </div>
    <a href="{{ route('employees.create') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 font-semibold flex items-center gap-2">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v3.5H9a1 1 0 100 2h2v3.5a1 1 0 102 0v-3.5h2a1 1 0 100-2h-2V7z" clip-rule="evenodd"></path>
        </svg>
        Add Employee
    </a>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Name</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Email</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Position</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Salary</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Departments</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse ($employees as $employee)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                {{ strtoupper(substr($employee->name, 0, 1)) }}
                            </div>
                            <p class="font-semibold text-gray-900">{{ $employee->name }}</p>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $employee->email }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $employee->position }}</td>
                    <td class="px-6 py-4 text-sm font-semibold text-gray-900">{{ $employee->salary ? 'Ksh ' . number_format($employee->salary, 0) : 'N/A' }}</td>
                    <td class="px-6 py-4">
                        @if ($employee->departments->count() > 0)
                            <div class="flex flex-wrap gap-1">
                                @foreach ($employee->departments as $dept)
                                    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs font-semibold">{{ $dept->name }}</span>
                                @endforeach
                            </div>
                        @else
                            <span class="text-gray-500 text-sm">No departments</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $employee->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ ucfirst($employee->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <a href="{{ route('employees.show', $employee) }}" class="text-blue-600 hover:text-blue-800 font-semibold text-sm">View</a>
                            <a href="{{ route('employees.edit', $employee) }}" class="text-yellow-600 hover:text-yellow-800 font-semibold text-sm">Edit</a>
                            <form method="POST" action="{{ route('employees.destroy', $employee) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 font-semibold text-sm" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                        <svg class="w-12 h-12 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3.598a3 3 0 01-2.996-3.154l.001-.192c0-4.069 4.418-7.381 9.897-7.381s9.897 3.312 9.897 7.38c0 1.059-.121 2.094-.35 3.137a40.122 40.122 0 01-7.848 1.016z"></path>
                        </svg>
                        No employees found
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $employees->links() }}
</div>
@endsection
