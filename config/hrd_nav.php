<?php

return [
    [
        'title' => 'Dashboard',
        'route' => 'hrd.dashboard',
        'active_on' => 'hrd.dashboard',
        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>'
    ],
    [
        'title' => 'Job Vacancies',
        'route' => 'hrd.job-vacancies.index',
        'active_on' => 'hrd.job-vacancies.*',
        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>'
    ],
    [
        'title' => 'Applications',
        'route' => 'hrd.applications.index',
        'active_on' => 'hrd.applications.*',
        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>'
    ],
    [
        'title' => 'Reports',
        'active_on' => 'hrd.reports.*',
        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2a4 4 0 00-4-4H5a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2zm8-10V5a2 2 0 00-2-2H9a2 2 0 00-2 2v2m4 10h2a2 2 0 002-2v-2a2 2 0 00-2-2h-2a2 2 0 00-2 2v2a2 2 0 002 2z" /></svg>',
        'sub_menu' => [
            [
                'title' => 'Applications Report',
                'route' => 'hrd.reports.applications',
                'active_on' => 'hrd.reports.applications',
            ],
            [
                'title' => 'Job Vacancies Report',
                'route' => 'hrd.reports.job-vacancies',
                'active_on' => 'hrd.reports.job-vacancies',
            ],
        ]
    ],
];