<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employee;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departments = Department::with('employees', 'hod')->paginate(10);
        return view('departments.index', compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $hods = Employee::all();
        return view('departments.create', compact('hods'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:departments|max:255',
            'description' => 'nullable|string',
            'hod_id' => 'nullable|exists:employees,id',
        ]);

        Department::create($validated);
        return redirect()->route('departments.index')->with('success', 'Department created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        $department->load('employees', 'hod');
        return view('departments.show', compact('department'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department)
    {
        // Only show employees who belong to this department when selecting a HOD
        $hods = $department->employees()->get();
        return view('departments.edit', compact('department', 'hods'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Department $department)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:departments,name,' . $department->id . '|max:255',
            'description' => 'nullable|string',
            'hod_id' => 'nullable|exists:employees,id',
        ]);

        $department->update($validated);
        return redirect()->route('departments.show', $department)->with('success', 'Department updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        $department->delete();
        return redirect()->route('departments.index')->with('success', 'Department deleted successfully');
    }

    /**
     * Add employee to department
     */
    public function addEmployee(Request $request, Department $department)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
        ]);

        $department->employees()->syncWithoutDetaching($validated['employee_id']);
        return redirect()->route('departments.show', $department)->with('success', 'Employee added to department');
    }

    /**
     * Remove employee from department
     */
    public function removeEmployee(Department $department, Employee $employee)
    {
        $department->employees()->detach($employee->id);
        return redirect()->route('departments.show', $department)->with('success', 'Employee removed from department');
    }
}
