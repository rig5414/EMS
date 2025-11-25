@extends('layout')

@section('title', 'Departments')
@section('page_title', 'Departments')

@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Departments</h1>
        <p class="text-gray-600 mt-1">Organize your company structure</p>
    </div>
    <a href="{{ route('departments.create') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 font-semibold flex items-center gap-2">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v3.5H9a1 1 0 100 2h2v3.5a1 1 0 102 0v-3.5h2a1 1 0 100-2h-2V7z" clip-rule="evenodd"></path>
        </svg>
        Add Department
    </a>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Name</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Description</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">HOD</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Employees</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse ($departments as $department)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4">
                        <p class="font-semibold text-gray-900">{{ $department->name }}</p>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ Str::limit($department->description, 50) }}</td>
                    <td class="px-6 py-4">
                        @if ($department->hod)
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 bg-gradient-to-br from-purple-400 to-purple-600 rounded-full flex items-center justify-center text-white text-xs font-bold">
                                    {{ strtoupper(substr($department->hod->name, 0, 1)) }}
                                </div>
                                <a href="{{ route('employees.show', $department->hod) }}" class="text-blue-600 hover:text-blue-800 font-semibold text-sm">
                                    {{ $department->hod->name }}
                                </a>
                            </div>
                        @else
                            <span class="text-gray-500 text-sm">Not assigned</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center justify-center w-8 h-8 bg-blue-100 text-blue-700 rounded-full text-sm font-semibold">
                            {{ $department->employees->count() }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <a href="{{ route('departments.show', $department) }}" class="text-blue-600 hover:text-blue-800 font-semibold text-sm">View</a>
                            <a href="{{ route('departments.edit', $department) }}" class="text-yellow-600 hover:text-yellow-800 font-semibold text-sm">Edit</a>
                            <form method="POST" action="{{ route('departments.destroy', $department) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 font-semibold text-sm" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                        <svg class="w-12 h-12 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        No departments found
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $departments->links() }}
</div>
@endsection
