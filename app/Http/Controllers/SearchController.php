<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Department;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');

        $employees = Employee::query()
            ->when($q, fn($qry) => $qry->where('name', 'like', "%{$q}%")
                ->orWhere('email', 'like', "%{$q}%")
                ->orWhere('position', 'like', "%{$q}%"))
            ->with('departments')
            ->limit(50)
            ->get();

        $departments = Department::query()
            ->when($q, fn($qry) => $qry->where('name', 'like', "%{$q}%")
                ->orWhere('description', 'like', "%{$q}%"))
            ->with('employees')
            ->limit(50)
            ->get();

        return view('search.results', compact('q', 'employees', 'departments'));
    }
}
