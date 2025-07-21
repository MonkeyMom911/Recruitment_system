<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\JobVacancyController as AdminJobVacancyController;
use App\Http\Controllers\Admin\ApplicationController as AdminApplicationController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\HRD\DashboardController as HRDDashboardController;
use App\Http\Controllers\HRD\JobVacancyController as HRDJobVacancyController;
use App\Http\Controllers\HRD\ApplicationController as HRDApplicationController;
use App\Http\Controllers\HRD\SelectionStageController as HRDSelectionStageController;
use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\JobVacancyController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// Guest routes
Route::get('/jobs', [JobVacancyController::class, 'index'])->name('jobs.index');
Route::get('/jobs/{jobVacancy:slug}', [JobVacancyController::class, 'show'])->name('jobs.show');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    // Job application routes
    Route::get('/jobs/{jobVacancy:slug}/apply', [ApplicationController::class, 'create'])->name('applications.create');
    Route::post('/jobs/{jobVacancy:slug}/apply', [ApplicationController::class, 'store'])->name('applications.store');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Notification routes
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::patch('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::patch('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.read.all');

    // Applicant routes
    Route::middleware(['role:applicant'])->prefix('applicant')->name('applicant.')->group(function () {
        Route::get('/dashboard', [ApplicantController::class, 'dashboard'])->name('dashboard');
        Route::get('/applications', [ApplicantController::class, 'applications'])->name('applications');
        Route::get('/applications/{application}', [ApplicantController::class, 'applicationShow'])->name('applications.show');
    });

    // HRD routes
    Route::middleware(['role:hrd'])->prefix('hrd')->name('hrd.')->group(function () {
        Route::get('/dashboard', [HRDDashboardController::class, 'index'])->name('dashboard');

        // Job vacancy management
        Route::resource('job-vacancies', HRDJobVacancyController::class);
        Route::post('/job-vacancies/{jobVacancy}/toggle-status', [HRDJobVacancyController::class, 'toggleStatus'])->name('job-vacancies.toggle-status');

        // Selection stages
        Route::resource('job-vacancies.selection-stages', HRDSelectionStageController::class)->shallow();

        // Applications management
        Route::get('/applications/{application}/documents/{document}', [HRDApplicationController::class, 'showDocument'])->name('applications.documents.show');
        Route::get('/applications', [HRDApplicationController::class, 'index'])->name('applications.index');
        Route::get('/applications/{application}', [HRDApplicationController::class, 'show'])->name('applications.show');
        Route::patch('/applications/{application}/update-status', [HRDApplicationController::class, 'updateStatus'])->name('applications.update-status');
        Route::patch('/application-stages/{applicationStage}/update', [HRDApplicationController::class, 'updateStage'])->name('application-stages.update');
        Route::post('/application-stages/{applicationStage}/schedule', [HRDApplicationController::class, 'scheduleStage'])->name('application-stages.schedule');
        Route::post('/applications/{application}/notes', [HRDApplicationController::class, 'addNote'])->name('applications.notes.add');

        // --- INI BAGIAN YANG DIPERBAIKI ---
        // Report generation routes
        Route::prefix('reports')->name('reports.')->group(function () {
            Route::get('/applications', [HRDDashboardController::class, 'applicationsReport'])->name('applications');
            Route::get('/job-vacancies', [HRDDashboardController::class, 'jobVacanciesReport'])->name('job-vacancies');
            Route::get('/export', [HRDDashboardController::class, 'exportReport'])->name('export');
        });
    });

    // Admin routes
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // User management
        Route::get('users/export', [AdminUserController::class, 'export'])->name('users.export');
        Route::resource('users', AdminUserController::class);
        Route::patch('/users/{user}/toggle-status', [AdminUserController::class, 'toggleStatus'])->name('users.toggle-status');

        // Job vacancy management
        Route::resource('job-vacancies', AdminJobVacancyController::class);

        // Application management
        Route::resource('applications', AdminApplicationController::class)->only(['index', 'show', 'destroy']);
        Route::patch('/applications/{application}/update-status', [AdminApplicationController::class, 'updateStatus'])->name('applications.update-status');

        // Settings
        Route::get('/settings', [AdminSettingController::class, 'index'])->name('settings.index');
        Route::patch('/settings', [AdminSettingController::class, 'update'])->name('settings.update');

        // Reports
        Route::get('/reports/applications', [AdminDashboardController::class, 'applicationsReport'])->name('reports.applications');
        Route::get('/reports/job-vacancies', [AdminDashboardController::class, 'jobVacanciesReport'])->name('reports.job-vacancies');
        Route::get('/reports/export', [AdminDashboardController::class, 'exportReport'])->name('reports.export');

        Route::get('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    });
});

require __DIR__.'/auth.php';
