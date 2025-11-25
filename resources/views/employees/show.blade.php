@extends('layout')

@section('title', $employee->name)

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-3xl font-bold text-gray-800">{{ $employee->name }}</h2>
    <div class="flex gap-2">
        <a href="{{ route('employees.edit', $employee) }}" class="bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700">Edit</a>
        <form method="POST" action="{{ route('employees.destroy', $employee) }}" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700" onclick="return confirm('Are you sure?')">Delete</button>
        </form>
    </div>
</div>

<div class="grid grid-cols-2 gap-6">
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold mb-4">Employee Details</h3>
        <dl class="space-y-3">
            <div>
                <dt class="font-semibold text-gray-700">Email:</dt>
                <dd class="text-gray-600">{{ $employee->email }}</dd>
            </div>
            <div>
                <dt class="font-semibold text-gray-700">Phone:</dt>
                <dd class="text-gray-600">{{ $employee->phone ?? 'N/A' }}</dd>
            </div>
            <div>
                <dt class="font-semibold text-gray-700">Position:</dt>
                <dd class="text-gray-600">{{ $employee->position }}</dd>
            </div>
            <div>
                <dt class="font-semibold text-gray-700">Salary:</dt>
                    <dd class="text-gray-600">{{ $employee->salary ? 'Ksh ' . number_format($employee->salary, 2) : 'N/A' }}</dd>
            </div>
            <div>
                <dt class="font-semibold text-gray-700">Status:</dt>
                <dd>
                    <span class="px-2 py-1 rounded text-sm {{ $employee->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ ucfirst($employee->status) }}
                    </span>
                </dd>
            </div>
        </dl>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold mb-4">Departments</h3>
        @if ($employee->departments->count() > 0)
            <ul class="space-y-2">
                @foreach ($employee->departments as $dept)
                    <li class="flex justify-between items-center bg-gray-50 p-3 rounded">
                        <a href="{{ route('departments.show', $dept) }}" class="text-blue-600 hover:underline">{{ $dept->name }}</a>
                        @if ($dept->hod_id === $employee->id)
                            <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded text-xs">HOD</span>
                        @endif
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-500">Not assigned to any department</p>
        @endif
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold mb-4">Departments as HOD</h3>
        @if ($employee->departmentsAsHod->count() > 0)
            <ul class="space-y-2">
                @foreach ($employee->departmentsAsHod as $dept)
                    <li>
                        <a href="{{ route('departments.show', $dept) }}" class="text-blue-600 hover:underline">{{ $dept->name }}</a>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-500">Not a HOD of any department</p>
        @endif
    </div>
</div>

<div class="mt-6">
    <a href="{{ route('employees.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">Back to Employees</a>
</div>
@endsection
