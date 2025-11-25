@extends('layout')

@section('title', 'Create Department')

@section('content')
<h2 class="text-3xl font-bold text-gray-800 mb-6">Create Department</h2>

<div class="bg-white rounded-lg shadow p-6 max-w-lg">
    <form action="{{ route('departments.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label for="name" class="block text-sm font-semibold text-gray-700">Name</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" class="w-full px-3 py-2 border rounded @error('name') border-red-500 @enderror">
            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="description" class="block text-sm font-semibold text-gray-700">Description</label>
            <textarea id="description" name="description" rows="4" class="w-full px-3 py-2 border rounded">{{ old('description') }}</textarea>
        </div>

        <div class="mb-4">
            <label for="hod_id" class="block text-sm font-semibold text-gray-700">Head of Department (HOD)</label>
            <select id="hod_id" name="hod_id" class="w-full px-3 py-2 border rounded">
                <option value="">Select an employee</option>
                @foreach ($hods as $emp)
                    <option value="{{ $emp->id }}" {{ old('hod_id') == $emp->id ? 'selected' : '' }}>
                        {{ $emp->name }} ({{ $emp->position }})
                    </option>
                @endforeach
            </select>
            @error('hod_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="flex gap-4">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Create</button>
            <a href="{{ route('departments.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">Cancel</a>
        </div>
    </form>
</div>
@endsection
