<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Department;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalEmployees = Employee::count();
        $totalDepartments = Department::count();
        $activeEmployees = Employee::where('status', 'active')->count();
        $inactiveEmployees = Employee::where('status', 'inactive')->count();

        $recentEmployees = Employee::with('departments')
            ->latest()
            ->limit(5)
            ->get();

        $departmentsWithCounts = Department::with(['employees', 'hod'])
            ->get()
            ->map(fn($dept) => [
                'name' => $dept->name,
                'employee_count' => $dept->employees->count(),
                'hod' => $dept->hod?->name ?? 'Not Assigned',
                'id' => $dept->id,
            ])
            ->take(5);

        $averageSalary = Employee::avg('salary');
        $highestPaidEmployee = Employee::orderBy('salary', 'desc')->first();

        // Payroll (sum of salaries)
        $totalPayroll = Employee::sum('salary') ?? 0;

        // New hires in last 30 days
        $newHires30 = Employee::where('created_at', '>=', now()->subDays(30))->count();

        // Hires per month (last 12 months)
        $months = collect();
        $hires = collect();
        for ($i = 11; $i >= 0; $i--) {
            $dt = now()->subMonths($i);
            $label = $dt->format('M');
            $start = $dt->copy()->startOfMonth();
            $end = $dt->copy()->endOfMonth();

            $count = Employee::whereBetween('created_at', [$start, $end])->count();
            $months->push($label);
            $hires->push($count);
        }

        // Cumulative employees per month (end of month total)
        $cumLabels = $months;
        $cumData = collect();
        $running = 0;
        foreach ($months as $mIndex => $mLabel) {
            $dt = now()->subMonths(11 - $mIndex)->endOfMonth();
            $running = Employee::where('created_at', '<=', $dt)->count();
            $cumData->push($running);
        }

        return view('dashboard', compact(
            'totalEmployees',
            'totalDepartments',
            'activeEmployees',
            'inactiveEmployees',
            'recentEmployees',
            'departmentsWithCounts',
            'averageSalary',
            'highestPaidEmployee',
            'totalPayroll',
            'newHires30',
            'months',
            'hires',
            'cumLabels',
            'cumData'
        ));
    }
}
