@extends('layouts.admin')

@section('header')
    <h2 class="font-semibold text-2xl text-secondary-800 leading-tight">
        {{ __('Admin Dashboard') }}
    </h2>
@endsection

@section('content')
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow-lg p-6 group transform hover:-translate-y-1 transition-all duration-300">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-medium text-secondary-500">Total Users</p>
                    <p class="text-3xl font-bold text-secondary-800 mt-1">{{ $totalUsers }}</p>
                </div>
                <div class="p-3 rounded-lg bg-primary-100 text-primary-600">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                </div>
            </div>
            <div class="flex items-center mt-4">
                @if(isset($userGrowth) && $userGrowth != 0)
                    <span class="flex items-center text-sm {{ $userGrowth > 0 ? 'text-green-600' : 'text-red-600' }}">
                        @if($userGrowth > 0)
                            <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
                        @else
                            <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" /></svg>
                        @endif
                        {{ abs($userGrowth) }}%
                    </span>
                @else
                    <span class="flex items-center text-sm text-secondary-500">—</span>
                @endif
                <span class="text-xs text-secondary-500 ml-2">vs last month</span>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-lg p-6 group transform hover:-translate-y-1 transition-all duration-300">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-medium text-secondary-500">Total Vacancies</p>
                    <p class="text-3xl font-bold text-secondary-800 mt-1">{{ $totalVacancies }}</p>
                </div>
                <div class="p-3 rounded-lg bg-blue-100 text-blue-600">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                </div>
            </div>
            <p class="text-sm text-secondary-600 mt-4"><span class="font-bold text-secondary-800">{{ $activeVacancies }}</span> active</p>
        </div>
        
        <div class="bg-white rounded-xl shadow-lg p-6 group transform hover:-translate-y-1 transition-all duration-300">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-medium text-secondary-500">Total Applications</p>
                    <p class="text-3xl font-bold text-secondary-800 mt-1">{{ $totalApplications }}</p>
                </div>
                <div class="p-3 rounded-lg bg-purple-100 text-purple-600">
                   <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                </div>
            </div>
            <p class="text-sm text-secondary-600 mt-4"><span class="font-bold text-secondary-800">{{ $applicationsLast7Days }}</span> in last 7 days</p>
        </div>
        
        <div class="bg-white rounded-xl shadow-lg p-6 group transform hover:-translate-y-1 transition-all duration-300">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-medium text-secondary-500">Active Vacancies</p>
                    <p class="text-3xl font-bold text-secondary-800 mt-1">{{ $activeVacancies }}</p>
                </div>
                <div class="p-3 rounded-lg bg-green-100 text-green-600">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
            </div>
            <p class="text-sm text-secondary-600 mt-4"><span class="font-bold text-secondary-800">{{ $totalVacancies - $activeVacancies }}</span> closed</p>
        </div>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-8">
        <div class="bg-white rounded-xl shadow-lg p-6 lg:col-span-2">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-secondary-800">Recent Applications</h3>
                <a href="{{ route('admin.applications.index') }}" class="text-sm font-medium text-primary-600 hover:text-primary-800 transition-colors">View all</a>
            </div>
            @if(count($recentApplications) > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-secondary-500">
                    <thead class="text-xs text-secondary-700 uppercase bg-secondary-50">
                        <tr>
                            <th scope="col" class="px-6 py-3">Applicant</th>
                            <th scope="col" class="px-6 py-3">Position</th>
                            <th scope="col" class="px-6 py-3">Status</th>
                            <th scope="col" class="px-6 py-3">Date</th>
                            <th scope="col" class="px-6 py-3"><span class="sr-only">View</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentApplications as $application)
                            <tr class="bg-white border-b hover:bg-secondary-50">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-9 w-9 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 font-bold">
                                            {{ strtoupper(substr($application->user->name, 0, 1)) }}
                                        </div>
                                        <div class="ml-3">
                                            <div class="font-medium text-secondary-800">{{ $application->user->name }}</div>
                                            <div class="text-xs text-secondary-500">{{ $application->user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">{{ $application->jobVacancy->title }}</td>
                                <td class="px-6 py-4">
                                     <span class="px-2.5 py-1 rounded-full text-xs font-semibold 
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
                                <td class="px-6 py-4">{{ $application->created_at->format('d M, Y') }}</td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('admin.applications.show', $application) }}" class="font-medium text-primary-600 hover:underline">View</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-16">
                <svg class="mx-auto h-12 w-12 text-secondary-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                <h3 class="mt-2 text-sm font-medium text-secondary-800">No applications yet</h3>
                <p class="mt-1 text-sm text-secondary-500">New applications will appear here.</p>
            </div>
            @endif
        </div>
        
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-semibold text-secondary-800 mb-4">Upcoming Interviews</h3>
            @if(isset($upcomingInterviews) && count($upcomingInterviews) > 0)
            <div class="space-y-4">
                @foreach($upcomingInterviews as $interview)
                <div class="flex items-center space-x-4 p-3 rounded-lg hover:bg-secondary-50 transition-colors">
                    <div class="flex-shrink-0 h-10 w-10 bg-purple-100 rounded-lg flex items-center justify-center text-purple-600">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-secondary-800 truncate">{{ $interview->application->user->name }}</p>
                        <p class="text-sm text-secondary-500 truncate">{{ $interview->application->jobVacancy->title }}</p>
                        <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($interview->scheduled_date)->format('d M Y, H:i') }}</p>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-16">
                <svg class="mx-auto h-12 w-12 text-secondary-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                <h3 class="mt-2 text-sm font-medium text-secondary-800">No upcoming interviews</h3>
                <p class="mt-1 text-sm text-secondary-500">Scheduled interviews will appear here.</p>
            </div>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-8">
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-semibold text-secondary-800 mb-4">Weekly Application Trend</h3>
            <div class="relative h-64">
                <canvas id="weekly-applications-chart"></canvas>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-semibold text-secondary-800 mb-4">User Distribution</h3>
            <div class="relative h-64">
                <canvas id="user-roles-chart"></canvas>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-semibold text-secondary-800 mb-4">Application Status</h3>
            <div class="relative h-64">
                <canvas id="application-status-chart"></canvas>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-lg p-6 lg:col-span-3">
            <h3 class="text-lg font-semibold text-secondary-800 mb-4">Monthly Applications</h3>
            <div class="relative h-80">
                <canvas id="monthly-applications-chart"></canvas>
            </div>
        </div>
    </div>
    
    <div class="mt-8 bg-white rounded-xl shadow-lg p-6">
        <h3 class="text-lg font-semibold text-secondary-800 mb-4">Quick Actions</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <a href="{{ route('admin.users.create') }}" class="flex flex-col items-center justify-center text-center p-4 bg-secondary-50 rounded-xl hover:bg-primary-100 hover:text-primary-800 group transition-all duration-300">
                <div class="p-3 rounded-full bg-primary-100 text-primary-600 group-hover:bg-white mb-2 transition-colors">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" /></svg>
                </div>
                <span class="text-sm font-medium text-secondary-700 group-hover:text-primary-800">Add User</span>
            </a>
            <a href="{{ route('admin.job-vacancies.index') }}" class="flex flex-col items-center justify-center text-center p-4 bg-secondary-50 rounded-xl hover:bg-blue-100 hover:text-blue-800 group transition-all duration-300">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600 group-hover:bg-white mb-2 transition-colors">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                </div>
                <span class="text-sm font-medium text-secondary-700 group-hover:text-blue-800">Manage Jobs</span>
            </a>
            <a href="{{ route('admin.applications.index') }}" class="flex flex-col items-center justify-center text-center p-4 bg-secondary-50 rounded-xl hover:bg-purple-100 hover:text-purple-800 group transition-all duration-300">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600 group-hover:bg-white mb-2 transition-colors">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                </div>
                <span class="text-sm font-medium text-secondary-700 group-hover:text-purple-800">Review Apps</span>
            </a>
            <a href="{{ route('admin.reports.applications') }}" class="flex flex-col items-center justify-center text-center p-4 bg-secondary-50 rounded-xl hover:bg-green-100 hover:text-green-800 group transition-all duration-300">
                <div class="p-3 rounded-full bg-green-100 text-green-600 group-hover:bg-white mb-2 transition-colors">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                </div>
                <span class="text-sm font-medium text-secondary-700 group-hover:text-green-800">View Reports</span>
            </a>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    function ucfirst(str) {
        if (!str) return '';
        return str.charAt(0).toUpperCase() + str.slice(1);
    }

    document.addEventListener('DOMContentLoaded', function () {
        // Skema Warna "Aura UI" untuk Grafik
        const auraColors = {
            roles: {
                'Admin': 'rgba(29, 78, 216, 0.9)',
                'Hrd': 'rgba(37, 99, 235, 0.9)',
                'Applicant': 'rgba(96, 165, 250, 0.9)',
                'default': 'rgba(100, 116, 139, 0.9)'
            },
            statuses: {
                'Applied': 'rgba(100, 116, 139, 0.9)',
                'Screening': 'rgba(59, 130, 246, 0.9)',
                'Interview': 'rgba(139, 92, 246, 0.9)',
                'Test': 'rgba(245, 158, 11, 0.9)',
                'Hired': 'rgba(16, 185, 129, 0.9)',
                'Rejected': 'rgba(239, 68, 68, 0.9)',
                'default': 'rgba(100, 116, 139, 0.9)'
            }
        };

        function renderDoughnutChart(ctx, labels, data, colorMap) {
            const bgColors = labels.map(label => colorMap[label] || colorMap.default);
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{ data: data, backgroundColor: bgColors, borderWidth: 2, borderColor: '#ffffff' }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { position: 'bottom', labels: { padding: 15, boxWidth: 12 } } },
                    cutout: '70%'
                }
            });
        }
        
        function renderBarChart(ctx, labels, data, chartLabel, color) {
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: chartLabel,
                        data: data,
                        backgroundColor: color.bg,
                        borderColor: color.border,
                        borderWidth: 1,
                        borderRadius: 5,
                        barThickness: 'flex',
                        maxBarThickness: 30,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: { y: { beginAtZero: true, ticks: { precision: 0 } } },
                    plugins: { legend: { display: false } }
                }
            });
        }

        // Render User Roles Chart
        const userRolesData = @json($userRoles ?? []);
        const roleChartEl = document.getElementById('user-roles-chart');
        if (roleChartEl && userRolesData.length > 0) {
            const roles = userRolesData.map(item => ucfirst(item.role));
            const counts = userRolesData.map(item => item.count);
            renderDoughnutChart(roleChartEl.getContext('2d'), roles, counts, auraColors.roles);
        }

        // Render Application Status Chart
        const statusData = @json($applicationStatuses ?? []);
        const statusChartEl = document.getElementById('application-status-chart');
        if (statusChartEl && statusData.length > 0) {
            const statuses = statusData.map(item => ucfirst(item.status));
            const counts = statusData.map(item => item.count);
            renderDoughnutChart(statusChartEl.getContext('2d'), statuses, counts, auraColors.statuses);
        }
        
        // Render Weekly Applications Chart
        const weeklyData = @json($weeklyApplicationsData ?? []);
        const weeklyChartEl = document.getElementById('weekly-applications-chart');
        if (weeklyChartEl && weeklyData) {
            const labels = [];
            const dataPoints = [];
            let dateMap = new Map(weeklyData.map(item => [new Date(item.date).toDateString(), item.count]));
            for (let i = 6; i >= 0; i--) {
                let d = new Date();
                d.setDate(d.getDate() - i);
                labels.push(d.toLocaleDateString('en-US', { weekday: 'short' }));
                dataPoints.push(dateMap.get(d.toDateString()) || 0);
            }
            renderBarChart(weeklyChartEl.getContext('2d'), labels, dataPoints, 'Applications', { bg: 'rgba(96, 165, 250, 0.7)', border: 'rgba(96, 165, 250, 1)'});
        }

        // Render Monthly Applications Chart
        const monthlyData = @json($monthlyApplications ?? []);
        const monthlyChartEl = document.getElementById('monthly-applications-chart');
        if (monthlyChartEl && monthlyData.length > 0) {
            const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            const labels = monthlyData.map(item => monthNames[item.month - 1] + ' ' + item.year);
            const data = monthlyData.map(item => item.count);
            renderBarChart(monthlyChartEl.getContext('2d'), labels, data, 'Applications', { bg: 'rgba(59, 130, 246, 0.7)', border: 'rgba(59, 130, 246, 1)'});
        }
    });
</script>
@endpush