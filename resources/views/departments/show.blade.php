@extends('layout')

@section('title', $department->name)

@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-3xl font-bold text-gray-800">{{ $department->name }}</h2>
        <p class="text-gray-600 mt-1">{{ $department->description }}</p>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('departments.edit', $department) }}" class="bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700">Edit</a>
        <form method="POST" action="{{ route('departments.destroy', $department) }}" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700" onclick="return confirm('Are you sure?')">Delete</button>
        </form>
    </div>
</div>

<div class="grid grid-cols-2 gap-6">
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold mb-4">Head of Department</h3>
        @if ($department->hod)
            <div class="bg-purple-50 p-4 rounded border border-purple-200">
                <p class="font-semibold">
                    <a href="{{ route('employees.show', $department->hod) }}" class="text-blue-600 hover:underline">
                        {{ $department->hod->name }}
                    </a>
                </p>
                <p class="text-sm text-gray-600">{{ $department->hod->position }}</p>
                <p class="text-sm text-gray-600">{{ $department->hod->email }}</p>
            </div>
        @else
            <p class="text-gray-500">No HOD assigned</p>
        @endif
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold mb-4">Employees ({{ $department->employees->count() }})</h3>
        <div class="flex gap-2 mb-4">
            <form action="{{ route('departments.addEmployee', $department) }}" method="POST" class="flex gap-2 w-full">
                @csrf
                <select name="employee_id" class="flex-1 px-3 py-2 border rounded">
                    <option value="">Add employee...</option>
                    @foreach (\App\Models\Employee::whereNotIn('id', $department->employees->pluck('id'))->get() as $emp)
                        <option value="{{ $emp->id }}">{{ $emp->name }} - {{ $emp->position }}</option>
                    @endforeach
                </select>
                <button type="submit" class="bg-green-600 text-white px-3 py-2 rounded hover:bg-green-700 text-sm">Add</button>
            </form>
        </div>

        @if ($department->employees->count() > 0)
            <ul class="space-y-2">
                @foreach ($department->employees as $emp)
                    <li class="flex justify-between items-center bg-gray-50 p-3 rounded">
                        <div>
                            <a href="{{ route('employees.show', $emp) }}" class="text-blue-600 hover:underline font-semibold">{{ $emp->name }}</a>
                            <p class="text-sm text-gray-600">{{ $emp->position }}</p>
                        </div>
                        <form method="POST" action="{{ route('departments.removeEmployee', [$department, $emp]) }}" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 text-sm" onclick="return confirm('Remove from department?')">Remove</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-500">No employees in this department</p>
        @endif
    </div>
</div>

<div class="mt-6">
    <a href="{{ route('departments.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">Back to Departments</a>
</div>
@endsection
