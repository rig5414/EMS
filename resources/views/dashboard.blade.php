@extends('layout')

@section('page_title', 'Dashboard')

@section('content')
    <div class="space-y-6">
        <!-- Top filters -->
        <div class="bg-white rounded-lg shadow px-6 py-4 flex items-center gap-4">
            <div class="flex-1">
                <div class="text-sm text-gray-500">Business customers only</div>
                <select class="mt-1 w-64 rounded border-gray-200 px-3 py-2 text-sm">
                    <option>-</option>
                </select>
            </div>

            <div class="flex gap-3">
                <div>
                    <div class="text-sm text-gray-500">Start date</div>
                    <input type="date" class="mt-1 rounded border-gray-200 px-3 py-2 text-sm" />
                </div>
                <div>
                    <div class="text-sm text-gray-500">End date</div>
                    <input type="date" class="mt-1 rounded border-gray-200 px-3 py-2 text-sm" />
                </div>
            </div>
        </div>

        <!-- Welcome + small metrics -->
        <div class="grid grid-cols-3 gap-6">
            <div class="col-span-1 ems-card p-4 flex items-center justify-between">
                <div>
                    <div class="text-sm ems-muted">Welcome</div>
                    <div class="text-base font-semibold">Demo User</div>
                </div>
                <div class="ems-avatar">DU</div>
            </div>

            <div class="col-span-2 grid grid-cols-3 gap-6">
                <div class="ems-card p-4">
                    <div class="text-sm ems-muted">Revenue</div>
                    <div class="mt-2 text-2xl font-bold">Ksh {{ number_format(($averageSalary ?? 0) * ($totalEmployees ?? 1) / 1000, 1) }}k</div>
                    <div class="text-xs text-green-500 mt-1">32k increase</div>
                </div>

                <div class="ems-card p-4">
                    <div class="text-sm ems-muted">New customers</div>
                    <div class="mt-2 text-2xl font-bold">1.34k</div>
                    <div class="text-xs text-red-500 mt-1">3% decrease</div>
                </div>

                <div class="ems-card p-4">
                    <div class="text-sm ems-muted">New orders</div>
                    <div class="mt-2 text-2xl font-bold">3.54k</div>
                    <div class="text-xs text-green-500 mt-1">7% increase</div>
                </div>
            </div>
        </div>

        <!-- Charts area -->
        <div class="grid grid-cols-3 gap-6">
            <div class="col-span-2 bg-white rounded-lg shadow p-4">
                <h3 class="text-sm font-semibold mb-2">Orders per month</h3>
                <div class="h-56">
                    <canvas id="ordersChart" style="width:100%;height:100%;"></canvas>
                </div>
            </div>

            <div class="col-span-1 bg-white rounded-lg shadow p-4">
                <h3 class="text-sm font-semibold mb-2">Total customers</h3>
                <div class="h-56">
                    <canvas id="customersChart" style="width:100%;height:100%;"></canvas>
                </div>
            </div>
        </div>

        <!-- Department quick list -->
        <div class="bg-white rounded-lg shadow p-4">
            <h3 class="text-lg font-semibold mb-4">Departments</h3>
            <div class="grid grid-cols-5 gap-4">
                @foreach($departmentsWithCounts ?? [] as $dept)
                    <div class="p-3 border rounded">
                        <div class="text-xs text-gray-500">{{ $dept['name'] }}</div>
                        <div class="text-lg font-bold">{{ $dept['employee_count'] }}</div>
                        <div class="text-xs text-gray-400">HOD: {{ $dept['hod'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <script>
        // Chart data injected from the server (EMS data)
        const hiresLabels = {!! json_encode($months->all()) !!};
        const hiresData = {!! json_encode($hires->all()) !!};

        const cumLabels = {!! json_encode($cumLabels->all()) !!};
        const cumData = {!! json_encode($cumData->all()) !!};

        const ordersCtx = document.getElementById('ordersChart').getContext('2d');
        new Chart(ordersCtx, {
            type: 'line',
            data: {
                labels: hiresLabels,
                datasets: [{
                    label: 'New Hires',
                    data: hiresData,
                    backgroundColor: 'rgba(59,130,246,0.06)',
                    borderColor: 'rgba(59,130,246,0.9)',
                    tension: 0.3,
                    fill: true,
                }]
            },
            options: { responsive:true, maintainAspectRatio:false, plugins:{legend:{display:false}} }
        });

        const customersCtx = document.getElementById('customersChart').getContext('2d');
        new Chart(customersCtx, {
            type: 'line',
            data: {
                labels: cumLabels,
                datasets: [{
                    label: 'Total Employees',
                    data: cumData,
                    backgroundColor: 'rgba(99,102,241,0.06)',
                    borderColor: 'rgba(99,102,241,0.9)',
                    tension: 0.3,
                    fill: true,
                }]
            },
            options: { responsive:true, maintainAspectRatio:false, plugins:{legend:{display:false}} }
        });
    </script>
@endsection
