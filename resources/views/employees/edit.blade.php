@extends('layout')

@section('title', 'Edit Employee')

@section('content')
<h2 class="text-3xl font-bold text-gray-800 mb-6">Edit Employee</h2>

<div class="bg-white rounded-lg shadow p-6 max-w-lg">
    <form action="{{ route('employees.update', $employee) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="name" class="block text-sm font-semibold text-gray-700">Name</label>
            <input type="text" id="name" name="name" value="{{ old('name', $employee->name) }}" class="w-full px-3 py-2 border rounded @error('name') border-red-500 @enderror">
            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="email" class="block text-sm font-semibold text-gray-700">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email', $employee->email) }}" class="w-full px-3 py-2 border rounded @error('email') border-red-500 @enderror">
            @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="phone" class="block text-sm font-semibold text-gray-700">Phone</label>
            <input type="text" id="phone" name="phone" value="{{ old('phone', $employee->phone) }}" class="w-full px-3 py-2 border rounded">
        </div>

        <div class="mb-4">
            <label for="position" class="block text-sm font-semibold text-gray-700">Position</label>
            <input type="text" id="position" name="position" value="{{ old('position', $employee->position) }}" class="w-full px-3 py-2 border rounded @error('position') border-red-500 @enderror">
            @error('position') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="salary" class="block text-sm font-semibold text-gray-700">Salary</label>
            <input type="number" id="salary" name="salary" step="0.01" value="{{ old('salary', $employee->salary) }}" class="w-full px-3 py-2 border rounded">
        </div>

        <div class="mb-4">
            <label for="status" class="block text-sm font-semibold text-gray-700">Status</label>
            <select id="status" name="status" class="w-full px-3 py-2 border rounded">
                <option value="active" {{ old('status', $employee->status) === 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ old('status', $employee->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="departments" class="block text-sm font-semibold text-gray-700">Departments</label>
            <select id="departments" name="departments[]" multiple class="w-full px-3 py-2 border rounded">
                @foreach ($departments as $dept)
                    <option value="{{ $dept->id }}" {{ $employee->departments->contains($dept->id) ? 'selected' : '' }}>
                        {{ $dept->name }}
                    </option>
                @endforeach
            </select>
            <p class="text-xs text-gray-500 mt-1">Hold Ctrl/Cmd to select multiple</p>
        </div>

        <div class="flex gap-4">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update</button>
            <a href="{{ route('employees.show', $employee) }}" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">Cancel</a>
        </div>
    </form>
</div>
@endsection
