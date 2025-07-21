@extends('layouts.admin')

@section('header')
    {{ __('Applications Report') }}
@endsection

@section('content')
    <div class="space-y-6">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Filter Report</h3>
            <form action="{{ route('admin.reports.applications') }}" method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                    <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                    <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select id="status" name="status" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">All Statuses</option>
                        <option value="applied" {{ request('status') == 'applied' ? 'selected' : '' }}>Applied</option>
                        <option value="screening" {{ request('status') == 'screening' ? 'selected' : '' }}>Screening</option>
                        <option value="interview" {{ request('status') == 'interview' ? 'selected' : '' }}>Interview</option>
                        <option value="test" {{ request('status') == 'test' ? 'selected' : '' }}>Test</option>
                        <option value="hired" {{ request('status') == 'hired' ? 'selected' : '' }}>Hired</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>
                <div>
                    <label for="job_vacancy_id" class="block text-sm font-medium text-gray-700">Job Vacancy</label>
                    <select id="job_vacancy_id" name="job_vacancy_id" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">All Positions</option>
                        @foreach($jobVacancies as $id => $title)
                            <option value="{{ $id }}" {{ request('job_vacancy_id') == $id ? 'selected' : '' }}>{{ $title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex space-x-2">
                    <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 10a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" /></svg>
                        Generate
                    </button>
                    <a href="{{ route('admin.reports.export', array_merge(request()->query(), ['report_type' => 'applications'])) }}" class="w-full inline-flex justify-center items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                       <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                        Export
                    </a>
                </div>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white rounded-xl shadow p-6">
                <p class="text-sm font-medium text-gray-500">Total Applications</p>
                <p class="text-3xl font-bold text-gray-800 mt-1">{{ $applications->total() }}</p>
            </div>
            <div class="bg-white rounded-xl shadow p-6">
                <p class="text-sm font-medium text-gray-500">Screening</p>
                <p class="text-3xl font-bold text-blue-600 mt-1">{{ $applications->where('status', 'screening')->count() }}</p>
            </div>
            <div class="bg-white rounded-xl shadow p-6">
                <p class="text-sm font-medium text-gray-500">Hired</p>
                <p class="text-3xl font-bold text-green-600 mt-1">{{ $applications->where('status', 'hired')->count() }}</p>
            </div>
            <div class="bg-white rounded-xl shadow p-6">
                <p class="text-sm font-medium text-gray-500">Rejected</p>
                <p class="text-3xl font-bold text-red-600 mt-1">{{ $applications->where('status', 'rejected')->count() }}</p>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Applicant</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Job Position</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Expected Salary</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Applied Date</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($applications as $application)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $application->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $application->user->name }}</div>
                                <div class="text-xs text-gray-500">{{ $application->user->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $application->jobVacancy->title }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($application->status == 'applied') bg-gray-100 text-gray-800
                                    @elseif($application->status == 'screening') bg-blue-100 text-blue-800
                                    @elseif($application->status == 'interview') bg-purple-100 text-purple-800
                                    @elseif($application->status == 'test') bg-yellow-100 text-yellow-800
                                    @elseif($application->status == 'hired') bg-green-100 text-green-800
                                    @elseif($application->status == 'rejected') bg-red-100 text-red-800
                                    @endif">
                                    {{ ucfirst($application->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rp {{ number_format($application->expected_salary, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $application->created_at->format('d M Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center text-gray-500">
                                No applications found for the selected criteria.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
             <div class="px-6 py-4 border-t border-gray-200">
                {{ $applications->withQueryString()->links() }}
            </div>
        </div>
        
        @php
            $statusCounts = $applications->countBy('status');
            $applicationsByJob = $applications->groupBy('jobVacancy.title')->map->count()->sortDesc()->take(10);
        @endphp
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Application Status Distribution</h3>
                <div class="relative h-80">
                     <canvas id="applicationStatusChart"></canvas>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Top 10 Jobs by Applications</h3>
                <div class="relative h-80">
                    <canvas id="applicationsByJobChart"></canvas>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Application Status Chart
        const statusCtx = document.getElementById('applicationStatusChart').getContext('2d');
        const statusData = @json($statusCounts);
        
        if (Object.keys(statusData).length > 0) {
            new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: Object.keys(statusData).map(s => s.charAt(0).toUpperCase() + s.slice(1)),
                    datasets: [{
                        data: Object.values(statusData),
                        backgroundColor: [
                            'rgba(107, 114, 128, 0.7)', // applied
                            'rgba(59, 130, 246, 0.7)',  // screening
                            'rgba(139, 92, 246, 0.7)',  // interview
                            'rgba(245, 158, 11, 0.7)',  // test
                            'rgba(16, 185, 129, 0.7)',  // hired
                            'rgba(239, 68, 68, 0.7)'    // rejected
                        ],
                        borderColor: '#fff',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { position: 'bottom' } }
                }
            });
        }

        // Applications per Job Chart
        const byJobCtx = document.getElementById('applicationsByJobChart').getContext('2d');
        const byJobData = @json($applicationsByJob);

        if (Object.keys(byJobData).length > 0) {
            new Chart(byJobCtx, {
                type: 'bar',
                data: {
                    labels: Object.keys(byJobData),
                    datasets: [{
                        label: 'Number of Applications',
                        data: Object.values(byJobData),
                        backgroundColor: 'rgba(59, 130, 246, 0.5)',
                        borderColor: 'rgba(59, 130, 246, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            beginAtZero: true,
                            ticks: { precision: 0 }
                        }
                    },
                    plugins: { legend: { display: false } }
                }
            });
        }
    });
</script>
@endpush